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
$out = "";
$_GET['times'] = abs((int) $_GET['times']);
if (isset($_GET['train']))
{
    if ($_GET['train'] != "strength" && $_GET['train'] != "agility"
            && $_GET['train'] != "guard" && $_GET['train'] != "labour")
    {
        $h->userdata($ir, $lv, $fm, $cm);
        $h->menuarea();
        die("Abusers aren't allowed.");
    }
    $tgain = 0;
    for ($i = 1; $i <= $_GET['times'] && $ir['energy'] > 0; $i++)
    {
        if ($ir['energy'] > 0)
        {
            $gain =
                    rand(1, 3) / rand(800, 1000) * rand(800, 1000)
                            * (($ir['will'] + 20) / 150);
            $tgain += $gain;
            if ($_GET['train'] == "IQ")
            {
                $gain /= 100;
            }
            $ir[$_GET['train']] += $gain;
            $egain = $gain / 10;
            $ts = $ir[$_GET['train']];
            $st = $_GET['train'];

            mysql_query(
                    "UPDATE userstats SET $st=$st+" . $gain
                            . " WHERE userid=$userid", $c)
                    or die(
                            "UPDATE userstats SET $st=$st+$gain,energy=energy-1,exp=exp+$egain WHERE userid=$userid<br />"
                                    . mysql_error());
            $wu = (int) (rand(1, 3));
            if ($ir['will'] >= $wu)
            {
                $ir['will'] -= $wu;
                mysql_query(
                        "UPDATE users SET energy=energy-1,exp=exp+$egain,will=will-$wu WHERE userid=$userid",
                        $c);
            }
            else
            {
                $ir['will'] = 0;
                mysql_query(
                        "UPDATE users SET energy=energy-1,exp=exp+$egain,will=0 WHERE userid=$userid",
                        $c);
            }
            $ir['energy'] -= 1;
            $ir['exp'] += $egain;

        }
        else
        {
            $out = "You do not have enough energy to train.";
        }
    }
    $stat = $ir[$st];
    $i--;
    $out =
            "You begin training your $st.<br />
You have gained $tgain $st by training it $i times.<br />
You now have $stat $st and {$ir['energy']} energy left.<br /><br />";

}
else
{
    $out = "<h3>Gym: Main Lobby<h3>";
}
$h->userdata($ir, $lv, $fm, $cm);
$h->menuarea();
print $out;
print
        "Enter the amount of times you wish to train and choose the stat to train.<br />
You can train up to {$ir['energy']} times.<br /><form action='gym.php' method='get'>
<input type='text' name='times' value='1' /><select type='dropdown' name='train'>
<option value='strength'>Strength</option>
<option value='agility'>Agility</option>
<option value='labour'>Labour</option>
<option value='guard'>Guard</option></select><br />
<input type='submit' value='Train!' /></form>";

$h->endpage();
