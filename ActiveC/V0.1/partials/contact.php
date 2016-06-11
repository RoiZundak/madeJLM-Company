<!****************************************************************************
********************************************************************************
********************************************************************************
***************************Contact Us Page-HTML*********************************
********************************************************************************
********************************************************************************
*****************************************************************************-->
<?php
require_once "../php/db_connect.php";
$databaseConnection =connect_to_db();

$_SESSION['login_user']="Contact";
if(isset($_POST['submit'])) {
    $to      = 'Activec.madejlm@gmail.com';
    $subject = 'Contact mail from company';
    if (!empty($_POST['contact_message'])    && !empty($_POST['contact_name'])   && !empty($_POST['contact_email']) ) {
        $number="";
        if(  !empty($_POST['contact_phone']) ){
            $number.= 
                "<br>Phone Number:".$_POST['contact_phone'];
        }
        $message = $_POST['contact_message'].
            "<br><br>".
            "<br>Name: ".$_POST['contact_name'].
            $number.
            "<br>Email: ".$_POST['contact_email'];
    }
    if(trim($_POST['contact_message']) == '' || trim($_POST['contact_name']) == ''  || trim($_POST['contact_message']) == '')
    {
        echo("<a id='re_route' href ='../#/contact'>
                    <script>
                        document.getElementById(\"re_route\").click();
                        alert('One of the fields contain only spaces.');
                    </script>
                </a>");
        exit;
    }
    $headers = 'From: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
        'Reply-To: jobmadeinjlm@server.thinksmart.co.il' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $sent_mail = mail($to, $subject, $message, $headers);
    $_POST = array();
    if ( ! $sent_mail){
        echo("<a id='re_route' href ='../#/contact'>
                    <script>
                        document.getElementById(\"re_route\").click();
                        alert('Mail was not sent, please try again.');
                    </script>
                </a>");
    }else{
        echo("<a id='re_route' href ='../#/contact'>
                    <script>
                        document.getElementById(\"re_route\").click();
                        alert('Mail was sent! thank you.');
                    </script>
                </a>");
    }

}
?>
<!-- Page Content -->
<div class="container">

    <div class="_row">
        <div class="col-sm-8">
            <h3><img src ="./img/envelope.jpg" width="17px" height="17px"> Let's Get In Touch!</h3>

            <p>We're happy to answer any questions you have or provide you with estimate.
                Just send us a message in the form below with any questions you may have.</p>

            <form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"  >
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="input1">Name</label>
                        <input type="text" name="contact_name" class="form-control" id="input1" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="input2">Email Address</label>
                        <input type="email" name="contact_email" class="form-control" id="input2" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="input3">Phone Number</label>
                        <input type="text" minlength="9" maxlength="10" pattern="([0][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]|[0][5][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])"  name="contact_phone" class="form-control" id="input3">
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-lg-12">
                        <label for="input4">Message</label>
                        <textarea name="contact_message" class="form-control" rows="6" id="input4" required></textarea>
                    </div>
                    <div class="form-group col-lg-12">
                        <input type="hidden" name="save" value="contact">
                        <button type="submit" name ="submit" class="btn btn-primary" >Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-4">
            <h3>ActiveC</h3>
            <p>
                Yefe Nof st.<br>
                Jerusalem, Israel<br>
            </p>

            <p><i class="fa fa-phone"></i> <abbr title="Phone">P</abbr>: (972) 548044784</p>

            <p><i class="fa fa-envelope-o"></i> <abbr title="Email">E</abbr>:  ActiveC.madejlm@Gmail.com</p>


            <p><i class="fa fa-clock-o"></i> <abbr title="Hours">H</abbr>: 24/7</p>
            <ul class="list-unstyled list-inline list-social-icons">
                <li class="tooltip-social facebook-link"><a href="https://www.facebook.com/MadeinJLM/?pnref=lhc&__mref=message_bubble" data-toggle="tooltip"
                                                            data-placement="top" title="Facebook"><i
                            class="fa fa-facebook-square fa-2x"></i></a></li>
                <li class="tooltip-social twitter-link"><a href="https://twitter.com/MadeinJLM" data-toggle="tooltip"
                                                           data-placement="top" title="Twitter"><i
                            class="fa fa-twitter-square fa-2x"></i></a></li>
                <li class="tooltip-social google-plus-link"><a href="https://plus.google.com/+MadeinjlmOrg1" data-toggle="tooltip"
                                                               data-placement="top" title="Google+"><i
                            class="fa fa-google-plus-square fa-2x"></i></a></li>
            </ul>
        </div>

    </div>
    <!-- /.row -->

</div><!-- /.container -->