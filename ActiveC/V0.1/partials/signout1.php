<?php

session_start(); // initialize the session variables
unset( $_SESSION['login_user'] );
session_write_close();
?>