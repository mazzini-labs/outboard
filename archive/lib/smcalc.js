//*******************************************
//Semi-Monthly Timesheet Calculator
//2012 Daniel C. Peterson ALL RIGHTS RESERVED
//Created: 09/12/2012
//Last Modified: 07/03/2015
//This script may not be copied, edited or reproduced
//without express written permission from
//Daniel C. Peterson of Web Winder Website Services
//For commercial use rates, contact:
//Web Winder Website Services
//P.O. Box 11
//Bemidji, MN  56619
//dan@webwinder.com
//http://www.webwinder.com
//Commercial User License #:free-online-calculator-use.com
//Code protected by COPYSCAPE
//A prerequisite to business success is INTEGRITY.
//Show that YOU have integrity by respecting the hard work that
//went into building this calculator.
//*******************************************

//Removed print disabled and required rate on 12/23/2013
//Added option to allow 1st half to end on day other than the 15th on 07/19/2014
//Added option for overtime after 10 hours per day on 10/18/2014
//Added starting and ending date selections to accomodate all pay period variations on 11/11/2014
//Added Local Storage on 07/03/2015

   var today = new Date();
   var now_mon = today.getMonth();
   var mon_num = now_mon + 1;
   if(mon_num == 12) {
      mon_num = 0;
   }

   var now_day = today.getDate();
   var now_yr = today.getFullYear();
   var now_time = today.getTime();

   var mt_ar = new Array(0,13,14,15,16,17,18,19,20,21,22,23,24,1,2,3,4,5,6,7,8,9,10,11,12);
   var zero_ar = new Array('00','01','02','03','04','05','06','07','08','09');

   var mlengths = [
    31,
    (now_yr % 4 == 0 && now_yr % 100 != 0 || now_yr % 400 == 0) ? 29 : 28,
    31, 30, 31, 30, 31, 31, 30, 31, 30, 31
   ];
   var days_ar = new Array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
   var mnames_ab = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

   var eoww_ar = [6,0,1,2,3,4,5];


function mins(h,m) {

   var hr_mins = h * 60;
   var tot_mins = Number(hr_mins) + Number(m);
   return tot_mins;
}

function mins_to_time(mins) {

   var hrs = Math.floor(mins / 60);
   var ev_hrs = hrs * 60;
   var rem_mins = Number(mins) - Number(ev_hrs);
   var min_txt = "";

   if(rem_mins < 10) {
      min_txt = zero_ar[rem_mins];
   } else {
      min_txt = rem_mins;
   }

   var time_txt = hrs + ":" + min_txt;

   return time_txt;

}

function mins_to_time_frac(mins) {

   var hrs = Math.round(mins / 60 * 100) / 100;

   var time_txt = fns(hrs,2,0,0,0);

   return time_txt;

}

function chg_min_fmt(form) {

   var v_min_fmt = document.calc.min_fmt.selectedIndex;


   if(v_min_fmt == 0) {
      document.getElementById("min_fmt_txt").innerHTML = "HH:MM";
      document.getElementById("min_fmt_tot_txt").innerHTML = "hours:minutes";
   } else {
      document.getElementById("min_fmt_txt").innerHTML = "HH.HH";
      document.getElementById("min_fmt_tot_txt").innerHTML = "hours";
   }

   calc_time(document.calc);

   clear_results(document.calc);

}


function fill_days(form) {

   //Added
   //var v_first_days = Number(document.calc.first_days.options[document.calc.first_days.selectedIndex].value);
   //End added

   var v_s_mon_idx = document.calc.s_mon.selectedIndex;
   var v_s_day_idx = document.calc.s_day.selectedIndex;
   var v_s_yr_idx = document.calc.s_yr.selectedIndex;
   
   var v_e_mon_idx = document.calc.e_mon.selectedIndex;
   var v_e_day_idx = document.calc.e_day.selectedIndex;
   var v_e_yr_idx = document.calc.e_yr.selectedIndex;
   
   var pp_days = 0;

	var v_s_mon = document.calc.s_mon.options[v_s_mon_idx].value;
	var v_s_day = document.calc.s_day.options[v_s_day_idx].value;
	var v_s_yr = document.calc.s_yr.options[v_s_yr_idx].value;
	
	var v_e_mon = document.calc.e_mon.options[v_e_mon_idx].value;
	var v_e_day = document.calc.e_day.options[v_e_day_idx].value;
	var v_e_yr = document.calc.e_yr.options[v_e_yr_idx].value;

	var dt_str = "" + v_s_mon + " " + v_s_day + ", " + v_s_yr + " 12:00:00";
	var s_date = new Date(dt_str);
	var s_time = s_date.getTime();
	var s_wday = s_date.getDay();
	
	var e_dt_str = "" + v_e_mon + " " + v_e_day + ", " + v_e_yr + " 12:00:00";
	var e_date = new Date(e_dt_str);
	var e_time = e_date.getTime();
	var e_wday = e_date.getDay();
	
	var date_diff = Math.round((e_time - s_time)/86400000)+1;
	
	var day_lu = 0;
	

	for(var i = 1; i<18; i++) { //looks like loop that outputs the days

		if(i<=date_diff && date_diff > 12 && date_diff < 18) {

			day_lu = s_date.getDay();
			document.getElementById("t_" + i + "_day").value = days_ar[day_lu] + " " + mnames_ab[s_date.getMonth()] + " " + s_date.getDate();
			//set value of first id to t_1_day...
			document.getElementById("t_" + i + "_dotw").value = s_date.getDay();

			s_time += 86400000;
			s_date.setTime(s_time);
			pp_days += 1;
			
			

		} else {

			document.getElementById("t_" + i + "_day").value = "";
			
			for(j=1; j<4; j++) {
				document.getElementById("t_" + i + "_in_" + j + "").value = "";
				document.getElementById("t_" + i + "_out_" + j + "").value = "";
			}
			
			document.getElementById("t_" + i + "_hrs").value = "";

		}



	}
	
	
	document.calc.per_end.value = days_ar[e_wday] + " " + v_e_mon + " " + v_e_day + ", " + v_e_yr + "";
	document.calc.h_pp_days.value = pp_days;

   calc_time(document.calc);
   clear_results(document.calc);

}


