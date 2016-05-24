<?php




session_start(); // initialize the session variables
echo'test is '. $_SESSION['login_user'];
session_unset(); // clear the $_SESSION variable

if(isset($_COOKIE[session_name()])) {
    setcookie(session_name(),'',time()-3600); # Unset the session id
}

session_regenerate_id();



echo'test is '. $_SESSION['login_user'];




?>