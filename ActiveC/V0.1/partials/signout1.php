<?php
session_start();
session_unset($_SESSION['login_user']);
echo'test is '. $_SESSION['login_user'];
session_destroy();

$_SESSION = array();
?>