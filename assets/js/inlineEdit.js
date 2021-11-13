function showEdit(editableObj) {
	$(editableObj).css("background", "#FFF");
}

function saveToDatabase(editableObj, column, id, api, sheet) {
	$(editableObj)
			.css("background", "#FFF url(./images/loaderIcon.gif) no-repeat center right 5px");
	$.ajax({
		url : "./ajax/save-edit.php",
		type : "POST",
		data : 'column=' + column + '&editval=' + editableObj.innerHTML
				+ '&id=' + id + '&api=' + api + '&sheet=' + sheet,
		success : function(data) {
			$(editableObj).css("background", "#FDFDFD");
		}
	});
}