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

if(isset($_POST['submit'])){
    $errMsg = '';
    //username and password sent from Form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if($username == '')
        $errMsg .= 'You must enter your Username<br>';

    if($password == '')
        $errMsg .= 'You must enter your Password<br>';


    if($errMsg == ''){
        $records = $databaseConnection->prepare('SELECT id,username,password FROM  company WHERE username = :username');
        $records->bindParam(':username', $username);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        if(count($results) > 0 && password_verify($password, $results['password'])){
            $_SESSION['username'] = $results['username'];
            header('location: main.php');
            exit;
        }else{
            $errMsg .= 'Username and Password are not found<br>';
        }
    }
}

?>

<div align="center">
    <div style="width:300px; border: solid 1px #006D9C; " align="left">
        <?php
        if(isset($errMsg)){
            echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.'</div>';
        }
        ?>
        <div style="background-color:#006D9C; color:#FFFFFF; padding:3px;"><b>Login</b></div>
        <div style="margin:30px">
            <form action="#/login.php" method="post">
                <label>Username  :</label><input type="text" name="username" class="box"/><br /><br />
                <label>Password  :</label><input type="password" name="password" class="box" /><br/><br />
                <input type="submit" name='submit' value="Submit" class='submit'/><br />
            </form>
        </div>
    </div>
</div>

