<?php

if (strpos($_SERVER['PHP_SELF'], "header.php") !== false)
{
    exit;
}

class headers
{

    function startheaders()
    {
        global $ir;
        echo <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/game.css" type="text/css" rel="stylesheet" />
<title>breakthenet</title>
</head>
<body style='background-color: #C3C3C3;'>

EOF;
    }

    function userdata($ir, $lv, $fm, $cm, $dosessh = 1)
    {
        global $c, $userid;
        $ip = ($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        mysql_query(
                "UPDATE users SET laston=" . time()
                        . ",lastip='$ip' WHERE userid=$userid", $c);
        if (!$ir['email'])
        {
            die(
                    "<body>Your account may be broken. Please mail help@yourgamename.com stating your username and player ID.");
        }
        if ($dosessh && isset($_SESSION['attacking']))
        {
            if ($_SESSION['attacking'] > 0)
            {
                print "You lost all your EXP for running from the fight.";
                mysql_query("UPDATE users SET exp=0 WHERE userid=$userid", $c);
                $_SESSION['attacking'] = 0;
            }
        }
        $enperc = (int) ($ir['energy'] / $ir['maxenergy'] * 100);
        $wiperc = (int) ($ir['will'] / $ir['maxwill'] * 100);
        $experc = (int) ($ir['exp'] / $ir['exp_needed'] * 100);
        $brperc = (int) ($ir['brave'] / $ir['maxbrave'] * 100);
        $hpperc = (int) ($ir['hp'] / $ir['maxhp'] * 100);
        $enopp = 100 - $enperc;
        $wiopp = 100 - $wiperc;
        $exopp = 100 - $experc;
        $bropp = 100 - $brperc;
        $hpopp = 100 - $hpperc;
        $d = "";
        $u = $ir['username'];
        if ($ir['donatordays'])
        {
            $u = "<font color=red>{$ir['username']}</font>";
            $d =
                    "<img src='donator.gif' alt='Donator: {$ir['donatordays']} Days Left' title='Donator: {$ir['donatordays']} Days Left' />";
        }
        print
                "
<table width=100%><tr><td><img src='logo.png'></td>
<td><b>Name:</b> {$u} [{$ir['userid']}] $d<br />
<b>Money:</b> {$fm}<br />
<b>Level:</b> {$ir['level']}<br />
<b>Crystals:</b> {$ir['crystals']}<br />
[<a href='logout.php'>Emergency Logout</a>]</td><td>
<b>Energy:</b> {$enperc}%<br />
<img src=bargreen.gif width=$enperc height=10><img src=barred.gif width=$enopp height=10><br />
<b>Will:</b> {$wiperc}%<br />
<img src=bargreen.gif width=$wiperc height=10><img src=barred.gif width=$wiopp height=10><br />
<b>Brave:</b> {$ir['brave']}/{$ir['maxbrave']}<br />
<img src=bargreen.gif width=$brperc height=10><img src=barred.gif width=$bropp height=10><br />
<b>EXP:</b> {$experc}%<br />
<img src=bargreen.gif width=$experc height=10><img src=barred.gif width=$exopp height=10><br />
<b>Health:</b> {$hpperc}%<br />
<img src=bargreen.gif width=$hpperc height=10><img src=barred.gif width=$hpopp height=10></td></tr></table></div><center><b><u><a href='voting.php'>Vote for breakthenet on various gaming sites and be rewarded!</a></u></b></center><br />
<center><b><u><a href='donator.php'>Donate to breakthenet, it's only \$3 and gets you a lot of benefits!</a></u></b></center><br />
                ";
        $q = mysql_query("SELECT * FROM ads ORDER BY rand() LIMIT 1", $c);
        if (mysql_num_rows($q))
        {
            $r = mysql_fetch_array($q);
            print
                    "<center><a href='ad.php?ad={$r['adID']}'><img src='{$r['adIMG']}' alt='Paid Advertisement' /></a></center><br />";
            mysql_query(
                    "UPDATE ads SET adVIEWS=adVIEWS+1 WHERE adID={$r['adID']}",
                    $c);
        }
        print "<table width=100%><tr><td width=20% valign='top'>
";
        if ($ir['fedjail'])
        {
            $q =
                    mysql_query(
                            "SELECT * FROM fedjail WHERE fed_userid=$userid",
                            $c);
            $r = mysql_fetch_array($q);
            die(
                    "<b><font color=red size=+1>You have been put in the breakthenet Federal Jail for {$r['fed_days']} day(s).<br />
Reason: {$r['fed_reason']}</font></b></body></html>");
        }
        if (file_exists('ipbans/' . $ip))
        {
            die(
                    "<b><font color=red size=+1>Your IP has been banned, there is no way around this.</font></b></body></html>");
        }
    }

    function menuarea()
    {
        include "mainmenu.php";
        global $ir, $c;
        print "</td><td valign='top'>
";
    }

    function endpage()
    {
        $year = date('Y');
        print
                "</td></tr></table>
        <div style='font-style: italic; text-align: center'>
      		Powered by codes made by Dabomstew. Copyright &copy; {$year} admin.
    	</div>
        </body>
		</html>";
    }
}
