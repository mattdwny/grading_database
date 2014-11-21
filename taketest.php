<?php
session_start();
require("killnonstudent.php");
require("curlRequest.php");

if(isset($_POST['test']) && !empty($_POST['test']))
{
	$test = json_decode($_POST['test']);
	if(!empty($test->testName))
	{
		echo $_POST['test'];

		$test->url = 'createtest';
		$test->id = $_SESSION['id'];
		$test->flag = 'test'; 
		$stuff = curlRequestF(json_encode($test));
		echo $stuff;
	}
}
?>

<html>
<head>
	<script type="text/javascript">

		function InitQuestions()
		{
			document.getElementById('test').value = '{"tid":"","MC":[],"TF":[],"FB":[],"OE":[]}';
			//'{"testName":"","MC":["question":{"qid":"10","answer":""}],"TF":[],"FB":[],"OE":[]}';
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

table
{
    border-collapse: collapse;
    background-color: white;
}

table, td, th
{
    border: 1px solid black;
}

</style>
	<div class="border">
		<h2>Create test</h2>
		<body>
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

function GetQuestions($type)
{
	//TODO: tagging system for questions, Query using like keyword search of question in SQL & tagging
	$arr = array( 'url' => 'taketest', 'flag' => 'get', 'author' => $_SESSION['id'], 'type' => $type);
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

function formatQuestionsOE()
{
/*
	$arr = array( 'url' => 'createtest', 'flag' => 'get', 'author' => $_SESSION['id'], 'type' => $type);
	
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
	
	return $formatted;*/
}


?>