function calc_ot_rate(form) {

   var v_reg_rate = sn(document.calc.reg_rate.value);
   var ot_type_idx = document.calc.ot_type.selectedIndex;
   var v_ot_fact = sn(document.calc.ot_fact.value);

   //ADDED IF STATEMENT ON 6/25/15
   if(ot_type_idx > 0) {
      var v_ot_rate = v_reg_rate * v_ot_fact;
      document.calc.ot_rate.value = fns(v_ot_rate,2,1,0,0);
   } else {
      document.calc.ot_rate.value = "";
   }

   if(ot_type_idx == 3) {
      document.calc.day.disabled = false;
      document.calc.co_hrs.disabled = false;
   } else {
      document.calc.day.disabled = true;
      document.calc.co_hrs.disabled = true;
   }

   clear_results(document.calc);
}

function calc_raw(raw) {

   var raw_hr = 0;
   var raw_min = 0;

   var raw_str = "" + raw + "";

   if(raw < 100) {
      raw_hr = raw;
      raw_min = 0;
   } else
   if(raw < 1000) {
      raw_hr = raw_str.substring(0,1);
      raw_min = raw_str.substring(1,3);
   } else {
      raw_hr = raw_str.substring(0,2);
      raw_min = raw_str.substring(2,4);
   }

   var raw_del = raw_hr + ":" + raw_min;

   return raw_del;

}


function calc_txt(raw) {

   var raw_hr = 0;
   var raw_min = 0;
   var raw_del = "";

   var raw_str = "" + raw + "";

   if(raw == 0) {
      raw_del = "";
   } else {
      if(raw < 100) {
         raw_hr = raw;
         raw_min = 0;
      } else
      if(raw < 1000) {
         raw_hr = raw_str.substring(0,1);
         raw_min = raw_str.substring(1,3);
      } else {
         raw_hr = raw_str.substring(0,2);
         raw_min = raw_str.substring(2,4);
      }

      if(raw_min == "0") {
         raw_min = "" + raw_min + "0";
      }

      raw_del = raw_hr + ":" + raw_min;

   }

   return raw_del;

}

