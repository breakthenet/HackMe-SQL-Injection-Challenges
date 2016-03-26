<?php

if (!isset($_GET['userid']) || !is_numeric($_GET['userid']))
{
    exit;
}
require "global_func.php";
$location =
        'http://' . determine_game_urlbase()
                . '/new_staff.php?action=fedform&XID=' . $_GET['userid'];
header('Location: ' . $location);
exit;
