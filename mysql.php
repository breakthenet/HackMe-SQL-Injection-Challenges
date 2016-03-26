<?php
$mysql_string = getenv('CLEARDB_DATABASE_URL');
$mysql_url = parse_url($mysql_string);

$c = mysql_connect($mysql_url['host'], $mysql_url['user'], $mysql_url['pass']) or die(mysql_error());
$db_name = str_replace("/", "", $mysql_url['path']);
mysql_select_db($db_name, $c);