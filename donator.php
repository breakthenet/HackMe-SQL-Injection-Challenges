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
<h3>Donations</h3>
<b>[<a href='willpotion.php'>Buy Will Potions</a>]</b><br />
If you become a donator to breakthenet, you will receive (each time you donate):<br />
<b>1st Offer:</b><ul>
<li>\$5,000 game money</li>
<li>50 crystals</li>
<li>50 IQ, the hardest stat to get in the game!</li>
<li>30 days Donator Status: Red name + cross next to your name</li>
<li><b>NEW!</b> Friend and Black Lists</li>
<li><b>NEW!</b> 17% Energy every 5 mins instead of 8%</li></ul><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type=hidden name=cmd value=_xclick>
<input type="hidden" name="business" value="teachthenet@gmail.com">
<input type="hidden" name="item_name" value="breakthenet Donation for ($userid) (Pack 1)">
<input type="hidden" name="amount" value="3.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$game_url}/donatordone.php?action=done&type=standard">
<input type="hidden" name="cancel_return" value="http://{$game_url}/donatordone.php?action=cancel">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<b>2nd Offer:</b><ul>
<li>100 crystals</li>
<li>30 days Donator Status: Red name + cross next to your name</li>
<li><b>NEW!</b> Friend and Black Lists</li>
<li><b>NEW!</b> 17% Energy every 5 mins instead of 8%</li></ul><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="teachthenet@gmail.com">
<input type="hidden" name="item_name" value="breakthenet Donation for ($userid) (Pack 2)">
<input type="hidden" name="amount" value="3.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$game_url}/donatordone.php?action=done&type=crystals">
<input type="hidden" name="cancel_return" value="http://{$game_url}/donatordone.php?action=cancel">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<b>3rd Offer:</b><ul>
<li>120 IQ, the hardest stat to get in the game!</li>
<li>30 days Donator Status: Red name + cross next to your name</li>
<li><b>NEW!</b> Friend and Black Lists</li>
<li><b>NEW!</b> 17% Energy every 5 mins instead of 8%</li></ul><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="teachthenet@gmail.com">
<input type="hidden" name="item_name" value="breakthenet Donation for ($userid) (Pack 3)">
<input type="hidden" name="amount" value="3.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$game_url}/donatordone.php?action=done&type=iq">
<input type="hidden" name="cancel_return" value="http://{$game_url}/donatordone.php?action=cancel">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<b>4th Offer ($5.00 pack):</b><ul>
<li>\$15,000 game money</li>
<li>75 crystals</li>
<li>80 IQ, the hardest stat to get in the game!</li>
<li>55 days Donator Status: Red name + cross next to your name</li>
<li><b>NEW!</b> Friend and Black Lists</li>
<li><b>NEW!</b> 17% Energy every 5 mins instead of 8%</li></ul><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="teachthenet@gmail.com">
<input type="hidden" name="item_name" value="breakthenet Donation for ($userid) (Pack 4)">
<input type="hidden" name="amount" value="5.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$game_url}/donatordone.php?action=done&type=fivedollars">
<input type="hidden" name="cancel_return" value="http://{$game_url}/donatordone.php?action=cancel">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<b>5th Offer ($10.00 pack):</b><ul>
<li>\$35,000 game money</li>
<li>160 crystals</li>
<li>180 IQ, the hardest stat to get in the game!</li>
<li>A free Rifle valued at \$25,000</li>
<li>115 days Donator Status: Red name + cross next to your name</li>
<li><b>NEW!</b> Friend and Black Lists</li>
<li><b>NEW!</b> 17% Energy every 5 mins instead of 8%</li></ul><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="teachthenet@gmail.com">
<input type="hidden" name="item_name" value="breakthenet Donation for ($userid) (Pack 5)">
<input type="hidden" name="amount" value="10.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://{$game_url}/donatordone.php?action=done&type=tendollars">
<input type="hidden" name="cancel_return" value="http://{$game_url}/donatordone.php?action=cancel">
<input type="hidden" name="cn" value="Your Player ID">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="tax" value="0">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
EOF;
$h->endpage();
