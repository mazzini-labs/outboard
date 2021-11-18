<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Annual Salary to Semimonthly Paycheck Conversion Calculator</title>
<link rel="shortcut icon" href="https://calculator.me/images/favicon.ico">
<link rel="icon" href="https://calculator.me/favicon.ico" type="image/x-icon">
<link rel='stylesheet' id='theme-style-css'  href='https://calculator.me/files/style.css?ver=3.7' type='text/css' media='all' /> <link rel='stylesheet' id='theme-font-css'  href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&#038;subset=latin,latin-ext' type='text/css' media='all' />
<script type='text/javascript' src='vendor/jquery/jquery-3.2.1.min.js'></script>
<script type='text/javascript' src='js/jquery-migrate.min.js'></script>
<!--[if lt IE 9]><script src="https://calculator.me/files/html5.js"></script><![endif]--><!--[if (gte IE 6)&(lte IE 8)]><script src="https://calculator.me/files/selectivizr-min.js"></script><![endif]-->	
<script Language='JavaScript'>

function sn(num) {

   num=num.toString();


   var len = num.length;
   var rnum = "";
   var test = "";
   var j = 0;

   var b = num.substring(0,1);
   if(b == "-") {
      rnum = "-";
   }

   for(i = 0; i <= len; i++) {

      b = num.substring(i,i+1);

      if(b == "0" || b == "1" || b == "2" || b == "3" || b == "4" || b == "5" || b == "6" || b == "7" || b == "8" || b == "9" || b == ".") {
         rnum = rnum + "" + b;

      }

   }

   if(rnum == "" || rnum == "-") {
      rnum = 0;
   }

   rnum = Number(rnum);

   return rnum;

}



function fns(num, places, comma, type, show) {

    var sym_1 = "$";
    var sym_2 = ""; 

    var isNeg=0;

    if(num < 0) {
       num=num*-1;
       isNeg=1;
    }

    var myDecFact = 1;
    var myPlaces = 0;
    var myZeros = "";
    while(myPlaces < places) {
       myDecFact = myDecFact * 10;
       myPlaces = Number(myPlaces) + Number(1);
       myZeros = myZeros + "0";
    }
    
	onum=Math.round(num*myDecFact)/myDecFact;
		
	integer=Math.floor(onum);

	if (Math.ceil(onum) == integer) {
		decimal=myZeros;
	} else{
		decimal=Math.round((onum-integer)* myDecFact)
	}
	decimal=decimal.toString();
	if (decimal.length<places) {
        fillZeroes = places - decimal.length;
	   for (z=0;z<fillZeroes;z++) {
        decimal="0"+decimal;
        }
     }

   if(places > 0) {
      decimal = "." + decimal;
   }

   if(comma == 1) {
	integer=integer.toString();
	var tmpnum="";
	var tmpinteger="";
	var y=0;

	for (x=integer.length;x>0;x--) {
		tmpnum=tmpnum+integer.charAt(x-1);
		y=y+1;
		if (y==3 & x>1) {
			tmpnum=tmpnum+",";
			y=0;
		}
	}

	for (x=tmpnum.length;x>0;x--) {
		tmpinteger=tmpinteger+tmpnum.charAt(x-1);
	}


	finNum=tmpinteger+""+decimal;
   } else {
      finNum=integer+""+decimal;
   }

    if(isNeg == 1) {
       if(type == 1 && show == 1) {
          finNum = "-" + sym_1 + "" + finNum + "" + sym_2;
       } else {
          finNum = "-" + finNum;
       }
    } else {
       if(show == 1) {
          if(type == 1) {
             finNum = sym_1 + "" + finNum + "" + sym_2;
          } else
          if(type == 2) {
             finNum = finNum + "%";
          }

       }

    }

	return finNum;
}


