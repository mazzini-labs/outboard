<?php include 'lib/ob.php'; ?>
<html>
<head>
  <title>OutBoard: <?php echo $ob->getConfig('board_title') ?></title> 
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.css" integrity="sha512-IBfPhioJ2AoH2nST7c0jwU0A3RJ7hwIb3t+nYR4EJ5n9P6Nb/wclzcQNbTd4QFX1lgRAtTT+axLyK7VUCDtjWA==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.css" integrity="sha512-CN6oL2X5VC0thwTbojxZ02e8CVs7rii0yhTLsgsdId8JDlcLENaqISvkSLFUuZk6NcPeB+FbaTfZorhbSqcRYg==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/timegrid/main.min.css" integrity="sha512-/Jnt6fX98n8zZyuCt4K81+1eQJhWQn/vyMph1UvHywyziYDbu9DFGcJoW8U73m/rkaQBIEAJeoEj+2Rrx4tFyw==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/list/main.min.css" integrity="sha512-tNMyUN1gVBvqtboKfcOFOiiDrDR2yNVwRDOD/O+N37mIvlJY5d5bZ0JeUydjqD8evWgE2cF48Gm4KvQzglN0fg==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/bootstrap/main.min.css" integrity="sha512-mK6wVf3xsmNcJnp0ZI+YORb6jQBsAIIwkOfMV47DHIiwvkSgR0t7GNCVBiotLQWWR8AND/LxWHAatnja1fU7kQ==" crossorigin="anonymous" /> -->
  <!-- <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/> -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
	<link rel="stylesheet" type="text/css" href="css/tabs.css?v1.0.0.4">
    <link rel="stylesheet" type="text/css" href="css/search.css">
    <link rel="stylesheet" type="text/css" href="css/fixed-action-button.css">
<!--===============================================================================================-->
		<!-- Bootstrap core CSS -->
    <link href="WSB/stylesheet/bootstrap.min.css?v1" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> -->
    <!-- Custom styles for this template -->
    <link href="WSB/stylesheet/offcanvas.css?v1" rel="stylesheet">
	<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="css/glyphicons.css?v1.0.0.8">
<!-- <script type="text/javascript" src="datatables/datatables.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<!-- <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>

    <script type="text/javascript" src="datatables/datatables.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.min.css" integrity="sha256-uq9PNlMzB+1h01Ij9cx7zeE2OR2pLAfRw3uUUOOPKdA=" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.min.js" integrity="sha256-izRz5kNrZijklla/aBIkhdoxtbRpqQzHaaABtK0Tqe4=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
  
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js" integrity="sha512-8vfyGnaOX2EeMypNMptU+MwwK206Jk1I/tMQV4NkhOz+W8glENoMhGyU6n/6VgQUhQcJH8NqQgHhMtZjJJBv3A==" crossorigin="anonymous"></script>

<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"/>
  <script src="https://unpkg.com/feather-icons"></script>
  <style type="text/css">
  main > div { display: block!important;}
    #listob {
      float: left;
      width: 25%;
      margin: 0 20px 20px 0;
    }	 
    .table > thead {
                font-style: normal!important;
                font-stretch: condensed!important;
                font-size: 12px;
            }
            thead, tbody, a {
    /* font-style: normal!important; */
    /* font-stretch: condensed!important; */
    
}
.smol th,
.smol td,
.smol a,
.smol p {
  padding-top: 0.3rem;
  padding-bottom: 0.3rem;
  font-size: 14px;
  font-family: "Poppins-Regular";
}
table.dataTable tbody td {
  word-break: break-word;
  vertical-align: top;
}
.text-wrap{
    white-space:normal!important;
}
    .lg-icon {
      width: 1.625rem;
      height: 1.625rem;
      vertical-align: -webkit-baseline-middle;

    }
    .btn-group-lg>.btn,.btn-lg {
      padding: 1rem!important;
      font-size: 1.25rem;
      line-height: 1.5!important;
      border-radius: .3rem;
    }
    .fc-more-popover > .fc-widget-header > span.fc-title { color: black!important; }
    span.fc-title { color: white!important;  }
.user 
{
    background-color: #17a2b8;
}
.h-75 { height: 75%!important;}
.fc-daygrid-event { line-height:1!important; }
.shadow-lg 
{
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
}
.poppins 
{
  font-family: "Poppins-Regular";
  font-size: 14px;
  font-weight: 400;
}
  </style>
<script type="text/javascript" class="init">
  // $.noConflict();
  // Activate tooltip
  // $('[data-toggle="tooltip"]').tooltip();
  $(document).ready(function() {
    var oTable = $('#table').DataTable( {
      "ajax": "ajax/printers.ajax.php",
      //},
      "sDom": 't',
      //"sDom": 'd',
      "order": [],
      //"paging": false,
      
      deferRender: true,
      scrollY: "70vh",
      scroller: true,
      "searching": true,
      //
      "autoWidth": false,
      retrieve: true,
      "columns": [
          {
          // "data": null, render: function ( data, type, row ) 
          // {
          //     // Combine the Well and API into a single table field
          //     return '<a href="prod_data.php?api='+data.api+'">'+data.entity_common_name+' <br> '+data.api+'</a>';
          // }, 
          "data": "name",
          "defaultContent": ""
          },
          {
          "data": "location", // State
          "defaultContent": ""
          },
          {
            // "data": "in",
            "data": null, render: function (data,type,row)
            {
              return "<a class='btn-primary btn' href=\"https://print.vprsrv.org/"+data.ip_address+"/\" target=\"print\">"+data.name+"</a>";
            },
            "defaultContent": "",
          },
      ],
      //"columnDefs": 
      //[ 
      //  { className: "text-wrap", "targets":  4  },
      //]
    });
  });
  </script>
</head>
<body style="background-color: #0e5092;">
<!-- top of page header w/logo-->
<?php include 'header_extensions.php'; ?>
<div class="container-fluid" >
    <div class="row justify-content-center">
      <div class="col-4 m-3 p-3 shadow-lg card-body bg-light" >
        <table id="table" class="table table-striped table-hover table-borderless smol" >
        <thead><tr>
            <th>Name</th>
            <th>Location</th>
            <th>IP Address</th>
          </tr></thead>
        </table>
      </div>
    <div class="col-6 m-3 p-3 shadow-lg card-body bg-light" ><div id="calendar"></div>
    <iframe name="print" width="100%" height="100%" src="." sandbox="allow-same-origin allow-scripts allow-popups allow-forms" frameborder="0" scrolling="auto" allowfullscreen></iframe>
    <!-- <embed name="print" width="100%" height="100%" src="."></embed>   -->
  </div>
   
    </div>
</div>
 <!-- Fixed Action Button -->
 <script>
    // $('#table')
    
    // .dataTable();
      
tippy('.cs', { 
  content: "Change Status",
  theme: 'light',
  placement: 'left',
  arrow: false
})
tippy('.vs', { 
  content: "View Status",
  theme: 'light',
  placement: 'left',
  arrow: false })
  
</script>
  <!-- Icons -->
  
  <!-- <script>
    feather.replace()
</script>    -->
<!-- Fixed Action Button -->
</body>
</html>