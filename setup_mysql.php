<?php
session_start();
require "global_func.php";
include "mysql.php";
$is = mysql_query("SELECT * FROM users", $c) or die(set_mysql());

function set_mysql() {
    //Only executed if table does not exist
    $c = mysql_connect($db_hostname, $db_username, $db_password);
    mysql_select_db($db_database, $c);
    $e_db_hostname = addslashes($db_hostname);
    $e_db_username = addslashes($db_username);
    $e_db_password = addslashes($db_password);
    $e_db_database = addslashes($db_database);
    
    $fo = fopen("dbdata.sql", "r");
    $query = '';
    $lines = explode("\n", fread($fo, 1024768));
    fclose($fo);
    foreach ($lines as $line)
    {
        if (!(strpos($line, "--") === 0) && trim($line) != '')
        {
            $query .= $line;
            if (!(strpos($line, ";") === FALSE))
            {
                mysql_query($query);
                $query = '';
            }
        }
    }

}