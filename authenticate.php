<?php

session_start();
if ($_POST['username'] == "" || $_POST['password'] == "")
{
    die(
            "<h3>breakthenet Error</h3>
You did not fill in the login form!<br />
<a href=login.php>&gt; Back</a>");
}
include "mysql.php";
require "global_func.php";
$username =
        (array_key_exists('username', $_POST) && is_string($_POST['username']))
                ? $_POST['username'] : '';
$password =
        (array_key_exists('password', $_POST) && is_string($_POST['password']))
                ? $_POST['password'] : '';
if (empty($username) || empty($password))
{
    die(
            "<h3>breakthenet Error</h3>
	You did not fill in the login form!<br />
	<a href='login.php'>&gt; Back</a>");
}
$form_username = mysql_real_escape_string(stripslashes($username), $c);
$raw_password = stripslashes($password);
$uq =
        mysql_query(
                "SELECT `userid`, `userpass`, `pass_salt`
                 FROM `users`
                 WHERE `login_name` = '$form_username'", $c);
if (mysql_num_rows($uq) == 0)
{
    die(
            "<h3>breakthenet Error</h3>
	Invalid username or password!<br />
	<a href='login.php'>&gt; Back</a>");
}
else
{
    $mem = mysql_fetch_assoc($uq);
    $login_failed = false;
    // Pass Salt generation: autofix
    if (empty($mem['pass_salt']))
    {
        if (md5($raw_password) != $mem['userpass'])
        {
            $login_failed = true;
        }
        $salt = generate_pass_salt();
        $enc_psw = encode_password($mem['userpass'], $salt, true);
        $e_salt = mysql_real_escape_string($salt, $c); // in case of changed salt function
        $e_encpsw = mysql_real_escape_string($enc_psw, $c); // ditto for password encoder
        mysql_query(
                "UPDATE `users`
        		 SET `pass_salt` = '{$e_salt}', `userpass` = '{$e_encpsw}'
        		 WHERE `userid` = {$mem['userid']}", $c);
    }
    else
    {
        $login_failed =
                !(verify_user_password($raw_password, $mem['pass_salt'],
                        $mem['userpass']));
    }
    if ($login_failed)
    {
        die(
                "<h3>breakthenet Error</h3>
		Invalid username or password!<br />
		<a href='login.php'>&gt; Back</a>");
    }
    if ($mem['userid'] == 1 && file_exists('./installer.php'))
    {
        die(
                "<h3>breakthenet Error</h3>
                The installer still exists! You need to delete installer.php immediately.<br />
                <a href='login.php'>&gt; Back</a>");
    }
    session_regenerate_id();
    $_SESSION['loggedin'] = 1;
    $_SESSION['userid'] = $mem['userid'];
    $loggedin_url = 'http://' . determine_game_urlbase() . '/loggedin.php';
    header("Location: {$loggedin_url}");
    exit;
}

