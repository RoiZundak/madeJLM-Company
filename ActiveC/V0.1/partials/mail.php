
<?php
    if(isset($_POST)){
        $to      = 'ohayon109@gmail.com';
        $subject = 'the subject';
        $message = 'hello';
        $headers = 'From: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
            'Reply-To: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $sent_mail = mail($to, $subject, $message, $headers);
        if ( ! $sent_mail){
            echo "<script> alert('lala');</script>";
        }
    }

?>