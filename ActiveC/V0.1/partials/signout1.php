<?php
session_start();
session_unset($_SESSION['login_user']);
echo'test is '. $_SESSION['login_user'];
$_SESSION = array();
session_destroy();


?>