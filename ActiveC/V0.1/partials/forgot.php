<?php
require_once "../php/db_connect.php";
$databaseConnection =connect_to_db();

$email=$_POST['email'];

$headers = 'From: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
    'Reply-To: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$sql = 'SELECT * FROM company WHERE email ="'.$email.'"';
echo $sql;
foreach($databaseConnection->query($sql) as $row){
    print_r($row);
    $user_name=$row['username'];
}

$message="Hi"  .$username .",<br>".
          "To  reset your password <a href='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/reset'>click here </a><br>".
          "This link has 24 hours limitation. <br>";
    echo $message;
    $sent_mail = mail($email, "Forget Password - ActiveC", $message, $headers);

?>