<?php
session_start();
require("killnoninstructors.php");
require("curlRequest.php");

if(isset($_POST['test']) && !empty($_POST['test']))
{
	$test = json_decode($_POST['test']);
	if(!empty($test->testName) && !empty($test->minutes))
	{
		$test->url = 'createtest';
		$test->id = $_SESSION['id'];
		$test->flag = 'test'; 
		$stuff = curlRequestF(json_encode($test));
	}
}
?>

<html>
<head>
	<script>
		function InitQuestions()
		{
			document.getElementById('test').value = '{"minutes":"","testName":"","MC":[],"TF":[],"FB":[],"OE":[]}';
		}
		
		function NameTest()
		{
			var test = document.getElementById('test').value;
			var obj = JSON.parse(test);
			
			obj.minutes = document.getElementById('minutes').value;
			obj.testName = document.getElementById('testName').value;
			document.getElementById('test').value = JSON.stringify(obj);
		}
	
		function drawQuestions()
		{
			var qt = document.getElementById('qt').value;
			
			document.getElementById('variable').innerHTML = document.getElementById(qt).innerHTML;
		}
		
		function addQuestions()
		{
			var table = document.getElementById('variable').children[0];
			var qt = document.getElementById('qt').value;
			var test = document.getElementById('test').value;
			var obj = JSON.parse(test);
		
			if(qt == 'MC') 
			{
				for(var i = 1; i < table.rows.length; i++)
				{
					if(table.rows[i].cells[0].children[0].checked) addQuestion(obj.MC,table.rows[i].cells[2].innerHTML);
				}
			}
			else if(qt == 'TF')
			{
				for(var i = 1; i < table.rows.length; i++)
				{
					if(table.rows[i].cells[0].children[0].checked) addQuestion(obj.TF,table.rows[i].cells[2].innerHTML);
				}
			}
			else if(qt == 'FB')
			{
				for(var i = 1; i < table.rows.length; i++)
				{
					if(table.rows[i].cells[0].children[0].checked) addQuestion(obj.FB,table.rows[i].cells[2].innerHTML);
				}
			}
			else if(qt == 'OE')
			{
				for(var i = 1; i < table.rows.length; i++)
				{
					if(table.rows[i].cells[0].children[0].checked) addQuestion(obj.OE,table.rows[i].cells[2].innerHTML);
				}
			}
			
			document.getElementById('test').value = JSON.stringify(obj);//document.getElementById('variable').children[0].innerHTML;
		}
		
		function addQuestion(obj,fid)
		{	
			obj.push(fid); //TODO: error multiple additions, also no remove
		}
		
		function lastChecks()
		{
			var test = document.getElementById('test').innerHTML;
			var obj = JSON.parse(test);
			
			obj.testName = document.getElementById('testName').innerHTML;
			obj.user = <?php echo $_SESSION['user']; ?>;
			
			document.getElementById('test').innerHTML = JSON.stringify(obj);
		}
		window.onload = InitQuestions;
	</script>

</head>


<style>
body
	{
		background-color: #C80000 ;
	}

table {
    border-collapse: collapse;
    background-color: white;
}

table, td, th {
    border: 1px solid black;
}

</style>


	<div class="border">
	
		<h2>Create test</h2>
		<body>
		
			<p hidden name="MC" id="MC"> <?php echo formatQuestions('MC'); ?> </p>
			<p hidden name="TF" id="TF"> <?php echo formatQuestions('TF'); ?> </p>
			<p hidden name="FB" id="FB"> <?php echo formatQuestions('FB'); ?> </p>
			<p hidden name="OE" id="OE"> <?php echo formatQuestions('OE'); ?> </p>
			
			<label>Test name :</label>
				<input type="text" id="testName" name="testName"/><br>
			
			<br>
			
			<label>Time Allowed (Minutes): </label>
				<input type="text" id="minutes" name="minutes"/><br>
				
			<br><p id="testInfo" name="testInfo">This is a paragraph</p>
			
			<br><label>Question type: </label>
				<select id="qt" name="qt">
					<option value="MC">Multiple Choice</option>
					<option value="TF">True False</option>
					<option value="FB">Fill in the Blank</option>
					<option value="OE">Open Ended</option>
				</select>
				<input type="button" value="Inspect Questions" onclick="drawQuestions();">
			<br>

			<p id="variable" name="variable">
				<?php echo formatQuestions('MC'); ?> </p>
			</p>
		
			<br>
				<input type="button" value="Add Questions" onclick="addQuestions();NameTest();">
			<br>
			<br>
			
			<form action="" method="POST">
				
				<input type="hidden" name="test" id="test">

				<div class="button">
					<input type="submit" value="Submit test " onclick="NameTest();">
				</div>
				
			</form>
		</body>
	</div>
</html>
<?php

function formatQuestions($type)
{
	//TODO: tagging system for questions, Query using like keyword search of question in SQL & tagging
	$arr = array( 'url' => 'createtest', 'flag' => 'fetch', 'author' => $_SESSION['id'], 'type' => $type);
	
	//return curlRequestF(json_encode($arr));
	$obj = json_decode(curlRequestF(json_encode($arr)));
	
	$formatted = "";
	$i = 0;
	
	$formatted .= '<table><tbody id="search">';
	$formatted .= "<tr name=\"rows\">";
	
	$formatted .= '<td name="cols"><input hidden type="checkbox" name="cbox"></td>'; //TODO points
	$formatted .= "<td name=\"cols\">Question</td>";
	$formatted .= "<td hidden name=\"cols\">ID</td>";
	if($type != 'OE') $formatted .= "<td name=\"cols\">Answer</td>";
	if($type == 'MC') $formatted .= "<td name=\"cols\">A</td>";
	if($type == 'MC') $formatted .= "<td name=\"cols\">B</td>";
	if($type == 'MC') $formatted .= "<td name=\"cols\">C</td>";
	if($type == 'MC') $formatted .= "<td name=\"cols\">D</td>";
	if($type == 'MC') $formatted .= "<td name=\"cols\">E</td></tr>";

	for($i = 0; $i < count($obj); $i++)
	{	
		$temp = get_object_vars($obj[$i]);

		$formatted.="<tr name=\"rows\">";
		
		$formatted .= '<td name="cols"><input type="checkbox" name="cbox"></td>'; //TODO points
		$formatted .= "<td name=\"cols\">".$temp['question']."</td>";
		$formatted .= "<td hidden name=\"cols\">".$temp['fid']."</td>";
		if($type != 'OE') $formatted .= "<td name=\"cols\">".$temp['answer']."</td>";
		if($type == 'MC') $formatted .= "<td name=\"cols\">".$temp['a']."</td>";
		if($type == 'MC') $formatted .= "<td name=\"cols\">".$temp['b']."</td>";
		if($type == 'MC') $formatted .= "<td name=\"cols\">".$temp['c']."</td>";
		if($type == 'MC') $formatted .= "<td name=\"cols\">".$temp['d']."</td>";
		if($type == 'MC') $formatted .= "<td name=\"cols\">".$temp['e']."</td>";
		
		$formatted .= "</tr>";
	}
	$formatted .= "</tbody></table>";
	
	return $formatted;
}

?>