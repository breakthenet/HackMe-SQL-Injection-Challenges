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
//search name
if (!$_GET['name'])
{
    print "Invalid use of file";
}
else
{
    $namebit = mysql_real_escape_string(stripslashes($_GET['name']), $c);
    $q =
            mysql_query(
                    "SELECT * FROM users WHERE username LIKE ('%{$namebit}%')",
                    $c);
    print 
            mysql_num_rows($q)
                    . " players found. <br />
<table><tr style='background-color:gray;'><th>User</th><th>Level</th><th>Money</th></tr>";
    while ($r = mysql_fetch_array($q))
    {
        print 
                "<tr><td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a></td><td>{$r['level']}</td><td>\${$r['money']}</td></tr>";
    }
    print "</table>";
}
$h->endpage();
