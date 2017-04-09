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

// Check for round wins:

$date = date("Y-m-d H:i:s");

$load = mysqli_query($con,"SELECT * FROM raffle_rounds WHERE '{$date}' >= end AND status = 0 ORDER BY id DESC LIMIT 1");

if(mysqli_num_rows($load) > 0.99) {
	
$r = mysqli_fetch_array($load);

mysqli_query($con,"UPDATE raffle_rounds SET status = 1 WHERE id = {$r['id']}");

$form_luck = 0;

$form_luck = mt_rand(1,5);

$total_amount_pool = $r['tickets_allocated'] * settings("ticketCost");
$first_v = sprintf("%.8f",($r['first'] / 100) * $total_amount_pool);
$second_v = sprintf("%.8f",($r['second'] / 100) * $total_amount_pool);
$third_v = sprintf("%.8f",($r['third'] / 100) * $total_amount_pool);
$fourth_v = sprintf("%.8f",($r['fourth'] / 100) * $total_amount_pool);
$fifth_v = sprintf("%.8f",($r['fifth'] / 100) * $total_amount_pool);
$sixth_v = sprintf("%.8f",($r['sixth'] / 100) * $total_amount_pool);
$seventh_v = sprintf("%.8f",($r['seventh'] / 100) * $total_amount_pool);
$eighth_v = sprintf("%.8f",($r['eighth'] / 100) * $total_amount_pool);
$nineth_v = sprintf("%.8f",($r['nineth'] / 100) * $total_amount_pool);
$tenth_v = sprintf("%.8f",($r['tenth'] / 100) * $total_amount_pool);
	
$l_u = mysqli_query($con,"SELECT * FROM rounds_allocation WHERE round_id = {$r['id']} AND tickets >= {$form_luck}");

$winners_array = array();

while($u = mysqli_fetch_array($l_u)) {
	
$winners_array[] = $u['user_id'];
	
}

shuffle($winners_array);
shuffle($winners_array);
shuffle($winners_array);
shuffle($winners_array);
shuffle($winners_array);

$winners = array_slice($winners_array, 0, 10);

shuffle($winners);
shuffle($winners);
shuffle($winners);
shuffle($winners);
shuffle($winners);

foreach($winners as $key => $value) {
	
if($key == 0) {
	
$first = $value;
$rr = mysqli_fetch_array(mysqli_query($con,"SELECT tickets FROM rounds_allocation WHERE user_id = {$value} AND round_id = {$r['id']}"));
$first_t = $rr['tickets'];

mysqli_query($con,"UPDATE users SET balance = balance + {$first_v} WHERE user_id = {$value}");

$body = "Hello,

<br>
<br>

We congratulate you on your position at our raffle contest. You have reached the 1st level, and won a prize of " . $first_v . " BTC.

<br>
<br>
Regards,
<br>" . 
$website_name;

sendMail(loadAccDetails("user_id",$value,"user_email"), "You have won the raffle round #" . $r['id'], $body);
	
} if($key == 1) {
	
$second = $value;
$rr = mysqli_fetch_array(mysqli_query($con,"SELECT tickets FROM rounds_allocation WHERE user_id = {$value} AND round_id = {$r['id']}"));
$second_t = $rr['tickets'];
	
mysqli_query($con,"UPDATE users SET balance = balance + {$second_v} WHERE user_id = {$value}");

$body = "Hello,

<br>
<br>

We congratulate you on your position at our raffle contest. You have reached the 2nd level, and won a prize of " . $second_v . " BTC.

<br>
<br>
Regards,
<br>" . 
$website_name;

sendMail(loadAccDetails("user_id",$value,"user_email"), "You have won the raffle round #" . $r['id'], $body);
	
} if($key == 2) {
	
$third = $value;
$rr = mysqli_fetch_array(mysqli_query($con,"SELECT tickets FROM rounds_allocation WHERE user_id = {$value} AND round_id = {$r['id']}"));
$third_t = $rr['tickets'];

mysqli_query($con,"UPDATE users SET balance = balance + {$third_v} WHERE user_id = {$value}");

$body = "Hello,

<br>
<br>

We congratulate you on your position at our raffle contest. You have reached the 3rd level, and won a prize of " . $third_v . " BTC.

<br>
<br>
Regards,
<br>" . 
$website_name;

sendMail(loadAccDetails("user_id",$value,"user_email"), "You have won the raffle round #" . $r['id'], $body);
	
} if($key == 3) {
	
$fourth = $value;
$rr = mysqli_fetch_array(mysqli_query($con,"SELECT tickets FROM rounds_allocation WHERE user_id = {$value} AND round_id = {$r['id']}"));
$fourth_t = $rr['tickets'];

mysqli_query($con,"UPDATE users SET balance = balance + {$fourth_v} WHERE user_id = {$value}");

$body = "Hello,

<br>
<br>

We congratulate you on your position at our raffle contest. You have reached the 4th level, and won a prize of " . $fourth_v . " BTC.

<br>
<br>
Regards,
<br>" . 
$website_name;

sendMail(loadAccDetails("user_id",$value,"user_email"), "You have won the raffle round #" . $r['id'], $body);
	
} if($key == 4) {
	
$fifth = $value;
$rr = mysqli_fetch_array(mysqli_query($con,"SELECT tickets FROM rounds_allocation WHERE user_id = {$value} AND round_id = {$r['id']}"));
$fifth_t = $rr['tickets'];

mysqli_query($con,"UPDATE users SET balance = balance + {$fifth_v} WHERE user_id = {$value}");

$body = "Hello,

<br>
<br>

We congratulate you on your position at our raffle contest. You have reached the 5th level, and won a prize of " . $fifth_v . " BTC.

<br>
<br>
Regards,
<br>" . 
$website_name;

sendMail(loadAccDetails("user_id",$value,"user_email"), "You have won the raffle round #" . $r['id'], $body);
	
} if($key == 5) {
	
$sixth = $value;
$rr = mysqli_fetch_array(mysqli_query($con,"SELECT tickets FROM rounds_allocation WHERE user_id = {$value} AND round_id = {$r['id']}"));
$sixth_t = $rr['tickets'];

mysqli_query($con,"UPDATE users SET balance = balance + {$sixth_v} WHERE user_id = {$value}");

$body = "Hello,

<br>
<br>

We congratulate you on your position at our raffle contest. You have reached the 6th level, and won a prize of " . $sixth_v . " BTC.

<br>
<br>
Regards,
<br>" . 
$website_name;

sendMail(loadAccDetails("user_id",$value,"user_email"), "You have won the raffle round #" . $r['id'], $body);
	
} if($key == 6) {
	
$seventh = $value;
$rr = mysqli_fetch_array(mysqli_query($con,"SELECT tickets FROM rounds_allocation WHERE user_id = {$value} AND round_id = {$r['id']}"));
$seventh_t = $rr['tickets'];

mysqli_query($con,"UPDATE users SET balance = balance + {$seventh_v} WHERE user_id = {$value}");

$body = "Hello,

<br>
<br>

We congratulate you on your position at our raffle contest. You have reached the 7th level, and won a prize of " . $seventh_v . " BTC.

<br>
<br>
Regards,
<br>" . 
$website_name;

sendMail(loadAccDetails("user_id",$value,"user_email"), "You have won the raffle round #" . $r['id'], $body);
	
} if($key == 7) {
	
$eighth = $value;
$rr = mysqli_fetch_array(mysqli_query($con,"SELECT tickets FROM rounds_allocation WHERE user_id = {$value} AND round_id = {$r['id']}"));
$eighth_t = $rr['tickets'];

mysqli_query($con,"UPDATE users SET balance = balance + {$eighth_v} WHERE user_id = {$value}");

$body = "Hello,

<br>
<br>

We congratulate you on your position at our raffle contest. You have reached the 8th level, and won a prize of " . $eighth_v . " BTC.

<br>
<br>
Regards,
<br>" . 
$website_name;

sendMail(loadAccDetails("user_id",$value,"user_email"), "You have won the raffle round #" . $r['id'], $body);
	
} if($key == 8) {
	
$nineth = $value;
$rr = mysqli_fetch_array(mysqli_query($con,"SELECT tickets FROM rounds_allocation WHERE user_id = {$value} AND round_id = {$r['id']}"));
$nineth_t = $rr['tickets'];

mysqli_query($con,"UPDATE users SET balance = balance + {$nineth_v} WHERE user_id = {$value}");

$body = "Hello,

<br>
<br>

We congratulate you on your position at our raffle contest. You have reached the 9th level, and won a prize of " . $nineth_v . " BTC.

<br>
<br>
Regards,
<br>" . 
$website_name;

sendMail(loadAccDetails("user_id",$value,"user_email"), "You have won the raffle round #" . $r['id'], $body);
	
} if($key == 9) {
	
$tenth = $value;
$rr = mysqli_fetch_array(mysqli_query($con,"SELECT tickets FROM rounds_allocation WHERE user_id = {$value} AND round_id = {$r['id']}"));
$tenth_t = $rr['tickets'];

mysqli_query($con,"UPDATE users SET balance = balance + {$tenth_v} WHERE user_id = {$value}");

$body = "Hello,

<br>
<br>

We congratulate you on your position at our raffle contest. You have reached the 10th level, and won a prize of " . $tenth_v . " BTC.

<br>
<br>
Regards,
<br>" . 
$website_name;

sendMail(loadAccDetails("user_id",$value,"user_email"), "You have won the raffle round #" . $r['id'], $body);
	
}

}

mysqli_query($con,"INSERT INTO `round_winners` (`round_id`, `total_tickets`, `first_user`, `first_user_amount`, `first_user_tickets`, `second_user`, `second_user_amount`, `second_user_tickets`, `third_user`, `third_user_amount`, `third_user_tickets`, `fourth_user`, `fourth_user_amount`, `fourth_user_tickets`, `fifth_user`, `fifth_user_amount`, `fifth_user_tickets`, `sixth_user`, `sixth_user_amount`, `sixth_user_tickets`, `seventh_user`, `seventh_user_amount`, `seventh_user_tickets`, `eighth_user`, `eighth_user_amount`, `eighth_user_tickets`, `nineth_user`, `nineth_user_amount`, `nineth_user_tickets`, `tenth_user`, `tenth_user_amount`, `tenth_user_tickets`)
VALUES ({$r['id']}, {$r['tickets_allocated']}, '{$first}', '{$first_v}', '{$first_t}', '{$second}', '{$second_v}', '{$second_t}', '{$third}', '{$third_v}', '{$third_t}', '{$fourth}', '{$fourth_v}', '{$fourth_t}', '{$fifth}', '{$fifth_v}', '{$fifth_t}', '{$sixth}', '{$sixth_v}', '{$sixth_t}', '{$seventh}', '{$seventh_v}', '{$seventh_t}', '{$eighth}', '{$eighth_v}', '{$eighth_t}', '{$nineth}', '{$nineth_v}', '{$nineth_t}', '{$tenth}', '{$tenth_v}', '{$tenth_t}')");

$started = date("Y-m-d H:i:s");
$end = date("Y-m-d H:i:s", strtotime('+' . settings("raffleHours") . ' hours'));
$first_per = settings("raffle_first_per");
$second_per = settings("raffle_second_per");
$third_per = settings("raffle_third_per");
$fourth_per = settings("raffle_fourth_per");
$fifth_per = settings("raffle_fifth_per");
$sixth_per = settings("raffle_sixth_per");
$seventh_per = settings("raffle_seventh_per");
$eighth_per = settings("raffle_eighth_per");
$nineth_per = settings("raffle_nineth_per");
$tenth_per = settings("raffle_tenth_per");

mysqli_query($con,"INSERT INTO raffle_rounds (started,end,first,second,third,fourth,fifth,sixth,seventh,eighth,nineth,tenth) VALUES ('{$started}','{$end}','{$first_per}','{$second_per}','{$third_per}','{$fourth_per}','{$fifth_per}','{$sixth_per}','{$seventh_per}','{$eighth_per}','{$nineth_per}','{$tenth_per}')");

}

}

mysqli_close($con);