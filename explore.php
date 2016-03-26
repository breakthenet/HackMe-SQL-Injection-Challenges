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
$tresder = (int) rand(100, 999);
print
        "<b>You begin exploring the area you're in, you see a bit that interests you.</b><br />
<table width=75%><tr height=100><td valign=top>
<u>Market Place</u><br />
<a href='shops.php'>Shops</a><br />
<a href='itemmarket.php'>Item Market</a><br />
<a href='cmarket.php'>Crystal Market</a></td>
<td valign=top
<u>Serious Money Makers</u><br />
<a href='monorail.php'>Travel Agency</a><br />
<a href='estate.php'>Estate Agent</a><br />
<a href='bank.php'>City Bank</a></td>
<td valign=top>";
if ($ir['location'] == 5)
{
    print
            "<u>Cyber State</u><br />
<a href='cyberbank.php'>Cyber Bank</a><br />";
}
print
        "</td><td valign=top>
<u>Dark Side</u><br />
<a href='fedjail.php'>Federal Jail</a><br />
<a href='slotsmachine.php?tresde=$tresder'>Slots Machine</a><br />
<a href='roulette.php?tresde=$tresder'>Roulette</a></td></tr><tr height=100>
<td valign=top>";
if ($ir['location'] == 5)
{
    print
            "<u>Cyber Casino</u><br />
<a href='slotsmachine3.php'>Super Slots</a><br />";
}
print
        "</td><td valign=top>
<u>Statistics Dept</u><br />
<a href='userlist.php'>User List</a><br />
<a href='stafflist.php'>breakthenet Staff</a><br />
<a href='halloffame.php'>Hall of Fame</a><br />
<a href='stats.php'>Game Stats</a><br />
<a href='usersonline.php'>Users Online</a></td><td valign=top>&nbsp;</td><td valign=top>
<u>Mysterious</u><br />
<a href='crystaltemple.php'>Crystal Temple</a><br />";
if ($ir['location'] == 4)
{
    print "<a href='battletent.php'>Battle Tent</a><br />";
}
$game_url = determine_game_urlbase();
print
        "</td></tr></table><br /><br />This is your referal link: http://{$game_url}/register.php?REF=$userid <br />
Every signup from this link earns you two valuable crystals!";
$h->endpage();
