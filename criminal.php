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
$q = mysql_query("SELECT * FROM crimegroups ORDER by cgORDER ASC", $c);
print
        "<b>Criminal Centre</b><br />
<table width='75%'><tr><th>Crime</th><th>Cost</th><th>Do</th></tr>";
while ($r = mysql_fetch_array($q))
{
    print
            "<tr style='background-color:gray'><td colspan='3'>{$r['cgNAME']}</td></tr>";
    $q2 =
            mysql_query("SELECT * FROM crimes WHERE crimeGROUP={$r['cgID']}",
                    $c);
    while ($r2 = mysql_fetch_array($q2))
    {
        print
                "<tr><td>{$r2['crimeNAME']}</td><td>{$r2['crimeBRAVE']} Brave</td><td><a href='docrime.php?c={$r2['crimeID']}'>Do</a></td></tr>";
    }
}
$h->endpage();
