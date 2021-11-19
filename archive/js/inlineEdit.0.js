function showEdit(editableObj) {
	$(editableObj).css("background", "#FFF");
}

function saveToDatabase(editableObj, column, id, api, sheet) {
	$(editableObj)
			.css("background", "#FFF url(./images/loaderIcon.gif) no-repeat center right 5px");
	$.ajax({
		url : "./ajax/save-edit0.php",
		type : "POST",
		data : 'column=' + column + '&editval=' + editableObj.innerHTML
				+ '&id=' + id + '&api=' + api + '&sheet=' + sheet,
		success : function(data) {
			$(editableObj).css("background", "#FDFDFD");
		}
	});
}
function createNew() {
	$("#add-more").hide();
	var data = '<tr class="table-row" id="new_row_ajax">' +
	'<td contenteditable="true" id="txt_title" onBlur="addToHiddenField(this,\'title\')" onClick="editRow(this);"></td>' +
	'<td contenteditable="true" id="txt_description" onBlur="addToHiddenField(this,\'description\')" onClick="editRow(this);"></td>' +
	'<td><input type="hidden" id="title" /><input type="hidden" id="description" /><span id="confirmAdd"><a onClick="addToDatabase()" class="ajax-action-links">Save</a> / <a onclick="cancelAdd();" class="ajax-action-links">Cancel</a></span></td>' +	
	'</tr>';
  $("#table-body").append(data);
}
function cancelAdd() {
	$("#add-more").show();
	$("#new_row_ajax").remove();
}
function addToDatabase() {
	var title = $("#title").val();
	var description = $("#description").val();
	
		$("#confirmAdd").html('<img src="loaderIcon.gif" />');
		$.ajax({
		  url: "./ajax/inline_add.php",
		  type: "POST",
		  data:'title='+title+'&description='+description,
		  success: function(data){
			$("#new_row_ajax").remove();
			$("#add-more").show();		  
			$("#table-body").append(data);
		  }
		});
}
function addToHiddenField(addColumn,hiddenField) {
	var columnValue = $(addColumn).text();
	$("#"+hiddenField).val(columnValue);
}

function deleteRecord(id) {
	if(confirm("Are you sure you want to delete this row?")) {
		$.ajax({
			url: "./ajax/inline_delete.php",
			type: "POST",
			data:'id='+id,
			success: function(data){
			  $("#table-row-"+id).remove();
			}
		});
	}
}