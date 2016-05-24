<?php
session_save_path("../js");
session_start(); // initialize the session variables
echo session_save_path()."<br>";
print_r($_SESSION);
$_SESSION['login_user'] = "jhgjnbvvhhjkjhgvcxcvhjkjhgfghjkjhgfghjk";
echo "Done , move on";
?>