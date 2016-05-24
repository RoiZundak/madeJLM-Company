<?php
session_start();
if($_SESSION['login_user']=="ActiveC"){
    $_SESSION['login_user']="5";
}

define('_HOST_NAME_', 'localhost');
define('_USER_NAME_', 'jobmadeinjlm');
define('_DB_PASSWORD', 'q1w2e3r4');
define('_DATABASE_NAME_', 'jobmadei_db');
//PDO Database Connection
try {
    $databaseConnection = new PDO('mysql:host='._HOST_NAME_.';dbname='._DATABASE_NAME_, _USER_NAME_, _DB_PASSWORD);
    $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}



$username = trim($_POST['username']);


//$_SESSION['login_user'] = $username;

$records = $databaseConnection->prepare('SELECT id,username,password FROM  company WHERE username = :username');
$records->bindParam(':username', $username);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);
if(count($results > 0 )) {
    $_SESSION['login_user'] = $username;
}
echo("<a id='re_route' href ='../#/main'></a>
                    <script>
                        document.getElementById(\"re_route\").click();
                    </script>
                ");
?>