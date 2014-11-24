<?php
require_once("backrequire.php");
$encoded = file_get_contents('php://input');

if (isset($encoded) && !empty($encoded))
{
	$decoded = json_decode($encoded);
	if($decoded->flag == 'fetch') //fetch questions
	{
		echo FetchTestQuestions($decoded, false);
	}
	else if($decoded->flag == 'correct') //fetch instructor's answers
	{
		echo FetchTestQuestions($decoded, true);
	}
	else if($decoded->flag == 'store') //save questions from user in the database
	{
		echo StoreQuestions($decoded);
	}
	else if($decoded->flag == 'submit') //saving test
	{
		echo "back working...";
		echo SubmitGrade($decoded);
	}
}
?>