function calc_gross(form) {

   var v_reg_rate = sn(document.calc.reg_rate.value);
   var v_ot_rate = sn(document.calc.ot_rate.value);

   var ot_type_idx = document.calc.ot_type.selectedIndex;
   var v_total_time = document.calc.total_time.value;

   var v_min_fmt = document.calc.min_fmt.selectedIndex;

   var s_wkday = Number(document.calc.day.selectedIndex);
   var e_wkday = eoww_ar[s_wkday];

   var v_co_hrs = document.calc.co_hrs.value;

   var v_pp_days = sn(document.calc.h_pp_days.value);


   //if(v_reg_rate == 0) {
      //alert("Please enter your regular hourly rate.");
      //document.calc.reg_rate.focus();
   //} else
   if(v_total_time == "") {
      alert("Please complete the time sheet before you attempt to calculate your gross wages.");
      document.calc.t_1_day.focus();
   } else {

      var tm = 0;
      var hr = 0;
      var mn = 0;
      var mins = 0;
      var ot_mins = 0;
      var v_reg_hours = 0;
      var v_reg_pay = 0;
      var v_ot_hours = 0;
      var v_ot_pay = 0;
      var v_tot_hours = 0;
      var v_tot_pay = 0;
      var accum_reg_mins = 0;
      var accum_ot_mins = 0;

      var accum_40_hrs = 0;
      var week_1_mins = 0;
      var week_2_mins = 0;

      if(ot_type_idx == 0 || ot_type_idx == 4) {

         if(v_min_fmt == 0) {

            var time_ar = v_total_time.split(":");

            hr = Number(time_ar[0]);
            mn = Number(time_ar[1]);
            mins = hr * 60 + mn;

         } else {

            mins = Math.round(Number(v_total_time) * 60 * 100) / 100;

         }

         if(ot_type_idx == 0) {
            accum_reg_mins = mins;
            accum_ot_mins = 0;
         } else {
            if(mins > 5760) {
               accum_reg_mins = 5760;
               accum_ot_mins = Number(mins) - Number(5760);
            } else {
               accum_reg_mins = mins;
               accum_ot_mins = 0;
            }

         }

         document.calc.co_next_time.value = "N/A";

      } else
      if(ot_type_idx == 3) {

         var wk_ot_mins = 0;
         var tdotw = 0;
         var v_co_mins = 0;
         
         //ADDED 12/14/2013
         var wk_cnt = 0;
         //END ADDED

         if(v_co_hrs.indexOf(":") > -1) {
            var co_ar = v_co_hrs.split(":");

            hr = Number(co_ar[0]);
            mn = Number(co_ar[1]);
            v_co_mins = hr * 60 + mn;
         } else
         if(v_co_hrs.length > 0) {
            v_co_mins = Number(v_co_hrs) * 60;
         } else {
            v_co_mins = 0;
         }
			
			//ADDED 12/14/2013
			if(v_co_mins > 2400) {
			   accum_40_hrs = 2400;
			} else {
            accum_40_hrs = v_co_mins;
         }
         //END ADDED
         
         //accum_40_hrs = v_co_mins; REMOVED 12/14/2013

         for(var i = 1; i<=v_pp_days; i++) {

            tm = document.getElementById("t_" + i + "_hrs").value;
            tdotw = document.getElementById("t_" + i + "_dotw").value;

            if(tm.length > 0) {

               if(v_min_fmt == 0) {

                  var time_ar = tm.split(":");

                  hr = Number(time_ar[0]);
                  mn = Number(time_ar[1]);
                  mins = hr * 60 + mn;


               } else {

                  mins = Math.round(Number(tm) * 60 * 100) / 100;
               }

               accum_40_hrs += mins;
               accum_reg_mins += mins;
            }

            if(tdotw == e_wkday) {
               
               if(accum_40_hrs > 2400) {
                  wk_ot_mins = Number(accum_40_hrs) - Number(2400);
                  accum_ot_mins += wk_ot_mins;
                  accum_reg_mins -= wk_ot_mins;
                  
               } else {
                  //accum_reg_mins += accum_40_hrs;
               }
               wk_cnt += 1;
               
               accum_40_hrs = 0;
            }
         }
         
         //ADDED 12/14/2013
         if(wk_cnt < 3) {
            if(accum_40_hrs > 2400) {
            	wk_ot_mins = Number(accum_40_hrs) - Number(2400);
               accum_ot_mins += wk_ot_mins;
               accum_reg_mins -= wk_ot_mins;
            }
         }
			//END ADDED

         document.calc.co_next_time.value = mins_to_time(accum_40_hrs);

      } else {
      
         //ADDED FOR OT OVER 10 HOURS ON 10/18/2014
         var daily_reg_mins = 480;
         if(ot_type_idx == 2) {
            daily_reg_mins = 600;
         }
         //END ADD

         for(var i = 1; i<=v_pp_days; i++) {

            tm = document.getElementById("t_" + i + "_hrs").value;

            if(tm.length > 0) {

               if(v_min_fmt == 0) {

                  var time_ar = tm.split(":");

                  hr = Number(time_ar[0]);
                  mn = Number(time_ar[1]);
                  mins = hr * 60 + mn;

               } else {

                  mins = Math.round(Number(tm) * 60 * 100) / 100;
               }
  
  
               //CHANGED TO ACCOMODATE OT PAID AFTER 10 HRS PER DAY
               if(mins > daily_reg_mins) {
                  ot_mins = Number(mins) - Number(daily_reg_mins);
                  mins = daily_reg_mins;
               } else {
                  ot_mins = 0;
               }
               //END CHANGE
               
               accum_ot_mins += ot_mins;
               accum_reg_mins += mins;
            }
         }

         document.calc.co_next_time.value = "N/A";

      }

      document.calc.reg_hours_rate.value = fns(v_reg_rate,2,1,1,1);

      v_reg_hours = Math.round(accum_reg_mins / 60 * 100) / 100;
      document.calc.reg_hours.value = fns(v_reg_hours,2,0,0,0);

      v_reg_pay = v_reg_hours * v_reg_rate;
      document.calc.reg_pay.value = fns(v_reg_pay,2,1,1,1);

      document.calc.ot_hours_rate.value = fns(v_ot_rate,2,1,1,1);

      v_ot_hours = Math.round(accum_ot_mins / 60 * 100) / 100;
      document.calc.ot_hours.value = fns(v_ot_hours,2,0,0,0);

      v_ot_pay = v_ot_hours * v_ot_rate;
      document.calc.ot_pay.value = fns(v_ot_pay,2,1,1,1);

      document.calc.tot_hours_rate.value = "";

      var v_tot_hours = Number(v_reg_hours) + Number(v_ot_hours);
      document.calc.tot_hours.value = fns(v_tot_hours,2,0,0,0);

      var v_tot_pay = Number(v_reg_pay) + Number(v_ot_pay);
      document.calc.tot_pay.value = fns(v_tot_pay,2,1,1,1);

      var tbl = "<br /><table class='ChartTable' style='margin: 0 auto;'>";
      tbl += "<tr>";
      tbl += "<td colspan='8' class='ChartColHead1'>Semi-Monthly Timesheet Report</td>";
      tbl += "</tr>";

      tbl += "<tr>";
      tbl += "<td colspan='8' class='ChartTextCellLeft'>Name: <strong>" + document.calc.emp_name.value + "</strong></td>";
      tbl += "</tr>";

      tbl += "<tr>";
      tbl += "<td colspan='8' class='ChartTextCellLeft'>Period ending: <strong>" + document.calc.per_end.value + "</strong></td>";
      tbl += "</tr>";

      tbl += "<tr>";
      tbl += "<td class='ChartColHead1'>Day</td>";
      tbl += "<td colspan='2' class='ChartColHead1'>Time Block 1</td>";
      tbl += "<td colspan='2' class='ChartColHead1'>Time Block 2</td>";
      tbl += "<td colspan='2' class='ChartColHead1'>Time Block 3</td>";
      if(v_min_fmt == 0) {
         tbl += "<td class='ChartColHead1'>HH:MM</td>";
      } else {
         tbl += "<td class='ChartColHead1'>HH.HH</td>";
      }
      tbl += "</tr>";

      tbl += "<tr>";
      tbl += "<td class='ChartColHead2'>&nbsp;</td>";
      tbl += "<td class='ChartColHead2'>In</td>";
      tbl += "<td class='ChartColHead2'>Out</td>";
      tbl += "<td class='ChartColHead2'>In</td>";
      tbl += "<td class='ChartColHead2'>Out</td>";
      tbl += "<td class='ChartColHead2'>In</td>";
      tbl += "<td class='ChartColHead2'>Out</td>";
      tbl += "<td class='ChartColHead2'>&nbsp;</td>";
      tbl += "</tr>";

      var in_1 = "";
      var out_1 = "";
      var in_2 = "";
      var out_2 = "";
      var in_3 = "";
      var out_3 = "";

      var row_col = "";

      for(var i = 1; i<=v_pp_days; i++) {

         if(i%2==0) {
            row_col = "class='ChartRowEven'";
         } else {
            row_col = "class='ChartRowOdd'";
         }

         in_1 = calc_txt(sn(document.getElementById("t_" + i + "_in_1").value));
         out_1 = calc_txt(sn(document.getElementById("t_" + i + "_out_1").value));
         in_2 = calc_txt(sn(document.getElementById("t_" + i + "_in_2").value));
         out_2 = calc_txt(sn(document.getElementById("t_" + i + "_out_2").value));
         in_3 = calc_txt(sn(document.getElementById("t_" + i + "_in_3").value));
         out_3 = calc_txt(sn(document.getElementById("t_" + i + "_out_3").value));

         //in_1_txt = time_txt(in_1);

         tbl += "<tr " + row_col + ">";
         tbl += "<td class='ChartTextCellLeft'>" + document.getElementById("t_" + i + "_day").value + "</td>";
         tbl += "<td class='ChartNumCell'>" + in_1 + "</td>";
         tbl += "<td class='ChartNumCell'>" + out_1 + "</td>";
         tbl += "<td class='ChartNumCell'>" + in_2 + "</td>";
         tbl += "<td class='ChartNumCell'>" + out_2 + "</td>";
         tbl += "<td class='ChartNumCell'>" + in_3 + "</td>";
         tbl += "<td class='ChartNumCell'>" + out_3 + "</td>";
         tbl += "<td class='ChartNumCell'>" + document.getElementById("t_" + i + "_hrs").value + "</td>";
         tbl += "</tr>";

      }

      tbl += "<tr class='ChartRowOdd'>";
      tbl += "<td colspan='7' class='ChartTextCellLeft'>";
      if(v_min_fmt == 0) {
         tbl += "Total hours:minutes for pay period:";
      } else {
         tbl += "Total hours for pay period:";
      }
      tbl += "</td>";
      tbl += "<td class='ChartNumCell'>";
      tbl += "" + document.calc.total_time.value + "";
      tbl += "</td>";
      tbl += "</tr>";

      if(ot_type_idx == 3) {
         tbl += "<tr class='ChartRowEven'>";
         tbl += "<td colspan='7' class='ChartTextCellLeft'>";
         tbl += "Hours:minutes to carry forward for OT calculations:";
         tbl += "</td>";
         tbl += "<td class='ChartNumCell'>";
         tbl += "" + document.calc.co_next_time.value + "";
         tbl += "</td>";
         tbl += "</tr>";
      }

      tbl += "<tr>";
      tbl += "<td colspan='2' class='ChartColHead1'>";
      tbl += "Type";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartColHead1'>";
      tbl += "Rate";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartColHead1'>";
      tbl += "Hours (10ths)";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartColHead1'>";
      tbl += "Pay";
      tbl += "</td>";
      tbl += "</tr>";

      tbl += "<tr class='ChartRowOdd'>";
      tbl += "<td colspan='2' class='ChartTextCellLeft'>";
      tbl += "Regular:";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartNumCell'>";
      tbl += "" + document.calc.reg_hours_rate.value + "";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartNumCell'>";
      tbl += "" + document.calc.reg_hours.value + "";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartNumCell'>";
      tbl += "" + document.calc.reg_pay.value + "";
      tbl += "</td>";
      tbl += "</tr>";

      tbl += "<tr class='ChartRowEven'>";
      tbl += "<td colspan='2' class='ChartTextCellLeft'>";
      tbl += "Overtime:";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartNumCell'>";
      tbl += "" + document.calc.ot_hours_rate.value + "";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartNumCell'>";
      tbl += "" + document.calc.ot_hours.value + "";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartNumCell'>";
      tbl += "" + document.calc.ot_pay.value + "";
      tbl += "</td>";
      tbl += "</tr>";

      tbl += "<tr class='ChartRowOdd'>";
      tbl += "<td colspan='2' class='ChartTextCellLeft'>";
      tbl += "Totals:";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartNumCell'>";
      tbl += "" + document.calc.tot_hours_rate.value + "";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartNumCell'>";
      tbl += "" + document.calc.tot_hours.value + "";
      tbl += "</td>";
      tbl += "<td colspan='2' class='ChartNumCell'>";
      tbl += "" + document.calc.tot_pay.value + "";
      tbl += "</td>";
      tbl += "</tr>";

      tbl += "</table><br />";

      document.getElementById("summary_tbl_1_div").innerHTML = tbl;
      document.getElementById("summary_footer_div").style.display = "block";

   }

}




