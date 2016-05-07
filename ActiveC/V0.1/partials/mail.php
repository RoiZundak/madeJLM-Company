
<?php
//contact_email
    if(isset($_POST)){
        $to      = $_POST['contact_email'];
        $subject = 'Contact mail from company';
        $message = $_POST['contact_message']."<br>Name: ".$_POST['contact_name']."<br>phone number: ".$_POST['contact_phone'];
        $headers = 'From: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
            'Reply-To: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $sent_mail = mail($to, $subject, $message, $headers);
        if ( ! $sent_mail){
            echo "<script> alert('lala');</script>";
        }
    }

?>