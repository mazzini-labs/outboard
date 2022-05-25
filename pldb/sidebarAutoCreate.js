/**
 * The code below creates a sidebar based on the data pulled from the PLDB. 
 * The idea is that each level will have data attributes that, when clicked, would send a request with those attributes.
 * The response would be json that would be constructed into a table for the user to view/edit.
 * 
 * The location of this code was within the 'DOMContentLoaded' scope. 
 * However this should likely be refactored (hope I'm using that right) into a class. 
 * 
 * TODO: finish this up / get it working
 * TODO: remove jQuery dependency ( $.ajax({}) )
 * 
 */
$.ajax({
    url:"/ajax/pldb.fetchdata.php",  
    method:"POST",  
    data:{"table":"pldb_locations", "simple":1},  
    dataType:"json",  
    success:function(response){ 
        rd = response['data'];
        log(rd.length)
        // log(response['region'])
        var fullregion = {};
        var region = {};
        var li_id = {};
        var a_id = {}
        var span_id = {};
        var i_id = {};
        var cc =  ["sog", "sdc"];
        var ot = { 
            "wells": {
                "op":{
                    "active":["oil","gas","oilgas"], 
                    "si":["oil","gas","oilgas"]
                }, 
                "nonop":{
                    "active":["oil","gas","oilgas"], 
                    "si":["oil","gas","oilgas"]
                },
                "both":{
                    "active":["oil","gas","oilgas"], 
                    "si":["oil","gas","oilgas"]
                }
            },
            "acres":["op", "nonop","both"]};
        var w = ["active", "si"];
        var o = ["op","nonop","both"];
        var t = ["wells", "acres"]
        var og = ["oil", "gas"]
        var count = 0;
        var countB = 0;
        var countC = 0;
        for(a = 0; a < cc.length; a++){
            cc_id = cc[a]+"-queries"
            log(cc_id)
            $('#collapsequeries').append($('<li/>', {id: cc_id, class:"nav-dash-item nav-item"}));
            a_c="nav-link nav-dash-link d-inline-block tree-group-link sidebar-dash-heading d-flex justify-content-between align-items-center sidebar-rounded"
            a_href="#nav-tree-list-wrapper-"
            a_id="tree-link-"
            $('#'+cc_id).append($('<a/>', {class: a_c, href:a_href+cc_id, id: a_id+cc_id}))
            console.log($('#'+cc_id))
            $('#'+a_id+cc_id).attr("data-toggle", "collapse");
            $('#'+a_id+cc_id).attr("role", "button");
            $('#'+a_id+cc_id).append($('<i/>', {class: "d-inline-block text-center tree-icon", "data-feather":"menu"}));
            $('#'+a_id+cc_id).append($('<span/>'), cc[a].toUpperCase());
            $('#'+a_id+cc_id).append($('<i/>', {"data-feather":"chevron-right"}));
            div_c="ml-4 collapse";
            div_id="nav-tree-list-wrapper-"
            $('#'+cc_id).append($('<div/>', {class: div_c, id: div_id+cc_id}));
            $('#'+div_id+cc_id).append($('<ul/>', {class:"flex-column mb-2", id:cc[a]+"-queries-list"}));
            countB++;
            for (b = 0; b < t.length; b++){
                $('#'+cc[a]+"-queries-list").append($('<li/>', { id: cc[a]+"-"+t[b]+"-queries", class: "nav-item"}));
                $('#'+cc[a]+"-"+t[b]+"-queries").append($('<a/>', { class: "nav-link nav-dash-link d-inline-block tree-group-link collapsed", id: "tree-link-"+cc[a]+"-"+t[b], href:"#nav-tree-list-wrapper-"+cc[a]+"-"+t[b]}));
                $('#'+"tree-link-"+cc[a]+"-"+t[b]).attr("data-toggle","collapse")
                $('#'+"tree-link-"+cc[a]+"-"+t[b]).attr("role","button")
                $('#'+"tree-link-"+cc[a]+"-"+t[b]).append($('<span/>', {id: cc[a]+"-"+t[b]+"-queries-span", class: "d-inline-block text-center tree-icon", style:"width: 25px"}), t[b].substr(0,1).toUpperCase()+t[b].substr(1));
                // $('#'+"tree-link-"+cc[a]+"_"+t[b]).append()
                $('#'+cc[a]+"-"+t[b]+"-queries").append($('<div/>', { id: "nav-tree-list-wrapper-"+cc[a]+"-"+t[b], class: "ml-4 collapse" }));
                $('#'+"nav-tree-list-wrapper-"+cc[a]+"-"+t[b]).append($('<ul/>', {class:"flex-column mb-2", id:cc[a]+t[b]+"-queries-list"}));
                countC++;
                // for (c = 0; c < ot[t[b]].length; c++){
                for (c = 0; c < o.length; c++){
                    // c_id = cc[a]+"-"+t[b]+"-"+ot[t[b]][o[c]];
                    c_id = cc[a]+"-"+t[b]+"-"+[o[c]];
                    console.log("b: " + b)
                    console.log("c: " + c)
                    console.log(ot[t[b]][o[c]])
                    var ops = {"op":"Operated", "nonop":"Non-Operated", "both":"Op & Non-Op"}
                    
                    ntlw = "nav-tree-list-wrapper-"+c_id
                    tl = "tree-link-"+c_id
                    $("#"+cc[a]+t[b]+"-queries-list").append($('<li/>', {id:c_id, class: "nav-item"}));
                    $("#"+c_id).append($('<a/>', {id:tl, class: "nav-link nav-dash-link d-inline-block tree-link", href: "#nav-tree-list-wrapper-"+c_id}))
                    // $("#"+tl).append($('<span/>', {id: "nav-tree-list-wrapper-list-"+c_id, class: "d-inline-block text-center tree-icon", style: "width: 25px"}), ops[ot[t[b]][c]])
                    $("#"+tl).append($('<span/>', {id: "nav-tree-list-wrapper-list-"+c_id, class: "d-inline-block text-center tree-icon", style: "width: 25px"}), ops[o[c]])
                    $("#"+tl).attr("data-toggle","collapse");
                    $("#"+tl).attr("button","role");
                    $("#"+c_id).append($('<div/>', {class: "ml-4 collapse", id: ntlw}));
                    $("#"+ntlw).append($('<ul/>', {class:"flex-column mb-2", id:c_id+"-group"}));
                    if(b == 0 ){
                        console.log(t[b]+" - "+ot[t[b]]+" - "+ot[t[b]][o[c]].length + " - " + w.length);
                        // for (d=0; d< ot[t[b]][o[c]].length; d++){
                        for (d=0; d< w.length; d++){

                            var actsi = {"active": "Active", "si": "Shut-In"};
                        
                            var og = ["oil", "gas", "oilgas"]
                            // d_id = cc[a]+"-"+t[b]+"-"+ot[t[b]][o[c]]+"-"+og[d];
                            d_id = cc[a]+"-"+t[b]+"-"+[o[c]]+"-"+w[d]
                            ntlw = "nav-tree-list-wrapper-"+d_id
                            tl = "tree-link-"+d_id
                            console.log(og[d] + "d is " + d);
                            console.log(ot[t[b]][c]);
                            $("#"+cc[a]+t[b]+"-queries-list").append($('<li/>', {id:d_id, class: "nav-item"}));
                            $("#"+d_id).append($('<a/>', {id:tl, class: "nav-link nav-dash-link d-inline-block tree-link", href: "#nav-tree-list-wrapper-"+d_id}))
                            $("#"+tl).append($('<span/>', {id: "nav-tree-list-wrapper-list-"+d_id, class: "d-inline-block text-center tree-icon", style: "width: 25px"}), actsi[w[d]])
                            $("#"+tl).attr("data-toggle","collapse");
                            $("#"+tl).attr("button","role");
                            $("#"+d_id).append($('<div/>', {class: "ml-4 collapse", id: ntlw}));
                            $("#"+ntlw).append($('<ul/>', {class:"flex-column mb-2", id:d_id+"-group"}));
                        }
                        // for(i =0; i < rd.length; i++){
                        //     count++;
                        //     fullregion = rd[i]['region'];
                        //     region = rd[i]['region'].toString().replace(" Region", "");
                        //     // log(region + (hasWhiteSpace(region))? " has whitespace \n replacement is: " +region.replace(" ", "") : "no whitespace")
                        //     if(hasWhiteSpace(region)){ region = region.replace(/\s/g, ''); }
                            
                        //     li_id = cc[a]+"-"+t[b]+"-"+ot[t[b]][c] + "-" + region;
                        //     company_code = cc[a];
                        //     entity_type = t[b];
                        //     op_nonop = ot[t[b]][c];
                        //     location_region = region;
                        //     li_class = "nav-item active data-query";
                        //     a_id = "tree-link-" + li_id;
                        //     a_class = "nav-link nav-dash-link d-inline-block tree-link data-query";
                        //     dq = li_id;
                        //     span_class = "d-inline-block text-center tree-icon";
                        //     span_style="width: 25px";
                        //     span_id="tree-span-" + li_id;
                        //     i_class="fas fa-link";
                        //     i_id="tree-icon-"+li_id;
                        //     $("#"+c_id+"-group").append($('<li/>', { id: li_id,class : li_class,}));
                        //     $("#"+li_id).append($('<a/>', {id: a_id, class: a_class, href:'#', onclick:'queryData()'}));
                        //     // log("the id for <a> is: "+a_id+"\n i = "+i+"\n region["+i+"] = "+region
                        //     // +"\n count: "+count+"\n countB: "+countB+"\n countC: "+countC
                        //     // +"\n a: "+a+ "\n b: "+b+"\n c: "+c)
                        //     $('#'+a_id).attr("data-query", dq);
                        //     $('#'+a_id).attr("data-location", fullregion);
                            
                        //     $("#"+a_id).append($('<span/>', {id: span_id, class: span_class, style:span_style}), fullregion);
                        //     // log("i = "+i+" & the span_id is "+span_id+" and the full region is "+fullregion)
                        //     $("#"+span_id).append($('<i/>', {id: i_id, class: a_class}));
                        // }
                    } else {
                        for(i =0; i < rd.length; i++){
                            count++;
                            fullregion = rd[i]['region'];
                            region = rd[i]['region'].toString().replace(" Region", "");
                            // log(region + (hasWhiteSpace(region))? " has whitespace \n replacement is: " +region.replace(" ", "") : "no whitespace")
                            if(hasWhiteSpace(region)){ region = region.replace(/\s/g, ''); }
                            
                            li_id = cc[a]+"-"+t[b]+"-"+ot[t[b]][c] + "-" + region;
                            company_code = cc[a];
                            entity_type = t[b];
                            op_nonop = ot[t[b]][c];
                            location_region = region;
                            li_class = "nav-item active data-query";
                            a_id = "tree-link-" + li_id;
                            a_class = "nav-link nav-dash-link d-inline-block tree-link data-query";
                            dq = li_id;
                            span_class = "d-inline-block text-center tree-icon";
                            span_style="width: 25px";
                            span_id="tree-span-" + li_id;
                            i_class="fas fa-link";
                            i_id="tree-icon-"+li_id;
                            $("#"+c_id+"-group").append($('<li/>', { id: li_id,class : li_class,}));
                            $("#"+li_id).append($('<a/>', {id: a_id, class: a_class, href:'#', onclick:'queryData()'}));
                            // log("the id for <a> is: "+a_id+"\n i = "+i+"\n region["+i+"] = "+region
                            // +"\n count: "+count+"\n countB: "+countB+"\n countC: "+countC
                            // +"\n a: "+a+ "\n b: "+b+"\n c: "+c)
                            $('#'+a_id).attr("data-query", dq);
                            $('#'+a_id).attr("data-location", fullregion);
                            
                            $("#"+a_id).append($('<span/>', {id: span_id, class: span_class, style:span_style}), fullregion);
                            // log("i = "+i+" & the span_id is "+span_id+" and the full region is "+fullregion)
                            $("#"+span_id).append($('<i/>', {id: i_id, class: a_class}));
                        }
                    }
                }
                    
            }
            
                    
                
        }
        feather.replace();
        
    }
})


