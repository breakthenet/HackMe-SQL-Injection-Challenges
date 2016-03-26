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
$ir['exp_needed'] = ($ir['level'] + 1) * ($ir['level'] + 1) * ($ir['level']
                        + 1);
check_level();
$fm = money_formatter($ir['money']);
$cm = money_formatter($ir['crystals'], '');
$lv = date('F j, Y, g:i a', $ir['laston']);
$h->userdata($ir, $lv, $fm, $cm);
$h->menuarea();
$_GET['delete'] = abs((int) $_GET['delete']);
if ($_GET['delete'])
{
    mysql_query(
            "DELETE FROM events WHERE evID={$_GET['delete']} AND evUSER=$userid",
            $c);
    print "<b>Event Deleted</b><br />";
}
print "<b>Latest 10 events</b><br />";
$q =
        mysql_query(
                "SELECT * FROM events WHERE evUSER=$userid ORDER BY evTIME DESC LIMIT 10;",
                $c);
print
        "<table width=75% border=2> <tr style='background:gray;'> <th>Time</th> <th>Event</th><th>Links</th> </tr>";
while ($r = mysql_fetch_array($q))
{
    print "<tr><td>" . date('F j Y, g:i:s a', $r['evTIME']);
    if (!$r['evREAD'])
    {
        print "<br /><b>New!</b>";
    }
    print
            "</td><td>{$r['evTEXT']}</td><td><a href='events.php?delete={$r['evID']}'>Delete</a></td></tr>";
}
print "</table>";
mysql_query("UPDATE events SET evREAD=1 WHERE evUSER=$userid", $c);
$h->endpage();
