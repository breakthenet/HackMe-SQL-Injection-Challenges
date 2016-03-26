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
        "<h3>Hall Of Fame</h3>
<table width=75%> <tr> <td><a href='halloffame.php?action=level'>LEVEL</a></td> <td><a href='halloffame.php?action=money'>MONEY</a></td> <td><a href='halloffame.php?action=crystals'>CRYSTALS</a></td> <td><a href='halloffame.php?action=total'>TOTAL STATS</a></td> </tr>
<tr> <td><a href='halloffame.php?action=strength'>STRENGTH</a></td> <td><a href='halloffame.php?action=agility'>AGILITY</a></td> <td><a href='halloffame.php?action=guard'>GUARD</a></td> <td><a href='halloffame.php?action=labour'>LABOUR</a></td> <td><a href='halloffame.php?action=iq'>IQ</a></td> </tr> </table>";
switch ($_GET['action'])
{
case "level":
    hof_level();
    break;
case "money":
    hof_money();
    break;
case "crystals":
    hof_crystals();
    break;
case "total":
    hof_total();
    break;
case "strength":
    hof_strength();
    break;
case "agility":
    hof_agility();
    break;
case "guard":
    hof_guard();
    break;
case "labour":
    hof_labour();
    break;
case "iq":
    hof_iq();
    break;
}

function hof_level()
{
    global $ir, $c, $userid;
    print
            "Showing the 20 users with the highest levels<br />
<table width=75%><tr style='background:gray'> <th>Pos</th> <th>User</th> <th>Level</th> </tr>";
    $q =
            mysql_query(
                    "SELECT u.* FROM users u WHERE u.user_level != 0 ORDER BY level DESC,userid ASC LIMIT 20",
                    $c);
    $p = 0;
    while ($r = mysql_fetch_array($q))
    {
        $p++;
        if ($r['userid'] == $userid)
        {
            $t = "<b>";
            $et = "</b>";
        }
        else
        {
            $t = "";
            $et = "";
        }
        print
                "<tr> <td>$t$p$et</td> <td>$t{$r['username']} [{$r['userid']}]$et</td> <td>$t{$r['level']}$et</td> </tr>";
    }
    print "</table>";
}

function hof_money()
{
    global $ir, $c, $userid;
    print
            "Showing the 20 users with the highest amount of money<br />
<table width=75%><tr style='background:gray'> <th>Pos</th> <th>User</th> <th>Money</th> </tr>";
    $q =
            mysql_query(
                    "SELECT u.* FROM users u WHERE u.user_level != 0 ORDER BY money DESC,userid ASC LIMIT 20",
                    $c);
    $p = 0;
    while ($r = mysql_fetch_array($q))
    {
        $p++;
        if ($r['userid'] == $userid)
        {
            $t = "<b>";
            $et = "</b>";
        }
        else
        {
            $t = "";
            $et = "";
        }
        print
                "<tr> <td>$t$p$et</td> <td>$t{$r['username']} [{$r['userid']}]$et</td> <td>$t\$"
                        . money_formatter($r['money'], '') . "$et</td> </tr>";
    }
    print "</table>";
}

function hof_crystals()
{
    global $ir, $c, $userid;
    print
            "Showing the 20 users with the highest amount of crystals<br />
<table width=75%><tr style='background:gray'> <th>Pos</th> <th>User</th> <th>Crystals</th> </tr>";
    $q =
            mysql_query(
                    "SELECT u.* FROM users u WHERE u.user_level != 0 ORDER BY crystals DESC,userid ASC LIMIT 20",
                    $c);
    $p = 0;
    while ($r = mysql_fetch_array($q))
    {
        $p++;
        if ($r['userid'] == $userid)
        {
            $t = "<b>";
            $et = "</b>";
        }
        else
        {
            $t = "";
            $et = "";
        }
        print
                "<tr> <td>$t$p$et</td> <td>$t{$r['username']} [{$r['userid']}]$et</td> <td>$t"
                        . money_formatter($r['crystals'], '')
                        . "$et</td> </tr>";
    }
    print "</table>";
}

