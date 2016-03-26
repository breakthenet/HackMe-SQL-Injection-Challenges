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
$_GET['c'] = abs((int) $_GET['c']);
if (!$_GET['c'])
{
    print "Invalid crime";
}
else
{
    $q = mysql_query("SELECT * FROM crimes WHERE crimeID={$_GET['c']}", $c);
    if (mysql_num_rows($q) == 0)
    {
        echo 'Invalid crime.';
        $h->endpage();
        exit;
    }
    $r = mysql_fetch_array($q);
    if ($ir['brave'] < $r['crimeBRAVE'])
    {
        print "You do not have enough Brave to perform this crime.";
    }
    else
    {
        $ec =
                "\$sucrate="
                        . str_replace(array("LEVEL", "EXP", "WILL", "IQ"),
                                array($ir['level'], $ir['exp'], $ir['will'],
                                        $ir['IQ']), $r['crimePERCFORM']) . ";";
        eval($ec);
        print $r['crimeITEXT'];
        $ir['brave'] -= $r['crimeBRAVE'];
        mysql_query(
                "UPDATE users SET brave={$ir['brave']} WHERE userid=$userid",
                $c);
        if (rand(1, 100) <= $sucrate)
        {
            print
                    str_replace("{money}", $r['crimeSUCCESSMUNY'],
                            $r['crimeSTEXT']);
            $ir['money'] += $r['crimeSUCCESSMUNY'];
            $ir['exp'] += (int) ($r['crimeSUCCESSMUNY'] / 8);
            mysql_query(
                    "UPDATE users SET money={$ir['money']},exp={$ir['exp']} WHERE userid=$userid",
                    $c);
        }
        else
        {
            print $r['crimeFTEXT'];
        }
        print
                "<br /><a href='docrime.php?c={$_GET['c']}'>Try Again</a><br />
<a href='criminal.php'>Crimes</a>";
    }
}

$h->endpage();
