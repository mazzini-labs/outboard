<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connect = mysqli_connect("localhost", "root", "devonian", "wells");  
Function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
if(!empty($_POST))  
{ 
$stmt = $connect->prepare("DELETE FROM notes WHERE id = ?");
$stmt->bind_param('i', $_POST['id']);
$stmt->execute();
printf("%d Row deleted.\n", $stmt->affected_rows);
}
