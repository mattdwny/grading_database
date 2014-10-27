<?php
require_once("backrequire.php");
if( isset ($_POST[0]) && isset ($_POST[1]) )
{
	//DB connection
	$conn=retConn();

	$sql = "SELECT cs490users.username, cs490users.type FROM cs490users, cs490pass
			WHERE cs490users.uid = cs490pass.uid AND
				  cs490pass.password = \"$_POST[1]\" AND
				  cs490users.username = \"$_POST[0]\"";

	$sql_result = mysql_fetch_assoc(mysql_query( $sql, $conn ));
	echo $sql_result['type'];
	if(! $sql_result )
	{
	  die('Could not get data: ' . mysql_error());
	}

	/*if( strpos($sql_result['username'], $_POST[0]) !== false)
	{	
		echo 'ACCEPTED';
	}*/

	if( strpos($sql_result['type'], 'STUDENT') !== false)
	{	
		echo 'STUDENT---';
	}

	if( strpos($sql_result['type'], 'INSTRUCTOR') !== false)
	{	
		echo 'INSTRUCTOR---';
	}
	

	//AddMCQuestion($conn, 2, "whats the answer to life", "C", "11", "12", "42", "13", "-6" );
	//AddTFQuestion($conn, 2, "is dylan gay", "F");
	//AddOEQuestion($conn, 2, "what is your opinion on airline food?");
	//AddFBQuestion($conn, 2, "is dylan gay", "no");
	mysql_close($conn);

}



?>