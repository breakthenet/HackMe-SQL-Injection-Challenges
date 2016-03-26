<?php

session_start();
require "mysql.php";
require "global_func.php";
print 
        <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/game.css" type="text/css" rel="stylesheet" />
<title>breakthenet</title>
</head>
<body onload="getme();" bgcolor="#C3C3C3">
<img src="logo.png" alt="Your Game Logo" />
<br />
EOF;
$ip = ($_SERVER['REMOTE_ADDR']);
if (file_exists('ipbans/' . $ip))
{
    die(
            "<b><span style='color: red; font-size: 120%'>
            Your IP has been banned, there is no way around this.
            </span></b>
            </body></html>");
}
if ($_POST['username'])
{
    $sm = 1000;
    if ($_POST['promo'] == "Your Promo Code Here")
    {
        $sm += 1000;
    }
    $username = $_POST['username'];
    $username =
            mysql_real_escape_string(
                    htmlentities(stripslashes($username), ENT_QUOTES,
                            'ISO-8859-1'), $c);
    $q = mysql_query("SELECT * FROM users WHERE username='{$username}'", $c);
    if (mysql_num_rows($q))
    {
        print "Username already in use. Choose another.";
    }
    else if ($_POST['password'] != $_POST['cpassword'])
    {
        print "The passwords did not match, go back and try again.";
    }
    else
    {
        $_POST['ref'] = abs((int) $_POST['ref']);
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($_POST['ref'])
        {
            $q =
                    mysql_query(
                            "SELECT `lastip`
                             FROM `users`
                             WHERE `userid` = {$_POST['ref']}", $c);
            if (mysql_num_rows($q) == 0)
            {
                mysql_free_result($q);
                echo "Referrer does not exist.<br />
				&gt; <a href='register.php'>Back</a>";
                die('</body></html>');
            }
            $rem_IP = mysql_result($q, 0, 0);
            mysql_free_result($q);
            if ($rem_IP == $ip)
            {
                echo "No creating referral multies.<br />
				&gt; <a href='register.php'>Back</a>";
                die('</body></html>');
            }
        }
        mysql_query(
                "INSERT INTO users (username, login_name, userpass, level, money, crystals, donatordays, user_level, energy, maxenergy, will, maxwill, brave, maxbrave, hp, maxhp, location, gender, signedup, email, bankmoney, lastip) VALUES( '{$username}', '{$username}', md5('{$_POST['password']}'), 1, $sm, 0, 0, 1, 12, 12, 100, 100, 5, 5, 100, 100, 1, 'Male', "
                        . time() . ", '{$_POST['email']}', -1, '$ip')", $c);
        $i = mysql_insert_id($c);
        mysql_query("INSERT INTO userstats VALUES($i, 10, 10, 10, 10, 10)", $c);

        if ($_POST['ref'])
        {
            mysql_query(
                    "UPDATE `users`
                    SET `crystals` = `crystals` + 2
                    WHERE `userid` = {$_POST['ref']}");
            event_add($_POST['ref'],
                    "For refering $username to the game, you have earnt 2 valuable crystals!",
                    $c);
            $e_rip = mysql_real_escape_string($rem_IP, $c);
            $e_oip = mysql_real_escape_string($ip, $c);
            mysql_query(
                    "INSERT INTO `referals`
                    VALUES(NULL, {$_POST['ref']}, $i, " . time()
                            . ", '{$e_rip}', '$e_oip')", $c);
        }
        print 
                "You have signed up, enjoy the game.<br />
&gt; <a href='login.php'>Login</a>";
    }
}
else
{
    $gref = abs((int) $_GET['REF']);
    $fref = $gref ? $gref : '';
    echo <<<EOF
    <h3>
      breakthenet Registration
    </h3>
    <form action="register.php" method="post">
      Username: <input type="text" name="username" /><br />
      Password: <input type="password" name="password" /><br />
      Confirm Password: <input type="password" name="cpassword" /><br />
      Email: <input type="text" name="email" /><br />
      Promo Code: <input type="text" name="promo" /><br />
      <input type="hidden" name="ref" value='{$fref}' />
      <input type="submit" value="Submit" />
    </form><br />
    &gt; <a href='login.php'>Go Back</a>
EOF;
}
print "</body></html>";
