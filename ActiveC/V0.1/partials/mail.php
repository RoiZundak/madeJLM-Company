
<?php
//contact_email
    if(isset($_POST)){
        $to      = 'Activec.madejlm@gmail.com';
        $subject = 'Contact mail from company';
        $message = $_POST['contact_message']."<br>"."Name: ".$_POST['contact_name']."<br>phone number: ".$_POST['contact_phone'];
        $headers = 'From: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
            'Reply-To: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $sent_mail = mail($to, $subject, $message, $headers);
        if ( ! $sent_mail){
            echo "<script> alert('lala');</script>";
        }
    }

?>