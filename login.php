<?php
session_start();
require_once("curlRequest.php");
require_once("globals.php");

if(isset ($_POST['username']) && isset ($_POST['password']))
{
	if(!empty($_POST['username']) &&  !empty($_POST['password']))
	{
		$data = array('url' => 'login', 'user' => $_POST['username'], 'pass' => $_POST['password']);
		$encoded = json_encode($data);
		
		$result = curlRequestF($encoded);
		
		if ($result)
		{
			$decoded = json_decode($result);

			$_SESSION['user'] = $_POST['username']; //set the username as it was typed.
			$_SESSION['id'] = $decoded->uid;
			$_SESSION['type'] = $decoded->type;
			
			if	   ($decoded->type == 'INSTRUCTOR') header("Location: $page/$front/instructorhome.$suffix");
			else if($decoded->type == 'STUDENT')	header("Location: $page/$front/studenthome.$suffix");
		}
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

