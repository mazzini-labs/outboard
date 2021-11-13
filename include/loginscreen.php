<?php


// header("Set-Cookie: key=_ga; path=/; domain=picsum.photos/; HttpOnly; SameSite=None; Secure");
// header("Set-Cookie: key=_gid; path=/; domain=picsum.photo/; HttpOnly; SameSite=None; Secure");
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
	<link rel="icon" type="../image/png" href="/var/www/testoutboard/include/images/icons/favicon.ico"/>
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
<style>
.box-wrapper {
    -webkit-transition-duration: 2000ms;
	transition-duration: 2000ms;
	position: absolute;
	top: 0vh;
	right: 1em;
	overflow: hidden;
}

.box-wrapper.loading:nth-child(odd) {
    transform: translate(100%);
    -webkit-transform: translate(100%);    
}
.shadow-lg 
{
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
}
.limiter
{
	/* background-image: url(https://i.picsum.photos/id/10/2500/1667.jpg?hmac=J04WWC_ebchx3WwzbM-Z4_KC_LeLBWr5LZMaAkWkF68); */
}
.sog
{
	bottom: 2em;
	left: 2em;
	width: 50vh;
	position: absolute;
}
.bottom-box 
{
	width: 100%;
	height: 25vh;
	
	background: rgba(255,255,255,0.25);
	clip-path: polygon(0 0, 0% 100%, 100% 100%);
	position: absolute;
	bottom: 0em;
	left: 0em;
}
.input-container {
  display: flex;
  width: 100%;
  margin-bottom: 15px;
}
.icon {
  padding: 10px;
  /* background: dodgerblue; */
  color: white;
  min-width: 50px;
  text-align: center;
  vertical-align: center;
}
</style>
<style>
	.login {
  /* position: relative; */
  height: 100%;
  background: -webkit-gradient(linear, left top, left bottom, from(rgba(146, 135, 187, 0.8)), to(rgba(0, 0, 0, 0.6)));
  background: linear-gradient(to bottom, rgba(146, 135, 187, 0.8) 0%, rgba(0, 0, 0, 0.6) 100%);
  -webkit-transition: opacity 0.1s, -webkit-transform 0.3s cubic-bezier(0.17, -0.65, 0.665, 1.25);
  transition: opacity 0.1s, -webkit-transform 0.3s cubic-bezier(0.17, -0.65, 0.665, 1.25);
  transition: opacity 0.1s, transform 0.3s cubic-bezier(0.17, -0.65, 0.665, 1.25);
  transition: opacity 0.1s, transform 0.3s cubic-bezier(0.17, -0.65, 0.665, 1.25), -webkit-transform 0.3s cubic-bezier(0.17, -0.65, 0.665, 1.25);
  -webkit-transform: scale(1);
          transform: scale(1);
	}
	.login.inactive {
	opacity: 0;
	-webkit-transform: scale(1.1);
			transform: scale(1.1);
	}
	.login__check {
	position: absolute;
	top: 16rem;
	left: 10rem;
	width: 14rem;
	height: 2.8rem;
	background: #fff;
	-webkit-transform-origin: 0 100%;
			transform-origin: 0 100%;
	-webkit-transform: rotate(-45deg);
			transform: rotate(-45deg);
	}
	.login__check:before {
	content: "";
	position: absolute;
	left: 0;
	bottom: 100%;
	width: 2.8rem;
	height: 5.2rem;
	background: #fff;
	box-shadow: inset -0.2rem -2rem 2rem rgba(0, 0, 0, 0.2);
	}
	.login__form {
	position: absolute;
	top: 50%;
	left: 0;
	width: 100%;
	height: 50%;
	padding: 1.5rem 2.5rem;
	text-align: center;
	}
	.login__row {
	height: 5rem;
	padding-top: 1rem;
	border-bottom: 1px solid rgba(255, 255, 255, 0.2);
	}
	.login__icon {
	margin-bottom: -0.4rem;
	margin-right: 0.5rem;
	}
	.login__icon.name path {
	stroke-dasharray: 73.50196075439453;
	stroke-dashoffset: 73.50196075439453;
	-webkit-animation: animatePath 2s 0.5s forwards;
			animation: animatePath 2s 0.5s forwards;
	}
	.login__icon.pass path {
	stroke-dasharray: 92.10662841796875;
	stroke-dashoffset: 92.10662841796875;
	-webkit-animation: animatePath 2s 0.5s forwards;
			animation: animatePath 2s 0.5s forwards;
	}
	.login__input {
	display: inline-block;
	width: 11rem;
	height: 100%;
	padding-left: 1.5rem;
	font-size: 1.5rem;
	background: transparent;
	color: #fdfcfd;
	}
	.login__submit {
	position: relative;
	width: 100%;
	height: 4rem;
	margin: 5rem 0 2.2rem;
	color: rgba(255, 255, 255, 0.8);
	background: #ff3366;
	font-size: 1.5rem;
	border-radius: 3rem;
	cursor: pointer;
	overflow: hidden;
	-webkit-transition: width 0.3s 0.15s, font-size 0.1s 0.15s;
	transition: width 0.3s 0.15s, font-size 0.1s 0.15s;
	}
	.login__submit:after {
	content: "";
	position: absolute;
	top: 50%;
	left: 50%;
	margin-left: -1.5rem;
	margin-top: -1.5rem;
	width: 3rem;
	height: 3rem;
	border: 2px dotted #fff;
	border-radius: 50%;
	border-left: none;
	border-bottom: none;
	-webkit-transition: opacity 0.1s 0.4s;
	transition: opacity 0.1s 0.4s;
	opacity: 0;
	}
	.login__submit.processing {
	width: 4rem;
	font-size: 0;
	}
	.login__submit.processing:after {
	opacity: 1;
	-webkit-animation: rotate 0.5s 0.4s infinite linear;
			animation: rotate 0.5s 0.4s infinite linear;
	}
	.login__submit.success {
	-webkit-transition: opacity 0.1s 0.3s, background-color 0.1s 0.3s, -webkit-transform 0.3s 0.1s ease-out;
	transition: opacity 0.1s 0.3s, background-color 0.1s 0.3s, -webkit-transform 0.3s 0.1s ease-out;
	transition: transform 0.3s 0.1s ease-out, opacity 0.1s 0.3s, background-color 0.1s 0.3s;
	transition: transform 0.3s 0.1s ease-out, opacity 0.1s 0.3s, background-color 0.1s 0.3s, -webkit-transform 0.3s 0.1s ease-out;
	-webkit-transform: scale(30);
			transform: scale(30);
	opacity: 0.9;
	}
	.login__submit.success:after {
	-webkit-transition: opacity 0.1s 0s;
	transition: opacity 0.1s 0s;
	opacity: 0;
	-webkit-animation: none;
			animation: none;
	}