function compute(form)  {

      var VannualWage = 0;

      var Vwage = sn(document.calc.wage.value);
      var Vperiod = document.calc.period.selectedIndex;
      var VDailyHours = sn(document.calc.DailyHours.value);
	  if (VDailyHours > 24) { VDailyHours = 24;}
	  if (VDailyHours <= 0) { VDailyHours = 8;}
      var VWeeklyDays = sn(document.calc.WeeklyDays.value);
	  if (VWeeklyDays > 7) { VWeeklyDays = 7;}
	  if (VWeeklyDays <= 0) { VWeeklyDays = 5;}
      var VYearlyWeeks = sn(document.calc.YearlyWeeks.value);
	  if (VYearlyWeeks > 52) { VYearlyWeeks = 52;}
	  if (VYearlyWeeks <= 0) { VYearlyWeeks = 50;}
      var VTaxRate = sn(document.calc.TaxRate.value)/100;
      var VTaxAdjust = document.calc.TaxAdjust.selectedIndex;	  if (VTaxAdjust == 0) {VTaxRate = 0;}

      var VHoursWorkedPerYear = VDailyHours * VWeeklyDays * VYearlyWeeks;
      document.calc.HoursWorkedPerYear.value =  fns(VHoursWorkedPerYear,2,1,0,1);
      var VHoursWorkedPerMonth = VDailyHours * VWeeklyDays * VYearlyWeeks / 12;
      document.calc.HoursWorkedPerMonth.value =  fns(VHoursWorkedPerMonth,2,1,0,1);
      var VHoursWorkedPerWeek = VDailyHours * VWeeklyDays;
      document.calc.HoursWorkedPerWeek.value =  fns(VHoursWorkedPerWeek,2,1,0,1);

      if(Vperiod == 0) { //hourly
         VannualWage = Vwage * VWeeklyDays * VDailyHours * VYearlyWeeks;
} else
      if(Vperiod == 1) { //daily
         VannualWage = Vwage * VWeeklyDays * VYearlyWeeks;
      } else
      if(Vperiod == 2) { //weekly
         VannualWage = Vwage * VYearlyWeeks;
      } else
      if(Vperiod == 3) { //bi-weekly
         VannualWage = Vwage * VYearlyWeeks / 2;
      } else
      if(Vperiod == 4) { //semi-monthly
         VannualWage = Vwage * 24;
      } else
      if(Vperiod == 5) { //monthly
         VannualWage = Vwage * 12;
      } else
      if(Vperiod == 6) { //bi-monthly
         VannualWage = Vwage * 6;
      } else
      if(Vperiod == 7) { //quarterly
         VannualWage = Vwage * 4;
      } else
      if(Vperiod == 8) { //semi-annually
         VannualWage = Vwage * 2;
      } else
      if(Vperiod == 9) { //annually
         VannualWage = Vwage;
      }
	  
	  if (VTaxAdjust == 2) {
		  
      Vhourlytaxed = VannualWage / (VYearlyWeeks * VDailyHours * VWeeklyDays);
      document.calc.hourlytaxed.value = fns(Vhourlytaxed,2,1,1,1);
      Vhourly = Vhourlytaxed / (1-VTaxRate);
      document.calc.hourly.value = fns(Vhourly,2,1,1,1);

      Vdailytaxed = VannualWage / (VYearlyWeeks * VWeeklyDays);
      document.calc.dailytaxed.value = fns(Vdailytaxed,2,1,1,1);
      Vdaily = Vdailytaxed / (1-VTaxRate);
      document.calc.daily.value = fns(Vdaily,2,1,1,1);

      Vweeklytaxed = VannualWage / VYearlyWeeks;
      document.calc.weeklytaxed.value = fns(Vweeklytaxed,2,1,1,1);
      Vweekly = Vweeklytaxed / (1-VTaxRate);
      document.calc.weekly.value = fns(Vweekly,2,1,1,1);

      Vbiweeklytaxed = VannualWage / (VYearlyWeeks * 0.5);
      document.calc.biweeklytaxed.value = fns(Vbiweeklytaxed,2,1,1,1);
      Vbiweekly = Vbiweeklytaxed / (1-VTaxRate);
      document.calc.biweekly.value = fns(Vbiweekly,2,1,1,1);

      Vsemimonthlytaxed = VannualWage / 24;
      document.calc.semimonthlytaxed.value = fns(Vsemimonthlytaxed,2,1,1,1);
      Vsemimonthly = Vsemimonthlytaxed / (1-VTaxRate);
      document.calc.semimonthly.value = fns(Vsemimonthly,2,1,1,1);

      Vmonthlytaxed = VannualWage / 12;
      document.calc.monthlytaxed.value = fns(Vmonthlytaxed,2,1,1,1);
      Vmonthly = Vmonthlytaxed / (1-VTaxRate);
      document.calc.monthly.value = fns(Vmonthly,2,1,1,1);

      Vbimonthlytaxed = VannualWage / 6;
      document.calc.bimonthlytaxed.value = fns(Vbimonthlytaxed,2,1,1,1);
      Vbimonthly = Vbimonthlytaxed / (1-VTaxRate);
      document.calc.bimonthly.value = fns(Vbimonthly,2,1,1,1);

      Vquarterlytaxed = VannualWage / 4;
      document.calc.quarterlytaxed.value = fns(Vquarterlytaxed,2,1,1,1);
      Vquarterly = Vquarterlytaxed / (1-VTaxRate);
      document.calc.quarterly.value = fns(Vquarterly,2,1,1,1);

      Vsemiannuallytaxed = VannualWage / 2;
      document.calc.semiannuallytaxed.value = fns(Vsemiannuallytaxed,2,1,1,1);
      Vsemiannually = Vsemiannuallytaxed / (1-VTaxRate);
      document.calc.semiannually.value = fns(Vsemiannually,2,1,1,1);

      Vannuallytaxed = VannualWage;
      document.calc.annuallytaxed.value = fns(Vannuallytaxed,2,1,1,1);
      Vannually = Vannuallytaxed / (1-VTaxRate);
      document.calc.annually.value = fns(Vannually,2,1,1,1);		  
		  
		  } else {

      Vhourly = VannualWage / (VYearlyWeeks * VDailyHours * VWeeklyDays);
      document.calc.hourly.value = fns(Vhourly,2,1,1,1);
      Vhourlytaxed = Vhourly * (1-VTaxRate);
      document.calc.hourlytaxed.value = fns(Vhourlytaxed,2,1,1,1);

      Vdaily = VannualWage / (VYearlyWeeks * VWeeklyDays);
      document.calc.daily.value = fns(Vdaily,2,1,1,1);
      Vdailytaxed = Vdaily * (1-VTaxRate);
      document.calc.dailytaxed.value = fns(Vdailytaxed,2,1,1,1);

      Vweekly = VannualWage / VYearlyWeeks;
      document.calc.weekly.value = fns(Vweekly,2,1,1,1);
      Vweeklytaxed = Vweekly * (1-VTaxRate);
      document.calc.weeklytaxed.value = fns(Vweeklytaxed,2,1,1,1);

      Vbiweekly = VannualWage / (VYearlyWeeks * 0.5);
      document.calc.biweekly.value = fns(Vbiweekly,2,1,1,1);
      Vbiweeklytaxed = Vbiweekly * (1-VTaxRate);
      document.calc.biweeklytaxed.value = fns(Vbiweeklytaxed,2,1,1,1);

      Vsemimonthly = VannualWage / 24;
      document.calc.semimonthly.value = fns(Vsemimonthly,2,1,1,1);
      Vsemimonthlytaxed = Vsemimonthly * (1-VTaxRate);
      document.calc.semimonthlytaxed.value = fns(Vsemimonthlytaxed,2,1,1,1);

      Vmonthly = VannualWage / 12;
      document.calc.monthly.value = fns(Vmonthly,2,1,1,1);
      Vmonthlytaxed = Vmonthly * (1-VTaxRate);
      document.calc.monthlytaxed.value = fns(Vmonthlytaxed,2,1,1,1);

      Vbimonthly = VannualWage / 6;
      document.calc.bimonthly.value = fns(Vbimonthly,2,1,1,1);
      Vbimonthlytaxed = Vbimonthly * (1-VTaxRate);
      document.calc.bimonthlytaxed.value = fns(Vbimonthlytaxed,2,1,1,1);

      Vquarterly = VannualWage / 4;
      document.calc.quarterly.value = fns(Vquarterly,2,1,1,1);
      Vquarterlytaxed = Vquarterly * (1-VTaxRate);
      document.calc.quarterlytaxed.value = fns(Vquarterlytaxed,2,1,1,1);

      Vsemiannually = VannualWage / 2;
      document.calc.semiannually.value = fns(Vsemiannually,2,1,1,1);
      Vsemiannuallytaxed = Vsemiannually * (1-VTaxRate);
      document.calc.semiannuallytaxed.value = fns(Vsemiannuallytaxed,2,1,1,1);

      Vannually = VannualWage;
      document.calc.annually.value = fns(Vannually,2,1,1,1);
      Vannuallytaxed = Vannually * (1-VTaxRate);
      document.calc.annuallytaxed.value = fns(Vannuallytaxed,2,1,1,1);
		  }


      var Vshare = "";
         Vshare += " <div style='border: 3px dashed #86B854 ; margin: 0pt 0pt 20px; border-radius: 15px; padding: 15px; width: 90%; background-color:#F5F5F5; text-align:center; font-weight:bold;'> <img src='https://calculator.me/pic/goal.png' width='24' height='24'> Save your results for later or share them with others!<br><br><div style='word-break: break-all;'><a rel='nofollow' target='_blank' href='https://calculator.me/planning/wages.php?time="+Vperiod+"&amnt="+Vwage+"&taxes="+VTaxAdjust+"&rate="+VTaxRate*100+"&ho="+VDailyHours+"&da="+VWeeklyDays+"&we="+VYearlyWeeks+"'>https://calculator.me/planning/wages.php?time="+Vperiod+"&amnt="+Vwage+"&taxes="+VTaxAdjust+"&rate="+VTaxRate*100+"&ho="+VDailyHours+"&da="+VWeeklyDays+"&we="+VYearlyWeeks+"</a></div></div>";
      var v_share_cell = document.getElementById("share");
      v_share_cell.innerHTML = "" + Vshare + "";


}


