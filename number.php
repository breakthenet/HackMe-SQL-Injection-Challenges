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
$maxbet = $ir['level'] * 1;
$_GET['tresde'] = abs((int) $_GET['tresde']);
if (($_SESSION['tresde'] == $_GET['tresde']) || $_GET['tresde'] < 100)
{
    die(
            "Error, you cannot refresh or go back on the slots, please use a side link to go somewhere else.<br />
<a href='number.php?tresde=$tresder'>&gt; Back</a>");
}
$_SESSION['tresde'] = $_GET['tresde'];
$_GET['crystals'] = abs((int) $_GET['crystals']);
$_GET['number'] = abs((int) $_GET['number']);
print "<h3>Pick a number between 1 - 3 and double your bet of crystals</h3>";
if ($_GET['crystals'])
{
    if ($_GET['crystals'] > $ir['crystals'])
    {
        die(
                "You are trying to bet more than you have.<br />
<a href='number.php?tresde=$tresder'>&gt; Back</a>");
    }
    else if ($_GET['crystals'] > $maxbet)
    {
        die(
                "You have gone over the max bet.<br />
<a href='roulette.php?tresde=$tresder'>&gt; Back</a>");
    }
    else if ($_GET['number'] > 3 or $_GET['number'] < 1 or $_GET['bet'] < 0)
    {
        die(
                "The Numbers are only 1 - 3.<br />
<a href='number.php?tresde=$tresder'>&gt; Back</a>");
    }

    $slot[1] = (int) rand(1, 3);
    print
            "You place \${$_GET['crystals']} into the slot and pull the pole.<br />
You see the number: <b>$slot[1]</b><br />
You bet \${$_GET['crystals']} ";
    if ($slot[1] == $_GET['number'])
    {
        $won = $_GET['crystals'] * 2;
        $gain = $_GET['crystals'] * 1;
        print
                "and won \$$won by matching the number u bet pocketing you \$$gain extra.";
    }
    else
    {
        $won = 0;
        $gain = -$_GET['crystals'];
        print "and lost it.";
    }
    mysql_query(
            "UPDATE users SET crystals=crystals+({$gain}) where userid=$userid",
            $c);
    $tresder = (int) (rand(100, 999));
    print
            "<br />
<a href='number.php?bet={$_GET['bet']}&tresde=$tresder&number={$_GET['number']}'>&gt; Another time, same bet.</a><br />
<a href='number.php?tresde=$tresder'>&gt; I'll continue, but I'm changing my bet.</a><br />
<a href='explore.php'>&gt; Enough's enough, I'm off.</a>";
}
else
{
    print
            "Ready to try your luck? Play today!<br />
The maximum bet for your level is \$maxbet.<br />
<form action='number.php' method='get'>
Bet: \$<input type='text' name='bet' value='5' /><br />
Pick (1-3): <input type='text' name='number' value='2' /><br />
<input type='hidden' name='tresde' value='$tresder' />
<input type='submit' value='Play!!' />
</form>";
}

$h->endpage();
