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
if ($ir['user_level'] != 2 && $ir['user_level'] != 3 && $ir['user_level'] != 5)
{
    print "You sneak, get out of here!";
    $h->endpage();
    exit;
}
$posta = mysql_real_escape_string(print_r($_POST, 1), $c);
$geta = mysql_real_escape_string(print_r($_GET, 1), $c);
mysql_query(
        "INSERT INTO seclogs VALUES(NULL, $userid, '$posta', '$geta', "
                . time() . " )", $c);

// Stuff that all staff can do
$actions = array();
$actions['fedform'] = 'fed_user_form';
$actions['fedsub'] = 'fed_user_submit';
$actions['unfedform'] = 'unfed_user_form';
$actions['unfedsub'] = 'unfed_user_submit';
$actions['atklogs'] = 'view_attack_logs';
$actions['ipform'] = 'ip_search_form';
$actions['ipsub'] = 'ip_search_submit';
$actions['massjailip'] = 'mass_jail';
$actions['itmlogs'] = 'view_itm_logs';
$actions['cashlogs'] = 'view_cash_logs';
// Stuff that a secretary or admin can do
if ($ir['user_level'] == 2 || $ir['user_level'] == 3)
{
    $actions['giveitem'] = 'give_item_form';
    $actions['giveitemsub'] = 'give_item_submit';
    $actions['mailform'] = 'mail_user_form';
    $actions['mailsub'] = 'mail_user_submit';
    $actions['invbeg'] = 'inv_user_begin';
    $actions['invuser'] = 'inv_user_view';
    $actions['deleinv'] = 'inv_delete';
    $actions['creditform'] = 'credit_user_form';
    $actions['creditsub'] = 'credit_user_submit';
    $actions['maillogs'] = 'view_mail_logs';
    $actions['reportsview'] = 'reports_view';
    $actions['repclear'] = 'report_clear';
}

// Stuff that only admins can do
if ($ir['user_level'] == 2)
{
    $actions['newuser'] = 'new_user_form';
    $actions['newusersub'] = 'new_user_submit';
    $actions['newitem'] = 'new_item_form';
    $actions['newitemsub'] = 'new_item_submit';
    $actions['killitem'] = 'kill_item_form';
    $actions['killitemsub'] = 'kill_item_submit';
    $actions['edititem'] = 'edit_item_begin';
    $actions['edititemform'] = 'edit_item_form';
    $actions['edititemsub'] = 'edit_item_sub';
    $actions['newshop'] = 'new_shop_form';
    $actions['newshopsub'] = 'new_shop_submit';
    $actions['newstock'] = 'new_stock_form';
    $actions['newstocksub'] = 'new_stock_submit';
    $actions['edituser'] = 'edit_user_begin';
    $actions['edituserform'] = 'edit_user_form';
    $actions['editusersub'] = 'edit_user_sub';
    $actions['fedeform'] = 'fed_edit_form';
    $actions['fedesub'] = 'fed_edit_submit';
    $actions['editnews'] = 'newspaper_form';
    $actions['subnews'] = 'newspaper_submit';
    $actions['editadnews'] = 'adnewspaper_form';
    $actions['subadnews'] = 'adnewspaper_submit';
    $actions['donator'] = 'donators_list';
    $actions['acceptdp'] = 'accept_dp';
    $actions['declinedp'] = 'decline_dp';
    $actions['givedpform'] = 'give_dp_form';
    $actions['givedpsub'] = 'give_dp_submit';
    $actions['stafflist'] = 'staff_list';
    $actions['userlevel'] = 'userlevel';
    $actions['userlevelform'] = 'userlevelform';
    $actions['massmailer'] = 'massmailer';
    $actions['record'] = 'admin_user_record';
    $actions['change_id'] = 'admin_user_changeid';
}

// Check their action
if (isset($_GET['action']) && isset($actions[$_GET['action']]))
{
    define('IN_STAFF', true);
    require_once('new_staff_actions.php');
    $action_name = $actions[$_GET['action']];
    $action_name();
}
else
{
    switch ($ir['user_level'])
    {
    case 2:
        admin_index();
        break;
    case 3:
        sec_index();
        break;
    case 5:
        ass_index();
        break;
    }
}

