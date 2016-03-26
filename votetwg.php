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
//$h->startheaders();
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
$q =
        mysql_query(
                "SELECT * FROM votes WHERE userid=$userid AND list='twg'", $c);
if (mysql_num_rows($q))
{
    $h->startheaders();
    $h->userdata($ir, $lv, $fm, $cm);
    $h->menuarea();
    print "You have already voted at TWG today!";
    $h->endpage();
}
else
{
    mysql_query("INSERT INTO votes values ($userid,'twg')", $c);
    mysql_query(
            "UPDATE users SET energy=energy+maxenergy/5 WHERE userid=$userid",
            $c);
    mysql_query("UPDATE users SET energy=maxenergy WHERE energy>maxenergy", $c);
    header("Location:http://www.topwebgames.com/in.asp?id=3341");
    exit;
}
