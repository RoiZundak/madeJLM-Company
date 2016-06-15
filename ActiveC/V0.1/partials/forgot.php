<!--****************************************************************************
********************************************************************************
********************************************************************************
***********************Forgot Password Page-PHP*********************************
********************************************************************************
********************************************************************************
*****************************************************************************-->
<?php
    //connect to db
    require_once "../php/db_connect.php";
    $databaseConnection =connect_to_db();

    //get email from form.
    $email=$_POST['email'];
    //build email headers  :
    $headers = 'From: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
        'Reply-To: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    //Get username from 'company' table
    $sql = "SELECT * FROM company WHERE email = '$email'";
    $username="";
    foreach($databaseConnection->query($sql) as $row){
        $username=$row['username'];
    }

    if($username===""){//no such user!
        echo "<script>
            window.location='http://job.madeinjlm.org/#/forgot';
                alert('Email: ".$email." was not found, please try again.');
            </script>";

    }
    //Create a random string
    $length = 13;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++)
        $randomString .= $characters[rand(0, $charactersLength - 1)];

    //experation : +24H from when the link was sent.
    $expire=time()+(24*60*60);

    //UPDATE THE DB to save the newly created data
    $sql = "UPDATE company SET f_pass='".$randomString."' , f_exp = '".$expire."' WHERE email = '$email'";
    // Prepare statement
    $stmt = $databaseConnection->prepare($sql);
    // execute the query
    $stmt->execute();

    //Build email message :
    $message="Hi "  .$username .",<br>".
        "To reset your password <a href='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/partials/reset_password.php?p=".$randomString."&mail=".$email."&e=".$expire."'>click here </a><br>".
        "This link has 24 hours limitation. <br>".
        "If you don't know why you have received this mail, please ignore it.";
    //Send mail.
    $sent_mail = mail($email, "Forget Password - ActiveC", $message, $headers);
    if($sent_mail)
        echo " <script> 
                alert('Email has been sent');
                window.location='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login';
                </script>";
    
?>