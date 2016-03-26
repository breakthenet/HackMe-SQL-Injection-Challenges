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
print "<h3>Users Online</h3>";
$cn = 0;
$q =
        mysql_query(
                "SELECT * FROM users WHERE laston>" . (time() - 900)
                        . " ORDER BY laston DESC", $c);
while ($r = mysql_fetch_array($q))
{
    $la = time() - $r['laston'];
    $unit = "secs";
    if ($la >= 60)
    {
        $la = (int) ($la / 60);
        $unit = "mins";
    }
    if ($la >= 60)
    {
        $la = (int) ($la / 60);
        $unit = "hours";
        if ($la >= 24)
        {
            $la = (int) ($la / 24);
            $unit = "days";
        }
    }
    $cn++;
    print
            "$cn. <a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> ($la $unit)<br />";
}
$h->endpage();
