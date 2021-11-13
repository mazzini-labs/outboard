<?php
require_once("obcontroller.php");
$db_handle = new DBController();

if(!empty($_POST["title"])) {
	$title = mysql_real_escape_string(strip_tags($_POST["title"]));
	$description = mysql_real_escape_string(strip_tags($_POST["description"]));
  $sql = "INSERT INTO new_ddr (post_title,description) VALUES ('" . $title . "','" . $description . "')";
  $faq_id = $db_handle->executeInsert($sql);
	if(!empty($faq_id)) {
		$sql = "SELECT * from new_ddr WHERE id = '$faq_id' ";
		$posts = $db_handle->runSelectQuery($sql);
	}/*
?>
<tr class="table-row" id="table-row-<?php echo $posts[0]["id"]; ?>">
<td contenteditable="true" onBlur="saveToDatabase(this,'post_title','<?php echo $posts[0]["id"]; ?>')" onClick="editRow(this);"><?php echo $posts[0]["department"]; ?></td>
<td contenteditable="true" onBlur="saveToDatabase(this,'description','<?php echo $posts[0]["id"]; ?>')" onClick="editRow(this);"><?php echo $posts[0]["type"]; ?></td>
<td><a class="ajax-action-links" onclick="deleteRecord(<?php echo $posts[0]["id"]; ?>);">Delete</a></td>
</tr>  
<?php */ } ?>