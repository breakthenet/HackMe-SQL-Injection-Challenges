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
print "<h3>Item Market</h3>";
switch ($_GET['action'])
{
case "buy":
    item_buy();
    break;

case "gift1":
    item_gift1();
    break;

case "gift2":
    item_gift2();
    break;

case "remove":
    item_remove();
    break;

default:
    imarket_index();
    break;
}

function imarket_index()
{
    global $ir, $c, $userid, $h;
    print
            "Viewing all listings...
<table width=75%> <tr style='background:gray'> <th>Adder</th> <th>Item</th> <th>Price</th> <th>Links</th> </tr>";
    $q =
            mysql_query(
                    "SELECT im.*, i.*, u.*,it.* FROM itemmarket im LEFT JOIN items i ON im.imITEM=i.itmid LEFT JOIN users u ON u.userid=im.imADDER LEFT JOIN itemtypes it ON i.itmtype=it.itmtypeid ORDER BY i.itmtype, i.itmname ASC",
                    $c);
    $lt = "";
    while ($r = mysql_fetch_array($q))
    {
        if ($lt != $r['itmtypename'])
        {
            $lt = $r['itmtypename'];
            print
                    "\n<tr style='background: gray;'><th colspan=4>{$lt}</th></tr>";
        }
        if ($r['imADDER'] == $userid)
        {
            $link =
                    "[<a href='itemmarket.php?action=remove&ID={$r['imID']}'>Remove</a>]";
        }
        else
        {
            $link =
                    "[<a href='itemmarket.php?action=buy&ID={$r['imID']}'>Buy</a>] [<a href='itemmarket.php?action=gift1&ID={$r['imID']}'>Gift</a>]";
        }
        print
                "\n<tr> <td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> [{$r['userid']}]</td> <td>{$r['itmname']}</td> <td>\$"
                        . number_format($r['imPRICE'])
                        . "</td> <td>[<a href='iteminfo.php?ID={$r['itmid']}'>Info</a>] $link</td> </tr>";
    }
    print "</table>";
}

function item_remove()
{
    global $ir, $c, $userid, $h;
    $q =
            mysql_query(
                    "SELECT im.*,i.* FROM itemmarket im LEFT JOIN items i ON im.imITEM=i.itmid WHERE imID={$_GET['ID']} AND imADDER=$userid",
                    $c);
    if (!mysql_num_rows($q))
    {
        print
                "Error, either this item does not exist, or you are not the owner.<br />
<a href='itemmarket.php'>&gt; Back</a>";
        $h->endpage();
        exit;
    }
    $r = mysql_fetch_array($q);
    mysql_query("INSERT INTO inventory VALUES(NULL,{$r['imITEM']},$userid,1)",
            $c) or die(mysql_error());
    $i = mysql_insert_id($c);
    mysql_query("DELETE FROM itemmarket WHERE imID={$_GET['ID']}", $c);
    mysql_query(
            "INSERT INTO imremovelogs VALUES(NULL, {$r['imITEM']}, {$r['imADDER']}, $userid, {$r['imID']}, $i, "
                    . time()
                    . ", '{$ir['username']} removed a {$r['itmname']} from the item market.')",
            $c);
    print
            "Item removed from market!<br />
<a href='itemmarket.php'>&gt; Back</a>";
}

function item_buy()
{
    global $ir, $c, $userid, $h;
    error_log("SELECT * FROM itemmarket im LEFT JOIN items i ON i.itmid=im.imITEM WHERE imID={$_GET['ID']}");
    $q = mysql_query("SELECT * FROM itemmarket im LEFT JOIN items i ON i.itmid=im.imITEM WHERE imID={$_GET['ID']}", $c);
    $r = mysql_fetch_array($q);
    if ($r['imPRICE'] > $ir['money'])
    {
        print
                "Error, you do not have the funds to buy this item.<br />
<a href='itemmarket.php'>&gt; Back</a>";
        $h->endpage();
        exit;
    }
    error_log("DELETE FROM itemmarket WHERE imID={$_GET['ID']}");
    mysql_query("DELETE FROM itemmarket WHERE imID={$_GET['ID']}", $c);
    mysql_query("INSERT INTO inventory VALUES(NULL,{$r['imITEM']},$userid,1)",
            $c) or die(mysql_error());
    $i = mysql_insert_id($c);
    mysql_query(
            "UPDATE users SET money=money-{$r['imPRICE']} where userid=$userid",
            $c);
    mysql_query(
            "UPDATE users SET money=money+{$r['imPRICE']} where userid={$r['imADDER']}",
            $c);
    event_add($r['imADDER'],
            "<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought your {$r['itmname']} item from the market for \$"
                    . number_format($r['imPRICE']) . ".", $c);
    mysql_query(
            "INSERT INTO imbuylogs VALUES(NULL, {$r['imITEM']}, {$r['imADDER']}, $userid,  {$r['imPRICE']}, {$r['imID']}, $i, "
                    . time()
                    . ", '{$ir['username']} bought a {$r['itmname']} from the item market for \${$r['imPRICE']} from user ID {$r['imADDER']}')",
            $c);
    print
            "You bought the {$r['itmname']} from the market for \$"
                    . number_format($r['imPRICE']) . ".";

}