/**
 * Unclear what the below function did or the .append() line does
 */
// $('.datareport').on('click', function(){
    
//     // $('.results').each(function(){
//     //     ($(this).attr('id') != value)? $(this).addClass('d-none') : $(this).removeClass('d-none');
//     //     // (($(this).attr('id') != value) || ($(this).attr('id') != valuetable)) ? $(this).addClass('d-none') : $(this).removeClass('d-none');
//     // })
//     // $('.dtables').each(function(){
//     //     ($(this).attr('id') != valuetable) ? $(this).addClass('d-none') : $(this).removeClass('d-none');
//     // })

// })
$('#sog-acre-nonop-group').append()

/**
 * As far as I know, currently unused in PLDB
 */

function queryData(){
    var a = this.oil_gas;
    var b = this.location_region;
    var c = this.active_bool;
    var d = this.company_code;
    var e = this.op_nonop;
    var f = this.entity_type;
    $.ajax({
        url:"/ajax/pldb.fetchdata.php",  
        method:"POST",  
        data:{
            "og":a, 
            "l":b,
            "a":c,
            "cc":d,
            "op":e,
            "et":f
        },  
        dataType:"json",  
        success:function(response){ 
            rd = response['data'];
        }
    })
    
}

/**
 * Pretty sure these are busted printing functions
 */

