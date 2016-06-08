<?php
    require_once "../php/db_connect.php";
    $databaseConnection =connect_to_db();

    if(!empty($_POST['username']))
    {
        $errMsg = '';

        //username and password sent from Form
        $username = trim($_POST['username']);
        $password = md5(trim($_POST['password']));

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

            if(count($results) > 0 && $password === $results['password'] )
            {
                //update company counter enters
                $sql_update="UPDATE company SET counter_enters = counter_enters + 1 WHERE username = '".$username."'";
                if($results['attempt'] > 0) {
                    $sql_update = "UPDATE company SET attempt = 0 WHERE username = '" . $username . "'";
                }
                $update = $databaseConnection ->prepare($sql_update);
                $update->execute();
                echo("<a id='re_route_main' href ='../#/main'></a>
                     <script>                  
                        sessionStorage.setItem('username', '".$username."');
                        document.getElementById(\"re_route_main\").click();
                    </script>
                    ");
                exit;
            }

           // $q = "SELECT attempts, (CASE when block is not NULL and DATE_ADD(LastLogin, INTERVAL ".TIME_PERIOD.
              //  " MINUTE)>NOW() then 1 else 0 end) as Denied FROM ".TBL_ATTEMPTS." WHERE ip = '$value'";


            else if(count($results) > 0 && $password !== $results['password'])
            {
                $errMsg .= 'Incorrect Password<br>';
                $sql_update="UPDATE company SET attempt = attempt + 1 WHERE username = '".$username."'";
                $update = $databaseConnection ->prepare($sql_update);
                $update->execute();
                
                if($results['attempt'] >= 5)
                {
                    $sql_update="UPDATE company SET attempt = 0 WHERE username = '".$username."'";
                    $d=strtotime("+15 minutes");
                    $sql_update="UPDATE company SET block = NOW() WHERE username = '".$username."'";
                }

                echo("<a id='re_route_login' href ='../#/login'></a>
                    <script>
                        alert('Incorrect Password.');
                        localStorage.clear();
                        document.getElementById(\"re_route_login\").click();
                    </script>
                ");
                exit;

            }
            else
            {
                $errMsg .= 'Username is not found<br>';

                echo("<a id='re_route_login' href ='../#/login'></a>
                    <script>
                        alert('Username is not found.');
                        localStorage.clear();
                        document.getElementById(\"re_route_login\").click();
                    </script>
                ");
                exit;
            }
        }
    }
?>
