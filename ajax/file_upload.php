<?php
    ///////////////////////begin upload file//////////////////////////////////
    if(!empty($_FILES['files'])){
    //$file_name = $_REQUEST['files[]'];
	// $id = mysql_insert_id();
    if($id == '') {
        $id = $last_id;
    }
     // File upload configuration 
    $targetDir = "../wsb_files/" . $api . "/" . $it . "/" . $de . "/"; 
    $allowTypes = array('jpg','png','jpeg','gif','JPG','JPEG','PNG','GIF','doc','docx','pdf','DOC','DOCX','PDF'); 
    if(!is_dir($targetDir)){
         //Directory does not exist, so lets create it.
        mkdir($targetDir, 0755, true);
    }
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
    $fileNames = array_filter($_FILES['files']['name']); 
    if(!empty($fileNames)){ 
        console_log($fileNames);
        foreach($_FILES['files']['name'] as $key=>$val){ 
            // File upload path 
            $fileName = basename($_FILES['files']['name'][$key]); 
            $fileData = pathinfo(basename($_FILES['files']['name'][$key]) );
            $fileName = uniqid() . '.' . $fileData['extension'];
            $targetFilePath = $targetDir . $fileName; 
            console_log($fileName);
             // Check whether file type is valid 
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
            if(in_array($fileType, $allowTypes)){ 
               // Upload file to server 
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){ 
                   // Image db insert sql 
                    $insertValuesSQL .= "('".$api."', '".$id."', '".$fileName."', '".$targetFilePath."', NOW(), '".$it."',),"; 
                }else{ 
                    $errorUpload .= $_FILES['files']['name'][$key].' | '; 
                } 
            }else{ 
                $errorUploadType .= $_FILES['files']['name'][$key].' | '; 
            } 
        } 
        
        if(!empty($insertValuesSQL)){ 
            $insertValuesSQL = trim($insertValuesSQL, ','); 
           // Insert image file name into database
            $sql = "INSERT INTO images (`api`, `note_id`, `filename`, `filepath`, `sd`, `t`) VALUES $insertValuesSQL";
            console_log($sql); 
            $insert = mysql_query($sql); 
            if($insert){ 
                $errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):''; 
                $errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):''; 
                $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType; 
                $statusMsg = "Files are uploaded successfully.".$errorMsg; 
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file."; 
            } 
        } 
    }else{ 
        $statusMsg = 'No files uploaded.'; 
    } 
    
      // Display status message 
    print_r($statusMsg);
    ///////////////////////end upload file//////////////////////////////////
}
    ?>