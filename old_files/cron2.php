<?php

/**
*
* "Login-Script" is a copyrighted service from Inculutus Ltd. It remains the property of it's original author: Areeb.
*
*
* This file is part of Login-Script. Please don't reproduce any part of the script without the permissions of Areeb.
*
* Please contact: hello[at]areebmajeed[dot]me for queries.
*
* Copyrighted 2015 - Inculutus (Areeb)
*
*/

if(version_compare(PHP_VERSION, '5.3.7', '<')) {
exit('Sorry, this script does not run on a PHP version smaller than 5.3.7!');
} elseif (version_compare(PHP_VERSION, '5.5.0', '<')) {
require_once('libraries/password_compatibility_library.php');
}

require_once('functions/Core.php');
require_once('config/config.php');
require_once('libraries/PHPMailer.php');

$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

require_once('functions/init.php');

if(filterData($_GET['key']) == settings("cronKey")) {

mysqli_query($con,"UPDATE users SET api_queries_today = 0 WHERE api_queries_today <> 0");
mysqli_query($con,"UPDATE users SET snakes_today = 0 WHERE snakes_today <> 0");
mysqli_query($con,"OPTIMIZE TABLE `account_groups`, `ban_logs`, `categories`, `chat`, `dice_wins`, `email_updates`, `posts`, `raffle_rounds`, `read_history`, `roll_wins`, `rounds_allocation`, `round_winners`, `settings`, `topics`, `users`");

}

mysqli_close($con);