function calc_time(form) {

   var v_min_fmt = document.calc.min_fmt.selectedIndex;
   var v_pp_days = sn(document.calc.h_pp_days.value);

   var inn = 0;
   var out = 0;
   
   var in_del = "";
   var out_del = "";

   var in_hr = 0;
   var in_min = 0;

   var out_hr = 0;
   var out_min = 0;


   var in_mins = 0;
   var out_mins = 0;
   var time_mins = 0;

   var day_mins = 0;
   var week_mins = 0;

   var test = "";


   for(var i = 1; i<=v_pp_days; i++) {

      day_mins = 0;

      for(var j = 1; j<4; j++) {

         inn = sn(document.getElementById("t_" + i + "_in_" + j + "").value);
         out = sn(document.getElementById("t_" + i + "_out_" + j + "").value);


         if(inn > 0 && out > 0) {

            in_del = calc_raw(inn);
            out_del = calc_raw(out);

            //test += "" + in_del + "|" + out_del + "||";

            var in_ar = in_del.split(":");
            var out_ar = out_del.split(":");

            in_hr = Number(in_ar[0]);
            in_min = Number(in_ar[1]);

            out_hr = Number(out_ar[0]);
            out_min = Number(out_ar[1]);


            if(in_hr > out_hr) {

               out_hr = mt_ar[out_hr];


               //Added 6/23/2012
               if(in_hr > 12) {
                  in_hr = mt_ar[in_hr];
               }
               //End add on 6/23/2012

            }

            in_mins = mins(in_hr,in_min);
            out_mins = mins(out_hr,out_min);

            time_mins = Number(out_mins) - Number(in_mins);
            day_mins += time_mins;

         } else {

            in_hr = 0;
            in_min = 0;
            out_hr = 0;
            out_min = 0;
         }

      }


      if(day_mins > 0 && day_mins < 1440) {
         if(v_min_fmt == 0) {
            document.getElementById("t_" + i + "_hrs").value = mins_to_time(day_mins);
         } else {
            document.getElementById("t_" + i + "_hrs").value = mins_to_time_frac(day_mins);
         }
      } else {
         document.getElementById("t_" + i + "_hrs").value = "";
      }
      week_mins += day_mins;

   }


   if(v_min_fmt == 0) {
      document.calc.total_time.value = mins_to_time(week_mins);
   } else {
      document.calc.total_time.value = mins_to_time_frac(week_mins);
   }

   clear_results(document.calc);

}

