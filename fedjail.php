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
$q =
        mysql_query(
                "SELECT f.*,u.username,u2.username as jailer FROM fedjail f LEFT JOIN users u ON f.fed_userid=u.userid LEFT JOIN users u2 ON f.fed_jailedby=u2.userid ORDER BY f.fed_days ASC",
                $c);
print
        "<b>Federal Jail</b><br />
If you ever cheat the game your name will become a permanent part of this list...<br />
<table border=1><tr style='background:gray'><th>Who</th><th>Days</th><th>Reason</th><th>Jailer</th></tr>";
while ($r = mysql_fetch_array($q))
{
    print
            "<tr><td><a href='viewuser.php?u={$r['fed_userid']}'>{$r['username']}</a></td>
<td>{$r['fed_days']} </td><td> {$r['fed_reason']}</td><td><a href='viewuser.php?u={$r['fed_jailedby']}'>{$r['jailer']}</a></td></tr>";
}
print "</table>";
$q =
        mysql_query(
                "SELECT * FROM users WHERE mailban>0 ORDER BY mailban ASC",
                $c);
print
        "<b>Mail Bann</b></center><br />
If you ever swear or do bad things at your mail, your name will become a permanent part of this list...<br />
<table width=100% border=1><tr style='background:gray'><th>Who</th><th>Days</th><th>Reason</th></tr>";
while ($r = mysql_fetch_array($q))
{
    print
            "<tr><td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a></td>
<td>{$r['mailban']} </td><td> {$r['mb_reason']}</td><td></td></tr>";
}
print "</table>";
$h->endpage();
