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
mysql_query("UPDATE `fedjail` SET `fed_days` = `fed_days` - 1", $c);
$q = mysql_query("SELECT * FROM `fedjail` WHERE `fed_days` <= 0", $c);
$ids = array();
while ($r = mysql_fetch_assoc($q))
{
    $ids[] = $r['fed_userid'];
}
mysql_free_result($q);
if (count($ids) > 0)
{
    mysql_query(
            "UPDATE `users` SET `fedjail` = 0 WHERE `userid` IN("
                    . implode(",", $ids) . ")", $c);
}
mysql_query("DELETE FROM `fedjail` WHERE `fed_days` <= 0", $c);
$user_update_query =
        "UPDATE `users` SET 
         `daysold` = `daysold` + 1,
         `mailban` = `mailban` - IF(`mailban` > 0, 1, 0),
         `donatordays` = `donatordays` - IF(`donatordays` > 0, 1, 0),
         `cdays` = `cdays` - IF(`course` > 0, 1, 0),
         `bankmoney` = `bankmoney` + IF(`bankmoney` > 0, `bankmoney` / 50, 0),
         `cybermoney` = `cybermoney` + IF(`cybermoney` > 0, `cybermoney` / 100 * 7, 0)";
mysql_query($user_update_query, $c);
$q =
        mysql_query(
                "SELECT `userid`, `course` FROM `users` WHERE `cdays` <= 0 AND `course` > 0",
                $c);
$course_cache = array();
while ($r = mysql_fetch_assoc($q))
{
    if (!array_key_exists($r['course'], $course_cache))
    {
        $cd =
                mysql_query(
                        "SELECT `crSTR`, `crGUARD`, `crLABOUR`, `crAGIL`, `crIQ`, `crNAME`
     				     FROM `courses`
                         WHERE `crID` = {$r['course']}", $c);
        $coud = mysql_fetch_assoc($cd);
        mysql_free_result($cd);
        $course_cache[$r['course']] = $coud;
    }
    else
    {
        $coud = $course_cache[$r['course']];
    }
    $userid = $r['userid'];
    mysql_query(
            "INSERT INTO `coursesdone` VALUES({$r['userid']}, {$r['course']})",
            $c);
    $upd = "";
    $ev = "";
    if ($coud['crSTR'] > 0)
    {
        $upd .= ", us.strength = us.strength + {$coud['crSTR']}";
        $ev .= ", {$coud['crSTR']} strength";
    }
    if ($coud['crGUARD'] > 0)
    {
        $upd .= ", us.guard = us.guard + {$coud['crGUARD']}";
        $ev .= ", {$coud['crGUARD']} guard";
    }
    if ($coud['crLABOUR'] > 0)
    {
        $upd .= ", us.labour = us.labour + {$coud['crLABOUR']}";
        $ev .= ", {$coud['crLABOUR']} labour";
    }
    if ($coud['crAGIL'] > 0)
    {
        $upd .= ", us.agility = us.agility + {$coud['crAGIL']}";
        $ev .= ", {$coud['crAGIL']} agility";
    }
    if ($coud['crIQ'] > 0)
    {
        $upd .= ", us.IQ = us.IQ + {$coud['crIQ']}";
        $ev .= ", {$coud['crIQ']} IQ";
    }
    $ev = substr($ev, 1);
    mysql_query(
            "UPDATE `users` AS `u`
                INNER JOIN `userstats` AS `us` ON `u`.`userid` = `us`.`userid`
                SET `u`.`course` = 0{$upd}
                WHERE `u`.`userid` = {$userid}", $c);
    event_add($userid,
            "Congratulations, you completed the {$coud['crNAME']} and gained {$ev}!",
            $c);
}
mysql_free_result($q);
mysql_query("TRUNCATE TABLE `votes`", $c);