function time_card_report(form) {

	var v_total_time = document.calc.total_time.value;
    
   if(v_total_time == "" || v_total_time == "0.00" || v_total_time == "0:00") {
      alert("Please enter some work hours before attempting to view the printer friendly report.");
   } else {
   
   	calc_gross(document.calc);

		reportWin = window.open("","","width=800,height=600,toolbar=yes,menubar=no,scrollbars=yes,resizable=yes");

		reportWin.document.write("<html><head><title>Semi-Monthly Timesheet Report</title>");
		reportWin.document.write("<lin");
		reportWin.document.write("k href='support-files/zz-old-style.css' rel='stylesheet' type='text/css'>");
		reportWin.document.write("</head>");
		reportWin.document.write("<bo");
		reportWin.document.write("dy style='background-color: #FFFFFF;'><br><br><div style='width: 90%; margin: 0 auto; text-align: center;'>");

		reportWin.document.write("" + document.getElementById("summary_tbl_1_div").innerHTML + "");

		reportWin.document.write("<br />Report created with Semi-Monthly Timesheet Calculator at<br />");
		reportWin.document.write("http://www.free-online-calculator-use.com/semi-monthly-timesheet-calculator.html<br />");


		reportWin.document.write("<br /><form method='post'>");
		reportWin.document.write("<input type='button' value='Print Report' onClick='window.print()'>");
		reportWin.document.write("<br /><input type='button' value='Close Window' onClick='window.close()'>");
		reportWin.document.write("</form></div></body></html>");


		reportWin.document.close();
		
	}
}

