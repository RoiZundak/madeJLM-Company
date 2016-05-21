<?php
/**
 * User: David
 * Date: 21/05/2016
 * Time: 18:58
 */
session_start();
echo "before we were :".$_SESSION['username'];
$_SESSION['username']="";
echo "Now we are :".$_SESSION['username'];
exit;?>

