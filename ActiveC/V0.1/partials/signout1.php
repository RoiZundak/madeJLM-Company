<?php
    session_save_path("../js");
    session_start(); // initialize the session variables
    $_SESSION=array();
    session_unset();
    session_destroy();
    echo "Done , move on";
?>