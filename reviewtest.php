<?php
session_start();
if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'STUDENT')
{
	echo $_SESSION['user'];
}
?>

<html>
<style>
body
	{
		background-color: #C80000 ;
	}
</style>
</html>