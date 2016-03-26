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
print "<h3>The MonoPaper</h3>";
$q = mysql_query("SELECT * FROM papercontent LIMIT 1", $c);
$content = mysql_result($q, 0, 0);
print
        "<table width=75% border=1><tr><td>&nbsp;</td> <td><a href='gym.php'>LOCAL GYM</a></td> <td><a href='halloffame.php'>HALL OF FAME</a></td></tr><tr><td><img src='http://img190.imageshack.us/img190/6798/ad1za.png' alt='Ad' /></td><td colspan=2>$content</td></tr>
</table>";
$h->endpage();
