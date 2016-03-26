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
$_GET['ID'] = abs((int) $_GET['ID']);
$_POST['money'] = abs((int) $_POST['money']);
if (!((int) $_GET['ID']))
{
    print "Invalid User ID";
}
else if ($_GET['ID'] == $userid)
{
    print "Haha, what does sending money to yourself do anyway?";
}
else
{
    if ((int) $_POST['money'])
    {
        if ($_POST['money'] > $ir['money'])
        {
            print "Die j00 abuser.";
        }
        else
        {
            mysql_query(
                    "UPDATE users SET money=money-{$_POST['money']} WHERE userid=$userid",
                    $c);
            mysql_query(
                    "UPDATE users SET money=money+{$_POST['money']} WHERE userid={$_GET['ID']}",
                    $c);
            print "You sent \${$_POST['money']} to ID {$_GET['ID']}.";
            event_add($_GET['ID'],
                    "You received \${$_POST['money']} from {$ir['username']}.",
                    $c);
            $it =
                    mysql_query(
                            "SELECT u.*,us.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.userid={$_GET['ID']}",
                            $c) or die(mysql_error());
            $er = mysql_fetch_array($it);
            mysql_query(
                    "INSERT INTO cashxferlogs VALUES(NULL, $userid, {$_GET['ID']}, {$_POST['money']}, "
                            . time()
                            . ", '{$ir['lastip']}', '{$er['lastip']}')", $c);
        }
    }
    else
    {
        print
                "<h3> Sending Money</h3>
You are sending money to ID: <b>{$_GET['ID']}</b>.
<form action='sendcash.php?ID={$_GET['ID']}' method='post'>
Amnt: <input type='text' name='money' /><br />
<input type='submit' value='Send' /></form>";
        print
                "<h3>Latest 5 Transfers</h3>
<table width=75% border=2> <tr style='background:gray'>  <th>Time</th> <th>User From</th> <th>User To</th> <th>Amount</th> </tr>";
        $q =
                mysql_query(
                        "SELECT cx.*,u1.username as sender, u2.username as sent FROM cashxferlogs cx LEFT JOIN users u1 ON cx.cxFROM=u1.userid LEFT JOIN users u2 ON cx.cxTO=u2.userid WHERE cx.cxFROM=$userid ORDER BY cx.cxTIME DESC LIMIT 5",
                        $c)
                or die(
                        mysql_error() . "<br />"
                                . "SELECT cx.*,u1.username as sender, u2.username as sent FROM cashxferlogs cx LEFT JOIN users u1 ON cx.cxFROM=u1.userid LEFT JOIN users u2 ON cx.cxTO=u2.userid WHERE cx.cxFROM=$userid ORDER BY cx.cxTIME DESC LIMIT 5");
        while ($r = mysql_fetch_array($q))
        {
            if ($r['cxFROMIP'] == $r['cxTOIP'])
            {
                $m = "<span style='color:red;font-weight:800'>MULTI</span>";
            }
            else
            {
                $m = "";
            }
            print
                    "<tr> <td>" . date("F j, Y, g:i:s a", $r['cxTIME'])
                            . "</td><td>{$r['sender']} [{$r['cxFROM']}] </td><td>{$r['sent']} [{$r['cxTO']}] </td> <td> \${$r['cxAMOUNT']}</td> </tr>";
        }
        print "</table>";
    }
}
$h->endpage();