function hof_total()
{
    global $ir, $c, $userid;
    print
            "Showing the 20 users with the highest total stats<br />
<table width=75%><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
    $q =
            mysql_query(
                    "SELECT u.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.user_level != 0 ORDER BY (us.strength+us.agility+us.guard+us.labour+us.IQ) DESC,u.userid ASC LIMIT 20",
                    $c);
    $p = 0;
    while ($r = mysql_fetch_array($q))
    {
        $p++;
        if ($r['userid'] == $ir['userid'])
        {
            $t = "<b>";
            $et = "</b>";
        }
        else
        {
            $t = "";
            $et = "";
        }
        print
                "<tr> <td>$t$p$et</td> <td>$t{$r['username']} [{$r['userid']}]$et</td> </tr>";
    }
    print "</table>";
}

function hof_strength()
{
    global $ir, $c, $userid;
    print
            "Showing the 20 users with the highest strength<br />
<table width=75%><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
    $q =
            mysql_query(
                    "SELECT u.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.user_level != 0 ORDER BY us.strength DESC,u.userid ASC LIMIT 20",
                    $c);
    $p = 0;
    while ($r = mysql_fetch_array($q))
    {
        $p++;
        if ($r['userid'] == $ir['userid'])
        {
            $t = "<b>";
            $et = "</b>";
        }
        else
        {
            $t = "";
            $et = "";
        }
        print
                "<tr> <td>$t$p$et</td> <td>$t{$r['username']} [{$r['userid']}]$et</td> </tr>";
    }
    print "</table>";
}

function hof_agility()
{
    global $ir, $c, $userid;
    print
            "Showing the 20 users with the highest agility<br />
<table width=75%><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
    $q =
            mysql_query(
                    "SELECT u.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.user_level != 0 ORDER BY us.agility DESC,u.userid ASC LIMIT 20",
                    $c);
    $p = 0;
    while ($r = mysql_fetch_array($q))
    {
        $p++;
        if ($r['userid'] == $ir['userid'])
        {
            $t = "<b>";
            $et = "</b>";
        }
        else
        {
            $t = "";
            $et = "";
        }
        print
                "<tr> <td>$t$p$et</td> <td>$t{$r['username']} [{$r['userid']}]$et</td> </tr>";
    }
    print "</table>";
}

function hof_guard()
{
    global $ir, $c, $userid;
    print
            "Showing the 20 users with the highest guard<br />
<table width=75%><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
    $q =
            mysql_query(
                    "SELECT u.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.user_level != 0 ORDER BY us.guard DESC,u.userid ASC LIMIT 20",
                    $c);
    $p = 0;
    while ($r = mysql_fetch_array($q))
    {
        $p++;
        if ($r['userid'] == $ir['userid'])
        {
            $t = "<b>";
            $et = "</b>";
        }
        else
        {
            $t = "";
            $et = "";
        }
        print
                "<tr> <td>$t$p$et</td> <td>$t{$r['username']} [{$r['userid']}]$et</td> </tr>";
    }
    print "</table>";
}

function hof_labour()
{
    global $ir, $c, $userid;
    print
            "Showing the 20 users with the highest labour<br />
<table width=75%><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
    $q =
            mysql_query(
                    "SELECT u.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.user_level != 0 ORDER BY us.labour DESC,u.userid ASC LIMIT 20",
                    $c);
    $p = 0;
    while ($r = mysql_fetch_array($q))
    {
        $p++;
        if ($r['userid'] == $ir['userid'])
        {
            $t = "<b>";
            $et = "</b>";
        }
        else
        {
            $t = "";
            $et = "";
        }
        print
                "<tr> <td>$t$p$et</td> <td>$t{$r['username']} [{$r['userid']}]$et</td> </tr>";
    }
    print "</table>";
}

function hof_iq()
{
    global $ir, $c, $userid;
    print
            "Showing the 20 users with the highest IQ<br />
<table width=75%><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
    $q =
            mysql_query(
                    "SELECT u.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.user_level != 0 ORDER BY us.IQ DESC,u.userid ASC LIMIT 20",
                    $c);
    $p = 0;
    while ($r = mysql_fetch_array($q))
    {
        $p++;
        if ($r['userid'] == $ir['userid'])
        {
            $t = "<b>";
            $et = "</b>";
        }
        else
        {
            $t = "";
            $et = "";
        }
        print
                "<tr> <td>$t$p$et</td> <td>$t{$r['username']} [{$r['userid']}]$et</td> </tr>";
    }
    print "</table>";
}
$h->endpage();
