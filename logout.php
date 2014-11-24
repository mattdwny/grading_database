<?
session_start();
require_once("globals.php");
session_unset();
session_destroy();

header("location:$page/$front/login.php");
exit();
?>