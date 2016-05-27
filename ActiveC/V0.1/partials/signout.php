<?php
    session_start();
    if(!empty($_SESSION['username'])){
         $_SESSION=array();;
        /*session_destroy();*/
        echo("<a id='re_route' href ='#/login'>
        <script>
             alert('successfully logout');
         </script>
          <a id='re_route' href ='./#/login\'>
            Go Back
         </a>
     </a>");
    }
 ?>
