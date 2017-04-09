<div class="splash">
<div class="container">
<div class="row">
<div class="col-lg-12">
<br>
<h1>Boutique Bitcoin Casino</h1>

<h4>Great rewards. Provably fair. Safe and secure.</h4>

<br>

<a href="register" class="btn btn-primary btn-lg">JOIN NOW</a> &nbsp; <a href="login" class="btn btn-primary btn-lg">Sign in</a>

<br>
<br>

</div>
</div>
</div>
</div>

<div class="section-tout">
<div class="container-fluid" align="center">

<?php

echo '<div class="row">';

if(settings("faucetStatus") == 1) {

echo '<div class="col-md-4">
<div class="panel panel-default">
<div class="panel-body" style="color:#333333;">

<img src="assets/images/home_faucet.svg" id="homeimg">

<center><h1>Bitcoin Faucet</h1></center>

Earn some coins by doing literally nothing - just completing a single captcha. Go ahead, just take your coins from our pool!

<br>
<br>

<a href="faucet" class="btn btn-success">Earn Bitcoins</a>

</div>
</div>
</div>';	
	
}

if(settings("gameSatoshiSnake") == 1) {
echo '<div class="col-md-4">
<div class="panel panel-default">
<div class="panel-body" style="color:#333333;">

<img src="assets/images/Bitcoin-Flip.svg" id="homeimg">

<center><h1>Bitcoin Flip</h1></center>

Choose heads or tails and your stake to win instantly.

<br>
<br>

<a href="flip" class="btn btn-sm btn-success">Flip Now</a>

</div>
</div>
</div>';
}
echo '<div class="col-md-4">
<div class="panel panel-default">
<div class="panel-body" style="color:#333333;">

<img src="assets/images/HiLo-Dice.svg" id="homeimg">

<center><h1>Hi-Lo Dice</h1></center>

You decide the odds and your stake in the classic game.

<br>
<br>

<a href="dice" class="btn btn-sm btn-success">Roll Dice</a>

</div>
</div>
</div>';

echo '<div class="col-md-4">
<div class="panel panel-default">
<div class="panel-body" style="color:#333333;">

<img src="assets/images/Bonanza-Jackpot.svg" id="homeimg">

<center><h1>Bonanza Jackpot</h1></center>

Earn or buy tickets to win our monthly Bonanza Jackpot.

<br>
<br>

<a href="raffle" class="btn btn-sm btn-success">Play Now</a>

</div>
</div>
</div>';
echo '</div>';

echo '<div class="row">';

echo '<div class="col-md-4">
<div class="panel panel-default" style="border-radius:0;">
<div class="panel-body" style="color:#333333;">

<img src="assets/images/Fortune-Hunt.svg" id="homeimg">

<center><h1>Fortune Hunter</h1></center>

Dig for treasure in one of three different locations.

<br>
<br>

<a href="fortune" class="btn btn-sm btn-success">Dig &amp; Find Fortune</a>

</div>
</div>
</div>';
//high low dice
echo '<div class="col-md-4">
<div class="panel panel-default">
<div class="panel-body" style="color:#333333;">

<img src="assets/images/Satoshi-Snake.svg" id="homeimg">

<center><h1>Satoshi Snakes</h1></center>

Free to play! Earn coins having fun playing classic snakes.

<br>
<br>

<a href="snakes" class="btn btn-sm btn-success">Collect Blocks</a>

</div>
</div>
</div>';
//flip
echo '<div class="col-md-4">
<div class="panel panel-default">
<div class="panel-body" style="color:#333333;">

<img src="assets/images/Lucky-DIce.svg" id="homeimg">

<center><h1>Lucky Dice</h1></center>

Free to play! Roll the dice to win up to 0.31410488 BTC.

<br>
<br>

<a href="snakes" class="btn btn-sm btn-success">Roll Dice</a>

</div>
</div>
</div>';


//raffle


echo '</div>';

echo '<div class="row">';

echo '<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-body" style="color:#333333; padding-left:0; padding-right:0; padding-bottom:0;">

<center><h1>Recent Dice Rolls</h1></center>';

echo '<center>';

$roll_wins = mysqli_query($con,"SELECT user_id,win_amount,raffle_tickets FROM roll_wins ORDER BY id DESC LIMIT 6");

echo '<table class="table table-striped table-hover">
<thead>
<tr class="danger">
<th>User</th>
<th>Win Amount</th>
<th>Raffle Tickets</th>
</tr>
</thead>
<tbody>';

while($q = mysqli_fetch_array($roll_wins)) {
	
echo '<tr class="success">';
echo '<td>' . loadAccDetails("user_id",$q['user_id'],"user_name") . '</td>';	
echo '<td>' . $q['win_amount'] . ' BTC</td>';	
echo '<td>' . $q['raffle_tickets'] . '</td>';
echo '</tr>';

}
	
echo '</tbody>
</table>';

echo '</center>';

echo '</div>
</div>
</div>';	

echo '<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-body" style="color:#333333; padding-left:0;padding-right:0;padding-bottom:0;">

<center><h1>Recent Hi-Lo Rolls</h1></center>';

echo '<center>';

$dice_wins = mysqli_query($con,"SELECT user_id,bet_amt,payout,win_amount,win FROM dice_wins ORDER BY id DESC LIMIT 6");

echo '<table class="table table-striped table-hover">
<thead>
<tr class="danger">
<th>User</th>
<th>Stake Amount</th>
<th>Multiplier</th>
<th>Win Amount</th>
<th>Result</th>
</tr>
</thead>
<tbody>';

while($q = mysqli_fetch_array($dice_wins)) {
	
echo '<tr class="success">';
echo '<td>' . loadAccDetails("user_id",$q['user_id'],"user_name") . '</td>';	
echo '<td>' . $q['bet_amt'] . ' BTC</td>';	
echo '<td>' . $q['payout'] . '</td>';	
echo '<td>' . $q['win_amount'] . ' BTC</td>';	
if($q['win'] == 1) {
echo '<td><span class="label label-success">Win</span></td>';	
} else {
echo '<td><span class="label label-danger">Lose</span></td>';		
}	

}
	
echo '</tbody>
</table>';

echo '</center>';

echo '</div>
</div>
</div>';

echo '</div>';


?>


</div>
</div>

<div class="home-stat">

<div class="container">
<div class="row">

<div class="col-md-4">
<i class="fa fa-users"></i>
<br>
<span style="font-size:20px;"><b><?php echo number_format(stats("total_users")); ?>+</b> Users</span>
</div>

<div class="col-md-4">
<i class="fa fa-gamepad"></i>
<br>
<span style="font-size:20px;"><b><?php echo number_format(stats("games_played")); ?>+</b> Games Played</span>
</div>

<div class="col-md-4">
<i class="fa fa-bitcoin"></i>
<br>
<span style="font-size:20px;"><b><?php echo sprintf("%.8f",stats("bitcoins_won")); ?>+</b> BTC Won</span>
</div>

</div>
</div>



</div>