function military_time_chart() {

   reportWin = window.open("","","width=400,height=600,toolbar=no,menubar=no,scrollbars=yes,resizable=yes");

   reportWin.document.write("<html><head><title>Military Time Conversion Chart</title>");
   reportWin.document.write("<lin");
   reportWin.document.write("k href='support-files/zz-old-style.css' rel='stylesheet' type='text/css'>");
   reportWin.document.write("</head>");
   reportWin.document.write("<bo");
   reportWin.document.write("dy style='background-color: #FFFFFF;'><br><br><div style='width: 90%; margin: 0 auto; text-align: center'>");

   reportWin.document.write("<table class='ChartTable' style='margin: 0 auto;'>");
   reportWin.document.write("<tr><td colspan='2' class='ChartColHead1'>Military Time Conversion Chart</td></tr>");
   reportWin.document.write("<tr><td width='150' class='ChartColHead2'>Standard</td><td width='150' class='ChartColHead2'>Military</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>12:00 am (Midnight)</td><td class='ChartNumCell'>0000</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>1:00 am</td><td class='ChartNumCell'>0100</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>2:00 am</td><td class='ChartNumCell'>0200</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>3:00 am</td><td class='ChartNumCell'>0300</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>4:00 am</td><td class='ChartNumCell'>0400</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>5:00 am</td><td class='ChartNumCell'>0500</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>6:00 am</td><td class='ChartNumCell'>0600</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>7:00 am</td><td class='ChartNumCell'>0700</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>8:00 am</td><td class='ChartNumCell'>0800</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>9:00 am</td><td class='ChartNumCell'>0900</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>10:00 am</td><td class='ChartNumCell'>1000</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>11:00 am</td><td class='ChartNumCell'>1100</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>12:00 pm (Noon)</td><td class='ChartNumCell'>1200</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>1:00 pm</td><td class='ChartNumCell'>1300</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>2:00 pm</td><td class='ChartNumCell'>1400</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>3:00 pm</td><td class='ChartNumCell'>1500</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>4:00 pm</td><td class='ChartNumCell'>1600</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>5:00 pm</td><td class='ChartNumCell'>1700</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>6:00 pm</td><td class='ChartNumCell'>1800</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>7:00 pm</td><td class='ChartNumCell'>1900</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>8:00 pm</td><td class='ChartNumCell'>2000</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>9:00 pm</td><td class='ChartNumCell'>2100</td></tr>");
   reportWin.document.write("<tr class='ChartRowOdd'><td width='150' class='ChartNumCell'>10:00 pm</td><td class='ChartNumCell'>2200</td></tr>");
   reportWin.document.write("<tr class='ChartRowEven'><td width='150' class='ChartNumCell'>11:00 pm</td><td class='ChartNumCell'>2300</td></tr>");
   reportWin.document.write("</table>");


   reportWin.document.write("<form method='post'>");
   reportWin.document.write("<br /><input type='button' value='Close Window' onClick='window.close()'>");
   reportWin.document.write("</form></div></body></html>");


   reportWin.document.close();

}


function clear_results(form) {

   document.calc.co_next_time.value = "";
   document.calc.reg_hours_rate.value = "";
   document.calc.reg_hours.value = "";
   document.calc.reg_pay.value = "";
   document.calc.ot_hours_rate.value = "";
   document.calc.ot_hours.value = "";
   document.calc.ot_pay.value = "";
   document.calc.tot_hours_rate.value = "";
   document.calc.tot_hours.value = "";
   document.calc.tot_pay.value = "";

   document.getElementById("summary_tbl_1_div").innerHTML = "";
   document.getElementById("summary_footer_div").style.display = "none";
   
   //ADDED FOR STORAGE
   document.getElementById("employee-save-btn").disabled = false;

}

function reset_calc(form) {
	
	if(confirm("Are you sure you want to clear out the entered In/Out times? If yes, click Okay. If not, click Cancel.")) {	

		document.getElementById("summary_tbl_1_div").innerHTML = "";
		document.getElementById("summary_footer_div").style.display = "none";

		document.getElementById("min_fmt_txt").innerHTML = "HH:MM";
		document.getElementById("min_fmt_tot_txt").innerHTML = "hours:minutes";

		var v_per_end = document.calc.per_end.value;
		var v_s_mon_idx = document.calc.s_mon.selectedIndex;
		var v_s_day_idx = document.calc.s_day.selectedIndex;
		var v_s_yr_idx = document.calc.s_yr.selectedIndex;

		var v_e_mon_idx = document.calc.e_mon.selectedIndex;
		var v_e_day_idx = document.calc.e_day.selectedIndex;
		var v_e_yr_idx = document.calc.e_yr.selectedIndex;

		var start_day = document.calc.day.selectedIndex;

		document.calc.reset();

		document.calc.per_end.value = v_per_end;
		document.calc.s_mon.selectedIndex = v_s_mon_idx;
		document.calc.s_day.selectedIndex = v_s_day_idx;
		document.calc.s_yr.selectedIndex = v_s_yr_idx;

		document.calc.e_mon.selectedIndex = v_e_mon_idx;
		document.calc.e_day.selectedIndex = v_e_day_idx;
		document.calc.e_yr.selectedIndex = v_e_yr_idx;

		document.calc.day.selectedIndex = start_day;
		fill_days(document.calc);
		
	}

}

//LOCAL STORAGE FEATURE
var errorMessage = undefined;

var db = getLocalStorage() || dispError("Unfortunately, local storage is not supported by your web browser. If you would like the timesheet to save your entries in between visits you will need to upgrade to a newer version of your web browser software.");

function getLocalStorage() {
	try {
		if( !! window.localStorage ) return window.localStorage;
	} catch(e) {
		return undefined;
	}
}

function dispError( message ) {
    errorMessage = message;
	//alert(errorMessage);
    //haveError = true;
}

var employees_ar = [];
var prefs_ar = [0,0,0,0,0,0,0,0,0,0,0];

window.onload = function() {

   if(errorMessage) {
      document.getElementById("errorMessageSpan").innerHTML = errorMessage;
   	return;
	} else {
	
		if(db.getItem("old-semi-monthly-timesheet-calculator-employees")) {
			var employees = db.getItem("old-semi-monthly-timesheet-calculator-employees");
			employees_ar = JSON.parse(employees);
		}
	
		if(db.getItem("old-semi-monthly-timesheet-calculator-prefs")) {
			var prefs = db.getItem("old-semi-monthly-timesheet-calculator-prefs");
			prefs_ar = JSON.parse(prefs);
			update_prefs();
		}
		
		build_emp_select();
	
		document.getElementById("employees").selectedIndex = 0;
		document.calc.emp_name.value = "";
		document.getElementById("employee-add-btn").style.display = "inline-block";
		document.getElementById("employee-save-btn").style.display = "none";
		document.getElementById("employee-delete-btn").style.display = "none";
	}
}

