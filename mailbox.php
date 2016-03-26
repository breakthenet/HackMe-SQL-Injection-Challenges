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
if ($ir['mailban'])
{
    die(
            "<font color=red><h3>! ERROR</h3>
You have been mail banned for {$ir['mailban']} days.<br />
<br />
<b>Reason: {$ir['mb_reason']}</font></b>");
}
$_GET['ID'] = abs((int) $_GET['ID']);
print 
        "<table width=75% border=2><tr><td><a href='mailbox.php?action=inbox'>Inbox</a></td> <td><a href='mailbox.php?action=outbox'>Sent Messages</a></td> <td><a href='mailbox.php?action=compose'>Compose Message</a></td> <td><a href='mailbox.php?action=delall'>Delete All Messages</a></td> <td><a href='mailbox.php?action=archive'>Archive Messages</a></td></tr> </table><br />";
switch ($_GET['action'])
{
case 'inbox':
    mail_inbox();
    break;

case 'outbox':
    mail_outbox();
    break;

case 'compose':
    mail_compose();
    break;

case 'delete':
    mail_delete();
    break;

case 'send':
    mail_send();
    break;

case 'delall':
    mail_delall();
    break;

case 'delall2':
    mail_delall2();
    break;

case 'archive':
    mail_archive();
    break;

default:
    mail_inbox();
    break;
}

function mail_inbox()
{
    global $ir, $c, $userid, $h;
    print 
            "Only the last 25 messages sent to you are visible.<br />
<table width=75% border=2><tr style='background:gray'><th>From</th><th>Subject/Message</th></tr>";
    $q =
            mysql_query(
                    "SELECT m.*,u.* FROM mail m LEFT JOIN users u ON m.mail_from=u.userid WHERE m.mail_to=$userid ORDER BY mail_time DESC LIMIT 25",
                    $c);
    while ($r = mysql_fetch_array($q))
    {
        $sent = date('F j, Y, g:i:s a', $r['mail_time']);
        print "<tr><td>";
        if ($r['userid'])
        {
            print 
                    "<a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> [{$r['userid']}]";
        }
        else
        {
            print "SYSTEM";
        }
        $fm = urlencode($r['mail_text']);
        print 
                "</td>\n<td>{$r['mail_subject']}</td></tr><tr><td>Sent at: $sent<br /><a href='mailbox.php?action=compose&ID={$r['userid']}'>Reply</a><br />
<a href='mailbox.php?action=delete&ID={$r['mail_id']}'>Delete</a> <br />
<a href='preport.php?ID={$r['userid']}&amp;report=Fradulent mail: {$fm}'>Report</a></td><td>{$r['mail_text']}</td></tr>";
    }
    mysql_query("UPDATE mail SET mail_read=1 WHERE mail_to=$userid", $c);

}

function mail_outbox()
{
    global $ir, $c, $userid, $h;
    print 
            "Only the last 25 messages you have sent are visible.<br />
<table width=75% border=2><tr style='background:gray'><th>To</th><th>Subject/Message</th></tr>";
    $q =
            mysql_query(
                    "SELECT m.*,u.* FROM mail m LEFT JOIN users u ON m.mail_to=u.userid WHERE m.mail_from=$userid ORDER BY mail_time DESC LIMIT 25",
                    $c);
    while ($r = mysql_fetch_array($q))
    {
        $sent = date('F j, Y, g:i:s a', $r['mail_time']);
        print 
                "<tr><td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> [{$r['userid']}]</td><td>{$r['mail_subject']}</td></tr><tr><td>Sent at: $sent<br /></td><td>{$r['mail_text']}</td></tr>";
    }

}

function mail_compose()
{
    global $ir, $c, $userid, $h;
    print 
            "<form action='mailbox.php?action=send' method='post'>
<table width=75% border=2> <tr>
<td>ID to send to:</td> <td><input type='text' name='userid' value='{$_GET['ID']}' /></td></tr><tr>
<td>Subject:</td> <td><input type='text' name='subject' /></td></tr><tr>
<td>Message:</td>
<td><textarea rows=5 cols=40 name='message'></textarea></td></tr><tr> <td colspan=2><input type='submit' value='Send' /></td></tr></table></form>";
    if ($_GET['ID'])
    {
        print 
                "<br /><table width=75% border=2><tr><td colspan=2><b>Your last 5 mails to/from this person:</b></td></tr>";
        $q =
                mysql_query(
                        "SELECT m.*,u1.username as sender from mail m left join users u1 on m.mail_from=u1.userid WHERE (m.mail_from=$userid AND m.mail_to={$_GET['ID']}) OR (m.mail_to=$userid AND m.mail_from={$_GET['ID']}) ORDER BY m.mail_time DESC LIMIT 5",
                        $c);
        while ($r = mysql_fetch_array($q))
        {
            $sent = date('F j, Y, g:i:s a', $r['mail_time']);
            print 
                    "<tr><td>$sent</td> <td><b>{$r['sender']} wrote:</b> {$r['mail_text']}</td></tr>";
        }
        print "</table>";
    }
}

function mail_send()
{
    global $ir, $c, $userid, $h;
    $subj =
            mysql_real_escape_string(
                    str_replace(array("\n"), array("<br />"),
                            htmlentities(
                                    stripslashes(strip_tags($_POST['subject'])),
                                    ENT_QUOTES, 'ISO-8859-1')), $c);
    $msg =
            mysql_real_escape_string(
                    str_replace(array("\n"), array("<br />"),
                            htmlentities(
                                    stripslashes(strip_tags($_POST['message'])),
                                    ENT_QUOTES, 'ISO-8859-1')), $c);
    $to = (int) $_POST['userid'];
    mysql_query(
            "INSERT INTO mail VALUES(NULL,0,$userid,$to," . time()
                    . ",'$subj','$msg')", $c) or die(mysql_error());
    print "Message sent.<br />
<a href='mailbox.php'>&gt; Back</a>";
}

function mail_delete()
{
    global $ir, $c, $userid, $h;
    mysql_query(
            "DELETE FROM mail WHERE mail_id={$_GET['ID']} AND mail_to=$userid",
            $c);
    print "Message deleted.<br />
<a href='mailbox.php'>&gt; Back</a>";
}

function mail_delall()
{
    global $ir, $c, $userid, $h;
    print 
            "This will delete all the messages in your inbox.<br />
There is <b>NO</b> undo, so be sure.<br />
<a href='mailbox.php?action=delall2'>&gt; Yes, delete all messages</a><br />
<a href='mailbox.php'>&gt; No, go back</a>";
}

function mail_delall2()
{
    global $ir, $c, $userid, $h;
    mysql_query("DELETE FROM mail WHERE mail_to='$userid'", $c);
    print 
            "All " . mysql_affected_rows($c)
                    . " mails in your inbox were deleted.<br />
<a href='mailbox.php'>&gt; Back</a>";
}

function mail_archive()
{
    global $ir, $c, $userid, $h;
    print 
            "This tool will download an archive of all your messages.<br />
<a href='dlarchive.php?a=inbox'>&gt; Download Inbox</a><br />
<a href='dlarchive.php?a=outbox'>&gt; Download Outbox</a>";
}
$h->endpage();
