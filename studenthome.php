<?php
session_start();
require("killnonstudents.php");

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
		width:488px;
		height:200px;
		float:left;
		border: 2px solid;
		border-radius: 25px;
		background-color: #F8F8F8;
	}
.tempRight
	{
		width:488px;
		height:200px;
		float:right;
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
		<h2><a href="http://web.njit.edu/~md369/taketest.php">Take Test</a></h2>
		</div>
		<div class="tempRight">
		<h2><a href="http://web.njit.edu/~md369/reviewtest.php">Review Test Grade</a></h2>
		</div>
	</div>
</body>
</html>
