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
print
        "<h3>Voting</h3>
Here you may vote for breakthenet at various RPG toplists and be rewarded.<br />
<a href='http://apexwebgaming.com/in/498'>Vote at APEX (no reward)</a><br />
<a href='votetwg.php'>Vote at TWG (20% energy restore)</a><br />
<a href='votetrpg.php'>Vote at TOPRPG (\$300)</a>";

$h->endpage();
