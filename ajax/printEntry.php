<!doctype html>
<html lang="en">
<head>
    <?php include './../include/dependencies.php'; ?>
<script>
// $(document).on('click', '.view_data', function(){  
    $(document).ready(function() {
        var id = $('.print-me').attr("id");  
        var p = 1;
        if(id != '')  
        {  
                $.ajax({  
                    url:"select.php",  
                    method:"POST",  
                    data:{id:id, p:p},  
                    success:function(data){  
                        $('#ddr_detail').html(data);  
                        $('#dataModal').modal('show'); 
                        $('#dataModal').on('shown.bs.modal', function (event) {
                        window.print();
                        setTimeout(window.close, 0); 
                        })
                    }  
                });  
        }            
    });  
</script>
<style>
  .modal-dialog {
    position: fixed;
    top: -3vh;
    left: 0;
    bottom: 0;
    height: 100%;
    width: 100%;
    max-width: 1000px;
    z-index: 9999;
    overflow: auto;
    transition: transform 0.3s;
    will-change: transform;
    background-color: #fff;
    display: flex;
    flex-direction: column;
    -webkit-transform: translateX(103%);
    transform: translateX(103%); /* extra 3% because of box-shadow */
    -webkit-overflow-scrolling: touch; /* enables momentum scrolling in iOS overflow elements */
    /* box-shadow: 0 2px 6px #777; */
  }
  .modal-content {
    position: relative;
    overflow-x: hidden;
    overflow-y: auto;
    height: 100%;
    flex-grow: 1;
    padding: 1.5rem;
    border-color: none;
    border-radius: none;
    border: none;
  }

  .modal.is-active {
    display: block;
  }

  .modal.is-visible .modal-wrapper {
    -webkit-transform: translateX(0);
    transform: translateX(0);
  }

  .modal.is-visible .modal-overlay {
    opacity: 0.5;
  }
  .modal-overlay {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: 2000;
    opacity: 0;
    transition: opacity 0.3s;
    will-change: opacity;
    background-color: #000;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }
  /* .modal-body { z-index: 9999; } */
</style>
</head>
<body>
<div class="print-me" id="<?php echo $_REQUEST['id']; ?>"></div>
<div id="dataModal" class="modal fade">  
      <div class="modal-dialog modal-lg" >  
           <div class="modal-content" id="ddr_detail" style="height:90vh!important;">  
                
               
           </div>  
      </div>  
 </div>
 </body>
 </html>