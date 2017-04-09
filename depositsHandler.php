<?php

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

$cp_merchant_id = settings("CoinPaymentsMerchantID"); 
$cp_ipn_secret = settings("CoinPaymentsIPNSecret");

$order_currency = 'USD'; 

if(!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
die('IPN Mode is not HMAC'); 
} 

if(!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
die('No HMAC signature sent.'); 
} 

$request = file_get_contents('php://input'); 

if($request === FALSE || empty($request)) { 
die('Error reading POST data'); 
} 

if(!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) { 
die('No or incorrect Merchant ID passed'); 
} 

$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
if($hmac != $_SERVER['HTTP_HMAC']) { 
die('HMAC signature does not match'); 
} 

$txn_id = $_POST['txn_id']; 
$item_name = $_POST['item_name']; 
$item_number = $_POST['item_number']; 
$amount = floatval($_POST['amount']); 
$currency = $_POST['currency']; 
$status = intval($_POST['status']); 
$status_text = $_POST['status_text']; 
$address = $_POST['address'];

if($currency != "BTC") { 
die('Original currency mismatch!'); 
}     

if($status >= 100 || $status == 1) {

$product_price = $amount;
$user = loadAccDetails("deposit_address",$address,"user_id");

mysqli_query($con,"UPDATE users SET balance = balance + {$product_price} WHERE user_id = {$user}");
mysqli_query($con,"INSERT INTO deposits (user_id,amount) VALUES ({$user},{$product_price})");

} else if($status < 0) { 



} else { 





} 

exit('IPN OK');

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

?>