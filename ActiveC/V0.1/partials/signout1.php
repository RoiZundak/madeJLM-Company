<?php

session_start(); // initialize the session variables
$_SESSION['login_user']="";
session_destroy();
session_write_close();
?>