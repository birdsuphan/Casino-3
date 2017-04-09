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
require_once('functions/solvemedia.php');
require_once('config/config.php');
require_once('libraries/PHPMailer.php');

$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

require_once('functions/init.php');

if(UserLoggedIn() == true) {

$pageName = "Roll";
    
require_once('assets/inc/frontend_header.php');
include('assets/pages/roll.php');
require_once('assets/inc/_footer.php');

} else {	
	
$pageName = "Home";
	
require_once('assets/inc/frontend_header.php');
include('assets/pages/index_home.php');
require_once('assets/inc/_footer.php');
	
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