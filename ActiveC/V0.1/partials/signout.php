<?php
    session_start();
    if(!empty($_SESSION['username'])){
         unset($_SESSION['username']);
        session_destroy();
        echo("<a id='re_route' href ='#/login'>
        <script>
             document.getElementById(\"re_route\").click();
                        //alert('successfully logout.--".$loginName."--');
                        alert('successfully logout.');
         </script>
     </a>");
    }
    //$loginName = $_SESSION['username'];

?>
