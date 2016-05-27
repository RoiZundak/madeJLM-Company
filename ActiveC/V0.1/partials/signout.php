<?php
    session_start();
    if(!empty($_SESSION['username'])){

        $_SESSION = array();
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );

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
