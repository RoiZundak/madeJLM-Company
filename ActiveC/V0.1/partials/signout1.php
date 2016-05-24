<?php
    session_save_path("../js");
    session_start(); // initialize the session variables
    echo session_save_path()."<br>";
    print_r($_SESSION);
    $_SESSION=array();
print_r($_SESSION);
    $_SESSION['login_user'] = "jhgjnbvvhhjkjhgvcxcvhjkjhgfghjkjhgfghjk";
session_destroy();
session_start();
    echo "Done , move on";
?>