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
print
        "<h3>Hospital</h3>
<table width='75%' border='2'><tr bgcolor=gray><th>ID</th><th>Name</th <th>Level</th> <th>Time</th><th>Reason</th></tr>";
$q =
        mysql_query(
                "SELECT u.*,c.* FROM users u WHERE u.hospital > 0 ORDER BY u.hospital DESC",
                $c);
while ($r = mysql_fetch_array($q))
{
    print
            "\n<tr><td>{$r['userid']}</td><td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> [{$r['userid']}]</td><td>
            {$r['level']}</td><td>{$r['hospital']} minutes</td><td>{$r['hospreason']}</td></tr>";
}
print "</table>";
$h->endpage();
