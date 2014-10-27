<?php
if(isset($_SESSION['usertype']) && $_SESSION['usertype'] != 'INSTRUCTOR')
{
	die;
}
?>