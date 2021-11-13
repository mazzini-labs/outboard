<script src="assets/js/datepicker-full.js"></script>
<SCRIPT>
    // var today = new Date();
    var today = moment().format("YYYY-MM-DD");
    console.log(today);
            $('#dee').datepicker({defaultViewDate: today, format: "yyyy-mm-dd"});
            $('#dee').on('changeDate', function() {
                $('#de').val(
                    $('#dee').datepicker('getFormattedDate')
                );
            });
            // $("#de.dsr").datepicker({
            //     format: "yyyy-mm-dd",
            //     autoclose: true
            // });
            $('#dee.dsr').datepicker({defaultViewDate: today, format: "yyyy-mm-dd"});
            $('#dee.dsr').on('changeDate', function() {
                $('#de.dsr').val(
                    $('#dee.dsr').datepicker('getFormattedDate')
                );
            });
            // $("#de").datepicker({
            //     format: "yyyy-mm-dd"
            // });
            // $("#de.dsr").datepicker({
            //     format: "yyyy-mm-dd"
            // });
            $("#ad").datepicker({
                autoclose: true,
                format: "yyyy-mm-dd"
            });
            $('#deel').datepicker({defaultViewDate: today, format: "yyyy-mm-dd"});
            $('#deel').on('changeDate', function() {
                $('#del').val(
                    $('#deel').datepicker('getFormattedDate')
                );
            });
            // $("#de-v").datepicker({
            //     format: "yyyy-mm-dd"
            // });
            // $("#de-f").datepicker({
            //     format: "yyyy-mm-dd"
            // });
            // const picker1 = new SimplePicker('startdate');
            // const picker2 = new SimplePicker('enddate');
            /* 
            const elem0 = document.querySelector('input[name="de-e"]');
            const datepickerE = new Datepicker(elem0, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            });

            const elem1 = document.querySelector('input[name="de-a"]');
            const datepickerA = new Datepicker(elem1, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            });

            const elem2 = document.querySelector('input[name="ad"]');
            const datepickerAD = new Datepicker(elem2, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            });

            const elem3 = document.querySelector('input[name="de-v"]');
            const datepickerV = new Datepicker(elem3, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            });

            const elem4 = document.querySelector('input[name="de-f"]');
            const datepickerF = new Datepicker(elem4, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            }); */
            // const elem2 = document.getElementById('inline');
            // const datepicker2 = new Datepicker(elem2, {
            //   buttonClass: 'btn',
            // });
            // const elem3 = document.getElementById('range');
            // const datepicker3 = new DateRangePicker(elem3, {
            //   buttonClass: 'btn',
            // });
    </SCRIPT>