<?php
session_start();
$_SESSION['login_user']='davidtheking';
echo("<a id='re_route' href ='../#/contact'>
                    <script>
                        document.getElementById(\"re_route\").click();
                    </script>
                </a>");
?>