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

switch ($_GET['action'])
{
case 'sexchange2':
    do_sex_change();
    break;

case 'sexchange':
    conf_sex_change();
    break;

case 'passchange2':
    do_pass_change();
    break;

case 'passchange':
    pass_change();
    break;

case 'namechange2':
    do_name_change();
    break;

case 'namechange':
    name_change();
    break;

case 'picchange2':
    do_pic_change();
    break;

case 'picchange':
    pic_change();
    break;

default:
    prefs_home();
    break;
}

function prefs_home()
{
    global $ir, $c, $userid, $h;
    print 
            "<h3>Preferences</h3>
<a href='preferences.php?action=sexchange'>Sex Change</a><br />
<a href='preferences.php?action=passchange'>Password Change</a><br />
<a href='preferences.php?action=namechange'>Name Change</a><br />
<a href='preferences.php?action=picchange'>Display Pic Change</a>";
}

function conf_sex_change()
{
    global $ir, $c, $userid, $h;
    if ($ir['gender'] == "Male")
    {
        $g = "Female";
    }
    else
    {
        $g = "Male";
    }
    print 
            "Having the trans-gender costs 20 Crystals.<br />Are you sure you want to become a $g?<br />
<a href='preferences.php?action=sexchange2'>Yes</a> | <a href='preferences.php'>No</a>";
}

function do_sex_change()
{
    global $ir, $c, $userid, $h;
    if ($ir['crystals'] < 20)
    {
        print "You don't have enough crystals!";
        exit;
    }
    else if ($ir['gender'] == "Male")
    {
        $g = "Female";
    }
    else
    {
        $g = "Male";
    }
    mysql_query("UPDATE users SET gender='$g' WHERE userid=$userid", $c);
    mysql_query("UPDATE users SET crystals=crystals-20 WHERE userid=$userid",
            $c);
    mysql_query("UPDATE users SET crystals=0 WHERE crystals<0", $c);
    print "Success, you are now $g!<br />
<a href='preferences.php'>Back</a>";
}

function pass_change()
{
    global $ir, $c, $userid, $h;
    print 
            "<h3>Password Change</h3><form action='preferences.php?action=passchange2' method='post'>Current Password: <input type='password' name='oldpw' /><br />
New Password: <input type='password' name='newpw' /><br />
Confirm: <input type='password' name='newpw2' /><br />
<input type='submit' value='Change PW' /></form>";
}

function do_pass_change()
{
    global $ir, $c, $userid, $h;
    $oldpw = stripslashes($_POST['oldpw']);
    $newpw = stripslashes($_POST['newpw']);
    $newpw2 = stripslashes($_POST['newpw2']);
    if (!verify_user_password($oldpw, $ir['pass_salt'], $ir['userpass']))
    {
        echo "
		The current password you entered was wrong.<br />
		<a href='preferences.php?action=passchange'>&gt; Back</a>
   		";
    }
    else if ($newpw !== $newpw2)
    {
        echo "The new passwords you entered did not match!<br />
		<a href='preferences.php?action=passchange'>&gt; Back</a>";
    }
    else
    {
        // Re-encode password
        $new_psw =
                mysql_real_escape_string(
                        encode_password($newpw, $ir['pass_salt']), $c);
        mysql_query(
                "UPDATE `users`
                 SET `userpass` = '{$new_psw}'
                 WHERE `userid` = {$ir['userid']}", $c);
        echo "Password changed!<br />
        &gt; <a href='preferences.php'>Go Back</a>";
    }
}

function name_change()
{
    global $ir, $c, $userid, $h;
    print 
            "<h3>Name Change</h3>
Changing your name now costs \$3000<br />
Please note that you still use the same name to login, this procedure simply changes the name that is displayed. <form action='preferences.php?action=namechange2' method='post'>
New Name: <input type='text' name='newname' /><br />
<input type='submit' value='Change Name' /></form>";
}

function do_name_change()
{
    global $ir, $c, $userid, $h;
    if ($ir['money'] < 3000)
    {
        print "You don't have enough money!";
        exit;
    }
    else if ($_POST['newname'] == "")
    {
        print 
                "You did not enter a new name.<br />
<a href='preferences.php?action=namechange'>&gt; Back</a>";
    }
    else
    {
        $_POST['newname'] =
                mysql_real_escape_string(
                        htmlentities(stripslashes($_POST['newname']),
                                ENT_QUOTES, 'ISO-8859-1'), $c);
        mysql_query(
                "UPDATE users SET username='{$_POST['newname']}' WHERE userid=$userid",
                $c);
        mysql_query("UPDATE users SET money=money-3000 WHERE userid=$userid",
                $c);
        mysql_query("UPDATE users SET money=0 WHERE money<0", $c);
        print "Username changed!";
    }
}

function pic_change()
{
    global $ir, $c, $userid, $h;
    print 
            "<h3>Pic Change</h3>
Please note that this must be externally hosted, <a href='http://imageshack.us'>ImageShack</a> is our recommendation.<br />
Any images that are not 150x150 will be automatically resized <form action='preferences.php?action=picchange2' method='post'>
New Pic: <input type='text' name='newpic' value='{$ir['display_pic']}' /><br />
<input type='submit' value='Change Pic' /></form>";
}

function do_pic_change()
{
    global $ir, $c, $userid, $h;
    if (empty($_POST['newpic']))
    {
        print 
                "You did not enter a new pic.<br />
<a href='preferences.php?action=picchange'>&gt; Back</a>";
    }
    else
    {
        $npic = stripslashes($_POST['newpic']);
        $sz = get_filesize_remote($npic);
        if ($sz <= 0 || $sz >= 1048576)
        {
            print 
                    "Invalid new pic entered.<br />
            &gt; <a href='preferences.php?action=picchange'>Back</a>";
            $h->endpage();
            exit;
        }
        $image = (@getimagesize($npic));
        if (!is_array($image))
        {
            echo 'Invalid Image.<br />
        	&gt; <a href="preferences.php?action=picchange">Go Back</a>';
            die($h->endpage());
        }
        $esc_npic =
                mysql_real_escape_string(
                        htmlentities($npic, ENT_QUOTES, 'ISO-8859-1'), $c);
        mysql_query(
                "UPDATE users SET display_pic='{$esc_npic}' WHERE userid=$userid",
                $c);
        print "Pic changed!";
    }
}

$h->endpage();
