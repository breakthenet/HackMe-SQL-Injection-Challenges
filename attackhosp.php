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

$_GET['ID'] = abs((int) $_GET['ID']);
$_SESSION['attacking'] = 0;
$od = mysql_query("SELECT * FROM users WHERE userid={$_GET['ID']}", $c);
if ($_SESSION['attackwon'] != $_GET['ID'])
{
    die("Cheaters don't get anywhere.");
}
if (mysql_num_rows($od))
{
    $r = mysql_fetch_array($od);
    if ($r['hp'] == 1)
    {
        print "What a cheater you are.";
    }
    else
    {
        print "You beat {$r['username']} and hospitalized them.";

        event_add($r['userid'],
                "<a href='viewuser.php?u=$userid'>{$ir['username']}</a> hospitalized you.",
                $c);

        mysql_query(
                "UPDATE users SET hp=1,hospital=hospital+80+(rand()*230),hospreason='Hospitalized by <a href=\'viewuser.php?u={$userid}\'>{$ir['username']}</a>' WHERE userid={$r['userid']}",
                $c);
        $atklog = mysql_escape_string($_SESSION['attacklog']);
        mysql_query(
                "INSERT INTO attacklogs VALUES(NULL,$userid,{$_GET['ID']},'won',"
                        . time() . ",-1,'$atklog');", $c);
        $_SESSION['attackwon'] = 0;
        $bots = array(263, 264, 265, 2477, 2479, 2480, 2481, 0, 0, 0, 0, 0, 0);
        $moneys =
                array(263 => 10000, 264 => 10000, 265 => 15500, 2477 => 80000,
                        2479 => 30000, 2480 => 30000, 2481 => 30000,
                        0 => 100000, 0 => 1400000, 0 => 1400000, 0 => 1400000,
                        0 => 5000000, 0 => 10000000);
        if (in_array($r['userid'], $bots))
        {
            $qk =
                    mysql_query(
                            "SELECT * FROM challengesbeaten WHERE userid=$userid AND npcid={$r['userid']}",
                            $c);
            if (!mysql_num_rows($qk))
            {
                $gain = $moneys[$r['userid']];
                mysql_query(
                        "UPDATE users SET money=money+$gain WHERE userid=$userid",
                        $c);
                mysql_query(
                        "INSERT INTO challengesbeaten VALUES ($userid,{$r['userid']})",
                        $c);
                print
                        "<br /><br />Congrats, you have beaten the Challenge BOT {$r['username']}, you have earnt \$$gain!";
            }
        }
    }
}
else
{
    print "You beat Mr. non-existant!";
}
$h->endpage();
