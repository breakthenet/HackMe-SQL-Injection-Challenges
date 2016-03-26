<?php

require_once(dirname(__FILE__) . "/../mysql.php");
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
mysql_query("UPDATE users SET hospital=hospital-1 WHERE hospital>0", $c);

