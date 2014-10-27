<?php
require("curlRequest.php");
$webpage = 'http://web.njit.edu/';
$suffix = '~md369/';

$address = 'back.php';

if( isset ($_POST[0]) && isset ($_POST[1]) )
{
	$user=$_POST[0];
	$pass=$_POST[1];

	$logintype=sql_login($webpage.$suffix.$address, $_POST[0], $_POST[1]);
	
	if($logintype == 'INSTRUCTOR')
	{
		echo "Login Instructor";
	}
	else if ($logintype == 'STUDENT')
	{
		echo "Login Student";
	}
	else
	{
		echo "Login Failed!";
	}
}

function sql_login($url, $user, $pass)
{
	$return=curlReq($url, array($user, $pass));

	if (strpos($return, "INSTRUCTOR") !== false)
	{
		return "INSTRUCTOR";
	}
	else if (strpos($return, "STUDENT") !== false)
	{
		return "STUDENT";
	}
	else
		return "FAILED";

}

?>