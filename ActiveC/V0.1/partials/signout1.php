<?php

session_start(); // initialize the session variables
$_SESSION['login_user']="3";
session_unset();
$_SESSION['login_user']="1";
session_destroy();
echo "Done , move on";
?>