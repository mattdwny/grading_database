<?php
require_once("backrequire.php");

$encoded = file_get_contents('php://input');

if (isset($encoded) && !empty($encoded))
{
	$decoded = json_decode($encoded);

	SaveTest($decoded->user, $decoded->testName, $decoded->MC, $decoded->TF, $decoded->FB, $decoded->OE);
}

?>