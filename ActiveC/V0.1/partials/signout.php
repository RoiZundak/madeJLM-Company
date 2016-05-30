<?php

/* session_start();

     unset($_SESSION['username']);

     // Unset all of the session variables.
     $_SESSION = array();

     //kill the session, also delete the session cookie
     if (ini_get("session.use_cookies")) {
         $params = session_get_cookie_params();
         setcookie(session_name(), '', time() - 42000,
             $params["path"], $params["domain"],
             $params["secure"], $params["httponly"]
         );
     }

     // Finally, destroy the session.
     session_destroy();*/
echo
    "<script>
             //if there is no user connected, skip those lines
             if ( name !== null && name !== 'Not_Valid_User_Name' ) 
             {
                sessionStorage.setItem('username', 'Not_Valid_User_Name');
                window.location='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login';
                alert('You have successfully logged.Redirecting to Login page..');
             }
             else
                 window.location='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login';
     </script>";
?>
