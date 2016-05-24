<?php
    session_save_path("../js");
    session_start();
    $_SESSION['login_user']="";
    header("Location: login.html");
?>