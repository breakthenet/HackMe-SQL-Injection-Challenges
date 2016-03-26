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
                "SELECT u.*,us.*,h.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN houses h ON h.hWILL=u.maxwill WHERE u.userid=$userid",
                $c) or die(mysql_error());
$ir = mysql_fetch_array($is);
check_level();
$fm = money_formatter($ir['money']);
$cm = money_formatter($ir['crystals'], '');
$lv = date('F j, Y, g:i a', $ir['laston']);
$h->userdata($ir, $lv, $fm, $cm);
$h->menuarea();
print "<h3>General Info:</h2>";
$exp = (int) ($ir['exp'] / $ir['exp_needed'] * 100);
print
        "<table><tr><td><b>Name:</b> {$ir['username']}</td><td><b>Crystals:</b> {$cm}</td></tr><tr>
<td><b>Level:</b> {$ir['level']}</td>
<td><b>Exp:</b> {$exp}%</td></tr><tr>
<td><b>Money:</b> $fm</td>
<td><b>HP:</b> {$ir['hp']}/{$ir['maxhp']}</td></tr>
<tr><td><b>Property:</b> {$ir['hNAME']}</td></tr></table>";
print "<hr><h3>Stats Info:</h3>";
$ts = $ir['strength'] + $ir['agility'] + $ir['guard'] + $ir['labour']
                + $ir['IQ'];
$ir['strank'] = get_rank($ir['strength'], 'strength');
$ir['agirank'] = get_rank($ir['agility'], 'agility');
$ir['guarank'] = get_rank($ir['guard'], 'guard');
$ir['labrank'] = get_rank($ir['labour'], 'labour');
$ir['IQrank'] = get_rank($ir['IQ'], 'IQ');
$tsrank = get_rank($ts, 'strength+agility+guard+labour+IQ');
$ir['strength'] = number_format($ir['strength']);
$ir['agility'] = number_format($ir['agility']);
$ir['guard'] = number_format($ir['guard']);
$ir['labour'] = number_format($ir['labour']);
$ir['IQ'] = number_format($ir['IQ']);
$ts = number_format($ts);

print
        "<table><tr><td><b>Strength:</b> {$ir['strength']} [Ranked: {$ir['strank']}]</td><td><b>Agility:</b> {$ir['agility']} [Ranked: {$ir['agirank']}]</td></tr>
<tr><td><b>Guard:</b> {$ir['guard']} [Ranked: {$ir['guarank']}]</td><td><b>Labour:</b> {$ir['labour']} [Ranked: {$ir['labrank']}]</td></tr>
<tr><td><b>IQ: </b> {$ir['IQ']} [Ranked: {$ir['IQrank']}]</td><td><b>Total stats:</b> {$ts} [Ranked: $tsrank]</td></tr></table>";
$h->endpage();
