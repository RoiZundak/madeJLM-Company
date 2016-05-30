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
             window.location='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login';
             //if there is no user connected, skip those lines
             if ( name !== null && name !== 'Not_Valid_User_Name' ) 
             {
                sessionStorage.setItem('username', 'Not_Valid_User_Name');
                setTimeout(function(){alert('You have successfully logout.Redirecting to Login page..');},500);
                //alert('You have successfully logout.Redirecting to Login page..');
             }
     </script>";
?>
