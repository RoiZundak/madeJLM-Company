<!--****************************************************************************
********************************************************************************
********************************************************************************
***********************Login Page-PHP*******************************************
********************************************************************************
********************************************************************************
*****************************************************************************-->
<?php
require_once "../php/db_connect.php";
$databaseConnection =connect_to_db();

if(!empty($_POST['username']))
{
    $errMsg = '';
    //username and password sent from Form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $password = md5($password);

    if($errMsg == '')
    {
        $name_or_mail="SELECT * FROM  admin WHERE  email=:email LIMIT 1";
        $records = $databaseConnection->prepare($name_or_mail);
        $records->bindParam(':email', $username);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        if(count($results) > 0 && $password === $results['Password'] )
        {
            echo " OK ! redirect you now...
                    <script>
                        sessionStorage.setItem('username_Admin','".$username."');
                        window.location='../#/adminPage';
                    </script>";
            exit;
        } else
        {
            echo " <script>
                        localStorage.username_admin = '';
                        localStorage.password_admin = '';
                        localStorage.chkbx_admin = '';
                         alert('Wrong username or password');
                        window.location='../#/adminPage';
                    </script>";
            exit;
        }
    }
}
?>
