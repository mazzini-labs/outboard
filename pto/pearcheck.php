<?php
require_once "include/mail_requestpto.php";
require_once "Mail/mime.php";
	$department = "Matt Mazzini";
	$departmentemail = "cmmazzini@spindletopoil.com";
	$name = "Matt M";
	$startdate = "3/17";
	$enddate = "3/18";
	$hours = 16;
	if ($hours == 1){ $hourtext = "Hour";}
	  else {$hourtext = "Hours";}
	$from = "PTO Request <pto@spindletopoil.com>";
	$to = "$department <$departmentemail>";
	$subject = " PTO Requested by $name ";
	$txt = " $name has requested $hours $hourtext of PTO with a start date of $startdate and an end date of $enddate";
	
	$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><!--[if IE]><html xmlns=\"http://www.w3.org/1999/xhtml\" class=\"ie\"><![endif]--><!--[if !IE]><!--><html style=\"margin: 0;padding: 0;\" xmlns=\"http://www.w3.org/1999/xhtml\"><!--<![endif]--><head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    <title></title>
    <!--[if !mso]><!--><meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" /><!--<![endif]-->
    <meta name=\"viewport\" content=\"width=device-width\" /><style type=\"text/css\">
@media only screen and (min-width: 620px){.wrapper{min-width:600px !important}.wrapper h1{}.wrapper h1{font-size:64px !important;line-height:63px !important}.wrapper h2{}.wrapper h2{font-size:30px !important;line-height:38px !important}.wrapper h3{}.wrapper h3{font-size:22px !important;line-height:31px !important}.column{}.wrapper .size-8{font-size:8px !important;line-height:14px !important}.wrapper .size-9{font-size:9px !important;line-height:16px !important}.wrapper .size-10{font-size:10px !important;line-height:18px !important}.wrapper .size-11{font-size:11px !important;line-height:19px !important}.wrapper .size-12{font-size:12px !important;line-height:19px !important}.wrapper .size-13{font-size:13px !important;line-height:21px !important}.wrapper .size-14{font-size:14px !important;line-height:21px !important}.wrapper .size-15{font-size:15px !important;line-height:23px 
!important}.wrapper .size-16{font-size:16px !important;line-height:24px !important}.wrapper .size-17{font-size:17px !important;line-height:26px !important}.wrapper .size-18{font-size:18px !important;line-height:26px !important}.wrapper .size-20{font-size:20px !important;line-height:28px !important}.wrapper .size-22{font-size:22px !important;line-height:31px !important}.wrapper .size-24{font-size:24px !important;line-height:32px !important}.wrapper .size-26{font-size:26px !important;line-height:34px !important}.wrapper .size-28{font-size:28px !important;line-height:36px !important}.wrapper .size-30{font-size:30px !important;line-height:38px !important}.wrapper .size-32{font-size:32px !important;line-height:40px !important}.wrapper .size-34{font-size:34px !important;line-height:43px !important}.wrapper .size-36{font-size:36px !important;line-height:43px !important}.wrapper 
.size-40{font-size:40px !important;line-height:47px !important}.wrapper .size-44{font-size:44px !important;line-height:50px !important}.wrapper .size-48{font-size:48px !important;line-height:54px !important}.wrapper .size-56{font-size:56px !important;line-height:60px !important}.wrapper .size-64{font-size:64px !important;line-height:63px !important}}
</style>
    <meta name=\"x-apple-disable-message-reformatting\" />
    <style type=\"text/css\">
