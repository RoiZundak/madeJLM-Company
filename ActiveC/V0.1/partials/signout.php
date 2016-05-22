<?php
    session_start();
    unset($_SESSION['username']);
    //session_destroy();
    echo("<a id='signout' href ='../#/login'>
        <script>
             document.getElementById(\"signout\").click();
                        alert('successfully logout.');
         </script>
     </a>");
?>
