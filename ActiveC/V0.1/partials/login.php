<!--****************************************************************************
********************************************************************************
************************************************************************
***********************Login Page-PHP*******************************************
********************************************************************************
********************************************************************************
*****************************************************************************-->

<?php
require_once "../php/db_connect.php";
$databaseConnection =connect_to_db();

if(!empty($_POST['username'])) {
    $errMsg = '';
    //username and password sent from Form
    $username = strtolower(trim($_POST['username']));
    //$email=trim($_POST['username']);
    $password = trim($_POST['password']);
    $password = md5(trim($_POST['password']));

    if($errMsg == '')
    {
        $name_or_mail="SELECT * FROM  company WHERE username = :username OR email=:username";
        $records = $databaseConnection->prepare($name_or_mail);
        $records->bindParam(':username', $username);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        if(count($results) > 0 && $results['block'] != null)
        {
            $d=strtotime("-5 Minutes -4 hours"); // time deffrence betweem time and date
            $newTime =  date("Y-m-d h:i:sa", $d);

            $currentDateTime = $results['block'];
            $newDateTime = date('Y-m-d h:i:sa', strtotime($currentDateTime));

            if($newTime < $newDateTime)
            {
                $errMsg .= 'Time block<br>';
                echo("
                    <script>
                        window.location='../#/login';
                        alert('Sorry. Your user is blocked. Please try again in 5 minutes.');
                    </script>
                     ");
                exit;

            }
            else
            {
                $sql_update = "UPDATE company SET block = null WHERE username = '".$username."' OR email='".$username."'";
                $update = $databaseConnection ->prepare($sql_update);
                $update->execute();
            }
        }

        if(count($results) > 0 && $password === $results['password'] )
        {
            if($results['attempt'] > 0) {
                $sql_update = "UPDATE company SET attempt = 0 WHERE username = '".$username."' OR email='".$username."'";
                $update = $databaseConnection ->prepare($sql_update);
                $update->execute();
            }

            //update company counter enters
            $sql_update="UPDATE company SET counter_enters = counter_enters + 1 WHERE username = '".$username."' OR email='".$username."'";
            $update = $databaseConnection ->prepare($sql_update);
            $update->execute();
            echo("
                     <script>                  
                        sessionStorage.setItem('username', '".$username."');
                        window.location='../#/main';
                    </script>
                    ");
            exit;
        }

        else if(count($results) > 0 && $password !== $results['password'])
        {
            $errMsg .= 'Incorrect Password <br>';
            $sql_update="UPDATE company SET attempt = attempt + 1 WHERE username = '".$username."' OR email='".$username."'";
            $update = $databaseConnection ->prepare($sql_update);
            $update->execute();

            if( intval( $results['attempt'] )>= 5)
            {
                $sql_update="UPDATE company SET attempt = 0 WHERE username = '".$username."' OR email='".$username."'";
                $update = $databaseConnection ->prepare($sql_update);
                $update->execute();


                $sql_update="UPDATE company SET block = NOW() WHERE username = '".$username."' OR email='".$username."'";
                $update = $databaseConnection ->prepare($sql_update);
                $update->execute();

                echo " <script>
                        localStorage.username = '';
                        localStorage.password = '';
                        localStorage.chkbx = '';                             
                        window.location='#/login';
                        alert('You have tried too much. please try again in 5 minutes.');
                        
                    </script>";
                exit;
            }
            /****
             * localStorage.username = '';
            localStorage.password = '';
            localStorage.chkbx = '';
             */
            echo(" 
                    <script>
                        
                        window.location='#/login';
                        setTimeout(function(){alert('You Must login first');},100);
                    </script>
                ");
            exit;

        }
        else
        {
            $errMsg .= 'Username is not found<br>';

            echo("
                    <script>
                        localStorage.username = '';
                        localStorage.password = '';
                        localStorage.chkbx = '';
                        window.location='#/login';
                        setTimeout(function(){alert('You Must login first');},100);
                    </script>
                ");
            exit;
        }
    }
}
?>