//BUILDS EMPLOYEE SELECT MENU FROM EMPLOYEES ARRAY
function build_emp_select() {

         var emp_select = "<select name='employees' id='employees' size='1' onChange='change_employee(this.selectedIndex)'>";
			emp_select += "<option value='-1'>New</option>";
			for(var i = 0; i<employees_ar.length; i++ ) {
					emp_select += "<option value='"+i+"'>"+employees_ar[i][3]+"</option>";
			}
	
			emp_select += "</select>";
			document.getElementById("employee_div").innerHTML = emp_select;
}


function update_prefs() {
  if(errorMessage) return;

	document.calc.ot_type.selectedIndex = prefs_ar[0];
	document.calc.ot_fact.value = prefs_ar[1];
	document.calc.day.selectedIndex = prefs_ar[2];
	document.calc.s_mon.selectedIndex = prefs_ar[3];
	document.calc.s_day.selectedIndex = prefs_ar[4];
	document.calc.s_yr.selectedIndex = prefs_ar[5];
	document.calc.e_mon.selectedIndex = prefs_ar[6];
	document.calc.e_day.selectedIndex = prefs_ar[7];
	document.calc.e_yr.selectedIndex = prefs_ar[8];
	document.calc.min_fmt.selectedIndex = prefs_ar[9];
	document.calc.per_end.value = prefs_ar[10];
	
	fill_days(document.calc);
	
}

function save_prefs() {
  if(errorMessage) return;

	prefs_ar[0] = document.calc.ot_type.selectedIndex;
	prefs_ar[1] = document.calc.ot_fact.value;
	prefs_ar[2] = document.calc.day.selectedIndex;
	prefs_ar[3] = document.calc.s_mon.selectedIndex;
	prefs_ar[4] = document.calc.s_day.selectedIndex;
	prefs_ar[5] = document.calc.s_yr.selectedIndex;
	prefs_ar[6] = document.calc.e_mon.selectedIndex;
	prefs_ar[7] = document.calc.e_day.selectedIndex;
	prefs_ar[8] = document.calc.e_yr.selectedIndex;
	prefs_ar[9] = document.calc.min_fmt.selectedIndex;
	prefs_ar[10] = document.calc.per_end.value;
	
	db.setItem("old-semi-monthly-timesheet-calculator-prefs", JSON.stringify(prefs_ar));
}

function add_employee() {
   if(errorMessage) return;
   
   var v_emp_name = document.calc.emp_name.value;
   if(v_emp_name.length == 0) {
      alert("Please enter a name for the employee.");
      document.calc.emp_name.focus();
   } else {
   
		employee_id = employees_ar.length+1;
	
		var line_ar = [0,0,0,0,""];

		line_ar[0] = employee_id;
		line_ar[1] = document.calc.reg_rate.value;
		line_ar[2] = document.calc.ot_rate.value;
		line_ar[3] = document.calc.emp_name.value;
	
		employees_ar.push(line_ar);
		
		build_emp_select();

		document.getElementById("employees").selectedIndex = employee_id;
		document.getElementById("employee-add-btn").style.display = "none";
		document.getElementById("employee-save-btn").style.display = "inline-block";
		document.getElementById("employee-delete-btn").style.display = "inline-block";

		db.setItem("old-semi-monthly-timesheet-calculator-employees", JSON.stringify(employees_ar));
		
	}

}

function change_employee(idx) {
   if(errorMessage) return;
   
   if(idx == 0) {
      document.calc.employees.selectedIndex = 0;
      document.calc.emp_name.value = "";
      document.getElementById("employee-add-btn").style.display = "inline-block";
      document.getElementById("employee-save-btn").style.display = "none";
      document.getElementById("employee-delete-btn").style.display = "none";
      var line_cnt = 0;
      for(var i = 0; i<17; i++) {
			line_cnt += 1;
			//document.getElementById("t_"+line_cnt+"_day").value = "";
	      document.getElementById("t_"+line_cnt+"_in_1").value = "";
	      document.getElementById("t_"+line_cnt+"_out_1").value = "";
	      document.getElementById("t_"+line_cnt+"_in_2").value = "";
	      document.getElementById("t_"+line_cnt+"_out_2").value = "";
	      document.getElementById("t_"+line_cnt+"_in_3").value = "";
	      document.getElementById("t_"+line_cnt+"_out_3").value = "";
	      document.getElementById("t_"+line_cnt+"_hrs").value = "";
		}
   } else {
      var employee_id = idx - 1;
      document.calc.emp_name.value = employees_ar[employee_id][3];
      document.getElementById("employee-add-btn").style.display = "none";
      document.getElementById("employee-save-btn").style.display = "inline-block";
      document.getElementById("employee-delete-btn").style.display = "inline-block";
      
      //POPULATE PREFS
		document.calc.reg_rate.value = employees_ar[employee_id][1];
		document.calc.ot_rate.value = employees_ar[employee_id][2];
		document.calc.emp_name.value = employees_ar[employee_id][3];
	
	   //CHECK TO SEE IF HOURS EXIST FOR SELECTED EMPLOYEE
	   if(employees_ar[employee_id][4].length > 0) {
			var emp_days_ar = employees_ar[employee_id][4].split("||");
			//console.log(emp_days_ar);
			var line_cnt = 0;
			for(var i = 0; i<emp_days_ar.length; i++) {
				var emp_day_ar = emp_days_ar[i].split("##");
				line_cnt += 1;
				//document.getElementById("t_"+line_cnt+"_day").value = emp_day_ar[0];
				document.getElementById("t_"+line_cnt+"_in_1").value = emp_day_ar[0];
				document.getElementById("t_"+line_cnt+"_out_1").value = emp_day_ar[1];
				document.getElementById("t_"+line_cnt+"_in_2").value = emp_day_ar[2];
				document.getElementById("t_"+line_cnt+"_out_2").value = emp_day_ar[3];
				document.getElementById("t_"+line_cnt+"_in_3").value = emp_day_ar[4];
				document.getElementById("t_"+line_cnt+"_out_3").value = emp_day_ar[5];
				document.getElementById("t_"+line_cnt+"_hrs").value = emp_day_ar[6];
			}
		} else {
		   var line_cnt = 0;
			for(var i = 0; i<17; i++) {
				line_cnt += 1;
				//document.getElementById("t_"+line_cnt+"_day").value = "";
				document.getElementById("t_"+line_cnt+"_in_1").value = "";
				document.getElementById("t_"+line_cnt+"_out_1").value = "";
				document.getElementById("t_"+line_cnt+"_in_2").value = "";
				document.getElementById("t_"+line_cnt+"_out_2").value = "";
				document.getElementById("t_"+line_cnt+"_in_3").value = "";
				document.getElementById("t_"+line_cnt+"_out_3").value = "";
				document.getElementById("t_"+line_cnt+"_hrs").value = "";
			}
		}
		
	   
   }
   
   calc_time(document.calc);
   
   document.calc.employee_save_btn.disabled = true;

}

