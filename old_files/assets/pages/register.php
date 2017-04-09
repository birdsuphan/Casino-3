<div class="container"  style="min-height: 100vh;">
<div class="row">
<div class="col-md-8 col-md-offset-2 well" id="duh" style="padding: 100px;">

<center>
<h2>Register an account</h2>
</center>

<span class="register-page"><center>Ready to <b>flip</b> coins? You're almost <b>done</b>.</center></span>
<hr>

<form action="register" method="post">

<div class="form-group">

<input type="text" name="username" class="form-control" id="username" placeholder="What's your username?">
</div>

<div class="form-group">

<input type="text" name="email" class="form-control" id="email" placeholder="What's your email?">
</div>

<div class="form-group">

<input type="password" name="password" class="form-control" id="password" placeholder="What's your password?">
</div>

<?php

if(settings("googleReCaptcha") == 1) {

echo "<script>
var onloadCallback = function() {
grecaptcha.render('captcha', {
'sitekey' : '" . settings("googleRecaptcha_PUBLICkey") . "',
'hl' : 'en-GB'
});
};
</script>
	
<script src='https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit' async defer></script>";

echo '<div id="captcha"></div>';
	
}

?>

<input type="submit" name="register" value="Register" placeholder="Submit" class="btn btn-primary">

<br>
<br>

Already a user? Login to your <b><a href="login">account</a></b>.

</form>

</div>
</div>
</div>