function admin_index()
{
    global $ir, $c, $userid;
    print 
            "Welcome to the breakthenet admin panel, <b>{$ir['username']}!</b><br />";
    echo <<<EOF
    <table width='90%' border='1' cellspacing='1' cellpadding='2'>
    	<tr style='background-color: black; color: white;'>
    		<th>Users</th>
    		<th>Shops</th>
    		<th>News</th>
    	</tr>
    	<tr>
    		<td rowspan='3'>
    			&gt; <a href='new_staff.php?action=newuser'>Create New User</a><br />
                &gt; <a href='new_staff.php?action=edituser'>Edit User</a><br />
                &gt; <a href='new_staff.php?action=mailform'>Mail Ban User</a><br />
                &gt; <a href='new_staff.php?action=fedform'>Jail User</a><br />
                &gt; <a href='new_staff.php?action=fedeform'>Edit Fedjail Sentence</a><br />
                &gt; <a href='new_staff.php?action=unfedform'>Unjail User</a><br />
                &gt; <a href='new_staff.php?action=invbeg'>View User Inventory</a><br />
                &gt; <a href='new_staff.php?action=creditform'>Credit User Money/Crystals</a><br />
                &gt; <a href='new_staff.php?action=ipform'>Ip Search</a><br />
                &gt; <a href='new_staff.php?action=reportsview'>Player Reports</a><br />
            </td>
            <td>
            	&gt; <a href='new_staff.php?action=newshop'>Create New Shop</a><br />
				&gt; <a href='new_staff.php?action=newstock'>Add Item To Shop</a><br />
			</td>
			<td rowspan='3'>
EOF;
    include 'admin.news';
    $versq = mysql_query("SELECT VERSION()");
    $mv = mysql_result($versq, 0, 0);
    mysql_free_result($versq);
    $versionno = intval('11003');
    $version = '1.1.0c';
    $phpv = phpversion();
    $critical_files =
            array('installer.php', 'installer_head.php', 'installer_foot.php',
                    'dbdata.sql');
    $have_files = array();
    foreach ($critical_files as $test_file)
    {
        if (file_exists('./' . $test_file))
        {
            $have_files[] = $test_file;
        }
    }
    $critical_error = '';
    if (count($have_files) > 0)
    {
        $errfiles = implode(', ', $have_files);
        $critical_error =
                <<<EOF
        <br />
        <div style="border: 2px solid red; background-color: #FF6666; color: black; width: 75%;">
            <h3>WARNING!</h3>
            The following system-critical files still exist: {$errfiles}<br />
            It is HIGHLY recommended that you delete these files immediately to
            avoid your game being hacked.
        </div>
EOF;
    }
    echo <<<EOF
    		</td>
    	</tr>
    	<tr style='background-color: black; color: white; height: 10pt;'>
    		<th>Misc.</th>
    	</tr>
    	<tr>
    		<td>
    			&gt; <a href='new_staff.php?action=editnews'>Edit Newspaper</a><br />
				&gt; <a href='new_staff.php?action=massmailer'>Mass Mailer</a><br />
			</td>
		</tr>
		<tr style='background-color: black; color: white;'>
    		<th>Items</th>
    		<th>Logs</th>
    		<th>System Info</th>
    	</tr>
    	<tr>
    		<td>
    			&gt; <a href='new_staff.php?action=newitem'>Create New Item</a><br />
    			&gt; <a href='new_staff.php?action=giveitem'>Give Item To User</a><br />
    			&gt; <a href='new_staff.php?action=edititem'>Edit Item</a><br />
    			&gt; <a href='new_staff.php?action=killitem'>Delete An Item</a><br />
    		</td>
    		<td>
    			&gt; <a href='new_staff.php?action=atklogs'>Attack Logs</a><br />
    			&gt; <a href='new_staff.php?action=cashlogs'>Cash Xfer Logs</a><br />
    			&gt; <a href='new_staff.php?action=itmlogs'>Item Xfer Logs</a><br />
    			&gt; <a href='new_staff.php?action=maillogs'>Mail Logs</a><br />
    		</td>
    		<td rowspan='3'>
                <table width='75%' cellspacing='1' border='1'>
                		<tr>
                			<th>PHP Version:</th>
                			<td>{$phpv}</td>
                		</tr>
                		<tr>
                			<th>MySQL Version:</th>
                			<td>{$mv}</td>
                		</tr>
                		<tr>
                			<th>Codes Version:</th>
                			<td>{$version} (Build: {$versionno})</td>
                		</tr>
                		<tr>
                			<th>Update Status:</th>
                			<td>
                				<iframe
                					src='http://www.mccodes.com/update_check.php?version={$versionno}&amp;type=free'
                					width='250' height='30'></iframe>
                			</td>
                		</tr>
                </table>
                {$critical_error}
            </td>
        </tr>
        <tr style='background-color: black; color: white;'>
        	<th>Experimental</th>
        	<th>Critical Tools</th>
        </tr>
        <tr>
        	<td>
        		&gt; <a href='new_staff.php?action=record'>User Record</a><br />
        		&gt; <a href='new_staff.php?action=change_id'>Change User's ID</a><br />
        	</td>
        	<td>
    			&gt; <a href='new_staff.php?action=stafflist'>Staff List</a><br />
    			&gt; <a href='new_staff.php?action=userlevelform'>Adjust User Level</a><br />
    			&gt; <a href='new_staff.php?action=donator'>Donator Packs</a><br />
    			&gt; <a href='new_staff.php?action=givedpform'>Give User Donator Pack</a><br />
    			&gt; <a href='new_staff.php?action=editadnews'>Edit Admin News</a><br />
    		</td>
    	</tr>
    </table>
EOF;
}