function clear_results(form) {

      document.calc.hourly.value = "";
      document.calc.weekly.value = "";
      document.calc.biweekly.value = "";
      document.calc.semimonthly.value = "";
      document.calc.monthly.value = "";
      document.calc.quarterly.value = "";
      document.calc.annually.value = "";

}</script>

</head>

<body class="single">

<!-- #primary-nav-mobile -->
<nav id="primary-nav-mobile">
<a class="menu-toggle" href="#"></a>
<ul id="mobile-menu" class="clearfix">
<li><a href="https://calculator.me/loan/">Loans</a></li>
<li><a href="https://calculator.me/real-estate/">Mortgage</a></li>
<li><a href="https://calculator.me/vehicle/">Auto</a></li>
<li><a href="https://calculator.me/credit-cards/">Credit Cards</a></li>
<li><a href="https://calculator.me/savings/">Savings</a></li>
<li><a href="https://calculator.me/planning/">Planning</a></li>
</ul></nav>
<!-- /#primary-nav-mobile -->

<!-- #header -->
<header id="header" class="clearfix" role="banner">


<div class="container">

<div id="header-inner" class="clearfix">
<!-- #logo -->
  <div id="logo">
 <a href="https://calculator.me/"><img src="https://calculator.me/pic/headerimage.png" alt="Calculators" width="362" height="45" border="0"/></a> 
  </div>
