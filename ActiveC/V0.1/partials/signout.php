<?php
    session_start();
    if(!empty($_SESSION['username'])){
         unset($_SESSION['username']);
        session_destroy();
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
