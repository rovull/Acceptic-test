<?php
require_once 'classes/User.php';
require_once 'classes/User_tools.php';
require_once 'classes/DB.php';

//connect to the database
$db = new DB();
$db -> connect();


//initialize UserTools object
$user_tools = new User_tools();

session_start();
//refresh session variables if logged in
if(isset($_SESSION['logged_in'])) {

    $user = unserialize($_SESSION['user']);
    $_SESSION['user'] = serialize($user_tools->get($user->id));
}