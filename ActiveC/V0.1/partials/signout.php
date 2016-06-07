<?php
    echo
    "<script>
             window.location='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login';
             var name = sessionStorage.getItem('username');
             //if there is no user connected, skip those lines
             if ( name !== null && name !== 'Not_Valid_User_Name' ) 
             {
                sessionStorage.setItem('username', 'Not_Valid_User_Name');
                setTimeout(function(){alert('You have successfully logout.Redirecting to Login page..');},100);
             }
     </script>";
?>

