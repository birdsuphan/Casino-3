

<div class="container" style="min-height: 100vh;">
<div class="col-md-8 col-md-offset-2 col-xs-12">
<div class="panel panel-default" id="duh" style="padding: 100px;">
<div class="panel-body">

<center>
<h2 >Referral System</h2>
</center>

<br>

<p id="nice-para">Did you know that you could earn by referring your friends and family here? That's right! We offer a referral percentage of <b><?php echo settings("refPercentage"); ?>%</b> from the profit of every winning bet your referred users make.</p>

<hr>

<div class="row">

<div id="ref-div">
<center>
<div class="col-xs-12 col-lg-4">

<span id="big-f"><b><?php echo settings("refPercentage"); ?>%</b></span>
<br>
<span id="small-f">Referral Commission</span>

<?php if(UserLoggedIn() == true) { ?>

<br>
<br>
</div>


<div class="col-xs-12 col-lg-4">

<span id="big-f"><b><?php echo number_format(loadAccDetails('user_id',$_SESSION['user_id'],"total_referral_earnings"),2); ?></b></span>
<br>
<span id="small-f">Referral Earnings (mBTC)</span>

</div>

<div class="col-xs-12 col-lg-4">

<span id="big-f"><b><?php echo number_format(loadAccDetails('user_id',$_SESSION['user_id'],"total_referred_users")); ?></b></span>
<br>
<span id="small-f">Referred Users</span>

</div>
</center>
</div>

<?php } ?>

</div>

<br>

<?php

if(UserLoggedIn() == true) {
	
echo '<pre><center>' . $website_url . '?r=' . $_SESSION['user_name'] . '</center></pre>';
	
echo '<br>';

$rc = mysqli_query($con,"SELECT COUNT(user_id) AS id FROM users WHERE referral = '{$_SESSION['user_name']}' ORDER BY user_id DESC");
$numrows = mysqli_fetch_array($rc);

$records = 60;
$total_pages = ceil($numrows['id'] / $records);

if(isset($_GET['offset']) && is_numeric($_GET['offset'])) {
$req_page = (int) filterData($_GET['offset']);
} else {
$req_page = 1;
}

if($req_page > $total_pages) {
$req_page = $total_pages;
}

if($req_page < 1) {
$req_page = 1;
}

$offset = ($req_page - 1) * $records;

$query = mysqli_query($con,"SELECT user_name,total_referred_earnings,total_games_played,total_wagered FROM users WHERE referral = '{$_SESSION['user_name']}' ORDER BY user_id DESC LIMIT $offset, $records");

if(mysqli_num_rows($query) > 0.9) {
	
echo '<table class="table table-striped table-hover" id="small-table">
<thead>
<tr class="success">    
<th>User</th>
<th>Referred Earnings</th>
<th>Total Games Played</th>
<th>Total Wagered</th>
</tr>
</thead>
<tbody>';

while($usr = mysqli_fetch_array($query)) {	 

echo '<tr class="primary">';
echo  '<td>' . $usr['user_name'] . '</td>';
echo  '<td>' . $usr['total_referred_earnings'] . ' mBTC</td>';
echo  '<td>' . $usr['total_games_played'] . '</td>';
echo  '<td>' . $usr['total_wagered'] . ' mBTC</td>';
echo '</tr>';
  
}
  
echo '</tbody>
</table>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
$prev = $req_page - 1;
echo '<li><a href="?offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="?offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {
$next = $req_page + 1;
echo '<li><a href="?offset=' . $next . '">Next Page</a></li>';
}
  
echo '</ul></div>';
	
} else {

echo '<div class="alert alert-info">
You have not referred anyone so far.
</div>';

}

}

?>

</div>
</div>
</div>

</div>
</div>