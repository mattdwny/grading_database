<?php
session_start();
require_once("killnonstudents.php");
require_once("globals.php");
require_once("curlRequest.php");
?>

<html>
	<style>
	body
	{
		background-color: #C80000 ;
	}
	.container
	{
		border: 2px solid;
		border-radius: 25px;
		background-color: #1E1E1E;
		width:1000px;
		height:800px;
		margin: 200px auto;
	}
	.tempLeft
	{
		width:488px;
		height:200px;
		float:left;
		border: 2px solid;
		border-radius: 25px;
		background-color: #F8F8F8;
	}
	.tempRight
	{
		width:488px;
		height:200px;
		float:right;
		border: 2px solid;
		border-radius: 25px;
		background-color: #F8F8F8;
	}
	h2
	{
		color: black;
		margin-left: 20px;
		text-align: center;
		font-family: "Times New Roman", Times, serif;
	}

	</style>
	
	<body>
		<?php echo SelectGrades() ?>
	</body>
</html>

<?php

function SelectGrades()
{
	global $page, $front;

	$info = array( 'url' => 'reviewtest', 'uid' => $_SESSION['id'], 'flag' => 'get_grades' );
	
	$tests = json_decode(curlRequestF(json_encode($info)));
	//$tests = curlRequestF(json_encode($info)); echo $tests; return;
	
	$formatted = "<p>";

	//var_dump($tests);
	for($i = 0; $i < count($tests); $i++)
	{	
		$test = get_object_vars($tests[$i]);
		$grade = $test['grade'];
		if($grade == "") $grade = 0;
		$formatted .= "<h1><a href=\"$page/$front/reviewgrade.php?tid=".$test['tid']."\">";
		$formatted .= $test['testName'].' ('.$grade.'%)</a></h1>';
	}

	$formatted .= "</p>";
	
	return $formatted;
}
?>