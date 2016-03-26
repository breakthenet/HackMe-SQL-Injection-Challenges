<?php

session_start();
require "global_func.php";
if ($_SESSION['loggedin'] == 0)
{
    header("Location: login.php");
    exit;
}
$userid = $_SESSION['userid'];
require "header.php";
$h = new headers;
$h->startheaders();
include "mysql.php";
global $c;
$is =
        mysql_query(
                "SELECT u.*,us.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.userid=$userid",
                $c) or die(mysql_error());
$ir = mysql_fetch_array($is);
check_level();
$fm = money_formatter($ir['money']);
$cm = money_formatter($ir['crystals'], '');
$lv = date('F j, Y, g:i a', $ir['laston']);
$h->userdata($ir, $lv, $fm, $cm);
$h->menuarea();
if ($_GET['action'] == "cancel")
{
    print "You have cancelled your donation. Please donate later...";
}
else if ($_GET['action'] == "done")
{
    if (!$_GET['tx'])
    {
        die("Get a life.");
    }
    mysql_query(
            "INSERT INTO dps_process VALUES(NULL,$userid," . time()
                    . ",'{$_GET['type']}');", $c);
    print
            "Your donation has been processed. An admin will check it and you should be credited in about 24-48 hours.";
}
$h->endpage();
