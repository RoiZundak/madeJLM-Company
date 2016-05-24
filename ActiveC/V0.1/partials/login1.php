<?php
session_start();


define('_HOST_NAME_', 'localhost');
define('_USER_NAME_', 'jobmadeinjlm');
define('_DB_PASSWORD', 'q1w2e3r4');
define('_DATABASE_NAME_', 'jobmadei_db');
//PDO Database Connection
try {
    $databaseConnection = new PDO('mysql:host='._HOST_NAME_.';dbname='._DATABASE_NAME_, _USER_NAME_, _DB_PASSWORD);
    $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}






$_SESSION['login_user'] = 'test2';

echo("<a id='re_route' href ='../#/conact'>
                    <script>
                        document.getElementById(\"re_route\").click();
                    </script>
                </a>");
?>