<?php

session_start();
require "mysql.php";
global $c;
if (!$_SESSION['userid'])
{
    header("Location: login.php");
    exit;
}
$userid = $_SESSION['userid'];
if ($_GET['a'] == 'inbox')
{
    // We'll be outputting a PDF
    header('Content-type: text/html');

    // It will be called downloaded.pdf
    header(
            'Content-Disposition: attachment; filename="inbox_archive_'
                    . $userid . '_' . time() . '.htm"');
    print
            "<table width=75% border=2><tr style='background:gray'><th>From</th><th>Subject/Message</th></tr>";
    $q =
            mysql_query(
                    "SELECT m.*,u.* FROM mail m LEFT JOIN users u ON m.mail_from=u.userid WHERE m.mail_to=$userid ORDER BY mail_time DESC ",
                    $c);
    while ($r = mysql_fetch_array($q))
    {
        $sent = date('F j, Y, g:i:s a', $r['mail_time']);
        print "<tr><td>";
        if ($r['userid'])
        {
            print "{$r['username']} [{$r['userid']}]";
        }
        else
        {
            print "SYSTEM";
        }
        print
                "</td>\n<td>{$r['mail_subject']}</td></tr><tr><td>Sent at: $sent<br /> </td><td>{$r['mail_text']}</td></tr>";
    }
    print "</table>";
}
else if ($_GET['a'] == 'outbox')
{
    // We'll be outputting a PDF
    header('Content-type: text/html');

    // It will be called downloaded.pdf
    header(
            'Content-Disposition: attachment; filename="outbox_archive_'
                    . $userid . '_' . time() . '.htm"');
    print
            "<table width=75% border=2><tr style='background:gray'><th>To</th><th>Subject/Message</th></tr>";
    $q =
            mysql_query(
                    "SELECT m.*,u.* FROM mail m LEFT JOIN users u ON m.mail_to=u.userid WHERE m.mail_from=$userid ORDER BY mail_time DESC",
                    $c);
    while ($r = mysql_fetch_array($q))
    {
        $sent = date('F j, Y, g:i:s a', $r['mail_time']);
        print
                "<tr><td>{$r['username']} [{$r['userid']}]</td><td>{$r['mail_subject']}</td></tr><tr><td>Sent at: $sent<br /></td><td>{$r['mail_text']}</td></tr>";
    }
    print "</table>";
}
