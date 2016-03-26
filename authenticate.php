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
    $login_failed = !(verify_user_password($raw_password, $mem['userpass']));
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

