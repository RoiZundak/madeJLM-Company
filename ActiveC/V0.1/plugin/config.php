<?php
/**
 * For Development Purposes
 */
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
        "auto_init" => true
    ),
    "pages" => array(
        "no_login" => array(
            "#/about"
        ),
        "login_page" => "#/login",
        "home_page" => "#/main"
    )
));
