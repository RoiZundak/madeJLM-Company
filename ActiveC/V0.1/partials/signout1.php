<?php
session_start();
session_unset();
echo'test is '. $_SESSION['test'];



?>