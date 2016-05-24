<?php

session_start(); // initialize the session variables
print_r($_SESSION);
$_SESSION['login_user']="";
session_destroy();
print_r($_SESSION);
?>