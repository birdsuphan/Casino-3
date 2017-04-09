<?php

/**
*
* PHP Easy Form Maker
* This file is a part of PHP Easy Form Maker. Please do not reproduce or share any part of this file without acknowledgement from the developers.
*
* Available at Overfeat.com. Developed by Areeb (hello@areebmajeed.me).
* 
*
**/

if(version_compare(PHP_VERSION, '5.3.7', '<')) {
exit('Sorry, this script does not run on a PHP version smaller than 5.3.7!');
} elseif (version_compare(PHP_VERSION, '5.5.0', '<')) {
require_once('libraries/password_compatibility_library.php');
}

require_once('functions/Core.php');
require_once('config/config.php');
require_once('libraries/PHPMailer.php');

require_once('functions/init.php');

if(isset($installed)) {
	
header("Location: " . $website_url);
exit();
	
} else {
	
$pageName = "Initializing Installer";
    
require_once('assets/inc/frontend_header.php');
include('assets/pages/installer_welcome.php');
require_once('assets/inc/_footer.php');
	
}