<?php
    session_start();
    $name = $_SESSION['username'];
    unset($_SESSION['username']);
    session_destroy();
    $name2= $_SESSION['username'];
    echo("<a id='re_route' href ='#/login'>
        <script>
             document.getElementById(\"re_route\").click();
                        alert('successfully logout.' +'nameBefore:--'$name+'--nameAfter:--'+$name2 +'--');
         </script>
     </a>");
?>
