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
$mpq = mysql_query("SELECT * FROM houses WHERE hWILL={$ir['maxwill']}", $c);
$mp = mysql_fetch_array($mpq);
$_GET['property'] = abs((int) $_GET['property']);
if ($_GET['property'])
{
    $npq =
            mysql_query("SELECT * FROM houses WHERE hID={$_GET['property']}",
                    $c);
    $np = mysql_fetch_array($npq);
    if ($np['hWILL'] < $mp['hWILL'])
    {
        print "You cannot go backwards in houses!";
    }
    else if ($np['hPRICE'] > $ir['money'])
    {
        print "You do not have enough money to buy the {$np['hrNAME']}.";
    }
    else
    {
        mysql_query(
                "UPDATE users SET money=money-{$np['hPRICE']},will=0,maxwill={$np['hWILL']} WHERE userid=$userid",
                $c);
        print "Congrats, you bought the {$np['hNAME']} for \${$np['hPRICE']}!";
    }
}
else if (isset($_GET['sellhouse']))
{
    $npq =
            mysql_query("SELECT * FROM houses WHERE hWILL={$ir['maxwill']}",
                    $c);
    $np = mysql_fetch_array($npq);
    if ($ir['maxwill'] == 100)
    {
        print "You already live in the lowest property!";
    }
    else
    {
        mysql_query(
                "UPDATE users SET money=money+{$np['hPRICE']},will=0,maxwill=100 WHERE userid=$userid",
                $c);
        print "You sold your {$np['hNAME']} and went back to your shed.";
    }
}
else
{
    print
            "Your current property: <b>{$mp['hNAME']}</b><br />
The houses you can buy are listed below. Click a house to buy it.<br />";
    if ($ir['maxwill'] > 100)
    {
        print "<a href='estate.php?sellhouse'>Sell Your House</a><br />";
    }
    $hq =
            mysql_query(
                    "SELECT * FROM houses WHERE hWILL>{$ir['maxwill']} ORDER BY hWILL ASC",
                    $c);
    while ($r = mysql_fetch_array($hq))
    {
        print
                "<a href='estate.php?property={$r['hID']}'>{$r['hNAME']}</a>&nbsp;&nbsp - Cost: \${$r['hPRICE']}&nbsp;&nbsp - Will Bar: {$r['hWILL']}<br />";
    }
}
$h->endpage();
