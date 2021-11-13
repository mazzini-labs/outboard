function drop_down_list(c = "")
{
    var state = $('#state').val();

    if(state == 'AK' || state == 'DC') // Alaska and District Columbia have no counties
    {
    $('#county_drop_down').hide();
    $('#no_county_drop_down').show();
    }
    else
    {
    $('#loading_county_drop_down').show(); // Show the Loading...
	
    $('#county_drop_down').hide(); // Hide the drop down
    $('#no_county_drop_down').hide(); // Hide the "no counties" message (if it's the case)

    $.getScript("js/states/"+ state.toLowerCase() +".js", function(){

    populate(document.insert_well_form.county_parish);

 	$('#loading_county_drop_down').hide(); // Hide the Loading...
    $('#county_drop_down').show(); // Show the drop down
    $('#county_parish').val(c);
    });
}
}

$(document).ready(function(){
$("#state").change(drop_down_list);
});

// $(window).on('load', drop_down_list);
// $(window).on('click', '.edit-well-info', drop_down_list);
// $("#well_entry_Modal").on('load', drop_down_list);
// $('#well_entry_Modal').on('shown.bs.modal', drop_down_list);