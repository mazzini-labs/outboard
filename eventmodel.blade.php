<body>
####################################DONT USE WITH YOUTUBE VIDEO#####################################################
<div class="modal fade" id="ShowCalendar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Event Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class-"calendar">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
                    {!! $calendar->calendar() !!}
                    {!! $calendar->script() !!}
                </div>
            </div>
            <form action="update.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" class="form-control" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="text" name="stime" class="form-control" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="text" name="etime" class="form-control" placeholder="Enter Title">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" name="insertdata" class="btn btn-primary">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
####################################POTENTIAL AJAX USAGE ^^^^^^#####################################################
<div class="modal fade" id="ShowCalendar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Event Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="calendar">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
                    {!! $calendar->calendar() !!}
                    {!! $calendar->script() !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="insertdata" class="btn btn-primary">Save Data</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="AddEvent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Event Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/events" method="POST">
                {{ csrf_field() }}
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="text" name="date" class="form-control" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label for="">Start Time</label>
                        <input type="text" name="stime" class="form-control" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label for="">End Time</label>
                        <input type="text" name="etime" class="form-control" placeholder="Enter Title">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="insertdata" class="btn btn-primary">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container">
    <div class="card">
        <div class="card-header">
            Event Calendar with BootStrap modal
        </div>
        <div class="card-body">
            <h5 class="card-title text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ShowCalendar">
                    Show Calendar
                </button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#AddEvent">
                    Add Event
                </button>
            </h5>


        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js">
