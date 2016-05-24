<?php
    session_name('complogin');
    session_start();
    //unset($_SESSION['username']);
    session_unset($_SESSION['complogin']);     // unset $_SESSION variable for the run-time
    session_destroy($_SESSION['complogin']);   // destroy session data in storage
    echo("<a id='re_route' href ='#/login'>
        <script>
             document.getElementById(\"re_route\").click();
                        alert('successfully logout.');
         </script>
     </a>");
?>
