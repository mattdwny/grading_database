<?php
session_start();
require("killnoninstructors.php");
echo $_SESSION['user'];
?>

<html>
<style>
body
	{
		background-color: #C80000 ;
	}
.container
	{
		border: 2px solid;
		border-radius: 25px;
		background-color: #1E1E1E;
		width:1000px;
		height:800px;
		margin: 200px auto;
	}
	.tempLeft
	{
		width:288px;
		height:200px;
		float:left;
		border: 2px solid;
		border-radius: 25px;
		background-color: #F8F8F8;
	}
.tempRight
	{
		width:288px;
		height:200px;
		float:right;
		border: 2px solid;
		border-radius: 25px;
		background-color: #F8F8F8;
	}
.tempMiddle
	{
		width:288px;
		height:200px;
		float:left;
		margin-left: 60px;
		border: 2px solid;
		border-radius: 25px;
		background-color: #F8F8F8;
	}
h2
	{
		color: black;
		margin-left: 20px;
		text-align: center;
		font-family: "Times New Roman", Times, serif;
	}
</style>
<body>
	<div class="container">
		<div class="tempLeft">
		<h2><a href="http://web.njit.edu/~md369/addquestion.php">Add Question</a></h2>
		</div>
		<div class="tempMiddle">
		<h2><a href="http://web.njit.edu/~md369/createtest.php">Create Test</a></h2>
		</div>
		<div class="tempRight">
		<h2><a href="http://web.njit.edu/~md369/manage.php">Manage Test</a></h2>
		</div>
	</div>
</body>
</html>