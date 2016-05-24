<?php

session_start(); // initialize the session variables
print_r($_SESSION);


$params = session_get_cookie_params();
setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));

session_destroy();
session_write_close();

?>