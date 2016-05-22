<?php
    session_start();
    unset($_SESSION['username']);
    $name = $_SESSION['username'];
    //session_destroy();
    echo("<a id='re_route' href ='#/login'>
        <script>
             document.getElementById(\"re_route\").click();
                        alert('successfully logout.' + $name);
         </script>
     </a>");
?>
