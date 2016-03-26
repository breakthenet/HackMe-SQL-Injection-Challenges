<?php

require "mysql.php";
$_GET['ad'] = abs(@intval($_GET['ad']));
mysql_query("UPDATE ads SET adCLICKS=adCLICKS+1 WHERE adID='{$_GET['ad']}'",
        $c);
$q = mysql_query("SELECT adURL FROM ads WHERE adID='{$_GET['ad']}'", $c);
if (mysql_num_rows($q) > 0)
{
    header("Location: " . mysql_result($q, 0, 0));
}
else
{
    die("Invalid ad.");
}
