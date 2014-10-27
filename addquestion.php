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
</style>
<body>
	<div class="container">
		<div class="tempLeft">
		<h2><a href="http://web.njit.edu/~md369/addmcquestion.php">Add Multiple Choice Questions</a></h2>
		</div>
		<div class="tempTop">
		<h2><a href="http://web.njit.edu/~md369/addtfquestion.php">Add True-False Questions</a></h2>
		</div>
		<div class="tempRight">
		<h2><a href="http://web.njit.edu/~md369/addfbquestion.php">Add Fill in the Blanks Choice Questions</a></h2>
		</div>
		<div class="tempBottom">
		<h2><a href="http://web.njit.edu/~md369/addoequestion.php">Add Open Ended Questions</a></h2>
		</div>
	</div>
</body>

</html>