<!-- /#logo -->


<!-- #primary-nav -->
<nav id="primary-nav" role="navigation" class="clearfix">
      <ul id="menu-menuname" class="nav sf-menu clearfix">
      <li class="menu-item"><a href="https://calculator.me/loan/">Loans</a></li>
      <li class="menu-item"><a href="https://calculator.me/real-estate/">Mortgage</a></li>
<li class="menu-item"><a href="https://calculator.me/vehicle/">Auto</a></li>
<li class="menu-item"><a href="https://calculator.me/credit-cards/">Credit Cards</a></li>
<li class="menu-item"><a href="https://calculator.me/savings/">Savings</a></li>
<li class="menu-item"><a href="https://calculator.me/planning/">Planning</a></li>
</ul>     </nav>
<!-- #primary-nav -->


</div>
</div>
</header>
<!-- /#header -->



<!-- #page-header -->
<div id="page-header" class="clearfix">
<div class="container">
<h1><img src="https://calculator.me/pic/clipboard.png" width="40px">
Convert Yearly Wages to Semi-monthly Pay</h1>
</div>
</div>
<!-- /#page-header -->

<!-- #breadcrumbs -->
<div id="page-subnav" class="clearfix">
<div class="container">
<div id="breadcrumbs"><a href="https://calculator.me/">Home</a><span class="sep">/</span><a href="https://calculator.me/planning/">Planning</a><span class="sep">/</span><a href="https://calculator.me/planning/wage-conversion.php">Conversion</a><span class="sep">/</span>Calculate Your Semimonthly Pay Check<span class="sep">/</span></div></div>
</div>
<!-- /#breadcrumbs -->

<!-- #primary -->
<div id="primary" class="sidebar- clearfix"> 
<div class="container">
  <!-- #content -->
  <section id="content" role="main">

<article class="post format-standard hentry clearfix">
 <p><img src="https://calculator.me/img/wage-conversion-calculator.png" width="1500" height="103" alt="Wage Conversion Logo."></p>


  <h2 class="entry-title">Semimonthly Paycheck Calculator</h2>
    
   
   
  <div class="entry-content">
 <!-- content begin -->

<div class="pc-tab">
<input checked="checked" id="tab1" type="radio" name="pct" />
<input id="tab2" type="radio" name="pct" />
<input id="tab3" type="radio" name="pct" />
  <nav>
    <ul>
      <li class="tab1">
        <label for="tab1">Calculate</label>
      </li>
      <li class="tab2">
        <label for="tab2">Rates</label>
      </li>
      <li class="tab3">
        <label for="tab3">Tips</label>
      </li>
    </ul>
  </nav>
  <section>
    <div class="tab1">

<form name="calc" method="post" action="#">

 <table border='0' width='90%'>
 <tbody>
 <tr >
 <td colspan="2">
 
Wages to convert:
 
 </td>
 <td align="center" >
 <input type="number" step="any" name="wage" size="15" value="60000" onKeyUp="clear_results(this.form);compute(this.form)" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" />
 </td>
 </tr>



 <tr >
 <td colspan="2">
 