function sec_index()
{
    global $ir, $c;
    print 
            "Welcome to the breakthenet secretary panel, {$ir['username']}!<br />
<h3><font color=red>Secretary Warning: Any sec who uses their powers without reason will be fired. No second chances.</font></h3><br />
<b>News from the Admins:</b> <br />";
    include "admin.news";
    print 
            "<u>Users</u><br />
[<a href='new_staff.php?action=fedform'>Jail User</a>]<br />
[<a href='new_staff.php?action=unfedform'>Unjail User</a>]<br />
[<a href='new_staff.php?action=mailform'>Mail Ban User</a>]<br />
[<a href='new_staff.php?action=invbeg'>View User Inventory</a>]<br />

[<a href='new_staff.php?action=creditform'>Credit User Money/Crystals</a>]<br />
[<a href='new_staff.php?action=ipform'>Ip Search</a>]<br />
[<a href='new_staff.php?action=reportsview'>Player Reports</a>]<br />
<br />
<u>Items</u><br />
[<a href='new_staff.php?action=giveitem'>Give Item To User</a>]<br />
<br />
<u>Logs</u><br />
[<a href='new_staff.php?action=atklogs'>Attack Logs</a>]<br />
[<a href='new_staff.php?action=cashlogs'>Cash Xfer Logs</a>]<br />
[<a href='new_staff.php?action=itmlogs'>Item Xfer Logs</a>]<br />
[<a href='new_staff.php?action=maillogs'>Mail Logs</a>]";
}

function ass_index()
{
    global $ir, $c;
    print 
            "Welcome to the breakthenet assistant panel, {$ir['username']}!<br />
<h3><font color=red>Assistant Warning: Any assistant who uses their powers without reason will be fired. No second chances.</font></h3><br />
<b>News from the Admins:</b> <br />";
    include "admin.news";
    print 
            "<u>Users</u><br />
[<a href='new_staff.php?action=fedform'>Jail User</a>]<br />
[<a href='new_staff.php?action=unfedform'>Unjail User</a>]<br />
[<a href='new_staff.php?action=ipform'>Ip Search</a>]<br />
<br />
<u>Logs</u><br />
[<a href='new_staff.php?action=atklogs'>Attack Logs</a>]<br />
[<a href='new_staff.php?action=cashlogs'>Cash Xfer Logs</a>]<br />
[<a href='new_staff.php?action=itmlogs'>Item Xfer Logs</a>]";
}

$h->endpage();
