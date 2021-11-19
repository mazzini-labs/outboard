function resize_panel_functions() {
    show_mobile_or_desktop()
}
var today = new Date();
var now_mon = today.getMonth();
var mon_num = now_mon + 1;
if (mon_num == 12) {
    mon_num = 0
}
var now_day = today.getDate();
var now_yr = today.getFullYear();
var now_time = today.getTime();
var mt_ar = new Array(0,13,14,15,16,17,18,19,20,21,22,23,24,1,2,3,4,5,6,7,8,9,10,11,12);
var zero_ar = new Array('00','01','02','03','04','05','06','07','08','09');
var mlengths = [31, (now_yr % 4 == 0 && now_yr % 100 != 0 || now_yr % 400 == 0) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
var days_ar = new Array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
var full_days_ar = new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
var mnames_ab = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
var mnames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
var eoww_ar = [6, 0, 1, 2, 3, 4, 5];
function calc_time_desktop(id) {
    var time_txt = document.getElementById("dt_t_" + id).value;
    var time_entry = time_txt;
    if (time_txt.indexOf(":") > -1) {
        time_entry = time_txt.replace(":", "")
    }
    document.getElementById("t_" + id).value = Number(sn(time_entry));
    calc_time(1)
}
function sh_day(idx) {
    if ($("#day-" + idx + "").css("display") == "none") {
        $("#day-" + idx + "").css("display", "table");
        $("#day-btn-" + idx + "").removeClass('ui-icon-plus').addClass('ui-icon-minus')
    } else {
        $("#day-" + idx + "").css("display", "none");
        $("#day-btn-" + idx + "").removeClass('ui-icon-minus').addClass('ui-icon-plus')
    }
}
function expand_all(form) {
    for (var i = 1; i < 187; i++) {
        $("#day-" + i + "").css("display", "table");
        $("#day-btn-" + i + "").removeClass('ui-icon-plus').addClass('ui-icon-minus')
    }
}
function collapse_all(form) {
    for (var i = 1; i < 18; i++) {
        $("#day-" + i + "").css("display", "none");
        $("#day-btn-" + i + "").removeClass('ui-icon-minus').addClass('ui-icon-plus')
    }
}
function mins(h, m) {
    var hr_mins = h * 60;
    var tot_mins = Number(hr_mins) + Number(m);
    return tot_mins
}
function mins_to_time(mins) {
    var hrs = Math.floor(mins / 60);
    var ev_hrs = hrs * 60;
    var rem_mins = Number(mins) - Number(ev_hrs);
    var min_txt = "";
    if (rem_mins < 10) {
        min_txt = zero_ar[rem_mins]
    } else {
        min_txt = rem_mins
    }
    var time_txt = hrs + ":" + min_txt;
    return time_txt
}
function mins_to_time_frac(mins) {
    var hrs = Math.round(mins / 60 * 100) / 100;
    var time_txt = fns(hrs, 2, 0, 0, 0);
    return time_txt
}
function chg_min_fmt(form) {
    var v_min_fmt = document.calc.min_fmt.selectedIndex;
    if (v_min_fmt === 0) {
        $(".min_fmt_txt").text("HH:MM")
    } else {
        $(".min_fmt_txt").text("HH.HH")
    }
    calc_time(0);
    clear_results(document.calc)
}
function fill_days(form) {
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
    var date_diff = Math.round((e_time - s_time) / 86400000) + 1;
    var day_lu = 0;
    var txt_day = "";
    var fld_day = "";
    for (var i = 1; i < 18; i++) {
        if (i <= date_diff && date_diff > 12 && date_diff < 18) {
            $("#t_" + i + "_in_1").prop("disabled", false);
            $("#t_" + i + "_out_1").prop("disabled", false);
            $("#t_" + i + "_in_2").prop("disabled", false);
            $("#t_" + i + "_out_2").prop("disabled", false);
            $("#t_" + i + "_in_3").prop("disabled", false);
            $("#t_" + i + "_out_3").prop("disabled", false);
            $("#dt_t_" + i + "_in_1").prop("disabled", false);
            $("#dt_t_" + i + "_out_1").prop("disabled", false);
            $("#dt_t_" + i + "_in_2").prop("disabled", false);
            $("#dt_t_" + i + "_out_2").prop("disabled", false);
            $("#dt_t_" + i + "_in_3").prop("disabled", false);
            $("#dt_t_" + i + "_out_3").prop("disabled", false);
            day_lu = s_date.getDay();
            fld_day = days_ar[day_lu] + " " + mnames_ab[s_date.getMonth()] + " " + s_date.getDate();
            document.getElementById("t_" + i + "_day").value = fld_day;
            txt_day = "";
            txt_day += "<span class='fld-lbl-xsm'>" + days_ar[day_lu] + " " + (s_date.getMonth() + 1) + "/" + s_date.getDate() + "</span>";
            txt_day += "<span class='fld-lbl-sm'>" + full_days_ar[day_lu] + " " + (s_date.getMonth() + 1) + "/" + s_date.getDate() + "</span>";
            txt_day += "<span class='fld-lbl-md'>" + full_days_ar[day_lu] + ", " + mnames[s_date.getMonth()] + " " + s_date.getDate() + "</span>";
            txt_day += "<span class='fld-lbl-lg'>" + full_days_ar[day_lu] + ", " + mnames[s_date.getMonth()] + " " + s_date.getDate() + "</span>";
            $("#t_" + i + "_day_txt").html(txt_day);
            $("#dt_t_" + i + "_day").val(fld_day);
            document.getElementById("dt_t_" + i + "_day").disabled = false;
            document.getElementById("t_" + i + "_dotw").value = s_date.getDay();
            s_time += 86400000;
            s_date.setTime(s_time);
            pp_days += 1
        } else {
            $("#t_" + i + "_day_txt").text("N/A");
            document.getElementById("t_" + i + "_day").value = "";
            $("#dt_t_" + i + "_day").val("");
            $("#dt_t_" + i + "_day").prop("disabled", true);
            $("#t_" + i + "_hrs_txt").text("");
            document.getElementById("t_" + i + "_hrs").value = "";
            $("#t_" + i + "_in_1").prop("disabled", true);
            $("#t_" + i + "_out_1").prop("disabled", true);
            $("#t_" + i + "_in_2").prop("disabled", true);
            $("#t_" + i + "_out_2").prop("disabled", true);
            $("#t_" + i + "_in_3").prop("disabled", true);
            $("#t_" + i + "_out_3").prop("disabled", true);
            $("#dt_t_" + i + "_in_1").prop("disabled", true);
            $("#dt_t_" + i + "_out_1").prop("disabled", true);
            $("#dt_t_" + i + "_in_2").prop("disabled", true);
            $("#dt_t_" + i + "_out_2").prop("disabled", true);
            $("#dt_t_" + i + "_in_3").prop("disabled", true);
            $("#dt_t_" + i + "_out_3").prop("disabled", true)
        }
    }
    document.calc.per_end.value = days_ar[day_lu] + " " + v_e_mon + " " + v_e_day + ", " + v_e_yr + "";
    document.calc.h_pp_days.value = pp_days;
    calc_time(0);
    clear_results(document.calc)
}
function calc_ot_rate(form) {
    var v_reg_rate = sn(document.calc.reg_rate.value);
    var v_ot_fact = sn($("#ot_fact").val());
    var ot_type_idx = 0;
    if (document.getElementById("ot-type-1").checked) {
        ot_type_idx = 1
    } else if (document.getElementById("ot-type-2").checked) {
        ot_type_idx = 2
    } else if (document.getElementById("ot-type-3").checked) {
        ot_type_idx = 3
    } else if (document.getElementById("ot-type-4").checked) {
        ot_type_idx = 4
    }
    var v_ot_rate = v_reg_rate * v_ot_fact;
    $("#ot_rate_txt").text(fns(v_ot_rate, 2, 1, 0, 0));
    $("#ot_rate").val(fns(v_ot_rate, 2, 1, 0, 0));
    if (ot_type_idx == 3) {
        $("#day").prop("disabled", false);
        $("#co_hrs").prop("disabled", false)
    } else {
        $("#day").prop("disabled", true);
        $("#co_hrs").prop("disabled", true)
    }
    clear_results(document.calc)
}
function calc_raw(raw) {
    var raw_hr = 0;
    var raw_min = 0;
    var raw_str = "" + raw + "";
    if (raw < 100) {
        raw_hr = raw;
        raw_min = 0
    } else if (raw < 1000) {
        raw_hr = raw_str.substring(0, 1);
        raw_min = raw_str.substring(1, 3)
    } else {
        raw_hr = raw_str.substring(0, 2);
        raw_min = raw_str.substring(2, 4)
    }
    var raw_del = raw_hr + ":" + raw_min;
    return raw_del
}
function calc_txt(raw) {
    var raw_hr = 0;
    var raw_min = 0;
    var raw_del = "";
    var raw_str = "" + raw + "";
    if (raw_str.indexOf(".") > -1) {
        raw_min = raw % 1;
        raw_hr = raw - raw_min;
        raw_min = Math.round(raw_min * 60);
        raw_del = raw_hr + ":" + raw_min
    } else {
        if (raw == 0) {
            raw_del = ""
        } else {
            if (raw < 100) {
                raw_hr = raw;
                raw_min = 0
            } else if (raw < 1000) {
                raw_hr = raw_str.substring(0, 1);
                raw_min = raw_str.substring(1, 3)
            } else {
                raw_hr = raw_str.substring(0, 2);
                raw_min = raw_str.substring(2, 4)
            }
            if (raw_min == "0") {
                raw_min = "" + raw_min + "0"
            }
            raw_del = raw_hr + ":" + raw_min
        }
    }
    return raw_del
}
function calc_gross(form) {
    var v_reg_rate = sn(document.calc.reg_rate.value);
    var v_ot_rate = sn(document.getElementById("ot_rate").value);
    var ot_type_idx = 0;
    if (document.getElementById("ot-type-1").checked) {
        ot_type_idx = 1
    } else if (document.getElementById("ot-type-2").checked) {
        ot_type_idx = 2
    } else if (document.getElementById("ot-type-3").checked) {
        ot_type_idx = 3
    } else if (document.getElementById("ot-type-4").checked) {
        ot_type_idx = 4
    }
    var v_total_time = document.calc.total_time.value;
    var v_min_fmt = document.calc.min_fmt.selectedIndex;
    var s_wkday = sn(document.getElementById("day").selectedIndex);
    var e_wkday = eoww_ar[s_wkday];
    var v_co_hrs = sn(document.calc.co_hrs.value);
    var v_pp_days = sn(document.calc.h_pp_days.value);
    if (v_total_time == "0:00" || v_total_time == "0.00") {
        alert("Please complete the time sheet before you attempt to calculate your gross wages.");
        document.calc.reg_rate.focus()
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
        if (ot_type_idx == 0 || ot_type_idx == 4) {
            if (v_min_fmt == 0) {
                var time_ar = v_total_time.split(":");
                hr = Number(time_ar[0]);
                mn = Number(time_ar[1]);
                mins = hr * 60 + mn
            } else {
                mins = Math.round(Number(v_total_time) * 60 * 100) / 100
            }
            if (ot_type_idx == 0) {
                accum_reg_mins = mins;
                accum_ot_mins = 0
            } else {
                if (mins > 5760) {
                    accum_reg_mins = 5760;
                    accum_ot_mins = Number(mins) - Number(5760)
                } else {
                    accum_reg_mins = mins;
                    accum_ot_mins = 0
                }
            }
            $("#co_next_time_txt").text("N/A");
            document.calc.co_next_time.value = "N/A"
        } else if (ot_type_idx == 3) {
            var wk_ot_mins = 0;
            var tdotw = 0;
            var v_co_mins = 0;
            var wk_cnt = 0;
            v_co_mins = Number(v_co_hrs) * 60;
            if (v_co_mins > 2400) {
                accum_40_hrs = 2400
            } else {
                accum_40_hrs = v_co_mins
            }
            for (var i = 1; i <= v_pp_days; i++) {
                tm = document.getElementById("t_" + i + "_hrs").value;
                tdotw = document.getElementById("t_" + i + "_dotw").value;
                if (tm.length > 0) {
                    if (v_min_fmt == 0) {
                        var time_ar = tm.split(":");
                        hr = Number(time_ar[0]);
                        mn = Number(time_ar[1]);
                        mins = hr * 60 + mn
                    } else {
                        mins = Math.round(Number(tm) * 60 * 100) / 100
                    }
                    accum_40_hrs += mins;
                    accum_reg_mins += mins
                }
                if (tdotw == e_wkday) {
                    if (accum_40_hrs > 2400) {
                        wk_ot_mins = Number(accum_40_hrs) - Number(2400);
                        accum_ot_mins += wk_ot_mins;
                        accum_reg_mins -= wk_ot_mins
                    } else {}
                    wk_cnt += 1;
                    accum_40_hrs = 0
                }
            }
            if (wk_cnt < 3) {
                if (accum_40_hrs > 2400) {
                    wk_ot_mins = Number(accum_40_hrs) - Number(2400);
                    accum_ot_mins += wk_ot_mins;
                    accum_reg_mins -= wk_ot_mins
                }
            }
            $("#co_next_time_txt").text(mins_to_time_frac(accum_40_hrs));
            document.calc.co_next_time.value = mins_to_time_frac(accum_40_hrs)
        } else {
            var daily_reg_mins = 480;
            if (ot_type_idx == 2) {
                daily_reg_mins = 600
            }
            for (var i = 1; i <= v_pp_days; i++) {
                tm = document.getElementById("t_" + i + "_hrs").value;
                if (tm.length > 0) {
                    if (v_min_fmt == 0) {
                        var time_ar = tm.split(":");
                        hr = Number(time_ar[0]);
                        mn = Number(time_ar[1]);
                        mins = hr * 60 + mn
                    } else {
                        mins = Math.round(Number(tm) * 60 * 100) / 100
                    }
                    if (mins > daily_reg_mins) {
                        ot_mins = Number(mins) - Number(daily_reg_mins);
                        mins = daily_reg_mins
                    } else {
                        ot_mins = 0
                    }
                    accum_ot_mins += ot_mins;
                    accum_reg_mins += mins
                }
            }
            $("#co_next_time_txt").text("N/A");
            document.calc.co_next_time.value = "N/A"
        }
        $("#reg_hours_rate_txt").text(fns(v_reg_rate, 2, 1, 1, 1));
        document.calc.reg_hours_rate.value = v_reg_rate;
        v_reg_hours = Math.round(accum_reg_mins / 60 * 100) / 100;
        $("#reg_hours_txt").text(fns(v_reg_hours, 2, 0, 0, 0));
        document.calc.reg_hours.value = v_reg_hours;
        v_reg_pay = v_reg_hours * v_reg_rate;
        $("#reg_pay_txt").text(fns(v_reg_pay, 2, 1, 1, 1));
        document.calc.reg_pay.value = v_reg_pay;
        $("#ot_hours_rate_txt").text(fns(v_ot_rate, 2, 1, 1, 1));
        document.calc.ot_hours_rate.value = v_ot_rate;
        v_ot_hours = Math.round(accum_ot_mins / 60 * 100) / 100;
        $("#ot_hours_txt").text(fns(v_ot_hours, 2, 0, 0, 0));
        document.calc.ot_hours.value = v_ot_hours;
        v_ot_pay = v_ot_hours * v_ot_rate;
        $("#ot_pay_txt").text(fns(v_ot_pay, 2, 1, 1, 1));
        document.calc.ot_pay.value = v_ot_pay;
        $("#tot_hours_rate_txt").text("");
        document.calc.tot_hours_rate.value = "";
        var v_tot_hours = Number(v_reg_hours) + Number(v_ot_hours);
        $("#tot_hours_txt").text(fns(v_tot_hours, 2, 0, 0, 0));
        document.calc.tot_hours.value = v_tot_hours;
        var v_tot_pay = Number(v_reg_pay) + Number(v_ot_pay);
        $("#tot_pay_txt").text(fns(v_tot_pay, 2, 1, 1, 1));
        document.calc.tot_pay.value = v_tot_pay;
        $('#clc-sum-row').css('display', 'table-row');
        $('#clc-sum-cell').css('display', 'table-cell')
    }
}
function calc_time(update_desktop) {
    var v_min_fmt = document.calc.min_fmt.selectedIndex;
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
    for (var i = 1; i < 18; i++) {
        day_mins = 0;
        for (var j = 1; j < 4; j++) {
            inn = sn(document.getElementById("t_" + i + "_in_" + j + "").value);
            out = sn(document.getElementById("t_" + i + "_out_" + j + "").value);
            if (update_desktop != 1) {
                if (inn > 0) {
                    document.getElementById("dt_t_" + i + "_in_" + j + "").value = inn
                } else {
                    document.getElementById("dt_t_" + i + "_in_" + j + "").value = ""
                }
                if (out > 0) {
                    document.getElementById("dt_t_" + i + "_out_" + j + "").value = out
                } else {
                    document.getElementById("dt_t_" + i + "_out_" + j + "").value = ""
                }
            }
            if (inn % 1 > 0) {
                inn = ((inn - (inn % 1)) * 100) + Math.round(inn % 1 * 60 * 100) / 100
            }
            if (out % 1 > 0) {
                out = ((out - (out % 1)) * 100) + Math.round(out % 1 * 60 * 100) / 100
            }
            if (inn > 0 && out > 0) {
                in_del = calc_raw(inn);
                out_del = calc_raw(out);
                var in_ar = in_del.split(":");
                var out_ar = out_del.split(":");
                in_hr = Number(in_ar[0]);
                in_min = Number(in_ar[1]);
                out_hr = Number(out_ar[0]);
                out_min = Number(out_ar[1]);
                if (in_hr > out_hr) {
                    out_hr = mt_ar[out_hr];
                    if (in_hr > 12) {
                        in_hr = mt_ar[in_hr]
                    }
                }
                in_mins = mins(in_hr, in_min);
                out_mins = mins(out_hr, out_min);
                time_mins = Number(out_mins) - Number(in_mins);
                day_mins += time_mins
            } else {
                in_hr = 0;
                in_min = 0;
                out_hr = 0;
                out_min = 0
            }
        }
        if (day_mins > 0 && day_mins < 1440) {
            if (v_min_fmt == 0) {
                $("#t_" + i + "_hrs_txt").text(mins_to_time(day_mins));
                document.getElementById("t_" + i + "_hrs").value = mins_to_time(day_mins)
            } else {
                $("#t_" + i + "_hrs_txt").text(mins_to_time_frac(day_mins));
                document.getElementById("t_" + i + "_hrs").value = mins_to_time_frac(day_mins)
            }
        } else {
            if (v_min_fmt == 0) {
                $("#t_" + i + "_hrs_txt").text("0:00");
                document.getElementById("t_" + i + "_hrs").value = ""
            } else {
                $("#t_" + i + "_hrs_txt").text("0.00");
                document.getElementById("t_" + i + "_hrs").value = ""
            }
        }
        $("#dt_t_" + i + "_hrs_txt").text($("#t_" + i + "_hrs_txt").text());
        week_mins += day_mins
    }
    if (v_min_fmt == 0) {
        $("#total_time_txt").text(mins_to_time(week_mins));
        document.calc.total_time.value = mins_to_time(week_mins)
    } else {
        $("#total_time_txt").text(mins_to_time_frac(week_mins));
        document.calc.total_time.value = mins_to_time_frac(week_mins)
    }
    clear_results(document.calc)
}
function time_card_report(form) {
    var v_min_fmt = document.calc.min_fmt.selectedIndex;
    var v_total_time = document.calc.total_time.value;
    var ot_type_idx = 0;
    if (document.getElementById("ot-type-1").checked) {
        ot_type_idx = 1
    } else if (document.getElementById("ot-type-2").checked) {
        ot_type_idx = 2
    } else if (document.getElementById("ot-type-3").checked) {
        ot_type_idx = 3
    } else if (document.getElementById("ot-type-4").checked) {
        ot_type_idx = 4
    }
    if (v_total_time == "0:00" || v_total_time == "0.00") {
        alert("Please enter some work hours before attempting to view the printer friendly report.")
    } else {
        calc_gross(document.calc);
        var tbl = "<table class='cht-tbl'>";
        tbl += "<tr>";
        tbl += "<th colspan='8' class='cht-td-borders'>Semi-Monthly Time Sheet Report</th>";
        tbl += "</tr>";
        tbl += "<tr>";
        tbl += "<td colspan='8' class='cht-td-borders'>Name: <strong>" + document.calc.emp_name.value + "</strong></td>";
        tbl += "</tr>";
        tbl += "<tr>";
        tbl += "<td colspan='8' class='cht-td-borders'>Period ending: <strong>" + document.calc.per_end.value + "</strong></td>";
        tbl += "</tr>";
        tbl += "<tr class='cht-row-odd'>";
        tbl += "<th class='cht-td-borders ctr'>Day</th>";
        tbl += "<th colspan='2' class='cht-td-borders ctr'>Time Block 1</th>";
        tbl += "<th colspan='2' class='cht-td-borders ctr'>Time Block 2</th>";
        tbl += "<th colspan='2' class='cht-td-borders ctr'>Time Block 3</th>";
        if (v_min_fmt == 0) {
            tbl += "<th class='cht-td-borders ctr'>HH:MM</th>"
        } else {
            tbl += "<th class='cht-td-borders ctr'>HH.HH</th>"
        }
        tbl += "</tr>";
        tbl += "<tr>";
        tbl += "<th style='width: 17%;' class='cht-td-borders ctr'>&nbsp;</th>";
        tbl += "<th style='width: 11%;' class='cht-td-borders ctr'>In</th>";
        tbl += "<th style='width: 11%;' class='cht-td-borders ctr'>Out</th>";
        tbl += "<th style='width: 11%;' class='cht-td-borders ctr'>In</th>";
        tbl += "<th style='width: 11%;' class='cht-td-borders ctr'>Out</th>";
        tbl += "<th style='width: 11%;' class='cht-td-borders ctr'>In</th>";
        tbl += "<th style='width: 11%;' class='cht-td-borders ctr'>Out</th>";
        tbl += "<th style='width: 17%;' class='cht-td-borders ctr'>&nbsp;</th>";
        tbl += "</tr>";
        var in_1 = "";
        var out_1 = "";
        var in_2 = "";
        var out_2 = "";
        var in_3 = "";
        var out_3 = "";
        var row_col = "";
        for (var i = 1; i < 18; i++) {
            if (i % 2 == 0) {
                row_col = ""
            } else {
                row_col = "class='cht-row-odd'"
            }
            in_1 = calc_txt(sn(document.getElementById("t_" + i + "_in_1").value));
            out_1 = calc_txt(sn(document.getElementById("t_" + i + "_out_1").value));
            in_2 = calc_txt(sn(document.getElementById("t_" + i + "_in_2").value));
            out_2 = calc_txt(sn(document.getElementById("t_" + i + "_out_2").value));
            in_3 = calc_txt(sn(document.getElementById("t_" + i + "_in_3").value));
            out_3 = calc_txt(sn(document.getElementById("t_" + i + "_out_3").value));
            tbl += "<tr " + row_col + ">";
            tbl += "<td class='cht-td-borders rgt'>" + document.getElementById("t_" + i + "_day").value + "</td>";
            tbl += "<td class='cht-td-borders rgt'>" + in_1 + "</td>";
            tbl += "<td class='cht-td-borders rgt'>" + out_1 + "</td>";
            tbl += "<td class='cht-td-borders rgt'>" + in_2 + "</td>";
            tbl += "<td class='cht-td-borders rgt'>" + out_2 + "</td>";
            tbl += "<td class='cht-td-borders rgt'>" + in_3 + "</td>";
            tbl += "<td class='cht-td-borders rgt'>" + out_3 + "</td>";
            tbl += "<td class='cht-td-borders rgt'>" + document.getElementById("t_" + i + "_hrs").value + "</td>";
            tbl += "</tr>"
        }
        tbl += "<tr class='cht-row-odd'>";
        tbl += "<td colspan='7' class='cht-td-borders'>";
        if (v_min_fmt == 0) {
            tbl += "Total hours:minutes for pay period:"
        } else {
            tbl += "Total hours for pay period:"
        }
        tbl += "</td>";
        tbl += "<td class='cht-td-borders rgt'>";
        tbl += "" + document.calc.total_time.value + "";
        tbl += "</td>";
        tbl += "</tr>";
        if (ot_type_idx == 3) {
            tbl += "<tr>";
            tbl += "<td colspan='7' class='cht-td-borders'>";
            tbl += "Hours to carry forward for OT calculations:";
            tbl += "</td>";
            tbl += "<td class='cht-td-borders rgt'>";
            tbl += "" + fns(document.calc.co_next_time.value, 2, 0, 0, 0) + "";
            tbl += "</td>";
            tbl += "</tr>"
        }
        tbl += "<tr>";
        tbl += "<th colspan='2' class='cht-td-borders ctr'>";
        tbl += "Type";
        tbl += "</th>";
        tbl += "<th colspan='2' class='cht-td-borders ctr'>";
        tbl += "Rate";
        tbl += "</th>";
        tbl += "<th colspan='2' class='cht-td-borders ctr'>";
        tbl += "Hours (10ths)";
        tbl += "</th>";
        tbl += "<th colspan='2' class='cht-td-borders ctr'>";
        tbl += "Pay";
        tbl += "</th>";
        tbl += "</tr>";
        tbl += "<tr class='cht-row-odd'>";
        tbl += "<td colspan='2' class='cht-td-borders'>";
        tbl += "Regular:";
        tbl += "</td>";
        tbl += "<td colspan='2' class='cht-td-borders rgt'>";
        tbl += "" + fns(document.calc.reg_hours_rate.value, 2, 1, 1, 1) + "";
        tbl += "</td>";
        tbl += "<td colspan='2' class='cht-td-borders rgt'>";
        tbl += "" + fns(document.calc.reg_hours.value, 2, 0, 0, 0) + "";
        tbl += "</td>";
        tbl += "<td colspan='2' class='cht-td-borders rgt'>";
        tbl += "" + fns(document.calc.reg_pay.value, 2, 1, 1, 1) + "";
        tbl += "</td>";
        tbl += "</tr>";
        tbl += "<tr>";
        tbl += "<td colspan='2' class='cht-td-borders'>";
        tbl += "Overtime:";
        tbl += "</td>";
        tbl += "<td colspan='2' class='cht-td-borders rgt'>";
        tbl += "" + fns(document.calc.ot_hours_rate.value, 2, 1, 1, 1) + "";
        tbl += "</td>";
        tbl += "<td colspan='2' class='cht-td-borders rgt'>";
        tbl += "" + fns(document.calc.ot_hours.value, 2, 0, 0, 0) + "";
        tbl += "</td>";
        tbl += "<td colspan='2' class='cht-td-borders rgt'>";
        tbl += "" + fns(document.calc.ot_pay.value, 2, 1, 1, 1) + "";
        tbl += "</td>";
        tbl += "</tr>";
        tbl += "<tr class='cht-row-odd'>";
        tbl += "<td colspan='2' class='cht-td-borders'>";
        tbl += "Totals:";
        tbl += "</td>";
        tbl += "<td colspan='2' class='cht-td-borders rgt'>";
        tbl += "" + document.calc.tot_hours_rate.value + "";
        tbl += "</td>";
        tbl += "<td colspan='2' class='cht-td-borders rgt'>";
        tbl += "" + fns(document.calc.tot_hours.value, 2, 0, 0, 0) + "";
        tbl += "</td>";
        tbl += "<td colspan='2' class='cht-td-borders rgt'>";
        tbl += "" + fns(document.calc.tot_pay.value, 2, 1, 1, 1) + "";
        tbl += "</td>";
        tbl += "</tr>";
        tbl += "</table>";
        $('#clc-sum-row').css('display', 'table-row');
        $('#clc-sum-cell').css('display', 'table-cell');
        reportWin = window.open("", "", "width=800,height=600,toolbar=yes,menubar=no,scrollbars=yes,resizable=yes");
        reportWin.document.write("<html><head><title>Semi_monthly Time Sheet Report</title>");
        reportWin.document.write("<lin");
        reportWin.document.write("k href='support-files/_css_r_glob-site-html5.css' rel='stylesheet' type='text/css'><style>.fld-lbl-xsm { display: none; } .fld-lbl-sm { display: none; } .fld-lbl-md { display: none; } .fld-lbl-lg { display: inline; }</style>");
        reportWin.document.write("</head>");
        reportWin.document.write("<bo");
        reportWin.document.write("dy style='background-color: #FFFFFF;'><div class='pfr-page-wrapper'>");
        reportWin.document.write(tbl);
        reportWin.document.write("<div class='non-member-only-content pfr-brand-div'>Report created with 3-Column Semi-Monthly Time Sheet Calculator at<br />");
        reportWin.document.write("https://www.free-online-calculator-use.com/semi-monthly-timesheet-calculator.html</div>");
        reportWin.document.write("<div class='pfr-btn-div'>");
        reportWin.document.write("<form method='post'>");
        reportWin.document.write("<input class='dontprint' type='button' value='Print Report' onClick='window.print()'> ");
        reportWin.document.write("<input class='dontprint' type='button' value='Close Window' onClick='window.close()'>");
        reportWin.document.write("</form></div></div></body></html>");
        reportWin.document.close()
    }
}
function calc_smot() {
    var v_pay_dotw_idx = document.smot_calc.smot_pay_dotw.selectedIndex;
    var v_period_dotw_idx = document.smot_calc.smot_period_dotw.selectedIndex;
    var v_last_period_days = v_period_dotw_idx - v_pay_dotw_idx;
    var v_pay_dotw = v_pay_dotw_idx;
    var old_partial_hrs = 0;
    var new_partial_hrs = 0;
    for (var i = 0; i < 7; i++) {
        hr = sn($("#smot_hr_" + i).val());
        mn = sn($("#smot_mn_" + i).val());
        dec_mn = Math.round(mn / 60 * 100) / 100;
        dec_time = hr + dec_mn;
        $("#smot_dec_" + i).text(fns(dec_time, 2, 0, 0, 0));
        if (i < v_last_period_days) {
            old_partial_hrs += dec_time
        } else {
            new_partial_hrs += dec_time
        }
    }
    var tot_payweek_hrs = old_partial_hrs + new_partial_hrs;
    var ot_hrs = 0;
    var new_reg_hrs = new_partial_hrs;
    var new_ot_hrs = 0;
    if (tot_payweek_hrs > 40) {
        ot_hrs = tot_payweek_hrs - 40;
        if (new_partial_hrs > 0) {
            new_reg_hrs = new_reg_hrs - ot_hrs;
            new_ot_hrs = ot_hrs
        }
    }
    $("#smot_old_partial_hrs").text(fns(old_partial_hrs, 2, 0, 0, 0));
    $("#smot_new_partial_hrs").text(fns(new_partial_hrs, 2, 0, 0, 0));
    $("#smot_payweek_hrs").text(fns(tot_payweek_hrs, 2, 0, 0, 0));
    $("#smot_payweek_ot_hrs").text(fns(ot_hrs, 2, 0, 0, 0));
    $("#smot_new_reg_hrs").text(fns(new_reg_hrs, 2, 0, 0, 0));
    $("#smot_new_ot_hrs").text(fns(new_ot_hrs, 2, 0, 0, 0))
}
function change_smot_days() {
    var v_pay_dotw_idx = Number(document.smot_calc.smot_pay_dotw.selectedIndex);
    var v_period_dotw_idx = Number(document.smot_calc.smot_period_dotw.selectedIndex);
    var v_last_period_days = v_period_dotw_idx - v_pay_dotw_idx;
    var v_pay_dotw = v_pay_dotw_idx;
    for (var i = 0; i < 7; i++) {
        $("#smot_dotw_" + i).text(days_ar[v_pay_dotw]);
        if (i === v_last_period_days) {
            $("#smot_row_" + i).css("background-color", "yellow")
        } else {
            $("#smot_row_" + i).css("background-color", "white")
        }
        v_pay_dotw += 1;
        if (v_pay_dotw === 7) {
            v_pay_dotw = 0
        }
    }
    clear_smot_results()
}
function calc_smot_dec(id) {
    var hr = 0;
    var mn = 0;
    var dec_mn = 0;
    var dec_time = 0;
    var accum_time = 0;
    hr = sn($("#smot_hr_" + id).val());
    mn = sn($("#smot_mn_" + id).val());
    dec_mn = Math.round(mn / 60 * 100) / 100;
    dec_time = hr + dec_mn;
    $("#smot_dec_" + id).text(fns(dec_time, 2, 0, 0, 0));
    var mn_txt = $("#smot_mn_" + id).val();
    if (id < 6 && mn_txt.length > 1) {
        $("#smot_hr_" + (id + 1)).select()
    }
    clear_smot_results()
}
function clear_smot_results() {
    $("#smot_old_partial_hrs").text("");
    $("#smot_new_partial_hrs").text("");
    $("#smot_payweek_hrs").text("");
    $("#smot_payweek_ot_hrs").text("");
    $("#smot_new_reg_hrs").text("");
    $("#smot_new_ot_hrs").text("")
}
function reset_smot() {
    for (var i = 0; i < 7; i++) {
        $("#smot_dotw_" + i).text(days_ar[i]);
        $("#smot_row_" + i).css("background-color", "white");
        $("#smot_dec_" + i).text("0.00")
    }
    clear_smot_results();
    document.smot_calc.reset()
}
function clear_results(form) {
    document.calc.reg_hours_rate.value = "";
    document.calc.reg_hours.value = "";
    document.calc.reg_pay.value = "";
    document.calc.ot_hours_rate.value = "";
    document.calc.ot_hours.value = "";
    document.calc.ot_pay.value = "";
    document.calc.tot_hours_rate.value = "";
    document.calc.tot_hours.value = "";
    document.calc.tot_pay.value = "";
    document.calc.co_next_time.value = "";
    $("#reg_hours_rate_txt").text("");
    $("#reg_hours_txt").text("");
    $("#reg_pay_txt").text("");
    $("#ot_hours_rate_txt").text("");
    $("#ot_hours_txt").text("");
    $("#ot_pay_txt").text("");
    $("#tot_hours_rate_txt").text("");
    $("#tot_hours_txt").text("");
    $("#tot_pay_txt").text("");
    $("#co_next_time_txt").text("");
    $('#clc-sum-row').css('display', 'none');
    $('#clc-sum-cell').css('display', 'none');
    resize_panel()
}
function clear_sheet_only() {
    if (confirm("Are you sure you want to clear out all of your time entries? Tap \"Okay\" to clear time entries.")) {
        for (var i = 1; i < 18; i++) {
            for (var j = 1; j < 4; j++) {
                $("#t_" + i + "_in_" + j + "").val("");
                $("#t_" + i + "_out_" + j + "").val("")
            }
        }
        calc_time()
    }
}
function reset_calc(form) {
    if (confirm("Are you sure you want to restore the calculator to its original state? Tap \"Okay\" to reset the calculator.")) {
        $("#reg_hours_rate_txt").text("");
        $("#reg_hours_txt").text("");
        $("#reg_pay_txt").text("");
        $("#ot_hours_rate_txt").text("");
        $("#ot_hours_txt").text("");
        $("#ot_pay_txt").text("");
        $("#tot_hours_rate_txt").text("");
        $("#tot_hours_txt").text("");
        $("#tot_pay_txt").text("");
        $("#co_next_time_txt").text("");
        $('#clc-sum-row').css('display', 'none');
        $('#clc-sum-cell').css('display', 'none');
        resize_panel();
        var v_per_end = document.calc.per_end.value;
        var v_s_mon_idx = document.getElementById("s_mon").selectedIndex;
        var v_s_day_idx = document.getElementById("s_day").selectedIndex;
        var v_s_yr_idx = document.getElementById("s_yr").selectedIndex;
        var v_e_mon_idx = document.getElementById("e_mon").selectedIndex;
        var v_e_day_idx = document.getElementById("e_day").selectedIndex;
        var v_e_yr_idx = document.getElementById("e_yr").selectedIndex;
        var start_day = document.getElementById("day").selectedIndex;
        glob_calc_reset();
        document.calc.per_end.value = v_per_end;
        document.getElementById("s_mon").selectedIndex = v_s_mon_idx;
        document.getElementById("s_day").selectedIndex = v_s_day_idx;
        document.getElementById("s_yr").selectedIndex = v_s_yr_idx;
        document.getElementById("e_mon").selectedIndex = v_e_mon_idx;
        document.getElementById("e_day").selectedIndex = v_e_day_idx;
        document.getElementById("e_yr").selectedIndex = v_e_yr_idx;
        document.getElementById("day").selectedIndex = start_day;
        fill_days(document.calc);
        for (var i = 1; i < 18; i++) {
            for (var j = 1; j < 4; j++) {
                $("#t_" + i + "_in_" + j + "").val("");
                $("#t_" + i + "_out_" + j + "").val("")
            }
        }
        calc_time();
        scroll_to_id("calc-table")
    }

}
function show_mobile_or_desktop() {
    var sw = Number(document.body.clientWidth);
    var calc_width = Number($("#calc-table").width());
    if (sw > 778 && calc_width > 500) {
        $(".clc-sec-desktop").css("display", "table-row-group");
        $(".clc-sec-mobile").css("display", "none");
        $(".mobile-explain").css("display", "none");
        $(".desktop-explain").css("display", "block")
    } else {
        $(".clc-sec-desktop").css("display", "none");
        $(".clc-sec-mobile").css("display", "table-row-group");
        $(".mobile-explain").css("display", "block");
        $(".desktop-explain").css("display", "none")
    }
}
function calc_ready_function() {
    var year_opts = "";
    var start_year = 2007;
    var end_year = now_yr + 1;
    for (var i = start_year; i <= end_year; i++) {
        if (i === now_yr) {
            year_opts += "<option value='" + i + "' selected>" + i + "</option>"
        } else {
            year_opts += "<option value='" + i + "'>" + i + "</option>"
        }
    }
    $("#s_yr").html(year_opts);
    $("#e_yr").html(year_opts);
    var full_form = "<tr id=\"clc-desktop-row\" class=\"clc-summary\">";
    full_form += "<td id=\"clc-desktop-cell\" class=\"ui-body-c\">";
    full_form += "<table class=\"cht-tbl\">";
    full_form += "<tr class=\"cht-row-head\">";
    full_form += "<th class=\"cht-td-borders\">Day</th>";
    full_form += "<th colspan=\"2\" class=\"cht-td-borders\">Time Block 1</th>";
    full_form += "<th colspan=\"2\" class=\"cht-td-borders\">Time Block 2</th>";
    full_form += "<th colspan=\"2\" class=\"cht-td-borders\">Time Block 3</th>";
    full_form += "<th class=\"cht-td-borders\"><span class=\"min_fmt_txt\">HH:MM</span></th>";
    full_form += "</tr>";
    full_form += "<tr class=\"cht-row-subhead\">";
    full_form += "<th class=\"cht-td-borders\">&nbsp;</th>";
    full_form += "<th class=\"cht-td-borders\">In</th>";
    full_form += "<th class=\"cht-td-borders\">Out</th>";
    full_form += "<th class=\"cht-td-borders\">In</th>";
    full_form += "<th class=\"cht-td-borders\">Out</th>";
    full_form += "<th class=\"cht-td-borders\">In</th>";
    full_form += "<th class=\"cht-td-borders\">Out</th>";
    full_form += "<th class=\"cht-td-borders\">&nbsp;</th>";
    full_form += "</tr>";
    var full_days_ar = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var days_ar = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    var tabidx = 7;
    var dotw_num = 0;
    var odd_eve = "even";
    for (i = 1; i < 18; i++) {
        dotw_num += 1;
        if (dotw_num > 6) {
            dotw_num = 0
        }
        if (i % 2 == 0) {
            odd_eve = "odd"
        } else {
            odd_eve = "even"
        }
        full_form += "<tr class='cht-row-" + odd_eve + "'>";
        full_form += "<td class='cht-td-borders ctr' style='width: 16%;'>";
        full_form += "<input type='text' id='dt_t_" + i + "_day' name='dt_t_" + i + "_day' maxlength='25' value='" + full_days_ar[dotw_num] + "' data-role='none' style='width: 90%;' />";
        full_form += "</td>";
        full_form += "<td class='cht-td-borders ctr' style='width: 12%;'>";
        full_form += "<input type='text' id='dt_t_" + i + "_in_1' name='dt_t_" + i + "_in_1' style='width: 90%;' maxlength='5' tabindex='" + tabidx + "' data-role='none' onkeyup='calc_time_desktop(\"" + i + "_in_1\")' onchange='calc_time_desktop(\"" + i + "_in_1\")' />";
        full_form += "</td>";
        tabidx += 1;
        full_form += "<td class='cht-td-borders ctr' style='width: 12%;'>";
        full_form += "<input type='text' id='dt_t_" + i + "_out_1' name='dt_t_" + i + "_out_1' style='width: 90%;' maxlength='5' tabindex='" + tabidx + "' data-role='none' onkeyup='calc_time_desktop(\"" + i + "_out_1\")' onchange='calc_time_desktop(\"" + i + "_out_1\")' />";
        full_form += "</td>";
        tabidx += 1;
        full_form += "<td class='cht-td-borders ctr' style='width: 12%;'>";
        full_form += "<input type='text' id='dt_t_" + i + "_in_2' name='dt_t_" + i + "_in_2' style='width: 90%;' maxlength='5' tabindex='" + tabidx + "' data-role='none' onkeyup='calc_time_desktop(\"" + i + "_in_2\")' onchange='calc_time_desktop(\"" + i + "_in_2\")' />";
        full_form += "</td>";
        tabidx += 1;
        full_form += "<td class='cht-td-borders ctr' style='width: 12%;'>";
        full_form += "<input type='text' id='dt_t_" + i + "_out_2' name='dt_t_" + i + "_out_2'  style='width: 90%;' maxlength='5' tabindex='" + tabidx + "' data-role='none' onkeyup='calc_time_desktop(\"" + i + "_out_2\")' onchange='calc_time_desktop(\"" + i + "_out_2\")' />";
        full_form += "</td>";
        tabidx += 1;
        full_form += "<td class='cht-td-borders ctr' style='width: 12%;'>";
        full_form += "<input type='text' id='dt_t_" + i + "_in_3' name='dt_t_" + i + "_in_3' style='width: 90%;' maxlength='5' tabindex='" + tabidx + "' data-role='none' onkeyup='calc_time_desktop(\"" + i + "_in_3\")' onchange='calc_time_desktop(\"" + i + "_in_3\")' />";
        full_form += "</td>";
        tabidx += 1;
        full_form += "<td class='cht-td-borders ctr' style='width: 12%;'>";
        full_form += "<input type='text' id='dt_t_" + i + "_out_3' name='dt_t_" + i + "_out_3'  style='width: 90%;' maxlength='5' tabindex='" + tabidx + "' data-role='none' onkeyup='calc_time_desktop(\"" + i + "_out_3\")' onchange='calc_time_desktop(\"" + i + "_out_3\")' />";
        full_form += "</td>";
        tabidx += 1;
        full_form += "<td class='cht-td-borders rgt' id='dt_t_" + i + "_hrs_txt' style='width: 12%;'>";
        full_form += "<input type='hidden' id='dt_t_" + i + "_hrs' name='dt_t_" + i + "_hrs' />";
        full_form += "</td>";
        full_form += "</tr>"
    }
    full_form += "</table>";
    full_form += "</td>";
    full_form += "</tr>";
    $("#ready-desktop-form").html(full_form);
    var mob_form = "<tr class=\"clc-row-subhead\">";
    mob_form += "<td class=\"clc-row-td-head ctr\">";
    mob_form += "<div data-role=\"controlgroup\" data-type=\"horizontal\" data-mini=\"true\" class=\"ui-controlgroup ui-controlgroup-horizontal ui-corner-all ui-mini\">";
    mob_form += "<div class=\"ui-controlgroup-controls\">";
    mob_form += "<button type=\"button\" data-focu=\"expand-btn\" class=\"ui-btn ui-btn-c ui-icon-plus ui-btn-icon-right ui-corner-all ui-first-child\" onClick=\"expand_all(this.form)\">Expand all</button>";
    mob_form += "<button type=\"button\" data-focu=\"collapse-btn\" class=\"ui-btn ui-btn-c ui-icon-minus ui-btn-icon-right ui-corner-all ui-last-child\" onClick=\"collapse_all(this.form)\">Collapse all</button>";
    mob_form += "</div><!-- ui-controlgroup-controls -->";
    mob_form += "</div><!-- controlgroup -->";
    mob_form += "</td>";
    mob_form += "</tr>";
    tabidx = 7;
    dotw_num = 0;
    odd_eve = "even";
    fld_td_width = "70px";
    for (i = 1; i < 18; i++) {
        dotw_num += 1;
        if (dotw_num > 6) {
            dotw_num = 0
        }
        if (i % 2 === 0) {
            odd_eve = "even"
        } else {
            odd_eve = "odd"
        }
        mob_form += "<tr class=\"clc-row-" + odd_eve + "\">";
        mob_form += "<td class=\"clc-td\">";
        mob_form += "<div class=\"clc-ttip-div\">";
        mob_form += "<button type=\"button\" id=\"day-btn-" + i + "\" class=\"ui-btn ui-icon-plus ui-btn-icon-notext ui-btn-c ui-corner-all ui-btn-inline\" onClick=\"sh_day(" + i + ")\" tabindex=\"-1\">Show/Hide</button>";
        mob_form += "</div>";
        mob_form += "<div class=\"clc-desc-div\">";
        mob_form += "<span id=\"t_" + i + "_day_txt\">" + full_days_ar[dotw_num] + "</span>";
        mob_form += "<input type=\"hidden\" id=\"t_" + i + "_day\" name=\"t_" + i + "_day\" value=\"" + days_ar[dotw_num] + "\" />";
        mob_form += "</div>";
        mob_form += "<div class=\"clc-fld-div clcOutTxt\">";
        mob_form += "<output name=\"t_" + i + "_hrs_txt\" id=\"t_" + i + "_hrs_txt\">";
        mob_form += "0:00";
        mob_form += "</output>";
        mob_form += "<input type=\"hidden\" id=\"t_" + i + "_hrs\" name=\"t_" + i + "_hrs\" value=\"0:00\" />";
        mob_form += "<input type=\"hidden\" id=\"t_" + i + "_dotw\" name=\"t_" + i + "_dotw\" />";
        mob_form += "</div>";
        mob_form += "</td>";
        mob_form += "</tr>";
        mob_form += "<tr class=\"clc-row-" + odd_eve + "\">";
        mob_form += "<td class=\"clc-td\">";
        mob_form += "<div id=\"day-" + i + "\" style=\"display: none\">";
        mob_form += "<div class=\"clc-fld-div-flex-left\">";
        mob_form += "<table style=\"border-collapse: collapse; border: 1px dotted #ccc;\">";
        mob_form += "<tr>";
        mob_form += "<td style=\"padding: 0; width: " + fld_td_width + ";\">";
        mob_form += "<label for=\"t_" + i + "_in_1\" class=\"ui-hidden-accessible\">In 1</label>";
        mob_form += "<input type=\"number\" min=\"0\" inputmode=\"numeric\" pattern=\"[0-9]*\" id=\"t_" + i + "_in_1\" name=\"t_" + i + "_in_1\" data-mini=\"true\" data-theme=\"c\" data-inline=\"true\" placeholder=\"In 1\" onkeyup=\"calc_time()\" onChange=\"calc_time()\" data-precalc-fld=\"true\" />";
        mob_form += "<input type=\"hidden\" id=\"t_" + i + "_in_1_txt\" name=\"t_" + i + "_in_1_txt\" />";
        mob_form += "</td>";
        mob_form += "<td class=\"fld-keypad-td\" style=\"padding: 0 4px;\">";
        mob_form += "<button type=\"button\" id=\"btn_t_" + i + "_in_1\" class=\"ui-btn ui-icon-grid ui-btn-icon-notext ui-corner-all ui-btn-c\" onClick=\"open_timepad('t_" + i + "_in_1')\" tabindex=\"-1\">No text</button>";
        mob_form += "</td>";
        mob_form += "<td class=\"ctr\" style=\"padding: 0 4px;\">";
        mob_form += "<td style=\"padding: 0; width: " + fld_td_width + ";\">";
        mob_form += "<label for=\"t_" + i + "_out_1\" class=\"ui-hidden-accessible\">Out 1</label>";
        mob_form += "<input type=\"number\" min=\"0\" inputmode=\"numeric\" pattern=\"[0-9]*\" id=\"t_" + i + "_out_1\" name=\"t_" + i + "_out_1\" data-mini=\"true\" data-theme=\"c\" data-inline=\"true\" placeholder=\"Out 1\" onkeyup=\"calc_time()\" onChange=\"calc_time()\" data-precalc-fld=\"true\" />";
        mob_form += "<input type=\"hidden\" id=\"t_" + i + "_out_1_txt\" name=\"t_" + i + "_out_1_txt\" />";
        mob_form += "</td>";
        mob_form += "<td class=\"fld-keypad-td\" style=\"padding: 0 4px;\">";
        mob_form += "<button type=\"button\" id=\"btn_t_" + i + "_out_1\" class=\"ui-btn ui-icon-grid ui-btn-icon-notext ui-corner-all ui-btn-c\" onClick=\"open_timepad('t_" + i + "_out_1')\" tabindex=\"-1\">No text</button>";
        mob_form += "</td>";
        mob_form += "</tr>";
        mob_form += "</table>";
        mob_form += "</div>";
        mob_form += "<div class=\"clc-fld-div-flex-left\">";
        mob_form += "<table style=\"border-collapse: collapse; border: 1px dotted #ccc\">";
        mob_form += "<tr>";
        mob_form += "<td style=\"padding: 0; width: " + fld_td_width + ";\">";
        mob_form += "<label for=\"t_" + i + "_in_2\" class=\"ui-hidden-accessible\">In 2</label>";
        mob_form += "<input type=\"number\" min=\"0\" inputmode=\"numeric\" pattern=\"[0-9]*\" id=\"t_" + i + "_in_2\" name=\"t_" + i + "_in_2\" data-mini=\"true\" data-theme=\"c\" data-inline=\"true\" placeholder=\"In 2\" onkeyup=\"calc_time()\" onChange=\"calc_time()\" data-precalc-fld=\"true\" />";
        mob_form += "<input type=\"hidden\" id=\"t_" + i + "_in_2_txt\" name=\"t_" + i + "_in_2_txt\" />";
        mob_form += "</td>";
        mob_form += "<td class=\"fld-keypad-td\" style=\"padding: 0 4px;\">";
        mob_form += "<button type=\"button\" id=\"btn_t_" + i + "_in_2\" class=\"ui-btn ui-icon-grid ui-btn-icon-notext ui-corner-all ui-btn-c\" onClick=\"open_timepad('t_" + i + "_in_2')\" tabindex=\"-1\">No text</button>";
        mob_form += "</td>";
        mob_form += "<td class=\"ctr\" style=\"padding: 0 4px;\">";
        mob_form += "<td  style=\"padding: 0; width: " + fld_td_width + ";\">";
        mob_form += "<label for=\"t_" + i + "_out_2\" class=\"ui-hidden-accessible\">Out 2</label>";
        mob_form += "<input type=\"number\" min=\"0\" inputmode=\"numeric\" pattern=\"[0-9]*\" id=\"t_" + i + "_out_2\" name=\"t_" + i + "_out_2\" data-mini=\"true\" data-theme=\"c\" data-inline=\"true\" placeholder=\"Out 2\" onkeyup=\"calc_time()\" onChange=\"calc_time()\" data-precalc-fld=\"true\" />";
        mob_form += "<input type=\"hidden\" id=\"t_" + i + "_out_2_txt\" name=\"t_" + i + "_out_2_txt\" />";
        mob_form += "</td>";
        mob_form += "<td class=\"fld-keypad-td\" style=\"padding: 0 4px;\">";
        mob_form += "<button type=\"button\" id=\"btn_t_" + i + "_out_2\" class=\"ui-btn ui-icon-grid ui-btn-icon-notext ui-corner-all ui-btn-c\" onClick=\"open_timepad('t_" + i + "_out_2')\" tabindex=\"-1\">No text</button>";
        mob_form += "</td>";
        mob_form += "</tr>";
        mob_form += "</table>";
        mob_form += "</div>";
        mob_form += "<div class=\"clc-fld-div-flex-left\">";
        mob_form += "<table style=\"border-collapse: collapse; border: 1px dotted #ccc\">";
        mob_form += "<tr>";
        mob_form += "<td style=\"padding: 0; width: " + fld_td_width + ";\">";
        mob_form += "<label for=\"t_" + i + "_in_3\" class=\"ui-hidden-accessible\">In 3</label>";
        mob_form += "<input type=\"number\" min=\"0\" inputmode=\"numeric\" pattern=\"[0-9]*\" id=\"t_" + i + "_in_3\" name=\"t_" + i + "_in_3\" data-mini=\"true\" data-theme=\"c\" data-inline=\"true\" placeholder=\"In 3\" onkeyup=\"calc_time()\" onChange=\"calc_time()\" data-precalc-fld=\"true\" />";
        mob_form += "<input type=\"hidden\" id=\"t_" + i + "_in_3_txt\" name=\"t_" + i + "_in_3_txt\" />";
        mob_form += "</td>";
        mob_form += "<td class=\"fld-keypad-td\" style=\"padding: 0 4px;\">";
        mob_form += "<button type=\"button\" id=\"btn_t_" + i + "_in_3\" class=\"ui-btn ui-icon-grid ui-btn-icon-notext ui-corner-all ui-btn-c\" onClick=\"open_timepad('t_" + i + "_in_3')\" tabindex=\"-1\">No text</button>";
        mob_form += "</td>";
        mob_form += "<td class=\"ctr\" style=\"padding: 0 4px;\">";
        mob_form += "<td  style=\"padding: 0; width: " + fld_td_width + ";\">";
        mob_form += "<label for=\"t_" + i + "_out_3\" class=\"ui-hidden-accessible\">Out 3</label>";
        mob_form += "<input type=\"number\" min=\"0\" inputmode=\"numeric\" pattern=\"[0-9]*\" id=\"t_" + i + "_out_3\" name=\"t_" + i + "_out_3\" data-mini=\"true\" data-theme=\"c\" data-inline=\"true\" placeholder=\"Out 3\" onkeyup=\"calc_time()\" onChange=\"calc_time()\" data-precalc-fld=\"true\" />";
        mob_form += "<input type=\"hidden\" id=\"t_" + i + "_out_3_txt\" name=\"t_" + i + "_out_3_txt\" />";
        mob_form += "</td>";
        mob_form += "<td class=\"fld-keypad-td\" style=\"padding: 0 4px;\">";
        mob_form += "<button type=\"button\" id=\"btn_t_" + i + "_out_3\" class=\"ui-btn ui-icon-grid ui-btn-icon-notext ui-corner-all ui-btn-c\" onClick=\"open_timepad('t_" + i + "_out_3')\" tabindex=\"-1\">No text</button>";
        mob_form += "</td>";
        mob_form += "</tr>";
        mob_form += "</table>";
        mob_form += "</div>";
        mob_form += "</div>";
        mob_form += "</td>";
        mob_form += "</tr>"
    }
    $("#ready-mobile-form").html(mob_form);
    show_mobile_or_desktop();
    $(window).resize(function() {
        show_mobile_or_desktop()
    });
    $(window).on("orientationchange", function(event) {
        show_mobile_or_desktop()
    })
}
if (db.getItem("semi-monthly-timesheet-calculator-employees")) {
    var employees = db.getItem("semi-monthly-timesheet-calculator-employees");
    var employees_ar = JSON.parse(employees);
    if (db.getItem("semi-monthly-timesheet-calculator-prefs")) {
        var prefs = db.getItem("semi-monthly-timesheet-calculator-prefs");
        var prefs_ar = JSON.parse(prefs)
    } else {
        var prefs_ar = [0, "1.5", 1, 8, 0, 10, 8, 14, 10, 0, "0"]
    }
    var calc_75_data_ar = [75, "semi-monthly-timesheet-calculator.html", "3-Column Semi-Monthly Time Sheet Calculator", ""];
    for (var i = 0; i < employees_ar.length; i++) {
        var emp_ar = [employees_ar[i][3], ""];
        var form_ar = [];
        form_ar.push(["emp_name", "text", employees_ar[i][3], false]);
        form_ar.push(["reg_rate", "number", employees_ar[i][1], false]);
        if (prefs_ar[0] === 0) {
            form_ar.push(["ot-type-0", "radio", true, false])
        } else {
            form_ar.push(["ot-type-0", "radio", false, false])
        }
        if (prefs_ar[0] === 1) {
            form_ar.push(["ot-type-1", "radio", true, false])
        } else {
            form_ar.push(["ot-type-1", "radio", false, false])
        }
        if (prefs_ar[0] === 2) {
            form_ar.push(["ot-type-2", "radio", true, false])
        } else {
            form_ar.push(["ot-type-2", "radio", false, false])
        }
        if (prefs_ar[0] === 3) {
            form_ar.push(["ot-type-3", "radio", true, false])
        } else {
            form_ar.push(["ot-type-3", "radio", false, false])
        }
        if (prefs_ar[0] === 4) {
            form_ar.push(["ot-type-4", "radio", true, false])
        } else {
            form_ar.push(["ot-type-4", "radio", false, false])
        }
        if (prefs_ar[0] === 5) {
            form_ar.push(["ot-type-5", "radio", true, false])
        } else {
            form_ar.push(["ot-type-5", "radio", false, false])
        }
        form_ar.push(["ot_fact", "number", prefs_ar[1], false]);
        form_ar.push(["ot_rate", "number", employees_ar[i][2], false]);
        form_ar.push(["day", "select-one", prefs_ar[2], false]);
        form_ar.push(["s_mon", "select-one", prefs_ar[3], false]);
        form_ar.push(["s_day", "select-one", prefs_ar[4], false]);
        form_ar.push(["s_yr", "select-one", prefs_ar[5], false]);
        form_ar.push(["e_mon", "select-one", prefs_ar[6], false]);
        form_ar.push(["e_day", "select-one", prefs_ar[7], false]);
        form_ar.push(["e_yr", "select-one", prefs_ar[8], false]);
        form_ar.push(["min_fmt", "select-one", prefs_ar[9], false]);
        var emp_days_ar = employees_ar[i][4].split("||");
        var line_cnt = 0;
        for (var t = 0; t < emp_days_ar.length; t++) {
            var emp_day_ar = emp_days_ar[t].split("##");
            line_cnt += 1;
            form_ar.push(["t_" + line_cnt + "_in_1", "number", emp_day_ar[0], false]);
            form_ar.push(["t_" + line_cnt + "_out_1", "number", emp_day_ar[1], false]);
            form_ar.push(["t_" + line_cnt + "_in_2", "number", emp_day_ar[2], false]);
            form_ar.push(["t_" + line_cnt + "_out_2", "number", emp_day_ar[3], false])
        }
        emp_ar.push(form_ar);
        emp_ar.push([["per_end", "text", prefs_ar[10], false]]);
        calc_75_data_ar.push(emp_ar)
    }
    db.setItem("calc_75_data", JSON.stringify(calc_75_data_ar));
    db.setItem("old-semi-monthly-timesheet-calculator-employees", JSON.stringify(employees_ar));
    db.setItem("old-semi-monthly-timesheet-calculator-prefs", JSON.stringify(prefs_ar));
    db.removeItem("semi-monthly-timesheet-calculator-employees");
    db.removeItem("semi-monthly-timesheet-calculator-prefs")
} else {
    $(".calc-alert-message").css("display", "none")
}
