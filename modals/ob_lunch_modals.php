<!-- Modal -->
<div class="modal fade" id="lunchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ending Lunch</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="user" class="modal-body" val="">
        Would you like to check back in remotely or physically?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="rtw" type="button" onclick="end_lunch_rw();" value="usr" class="btn btn-primary">Check in remotely</button>
        <button id="itw" type="button" onclick="end_lunch_in();" value="usr" class="btn btn-success">Check in office</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="takeLunchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Taking Lunch</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="user" class="modal-body" val="">
        <div class="col">
          What time will you be returning?
        </div>
        
        <div class="col">
            <div class="input-group input-group-sm">
                <input name="lunchtime" id="lunchtime" type="hidden" autocomplete="off" value="00:00" class="form-control without_ampm" >
                <!-- <input name="otl" id="otl" type="hidden" value="usr"> -->
            </div>
                
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="otl" type="button" onclick="otl();" value="usr" class="btn btn-primary">Submit</button>
        <!-- <button id="itw" type="button" onclick="otl();" value="usr" class="btn btn-success">Check in office</button> -->

      </div>
    </div>
  </div>
</div>
<script>
var today = moment().format("hh:mm");
    console.log(today);
    $('#lunchtime').val(today);
    $('#end').val(today);
    // $('#dee').datepicker({defaultViewDate: today, format: "yyyy-mm-dd"});
    // $('#dee').on('changeDate', function() {
    //     $('#start').val(
    //         $('#dee').datepicker('getFormattedDate')
    //     );
    // });
    // log(today);
    // $('#def').datepicker({defaultViewDate: today, format: "yyyy-mm-dd"});
    // $('#def').on('changeDate', function() {
    //     $('#end').val(
    //         $('#def').datepicker('getFormattedDate')
    //     );
    // });
  
</script>
<script type="text/javascript">
      $(function () {
          $('#lunchtime').datetimepicker({
              inline: true,
              format: 'hh:mm'
          });
          // $('#lunchtime').on('change', function() {
          //   $('#otl').val(
          //     $('#lunchtime').data("DateTimePicker").viewDate();
          //   )
          // });
      });
    
   </script>