{/* <script language = "javascript" type = "text/javascript"> */}

$("#startdate").datepicker({"daysOfWeekDisabled": '06'});
$("#enddate").datepicker({"daysOfWeekDisabled": [0,6]});
$('#startdate').datepicker('update', '');
// </script>