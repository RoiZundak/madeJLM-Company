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

        if ($username == '' || $password == '')
        {
            $errMsg .= 'empty Fields<br>';
            echo
                " <script>
                    localStorage.clear();
                    window.location='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login';
                    setTimeout(function(){ alert('Username or password required');},5);
                </script>";
            exit;

        }

        if($username == 'Example@example.com')
        {
            $errMsg .= 'You must enter your Username<br>';
            echo
                " <script>
                    localStorage.clear();
                    window.location='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login';
                    setTimeout(function(){ alert('You must enter your Username');},5);
                </script>";
            exit;
        }

        if($password == '688822292')
        {
            $errMsg .= 'You must enter your Password<br>';
            echo
                " <script>
                    localStorage.clear();
                    window.location='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login';
                     setTimeout(function(){ alert('You must enter your Password');},5);
                </script>";
            exit;
        }
        $password = md5(trim($_POST['password']));

        //$student_mail="";
        //$row=$databaseConnection->query($sql);
        $email=trim($_POST['username']);
        if($errMsg == '')
        {
            $name_or_mail="SELECT * FROM  company WHERE username = :username OR Email=:username";
            $records = $databaseConnection->prepare($name_or_mail);
            $records->bindParam(':username', $username);
            //$records->bindParam(':email', $email);
            $records->execute();
            //$results = $records->fetch(PDO::FETCH_ASSOC);
            $results=$records->fetchAll();


             /*
             $student_id_query = "SELECT student_id FROM student_skills WHERE skill_id=:skill AND years=:time";
			$complete_query= $databaseConnection->prepare($student_id_query);
			$complete_query->bindParam(':skill',$skill);
			$complete_query->bindParam(':time',$time);
			$complete_query->execute();
			$id=$complete_query->fetchAll();
             */

            if(count($results) > 0 && $results['block'] != null)
            {
                $d=strtotime("-5 Minutes -4 hours"); // time deffrence betweem time and date 
                $newTime =  date("Y-m-d h:i:sa", $d);

                $currentDateTime = $results['block'];
                $newDateTime = date('Y-m-d h:i:sa', strtotime($currentDateTime));

                if($newTime < $newDateTime)
                {
                    $errMsg .= 'Time block<br>';
                    echo("<a id='re_route_login' href ='../#/login'></a>
                    <script>
                        alert('Sorry. Your user is blocked. you should wait');
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

                if( intval( $results['attempt'] )>= 4)
                {
                    $sql_update="UPDATE company SET attempt = 0 WHERE username = '".$username."'";
                    $update = $databaseConnection ->prepare($sql_update);
                    $update->execute();


                    $sql_update="UPDATE company SET block = NOW() WHERE username = '".$username."'";
                    $update = $databaseConnection ->prepare($sql_update);
                    $update->execute();

                   echo " <script>
                        localStorage.clear();
                        //document.getElementById(\"re_route_login\").click();
                        window.location='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login';
                        setTimeout(function(){ alert('You tried too much. Try again in 5 minuts.');},100);
                    </script>";
                    exit;
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
