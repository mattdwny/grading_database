<?php
session_start();
require("killnoninstructors.php");
require("curlRequest.php");

/*if(isset($_POST['test']) && !empty($_POST['test']))
{
	curlRequestJxJ("web.njit.edu/~dat25/verifytest.php", $_POST['test']);
}*/
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="table.css">
	<script type="text/javascript">

		function drawQuestions()
		{
			var qt = document.getElementById('qt').value;
			
			document.getElementById('variable').innerHTML = document.getElementById(qt).innerHTML;
		}
		
		function addQuestions()
		{
			var table = document.getElementById('variable').children[0];
			var qt = document.getElementById('qt').value;
			var test = document.getElementById('test').innerHTML;
			var obj = JSON.parse(test);
			document.getElementById('output_test').innerHTML = document.getElementById('test').innerHTML;
			
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
			
			document.getElementById('test').innerHTML = JSON.stringify(obj);//document.getElementById('variable').children[0].innerHTML;
			document.getElementById('output_test').innerHTML = JSON.stringify(obj);
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
			
			<form action="" method="POST">
				
				<p hidden name="test" id="test">{"user":"nicholson","testName":"none","MC":[],"TF":[],"FB":[],"OE":[]}</p>
				<label>Test name :</label>
					<input type="text" id="testName" name="testName"/><br>
					
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
			
				<p id="output_test" name="output_test">
				</p>
			
				<br>
					<input type="button" value="Add Questions" onclick="addQuestions();">
				<br>
				<br>
				<div class="button">
					<input type="submit" value="Submit test " onclick="lastChecks();">
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
	
	$obj = json_decode(curlRequestF(json_encode($arr)));
	
	$formatted = "";
	$i = 0;
	
	$formatted .= '<table><tbody id="search">';
	$formatted .= "<tr name=\"rows\">";
	
	$formatted .= '<td name="cols"><input hidden type="checkbox" name="cbox"></td>';
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
		
		$formatted .= '<td name="cols"><input type="checkbox" name="cbox"></td>';
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