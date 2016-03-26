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
        "<h3>Search</h3>
<b>Search by Name</b><form action='searchname.php' method='get'>
<input type='text' name='name' /><br />
<input type='submit' value='Search' /></form><hr />
<b>Search by ID</b><form action='viewuser.php' method='get'>
<input type='text' name='u' /><br />
<input type='submit' value='Search' /></form>";
$h->endpage();
