<?php
session_save_path("../js");
session_start(); // initialize the session variables


$myfile = fopen("test.txt", "w") or die("Unable to open file!");
$txt = "";
fwrite($myfile, $txt);
fclose($myfile);



$_SESSION['login_user'] = "jhgjnbvvhhjkjhgvcxcvhjkjhgfghjkjhgfghjk";
echo "Done , move on";
?>