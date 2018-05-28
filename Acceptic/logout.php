<?php

require_once 'global.inc.php';

$user_tools = new User_tools();
    $user_tools->logout();

header("Location: index.php");