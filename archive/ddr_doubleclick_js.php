<script>
var dblclick = false;

//single click function
$('td.inline').on('click',function(){
    setTimeout(function(){
        if($('td.inline').prop("disabled"))    return;
        console.log('singleClick');
        
        $('td.inline').prop("disabled", true);
        //some single click work.
        $('td.inline').prop("disabled", false);
    },1000); 
});

//double click function
$('td.inline').on('dblclick',function(){       
    if($('td.inline').prop("disabled"))    return;
    $('td.inline').prop("disabled", true);
    console.log('doubleClick');
    showEdit(this);
    //some work    then enable single click again
    setTimeout(function(){
    $('td.inline').prop("disabled",false);
    },2000); 
});
</script>