<?php
session_start();
echo'test is '. $_SESSION['login_user']."<br>";
session_unset();
echo'test is '. $_SESSION['login_user']."<br>";
session_destroy();
echo'test is '. $_SESSION['login_user']."<br>";

?>