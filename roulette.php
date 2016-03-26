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
$maxbet = $ir['level'] * 150;
$_GET['tresde'] = abs((int) $_GET['tresde']);
if (($_SESSION['tresde'] == $_GET['tresde']) || $_GET['tresde'] < 100)
{
    die(
            "Error, you cannot refresh or go back on the slots, please use a side link to go somewhere else.<br />
<a href='roulette.php?tresde=$tresder'>&gt; Back</a>");
}
$_SESSION['tresde'] = $_GET['tresde'];
$_GET['bet'] = abs((int) $_GET['bet']);
$_GET['number'] = abs((int) $_GET['number']);
print "<h3>Roulette: Pick a number between 0 - 36</h3>";
if ($_GET['bet'])
{
    if ($_GET['bet'] > $ir['money'])
    {
        die(
                "You are trying to bet more than you have.<br />
<a href='roulette.php?tresde=$tresder'>&gt; Back</a>");
    }
    else if ($_GET['bet'] > $maxbet)
    {
        die(
                "You have gone over the max bet.<br />
<a href='roulette.php?tresde=$tresder'>&gt; Back</a>");
    }
    else if ($_GET['number'] > 36 or $_GET['number'] < 0 or $_GET['bet'] < 0)
    {
        die(
                "The Numbers are only 0 - 36.<br />
<a href='roulette.php?tresde=$tresder'>&gt; Back</a>");
    }

    $slot[1] = (int) rand(0, 36);
    print
            "You place \${$_GET['bet']} into the slot and pull the pole.<br />
You see the number: <b>$slot[1]</b><br />
You bet \${$_GET['bet']} ";
    if ($slot[1] == $_GET['number'])
    {
        $won = $_GET['bet'] * 37;
        $gain = $_GET['bet'] * 36;
        print
                "and won \$$won by matching the number u bet pocketing you \$$gain extra.";
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
<a href='roulette.php?bet={$_GET['bet']}&tresde=$tresder&number={$_GET['number']}'>&gt; Another time, same bet.</a><br />
<a href='roulette.php?tresde=$tresder'>&gt; I'll continue, but I'm changing my bet.</a><br />
<a href='explore.php'>&gt; Enough's enough, I'm off.</a>";
}
else
{
    print
            "Ready to try your luck? Play today!<br />
The maximum bet for your level is \$$maxbet.<br />
<form action='roulette.php' method='get'>
Bet: \$<input type='text' name='bet' value='5' /><br />
Pick (0-36): <input type='text' name='number' value='18' /><br />
<input type='hidden' name='tresde' value='$tresder' />
<input type='submit' value='Play!!' />
</form>";
}

$h->endpage();
