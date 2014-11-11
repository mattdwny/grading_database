<?php
require_once("curlRequest.php");
$encoded = file_get_contents('php://input');

if(isset($encoded) && !empty($encoded))
{	
	//echo "This should print";
	echo curlRequestM($encoded);
}

?>