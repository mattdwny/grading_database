<?php
if(isset($_SESSION['usertype']) && $_SESSION['usertype'] != 'STUDENT')
{
	die;
}
?>