<?php
session_start();
session_unset();
echo'test is '. $_SESSION['login_user'];
session_destroy();


?>