Above wages are per:
 
 </td>
 <td align="center" >
 <select name="period" size="1" onChange="clear_results(this.form);compute(this.form)">
 <option value="0">Hour</option>
 <option value="1">Day</option>
 <option value="2">Week</option>
 <option value="3">Bi-Weekly</option>
 <option value="4">Semi-Monthly</option>
 <option value="5">Month</option>
 <option value="6">Bi-Monthly</option>
 <option value="7">Quarter</option>
 <option value="8">Semi-Annually</option>
 <option value="9" selected>Year</option>
 </select>
 </td>
 </tr>

 <tr >
 <td colspan="2">
 Hours worked per day: 
 </td>
 <td align="center" >
 <input type="number" step="any" name="DailyHours" size="15" value="8" onKeyUp="clear_results(this.form);compute(this.form)" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" />
 </td>
 </tr>

 <tr >
 <td colspan="2">
 Days worked per week: 
 </td>
 <td align="center" >
 <input type="number" step="any" name="WeeklyDays" size="15" value="5" onKeyUp="clear_results(this.form);compute(this.form)" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" />
 </td>
 </tr>
 <tr >
 <td colspan="2">
 Weeks worked per year: 
 </td>
 <td align="center" >
 <input type="number" step="any" name="YearlyWeeks" size="15" value="50" onKeyUp="clear_results(this.form);compute(this.form)" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" />
 </td>
 </tr>

 <tr >
 <td colspan="2">
 
Above wages are:
 
 </td>
 <td align="center" >
 <select name="TaxAdjust" size="1" onChange="clear_results(this.form);compute(this.form)">
 <option value="0">Untaxed</option>
 <option value="1" selected>Before Taxes</option>
 <option value="2">After Taxes</option>
 </select>
 </td>
 </tr>

 <tr >
 <td colspan="2">
 Your tax rate in %: 
 </td>
 <td align="center" >
 <input type="number" step="any" name="TaxRate" size="15" value="25" onKeyUp="clear_results(this.form);compute(this.form)" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" />
 </td>
 </tr>


 <tr>
 <td align="center"  colspan="3">
      <input type="button" value="Convert Wage" onClick="compute(this.form)" />
 <input type="reset" value="Clear" />
 <a style="text-decoration:none;" href="#planningrate"><input type="button" value="Savings Rates" onClick=" " /></a>
 
 </td>
 </tr>

 <tr >
 <td >
 <strong>Converted:</strong>
 </td>
 <td align="center" >
 <strong>Untaxed</strong>
 </td>
 <td align="center" >
 <strong>Taxed</strong>
 </td>
 </tr>

 <tr >
 <td >
 Hourly:
 </td>
 <td align="center" >
 <input type="text" name="hourly" size="15" />
 </td>
 <td align="center" >
 <input type="text" name="hourlytaxed" size="15" />
 </td>
 </tr>

 <tr >
 <td >
 Daily:
 </td>
 <td align="center" >
 <input type="text" name="daily" size="15" />
 </td>
 <td align="center" >
 <input type="text" name="dailytaxed" size="15" />
 </td>
 </tr>

 <tr> <td >
 Weekly: 
 </td>
 <td align="center" >
 <input type="text" name="weekly" size="15" />
 </td>
 <td align="center" >
 <input type="text" name="weeklytaxed" size="15" />
 </td>
 </tr>

 <tr>
 <td>
 Hours worked per week:
 </td>
 <td align="center" >
 <input type="text" name="HoursWorkedPerWeek" size="15" />
 </td>
 </tr>



 <tr >
 <td>
 Bi-Weekly: 
 </td>
 <td align="center" >
 <input type="text" name="biweekly" size="15" />
 </td>
 <td align="center" >
 <input type="text" name="biweeklytaxed" size="15" />
 </td>
 </tr>

 <tr class="featured">
 <td >
 Semi-Monthly:
 </td>
 <td align="center" >
 <input type="text" name="semimonthly" size="15" />
 </td>
 <td align="center" >
 <input type="text" name="semimonthlytaxed" size="15" />
 </td>
 </tr>

 <tr>
 <td>
 Monthly:
 </td>
 <td align="center" >
 <input type="text" name="monthly" size="15" />
 </td>
 <td align="center" >
 <input type="text" name="monthlytaxed" size="15" />
 </td>
 </tr>

 <tr>
 <td>
Hours worked per month:
 </td>
 <td align="center" >
 <input type="text" name="HoursWorkedPerMonth" size="15" />
 </td>
 </tr><tr >
 <td >
 Bi-Monthly: 
 </td>
 <td align="center" >
 <input type="text" name="bimonthly" size="15" />
 </td>
 <td align="center" >
 <input type="text" name="bimonthlytaxed" size="15" />
 </td>
 </tr>

 <tr >
 <td >
 Quarterly:
 </td>
 <td align="center" >
 <input type="text" name="quarterly" size="15" />
 </td>
 <td align="center" >
 <input type="text" name="quarterlytaxed" size="15" />
 </td>
 </tr>


 <tr >
 <td >
 Semi-Annually:
 </td>
 <td align="center" >
 <input type="text" name="semiannually" size="15" />
 </td>
 <td align="center" >
 <input type="text" name="semiannuallytaxed" size="15" />
 </td>
 </tr>


 <tr > <td >
 Annually: 
 </td>
 <td align="center" >
 <input type="text" name="annually" size="15" />
 </td>
 <td align="center" >
 <input type="text" name="annuallytaxed" size="15" />
 </td>
 </tr>

 <tr>
 <td>
 Hours worked per year:
 </td>
 <td align="center" >
 <input type="text" name="HoursWorkedPerYear" size="15" />
 </td>
 </tr>
