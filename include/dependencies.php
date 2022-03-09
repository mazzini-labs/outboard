  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <link rel="icon" type="image/png" href="assets/images/icons/favicon.ico"/>
  <!-- Outboard CSS -->
  <link rel="stylesheet" type="text/css" href="../assets/css/util.css?v1.0.0.6">
	<link rel="stylesheet" type="text/css" href="../assets/css/tabs.css?v1.0.0.4">
  <!-- <link rel="stylesheet" type="text/css" href="../assets/css/search.css"> -->
  <link rel="stylesheet" type="text/css" href="../assets/css/fixed-action-button.css?v1.0.0.0">
  <!-- <link rel="stylesheet" type="text/css" href="../assets/css/wsb.style.css?v1.0.0.12"> -->
  <link rel="stylesheet" type="text/css" href="../assets/css/ob.scrollbar.css">
	<!-- Bootstrap core CSS -->
  <!-- <link href="/WSB/stylesheet/bootstrap.min.css?v1" rel="stylesheet"> -->
  <?php if(isset($_REQUEST["bs5"])) { ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <?php } else { ?>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <?php } ?>
  <?php if(isset($_REQUEST["testing"])) { ?>
  <!-- <link href="assets/css/bootstrap-modal-bs3patch.css" rel="stylesheet" /> -->
  <!-- <link href="assets/css/bootstrap-modal.css" rel="stylesheet" /> -->
  <?php } ?>
  <link rel="stylesheet" type="text/css" href="../assets/css/maintest.css?=v1.0.0.6.21">
  <link href="../assets/css/offcanvas.css?v1.0.0.0" rel="stylesheet">
  <!-- FontAwesome CSS -->
	<link href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="assets/css/glyphicons.css?v1.0.0.8">
  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <!-- DataTables -->
  <?php 
  $checkurl = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
  if($checkurl != 'outboard.php') { ?>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.25/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.4/sp-1.2.1/sl-1.3.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.4/sp-1.2.1/sl-1.3.1/datatables.min.js"></script>
  <?php } else { ?>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.0/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.0/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.0.1/datatables.min.js"></script>
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.4/sp-1.2.1/sl-1.3.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.4/sp-1.2.1/sl-1.3.1/datatables.min.js"></script> -->
  <?php } ?>
  <!-- FullCalendar -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.min.css" integrity="sha256-uq9PNlMzB+1h01Ij9cx7zeE2OR2pLAfRw3uUUOOPKdA=" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.min.js" integrity="sha256-izRz5kNrZijklla/aBIkhdoxtbRpqQzHaaABtK0Tqe4=" crossorigin="anonymous"></script>
  <!-- Popper.js -->
  <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/popper.js"></script>
  <!-- Tippy.js -->
  <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
  <!-- Bootstrap Core JS -->
  <?php if(isset($_POST["bs5"])) { ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
  <?php } else { ?>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <?php } ?>
  <?php if(isset($_REQUEST["testing"])) { ?>
  <!-- <script src="js/bootstrap-modalmanager.js"></script>
  <script src="js/bootstrap-modal.js"></script> -->
  <!-- <link rel="stylesheet" type="text/css" href="https://unpkg.com/pell/dist/pell.min.css"> -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" /> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/ui/trumbowyg.min.css" integrity="sha512-iw/TO6rC/bRmSOiXlanoUCVdNrnJBCOufp2s3vhTPyP1Z0CtTSBNbEd5wIo8VJanpONGJSyPOZ5ZRjZ/ojmc7g==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/colors/ui/trumbowyg.colors.min.css" integrity="sha512-8dXb2ITE13jLrqqGDVTU8kKl9vHZI9E4TpZGyfhevHeF+/cWWA17wVj+SKX3+QHqZISiGihaCOyK3nA152ShDg==" crossorigin="anonymous" />
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/highlight/ui/trumbowyg.highlight.min.css" integrity="sha512-ONcCwVNQALW50RuCcX4fu1p8K9eWr0Fs6UwmRX6iwr+Q8VySqjxCplim+FtNCbGkdkN14ZAZedXDE4GYEEeAng==" crossorigin="anonymous" /> -->

  <?php } ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/ui/trumbowyg.min.css" integrity="sha512-iw/TO6rC/bRmSOiXlanoUCVdNrnJBCOufp2s3vhTPyP1Z0CtTSBNbEd5wIo8VJanpONGJSyPOZ5ZRjZ/ojmc7g==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/colors/ui/trumbowyg.colors.min.css" integrity="sha512-8dXb2ITE13jLrqqGDVTU8kKl9vHZI9E4TpZGyfhevHeF+/cWWA17wVj+SKX3+QHqZISiGihaCOyK3nA152ShDg==" crossorigin="anonymous" />

  <!-- Bootstrap Datepicker JS-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
  <!-- BootBox JS -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js" integrity="sha512-8vfyGnaOX2EeMypNMptU+MwwK206Jk1I/tMQV4NkhOz+W8glENoMhGyU6n/6VgQUhQcJH8NqQgHhMtZjJJBv3A==" crossorigin="anonymous"></script> -->
  <!-- Bootstrap Select -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  <!-- Bootstrap Datepicker CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"/>
  <!-- Feather Icons JS -->
  <script src="https://unpkg.com/feather-icons"></script>
  <!-- Hide Empty Columns DataTables Custom Function -->
  <script src="/assets/js/dataTables.hideEmptyColumns.js"></script>
  <!-- FontAwsome Script -->
  <script src="https://kit.fontawesome.com/634c08e21e.js" crossorigin="anonymous"></script>
  <!-- Select Search  -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

  <!-- Leaflet Maps -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
	integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
	integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
  crossorigin=""></script>
  <!-- Bootstrap DateTimePicker  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.49/css/bootstrap-datetimepicker.css" integrity="sha512-DMmBV1BMgTLnPstv79yX2ejxAG2IHG4YBj2oMxYTLx5sN2W++PFn6edzEyBh6PYclC1JGfFDSnR34ctqBX/Niw==" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.49/js/bootstrap-datetimepicker.min.js" integrity="sha512-jPwanAeILSRxZLeyP1XYBOo67+how4C1Ij54LQSa8xIOP3hKyeWRe24C0scI4QrTeQywKd1meF4Pak/Glv34vA==" crossorigin="anonymous"></script>

  
  <!-- Microsoft Teams JavaScript API (via CDN) -->
  <script src="https://statics.teams.microsoft.com/sdk/v1.5.2/js/MicrosoftTeams.min.js" crossorigin="anonymous"></script>
  <script>
  window.onload = microsoftTeams.initialize();
  </script>
  <!-- Button Text Hide On Resize CSS -->
  <link rel="stylesheet" type="text/css" href="assets/css/buttonhidetext.css?v1">
  
<script src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/datetime-moment.js"></script>
<!--- TRYING TO USE THIS FOR MULTIPLE MODALS; DELETE IF I FIGURE IT OUT --->

<script src="/assets/js/alertify.js"></script>
<script src="https://unpkg.com/canvas-datagrid"></script>

<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
<script src="https://unpkg.com/pdfobject@2.2.6/pdfobject.min.js"></script>
<link
    rel="stylesheet"
    type="text/css"
    href="https://unpkg.com/file-upload-with-preview@4.1.0/dist/file-upload-with-preview.min.css"
/>
<script src="https://unpkg.com/file-upload-with-preview@4.1.0/dist/file-upload-with-preview.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notiflix@3.2.5/dist/notiflix-aio-3.2.5.min.js" integrity="sha256-LQj8h+SKqntnw8M/FP7QM+3dTqgHvB1JzZMVPD868Rg=" crossorigin="anonymous"></script>