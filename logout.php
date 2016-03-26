<?php

session_start();
$sessid = $_SESSION['userid'];
$atk = $_SESSION['attacking'];

if ($_SESSION['attacking'])
{
    print "You lost all your EXP for running from the fight.<br />";
    require "mysql.php";
    global $c;
    mysql_query("UPDATE users SET exp=0 WHERE userid=$sessid", $c);
    $_SESSION['attacking'] == 0;
    session_unset();
    session_destroy();
    die("<a href='login.php'>Continue login...</a>");
}
session_unset();
session_destroy();
header("Location: login.php");