</tbody>
 </table>
 </form>  
 
     </div>
    <div class="tab2">

    </div>

    <div class="tab3">
<br />
 <p> This calculator will help you to quickly convert a wage stated in one periodic term (hourly, weekly, etc.) into its equivalent stated in all other common periodic terms. This can be helpful when comparing your present wage to a wage being offered by a prospective employer where each wage is stated in a different periodic term (e.g., one is listed as an hourly wage and the other is listed as annually).</p>
 <p> Simply enter a wage, select it's periodic term from the pull-down menu, enter the number of hours per week the wage is based on, and click on the "Convert Wage" button. </p>
    </div>

  </section>
</div>
 
 
 
 <a name="planningrate"></a>

<div class="myFinance-widget" data-widget-id="b5781fc1-0381-4f5f-b9d0-70cfe2c67850" data-campaign="calcme_fulltable_savings"></div>
<!-- end calculator -->

<div id="share"></div>
<h2>How Much Do You Earn?</h2>
<div>
  <p>Each year has 12 months in it. Semi-monthly means twice per month, so each year has 24 semi-monthly periods in it.</p>
  <p>The following table shows the equivalent semi-monthly pay for various annual salaries presuming each payment is the same throughout the year. The first column shows the equivalent semi-monthly untaxed income &amp; the second column shows the equivalent after-tax income presuming a flat 25% income tax rate. This table is only for illustrative purposes as people will get taxed at different levels depending upon their income, their family situation, donations to charities &amp; other deductions. The income tax system has both progressive &amp; regressive aspects. </p>
  <ul>
    <li><strong>Progressive: </strong>As income increases the core income tax rate can go up from 10% to as high as 37%. There are also  Federal Insurance Contributions Act (FICA) taxes, which combine to pay for Social Security &amp; Medicare.</li>
    <li><strong>Regressive:</strong> Social security payments as a portion of self-employment taxes cap out at 12.4% of up to $132,900 in 2019, while the Medicare tax rate of 2.9% does not have a limit. Long-term capital gains are taxed at lower rates than ordinary earned income.</li>
    </ul>
  <p><img src="../img/graph-of-saving-money.png" alt="Graph of Saving Money."></p>
  <p>January, March, May, July, August,October, and December have 31 days, while February, April, June, September, and November have 30 days. February typically has 28 days except on leap years when it has 29 days. If you are paid an even sum for each month, to convert annual salary into monthly salary divide the annual salary by 24. If you are paid in part based on how many days are in each month then divide your annual salary by 365 (or 366 on leap years) &amp; then multiply that number by the number of days in the month to calculate monthly salary. Divide that number by 2 and you have the semi-monthly salary.</p>
  <table width="100%">
    <thead>
      <tr class="yearend">
        <td><strong>Annual Income</strong></td>
        <td><strong>Semi-monthly Pretax Income</strong></td>
        <td><strong>Taxes @ 25%</strong></td>
        <td><strong> Post-tax Income</strong></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>$10,000</td>
        <td>$416.67</td>
        <td>$104.17 </td>
        <td>$312.50</td>
      </tr>
      <tr>
        <td>$20,000</td>
        <td>$833.33</td>
        <td>$208.33 </td>
        <td>$625.00</td>
      </tr>
      <tr>
        <td>$30,000</td>
        <td>$1,250.00</td>
        <td>$312.50 </td>
        <td>$937.50</td>
      </tr>
      <tr>
        <td>$40,000</td>
        <td>$1,666.67</td>
        <td>$416.67</td>
        <td>$1,250.00</td>
      </tr>
      <tr>
        <td>$50,000</td>
        <td>$2,083.33</td>
        <td>$520.83</td>
        <td>$1,562.50</td>
      </tr>
      <tr>
        <td>$60,000</td>
        <td>$2,500.00</td>
        <td>$625.00 </td>
        <td>$1,875.00</td>
      </tr>
      <tr>
        <td>$70,000</td>
        <td>$2,916.67</td>
        <td>$729.17</td>
        <td>$2,187.50</td>
      </tr>
      <tr>
        <td>$80,000</td>
        <td>$3,333.33</td>
        <td>$833.33</td>
        <td>$2,500.00</td>
      </tr>
      <tr>
        <td>$90,000</td>
        <td>$3,750.00</td>
        <td>$937.50</td>
        <td>$2,812.50</td>
      </tr>
      <tr>
        <td>$100,000</td>
        <td>$4,166.67</td>
        <td>$1,041.67 </td>
        <td>$3,125.00</td>
      </tr>
      <tr>
        <td>$120,000</td>
        <td>$5,000.00</td>
        <td>$1,250.00</td>
        <td>$3,750.00</td>
      </tr>
      <tr>
        <td>$150,000</td>
        <td>$6,250.00</td>
        <td>$3,125.00</td>
        <td>$4,687.50</td>
      </tr>
      <tr>
        <td>$200,000</td>
        <td>$8,333.33</td>
        <td>$2,083.33</td>
        <td>$6,250.00</td>
      </tr>
      <tr>
        <td>$250,000</td>
        <td>$10,416.67</td>
        <td>$2,604.17</td>
        <td>$7,812.50</td>
      </tr>
      <tr>
        <td>$500,000</td>
        <td>$20,833.33</td>
        <td>$5,208.33</td>
        <td>$15,625.00</td>
      </tr>
      <tr>
        <td>$750,000</td>
        <td>$31,250.00</td>
        <td>$7,812.50</td>
        <td>$23,437.50</td>
      </tr>
      <tr>
        <td>$1,000,000</td>
        <td>$41,666.67</td>
        <td>$10,416.67</td>
        <td>$31,250.00</td>
      </tr>
    </tbody>
