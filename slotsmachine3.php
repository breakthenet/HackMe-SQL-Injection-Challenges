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
$tresder = (int) (rand(100, 999));
$maxbet = $ir['level'] * 500;
$_GET['tresde'] = abs((int) $_GET['tresde']);
if (($_SESSION['tresde'] == $_GET['tresde']) || $_GET['tresde'] < 100)
{
    die(
            "Error, you cannot refresh or go back on the slots, please use a side link to go somewhere else.<br />
<a href='slotsmachine3.php?tresde=$tresder'>&gt; Back</a>");
}
$_SESSION['tresde'] = $_GET['tresde'];
$_GET['bet'] = abs((int) $_GET['bet']);
print "<h3>5 Line Slotmachine</h3>";
if ($_GET['bet'])
{
    if ($_GET['bet'] > $ir['money'])
    {
        die(
                "You are trying to bet more than you have.<br />
<a href='slotsmachine3.php?tresde=$tresder'>&gt; Back</a>");
    }
    else if ($_GET['bet'] > $maxbet)
    {
        die(
                "You have gone over the max bet.<br />
<a href='slotsmachine3.php?tresde=$tresder'>&gt; Back</a>");
    }

    $slot[1] = (int) rand(0, 9);
    $slot[2] = (int) rand(0, 9);
    $slot[3] = (int) rand(0, 9);
    $slot[4] = (int) rand(0, 9);
    $slot[5] = (int) rand(0, 9);
    print
            "You place \${$_GET['bet']} into the slot and pull the pole.<br />
You see the numbers: <b>$slot[1] $slot[2] $slot[3] $slot[4] $slot[5]</b><br />
You bet \${$_GET['bet']} ";
    if ($slot[1] == $slot[2] && $slot[2] == $slot[3] && $slot[3] == $slot[4]
            && $slot[4] == $slot[5])
    {
        $won = $_GET['bet'] * 126;
        $gain = $_GET['bet'] * 125;
        print
                "and won \$$won by lining up 5 numbers pocketing you \$$gain extra.";
    }
    else if (($slot[1] == $slot[2] && $slot[2] == $slot[3]
            && $slot[3] == $slot[4])
            || ($slot[2] == $slot[3] && $slot[3] == $slot[4]
                    && $slot[4] == $slot[5])
            || ($slot[1] == $slot[3] && $slot[3] == $slot[4]
                    && $slot[4] == $slot[5])
            || ($slot[1] == $slot[2] && $slot[2] == $slot[4]
                    && $slot[4] == $slot[5])
            || ($slot[1] == $slot[2] && $slot[2] == $slot[3]
                    && $slot[3] == $slot[5]))
    {
        $won = $_GET['bet'] * 36;
        $gain = $_GET['bet'] * 35;
        print
                "and won \$$won by lining up 4 numbers pocketing you \$$gain extra.";
    }
    else if (($slot[1] == $slot[2] && $slot[2] == $slot[3])
            || ($slot[2] == $slot[3] && $slot[3] == $slot[5])
            || ($slot[3] == $slot[4] && $slot[4] == $slot[5])
            || ($slot[1] == $slot[3] && $slot[3] == $slot[5])
            || ($slot[1] == $slot[4] && $slot[4] == $slot[5])
            || ($slot[1] == $slot[2] && $slot[2] == $slot[4])
            || ($slot[2] == $slot[3] && $slot[3] == $slot[5])
            || ($slot[1] == $slot[3] && $slot[3] == $slot[4])
            || ($slot[2] == $slot[4] && $slot[4] == $slot[5])
            || ($slot[1] == $slot[2] && $slot[2] == $slot[5])
            || ($slot[2] == $slot[3] && $slot[3] == $slot[4]))
    {
        $won = $_GET['bet'] * 9;
        $gain = $_GET['bet'] * 8;
        print
                "and won \$$won by lining up 3 numbers pocketing you \$$gain extra.";
    }
    else
    {
        $won = 0;
        $gain = -$_GET['bet'];
        print "and lost it.";
    }
    mysql_query(
            "UPDATE users SET money=money+({$gain}) where userid=$userid", $c);
    $tresder = (int) (rand(100, 999));
    print
            "<br />
<a href='slotsmachine3.php?bet={$_GET['bet']}&tresde=$tresder'>&gt; Another time, same bet.</a><br />
<a href='slotsmachine3.php?tresde=$tresder'>&gt; I'll continue, but I'm changing my bet.</a><br />
<a href='explore.php'>&gt; Enough's enough, I'm off.</a>";
}
else
{
    print
            "Ready to try your luck? Play today!<br />
The maximum bet for your level is \$$maxbet.<br />
<form action='slotsmachine3.php' method='get'>
Bet: \$<input type='text' name='bet' value='5' /><br />
<input type='hidden' name='tresde' value='$tresder' />
<input type='submit' value='Play!!' />
</form>";
}

$h->endpage();
