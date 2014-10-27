<?php

session_start();
require("curlRequest.php");
$webpage = 'http://web.njit.edu/';
$suffix = '~md369/';
$address = 'middle.php';

if(isset ($_POST['username']) && isset ($_POST['password']))
{
	$userBool = !empty($_POST['username']);
	$passBool = !empty($_POST['password']);

	if($userBool && $passBool)
	{
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$return=curlReq($webpage.$suffix.$address, array($user, $pass));
		if ($return == 'Login Instructor')
		{
			$_SESSION['user'] = $user;
			$_SESSION['usertype'] = 'INSTRUCTOR';
			header("Location: http://web.njit.edu/~md369/instructorhome.php");
		}
		else if ($return == 'Login Student')
		{
			$_SESSION['user'] = $user;
			$_SESSION['usertype'] = 'STUDENT';
			header("Location: http://web.njit.edu/~md369/studenthome.php");
		}
		echo $return;
	}
}
?>

<html>
<head>
	<script type="text/javascript">
	function isValid() 
	{
		var password = document.getElementById('password').value;
		var username = document.getElementById('username').value;
		if (password == "")
		{
		alert('You need to enter a password')
		}
		if (username == "")
		{
		alert('You need to enter a username')
		}
		
		<?php ?>
	}
	</script>
</head>

<style>
	body 
	{
    	background-color: #C80000 ;
	}
	label
	{
		font-weight: bold;
		width: 150px;
		float: left;
		text-align: center
	}
	h1 
	{
		color: black;
		margin-left: 20px;
		text-align: center;
		font-family: "Times New Roman", Times, serif;
	}
	.border 
	{
		border: 2px solid;
		border-radius: 25px;
		background-color: #F8F8F8;
		width: 500px; 
		margin: 200px auto;
	}
	.button 
	{
		padding : 15px 30px 14px 30px;
		margin  : 5px auto;
		display : block;
		width   : 100px;
	}
</style>
	<div class="border">
		<h1>CS 490 Online Testing System</h1>
			<form action="" method="POST">
				<label>Username :</label>
					<input type="text" id="username" name="username"/><br>
				<br><label>Password :</label>
					<input type="password" id="password" name="password"/><br/>
				<div class="button">
					<input type="submit" value=" Log In " onclick="isValid();">
				</div>
			</form>
	</div>
</html>