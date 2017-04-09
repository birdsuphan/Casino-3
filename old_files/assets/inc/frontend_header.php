<!DOCTYPE html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php echo $website_name; ?> | <?php echo @$pageName; ?></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="assets/css/style.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
<link href='https://fonts.googleapis.com/css?family=Muli:400,300italic' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Questrial|Roboto+Condensed|Stalemate" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>

<body>

<div class="navbar navbar-default navbar-fixed-top">
<div class="container">
<div class="navbar-header">
<a href="index" class="navbar-brand"><b><?php echo $website_name; ?></b></a>
<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
</div>
<div class="navbar-collapse collapse" id="navbar-main">
<ul class="nav navbar-nav">

<li><a href="news"><i class="fa fa-newspaper-o"></i> &nbsp; News</a></li>

<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-trophy"></i> &nbsp; Games &nbsp;<span class="caret"></span></a>
<ul class="dropdown-menu" role="menu">
<li><a href="roll">Roll Dice</a></li>
<li><a href="dice">Hi-Lo Dice </a></li>
<li><a href="fortune">Fortune Hunter</a></li>
<li><a href="flip">Coin Flip</a></li>
<?php if(settings("gameSatoshiSnake") == 1) {?><li><a href="snakes">Satoshi Snakes</a></li><?php } ?>
</ul>
</li>

<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-gamepad"></i> &nbsp; Earn &nbsp;<span class="caret"></span></a>
<ul class="dropdown-menu" role="menu">
<?php if(settings("faucetStatus") == 1) {?><li><a href="faucet">Faucet</a></li><?php } ?>
<li><a href="raffle">Raffle</a></li>
</ul>
</li>

<?php if(settings("forums") == 1){?><li><a href="forums"><i class="glyphicon glyphicon-comment"></i> &nbsp; Forums</a></li><?php } ?>
<li><a href="contact"><i class="fa fa-envelope"></i> &nbsp; Contact</a></li>

</ul>

<ul class="nav navbar-nav navbar-right">

<?php

if(UserLoggedIn() == true) {

?>

<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bitcoin"></i> &nbsp; <b><span id="balance_global"><?php echo loadAccDetails("user_id",$_SESSION['user_id'],"balance"); ?></span></b> BTC</a>
<ul class="dropdown-menu" role="menu">
<li><a href="promo">Referral Earnings</a></li>
<li><a href="history?id=1">Withdrawal History</a></li>
<li><a href="?withdraw_all">Withdraw</a></li>
</ul>
</li>
<li><a href="edit-profile"><i class="glyphicon glyphicon-wrench"></i> &nbsp; Edit Profile</a></li>
<?php if(checkAdmin() == true) {?><li><a href="admin"><i class="fa fa-cog"></i> &nbsp; Admin</a></li><?php } ?>
<li><a href="?logout"><i class="glyphicon glyphicon-off"></i></a></li>

<?php

} else {
	
?>

<li><a href="login"><i class="fa fa-user"></i> &nbsp; Login</a></li>
<li><a href="register"><i class="fa fa-users"></i> &nbsp; Register</a></li>

<?php	

}

?>

</ul>

</div>
</div>
</div>

<div id="wrapper">

<?php

if(empty($core_system_messages) == false) {

foreach($core_system_messages as $message) {

echo '<br>
<div class="container">
<div class="alert alert-dismissable alert-info">
' . $message . '
</div>
</div>';

}

}

?>