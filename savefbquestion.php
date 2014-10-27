<?php
require_once("backrequire.php");

$encoded = file_get_contents('php://input');

if (isset($encoded) && !empty($encoded))
{
	$decoded = json_decode($encoded);

	$conn=retConn();

	AddFBQuestion($conn, getUser($conn, $decoded->author), $decoded->question, $decoded->answer);
}

?>