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
if ($_POST['report'])
{
    $_POST['player'] = abs((int) $_POST['player']);
    $ins_report =
            mysql_real_escape_string(stripslashes($_POST['report']), $c);
    mysql_query(
            "INSERT INTO preports VALUES(NULL,$userid,{$_POST['player']},'{$ins_report}')",
            $c)
            or die(
                    "Your report could not be processed, make sure you have filled out the form entirely.");
    print "Report processed!";
}
else
{
    print
            "<h3>Player Report</h3>
Know of a player that's breaking the rules? Don't hesitate to report them. Reports are kept confidential.<br />
<form action='preport.php' method='post'>
Player's ID: <input type='text' name='player' value='{$_GET['ID']}' /><br />
What they've done: <br />
<textarea rows='7' cols='40' name='report'>{$_GET['report']}</textarea><br />
<input type='submit' value='Send Report' /></form>";
}
$h->endpage();
