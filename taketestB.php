<?php
require_once("backrequire.php");
$encoded = file_get_contents('php://input');
if (isset($encoded) && !empty($encoded))
{
	$decoded = json_decode($encoded);
	
	if($decoded->flag == 'get') //fetch questions
	{
		echo GetQuestions($decoded);
	}
	else if($decoded->flag == 'submit') //saving test
	{
		//submitting test for SQL entry
		echo SubmitGrade($decoded);
	}
	
	
}
?>