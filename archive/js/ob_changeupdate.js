function change_remark(remark,userid) {
    var newremark = prompt("Enter your remarks below:",remark);
    if (newremark != null) {
      self.location="outboard.php?remarks="
		    + escape(newremark) + "&userid=" +userid + "#<?php echo $userid ?>";
    }
  }
  function out_to_lunch(remark,userid) {
    var newremark = prompt("Approximately what time will you return?");
    var rto = "OTL; will return around ";
    if (newremark != null) {
      self.location="outboard.php?remarks=" + escape(rto) + ""
		    + escape(newremark) + "&out=1&userid=" +userid + "#<?php echo $userid ?>";
    }
  }
  function clear_remarks(remark,userid) {
    alert("Remark cleared.");
    self.location="outboard.php?remarks=" + "&userid=" +userid + "#<?php echo $userid ?>";
  }
  function end_lunch_rw() {
      var userid = $('#rtw').attr("value");  
      $('#lunchModal').modal('hide');
      self.location="outboard.php?remarks=" + "&rw=1&userid=" +userid + "#<?php echo $userid ?>";
  }
  function end_lunch_in() {
      var userid = $('#itw').attr("value");  
      $('#lunchModal').modal('hide');
      self.location="outboard.php?remarks=" + "&in=1&userid=" +userid + "#<?php echo $userid ?>";
  }
  $(document).on('click', '.returnfromlunch', function(){  
    var userid = $(this).attr("id");  
    $('#lunchModal').modal('show');
    $('#rtw').val(userid);  
    $('#itw').val(userid);  
  });