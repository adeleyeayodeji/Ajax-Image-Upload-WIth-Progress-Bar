<?php

//If isset file
if (isset($_FILES)) {
    
    // Resize the image to the size of choice
    function resizeImage($resourceType,$image_width,$image_height) {
        $resizeWidth = 300; // Specify Width
        $resizeHeight = 300; // Specify Height
        $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
        imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
        return $imageLayer;
    }

    $imageProcess = 0;
    //image process start here
    if(is_array($_FILES)) {
        $fileName = $_FILES['fileToUpload']['tmp_name']; 
        $sourceProperties = getimagesize($fileName);
        //Specify the the new resized image name 
        $resizeFileName = "" ;
        //Specify uploaded file directory
        $uploadPath =  "./uploads/";
        $fileExt = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
        $uploadImageType = $sourceProperties[2];
        $sourceImageWidth = $sourceProperties[0];
        $sourceImageHeight = $sourceProperties[1];
        switch ($uploadImageType) {
            case IMAGETYPE_JPEG:
                $resourceType = imagecreatefromjpeg($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                imagepng($imageLayer,$uploadPath.$resizeFileName.'.jpeg');
                break;

            case IMAGETYPE_GIF:
                $resourceType = imagecreatefromgif($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                imagepng($imageLayer,$uploadPath.$resizeFileName.'.gif');
                break;

            case IMAGETYPE_PNG:
                $resourceType = imagecreatefrompng($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                imagepng($imageLayer,$uploadPath.$resizeFileName.'.png');
                break;

            default:
                $imageProcess = 0;
                break;
        }
        move_uploaded_file($file, $uploadPath. $resizeFileName. ".". $fileExt);
        $imageProcess = 1;
    }
    if($imageProcess == 1){
        echo json_encode(array('info' => 'Uploaded'));
    }else{
        echo json_encode(array('info' => 'Failed'));
    }
}
