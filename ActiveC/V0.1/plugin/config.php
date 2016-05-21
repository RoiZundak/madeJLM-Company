<?php
/**
 * For Development Purposes
 */
/*session_start();*/
ini_set("display_errors", "on");

require __DIR__ . "/logsys.php";
\Fr\LS::config(array(
    "db" => array(
        "host" => "localhost",
        "port" => 3306,
        "username" => "jobmadeinjlm",
        "password" => "q1w2e3r4",
        "name" => "jobmadei_db",
        "table" => "Company"
    ),
    "features" => array(
        "auto_init" => true,
        "start_session" => false
    ),
    "pages" => array(
        "no_login" => array(
            "#/about",
            "http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login",
            "#/login"
        ),
        "login_page" => "#/login",
        "home_page" => "#/main"
    )
));
