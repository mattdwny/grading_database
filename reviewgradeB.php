<?php
require_once("backrequire.php");
$encoded = file_get_contents('php://input');

if (isset($encoded) && !empty($encoded))
{
	//echo "back working...";
	echo SelectGrade(json_decode($encoded));
}

?>