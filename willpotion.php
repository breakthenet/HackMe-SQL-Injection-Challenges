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
$game_url = determine_game_urlbase();
print
        <<<EOF
<h3>Will Potions</h3>

Buy will potions today! They restore 100% will.<br />
<b>Buy One:</b> (\$1)<br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="teachthenet@gmail.com">
<input type="hidden" name="item_name" value="Will Potion for ($userid) (1)">
<input type="hidden" name="amount" value="1.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$game_url}/willpdone.php?action=done&quantity=one">
<input type="hidden" name="cancel_return" value="http://{$game_url}/willpdone.php?action=cancel">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<b>Buy Five:</b> (\$4.50)<br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="teachthenet@gmail.com">
<input type="hidden" name="item_name" value="Will Potion for ($userid) (5)">
<input type="hidden" name="amount" value="4.50">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$game_url}/willpdone.php?action=done&quantity=five">
<input type="hidden" name="cancel_return" value="http://{$game_url}/willpdone.php?action=cancel">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
EOF;
$h->endpage();