body {
  margin: 0;
  padding: 0;
}
table {
  border-collapse: collapse;
  table-layout: fixed;
}
* {
  line-height: inherit;
}
[x-apple-data-detectors] {
  color: inherit !important;
  text-decoration: none !important;
}
.wrapper .footer__share-button a:hover,
.wrapper .footer__share-button a:focus {
  color: #ffffff !important;
}
.btn a:hover,
.btn a:focus,
.footer__share-button a:hover,
.footer__share-button a:focus,
.email-footer__links a:hover,
.email-footer__links a:focus {
  opacity: 0.8;
}
.preheader,
.header,
.layout,
.column {
  transition: width 0.25s ease-in-out, max-width 0.25s ease-in-out;
}
.preheader td {
  padding-bottom: 8px;
}
.layout,
div.header {
  max-width: 400px !important;
  -fallback-width: 95% !important;
  width: calc(100% - 20px) !important;
}
div.preheader {
  max-width: 360px !important;
  -fallback-width: 90% !important;
  width: calc(100% - 60px) !important;
}
.snippet,
.webversion {
  Float: none !important;
}
.stack .column {
  max-width: 400px !important;
  width: 100% !important;
}
.fixed-width.has-border {
  max-width: 402px !important;
}
.fixed-width.has-border .layout__inner {
  box-sizing: border-box;
}
.snippet,
.webversion {
  width: 50% !important;
}
.ie .btn {
  width: 100%;
}
.ie .stack .column,
.ie .stack .gutter {
  display: table-cell;
  float: none !important;
}
.ie div.preheader,
.ie .email-footer {
  max-width: 560px !important;
  width: 560px !important;
}
.ie .snippet,
.ie .webversion {
  width: 280px !important;
}
.ie div.header,
.ie .layout {
  max-width: 600px !important;
  width: 600px !important;
}
.ie .two-col .column {
  max-width: 300px !important;
  width: 300px !important;
}
.ie .three-col .column,
.ie .narrow {
  max-width: 200px !important;
  width: 200px !important;
}
.ie .wide {
  width: 400px !important;
}
.ie .stack.fixed-width.has-border,
.ie .stack.has-gutter.has-border {
  max-width: 602px !important;
  width: 602px !important;
}
.ie .stack.two-col.has-gutter .column {
  max-width: 290px !important;
  width: 290px !important;
}
.ie .stack.three-col.has-gutter .column,
.ie .stack.has-gutter .narrow {
  max-width: 188px !important;
  width: 188px !important;
}
.ie .stack.has-gutter .wide {
  max-width: 394px !important;
  width: 394px !important;
}
.ie .stack.two-col.has-gutter.has-border .column {
  max-width: 292px !important;
  width: 292px !important;
}
.ie .stack.three-col.has-gutter.has-border .column,
.ie .stack.has-gutter.has-border .narrow {
  max-width: 190px !important;
  width: 190px !important;
}
.ie .stack.has-gutter.has-border .wide {
  max-width: 396px !important;
  width: 396px !important;
}
.ie .fixed-width .layout__inner {
  border-left: 0 none white !important;
  border-right: 0 none white !important;
}
.ie .layout__edges {
  display: none;
}
.mso .layout__edges {
  font-size: 0;
}
.layout-fixed-width,
.mso .layout-full-width {
  background-color: #ffffff;
}
@media only screen and (min-width: 620px) {
  .column,
  .gutter {
    display: table-cell;
    Float: none !important;
    vertical-align: top;
  }
  div.preheader,
  .email-footer {
    max-width: 560px !important;
    width: 560px !important;
  }
  .snippet,
  .webversion {
    width: 280px !important;
  }
  div.header,
  .layout,
  .one-col .column {
    max-width: 600px !important;
    width: 600px !important;
  }
  .fixed-width.has-border,
  .fixed-width.x_has-border,
  .has-gutter.has-border,
  .has-gutter.x_has-border {
    max-width: 602px !important;
    width: 602px !important;
  }
  .two-col .column {
    max-width: 300px !important;
    width: 300px !important;
  }
  .three-col .column,
  .column.narrow,
  .column.x_narrow {
    max-width: 200px !important;
    width: 200px !important;
  }
  .column.wide,
  .column.x_wide {
    width: 400px !important;
  }
  .two-col.has-gutter .column,
  .two-col.x_has-gutter .column {
    max-width: 290px !important;
    width: 290px !important;
  }
  .three-col.has-gutter .column,
  .three-col.x_has-gutter .column,
  .has-gutter .narrow {
    max-width: 188px !important;
    width: 188px !important;
  }
  .has-gutter .wide {
    max-width: 394px !important;
    width: 394px !important;
  }
  .two-col.has-gutter.has-border .column,
  .two-col.x_has-gutter.x_has-border .column {
    max-width: 292px !important;
    width: 292px !important;
  }
  .three-col.has-gutter.has-border .column,
  .three-col.x_has-gutter.x_has-border .column,
  .has-gutter.has-border .narrow,
  .has-gutter.x_has-border .narrow {
    max-width: 190px !important;
    width: 190px !important;
  }
  .has-gutter.has-border .wide,
  .has-gutter.x_has-border .wide {
    max-width: 396px !important;
    width: 396px !important;
  }
}
@supports (display: flex) {
  @media only screen and (min-width: 620px) {
    .fixed-width.has-border .layout__inner {
      display: flex !important;
    }
  }
}
@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
  .fblike {
    background-image: url(https://i7.createsend1.com/static/eb/master/13-the-blueprint-3/images/fblike@2x.png) !important;
  }
  .tweet {
    background-image: url(https://i8.createsend1.com/static/eb/master/13-the-blueprint-3/images/tweet@2x.png) !important;
  }
  .linkedinshare {
    background-image: url(https://i9.createsend1.com/static/eb/master/13-the-blueprint-3/images/lishare@2x.png) !important;
  }
  .forwardtoafriend {
    background-image: url(https://i10.createsend1.com/static/eb/master/13-the-blueprint-3/images/forward@2x.png) !important;
  }
}
@media (max-width: 321px) {
  .fixed-width.has-border .layout__inner {
    border-width: 1px 0 !important;
  }
  .layout,
  .stack .column {
    min-width: 320px !important;
    width: 320px !important;
  }
  .border {
    display: none;
  }
  .has-gutter .border {
    display: table-cell;
  }
}
.mso div {
  border: 0 none white !important;
}
.mso .w560 .divider {
  Margin-left: 260px !important;
  Margin-right: 260px !important;
}
.mso .w360 .divider {
  Margin-left: 160px !important;
  Margin-right: 160px !important;
}
.mso .w260 .divider {
  Margin-left: 110px !important;
  Margin-right: 110px !important;
}
.mso .w160 .divider {
  Margin-left: 60px !important;
  Margin-right: 60px !important;
}
.mso .w354 .divider {
  Margin-left: 157px !important;
  Margin-right: 157px !important;
}
.mso .w250 .divider {
  Margin-left: 105px !important;
  Margin-right: 105px !important;
}
.mso .w148 .divider {
  Margin-left: 54px !important;
  Margin-right: 54px !important;
}
.mso .size-8,
.ie .size-8 {
  font-size: 8px !important;
  line-height: 14px !important;
}
.mso .size-9,
.ie .size-9 {
  font-size: 9px !important;
  line-height: 16px !important;
}
.mso .size-10,
.ie .size-10 {
  font-size: 10px !important;
  line-height: 18px !important;
}
.mso .size-11,
.ie .size-11 {
  font-size: 11px !important;
  line-height: 19px !important;
}
.mso .size-12,
.ie .size-12 {
  font-size: 12px !important;
  line-height: 19px !important;
}
.mso .size-13,
.ie .size-13 {
  font-size: 13px !important;
  line-height: 21px !important;
}
.mso .size-14,
.ie .size-14 {
  font-size: 14px !important;
  line-height: 21px !important;
}
.mso .size-15,
.ie .size-15 {
  font-size: 15px !important;
  line-height: 23px !important;
}
.mso .size-16,
.ie .size-16 {
  font-size: 16px !important;
  line-height: 24px !important;
}
.mso .size-17,
.ie .size-17 {
  font-size: 17px !important;
  line-height: 26px !important;
}
.mso .size-18,
.ie .size-18 {
  font-size: 18px !important;
  line-height: 26px !important;
}
.mso .size-20,
.ie .size-20 {
  font-size: 20px !important;
  line-height: 28px !important;
}
.mso .size-22,
.ie .size-22 {
  font-size: 22px !important;
  line-height: 31px !important;
}
.mso .size-24,
.ie .size-24 {
  font-size: 24px !important;
  line-height: 32px !important;
}
.mso .size-26,
.ie .size-26 {
  font-size: 26px !important;
  line-height: 34px !important;
}
.mso .size-28,
.ie .size-28 {
  font-size: 28px !important;
  line-height: 36px !important;
}
.mso .size-30,
.ie .size-30 {
  font-size: 30px !important;
  line-height: 38px !important;
}
.mso .size-32,
.ie .size-32 {
  font-size: 32px !important;
  line-height: 40px !important;
}
.mso .size-34,
.ie .size-34 {
  font-size: 34px !important;
  line-height: 43px !important;
}
.mso .size-36,
.ie .size-36 {
  font-size: 36px !important;
  line-height: 43px !important;
}
.mso .size-40,
.ie .size-40 {
  font-size: 40px !important;
  line-height: 47px !important;
}
.mso .size-44,
.ie .size-44 {
  font-size: 44px !important;
  line-height: 50px !important;
}
.mso .size-48,
.ie .size-48 {
  font-size: 48px !important;
  line-height: 54px !important;
}
.mso .size-56,
.ie .size-56 {
  font-size: 56px !important;
  line-height: 60px !important;
}
.mso .size-64,
.ie .size-64 {
  font-size: 64px !important;
  line-height: 63px !important;
}
</style>
    
  <style type=\"text/css\">
body{background-color:#2187cf}.logo a:hover,.logo a:focus{color:#fff !important}.mso .layout-has-border{border-top:1px solid #134e77;border-bottom:1px solid #134e77}.mso .layout-has-bottom-border{border-bottom:1px solid #134e77}.mso .border,.ie .border{background-color:#134e77}.mso h1,.ie h1{}.mso h1,.ie h1{font-size:64px !important;line-height:63px !important}.mso h2,.ie h2{}.mso h2,.ie h2{font-size:30px !important;line-height:38px !important}.mso h3,.ie h3{}.mso h3,.ie h3{font-size:22px !important;line-height:31px !important}.mso .layout__inner,.ie .layout__inner{}.mso .footer__share-button p{}.mso .footer__share-button p{font-family:sans-serif}
</style><meta name=\"robots\" content=\"noindex,nofollow\" />
<meta property=\"og:title\" content=\"My First Campaign\" />
</head>
<!--[if mso]>
  <body class=\"mso\">
<![endif]-->
<!--[if !mso]><!-->
  <body class=\"half-padding\" style=\"margin: 0;padding: 0;-webkit-text-size-adjust: 100%;\">
<!--<![endif]-->
    <table class=\"wrapper\" style=\"border-collapse: collapse;table-layout: fixed;min-width: 320px;width: 100%;background-color: #2187cf;\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\"><tbody><tr><td>
      <div role=\"banner\">
        <div class=\"preheader\" style=\"Margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;width: calc(28000% - 167440px);\">
          <div style=\"border-collapse: collapse;display: table;width: 100%;\">
          <!--[if (mso)|(IE)]><table align=\"center\" class=\"preheader\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\"><tr><td style=\"width: 280px\" valign=\"top\"><![endif]-->
            <div class=\"snippet\" style=\"display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;width: calc(14000% - 78120px);padding: 10px 0 5px 0;color: #adb3b9;font-family: sans-serif;\">
              
            </div>
          <!--[if (mso)|(IE)]></td><td style=\"width: 280px\" valign=\"top\"><![endif]-->
            <div class=\"webversion\" style=\"display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;width: calc(14100% - 78680px);padding: 10px 0 5px 0;text-align: right;color: #adb3b9;font-family: sans-serif;\">
              
            </div>
          <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
          </div>
        </div>
        
      </div>
      <div>
      <div style=\"background-color: #fff;\">
        <div class=\"layout one-col stack\" style=\"Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;\">
          <div class=\"layout__inner\" style=\"border-collapse: collapse;display: table;width: 100%;\">
          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\"><tr class=\"layout-full-width\" style=\"background-color: #fff;\"><td class=\"layout__edges\">&nbsp;</td><td style=\"width: 600px\" class=\"w560\"><![endif]-->
            <div class=\"column\" style=\"text-align: left;color: #8e959c;font-size: 14px;line-height: 21px;font-family: sans-serif;\">
            
              <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 12px;Margin-bottom: 12px;\">
      <div style=\"mso-line-height-rule: exactly;mso-text-raise: 11px;vertical-align: middle;\">
        <h2 style=\"Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #18527c;font-size: 26px;line-height: 34px;font-family: Avenir,sans-serif;text-align: center;\"><strong>PTO Request for $name</strong></h2>
      </div>
    </div>
            
            </div>
          <!--[if (mso)|(IE)]></td><td class=\"layout__edges\">&nbsp;</td></tr></table><![endif]-->
          </div>
        </div>
      </div>
  
      <div style=\"background-color: #fff;\">
        <div class=\"layout three-col stack\" style=\"Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;\">
          <div class=\"layout__inner\" style=\"border-collapse: collapse;display: table;width: 100%;\">
          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\"><tr class=\"layout-full-width\" style=\"background-color: #fff;\"><td class=\"layout__edges\">&nbsp;</td><td style=\"width: 200px\" valign=\"top\" class=\"w160\"><![endif]-->
            <div class=\"column\" style=\"text-align: left;color: #8e959c;font-size: 14px;line-height: 21px;font-family: sans-serif;max-width: 320px;min-width: 200px; width: 320px;width: calc(72200px - 12000%);Float: left;\">
            
              <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 12px;Margin-bottom: 12px;\">
      <div style=\"mso-line-height-rule: exactly;mso-text-raise: 11px;vertical-align: middle;\">
        <h3 class=\"size-18\" style=\"Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #18527c;font-size: 17px;line-height: 26px;font-family: Avenir,sans-serif;text-align: center;\" lang=\"x-size-18\"><strong>Name</strong></h3>
      </div>
    </div>
            
            </div>
          <!--[if (mso)|(IE)]></td><td style=\"width: 200px\" valign=\"top\" class=\"w160\"><![endif]-->
            <div class=\"column\" style=\"text-align: left;color: #8e959c;font-size: 14px;line-height: 21px;font-family: sans-serif;max-width: 320px;min-width: 200px; width: 320px;width: calc(72200px - 12000%);Float: left;\">
            
              <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 12px;Margin-bottom: 12px;\">
      <div style=\"mso-line-height-rule: exactly;mso-text-raise: 11px;vertical-align: middle;\">
        <h3 class=\"size-18\" style=\"Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #18527c;font-size: 17px;line-height: 26px;font-family: Avenir,sans-serif;text-align: center;\" lang=\"x-size-18\"><strong>Date Range</strong></h3>
      </div>
    </div>
            
            </div>
          <!--[if (mso)|(IE)]></td><td style=\"width: 200px\" valign=\"top\" class=\"w160\"><![endif]-->
            <div class=\"column\" style=\"text-align: left;color: #8e959c;font-size: 14px;line-height: 21px;font-family: sans-serif;max-width: 320px;min-width: 200px; width: 320px;width: calc(72200px - 12000%);Float: left;\">
            
              <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 12px;Margin-bottom: 12px;\">
      <div style=\"mso-line-height-rule: exactly;mso-text-raise: 11px;vertical-align: middle;\">
        <h3 class=\"size-18\" style=\"Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #18527c;font-size: 17px;line-height: 26px;font-family: Avenir,sans-serif;text-align: center;\" lang=\"x-size-18\"><strong>Hours Requested</strong></h3>
      </div>
    </div>
            
            </div>
          <!--[if (mso)|(IE)]></td><td class=\"layout__edges\">&nbsp;</td></tr></table><![endif]-->
          </div>
        </div>
      </div>
  
      <div style=\"background-color: #fff;\">
        <div class=\"layout three-col stack\" style=\"Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;\">
          <div class=\"layout__inner\" style=\"border-collapse: collapse;display: table;width: 100%;\">
          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\"><tr class=\"layout-full-width\" style=\"background-color: #fff;\"><td class=\"layout__edges\">&nbsp;</td><td style=\"width: 200px\" valign=\"top\" class=\"w160\"><![endif]-->
            <div class=\"column\" style=\"text-align: left;color: #8e959c;font-size: 14px;line-height: 21px;font-family: sans-serif;max-width: 320px;min-width: 200px; width: 320px;width: calc(72200px - 12000%);Float: left;\">
            
              <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 12px;Margin-bottom: 12px;\">
      <div style=\"mso-line-height-rule: exactly;mso-text-raise: 11px;vertical-align: middle;\">
        <p style=\"Margin-top: 0;Margin-bottom: 0;text-align: center;\">$name</p>
      </div>
    </div>
            
            </div>
          <!--[if (mso)|(IE)]></td><td style=\"width: 200px\" valign=\"top\" class=\"w160\"><![endif]-->
            <div class=\"column\" style=\"text-align: left;color: #8e959c;font-size: 14px;line-height: 21px;font-family: sans-serif;max-width: 320px;min-width: 200px; width: 320px;width: calc(72200px - 12000%);Float: left;\">
            
              <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 12px;Margin-bottom: 12px;\">
      <div style=\"mso-line-height-rule: exactly;mso-text-raise: 11px;vertical-align: middle;\">
        <p style=\"Margin-top: 0;Margin-bottom: 0;text-align: center;\">$startdate - $enddate</p>
      </div>
    </div>
            
            </div>
          <!--[if (mso)|(IE)]></td><td style=\"width: 200px\" valign=\"top\" class=\"w160\"><![endif]-->
            <div class=\"column\" style=\"text-align: left;color: #8e959c;font-size: 14px;line-height: 21px;font-family: sans-serif;max-width: 320px;min-width: 200px; width: 320px;width: calc(72200px - 12000%);Float: left;\">
            
              <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 12px;Margin-bottom: 12px;\">
      <div style=\"mso-line-height-rule: exactly;mso-text-raise: 11px;vertical-align: middle;\">
        <p style=\"Margin-top: 0;Margin-bottom: 0;text-align: center;\">$hours $hourtext</p>
      </div>
    </div>
            
            </div>
          <!--[if (mso)|(IE)]></td><td class=\"layout__edges\">&nbsp;</td></tr></table><![endif]-->
          </div>
        </div>
      </div>
  
      <div class=\"layout two-col has-gutter stack\" style=\"Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;\">
        <div class=\"layout__inner\" style=\"border-collapse: collapse;display: table;width: 100%;\">
        <!--[if (mso)|(IE)]><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\"><tr><td style=\"width: 290px\" valign=\"top\" class=\"w250\"><![endif]-->
          <div class=\"column\" style=\"max-width: 320px;min-width: 290px; width: 320px;width: calc(18290px - 3000%);Float: left;\">
            <table class=\"column__background\" style=\"border-collapse: collapse;table-layout: fixed;background-color: #2187cf;\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" role=\"presentation\">
              <tbody><tr>
                <td style=\"text-align: left;color: #8e959c;font-size: 14px;line-height: 21px;font-family: sans-serif;\">
                
                  <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 12px;Margin-bottom: 12px;\">
      <div class=\"btn btn--shadow btn--large\" style=\"text-align:left;\">
        <![if !mso]><a style=\"border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px 13px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #ffffff !important;box-shadow: inset 0 -2px 0 0 rgba(0, 0, 0, 0.2);background-color: #8e959c;font-family: Avenir, sans-serif;\" href=\"http://vprsrv2/outboard.php\">Outboard</a><![endif]>
      <!--[if mso]><p style=\"line-height:0;margin:0;\">&nbsp;</p><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" href=\"http://vprsrv2/outboard.php\" style=\"width:111px\" arcsize=\"9%\" fillcolor=\"#8E959C\" stroke=\"f\"><v:shadow on=\"t\" color=\"#72777D\" offset=\"0,2px\"></v:shadow><v:textbox style=\"mso-fit-shape-to-text:t\" inset=\"0px,11px,0px,10px\"><center style=\"font-size:14px;line-height:24px;color:#FFFFFF;font-family:Avenir,sans-serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px\">Outboard</center></v:textbox></v:roundrect><![endif]--></div>
    </div>
                
                </td>
              </tr>
            </tbody></table>
          </div>
        <!--[if (mso)|(IE)]></td><td style=\"width: 20px\"><![endif]--><div class=\"gutter\" style=\"Float: left;width: 20px;\">&nbsp;</div><!--[if (mso)|(IE)]></td><td style=\"width: 290px\" valign=\"top\" class=\"w250\"><![endif]-->
          <div class=\"column\" style=\"max-width: 320px;min-width: 290px; width: 320px;width: calc(18290px - 3000%);Float: left;\">
            <table class=\"column__background\" style=\"border-collapse: collapse;table-layout: fixed;background-color: #2187cf;\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" role=\"presentation\">
              <tbody><tr>
                <td style=\"text-align: left;color: #8e959c;font-size: 14px;line-height: 21px;font-family: sans-serif;\">
                
                  <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 12px;Margin-bottom: 12px;\">
      <div class=\"btn btn--shadow btn--large\" style=\"text-align:right;\">
        <![if !mso]><a style=\"border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px 13px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #ffffff !important;box-shadow: inset 0 -2px 0 0 rgba(0, 0, 0, 0.2);background-color: #8e959c;font-family: Avenir, sans-serif;\" href=\"http://vprsrv2/approvePTO.php\">See PTO Requests</a><![endif]>
      <!--[if mso]><p style=\"line-height:0;margin:0;\">&nbsp;</p><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" href=\"http://vprsrv2/approvePTO.php\" style=\"width:172px\" arcsize=\"9%\" fillcolor=\"#8E959C\" stroke=\"f\"><v:shadow on=\"t\" color=\"#72777D\" offset=\"0,2px\"></v:shadow><v:textbox style=\"mso-fit-shape-to-text:t\" inset=\"0px,11px,0px,10px\"><center style=\"font-size:14px;line-height:24px;color:#FFFFFF;font-family:Avenir,sans-serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px\">See PTO Requests</center></v:textbox></v:roundrect><![endif]--></div>
    </div>
                
                </td>
              </tr>
            </tbody></table>
          </div>
        <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
        </div>
      </div>
  
      <div style=\"mso-line-height-rule: exactly;line-height: 20px;font-size: 20px;\">&nbsp;</div>
  
      
      <div role=\"contentinfo\">
        <div class=\"layout email-footer stack\" style=\"Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;\">
          <div class=\"layout__inner\" style=\"border-collapse: collapse;display: table;width: 100%;\">
          <!--[if (mso)|(IE)]><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\"><tr class=\"layout-email-footer\"><td style=\"width: 400px;\" valign=\"top\" class=\"w360\"><![endif]-->
            <div class=\"column wide\" style=\"text-align: left;font-size: 12px;line-height: 19px;color: #adb3b9;font-family: sans-serif;Float: left;max-width: 400px;min-width: 320px; width: 320px;width: calc(8000% - 47600px);\">
              <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;\">
                
                <div style=\"font-size: 12px;line-height: 19px;\">
                  
                </div>
                <div style=\"font-size: 12px;line-height: 19px;Margin-top: 18px;\">
                  
                </div>
                <!--[if mso]>&nbsp;<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td><td style=\"width: 200px;\" valign=\"top\" class=\"w160\"><![endif]-->
            <div class=\"column narrow\" style=\"text-align: left;font-size: 12px;line-height: 19px;color: #adb3b9;font-family: sans-serif;Float: left;max-width: 320px;min-width: 200px; width: 320px;width: calc(72200px - 12000%);\">
              <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;\">
                
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
          </div>
        </div>
        <div class=\"layout one-col email-footer\" style=\"Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;\">
          <div class=\"layout__inner\" style=\"border-collapse: collapse;display: table;width: 100%;\">
          <!--[if (mso)|(IE)]><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\"><tr class=\"layout-email-footer\"><td style=\"width: 600px;\" class=\"w560\"><![endif]-->
            <div class=\"column\" style=\"text-align: left;font-size: 12px;line-height: 19px;color: #adb3b9;font-family: sans-serif;\">
              <div style=\"Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;\">
                <div style=\"font-size: 12px;line-height: 19px;\">
                  <unsubscribe style=\"text-decoration: underline;\">Unsubscribe</unsubscribe>
                </div>
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
          </div>
        </div>
      </div>
      <div style=\"line-height:40px;font-size:40px;\">&nbsp;</div>
    </div></td></tr></tbody></table>
  
</body></html>


";


	/*
	$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
 <head>
   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
   
   
 <style>@media (max-width:992px) {
  .wrap-login100 {
    padding: 177px 90px 33px 85px;
  }
  .login100-pic {
    width: 35%;
  }
  .login100-form {
    width: 50%;
  }
}
@media (max-width:768px) {
  .wrap-login100 {
    padding: 100px 80px 33px 80px;
  }
  .login100-pic {
    display: none;
  }
  .login100-form {
    width: 100%;
  }
}
@media (max-width:576px) {
  .wrap-login100 {
    padding: 100px 15px 33px 15px;
  }
}
</style>        <style type=\"text/css\">
          .ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:150%}a{text-decoration:none}@media screen and (max-width: 600px){table.row th.col-lg-1,table.row th.col-lg-2,table.row th.col-lg-3,table.row th.col-lg-4,table.row th.col-lg-5,table.row th.col-lg-6,table.row th.col-lg-7,table.row th.col-lg-8,table.row th.col-lg-9,table.row th.col-lg-10,table.row th.col-lg-11,table.row th.col-lg-12{display:block;width:100% !important}.d-mobile{display:block !important}.d-desktop{display:none !important}.w-lg-25{width:auto !important}.w-lg-25>tbody>tr>td{width:auto !important}.w-lg-50{width:auto !important}.w-lg-50>tbody>tr>td{width:auto !important}.w-lg-75{width:auto !important}.w-lg-75>tbody>tr>td{width:auto !important}.w-lg-100{width:auto !important}.w-lg-100>tbody>tr>td{width:auto !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.w-25{width:25% !important}.w-25>tbody>tr>td{width:25% !important}.w-50{width:50% !important}.w-50>tbody>tr>td{width:50% !important}.w-75{width:75% !important}.w-75>tbody>tr>td{width:75% !important}.w-100{width:100% !important}.w-100>tbody>tr>td{width:100% !important}.w-auto{width:auto !important}.w-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:0 !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:0 !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:0 !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:0 !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:0 !important}.p-lg-2>tbody>tr>td{padding:0 !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:0 !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:0 !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:0 !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:0 !important}.p-lg-3>tbody>tr>td{padding:0 !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:0 !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:0 !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:0 !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:0 !important}.p-lg-4>tbody>tr>td{padding:0 !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:0 !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:0 !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:0 !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:0 !important}.p-lg-5>tbody>tr>td{padding:0 !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:0 !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:0 !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:0 !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:0 !important}.p-0>tbody>tr>td{padding:0 !important}.pt-0>tbody>tr>td,.py-0>tbody>tr>td{padding-top:0 !important}.pr-0>tbody>tr>td,.px-0>tbody>tr>td{padding-right:0 !important}.pb-0>tbody>tr>td,.py-0>tbody>tr>td{padding-bottom:0 !important}.pl-0>tbody>tr>td,.px-0>tbody>tr>td{padding-left:0 !important}.p-1>tbody>tr>td{padding:4px !important}.pt-1>tbody>tr>td,.py-1>tbody>tr>td{padding-top:4px !important}.pr-1>tbody>tr>td,.px-1>tbody>tr>td{padding-right:4px !important}.pb-1>tbody>tr>td,.py-1>tbody>tr>td{padding-bottom:4px !important}.pl-1>tbody>tr>td,.px-1>tbody>tr>td{padding-left:4px !important}.p-2>tbody>tr>td{padding:8px !important}.pt-2>tbody>tr>td,.py-2>tbody>tr>td{padding-top:8px !important}.pr-2>tbody>tr>td,.px-2>tbody>tr>td{padding-right:8px !important}.pb-2>tbody>tr>td,.py-2>tbody>tr>td{padding-bottom:8px !important}.pl-2>tbody>tr>td,.px-2>tbody>tr>td{padding-left:8px !important}.p-3>tbody>tr>td{padding:16px !important}.pt-3>tbody>tr>td,.py-3>tbody>tr>td{padding-top:16px !important}.pr-3>tbody>tr>td,.px-3>tbody>tr>td{padding-right:16px !important}.pb-3>tbody>tr>td,.py-3>tbody>tr>td{padding-bottom:16px !important}.pl-3>tbody>tr>td,.px-3>tbody>tr>td{padding-left:16px !important}.p-4>tbody>tr>td{padding:24px !important}.pt-4>tbody>tr>td,.py-4>tbody>tr>td{padding-top:24px !important}.pr-4>tbody>tr>td,.px-4>tbody>tr>td{padding-right:24px !important}.pb-4>tbody>tr>td,.py-4>tbody>tr>td{padding-bottom:24px !important}.pl-4>tbody>tr>td,.px-4>tbody>tr>td{padding-left:24px !important}.p-5>tbody>tr>td{padding:48px !important}.pt-5>tbody>tr>td,.py-5>tbody>tr>td{padding-top:48px !important}.pr-5>tbody>tr>td,.px-5>tbody>tr>td{padding-right:48px !important}.pb-5>tbody>tr>td,.py-5>tbody>tr>td{padding-bottom:48px !important}.pl-5>tbody>tr>td,.px-5>tbody>tr>td{padding-left:48px !important}.s-lg-1>tbody>tr>td,.s-lg-2>tbody>tr>td,.s-lg-3>tbody>tr>td,.s-lg-4>tbody>tr>td,.s-lg-5>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}@media yahoo{.d-mobile{display:none !important}.d-desktop{display:block !important}.w-lg-25{width:25% !important}.w-lg-25>tbody>tr>td{width:25% !important}.w-lg-50{width:50% !important}.w-lg-50>tbody>tr>td{width:50% !important}.w-lg-75{width:75% !important}.w-lg-75>tbody>tr>td{width:75% !important}.w-lg-100{width:100% !important}.w-lg-100>tbody>tr>td{width:100% !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:4px !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:4px !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:4px !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:4px !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:4px !important}.p-lg-2>tbody>tr>td{padding:8px !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:8px !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:8px !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:8px !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:8px !important}.p-lg-3>tbody>tr>td{padding:16px !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:16px !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:16px !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:16px !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:16px !important}.p-lg-4>tbody>tr>td{padding:24px !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:24px !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:24px !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:24px !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:24px !important}.p-lg-5>tbody>tr>td{padding:48px !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:48px !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:48px !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:48px !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:48px !important}.s-lg-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-lg-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-lg-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-lg-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-lg-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-lg-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}

        </style>
</head>
 <!-- Edit the code below this line -->
 <body style=\"outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; margin: 0; padding: 0; border: 0;\">
<div class=\"preview\" style=\"display: none; max-height: 0px; overflow: hidden;\">
  PTO Request for Matt M                                                                              
</div>
<table valign=\"top\" class=\"bg-light body\" style=\"outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; margin: 0; padding: 0; border: 0;\" bgcolor=\"#f8f9fa\">
  <tbody>
    <tr>
      <td valign=\"top\" style=\"border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;\" align=\"left\" bgcolor=\"#f8f9fa\">
        


				<div class=\"container-login100\" style=\"width: 100%; min-height: 100vh; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; background-image: linear-gradient(-135deg,#3e94ec,navy); margin: 0; padding: 15px;\">
					<table class=\"\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse;\">
  <tbody>
    <tr>
      <td style=\"border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;\" align=\"left\">
        <div class=\"wrap-login100\" style=\"width: 960px; background-color: #fff; border-radius: 10px; overflow: hidden; display: flex; flex-wrap: wrap; justify-content: space-between; padding: 25px;\">
						<table class=\"container\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%;\">
  <tbody>
    <tr>
      <td align=\"center\" style=\"border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;\">
        <!--[if (gte mso 9)|(IE)]>
          <table align=\"center\">
            <tbody>
              <tr>
                <td width=\"600\">
        <![endif]-->
        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 600px; margin: 0 auto;\">
          <tbody>
            <tr>
              <td style=\"border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;\" align=\"left\">
                
							<table class=\"row\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; margin-right: -15px; margin-left: -15px; table-layout: fixed; width: 100%; margin-top: 0;\">
  <thead style=\"padding: 0 0 0 3rem;\">
    <tr>
      
							<h2 style=\"margin-top: 0; margin-bottom: 0; font-weight: 500; color: inherit; vertical-align: baseline; font-size: 32px; line-height: 38.4px;\" align=\"left\">
<img class=\"img-fluid\" width=\"300\" height=\"125\" src=http://spindletopoil.com/SOGLOGO-01.svg alt=\"IMG\" style=\"height: auto; line-height: 100%; outline: none; text-decoration: none; width: 100%; max-width: 100%; border: 0 none;\"> <br>
							PTO Request for $name</h2>
							
    </tr>
  </thead>
</table>

							<br>
							<table class=\"row\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; margin-right: -15px; margin-left: -15px; table-layout: fixed; width: 100%; margin-top: 0;\">
  <thead style=\"padding: 0 0 0 3rem;\">
    <tr>
      
								<th class=\"col\" align=\"left\" valign=\"top\" style=\"line-height: 24px; font-size: 16px; margin: 0;\">
  <h3 style=\"margin-top: 0; margin-bottom: 0; font-weight: 500; color: inherit; vertical-align: baseline; font-size: 28px; line-height: 33.6px;\" align=\"left\">Name</h3>
</th>

								<th class=\"col\" align=\"left\" valign=\"top\" style=\"line-height: 24px; font-size: 16px; margin: 0;\">
  <h3 style=\"margin-top: 0; margin-bottom: 0; font-weight: 500; color: inherit; vertical-align: baseline; font-size: 28px; line-height: 33.6px;\" align=\"left\">Start Date</h3>
</th>

								<th class=\"col\" align=\"left\" valign=\"top\" style=\"line-height: 24px; font-size: 16px; margin: 0;\">
  <h3 style=\"margin-top: 0; margin-bottom: 0; font-weight: 500; color: inherit; vertical-align: baseline; font-size: 28px; line-height: 33.6px;\" align=\"left\">End Date</h3>
</th>

								<th class=\"col\" align=\"left\" valign=\"top\" style=\"line-height: 24px; font-size: 16px; margin: 0;\">
  <h3 style=\"margin-top: 0; margin-bottom: 0; font-weight: 500; color: inherit; vertical-align: baseline; font-size: 28px; line-height: 33.6px;\" align=\"left\">Hours Requested</h3>
</th>

							
    </tr>
  </thead>
</table>

							<table class=\"row\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; margin-right: -15px; margin-left: -15px; table-layout: fixed; width: 100%; margin-top: 0;\">
  <thead style=\"padding: 0 0 0 3rem;\">
    <tr>
      
								<th class=\"col\" align=\"left\" valign=\"top\" style=\"line-height: 24px; font-size: 16px; margin: 0;\">
  <h4 style=\"margin-top: 0; margin-bottom: 0; font-weight: 500; color: inherit; vertical-align: baseline; font-size: 24px; line-height: 28.8px;\" align=\"left\">$name</h4>
</th>

								<th class=\"col\" align=\"left\" valign=\"top\" style=\"line-height: 24px; font-size: 16px; margin: 0;\">
  <h4 style=\"margin-top: 0; margin-bottom: 0; font-weight: 500; color: inherit; vertical-align: baseline; font-size: 24px; line-height: 28.8px;\" align=\"left\">$startdate</h4>
</th>

								<th class=\"col\" align=\"left\" valign=\"top\" style=\"line-height: 24px; font-size: 16px; margin: 0;\">
  <h4 style=\"margin-top: 0; margin-bottom: 0; font-weight: 500; color: inherit; vertical-align: baseline; font-size: 24px; line-height: 28.8px;\" align=\"left\">$enddate</h4>
</th>

								<th class=\"col\" align=\"left\" valign=\"top\" style=\"line-height: 24px; font-size: 16px; margin: 0;\">
  <h4 style=\"margin-top: 0; margin-bottom: 0; font-weight: 500; color: inherit; vertical-align: baseline; font-size: 24px; line-height: 28.8px;\" align=\"left\">$hours $hourtext</h4>
</th>

							
    </tr>
  </thead>
</table>

							<br>
							<div col=\"row\">
							<a href=\"vprsrv2/outboard.php\" class=\"navbar-btn\" style=\"color: #fff; text-decoration: none; font-size: 17px; text-align: center; display: inline-block; border-radius: 5px; text-shadow: 0 1px 1px rgba(256,256,256,.1); box-shadow: 0 6px 20px 0 rgba(0,0,0,.19); background-color: #494949; padding: 12px;\">Go to the Outboard</a>
							<a href=\"vprsrv2/approvePTO.php\" class=\"navbar-btn\" style=\"color: #fff; text-decoration: none; font-size: 17px; text-align: center; display: inline-block; border-radius: 5px; text-shadow: 0 1px 1px rgba(256,256,256,.1); box-shadow: 0 6px 20px 0 rgba(0,0,0,.19); background-color: #494949; padding: 12px;\">Approve/Deny PTO</a>
						</div>
						
              </td>
            </tr>
          </tbody>
        </table>
        <!--[if (gte mso 9)|(IE)]>
                </td>
              </tr>
            </tbody>
          </table>
        <![endif]-->
      </td>
    </tr>
  </tbody>
</table>

					</div>
      </td>
    </tr>
  </tbody>
</table>

				</div>			
			

 
      </td>
    </tr>
  </tbody>
</table>
</body>
</html>



				";
	*/

	/*$html = "
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
*/
/*
$from = "PTO Request <pto@spindletopoil.com>";
$to = "Recipient Name <cmmazzini@spindletopoil.com>";
$subject = " Test PHP Pear Mail ";
$txt = " This mail has sent correctly. ";
*/

/*
$html = "
		<html>
		<head>
		  <title>PTO Request</title>
		</head>
		<body>
		  <p>Here are the details of the request:</p>
		  <table>
			<tr>
			  <th>Name</th><th>Start Day</th><th>End Day</th><th>Start Time</th><th>End Time</th>
			</tr>
			<tr>
			  <td>Matt M</td><td>3/17</td><td>3/17</td><td>8:00:00</td><td>16:00:00</td>
			</tr>
			<tr>
			  <td>Name</td><td>Start Day</td><td>End Day</td><td>Start Time</td><td>End Time</td>
			</tr>
		  </table>
		</body>
		</html>";

*/
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


?>
