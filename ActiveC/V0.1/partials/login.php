<?php
session_start();
//DB configuration Constants
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
if(!empty($_POST['username'])){
    $errMsg = '';

    //username and password sent from Form
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));
   // echo ("<script> alert('$password');</script>");

    if($username == '')
        $errMsg .= 'You must enter your Username<br>';

    if($password == '')
        $errMsg .= 'You must enter your Password<br>';

    if($errMsg == '')
    {
        $records = $databaseConnection->prepare('SELECT id,username,password FROM  company WHERE username = :username');
        $records->bindParam(':username', $username);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        //if(count($results) > 0 && password_verify($password, $results['password'])){
        /*if(count($results) > 0 && $password === $results['password'] )
        {
            $_SESSION['username'] = $results['username'];
            header('location: ../#/main');
            exit;
        }else{
            $errMsg .= 'Username and Password are not found<br>';
            header('location: ../#/login');
            exit;
        }
*/
        if(count($results) > 0 && $password === $results['password'] )
        {
            $_SESSION['username'] = $results['username'];
            echo("<a id='re_route' href ='#/main'>
                 <script>
             document.getElementById(\"re_route\").click();
                        alert('successfully logout.');
                </script>
            </a>");
            exit;
        }
        else
        {
            $errMsg .= 'Username and Password are not found<br>';
            echo("<a id='re_route' href ='#/login'>
                <script>
             document.getElementById(\"re_route\").click();
                        alert('successfully logout.');
                </script>
            </a>");
            exit;
        }
    }
}
?>
