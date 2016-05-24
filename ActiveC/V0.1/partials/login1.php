<?php
session_start();
$_SESSION['test']='davidtheking';
echo("<a id='re_route' href ='../#/contact'>
                    <script>
                        document.getElementById(\"re_route\").click();
                        alert('Mail was sent! thank you.');
                    </script>
                </a>");
?>