</table>

</div>
    
 
<div id="calculatorsme-endcontent"></div>

<div class="myFinance-widget" data-type="horizontal" data-campaign="calcme-cru-eoc"></div>

<script type="text/javascript" language="javascript" src="https://live.sekindo.com/live/liveView.php?s=102348&cbuster=%%CACHEBUSTER%%&pubUrl=%%REFERRER_URL_ESC%%&subId=[SUBID_ENCODED]&x=%%WIDTH%%&y=%%HEIGHT%%&vp_content=plembed1a24ihtjpyvs&vp_template=7380"></script> </article>
    
</section>
<!-- /#content -->

<!-- #sidebar -->
	<aside id="sidebar" role="complementary">
    
    <div class="boxed widget st_kb_categories_widget clearfix"> 
    <h4 class="widget-title">Financial Planning</h4>
    <ul>
      <li><a href='https://calculator.me/planning/'>Budget Planning</a></li>
	  <li><a href='https://calculator.me/planning/life-insurance.php'>Life Insurance Needs</a></li>
      <li><a href='https://calculator.me/planning/wage-conversion.php'>Wage to Salary</a></li>
      <li><a href='https://calculator.me/planning/hourly-wages.php'>Real Hourly Wages</a></li>
      <li><a href='https://calculator.me/planning/lifetime-earnings.php'>Lifetime Earnings</a></li>
      <li><a href='https://calculator.me/planning/inflation.php'>Inflation</a></li>
	</ul>
	</div>

     <div class="boxed widget widget_recent_entries clearfix">		
<h4 class="widget-title">Retirement Planning</h4>		
<ul>
      <li><a href='https://calculator.me/planning/retirement.php'>Retirement</a></li>
      <li><a href='https://calculator.me/planning/401k-ira.php'>401(k) IRA Rollover</a></li>
      <li><a href='https://calculator.me/planning/roth-ira.php'>Roth IRA Conversion</a></li>
      <li><a href='https://calculator.me/planning/present-value.php'>Present Value</a></li>
      <li><a href='https://calculator.me/planning/annuity.php'>Annuity Value</a></li>
      <li><a href='https://calculator.me/planning/net-worth.php'>Net Worth Calculator</a></li>
</ul>
</div>   

     <div class="boxed widget widget_recent_entries clearfix">		
<h4 class="widget-title">Hourly Wages</h4>		
<ul>
      <li><a href='https://calculator.me/planning/hourly-to-annual.php'>Hourly to Annual</a></li>
      <li><a href='https://calculator.me/planning/hourly-to-monthly.php'>Hourly to Monthly</a></li>
      <li><a href='https://calculator.me/planning/hourly-to-biweekly.php'>Hourly to Biweekly</a></li>
      <li><a href='https://calculator.me/planning/hourly-to-weekly.php'>Hourly to Weekly</a></li>
</ul>
</div>      

     <div class="boxed widget widget_recent_entries clearfix">		
