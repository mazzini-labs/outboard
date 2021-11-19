$(document).ready(function(){
// function pldb_county_fill(c = ""){
//     $('#county_drop_down_fake').hide();
//     $('#strCountyParishFake.selectpicker').selectpicker('destroy');
//     var state = $('#strState').val();
//     // var cp = $('#county_parish');
//     var cp = document.querySelector("#strCountyParish");
//     //var dd = document.querySelector("#bs-select-3");
//     //var dd = document.querySelector("#bs-select-3 > ul > li");
//     if(state == 'AK' || state == 'DC') // Alaska and District Columbia have no counties
//     {
//     $('#county_drop_down').hide();
//     $('#no_county_drop_down').show();
//     }
//     else
//     {
//     $('#loading_county_drop_down').show(); // Show the Loading...
    
//     $('#county_drop_down').hide(); // Hide the drop down
//     $('#no_county_drop_down').hide(); // Hide the "no counties" message (if it's the case)

//     $.getScript("js/states/"+ state.toLowerCase() +".js", function(){

//     populate(cp);

//     // populate(document.insert_well_form.county_parish);

//     $('#loading_county_drop_down').hide(); // Hide the Loading...
//     $('#county_drop_down').show(); // Show the drop down

//     $('#strCountyParish').val(c);
//     });
// }
// }
a = []
w = []
d = document.querySelector("body > div > main > div > div > div").offsetWidth;
for(let $i=1; $i < 8; $i++){

    // b = "#frmSearchDB > div:nth-child("+$i+") > div > select"
    // b = "#frmSearchDB > div:nth-child("+$i+") > div"
    // c = "#frmSearchDB > div:nth-child("+$i+") > div > label"
    // c = "#frmSearchDB > div.container > div:nth-child("+$i+")"
    // a[$i] = document.querySelector(b).offsetWidth - document.querySelector(c).offsetWidth - document.querySelector(c).offsetLeft
    // b = "#frmSearchDB > .w-75"
    b = "#labelWidthElement"
    // a[$i] = document.querySelector(b).offsetWidth - document.querySelector(c).offsetWidth 
    // a[$i] = d - document.querySelector(c).offsetWidth 
    // w[$i] = ( a[$i] * 1 ) + "px"
    console.log("Width ("+$i+"): "+w[$i]);
    // $('#input'+$i).selectpicker({width:w[$i]});
    $('#input'+$i).selectpicker({width:'100%'});
    // $('#input'+$i).selectpicker({style:'btn btn-primary btn-sm btn-block',styleBase:''});
}


$('#searchTypeName').selectpicker();
// $('#searchTypeName').selectpicker({width:w[0]});
$('#strState').selectpicker({width:w[1]});
$('#strCountyParishFake').selectpicker({width:w[2]});

$('#searchTypeBlock').selectpicker();
// $('#searchTypeBlock').selectpicker({width:w[4]});
$('#searchTypeCompanyCode').selectpicker({width:w[5]});
$('#searchTypeEntityStatus').selectpicker({width:w[6]});
$('#searchTypeStatus').selectpicker({width:w[6]});
// $('#input1').selectpicker();
// $('#input2').selectpicker();
// $('#input3').selectpicker();
// $('#input4').selectpicker();
// $('#input5').selectpicker();
// $('#input6').selectpicker();
// $('#input7').selectpicker();
// $('#input8').selectpicker();
$('#input2').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    $('#county_drop_down_fake').hide();
    $('#county_drop_down').removeClass("hidden");
    // $("#strState").change(pldb_county_fill);
    // $("#strCountyParish").addClass("selectpicker");
    // $("#strCountyParish.selectpicker").selectpicker('render');

    
    
    // $('#county_drop_down_fake').hide();
    $('.strCountyParishFake.selectpicker').selectpicker('destroy');
    var state = $('#input2').val();
    console.log(state);
    // var cp = $('#county_parish');
    var cp = document.querySelector("#input3");
    //var dd = document.querySelector("#bs-select-3");
    //var dd = document.querySelector("#bs-select-3 > ul > li");
    if(state == 'AK' || state == 'DC') // Alaska and District Columbia have no counties
    {
    $('#county_drop_down').hide();
    $('#no_county_drop_down').show();
    }
    else
    {
    $('#loading_county_drop_down').show(); // Show the Loading...
    
    // $('#county_drop_down').hide(); // Hide the drop down
    $('#no_county_drop_down').hide(); // Hide the "no counties" message (if it's the case)

    $.getScript("/assets/js/states/"+ state.toLowerCase() +".js", function(){

    populate(cp);
    
    // populate(document.insert_well_form.county_parish);

    $('#loading_county_drop_down').hide(); // Hide the Loading...
     // Show the drop down

    // $('.strCountyParish').val(cp[0]);
    // console.log(cp[0]);
    // $('.strCountyParish').selectpicker({width:'100%'});
    $("#input3").selectpicker('refresh');
    });
}

    

});
$('#strCountyParish').on('rendered.bs.select', function () {
    // $('#strCountyParish.selectpicker').selectpicker({'liveSearch':true});
    // $('#strCountyParish.selectpicker').selectpicker('refresh');
});

    
  
});