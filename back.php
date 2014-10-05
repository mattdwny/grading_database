<?php

if( isset ($_POST[0]) && isset ($_POST[1]) )
{
	//DB connection
	$server="sql.njit.edu";
	$user = "ss2563";
	$pass = "3XLprl2A2";
	$conn = mysql_connect($server,$user,$pass);
	echo "tryingtoconnect";
	if(! $conn )
	{
		die('Could not connect: ' . mysql_error());
	}
	echo "connected";
	mysql_select_db('ss2563') or die("didnt select database");
	$sql = "SELECT cs490users.username FROM cs490users, cs490pass
			WHERE cs490users.uid = cs490pass.uid AND
				  cs490pass.password = \"$_POST[1]\" AND
				  cs490users.username = \"$_POST[0]\"";

				  echo $sql;

	$sql_result = mysql_fetch_assoc(mysql_query( $sql, $conn ));
	echo $sql_result[0];
	if(! $sql_result )
	{
	  die('Could not get data: ' . mysql_error());
	}

	if( strpos($sql_result, $_POST[0]) !== false)
	{	
		echo 'ACCEPTED';
	}
	mysql_close($conn);

}

/*
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $webpage.$suffix.$address);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
 		"user" => $user,
 		"pass" => $pass
)));

curl_close($ch);
*/

?>