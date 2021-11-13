$(document).ready(function(){
     
    
      
     $('#insert_form-a').on("submit", function(event){  
          event.preventDefault();  
          if($('#de').val() == "")  
          {  
               alert("Date is required");  
          }  
          else  
          {  
               $.ajax({  
                    url:"./ddrtest/insert.a.php",  
                    method:"POST",  
                    data:$('#insert_form-a').serialize(),  
                    beforeSend:function(){  
                         $('#insert-a').val("Inserting");  
                    },  
                    success:function(data){  
                         $('#insert_form-a')[0].reset();  
                         $('#add_data_Modal').modal('hide');  
                         $('#ddr_table').html(data);  
                    }  
               });  
          }  
     });  
     $('#insert_form-v').on("submit", function(event){  
          event.preventDefault();  
          if($('#de-v').val() == "")  
          {  
               alert("Date is required");  
          }
          
          else  
          {  
               $.ajax({  
                    url:"./ddrtest/insert.v.php",  
                    method:"POST",  
                    data:$('#insert_form-v').serialize(),  
                    beforeSend:function(){  
                         $('#insert-v').val("Inserting");  
                    },  
                    success:function(data){  
                         $('#insert_form-v')[0].reset();  
                         $('#add_data_Modal').modal('hide');  
                         $('#ddr_table').html(data);  
                    }  
               });  
          }  
     }); 
     $('#insert_form-f').on("submit", function(event){  
          event.preventDefault();  
          if($('#de-f').val() == "")  
          {  
               alert("Date is required");  
          } 
          if($('#ts-f').val() == "" || $('#te-f').val() == "")
          {
              alert("At least one time is required.");
          }
          if($('#ts-f').val() > $('#te-f').val() && $('#te-f').val() != "")
          {
              alert("The start time cannot be greater than the end time.");
          }
          if($('#cvn-f').val() == "")  
          {  
               alert("Contact name is required");  
          }
          if($('#cvn-f').val() != "" && $('#cin-f').val() == "")  
          {  
               alert("Please enter "+$('#cvn-f').val()+"'s contact information");  
          } 
          else  
          {  
               $.ajax({  
                    url:"./ddrtest/insert.f.php",  
                    method:"POST",  
                    data:$('#insert_form-f').serialize(),  
                    beforeSend:function(){  
                         $('#insert-f').val("Inserting");  
                    },  
                    success:function(data){  
                         $('#insert_form-f')[0].reset();  
                         $('#add_data_Modal').modal('hide');  
                         $('#ddr_table').html(data);  
                    }  
               });  
          }  
     }); 
     
});  