<h4 class="widget-title">Annual Wages</h4>		
<ul>
      <li><a href='https://calculator.me/planning/annual-to-hourly.php'>Annual to Hourly</a></li>
      <li><a href='https://calculator.me/planning/annual-to-daily.php'>Annual to Daily</a></li>
      <li><a href='https://calculator.me/planning/annual-to-weekly.php'>Annual to Weekly</a></li>
      <li><a href='https://calculator.me/planning/annual-to-biweekly.php'>Annual to Biweekly</a></li>
      <li><a href='https://calculator.me/planning/annual-to-semimonthly.php'>Annual to Semimonthly</a></li>
      <li><a href='https://calculator.me/planning/annual-to-monthly.php'>Annual to Monthly</a></li>
</ul>
</div>  

     <div class="boxed widget widget_recent_entries clearfix">		
<h4 class="widget-title">Biweekly Wages</h4>		
<ul>
      <li><a href='https://calculator.me/planning/biweekly-to-hourly.php'>Biweekly to Hourly</a></li>
      <li><a href='https://calculator.me/planning/biweekly-to-monthly.php'>Biweekly to Monthly</a></li>
      <li><a href='https://calculator.me/planning/biweekly-to-annual.php'>Biweekly to Annual</a></li>
</ul>
</div>  

     <div class="boxed widget widget_recent_entries clearfix">		
<h4 class="widget-title">Other Wages</h4>		
<ul>
      <li><a href='https://calculator.me/planning/monthly-to-hourly.php'>Monthly to Hourly</a></li>
      <li><a href='https://calculator.me/planning/weekly-to-hourly.php'>Weekly to Hourly</a></li>
</ul>
</div>  
    
      
     <div class="boxed widget widget_recent_entries clearfix">		
<h4 class="widget-title">Health Tools</h4>		
<ul>
      <li><a href='https://calculator.me/planning/weight-loss.php'>Weight Loss</a></li>
      <li><a href='https://calculator.me/planning/quit-smoking.php'>Quit Smoking</a></li>
</ul>
</div>

<script type='text/javascript' src='https://calculator.me/files/sticky-sidebar-scroll.min.js'></script>
<script>
$(document).ready(function() {
  $.stickysidebarscroll("#stick",{offset: {top: 0, bottom: 320}});
});
</script>

<div id="stick">
<div class="myFinance-widget" data-widget-id="4a22d62c-7859-4a08-9c4c-82967b0952e6" data-campaign="calcme-oa-svgs-module"></div>
</div>
<!-- sidebar end -->    

    
    	</aside>
<!-- /#sidebar -->

</div>
</div>
<!-- /#primary -->


<!-- #footer-bottom -->
<footer id="footer" class="clearfix">




<div id="footer-widgets" class="clearfix">
    <div class="container">
        <div class="row">
        	<div class="column col-fourth widget st_kb_categories_widget"> 
        
		</div><div class="column col-fourth widget widget_meta">
        
</div><div class="column col-fourth widget st_kb_articles_widget"> 

		
		</div><div class="column col-fourth widget widget_pages">
        
		</div></div>
</div>

<br />
<div id="footer-bottom" class="clearfix">
<div class="container">
    <small id="copyright" role="contentinfo">&copy; 2013 &mdash; 2020 Calculator.me</small>
  

    <nav id="footer-nav" role="navigation">
    <ul id="menu-menuname" class="nav-footer clearfix">
    <li class="menu-item"><a href="https://calculator.me/about-us/">About Us</a></li>
<li class="menu-item"><a href="https://calculator.me/about-us/#contact">Contact Us</a></li>
<li class="menu-item"><a href="https://calculator.me/about-us/#privacy">Privacy</a></li>
<li class="menu-item"><a href="https://calculator.me/sitemap/">Sitemap</a></li>
</ul>  </nav>
  </div>
</div>

</footer> 
<!-- /#footer-bottom -->
<script>var clicky_site_ids = clicky_site_ids || []; clicky_site_ids.push(101184573);</script>
<script async src="//static.getclicky.com/js"></script>
<noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/101184573ns.gif" /></p></noscript>
<script type='text/javascript' src='https://calculator.me/files/functions.js?ver=3.7'></script>
<script src="/mint/?js" type="text/javascript"></script>

<script async type='text/javascript' id="myFinance-widget-script">
!function(){function e(){var e=document.createElement("script"),n=document.getElementById("myFinance-widget-script"),a=t+"static/widget/myFinance.js";e.type="text/javascript",e.async=!0,e.src=a,n.parentNode.insertBefore(e,n);var c="myFinance-widget-css";if(!document.getElementById(c)){var d=document.getElementsByTagName("head")[0],i=document.createElement("link");i.id=c,i.rel="stylesheet",i.type="text/css",i.href=t+"static/widget/myFinance.css",i.media="all",d.appendChild(i)}}var t="https://www.myfinance.com/";document.attachEvent?document.attachEvent("onreadystatechange",function(){"complete"===document.readyState&&e()}):document.addEventListener("DOMContentLoaded",e,!1)}();
</script>
          
		</body>
</html>
