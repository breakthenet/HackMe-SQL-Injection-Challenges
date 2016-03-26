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
print "<h3>Schooling</h3>";
if ($ir['course'] > 0)
{
    $cd = mysql_query("SELECT * FROM courses WHERE crID={$ir['course']}", $c);
    $coud = mysql_fetch_array($cd);
    print
            "You are currently doing the {$coud['crNAME']}, you have {$ir['cdays']} days remaining.";
}
else
{
    if ($_GET['cstart'])
    {
        $_GET['cstart'] = abs((int) $_GET['cstart']);
        //Verify.
        $cd =
                mysql_query(
                        "SELECT * FROM courses WHERE crID={$_GET['cstart']}",
                        $c);
        if (mysql_num_rows($cd) == 0)
        {
            print "You are trying to start a non-existant course!";
        }
        else
        {
            $coud = mysql_fetch_array($cd);
            $cdo =
                    mysql_query(
                            "SELECT * FROM coursesdone WHERE userid=$userid AND courseid={$_GET['cstart']}",
                            $c);
            if ($ir['money'] < $coud['crCOST'])
            {
                print "You don't have enough money to start this course.";
                $h->endpage();
                exit;
            }
            if (mysql_num_rows($cdo) > 0)
            {
                print "You have already done this course.";
                $h->endpage();
                exit;
            }
            mysql_query(
                    "UPDATE users SET course={$_GET['cstart']},cdays={$coud['crDAYS']},money=money-{$coud['crCOST']} WHERE userid=$userid",
                    $c);
            print
                    "You have started the {$coud['crNAME']}, it will take {$coud['crDAYS']} days to complete.";
        }
    }
    else
    {
        //list courses
        print "Here is a list of available courses.";
        $q = mysql_query("SELECT * FROM courses", $c);
        print
                "<br /><table width=75%><tr style='background:gray;'><th>Course</th><th>Description</th><th>Cost</th><th>Take</th></tr>";
        while ($r = mysql_fetch_array($q))
        {
            $cdo =
                    mysql_query(
                            "SELECT * FROM coursesdone WHERE userid=$userid AND courseid={$r['crID']}",
                            $c);
            if (mysql_num_rows($cdo))
            {
                $do = "<i>Done</i>";
            }
            else
            {
                $do = "<a href='education.php?cstart={$r['crID']}'>Take</a>";
            }
            print
                    "<tr><td>{$r['crNAME']}</td><td>{$r['crDESC']}</td><td>\${$r['crCOST']}</td><td>$do</td></tr>";
        }
        print "</table>";
    }
}
$h->endpage();
