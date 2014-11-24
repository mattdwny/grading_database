<?php
require_once("backrequire.php");
$encoded = file_get_contents('php://input');
if (isset($encoded) && !empty($encoded))
{
	$decoded = json_decode($encoded);
	
	if($decoded->flag == 'fetch') //fetch questions
	{
		echo FetchTests($decoded);
	}
	else if($decoded->flag == 'close') //saving test
	{
		echo "closing...";
		echo CloseTest($decoded);
	}
}
?>