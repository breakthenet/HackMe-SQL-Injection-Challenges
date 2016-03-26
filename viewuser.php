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
$_GET['u'] = abs((int) $_GET['u']);
if (!$_GET['u'])
{
    print "Invalid use of file";
}
else
{
    $q =
            mysql_query(
                    "SELECT u.*,us.*,c.*,h.*,f.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN cities c ON u.location=c.cityid LEFT JOIN houses h ON u.maxwill=h.hWILL LEFT JOIN fedjail f ON f.fed_userid=u.userid WHERE u.userid={$_GET['u']}",
                    $c);
    if (mysql_num_rows($q) == 0)
    {
        print 
                "Sorry, we could not find a user with that ID, check your source.";
    }
    else
    {
        $r = mysql_fetch_array($q);
        if ($r['user_level'] == 1)
        {
            $userl = "Member";
        }
        else if ($r['user_level'] == 2)
        {
            $userl = "Admin";
        }
        else if ($r['user_level'] == 3)
        {
            $userl = "Secretary";
        }
        else if ($r['user_level'] == 0)
        {
            $userl = "NPC";
        }
        else if ($r['user_level'] == 4)
        {
            $userl = "IRC Mod";
        }
        else
        {
            $userl = "Assistant";
        }
        $lon = date('F j, Y g:i:s a', $r['laston']);
        $sup = date('F j, Y g:i:s a', $r['signedup']);
        $ts =
                $r['strength'] + $r['agility'] + $r['guard'] + $r['labour']
                        + $r['IQ'];
        $d = "";
        $la = time() - $r['laston'];
        $unit = "seconds";
        if ($la >= 60)
        {
            $la = (int) ($la / 60);
            $unit = "minutes";
        }
        if ($la >= 60)
        {
            $la = (int) ($la / 60);
            $unit = "hours";
            if ($la >= 24)
            {
                $la = (int) ($la / 24);
                $unit = "days";
            }
        }
        if ($r['donatordays'])
        {
            $r['username'] = "<font color=red>{$r['username']}</font>";
            $d =
                    "<img src='donator.gif' alt='Donator: {$r['donatordays']} Days Left' title='Donator: {$r['donatordays']} Days Left' />";
        }
        if ($r['laston'] >= time() - 15 * 60)
        {
            $on = "<font color=green><b>Online</b></font>";
        }
        else
        {
            $on = "<font color=red><b>Offline</b></font>";
        }
        print 
                "<h3>Profile for {$r['username']}</h3>
<table width=75%><tr style='background:gray'><th>General Info</th><th>Financial Info</th> <th>Display Pic</th></tr>
<tr><td>Name: {$r['username']} [{$r['userid']}] $d<br />
User Level: $userl<br />
Duties: {$r['duties']}<br />
Gender: {$r['gender']}<br />
Signed Up: $sup<br />
Last Active: $lon<br />
Last Action: $la $unit ago<br />
Online: $on<br />
Days Old: {$r['daysold']}<br />
Location: {$r['cityname']}</td><td>
Money: \${$r['money']}<br />
Crystals: {$r['crystals']}<br />
Property: {$r['hNAME']}<br />
Referals: ";
        $rr =
                mysql_query(
                        "SELECT * FROM referals WHERE refREFER={$r['userid']}",
                        $c);
        print mysql_num_rows($rr);
        $q_y =
                mysql_query(
                        "SELECT * FROM friendslist WHERE fl_ADDED={$r['userid']}",
                        $c);
        $q_z =
                mysql_query(
                        "SELECT * FROM blacklist WHERE bl_ADDED={$r['userid']}",
                        $c);
        print 
                "<br />
Friends: " . mysql_num_rows($q_y) . "<br />
Enemies: " . mysql_num_rows($q_z) . "
</td> <td rowspan='2'>";
        if ($r['display_pic'])
        {
            print 
                    "<img src='{$r['display_pic']}' width='150' height='150' alt='User Display Pic' title='User Display Pic' />";
        }
        else
        {
            print "This user has no display pic!";
        }
        print 
                "</td></tr>
<tr style='background:gray'><th>Physical Info</th><th>Links</th></tr>
<tr><td>Level: {$r['level']}<br />
Health: {$r['hp']}/{$r['maxhp']}<br />";
        if ($r['fedjail'])
        {
            print 
                    "<br /><b><font color=red>In federal jail for {$r['fed_days']} day(s).<br />
                    {$r['fed_reason']}</font>";
        }
        if ($r['hospital'])
        {
            print 
                    "<br /><b><font color=red>In hospital for {$r['hospital']} minutes.<br />{$r['hospreason']}</font></b>";
        }
        if ($ir['user_level'] == 2 || $ir['user_level'] == 3
                || $ir['user_level'] == 5)
        {
            print "<br />IP Address: {$r['lastip']}";
            $e_staffnotes =
                    htmlentities($r['staffnotes'], ENT_QUOTES, 'ISO-8859-1');
            print 
                    "<form action='staffnotes.php' method='post'>
Staff Notes: <br />
<textarea rows=7 cols=40 name='staffnotes'>{$e_staffnotes}</textarea>
<br /><input type='hidden' name='ID' value='{$_GET['u']}' />
<input type='submit' value='Change' /></form>";
        }
        print 
                "</td><td>[<a href='mailbox.php?action=compose&ID={$r['userid']}'>Send Mail</a>]<br /><br />
[<a href='sendcash.php?ID={$r['userid']}'>Send Cash</a>]<br /><br />
[<a href='attack.php?ID={$r['userid']}'>Attack</a>]";
        if ($ir['user_level'] == 2 || $ir['user_level'] == 3
                || $ir['user_level'] == 5)
        {
            print 
                    "<br /><br />
[<a href='jailuser.php?userid={$r['userid']}'>Jail</a>]<br /><br />
[<a href='mailban.php?userid={$r['userid']}'>MailBan</a>]";
        }
        if ($ir['donatordays'] > 0)
        {
            print 
                    "<br /><br />
[<a href='friendslist.php?action=add&ID={$r['userid']}'>Add Friends</a>]<br /><br />
[<a href='blacklist.php?action=add&ID={$r['userid']}'>Add Enemies</a>]<br />";
        }
        print "</td></tr></table>";
    }
}
$h->endpage();
