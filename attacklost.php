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
$h->userdata($ir, $lv, $fm, $cm, 0);
$h->menuarea();

$_GET['ID'] == abs((int) $_GET['ID']);
$_SESSION['attacking'] = 0;
$od = mysql_query("SELECT * FROM users WHERE userid={$_GET['ID']}", $c);
if (mysql_num_rows($od))
{
    $_SESSION['attacklost'] = 0;
    $r = mysql_fetch_array($od);
    print "You lost to {$r['username']}";
    $expgain = abs(($ir['level'] - $r['level']) ^ 3);
    $expgainp = $expgain / $ir['exp_needed'] * 100;
    print " and lost $expgainp% EXP!";
    mysql_query(
            "UPDATE users SET exp=exp-$expgain,hospital=40+(rand()*20),hospreason='Lost to <a href=\'viewuser.php?u={$r['userid']}\'>{$r['username']}</a>' WHERE userid=$userid",
            $c);
    mysql_query("UPDATE users SET exp=0 WHERE exp<0", $c);
    event_add($r['userid'],
            "<a href='viewuser.php?u=$userid'>{$ir['username']}</a> attacked you and lost.",
            $c);
    $atklog = mysql_escape_string($_SESSION['attacklog']);
    mysql_query(
            "INSERT INTO attacklogs VALUES(NULL,$userid,{$_GET['ID']},'lost',"
                    . time() . ",0,'$atklog');", $c);
}
else
{
    print "You lost to Mr. Non-existant! =O";
}
$h->endpage();