function item_gift1()
{
    global $ir, $c, $userid, $h;
    $q =
            mysql_query(
                    "SELECT * FROM itemmarket im LEFT JOIN items i ON i.itmid=im.imITEM WHERE imID={$_GET['ID']}",
                    $c);
    if (!mysql_num_rows($q))
    {
        print
                "Error, either this item does not exist, or it has already been bought.<br />
<a href='itemmarket.php'>&gt; Back</a>";
        $h->endpage();
        exit;
    }
    $r = mysql_fetch_array($q);
    if ($r['imPRICE'] > $ir['money'])
    {
        print
                "Error, you do not have the funds to buy this item.<br />
<a href='itemmarket.php'>&gt; Back</a>";
        $h->endpage();
        exit;
    }
    print
            "Buying the <b>{$r['itmname']}</b> for \$"
                    . number_format($r['imPRICE'])
                    . " as a gift...<br />
<form action='itemmarket.php?action=gift2' method='post'>
<input type='hidden' name='ID' value='{$_GET['ID']}' />
User to give gift to: " . user_dropdown($c, 'user')
                    . "<br />
<input type='submit' value='Buy Item and Send Gift' /></form>";
}

function item_gift2()
{
    global $ir, $c, $userid, $h;
    $q =
            mysql_query(
                    "SELECT * FROM itemmarket im LEFT JOIN items i ON i.itmid=im.imITEM WHERE imID={$_POST['ID']}",
                    $c);
    if (!mysql_num_rows($q))
    {
        print
                "Error, either this item does not exist, or it has already been bought.<br />
<a href='itemmarket.php'>&gt; Back</a>";
        $h->endpage();
        exit;
    }
    $r = mysql_fetch_array($q);
    if ($r['imPRICE'] > $ir['money'])
    {
        print
                "Error, you do not have the funds to buy this item.<br />
<a href='itemmarket.php'>&gt; Back</a>";
        $h->endpage();
        exit;
    }
    mysql_query(
            "INSERT INTO inventory VALUES(NULL,{$r['imITEM']},{$_POST['user']},1)",
            $c) or die(mysql_error());
    $i = mysql_insert_id($c);
    mysql_query("DELETE FROM itemmarket WHERE imID={$_POST['ID']}", $c);
    mysql_query(
            "UPDATE users SET money=money-{$r['imPRICE']} where userid=$userid",
            $c);
    mysql_query(
            "UPDATE users SET money=money+{$r['imPRICE']} where userid={$r['imADDER']}",
            $c);
    event_add($r['imADDER'],
            "<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought your {$r['itmname']} item from the market for \$"
                    . number_format($r['imPRICE']) . ".", $c);

    event_add($_POST['user'],
            "<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought you a {$r['itmname']} from the item market as a gift.",
            $c);
    $u = mysql_query("SELECT * FROM users WHERE userid={$_POST['user']}", $c);
    $uname = mysql_result($u, 0, 1);
    mysql_query(
            "INSERT INTO imbuylogs VALUES(NULL, {$r['imITEM']}, {$r['imADDER']}, $userid,  {$r['imPRICE']}, {$r['imID']}, $i, "
                    . time()
                    . ", '{$ir['username']} bought a {$r['itmname']} from the item market for \${$r['imPRICE']} from user ID {$r['imADDER']} as a gift for $uname [{$_POST['user']}]')",
            $c);
    print
            "You bought the {$r['itmname']} from the market for \$"
                    . number_format($r['imPRICE'])
                    . " and sent the gift to $uname.";

}
$h->endpage();
