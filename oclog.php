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
if (!$_GET['ID'])
{
    die("Incorrect usage of file.");
}
$q = mysql_query("SELECT * FROM oclogs WHERE oclID={$_GET['ID']}", $c);
$r = mysql_fetch_array($q);
print
        "Here is the detailed view on this crime.<br />
<b>Crime:</b> {$r['ocCRIMEN']}<br />
<b>Time Executed:</b> " . date('F j, Y, g:i:s a', $r['ocTIME'])
                . "<br />
                {$r['oclLOG']}<br /><br />
<b>Result:</b> {$r['oclRESULT']}<br />
<b>Money Made:</b> \${$r['oclMONEY']}";
$h->endpage();
