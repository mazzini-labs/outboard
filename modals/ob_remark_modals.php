<!-- Modal -->
<div class="modal fade" id="clearRemarkModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="user" class="modal-body" val="">
        Remark cleared.
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="rtw" type="button" onclick="end_lunch_rw();" value="usr" class="btn btn-primary">Check in remotely</button>
        <button id="itw" type="button" onclick="end_lunch_in();" value="usr" class="btn btn-success">Check in office</button>
      </div> -->
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="setRemarkModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="user" class="modal-body" val="">
        <!-- Previous Remark:
        <p id=olddRemark> -->
        Please set your remark below:
        <!-- <input id="oldRemark"> -->
        <!-- <div class="input-group input-group-sm mb-1"> -->
        <form id="remark_form">
            <input id="remark" name="oldRemark" type="text" class="form-control" placeholder="Insert remarks...">
        </form>
            <input type="hidden" value="curRemark">
        <!-- </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="remarkUser" type="button" onclick="set_remark();" value="usr" class="btn btn-primary">Submit</button>
        <!-- <button id="itw" type="button" onclick="end_lunch_in();" value="usr" class="btn btn-success">Check in office</button> -->
      </div>
    </div>
  </div>
</div>