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
$table = "";
if($_POST['location']==="comp")
    $table = "company";
else
    $table = "admin";

//get email from form.
$email=$_POST['email'];
//build email headers  :
$headers = 'From: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
    'Reply-To: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
if($table === "company"){
    //Get username from 'company' table
    $sql = "SELECT * FROM company WHERE email = :email LIMIT 1";
}else{
    //Get username from 'admin' table
    $sql = "SELECT * FROM admin WHERE Email = :email LIMIT 1";
}
$stmt = $databaseConnection->prepare($sql);
$stmt->bindParam(":email",$email);
$stmt->execute();
$result = $stmt->fetchAll();
$username="";
foreach($result as $row){
    if($table === "company"){
        $username=$row['username'];
    }else{
        $username=$row['first_name'];
    }
}
if($username===""){//no such user!
    if ($table === "company") {
        echo " <script> 
                window.location ='../#/forgot';
                alert('Email: ".$email." was not found, please try again.');
                </script>";
    } else {
        echo " <script> 
                window.location ='../#/forgotAdmin';
                alert('Email: ".$email." was not found, please try again.');
                </script>";
    }
    exit();
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
if($table === "company"){
    //UPDATE THE DB to save the newly created data
    $sql = "UPDATE company SET f_pass='".$randomString."' , f_exp = '".$expire."' WHERE email = :email";
}else{
    //UPDATE THE DB to save the newly created data
    $sql = "UPDATE admin SET f_pass='".$randomString."' , f_exp = '".$expire."' WHERE Email = :email";
}
// Prepare statement
$stmt = $databaseConnection->prepare($sql);
//bind parameters
$stmt->bindParam(":email",$email);
// execute the query
$stmt->execute();
//Build email message :
$message="Hi "  .$username .",<br>".
    "To reset your password <a href='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/partials/reset_password.php?t=".$table."&p=".$randomString."&mail=".$email."&e=".$expire."'>click here </a><br>".
    "This link has 24 hours limitation. <br>".
    "If you don't know why you have received this mail, please ignore it.";
//Send mail.
$sent_mail = mail($email, "Forget Password - ActiveC", $message, $headers);
if($sent_mail) {
    if ($table === "company") {
        echo " <script> 
                window.location='../#/login';
                alert('Email has been sent.');
                </script>";
    } else {
        echo " <script> 
                window.location='../#/loginAdmin';
                alert('Email has been sent.');
                </script>";
    }
}else{
    if ($table === "company") {
        echo " <script> 
                window.location='../#/login';
                alert('Email was not sent.please try again.');
                </script>";
    } else {
        echo " <script> 
                window.location='../#/loginAdmin';
                alert('Email was not sent.please try again.');
                </script>";
    }
}
?>