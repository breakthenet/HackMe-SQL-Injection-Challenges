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
if (!$_GET['spend'])
{
    print
            "Welcome to the crystal temple!<br />
You have <b>{$ir['crystals']}</b> crystals.<br />
What would you like to spend your crystals on?<br />
<br />
<a href='crystaltemple.php?spend=refill'>Energy Refill - 12 Crystals</a><br />
<a href='crystaltemple.php?spend=IQ'>IQ - 5 IQ per crystal</a><br />
<a href='crystaltemple.php?spend=money'>Money - \$200 per crystal</a><br />";
}
else
{
    if ($_GET['spend'] == 'refill')
    {
        if ($ir['crystals'] < 12)
        {
            print "You don't have enough crystals!";
        }
        else if ($ir['energy'] == $ir['maxenergy'])
        {
            print "You already have full energy.";
        }
        else
        {
            mysql_query(
                    "UPDATE users SET energy=maxenergy,crystals=crystals-12 WHERE userid=$userid",
                    $c);
            print "You have paid 12 crystals to refill your energy bar.";
        }
    }
    else if ($_GET['spend'] == 'IQ')
    {
        print
                "Type in the amount of crystals you want to swap for IQ.<br />
You have <b>{$ir['crystals']}</b> crystals.<br />
One crystal = 5 IQ.<form action='crystaltemple.php?spend=IQ2' method='post'><input type='text' name='crystals' /><br /><input type='submit' value='Swap' /></form>";
    }
    else if ($_GET['spend'] == 'IQ2')
    {
        $_POST['crystals'] = (int) $_POST['crystals'];
        if ($_POST['crystals'] <= 0 || $_POST['crystals'] > $ir['crystals'])
        {
            print
                    "Error, you either do not have enough crystals or did not fill out the form.<br />
<a href='crystaltemple.php?spend=IQ'>Back</a>";
        }
        else
        {
            $iqgain = $_POST['crystals'] * 5;
            mysql_query(
                    "UPDATE users SET crystals=crystals-{$_POST['crystals']} WHERE userid=$userid",
                    $c);
            mysql_query(
                    "UPDATE userstats SET IQ=IQ+$iqgain WHERE userid=$userid",
                    $c);
            print "You traded {$_POST['crystals']} crystals for $iqgain IQ.";
        }
    }
    else if ($_GET['spend'] == 'money')
    {
        print
                "Type in the amount of crystals you want to swap for \$\$\$.<br />
You have <b>{$ir['crystals']}</b> crystals.<br />
One crystal = \$200.<form action='crystaltemple.php?spend=money2' method='post'><input type='text' name='crystals' /><br /><input type='submit' value='Swap' /></form>";
    }
    else if ($_GET['spend'] == 'money2')
    {
        $_POST['crystals'] = (int) $_POST['crystals'];
        if ($_POST['crystals'] <= 0 || $_POST['crystals'] > $ir['crystals'])
        {
            print
                    "Error, you either do not have enough crystals or did not fill out the form.<br />
<a href='crystaltemple.php?spend=money'>Back</a>";
        }
        else
        {
            $iqgain = $_POST['crystals'] * 200;
            mysql_query(
                    "UPDATE users SET crystals=crystals-{$_POST['crystals']},money=money+$iqgain WHERE userid=$userid",
                    $c);
            print "You traded {$_POST['crystals']} crystals for \$$iqgain.";
        }
    }
}

$h->endpage();
