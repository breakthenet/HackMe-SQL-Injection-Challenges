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
print "<h3>Crystal Market</h3>";
switch ($_GET['action'])
{
case "buy":
    crystal_buy();
    break;

case "remove":
    crystal_remove();
    break;

case "add":
    crystal_add();
    break;

default:
    cmarket_index();
    break;
}

function cmarket_index()
{
    global $ir, $c, $userid, $h;
    print
            "<a href='cmarket.php?action=add'>&gt; Add A Listing</a><br /><br />
Viewing all listings...
<table width=75%> <tr style='background:gray'> <th>Adder</th> <th>Qty</th> <th>Price each</th> <th>Price total</th> <th>Links</th> </tr>";
    $q =
            mysql_query(
                    "SELECT cm.*, u.* FROM crystalmarket cm LEFT JOIN users u ON u.userid=cm.cmADDER ORDER BY cmPRICE/cmQTY ASC",
                    $c);
    while ($r = mysql_fetch_array($q))
    {
        if ($r['cmADDER'] == $userid)
        {
            $link =
                    "<a href='cmarket.php?action=remove&ID={$r['cmID']}'>Remove</a>";
        }
        else
        {
            $link =
                    "<a href='cmarket.php?action=buy&ID={$r['cmID']}'>Buy</a>";
        }
        $each = (int) $r['cmPRICE'] / $r['cmQTY'];
        print
                "\n<tr> <td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> [{$r['userid']}]</td> <td>{$r['cmQTY']}</td> <td> \$"
                        . number_format($each) . "</td> <td>\$"
                        . number_format($r['cmPRICE'])
                        . "</td> <td>[$link]</td> </tr>";
    }
    print "</table>";
}

function crystal_remove()
{
    global $ir, $c, $userid, $h;
    $q =
            mysql_query(
                    "SELECT * FROM crystalmarket WHERE cmID={$_GET['ID']} AND cmADDER=$userid",
                    $c);
    if (!mysql_num_rows($q))
    {
        print
                "Error, either these crystals do not exist, or you are not the owner.<br />
<a href='cmarket.php'>&gt; Back</a>";
        $h->endpage();
        exit;
    }
    $r = mysql_fetch_array($q);
    mysql_query(
            "UPDATE users SET crystals=crystals+{$r['cmQTY']} where userid=$userid",
            $c) or die(mysql_error());
    mysql_query("DELETE FROM crystalmarket WHERE cmID={$_GET['ID']}", $c);
    print
            "Crystals removed from market!<br />
<a href='cmarket.php'>&gt; Back</a>";
}

function crystal_buy()
{
    global $ir, $c, $userid, $h;
    error_log("SELECT * FROM crystalmarket cm WHERE cmID={$_GET['ID']}");
    $q = mysql_query("SELECT * FROM crystalmarket cm WHERE cmID={$_GET['ID']}", $c);
    if (!mysql_num_rows($q))
    {
        print
                "Error, either these crystals do not exist, or they have already been bought.<br />
<a href='cmarket.php'>&gt; Back</a>";
        $h->endpage();
        exit;
    }
    $r = mysql_fetch_array($q);
    if ($r['cmPRICE'] > $ir['money'])
    {
        print
                "Error, you do not have the funds to buy these crystals.<br />
<a href='cmarket.php'>&gt; Back</a>";
        $h->endpage();
        exit;
    }
    error_log("UPDATE users SET crystals=crystals+{$r['cmQTY']} where userid=$userid");
    mysql_query("UPDATE users SET crystals=crystals+{$r['cmQTY']} where userid=$userid", $c);
    mysql_query("DELETE FROM crystalmarket WHERE cmID={$_GET['ID']}", $c);
    mysql_query(
            "UPDATE users SET money=money-{$r['cmPRICE']} where userid=$userid",
            $c);
    mysql_query(
            "UPDATE users SET money=money+{$r['cmPRICE']} where userid={$r['cmADDER']}",
            $c);
    //event_add($r['cmADDER'], "<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought your {$r['cmQTY']} crystals from the market for \$". number_format($r['cmPRICE']) . ".", $c);
    print
            "You bought the {$r['cmQTY']} crystals from the market for \$"
                    . number_format($r['cmPRICE']) . ".";

}

function crystal_add()
{
    global $ir, $c, $userid, $h;
    $_POST['amnt'] = abs((int) $_POST['amnt']);
    $_POST['price'] = abs((int) $_POST['price']);
    if ($_POST['amnt'])
    {
        if ($_POST['amnt'] > $ir['crystals'])
        {
            die(
                    "You are trying to add more crystals to the market than you have.");
        }
        $tp = $_POST['amnt'] * $_POST['price'];
        mysql_query(
                "INSERT INTO crystalmarket VALUES(NULL,{$_POST['amnt']},$userid,$tp)",
                $c);
        mysql_query(
                "UPDATE users SET crystals=crystals-{$_POST['amnt']} WHERE userid=$userid",
                $c);
        print
                "Crystals added to market!<br />
<a href='cmarket.php'>&gt; Back</a>";
    }
    else
    {
        print
                "<b>Adding a listing...</b><br /><br />
You have <b>{$ir['crystals']}</b> crystal(s) that you can add to the market.<form action='cmarket.php?action=add' method='post'><table width=50% border=2><tr>
<td>Crystals:</td> <td><input type='text' name='amnt' value='{$ir['crystals']}' /></td></tr><tr>
<td>Price Each:</td> <td><input type='text' name='price' value='200' /></td></tr><tr>
<td colspan=2 align=center><input type='submit' value='Add To Market' /></tr></table></form>";
    }
}
$h->endpage();
