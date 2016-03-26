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
//itemsend
if ($_GET['qty'] && $_GET['user'])
{
    $id =
            mysql_query(
                    "SELECT iv.*,it.* FROM inventory iv LEFT JOIN items it ON iv.inv_itemid=it.itmid WHERE iv.inv_id={$_GET['ID']} AND iv.inv_userid=$userid LIMIT 1",
                    $c);
    if (mysql_num_rows($id) == 0)
    {
        print "Invalid item ID";
    }
    else
    {
        $r = mysql_fetch_array($id);
        $m =
                mysql_query(
                        "SELECT * FROM users WHERE userid={$_GET['user']} LIMIT 1",
                        $c);
        if ($_GET['qty'] > $r['inv_qty'])
        {
            print "You are trying to send more than you have!";
        }
        else if ($_GET['qty'] <= 0)
        {
            print "You know, I'm not dumb, j00 cheating hacker.";
        }
        else if (mysql_num_rows($m) == 0)
        {
            print "You are trying to send to an invalid user!";
        }
        else
        {
            $rm = mysql_fetch_array($m);
            //are we sending it all
            if ($_GET['qty'] == $r['inv_qty'])
            {
                //just give them possession of the item
                mysql_query(
                        "UPDATE inventory SET inv_userid={$_GET['user']} WHERE inv_id={$_GET['ID']} LIMIT 1",
                        $c);

            }
            else
            {
                //create seperate
                mysql_query(
                        "INSERT INTO inventory VALUES(NULL,'{$r['inv_itemid']}',{$_GET['user']},{$_GET['qty']});",
                        $c);
                mysql_query(
                        "UPDATE inventory SET inv_qty=inv_qty-{$_GET['qty']} WHERE inv_id={$_GET['ID']} LIMIT 1;",
                        $c);
            }
            print
                    "You sent {$_GET['qty']} {$r['itmname']}(s) to {$rm['username']}";
            event_add($_GET['user'],
                    "You received {$_GET['qty']} {$r['itmname']}(s) from <a href='viewuser.php?u=$userid'>{$ir['username']}</a>",
                    $c);
            mysql_query(
                    "INSERT INTO itemxferlogs VALUES(NULL,$userid,{$_GET['user']},{$r['itmid']},{$_GET['qty']},"
                            . time() . ")", $c);
        }
    }
}
else if ($_GET['ID'])
{
    $id =
            mysql_query(
                    "SELECT iv.*,it.* FROM inventory iv LEFT JOIN items it ON iv.inv_itemid=it.itmid WHERE iv.inv_id={$_GET['ID']} AND iv.inv_userid=$userid LIMIT 1",
                    $c);
    if (mysql_num_rows($id) == 0)
    {
        print "Invalid item ID";
    }
    else
    {
        $r = mysql_fetch_array($id);
        print
                "<b>Enter who you want to send {$r['itmname']} to and how many you want to send. You have {$r['inv_qty']} to send.</b><br />
<form action='itemsend.php' method='get'>
<input type='hidden' name='ID' value='{$_GET['ID']}' />User ID: <input type='text' name='user' value='' /><br />
Quantity: <input type='text' name='qty' value='' /><br />
<input type='submit' value='Send Items (no prompt so be sure!' /></form>";
    }
}
else
{
    print "Invalid use of file.";
}
$h->endpage();
