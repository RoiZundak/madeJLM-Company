<?php

session_start(); // initialize the session variables
setcookie (session_id(), "", time() - 3600);
session_destroy();
session_write_close();

?>