function showEdit(editableObj) {
	$(editableObj).css("background", "#343a40");
	$(editableObj).css("color", "#fff");
}

function saveToDatabase(editableObj, column, id) {
	$(editableObj)
			.css("background", "#343a40 url(./images/loaderIcon.gif) no-repeat center right 5px");
	$.ajax({
		url : "./ajax/save-edit.notes.php",
		type : "POST",
		data : 'column=' + column + '&editval=' + editableObj.innerHTML
				+ '&id=' + id,
		success : function(data) {
            $(editableObj).css("background", "#28a745");
            $.ajax({
                url : "./ajax/save-edit.notesarchive.php",
                type : "POST",
                data : 'column=' + column + '&editval=' + editableObj.innerHTML
                        + '&id=' + id,
                success : function() {
                    // alert('It worked.');
                }
            });
		}
	});
}