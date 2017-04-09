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

if(UserLoggedIn() == true) {
	
$method = $_GET['method'];
	
if($method == "flip_coin") {

$bet_amount = sprintf("%.8f",filterData($_POST['bet_amount']));
$bet_face = filterData($_POST['bet_face']);
$client_seed = filterData($_POST['client_seed']);
$nonce = filterData($_POST['nonce']);
	
if(!is_numeric($bet_amount) || $bet_amount < settings("coinFlip_minBet")) {
	
$out = array(

"error" => "Your bet amount is lower than the minimum amount to bet.",
"new_balance" => loadAccDetails("user_id",$_SESSION['user_id'],"balance")

);	

echo json_encode($out);

} elseif($bet_amount > settings("coinFlip_maxBet")) {
	
$out = array(

"error" => "Your bet amount is bigger than the maximum amount to bet.",
"new_balance" => loadAccDetails("user_id",$_SESSION['user_id'],"balance")

);	

echo json_encode($out);
	
} elseif($bet_amount > loadAccDetails("user_id",$_SESSION['user_id'],"balance")) {
	
$out = array(

"error" => "Your bet amount is bigger than your available account balance.",
"new_balance" => loadAccDetails("user_id",$_SESSION['user_id'],"balance")

);	

echo json_encode($out);
	
} elseif(!in_array($bet_face,array('head','tail'))) {
	
$out = array(
	
"error" => "Your predicted coin face is not valid. Choose among the 2 choices, either head or tail.",
"new_balance" => loadAccDetails("user_id",$_SESSION['user_id'],"balance")

);

echo json_encode($out);
	
} elseif($nonce == "" OR !is_numeric($nonce)) {
	
$out = array(
	
"error" => "Your nonce is not valid, it has to be a numeric string.",
"new_balance" => loadAccDetails("user_id",$_SESSION['user_id'],"balance")

);

echo json_encode($out);
	
} elseif($client_seed == "") {
	
$out = array(
	
"error" => "Your client seed has been left blank.",
"new_balance" => loadAccDetails("user_id",$_SESSION['user_id'],"balance")

);

echo json_encode($out);
	
} else {
	
mysqli_query($con,"UPDATE users SET balance = balance - {$bet_amount} WHERE user_id = {$_SESSION['user_id']}");

$server_seed = loadAccDetails("user_id",$_SESSION['user_id'],"server_seed");
$server_seed_hash = loadAccDetails("user_id",$_SESSION['user_id'],"server_seed_hash");
	
$str1 = $nonce . ":" . $server_seed . ":" . $nonce;
$str2 = $nonce . ":" . $client_seed . ":" . $nonce;
	
$roll_number = hash_hmac('sha512', $str1, $str2);
$roll_number = (hexdec(substr($roll_number, 0, 8)) / 429496.7295);
$roll_number = round($roll_number);

$win = 0;
$profit = 0;
$new_amount = 0;

if($roll_number >= 0 && $roll_number <= 4999) {
	
if($bet_face == "head") {

$win = 1;	
	
}	
	
} elseif($roll_number > 4999 && $roll_number <= 9999) {
	
if($bet_face == "tail") {

$win = 1;	
	
}
	
} else {
	
$win = 0;
	
}

if($win == 1) {
	
$new_amount = (settings("CoinFlipReturn") / 100) * $bet_amount;
$new_amount = number_format($new_amount,8,".","");
$profit = number_format($new_amount - $bet_amount,8,".","");
	
$time = date("Y-m-d H:i:s");
$referral = loadAccDetails("user_id",$_SESSION['user_id'],"referral");
 
if($referral != "") {
	
$earnAmt = (settings("refPercentageCoinFlip") / 100) * $profit;
mysqli_query($con,"UPDATE users SET balance = balance + {$earnAmt}, total_referred = total_referred + {$earnAmt} WHERE user_name = {$referral} AND account_status = 1");
	
}

mysqli_query($con,"UPDATE users SET balance = balance + {$new_amount} WHERE user_id = {$_SESSION['user_id']}");
mysqli_query($con,"UPDATE stats SET value = value + {$profit} WHERE name = 'bitcoins_won'");

$out = array(
	
"error" => "",
"win" => $win,
"message" => "You have successfully predicted the right face! You have earned a profit of <b>" . $profit . "</b> BTC.",
"new_balance" => loadAccDetails("user_id",$_SESSION['user_id'],"balance")

);
	
} else {
	
$out = array(
	
"error" => "",
"win" => $win,
"message" => "You have failed to predict the right face. You have lost <b>" . $bet_amount . "</b> BTC from your account balance!",
"new_balance" => loadAccDetails("user_id",$_SESSION['user_id'],"balance")

);
	
}

echo json_encode($out);

mysqli_query($con,"INSERT INTO flip_wins (user_id,datetime,bet_amt,profit,win_amount,roll_number,client_seed,server_seed,server_seed_hash,nonce,win) VALUES ({$_SESSION['user_id']},'" . date("Y-m-d H:i:s") . "','{$bet_amount}',{$profit},{$new_amount},'{$roll_number}','{$client_seed}','{$server_seed}','{$server_seed_hash}','{$nonce}',{$win})");	
mysqli_query($con,"UPDATE stats SET value = value + 1 WHERE name = 'games_played'");

$server_seed = md5(bin2hex(openssl_random_pseudo_bytes(8)));
$server_seed_hash = hash("sha512",$server_seed);

mysqli_query($con,"UPDATE users SET server_seed = '{$server_seed}', server_seed_hash = '{$server_seed_hash}' WHERE user_id = {$_SESSION['user_id']}");

}

}

} else {
	
if(checkAdmin == true) {
	
$load = mysqli_query($con,"SELECT bet_amt,profit,win_amount,roll_number,client_seed,server_seed,server_seed_hash,nonce,win FROM treasure_wins WHERE id = " . intval($_GET['id']) . "");
	
} else {
	
$load = mysqli_query($con,"SELECT bet_amt,profit,win_amount,roll_number,client_seed,server_seed,server_seed_hash,nonce,win FROM treasure_wins WHERE id = " . intval($_GET['id']) . " AND user_id = {$_SESSION['user_id']}");

}

if(mysqli_num_rows($load) > 0.99) {
	
$r = mysqli_fetch_array($load);

$win = "false";

if($r['win'] == 1) { 

$win = "true";

}
	
echo '<b>Bet Amount:</b> ' . $r['bet_amt'] . " BTC";	
echo '<br>';
echo '<b>Profit:</b> ' . $r['profit'] . " BTC";	
echo '<br>';
echo '<b>Won Amount:</b> ' . $r['win_amount'] . " BTC";	
echo '<br>';
echo '<b>Won:</b> ' . $win;
echo '<br>';
echo '<br>';
echo '<b>Roll Number:</b> ' . $r['roll_number'];	
echo '<br>';
echo '<b>Client Seed:</b> ' . $r['client_seed'];	
echo '<br>';
echo '<b>Server Seed:</b> ' . $r['server_seed'];	
echo '<br>';
echo '<b>Server Seed Hash (SHA-512):</b> ' . $r['server_seed_hash'];	
echo '<br>';
echo '<b>Nonce:</b> ' . $r['nonce'];	
	
}
	
}

mysqli_close($con);

echo "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51746401-11', 'auto');
  ga('send', 'pageview');

</script>
";