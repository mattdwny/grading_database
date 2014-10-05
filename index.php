<?php
require("curlRequest.php");
$webpage = 'http://web.njit.edu/';
$suffix = '~ss2563/';
$address = 'middle.php';

if(isset ($_POST['username']) && isset ($_POST['password']) &&
	!empty($_POST['username']) && !empty($_POST['password']))
{
	$user = $_POST['username'];
	$pass = $_POST['password'];
	$return=curlReq($webpage.$suffix.$address, array($user, $pass));

	echo $return;
}


?>

<form action="" method="POST">
<label>UserName :</label>
<input type="text" name="username"/><br />
<label>Password :</label>
<input type="password" name="password"/><br/>
<input type="submit" value=" Submit "/><br />
</form>