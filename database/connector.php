<?php
// define('DBHOST', 'localhost');
define('DBHOST', '127.0.0.1');
define('DBUSER', 'root');
define('DBPASS', 'dende');
define('DBNAME', 'hcc');
define('SECRET_KEY', 'v70d4rA8cZhbxpGUDP2BSUClg');
function noDB()
{
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS);
    return $mysqli;
}

function DB()
{
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    return $mysqli;
}