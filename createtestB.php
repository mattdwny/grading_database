<?php
require_once("backrequire.php");
$encoded = file_get_contents('php://input');
if (isset($encoded) && !empty($encoded))
{
	$decoded = json_decode($encoded);
	
	if($decoded->flag == 'fetch') //fetch questions
	{
		echo FetchQuestions($decoded, true);
	}
	else if($decoded->flag == 'test') //saving test
	{
		//submitting test for SQL entry
		echo CreateTest($decoded);
	}
}
?>