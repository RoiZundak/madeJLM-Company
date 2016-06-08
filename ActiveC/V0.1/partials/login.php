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
            $records = $databaseConnection->prepare('SELECT * FROM  company WHERE username = :username');
            $records->bindParam(':username', $username);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);

            if(count($results) > 0 && $results['block'] != null)
            {
                $d=strtotime("+1 Minutes -4 hours");
                $newTime =  date("Y-m-d h:i:sa", $d);
                
                $currentDateTime = $results['block'];
                $newDateTime = date('Y-m-d  h:i:sa', strtotime($currentDateTime));

                if($newTime < $newDateTime)
                {
                    $errMsg .= 'Time block<br>';

                    echo("<a id='re_route_login' href ='../#/login'></a>
                    <script>
                        alert('Your block time did not over yet.');
                        document.getElementById(\"re_route_login\").click();
                    </script>
                     ");
                    exit;

                }
                else
                {
                    $sql_update = "UPDATE company SET block = null WHERE username = '" . $username . "'";
                    $update = $databaseConnection ->prepare($sql_update);
                    $update->execute();
                }
            }

            if(count($results) > 0 && $password === $results['password'] )
            {
                //update company counter enters
                if($results['attempt'] > 0) {
                    $sql_update = "UPDATE company SET attempt = 0 WHERE username = '" . $username . "'";
                    $update = $databaseConnection ->prepare($sql_update);
                    $update->execute();
                }

                $sql_update="UPDATE company SET counter_enters = counter_enters + 1 WHERE username = '".$username."'";
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

            else if(count($results) > 0 && $password !== $results['password'])
            {
                $errMsg .= 'Incorrect Password<br>';
                $sql_update="UPDATE company SET attempt = attempt + 1 WHERE username = '".$username."'";
                $update = $databaseConnection ->prepare($sql_update);
                $update->execute();

                if( intval( $results['attempt'] )>= 5)
                {
                    echo "<script>
                        alert('You tried too much. Try again in few minuts.');
                    </script>";
                    $sql_update="UPDATE company SET attempt = 0 WHERE username = '".$username."'";
                    $update = $databaseConnection ->prepare($sql_update);
                    $update->execute();

                    $d=strtotime("+15 minutes");

                    $sql_update="UPDATE company SET block = NOW() WHERE username = '".$username."'";
                    $update = $databaseConnection ->prepare($sql_update);
                    $update->execute();
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
