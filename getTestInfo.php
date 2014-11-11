<?php
require_once("curlRequest.php");
$encoded = file_get_contents('php://input');

if (isset($encoded) && !empty($encoded))
{
	$decoded = json_decode($encoded);

	$result = curlReqJxJ("web.njit.edu/~dat25/loadTestInfo.php", $decoded);
	echo json_encode($result); 
}

//curlReqJxJ auto encodes and sends to middle

//encoded at middle, decode and send again

//back now has encoded, decode and create encoded object

//back encodes object and sends it over the network,

//middle now has decoded object due to the nature of curlReqJxJ

//middle must re-encode the object to send it over the network

//middle sends the object which is automatically decoded by front

//front now has a usable object
?>