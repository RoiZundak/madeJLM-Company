<?php

session_start(); // initialize the session variables
session_unset();
session_destroy();
echo "Done , move on";
?>