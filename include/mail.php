<?php
include "Mail.php";
include "Mail/mime.php";
Function sendMail($name,$startdate,$enddate,$hours,$department,$departmentemail){
	
	if ($hours == 1){ $hourtext = "Hour";}
	  else {$hourtext = "Hours";}
	
	$from = "PTO Request <pto@spindletopoil.com>";
	$to = "$department <$departmentemail>";
	$subject = " PTO Requested by $name ";
	$txt = " $name has requested $hours $hourtext of PTO with a start date of $startdate and an end date of $enddate";

	$html = "
			<!doctype html>
			<html>
			<head>
			<meta charset=\"utf-8\">
			<title>PTO Request</title>
			</head>	
			<style>
			@media print{*,::after,::before{text-shadow:none!important;box-shadow:none!important}a,a:visited{text-decoration:underline}abbr[title]::after{content:\" (\" attr(title) \")\"}pre{white-space:pre-wrap!important}blockquote,pre{border:1px solid #999;page-break-inside:avoid}thead{display:table-header-group}img,tr{page-break-inside:avoid}h2,h3,p{orphans:3;widows:3}h2,h3{page-break-after:avoid}.navbar{display:none}.badge{border:1px solid #000}.table{border-collapse:collapse!important}.table td,.table th{background-color:#fff!important}.table-bordered td,.table-bordered th{border:1px solid #ddd!important}}html{box-sizing:border-box;font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar;-webkit-tap-highlight-color:transparent}*,::after,::before{box-sizing:inherit}@-ms-viewport{width:device-width}article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}body{margin:0;font-family:-apple-system,BlinkMacSystemFont,\"Segoe UI\",Roboto,\"Helvetica Neue\",Arial,sans-serif;font-size:1rem;font-weight:400;line-height:1.5;color:#212529;background-color:#fff}[tabindex=\"-1\"]:focus{outline:0!important}hr{box-sizing:content-box;height:0;overflow:visible}h1,h2,h3,h4,h5,h6{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}abbr[data-original-title],abbr[title]{text-decoration:underline;-webkit-text-decoration:underline dotted;text-decoration:underline dotted;cursor:help;border-bottom:0}address{margin-bottom:1rem;font-style:normal;line-height:inherit}dl,ol,ul{margin-top:0;margin-bottom:1rem}ol ol,ol ul,ul ol,ul ul{margin-bottom:0}dt{font-weight:700}dd{margin-bottom:.5rem;margin-left:0}blockquote{margin:0 0 1rem}dfn{font-style:italic}b,strong{font-weight:bolder}small{font-size:80%}sub,sup{position:relative;font-size:75%;line-height:0;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}a{color:#007bff;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}a:hover{color:#0056b3;text-decoration:underline}a:not([href]):not([tabindex]){color:inherit;text-decoration:none}a:not([href]):not([tabindex]):focus,a:not([href]):not([tabindex]):hover{color:inherit;text-decoration:none}a:not([href]):not([tabindex]):focus{outline:0}code,kbd,pre,samp{font-family:monospace,monospace;font-size:1em}pre{margin-top:0;margin-bottom:1rem;overflow:auto}figure{margin:0 0 1rem}img{vertical-align:middle;border-style:none}svg:not(:root){overflow:hidden}[role=button],a,area,button,input,label,select,summary,textarea{-ms-touch-action:manipulation;touch-action:manipulation}table{border-collapse:collapse}caption{padding-top:.75rem;padding-bottom:.75rem;color:#868e96;text-align:left;caption-side:bottom}th{text-align:left}label{display:inline-block;margin-bottom:.5rem}button:focus{outline:1px dotted;outline:5px auto -webkit-focus-ring-color}button,input,optgroup,select,textarea{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button,select{text-transform:none}[type=reset],[type=submit],button,html [type=button]{-webkit-appearance:button}[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none}input[type=checkbox],input[type=radio]{box-sizing:border-box;padding:0}input[type=date],input[type=datetime-local],input[type=month],input[type=time]{-webkit-appearance:listbox}textarea{overflow:auto;resize:vertical}fieldset{min-width:0;padding:0;margin:0;border:0}legend{display:block;width:100%;max-width:100%;padding:0;margin-bottom:.5rem;font-size:1.5rem;line-height:inherit;color:inherit;white-space:normal}progress{vertical-align:baseline}[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}[type=search]{outline-offset:-2px;-webkit-appearance:none}[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}output{display:inline-block}summary{display:list-item}template{display:none}[hidden]{display:none!important}.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.1;color:inherit}.h1,h1{font-size:2.5rem}.h2,h2{font-size:2rem}.h3,h3{font-size:1.75rem}.h4,h4{font-size:1.5rem}.h5,h5{font-size:1.25rem}.h6,h6{font-size:1rem}.lead{font-size:1.25rem;font-weight:300}.display-1{font-size:6rem;font-weight:300;line-height:1.1}.display-2{font-size:5.5rem;font-weight:300;line-height:1.1}.display-3{font-size:4.5rem;font-weight:300;line-height:1.1}.display-4{font-size:3.5rem;font-weight:300;line-height:1.1}hr{margin-top:1rem;margin-bottom:1rem;border:0;border-top:1px solid rgba(0,0,0,.1)}.small,small{font-size:80%;font-weight:400}.mark,mark{padding:.2em;background-color:#fcf8e3}.list-unstyled{padding-left:0;list-style:none}.list-inline{padding-left:0;list-style:none}.list-inline-item{display:inline-block}.list-inline-item:not(:last-child){margin-right:5px}.initialism{font-size:90%;text-transform:uppercase}.blockquote{margin-bottom:1rem;font-size:1.25rem}.blockquote-footer{display:block;font-size:80%;color:#868e96}.blockquote-footer::before{content:\"\2014 \00A0\"}.img-fluid{max-width:100%;height:auto}.img-thumbnail{padding:.25rem;background-color:#fff;border:1px solid #ddd;border-radius:.25rem;transition:all .2s ease-in-out;max-width:100%;height:auto}.figure{display:inline-block}.figure-img{margin-bottom:.5rem;line-height:1}.figure-caption{font-size:90%;color:#868e96}code,kbd,pre,samp{font-family:Menlo,Monaco,Consolas,\"Liberation Mono\",\"Courier New\",monospace}code{padding:.2rem .4rem;font-size:90%;color:#bd4147;background-color:#f8f9fa;border-radius:.25rem}a>code{padding:0;color:inherit;background-color:inherit}kbd{padding:.2rem .4rem;font-size:90%;color:#fff;background-color:#212529;border-radius:.2rem}kbd kbd{padding:0;font-size:100%;font-weight:700}pre{display:block;margin-top:0;margin-bottom:1rem;font-size:90%;color:#212529}pre code{padding:0;font-size:inherit;color:inherit;background-color:transparent;border-radius:0}.pre-scrollable{max-height:340px;overflow-y:scroll}.container{margin-right:auto;margin-left:auto;padding-right:15px;padding-left:15px;width:100%}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.container-fluid{width:100%;margin-right:auto;margin-left:auto;padding-right:15px;padding-left:15px;width:100%}.row{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px}.no-gutters{margin-right:0;margin-left:0}.no-gutters>.col,.no-gutters>[class*=col-]{padding-right:0;padding-left:0}.col,.col-1,.col-10,.col-11,.col-12,.col-2,.col-3,.col-4,.col-5,.col-6,.col-7,.col-8,.col-9,.col-auto,.col-lg,.col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9,.col-lg-auto,.col-md,.col-md-1,.col-md-10,.col-md-11,.col-md-12,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9,.col-md-auto,.col-sm,.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-sm-auto,.col-xl,.col-xl-1,.col-xl-10,.col-xl-11,.col-xl-12,.col-xl-2,.col-xl-3,.col-xl-4,.col-xl-5,.col-xl-6,.col-xl-7,.col-xl-8,.col-xl-9,.col-xl-auto{position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px}.col{-ms-flex-preferred-size:0;flex-basis:0;-ms-flex-positive:1;flex-grow:1;max-width:100%}
			.container-login100{margin:0;width:100%;min-height:100vh;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:center;align-items:center;padding:15px;background:#5653c7;background:-webkit-linear-gradient(-135deg,#3e94ec,navy);background:-o-linear-gradient(-135deg,#3e94ec,navy);background:-moz-linear-gradient(-135deg,#3e94ec,navy);background:linear-gradient(-135deg,#3e94ec,navy)}.wrap-login100{width:960px;background:#fff;border-radius:10px;overflow:hidden;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:space-between;padding:25px}.navbar-btn{padding:12px;color:#fff;text-decoration:none;font-size:17px;text-align:center;display:inline-block;border-radius:5px;text-shadow:0 1px 1px rgba(256,256,256,.1);box-shadow:0 6px 20px 0 rgba(0,0,0,.19);background-color:#494949}.adminbar{background-color:rgba(171,205,239,.3)}@media (max-width:992px){.wrap-login100{padding:177px 90px 33px 85px}.login100-pic{width:35%}.login100-form{width:50%}}@media (max-width:768px){.wrap-login100{padding:100px 80px 33px 80px}.login100-pic{display:none}.login100-form{width:100%}}@media (max-width:576px){.wrap-login100{padding:100px 15px 33px 15px}}.row{margin-top:0;margin-left:-3rem;margin-right:-3rem}.row>*{padding:0 0 0 3rem}	
			</style>
			<body>
				<div class=container-login100>
					<div class=wrap-login100>
						<div class=container>
							<div class=row>
							<h2><img src=images/SOGLOGO-01.svg alt=IMG> <br />
							PTO Request</h2>
							</div>
							<br>
							<div class='row adminbar'>
								<div class=col><h3>Name</h3></div>
								<div class=col><h3>Start Date</h3></div>
								<div class=col><h3>End Date</h3></div>
								<div class=col><h3>Hours Requested</h3></div>
							</div>
							<div class=row>
								<div class=col><h4>$name</h4></div>
								<div class=col><h4>$startdate</h4></div>
								<div class=col><h4>$enddate</h4></div>
								<div class=col><h4>$hours $hourtext</h4></div>
							</div>
							<br>
							<div col=row>
							<a href=vprsrv2/outboard.php class=navbar-btn>Go to the Outboard</a>
							<a href=vprsrv2/approvePTO.php class=navbar-btn>Approve/Deny PTO</a>
						</div>
						</div>
					</div>
				</div>			
			</body>
			</html>";

	$crlf = "\r\n";

	$host = "smtp.fatcow.com";
	$username = "pto@spindletopoil.com";
	$password = "thisisthePTOmailbox1";

	$headers = array ('From' => $from,
					  'To' => $to,
					  'Subject' => $subject);

	$mime = new Mail_mime($crlf);
	$mime->setTXTBody($txt);
	$mime->setHTMLBody($html);

	$body = $mime->get();
	$headers = $mime->headers($headers);

	$smtp = Mail::factory('smtp',
						  array ('host' => $host,
								 'auth' => true,
								 'username' => $username,
								 'password' => $password));
	$mail = $smtp->send($to, $headers, $body);
	if (PEAR::isError($mail)) {
	echo("<p>" . $mail->getMessage() . "</p>");
	} else {
	echo("<p>Message successfully sent!</p>");
	}
}

?>