</style>
<body>
	<div class="limiter">
		<div class="container-fluid">
			<div class="bottom-box shadow-lg"></div>
			<div class="sog js-tilt justify-content-center" data-tilt>
				<img src="images/SOGLOGO-01.svg" alt="IMG">
			</div>
			<div class="login shadow-lg card-body bg-light box-wrapper loading" style="width:40vh;">
			
			<div class="login__check"></div>
			<div class="login__form">
				<form class="card-body validate-form" ACTION="<?php echo $baseurl ?>" METHOD=post>
				<?php echo $message ?>
				<?php if (! $BasicAuthInUse) { ?>

					<!-- <span class="login100-form-title">
						Outboard Login
					</span> -->
					
					<div class="login__row validate-input input-container" data-validate = "Valid email is required: ex@abc.xyz">
						
							<i class="fa fa-user icon" aria-hidden="true"></i>
						
						<input class="login__input" type=text name=username placeholder="Username">
						<span class="focus-input100"></span>
						
						
					</div>

					<div class="login__row validate-input input-container" data-validate = "Password is required">
						<i class="fa fa-lock icon" aria-hidden="true"></i>
						<input class="login__input" type=password name=password placeholder="Password" readonly onfocus="this.removeAttribute('readonly');"/>
						<span class="login__row"></span>
						<span class="symbol-input100">
							
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="navbar-btn" type=submit name=loginbutton value="Login">
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
	<script>
		$('.box-wrapper').each(function(index, element) {
    
    setTimeout(function(){
        element.classList.remove('loading');
    }, index * 500);

});
</script>
<script>
	// SameSite is fucking this up. Have to download images manually.
const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)
const vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0)
// var bg = "http://picsum.photos/"+vw+"/"+vh+"?random=1";
var numOfBackgrounds = 146;
var rng = Math.floor((Math.random() * numOfBackgrounds) + 1);
var grad = "linear-gradient(rgba(0, 0, 255, 0.15), rgba(0, 0, 255, 0.15)),";
var url = "url(http://vprsrv2/images/login-bg/"+rng+".jpg)";
// background: 
    /* top, transparent red, faked with gradient */ 
    
    /* bottom, image */
    // url(image.jpg);
// }
$('body').css("background-image",grad+url);
$('body').css("background-size",vw +"px "+vh+"px");
</script>
</body>
</html>
<?php exit; ?>
