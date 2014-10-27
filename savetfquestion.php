<?php
require_once("backrequire.php");

$encoded = file_get_contents('php://input');

if (isset($encoded) && !empty($encoded))
{
	$decoded = json_decode($encoded);

	$arr = array('message'=>'ffffuuuuuuu');
	$json1 = json_encode($arr);

	$conn=retConn();
	
	AddTFQuestion($conn, getUser($conn, $decoded->author), $decoded->question, $decoded->answer);

}



?>