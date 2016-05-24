<?php
    session_name('complogin');
    session_start();
    //unset($_SESSION['username']);
    //session_unset($_SESSION['complogin']);     // unset $_SESSION variable for the run-time
    $_SESSION['username']='moria';
    //unset($_SESSION['username']);     // unset $_SESSION variable for the run-time
    //session_destroy(); // destroy the Session, not just the data stored!
    //session_unset();// delete the session contents
    echo("<a id='re_route' href ='#/login'>
        <script>
             document.getElementById(\"re_route\").click();
                        alert('successfully logout.');
             console.log('from signout : ".$_SESSION['username']."');
         </script>
     </a>");
?>
