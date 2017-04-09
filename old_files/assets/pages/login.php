

<div class="container"  style="min-height: 100vh;">
<div class="row">
<div class="col-md-8 col-md-offset-2 well" id="duh" style="padding: 100px;">

<center>
<h2>Login to your account</h2>
</center>

<br>
<br>

<form action="login" method="post">

<div class="form-group">
<input type="text" name="username" class="form-control" id="username" placeholder="What's your username?">
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

<div class="form-group">
<div class="checkbox">
<label>
<input type="checkbox" name="remember_me" value="1"> Stay logged in
</label>
</div>
</div>

<input type="submit" name="login" value="Login" placeholder="Submit" class="btn btn-primary">

<br>
<br>

Forgot your password? Click <b><a href="reset-password">here</a></b>. Not a member, <b><a href="register">register now!</a></b>

<br>
<br>

Didn't receive the confirmation email? <a href="resend-email"><b>Resend</b></a>.

</form>

</div>
</div>
</div>