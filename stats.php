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
// Basic Stats (all users)
$q =
        mysql_query(
                "SELECT COUNT(`userid`) AS `c_users`,
				 SUM(`money`) AS `s_money`,
				 SUM(`crystals`) AS `s_crystals`
                 FROM `users`", $c);
$mem_info = mysql_fetch_assoc($q);
$membs = $mem_info['c_users'];
$total = $mem_info['s_money'];
$avg = (int) ($total / ($membs > 1 ? $membs : 1));
$totalc = $mem_info['s_crystals'];
$avgc = (int) ($totalc / ($membs > 1 ? $membs : 1));
mysql_free_result($q);
$q =
        mysql_query(
                "SELECT COUNT(`userid`) AS `c_users`,
                 SUM(`bankmoney`) AS `s_bank`
                 FROM `users`
                 WHERE `bankmoney` > -1", $c);
$bank_info = mysql_fetch_assoc($q);
$banks = $bank_info['c_users'];
$totalb = $bank_info['s_bank'];
$avgb = (int) ($totalb / ($banks > 0 ? $banks : 1));
mysql_free_result($q);
$q =
        mysql_query(
                "SELECT COUNT(`userid`)
                 FROM `users`
                 WHERE `gender` = 'Male'", $c);
$male = mysql_result($q, 0, 0);
mysql_free_result($q);
$q =
        mysql_query(
                "SELECT COUNT(`userid`)
                 FROM `users`
                 WHERE `gender` = 'Female'", $c);
$fem = mysql_result($q, 0, 0);
mysql_free_result($q);

$q = mysql_query("SELECT SUM(`inv_qty`)
				 FROM `inventory`", $c);
$totali =(int) mysql_result($q, 0, 0);
mysql_free_result($q);
$q = mysql_query("SELECT COUNT(`mail_id`)
				 FROM `mail`", $c);
$mail = mysql_result($q, 0, 0);
mysql_free_result($q);
$q = mysql_query("SELECT COUNT(`evID`)
				 FROM `events`", $c);
$events = mysql_result($q, 0, 0);
mysql_free_result($q);
echo "<h3>Country Statistics</h3>
You step into the Statistics Department and login to the service. You see some stats that interest you.<br />
<table width='75%' cellspacing='1' class='table'>
	<tr>
		<th>Users</th>
		<th>Money and Crystals</th>
	</tr>
	<tr>
		<td>
			There are currently $membs {$set['game_name']} players,
                $male males and $fem females.
        </td>
        <td>
			Amount of cash in circulation: " . money_formatter($total)
        . ". <br />
			The average player has: " . money_formatter($avg)
        . ". <br />
			Amount of cash in banks: " . money_formatter($totalb)
        . ". <br />
			Amount of players with bank accounts: $banks<br />
			The average player has in their bank accnt: "
        . money_formatter($avgb)
        . ". <br />
			Amount of crystals in circulation: "
        . money_formatter($totalc, "")
        . ". <br />
			The average player has: " . money_formatter($avgc, "")
        . " crystals.
        </td>
    </tr>
	<tr>
		<th>Mails/Events</th>
		<th>Items</th>
	</tr>
	<tr>
		<td>
			" . money_formatter($mail, "") . " mails and "
        . money_formatter($events, "")
        . " events have been sent.
        </td>
        <td>
			There are currently " . money_formatter($totali, "")
        . " items in circulation.
        </td>
    </tr>
 </table>";
$h->endpage();
