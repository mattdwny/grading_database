<?php
require_once("curlRequest.php");
$encoded = file_get_contents('php://input');

if (isset($encoded) && !empty($encoded))
{
	$decoded = json_decode($encoded);

	$result = curlReqJxJ("web.njit.edu/~dat25/savetest.php", $decoded);
}
?>