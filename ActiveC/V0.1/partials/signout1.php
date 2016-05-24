<?php
    session_save_path("../js");
session_start();
session_unset();
header("Location: login.php");
?>