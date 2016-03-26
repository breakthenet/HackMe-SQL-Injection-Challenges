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
$staff = array();
$q =
        mysql_query(
                "SELECT `userid`, `laston`, `username`, `level`, `money`,
 				 `user_level`
 				 FROM `users`
 				 WHERE `user_level` IN(2, 3, 4, 5)
 				 ORDER BY `userid` ASC",$c);
while ($r = mysql_fetch_assoc($q))
{
    $staff[$r['userid']] = $r;
}
mysql_free_result($q);
echo '
<b>Admins</b>
<br />
<table width="75%" cellspacing="1" cellpadding="1" border="1">
		<tr style="background: gray;">
			<th>User</th>
			<th>Level</th>
			<th>Money</th>
			<th>Last Seen</th>
			<th>Status</th>
		</tr>
   ';

foreach ($staff as $r)
{
    if ($r['user_level'] == 2)
    {
        $on =
                ($r['laston'] >= ($_SERVER['REQUEST_TIME'] - 900))
                        ? '<span style="color: green;">Online</span>'
                        : '<span style="color: green;">Offline</span>';
        echo '
		<tr>
			<td><a href="viewuser.php?u=' . $r['userid'] . '">'
                . $r['username'] . '</a> [' . $r['userid'] . ']</td>
			<td>' . $r['level'] . '</td>
			<td>' . money_formatter($r['money'], '$') . '</td>
			<td>' . date("F j, Y, g:i:s a", $r['laston']) . '</td>
			<td>' . $on . '</td>
		</tr>
   		';
    }
}
echo '</table>

<b>Secretaries</b>
<br />
<table width="75%" cellspacing="1" cellpadding="1" border="1">
		<tr style="background: gray;">
			<th>User</th>
			<th>Level</th>
			<th>Money</th>
			<th>Last Seen</th>
			<th>Status</th>
		</tr>
   ';
foreach ($staff as $r)
{
    if ($r['user_level'] == 3)
    {
        $on =
                ($r['laston'] >= ($_SERVER['REQUEST_TIME'] - 900))
                        ? '<span style="color: green;">Online</span>'
                        : '<span style="color: green;">Offline</span>';
        echo '
		<tr>
			<td><a href="viewuser.php?u=' . $r['userid'] . '">'
                . $r['username'] . '</a> [' . $r['userid'] . ']</td>
			<td>' . $r['level'] . '</td>
			<td>' . money_formatter($r['money'], '$') . '</td>
			<td>' . date("F j, Y, g:i:s a", $r['laston']) . '</td>
			<td>' . $on . '</td>
		</tr>
   		';
    }
}
echo '</table>

<b>Assistants</b>
<br />
<table width="75%" cellspacing="1" cellpadding="1" border="1">
		<tr style="background: gray;">
			<th>User</th>
			<th>Level</th>
			<th>Money</th>
			<th>Last Seen</th>
			<th>Status</th>
		</tr>
   ';
foreach ($staff as $r)
{
    if ($r['user_level'] == 5)
    {
        $on =
                ($r['laston'] >= ($_SERVER['REQUEST_TIME'] - 900))
                        ? '<span style="color: green;">Online</span>'
                        : '<span style="color: green;">Offline</span>';
        echo '
		<tr>
			<td><a href="viewuser.php?u=' . $r['userid'] . '">'
                . $r['username'] . '</a> [' . $r['userid'] . ']</td>
			<td>' . $r['level'] . '</td>
			<td>' . money_formatter($r['money'], '$') . '</td>
			<td>' . date("F j, Y, g:i:s a", $r['laston']) . '</td>
			<td>' . $on . '</td>
		</tr>
   		';
    }
}
echo '</table>

<b>IRC Ops</b>
<br />
<table width="75%" cellspacing="1" cellpadding="1" border="1">
		<tr style="background: gray;">
			<th>User</th>
			<th>Level</th>
			<th>Money</th>
			<th>Last Seen</th>
			<th>Status</th>
		</tr>
   ';
foreach ($staff as $r)
{
    if ($r['user_level'] == 4)
    {
        $on =
                ($r['laston'] >= ($_SERVER['REQUEST_TIME'] - 900))
                        ? '<span style="color: green;">Online</span>'
                        : '<span style="color: green;">Offline</span>';
        echo '
		<tr>
			<td><a href="viewuser.php?u=' . $r['userid'] . '">'
                . $r['username'] . '</a> [' . $r['userid'] . ']</td>
			<td>' . $r['level'] . '</td>
			<td>' . money_formatter($r['money'], '$') . '</td>
			<td>' . date("F j, Y, g:i:s a", $r['laston']) . '</td>
			<td>' . $on . '</td>
		</tr>
   		';
    }
}
echo '</table>';
$h->endpage();
