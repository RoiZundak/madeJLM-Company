<?php

session_start(); // initialize the session variables
$variable = $_SESSION['login_user'];
unset( $_SESSION['login_user'], $variable );
session_destroy();
session_write_close();
?>