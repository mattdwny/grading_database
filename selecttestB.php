<?php
require_once("backrequire.php");
$encoded = file_get_contents('php://input');

if (isset($encoded) && !empty($encoded))
{
	echo SelectTests(json_decode($encoded));
}

?>