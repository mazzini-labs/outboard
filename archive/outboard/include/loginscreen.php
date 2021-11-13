<?php
$username = "";
$password = "";
//$message = "<CENTER> &nbsp; </CENTER>";

if (getPostValue('username') != "") {
    $message = "<CENTER><H3>Login Incorrect</H3></CENTER><p>";
} 

//$baseurl = $conf->getConfig('progname');

if ($BasicAuthInUse) {
    $message = "<CENTER><H3>You are not logged in.<br>"
			."<a href=\"$baseurl\">Click Here</a> "
			."to try again.</H3></CENTER><p>";
}
?>
<html lang="en">
<head>
	<title>Outboard: Spindletop Oil & Gas Co.</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="/var/www/testoutboard/include/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/SOGLOGO-01.svg" alt="IMG">
				</div>

				<form class="login100-form validate-form" ACTION="<?php echo $baseurl ?>" METHOD=post>
	<?php echo $message ?>
	<?php if (! $BasicAuthInUse) { ?>

					<span class="login100-form-title">
						Outboard Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type=text name=username placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
						
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type=password name=password placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type=submit name=loginbutton value="Login">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php } // IF ?>
	</form>

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
	<script language="JavaScript"> loginform.username.focus(); </script>

</body>
</html>
<?php exit; ?>
