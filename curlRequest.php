<?php
require_once("globals.php");

function curlRequestF($encoded)
{
	global $page, $mid;

	$decoded = json_decode($encoded);
	
	//echo $encoded;
	//echo "$page/$mid/".$decoded->url.'M.php';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type' => 'text/plain'));
	curl_setopt($ch, CURLOPT_URL, "$page/$mid/".$decoded->url.'M.php');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}

function curlRequestM($encoded)
{
	global $page, $back;

	$decoded = json_decode($encoded);

	//echo $encoded;
	//echo "$page/$back/".$decoded->url.'B.php';
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type' => 'text/plain'));
	curl_setopt($ch, CURLOPT_URL, "$page/$back/".$decoded->url.'B.php');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}
?>