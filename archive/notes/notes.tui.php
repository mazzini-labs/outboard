<?php include './lib/ob.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="css/util.css">
<link rel="stylesheet" type="text/css" href="css/maintest.css?=v1.2">
<link rel="stylesheet" href="https://uicdn.toast.com/tui.pagination/latest/tui-pagination.css" />
<link rel="stylesheet" href="https://uicdn.toast.com/grid/latest/tui-grid.css" />
<!-- Bootstrap core CSS -->
<link href="./WSB/stylesheet/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="./WSB/stylesheet/offcanvas.css" rel="stylesheet">


<script src="./vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="https://uicdn.toast.com/tui.pagination/latest/tui-pagination.js"></script>
<script src="https://uicdn.toast.com/grid/latest/tui-grid.js"></script>
<script src="./assets/js/inlineEdit.js"></script>
<?php include './WSB/includes.php'; ?>
<title>WSB</title>



</head>
<body>
<?php include 'header_extensions.php'; ?>
<div id="grid"></div>
<!-- <main role='main' class='col-lg-12 pt-5 '>

</main> -->
</body>
</html>
<script>
// import Grid from 'tui-grid';
const dataSource = {
    api: {
        readData: { url: 'readData.php', method: 'GET'}
        // updateData:
        // {
        //     url : "./ajax-end-point/save-edit.php",
        //     type : "POST",
        //     data : 'column=' + column + '&editval=' + editableObj.innerHTML
		// 		+ '&id=' + id,
        // }
    },
//    initialRequest: false, // set to true by default
  
        pageOptions: {
            perPage: 10
        },
};
const grid = new tui.Grid({
      el: document.getElementById('grid'),
      scrollX: false,
      scrollY: false,
      pageOptions: {
            perPage: 10
        },
      columns: [
        {
            header: "Row",
            name: 'rowKey'
        },
        {
            header: 'Well Common Name [Editable]',
            name: 'well_common_name',
            editor: 'text'
        },
        {
            header: 'State',
            name: 'state'
        },
        {
            header: 'County',
            name: 'county'
        },
        {
            header: 'Block [Editable]',
            name: 'block',
            // editor: 'text'
        },
        {
            header: 'Company',
            name: 'company'
        },
        {
            header: 'Status [Editable]',
            name: 'status',
            // editor: 'text'
        },
        {
            header: 'Type',
            name: 'type'
        },
        {
            header: 'Last Produced [Editable]',
            name: 'last_produced',
            // editor: 'text'
        },
        {
            header: 'Pumper [Editable]',
            name: 'pumper',
            // editor: 'text'
        },
        {
            header: 'Notes [Editable]',
            name: 'notes',
            // editor: 'text'
        },
        {
            header: 'S/I Notes',
            name: 'si_notes'
        }
      ],
    //   data: {
    //             api: {
    //                 readData: { url: 'readData.php', method: 'GET', contentType: 'application/json',}
    //             },
    //             // hideLoadingBar: true
    //   },

    //   data: dataSource,  
    data: []
    });
    grid.resetData(dataSource);
// const data = [
//     data: {
//                 api: {
//                     readData: { url: 'readData.php', method: 'GET', contentType: 'application/json',}
//                 },
//                 // hideLoadingBar: true
//       },
// ]
// after loading the DOM
// axios.get('./get').then(res => {
//   grid.reset(res.data); // set your response data from the server
// });
    // grid.readData(1);
    
</script>