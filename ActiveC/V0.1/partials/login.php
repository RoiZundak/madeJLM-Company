<?php
//session_start();
echo "
<script>
function() {

    if (localStorage.chkbx && localStorage.chkbx != '') {
        $('#remember_me').attr('checked', 'checked');
        $('#username').val(localStorage.usrname);
        $('#pass').val(localStorage.pass);
    } else {
        $('#remember_me').removeAttr('checked');
        $('#username').val('Example@example.com');
        $('#pass').val('688822292');
    }

    $('#remember_me').click(function() {

        if ($('#remember_me').is(':checked')) {
            // save username and password
            localStorage.usrname = $('#username').val();
            localStorage.pass = $('#pass').val();
            localStorage.chkbx = $('#remember_me').val();
        } else {
            localStorage.usrname = 'Example@example.com';
            localStorage.pass = '688822292';
            localStorage.chkbx = '';
        }
    });
});

</script>";


//DB configuration Constants

require_once "../php/db_connect.php";
$databaseConnection =connect_to_db();

if(!empty($_POST['username'])){
    $errMsg = '';

    //username and password sent from Form
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));
   // echo ("<script> alert('$password');</script>");

    if($username == 'Example@example.com')
        $errMsg .= 'You must enter your Username<br>';

    if($password == '688822292')
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

            //$_SESSION['username'] = $username;
            echo("<a id='re_route_main' href ='../#/main'></a>
                 <script>                  
                    sessionStorage.setItem('username', '".$username."');
                    document.getElementById(\"re_route_main\").click();
                </script>
                ");
            exit;
        }
        else
        {
            $errMsg .= 'Username and Password are not found<br>';
            echo("<a id='re_route_login' href ='../#/login'></a>
                <script>
                    alert('Wrong Password Or User Name.');
                    document.getElementById(\"re_route_login\").click();
                </script>
            ");
            exit;
        }
    }
}
?>
