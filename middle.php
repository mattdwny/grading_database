<?php
require("curlRequest.php");
$webpage = 'http://web.njit.edu/';
$suffix = '~ss2563/';
$address = 'back.php';

if( isset ($_POST[0]) && isset ($_POST[1]) )
{
	$user=$_POST[0];
	$pass=$_POST[1];
	
	if(njit_login($_POST[0], $_POST[1]) == 1)
	{
		echo "GOOD NJIT LOGIN";
	}
	else if(sql_login($webpage.$suffix.$address, $_POST[0], $_POST[1]) == 1)
	{
		echo "SQL DB Connection - Good";
	}
	else
	{
		echo "neither worked :c";
	}

}

function njit_login($user, $pass)
{
	// user=UCID&pass=pass&uuid=0xACA021
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://cp4.njit.edu/cp/home/login");
	curl_setopt($c, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
	 	"user" => $user,
	 	"pass" => $pass,
	 	"uuid" => "0xACA021"
	)));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);

	// Logout to kill any sessions
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://cp4.njit.edu/up/Logout?uP_tparam=frm&frm=");
	curl_exec($ch);
	curl_close($ch);

	// Return validation bool
	return strpos($result, "loginok.html") !== false;
}



function sql_login($url, $user, $pass)
{
	$return=curlReq($url, array($user, $pass));
	// Return validation bool
	return strpos($return, "ACCEPTED") !== false;
	//return $url.$user.$pass.$return;

}

?>