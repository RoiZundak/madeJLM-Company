<?php
/**
 * User: David
 * Date: 21/05/2016
 * Time: 18:58
 */
session_start();
unset($_SESSION['username']);

header("location: ../#/login");
exit;

?>

