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
if ($ir['donatordays'] == 0)
{
    die("This feature is for donators only.");
}
print "<h3>Black List</h3>";
switch ($_GET['action'])
{
case "add":
    add_enemy();
    break;

case "remove":
    remove_enemy();
    break;

case "ccomment":
    change_comment();
    break;

default:
    black_list();
    break;
}

function black_list()
{
    global $ir, $c, $userid;
    print 
            "<a href='blacklist.php?action=add'>&gt; Add an Enemy</a><br />
These are the people on your black list. ";
    $q_y = mysql_query("SELECT * FROM blacklist WHERE bl_ADDED=$userid", $c);
    print 
            mysql_num_rows($q_y)
                    . " people have added you to their list.<br />Most hated: [";
    $q2r =
            mysql_query(
                    "SELECT u.username,count( * ) as cnt,bl.bl_ADDED FROM blacklist bl LEFT JOIN users u on bl.bl_ADDED=u.userid GROUP BY bl.bl_ADDED ORDER BY cnt DESC LIMIT 5",
                    $c) or die(mysql_error());
    $r = 0;
    while ($r2r = mysql_fetch_array($q2r))
    {
        $r++;
        if ($r > 1)
        {
            print " | ";
        }
        print 
                "<a href='viewuser.php?u={$r2r['bl_ADDED']}'>{$r2r['username']}</a>";
    }
    print 
            "]
<table width=90%><tr style='background:gray'> <th>ID</th> <th>Name</th> <th>Mail</th> <th>Attack</th> <th>Remove</th> <th>Comment</th> <th>Change Comment</th> <th>Online?</th></tr>";
    $q =
            mysql_query(
                    "SELECT bl.*,u.* FROM blacklist bl LEFT JOIN users u ON bl.bl_ADDED=u.userid WHERE bl.bl_ADDER=$userid ORDER BY u.username ASC",
                    $c);
    while ($r = mysql_fetch_array($q))
    {
        if ($r['laston'] >= time() - 15 * 60)
        {
            $on = "<font color=green><b>Online</b></font>";
        }
        else
        {
            $on = "<font color=red><b>Offline</b></font>";
        }
        $d = "";
        if ($r['donatordays'])
        {
            $r['username'] = "<font color=red>{$r['username']}</font>";
            $d =
                    "<img src='donator.gif' alt='Donator: {$r['donatordays']} Days Left' title='Donator: {$r['donatordays']} Days Left' />";
        }
        if (!$r['bl_COMMENT'])
        {
            $r['bl_COMMENT'] = "N/A";
        }
        print 
                "<tr> <td>{$r['userid']}</td> <td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> $d</td> <td><a href='mailbox.php?action=compose&ID={$r['userid']}'>Mail</a></td> <td><a href='attack.php?ID={$r['userid']}'>Attack</a></td> <td><a href='blacklist.php?action=remove&f={$r['bl_ID']}'>Remove</a></td> <td>{$r['bl_COMMENT']}</td> <td><a href='blacklist.php?action=ccomment&f={$r['bl_ID']}'>Change</a></td> <td>$on</td></tr>";
    }
}

function add_enemy()
{
    global $ir, $c, $userid;
    $_POST['ID'] = abs((int) $_POST['ID']);
    $_POST['comment'] =
            mysql_real_escape_string(
                    nl2br(
                            htmlentities(stripslashes($_POST['comment']),
                                    ENT_QUOTES, 'ISO-8859-1')), $c);

    if ($_POST['ID'])
    {
        $qc =
                mysql_query(
                        "SELECT * FROM blacklist WHERE bl_ADDER=$userid AND bl_ADDED={$_POST['ID']}",
                        $c);
        $q =
                mysql_query(
                        "SELECT * FROM users WHERE userid={$_POST['ID']}", $c);
        if (mysql_num_rows($qc))
        {
            print "You cannot add the same person twice.";
        }
        else if ($userid == $_POST['ID'])
        {
            print 
                    "You cannot be so lonely that you have to try and add yourself.";
        }
        else if (mysql_num_rows($q) == 0)
        {
            print "Oh no, you're trying to add a ghost.";
        }
        else
        {
            mysql_query(
                    "INSERT INTO blacklist VALUES(NULL, $userid, {$_POST['ID']}, '{$_POST['comment']}')",
                    $c) or die(mysql_error());
            $r = mysql_fetch_array($q);
            print 
                    "{$r['username']} was added to your black list.<br />
<a href='blacklist.php'>&gt; Back</a>";
        }
    }
    else
    {
        $_GET['ID'] =
                (isset($_GET['ID']) && is_numeric($_GET['ID']))
                        ? abs(intval($_GET['ID'])) : '';
        print 
                "Adding an enemy!<form action='blacklist.php?action=add' method='post'>
Enemy's ID: <input type='text' name='ID' value='{$_GET['ID']}' /><br />
Comment (optional): <br />
<textarea name='comment' rows='7' cols='40'></textarea><br />
<input type='submit' value='Add Enemy' /></form>";
    }

}

function remove_enemy()
{
    global $ir, $c, $userid;
    $_GET['f'] = abs((int) $_GET['f']);
    mysql_query(
            "DELETE FROM blacklist WHERE bl_ID={$_GET['f']} AND bl_ADDER=$userid",
            $c);
    print 
            "Black list entry removed!<br />
<a href='blacklist.php'>&gt; Back</a>";
}

function change_comment()
{
    global $ir, $c, $userid;
    $_POST['f'] = abs((int) $_POST['f']);
    $_POST['comment'] =
            mysql_real_escape_string(
                    nl2br(
                            htmlentities(stripslashes($_POST['comment']),
                                    ENT_QUOTES, 'ISO-8859-1')), $c);
    if ($_POST['comment'])
    {
        mysql_query(
                "UPDATE blacklist SET bl_COMMENT='{$_POST['comment']}' WHERE bl_ID={$_POST['f']} AND bl_ADDER=$userid",
                $c);
        print 
                "Comment for enemy changed!<br />
<a href='blacklist.php'>&gt; Back</a>";
    }
    else
    {
        $_GET['f'] = abs((int) $_GET['f']);
        $q =
                mysql_query(
                        "SELECT * FROM blacklist WHERE bl_ID={$_GET['f']} AND bl_ADDER=$userid",
                        $c);
        if (mysql_num_rows($q))
        {
            $r = mysql_fetch_array($q);
            $comment = str_replace('<br />', "\n", $r['bl_COMMENT']);
            print 
                    "Changing a comment.<form action='blacklist.php?action=ccomment' method='post'>
<input type='hidden' name='f' value='{$_GET['f']}' /><br />
Comment: <br />
<textarea rows='7' cols='40' name='comment'>$comment</textarea><br />
<input type='submit' value='Change Comment' /></form>";
        }
        else
        {
            print "Stop trying to edit comments that aren't yours.";
        }
    }
}

$h->endpage();
