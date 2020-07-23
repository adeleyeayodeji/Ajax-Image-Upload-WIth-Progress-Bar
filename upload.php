<?php

//If isset file
if (isset($_FILES)) {
    $fileName = $_FILES['filename']['name'];
    //Move uploaded file to a nice directory
    $targetPath = "uploads/".basename($fileName);
    $saved = move_uploaded_file($_FILES['filename']['tmp_name'], $targetPath);
    if ($saved) {
        echo json_encode(array('info' => 'Uploaded'));
    }
}
