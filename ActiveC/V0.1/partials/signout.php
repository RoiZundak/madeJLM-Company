<?php
    session_start();
    if(!empty($_SESSION['username'])){

        /*Clear session data*/
        $_SESSION = array();

        /*kill all session cookies*/
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        /*Finaly destroy*/
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
