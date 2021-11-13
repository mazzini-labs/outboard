$(function(){
    var editID;
    var editor;
    var drn = {
        selector: '#drn1',
        skin: "bs",
        // skin: 'oxide-dark',
        content_css: "//vprsrv.org/js/tinymce/skins/ui/bs",
        menubar: false,
        // inline: true,
        plugins: [
            'lists',
            'quickbars',
            'help',
            'autoresize'
        ],
        toolbar: true,
        quickbars_insert_toolbar: 'codesample',
        quickbars_selection_toolbar: "bold italic underline strikethrough forecolor backcolor formatpainter | alignleft aligncenter alignright alignjustify | outdent indent removeformat | code | checklist | casechange",
        // numlist bullist 
        contextmenu: 'copy pastetext | undo redo | help',
        powerpaste_word_import: 'clean',
        powerpaste_html_import: 'clean',
    };
    editor = tinymce.init(drn);
    // editor_remove = tinymce.remove();
    $(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
    });
    $("#engShow").click(function(){
        $("#eng").show();
        $("#acct").hide();
        $("#vend").hide();
        $("#field").hide();
    });
    $("#acctShow").click(function(){
        $("#acct").show();
        $("#eng").hide();
        $("#vend").hide();
        $("#field").hide();
    });
    $("#vendShow").click(function(){
        $("#vend").show();
        $("#acct").hide();
        $("#eng").hide();
        $("#field").hide();
    });
    $("#fieldShow").click(function(){
        $("#field").show();
        $("#acct").hide();
        $("#vend").hide();
        $("#eng").hide();
    });
    $('#drn-e-none').click(function(){  
        

        $('#appendSection').removeClass("show");        
        $('#replaceSection').removeClass("show");
    });

    $('#drn-e-add').click(function(){  
        

        $('#replaceSection').removeClass("show");        
        // $('#removeSection').addClass("active");
    });
    $('#drn-e-replace').click(function(){  
        

        $('#appendSection').removeClass("show");        
        // $('#removeSection').addClass("active");
    });


// Insert/Edit/View DDR/DSR
$('#add').click(function(){  
        
    // editor_remove;
    // editor;
    $('#pills-eng-tab').removeClass("disabled not-allowed");
    $('#pills-acct-tab').removeClass("active disabled not-allowed");
    $('#pills-vend-tab').removeClass("active disabled not-allowed");
    $('#pills-field-tab').removeClass("active disabled not-allowed");
    
    $('#pills-eng-tab').addClass("active");

    $('#pills-eng').addClass("in show active");
    $('#pills-acct').removeClass("in show active");
    $('#pills-vend').removeClass("in show active");
    $('#pills-field').removeClass("in show active");  
    $('#insert').val("Insert"); 
    $('#insert_form')[0].reset();
    $('#id').val('');
    $('.ddr-a').prop('disabled', false);
    $('.ddr-v').prop('disabled', false);
    $('.ddr-f').prop('disabled', false);
    $('.ddr-e').prop('disabled', false);
    $('#appendSection').removeClass("show");        
    $('#replaceSection').removeClass("show");
});
$('#add_dsr').click(function(){
    $('#insert.dsr').val("Insert"); 
    $('#insert_form.dsr')[0].reset();
    $('#id.dsr').val('');
})
$('#pills-eng').click(function(){  
    $('.ddr-a').prop('disabled', true);
    $('.ddr-v').prop('disabled', true);
    $('.ddr-f').prop('disabled', true);
    $('#drn.ddr-v').trumbowyg('destroy');
    $('#drn.ddr-f').trumbowyg('destroy');
});
$('#pills-acct').click(function(){  
    $('.ddr-e').prop('disabled', true);
    $('.ddr-v').prop('disabled', true);
    $('.ddr-f').prop('disabled', true);
    $('#drn.ddr-e').trumbowyg('destroy');
    $('#drn.ddr-v').trumbowyg('destroy');
    $('#drn.ddr-f').trumbowyg('destroy');
});
$('#pills-vend').click(function(){  
    $('.ddr-e').prop('disabled', true);
    $('.ddr-a').prop('disabled', true);
    $('.ddr-f').prop('disabled', true);
    $('#drn.ddr-e').trumbowyg('destroy');
    $('#drn.ddr-f').trumbowyg('destroy');
});
$('#pills-field').click(function(){  
    $('.ddr-e').prop('disabled', true);
    $('.ddr-a').prop('disabled', true);
    $('.ddr-v').prop('disabled', true);
    $('#drn.ddr-e').trumbowyg('destroy');
    $('#drn.ddr-v').trumbowyg('destroy');
});
$('#dsr-tab').click(function(){  
    $('.ddr-e').prop('disabled', true);
    $('.ddr-a').prop('disabled', true);
    $('.ddr-v').prop('disabled', true);
    $('.ddr-f').prop('disabled', true);
});
$('#insert_form.ddr').on("submit", function(event){  
    event.preventDefault();  
    if($('#de').val() == "")  
    {  
            alert("Date is required");  
    }  
    else  
    {  
            $.ajax({  
                url:"./ajax/insert.ntf.php",  
                method:"POST",  
                data:$('#insert_form').serialize(),  
                beforeSend:function(){  
                    $('#insert').val("Inserting");  
                },  
                success:function(data){  
                    $('#insert_form')[0].reset();  
                    $('#add_data_Modal').modal('hide');
                    iTable.ajax.reload();  
                    $('#drn.ddr-e').trumbowyg('destroy');
                    $('#drn.ddr-v').trumbowyg('destroy');
                    // $('#drn.ddr-a').trumbowyg('destroy');
                    $('#drn.ddr-f').trumbowyg('destroy');
                }  
            });  
    }  
});  
$('#insert_form.dsr').on("submit", function(event){  
    event.preventDefault();  
    if($('#de.dsr').val() == "")  
    {  
            alert("Date is required");  
    }  
    else  
    {  
            $.ajax({  
                url:"./ajax/insert.ntf.php",  
                method:"POST",  
                data:$('#insert_form.dsr').serialize(),  
                beforeSend:function(){  
                    $('#insert.dsr').val("Inserting");  
                },  
                success:function(data){  
                    $('#insert_form.dsr')[0].reset();  
                    $('#add_data_dsr_Modal').modal('hide');
                    sTable.ajax.reload();  
                    //$('#dsr_table').html(data);  
                }  
            });  
    }  
});
$('#insert_well_form').on("submit", function(event){
    event.preventDefault();
    
    if($('#api').val() == "")  
    {  
            alert("API No. is required");  
    }  
    else  
    {  
        var api = $('#api').val();
        $.ajax({
            url:"./ajax/insert.well.php",  
            method:"POST",  
            data:$('#insert_well_form').serialize(),  
            beforeSend:function(){  
                $('#insert-well').val("Inserting");  
            },  
            success:function(data){  
                $('#insert_well_form')[0].reset();  
                $('#well_entry_Modal').modal('hide');
                //$('#dsr_table').html(data);
                $.ajax({  
                    url:"./ajax/fetchwells.php",  
                    method:"POST",  
                    data:{api:api},  
                    dataType:"json",  
                    success:function(data){
                        $('#cn.wellinfo').html(data.entity_common_name);  
                        $('#an.wellinfo').html(data.api);  
                        $('#eo.wellinfo').html(data.entity_operator_code);  
                        $('#p.wellinfo').html(data.pumper);  
                        $('#s.wellinfo').html(data.state);  
                        $('#cp.wellinfo').html(data.county_parish);  
                        $('#b.wellinfo').html(data.block);
                        $('#lat.wellinfo').html(data.surface_latitude_wgs84);  
                        $('#long.wellinfo').html(data.surface_longitude_wgs84);
                        $('#ws.wellinfo').html(data.producing_status);
                        $('#pt.wellinfo').html(data.production_type);
                        $('#r.wellinfo').html(data.reservoir);
                        $('#f.wellinfo').html(data.field);
                        $('#md.wellinfo').html(data.measured_depth_td);
                        $('#tvd.wellinfo').html(data.true_vertical_depth);
                        $('#dt.wellinfo').html(data.drill_type);
                        $('#cd.wellinfo').html(data.completion_date);
                        $('#fpd.wellinfo').html(data.first_prod_date);
                        $('#ggr.wellinfo').html(data.gas_gatherer);
                        $('#ogr.wellinfo').html(data.oil_gatherer);
                        $('#up.wellinfo').html(data.upper_perforation);
                        $('#lp.wellinfo').html(data.lower_perforation);
                        $('#gg.wellinfo').html(data.gas_gravity);
                        $('#og.wellinfo').html(data.oil_gravity);
                        $('#sd.wellinfo').html(data.spud_date);
                        $('#lpd.wellinfo').html(data.last_prod_date);
                        $('#l.wellinfo').html(data.landowner);  
                        $('#gc.wellinfo').html(data.gatecombo);  
                        $('#ln.wellinfo').html(data.landowner_notes);
                    }
                });     
            }  
        });  
    }
});  
$(document).on('click', '.edit_ddr-e', function(){  
    var id = $(this).attr("id");
    $('#drn.ddr-e').trumbowyg(drn_t);  
    $.ajax({  
            url:"./ajax/fetch.php",  
            method:"POST",  
            data:{id:id},  
            dataType:"json",  
            success:function(data){  
                $('#deb.ddr').val(data.deb);  
                $('#t.ddr').val(data.t);  
                $('#de.ddr').val(data.de);  
                $('#ts.ddr').val(data.ts);  
                $('#te.ddr').val(data.te);  
                $('#id.ddr').val(data.id);  
                $('#api.ddr').val(data.api);
                $('#ec.ddr').val(data.ec);  
                $('#d.ddr-e').val(data.d);  
                $('#cvn.ddr-e').val(data.cvn);  
                $('#cin.ddr-e').val(data.cin);  
                // $('#drn.ddr-e').val(data.drn);
                $('#drn.ddr-e').trumbowyg('html', data.drn);
                // quill.insertText(data.drn);
                // $('#drn_ifr.ddr-e').val(data.drn);
                // editor.insertContent(data.drn); 
                // tinymce.get('drn').setContent(data.drn);
                // CKEDITOR.editor.setData(data.drn);
                // CKEDITOR.editor.insertText(data.drn);
                // CKEDITOR.editor.insertHTML(data.drn);
                $('#edc.ddr-e').val(data.edc);  
                $('#ecc.ddr-e').val(data.ecc); 
                // console.log(data.deb);  
                // console.log(data.t);  
                // console.log(data.de);  
                // console.log(data.ts);  
                // console.log(data.te);  
                // console.log(data.id);  
                // console.log(data.api);  
                // console.log(data.d);  
                // console.log(data.cvn);  
                // console.log(data.cin);  
                // console.log(data.drn); 
                // console.log(data.edc);  
                // console.log(data.ecc);
                $('#insert.ddr-e').val("Update");  
                $('#add_data_Modal').modal('show');  
                
                
                $('#pills-eng-tab').addClass("active");
                $('#pills-eng-tab').removeClass("disabled not-allowed");

                $('#pills-acct-tab').removeClass("active");
                $('#pills-acct-tab').addClass("disabled not-allowed");

                $('#pills-vend-tab').removeClass("active");
                $('#pills-vend-tab').addClass("disabled not-allowed");

                $('#pills-field-tab').removeClass("active");
                $('#pills-field-tab').addClass("disabled not-allowed");

                $('#pills-eng').addClass("in show active");
                $('#pills-acct').removeClass("in show active");
                $('#pills-vend').removeClass("in show active");
                $('#pills-field').removeClass("in show active");
                $('.ddr-a').prop('disabled', true);
                $('.ddr-v').prop('disabled', true);
                $('.ddr-f').prop('disabled', true);
                $('.ddr-e').prop('disabled', false);
                $('#appendSection').removeClass("show");        
                $('#replaceSection').removeClass("show");
                
            }  
    });  
});
$(document).on('click', '.edit_ddr-a', function(){
    $('#ad').datepicker('update', '');  
    var id = $(this).attr("id");
    // $('#drn.ddr-a').trumbowyg(drn_t);  
    $.ajax({  
            url:"./ajax/fetch.php",  
            method:"POST",  
            data:{id:id},  
            dataType:"json",  
            success:function(data){  
                $('#deb.ddr').val(data.deb);  
                $('#t.ddr').val(data.t);  
                $('#de.ddr').val(data.de);  
                $('#ts.ddr').val(data.ts);  
                $('#te.ddr').val(data.te);  
                $('#id.ddr').val(data.id);  
                $('#api.ddr').val(data.api);
                $('#ec.ddr').val(data.ec);    
                $('#d.ddr-a').val(data.d);  
                $('#cvn.ddr-a').val(data.cvn);  
                $('#cin.ddr-a').val(data.cin);  
                $('#drn.ddr-a').val(data.drn); 
                // $('#drn.ddr-a').trumbowyg('html', data.drn);
                $('#edc.ddr-a').val(data.edc);  
                $('#ecc.ddr-a').val(data.ecc);  
                $('#ad').val(data.ad); 

                $('#insert.ddr-a').val("Update");  
                $('#add_data_Modal').modal('show');  
                
                $('#pills-eng-tab').removeClass("active");
                $('#pills-eng-tab').addClass("disabled not-allowed");

                $('#pills-acct-tab').addClass("active");
                $('#pills-acct-tab').removeClass("disabled not-allowed");

                $('#pills-vend-tab').removeClass("active");
                $('#pills-vend-tab').addClass("disabled not-allowed");

                $('#pills-field-tab').removeClass("active");
                $('#pills-field-tab').addClass("disabled not-allowed");

                $('#pills-eng').removeClass("in show active");
                $('#pills-acct').addClass("in show active");
                $('#pills-vend').removeClass("in show active");
                $('#pills-field').removeClass("in show active");
                $('.ddr-a').prop('disabled', false);
                $('.ddr-v').prop('disabled', true);
                $('.ddr-f').prop('disabled', true);
                $('.ddr-e').prop('disabled', true);
            }  
    });  
});    
$(document).on('click', '.edit_ddr-v', function(){  
    var id = $(this).attr("id");
    $('#drn.ddr-v').trumbowyg(drn_t);  
    $.ajax({  
            url:"./ajax/fetch.php",  
            method:"POST",  
            data:{id:id},  
            dataType:"json",  
            success:function(data){  
                $('#deb.ddr').val(data.deb);  
                $('#t.ddr').val(data.t);  
                $('#de.ddr').val(data.de);  
                $('#ts.ddr').val(data.ts);  
                $('#te.ddr').val(data.te);  
                $('#id.ddr').val(data.id);  
                $('#api.ddr').val(data.api);
                $('#ec.ddr').val(data.ec);    
                $('#d.ddr-v').val(data.d);  
                $('#cvn.ddr-v').val(data.cvn);  
                $('#cin.ddr-v').val(data.cin);  
                // $('#drn.ddr-v').val(data.drn);
                $('#drn.ddr-v').trumbowyg('html', data.drn); 
                $('#edc.ddr-v').val(data.edc);  
                $('#ecc.ddr-v').val(data.ecc); 
                $('#ac.ddr-v').val(data.ac);
                $('#dc.ddr-v').val(data.dc);
                $('#at.ddr-v').val(data.at); 
                $('#et.ddr-v').val(data.et); 
                $('#dt.ddr-v').val(data.dt); 
                $('#tt.ddr-v').val(data.tt); 

                $('#insert.ddr-v').val("Update");  
                $('#add_data_Modal').modal('show');  

                $('#pills-eng-tab').removeClass("active");
                $('#pills-eng-tab').addClass("disabled not-allowed");

                $('#pills-acct-tab').removeClass("active");
                $('#pills-acct-tab').addClass("disabled not-allowed");

                $('#pills-vend-tab').addClass("active");
                $('#pills-vend-tab').removeClass("disabled not-allowed");

                $('#pills-field-tab').removeClass("active");
                $('#pills-field-tab').addClass("disabled not-allowed");

                $('#pills-eng').removeClass("in show active");
                $('#pills-acct').removeClass("in show active");
                $('#pills-vend').addClass("in show active");
                $('#pills-field').removeClass("in show active");
                $('.ddr-a').prop('disabled', true);
                $('.ddr-e').prop('disabled', true);
                $('.ddr-f').prop('disabled', true);
                $('.ddr-v').prop('disabled', false);
            }  
    });  
});    
$(document).on('click', '.edit_ddr-f', function(){  
    var id = $(this).attr("id");  
    $('#drn.ddr-f').trumbowyg(drn_t);  
    $.ajax({  
            url:"./ajax/fetch.php",  
            method:"POST",  
            data:{id:id},  
            dataType:"json",  
            success:function(data){  
                $('#deb.ddr').val(data.deb);  
                $('#t.ddr').val(data.t);  
                $('#de.ddr').val(data.de);  
                $('#ts.ddr').val(data.ts);  
                $('#te.ddr').val(data.te);  
                $('#id.ddr').val(data.id);  
                $('#api.ddr').val(data.api);
                $('#ec.ddr').val(data.ec);    
                $('#d.ddr-f').val(data.d);  
                $('#cvn.ddr-f').val(data.cvn);  
                $('#cin.ddr-f').val(data.cin);  
                // $('#drn.ddr-f').val(data.drn);
                $('#drn.ddr-f').trumbowyg('html', data.drn); 
                $('#edc.ddr-f').val(data.edc);  
                $('#ecc.ddr-f').val(data.ecc);  

                $('#insert.ddr-f').val("Update");  
                
                $('#add_data_Modal').modal('show');  
                
                $('#pills-eng-tab').removeClass("active");
                $('#pills-eng-tab').addClass("disabled not-allowed");

                $('#pills-acct-tab').removeClass("active");
                $('#pills-acct-tab').addClass("disabled not-allowed");

                $('#pills-vend-tab').removeClass("active");
                $('#pills-vend-tab').addClass("disabled not-allowed");

                $('#pills-field-tab').addClass("active");
                $('#pills-field-tab').removeClass("disabled not-allowed");

                $('#pills-eng').removeClass("in show active");
                $('#pills-acct').removeClass("in show active");
                $('#pills-vend').removeClass("in show active");
                $('#pills-field').addClass("in show active");
                $('.ddr-a').prop('disabled', true);
                $('.ddr-v').prop('disabled', true);
                $('.ddr-e').prop('disabled', true);
                $('.ddr-f').prop('disabled', false);
            }  
    });  
});    
$(document).on('click', '.edit_dsr', function(){  
    var id = $(this).attr("id");  
    $.ajax({  
            url:"./ajax/fetch.php",  
            method:"POST",  
            data:{id:id},  
            dataType:"json",  
            success:function(data){  
                $('#deb.dsr').val(data.deb);  
                $('#t.dsr').val(data.t);  
                $('#de.dsr').val(data.de);  
                $('#ts.dsr').val(data.ts);  
                $('#te.dsr').val(data.te);  
                $('#id.dsr').val(data.id);  
                $('#api.dsr').val(data.api);
                $('#ec.ddr').val(data.ec);    
                $('#d.dsr').val(data.d);  
                $('#cvn.dsr').val(data.cvn);  
                $('#cin.dsr').val(data.cin);  
                $('#drn.dsr').val(data.drn); 
                $('#edc.dsr').val(data.edc);  
                $('#ecc.dsr').val(data.ecc);  

                $('#insert.dsr').val("Update");  
                $('#add_data_dsr_Modal').modal('show');  
                
                
                $('#pills-eng-tab').addClass("active");
                $('#pills-eng-tab').removeClass("disabled not-allowed");

                $('#pills-acct-tab').removeClass("active");
                $('#pills-acct-tab').addClass("disabled not-allowed");

                $('#pills-vend-tab').removeClass("active");
                $('#pills-vend-tab').addClass("disabled not-allowed");

                $('#pills-field-tab').removeClass("active");
                $('#pills-field-tab').addClass("disabled not-allowed");

                $('#pills-eng').addClass("in show active");
                $('#pills-acct').removeClass("in show active");
                $('#pills-vend').removeClass("in show active");
                $('#pills-field').removeClass("in show active");
                $('.ddr-a').prop('disabled', true);
                $('.ddr-v').prop('disabled', true);
                $('.ddr-f').prop('disabled', true);
                $('.ddr-e').prop('disabled', true);
                
            }  
    });  
});
$(document).on('click', '#add.fixed-action-btn', function(){
    var now = moment();
    var curDate = now.format('YYYY-MM-DD');
    var curTime = now.format('HH:mm');
    $('#de').val(curDate);
    $('#ts').val(curTime);
    $('#te').val(curTime);
    // $('.datepicker').datepicker('destroy');
    $('#dee').datepicker('update', curDate);
    $('#drn.ddr-e').trumbowyg('destroy');
    $('#drn.ddr-v').trumbowyg('destroy');
    // $('#drn.ddr-a').trumbowyg('destroy');
    $('#drn.ddr-f').trumbowyg('destroy');
    $('#drn.ddr-e').trumbowyg(drn_t);
    $('#drn.ddr-v').trumbowyg(drn_t);
    // $('#drn.ddr-a').trumbowyg(drn_t);
    $('#drn.ddr-f').trumbowyg(drn_t);
})
function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
    }
    return val;
}
function formatMoney(number, decPlaces, decSep, thouSep) {
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    decSep = typeof decSep === "undefined" ? "." : decSep;
    thouSep = typeof thouSep === "undefined" ? "," : thouSep;
    var sign = number < 0 ? "-" : "";
    var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
    var j = (j = i.length) > 3 ? j % 3 : 0;
    
    return sign +
        (j ? i.substr(0, j) + thouSep : "") +
        i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
        (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
    }

$('#drn-e-none').click(function(){  


    $('#appendSection').removeClass("show");        
    $('#replaceSection').removeClass("show");
});

$('#drn-e-add').click(function(){  
    

    $('#replaceSection').removeClass("show");        
    // $('#removeSection').addClass("active");
});
$('#drn-e-replace').click(function(){  
    

    $('#appendSection').removeClass("show");        
    // $('#removeSection').addClass("active");
});
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

});