// function printContent (elem){
//         // let elem = document.getElementById("searchresults");
//         let WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
//         WinPrint.document.write(elem.innerHTML);
//         WinPrint.document.close();
//         WinPrint.focus();
//         WinPrint.print();
//         WinPrint.close();
//     }
// function printSection(el){
//     var getFullContent = document.getElementById('printdiv');
//     var printsection = el.innerHTML;
//     // var printsection = document.getElementById(el).innerHTML;
//     getFullContent.innerHTML = printsection;
//     window.print();
//     // document.body.innerHTML = getFullContent;
// }
// function printDiv(b) {
//     // var a = document.getElementById('printing-css').value;
//     // var b = document.getElementById(elementId).innerHTML;
//     // var b = elementId.innerHTML;
//     // let frame = document.getElementById('printing-frame');
//     // let link = document.createElement('link');
//     // link.rel = 'stylesheet';
//     // link.type = 'text/css';
//     // link.href = '/assets/css/main.min.css';
//     // let linkDT = document.createElement('link');
//     // linkDT.rel = 'stylesheet';
//     // linkDT.type = 'text/css';
//     // linkDT.href = 'https://cdn.datatables.net/v/bs4/dt-1.10.25/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.4/sp-1.2.1/sl-1.3.1/datatables.min.css';
//     // window.frames["print_frame"].document.title = document.title;
//     // window.frames["print_frame"].document.getElementsByTagName('HEAD')[0].appendChild(link);
//     // window.frames["print_frame"].document.getElementsByTagName('HEAD')[0].appendChild(linkDT);

