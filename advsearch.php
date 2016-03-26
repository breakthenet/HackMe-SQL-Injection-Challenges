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
if ($_POST['submit'])
{
    $levelmin = abs((int) $_POST['levelmin']);
    $levelmax = abs((int) $_POST['levelmax']);
    $levelmin_clause = "WHERE level >= '{$levelmin}'";
    $levelmax_clause = " AND level <= '{$levelmax}'";
    $nom = mysql_real_escape_string(stripslashes($_POST['name']), $c);
    $gender =
            in_array($_POST['gender'], array('Male', 'Female'), true)
                    ? $_POST['gender'] : '';
    $name_clause = ($nom) ? " AND username LIKE('%{$nom}%')" : "";
    $gender_clause = ($gender) ? " AND gender = '{$gender}'" : "";
    $house = abs((int) $_POST['house']);
    $online = abs((int) $_POST['online']);
    $dayo_min = abs((int) $_POST['daysmin']);
    $dayo_max = abs((int) $_POST['daysmax']);
    $house_clause = ($house) ? " AND maxwill = '{$house}'" : "";
    $online_clause = ($online) ? " AND laston >= " . (time() - $online) : "";
    $daysmin_clause = ($dayo_min) ? " AND daysold >= '{$dayo_min}'" : "";
    $daysmax_clause = ($dayo_max) ? " AND daysold <= '{$dayo_max}'" : "";
    $q =
            mysql_query(
                    "SELECT * FROM users $levelmin_clause$levelmax_clause$name_clause$gender_clause$house_clause$online_clause$daysmin_clause$daysmax_clause",
                    $c);
    print
            mysql_num_rows($q)
                    . " players found. <br />
<table><tr style='background-color:gray;'><th>User</th><th>Level</th><th>Money</th></tr>";
    while ($r = mysql_fetch_array($q))
    {
        print
                "<tr><td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a></td><td>{$r['level']}</td><td>\${$r['money']}</td></tr>";
    }
    print "</table>";
}
else
{
    print
            <<<EOF
<h3>Advanced search</h3>
<span style="color: red;">*</span> is a required field.<br />
<form action="advsearch.php" method="post">
<input type="hidden" name="submit" value="1" />
Name: <input type="text" name="name" /><br />
Level: From: <span style="color: red;">*</span><input type="text" name="levelmin" value="1" /> To:
<span style="color: red;">*</span> <input type="text" name="levelmax" value="100" /><br />
Gender: <select name="gender" type="dropdown">
<option value="0" selected="selected">Either</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select><br />
House: <select name=house type=dropdown>
<option value=0 selected>Any House</option>
EOF;
    $q = mysql_query("SELECT * FROM houses ORDER BY hWILL ASC", $c);
    while ($r = mysql_fetch_array($q))
    {
        print "\n<option value='{$r['hWILL']}'>{$r['hNAME']}</option>";
    }
    print
            <<<EOF
</select><br />
Days Old: From: <input type=text name=daysmin> To: <input type=text name=daysmax><br />
<input type='submit' value='Go'></form>
EOF;
}
$h->endpage();