function save_employee() {
   if(errorMessage) return;
   
   var employee_id = document.calc.employees.selectedIndex-1;
   
   employees_ar[employee_id][1] = document.calc.reg_rate.value;
	employees_ar[employee_id][2] = document.calc.ot_rate.value;
	employees_ar[employee_id][3] = document.calc.emp_name.value;
	
   var delim_str = "";
   var line_cnt = 0;
   
   for(var i = 0; i<17; i++) {
   
      line_cnt += 1;
	   
	   //delim_str += "" + document.getElementById("t_"+line_cnt+"_day").value + "##";
	   delim_str += "" + document.getElementById("t_"+line_cnt+"_in_1").value + "##";
	   delim_str += "" + document.getElementById("t_"+line_cnt+"_out_1").value + "##";
	   delim_str += "" + document.getElementById("t_"+line_cnt+"_in_2").value + "##";
	   delim_str += "" + document.getElementById("t_"+line_cnt+"_out_2").value + "##";
	   delim_str += "" + document.getElementById("t_"+line_cnt+"_in_3").value + "##";
	   delim_str += "" + document.getElementById("t_"+line_cnt+"_out_3").value + "##";
	   delim_str += "" + document.getElementById("t_"+line_cnt+"_hrs").value + "";
	   
	   if(i<16) {
	      delim_str += "||";
	   }
	
	}
	
	employees_ar[employee_id][4] = delim_str;
	
	db.setItem("old-semi-monthly-timesheet-calculator-employees", JSON.stringify(employees_ar));

   document.getElementById("employee-save-btn").disabled = true;
}

function delete_employee() {
   if(errorMessage) return;
   
   var employee_id = document.calc.employees.selectedIndex-1;
   
   if(confirm("Are you sure you want to delete " + employees_ar[employee_id][3] + " from the employee list? If not, click the Cancel button.")) {
   
      employees_ar.splice(employee_id,1);
      
      build_emp_select();
	
		document.getElementById("employees").selectedIndex = 0;
		document.getElementById("employee-add-btn").style.display = "inline-block";
		document.getElementById("employee-save-btn").style.display = "none";
		document.getElementById("employee-delete-btn").style.display = "none";
   
      change_employee(0);
	
	   db.setItem("old-semi-monthly-timesheet-calculator-employees", JSON.stringify(employees_ar));
	   
	}

}

function clear_saved_hours() {

   if(errorMessage) return;
   
   if(confirm("Are you sure you want to clear all entered in/out times to start a new pay period? If not, click the Cancel button.")) {
   
      for(var i = 0; i<employees_ar.length; i++) {
      
         employees_ar[i][4] = "";
      }
      
      db.setItem("old-semi-monthly-timesheet-calculator-employees", JSON.stringify(employees_ar));
      
      change_employee(0);
   
   }

}

function clear_all_data() {
	
	if(errorMessage) return;
	
	if(confirm("Are you sure you want to clear all previously saved settings, employees, and in/out times? If not, click the Cancel button.")) {
	
	   db.removeItem("old-semi-monthly-timesheet-calculator-prefs");
	   db.removeItem("old-semi-monthly-timesheet-calculator-employees");
	   
	   employees_ar = [];
      prefs_ar = [0,0,0,0,0,0,0,0,0,0,0];
	   
	   build_emp_select();
		
		document.getElementById("employee-add-btn").style.display = "inline-block";
      document.getElementById("employee-save-btn").style.display = "none";
      document.getElementById("employee-delete-btn").style.display = "none";
      document.calc.emp_name.value = "";
      
      change_employee(0);
      
      reset_calc(document.calc);
	   
	}
}