//     // window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
//     // for(let i = 0; i < 2; i++){
//     // frame.style = null;
//     // window.frames["print_frame"].document.body.innerHTML = b;
    
//     // window.frames["print_frame"].style = "";
//     // setTimeout(window.frames["print_frame"].window.focus(), 10000);
//     // window.frames["print_frame"].onfocus = function(){
//     //     window.frames["print_frame"].window.print();
//     // }
    
//     // frame.style = "display:none;";

//     window.frames["print_frame"].window.print();
//     // }
// }


// $(document).on('click', '.results-property', function(){  
//     var id = $(this).attr("id");
//     $('tr.table-info').removeClass("table-info");
//     $(this).addClass("table-info");
//     $.ajax({  
//         url:"/ajax/pldb.editdata.php",  
//         method:"POST",  
//         data:{id:id},  
//         dataType:"json",  
//         success:function(response){  
//             $('.edit-results').removeClass('d-none');
//             $("#editresults").removeClass('d-none');
//             rd = response.data;
//             console.log(response);
//             // console.log(rd[0]['id']);
//             $('#edit-input-1').val(rd[0]['id']);
//             $('#edit-input-2').val(rd[0]['location_id']);
//             $('#edit-input-3').val(rd[0]['name']);
//             $('#edit-input-4').val(rd[0]['wi']);
//             $('#edit-input-5').val(rd[0]['gwi_value']);
//             $('#edit-input-6').val(rd[0]['status']);
//             $('#edit-input-7').val(rd[0]['ri']);
//             $('#edit-input-8').val(rd[0]['nri_value']);
//             $('#edit-input-9').val(rd[0]['operating_status']);
//             $('#edit-input-10').val(rd[0]['orri']);
//             $('#edit-input-11').val(rd[0]['orri_value']);
//             $('#edit-input-12').val(rd[0]['owning_company']);
//             $('#edit-input-13').val(rd[0]['biapo']);
//             $('#edit-input-14').val(rd[0]['ri_values']);
//             $('#edit-input-15').val(rd[0]['operator']);
//             $('#edit-input-16').val(rd[0]['wbo']);
//             $('#edit-input-17').val(rd[0]['legal_description']);
//             $('#edit-input-18').val(rd[0]['gross_acres']);
//             $('#edit-input-19').val(rd[0]['api']);
//             $('#edit-input-20').val(rd[0]['net_acres']);
//             $('#edit-input-21').val(rd[0]['lease_number']);
//             $('#edit-input-22').val(rd[0]['wp_code']);

//         }
//     })
// }) 
