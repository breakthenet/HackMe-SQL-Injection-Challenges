<?php

require_once(dirname(__FILE__) . "/../mysql.php");
require_once(dirname(__FILE__) . "/../global_func.php");
$cron_code = '4f155ea3c4a19a5d37420b1158111a78';
if ($argc == 2)
{
    if ($argv[1] != $cron_code)
    {
        exit;
    }
}
else if (!isset($_GET['code']) || $_GET['code'] !== $cron_code)
{
    exit;
}
// update for all users
$allusers_query =
        "UPDATE `users`
        SET `brave` = LEAST(`brave` + ((`maxbrave` / 10) + 0.5), `maxbrave`),
        `hp` = LEAST(`hp` + (`maxhp` / 3), `maxhp`),
        `will` = LEAST(`will` + 10, `maxwill`)";
mysql_query($allusers_query, $c);
//enerwill update
$en_nd_query =
        "UPDATE `users`
        SET `energy` = LEAST(`energy` + (`maxenergy` / 12.5), `maxenergy`)
        WHERE `donatordays` = 0";
$en_don_query =
        "UPDATE `users`
        SET `energy` = LEAST(`energy` + (`maxenergy` / 6), `maxenergy`)
        WHERE `donatordays` > 0";
mysql_query($en_nd_query, $c);
mysql_query($en_don_query, $c);
