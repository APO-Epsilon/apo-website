<?php
session_start();

$exec_page = false;
$active_page = true;
$public_page = false;
require_once("../permissions.php");

function show_active() {
    //Code based on example at https://vikasmahajan.wordpress.com/2010/07/07/inserting-and-displaying-images-in-mysql-using-php/
    include('../mysql_access.php');
    $user_id = $_SESSION['sessionID'];
    $maxsize = 3000000;
    try {
        if($_FILES['user_photo']['error']==UPLOAD_ERR_OK) {

            //check whether file is uploaded with HTTP POST
            if(is_uploaded_file($_FILES['user_photo']['tmp_name'])) {   

                //checks size of uploaded image on server side
                if( $_FILES['user_photo']['size'] < $maxsize) {  
  
                    //checks whether uploaded file is of image type
                    //if(strpos(mime_content_type($_FILES['user_photo']['tmp_name']),"image")===0) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    if(strpos(finfo_file($finfo, $_FILES['user_photo']['tmp_name']),"image")===0) {    

                        // prepare the image for insertion
                        $imgData = file_get_contents($_FILES['user_photo']['tmp_name']);

                        // put the image in the db...
                        $sql = "INSERT INTO user_photos (user_id, content) VALUES (?, ?) ON DUPLICATE KEY UPDATE content=VALUES(content);";
                        $stmt = $db->prepare($sql);
                        $stmt->bind_param("is", $user_id, $imgData);
                        if(!$stmt->execute()) {
                            $msg = "Insert Failed: " . $stmt->errno . " " . $stmt->error;
                        } else {
                            $msg = "Success";
                        }

                    }else{
                        $msg = "Sorry, that file is not an image";
                    }
                }else{
                    $msg = "Sorry, that file is too large. The maximum file size is " . $maxsize/1000000 . "megabytes.";
                }
            }else{
                $msg = "File upload unsuccessful.";
            }
        }else{
            switch($_FILES['user_photo']['error']){
                case UPLOAD_ERR_INI_SIZE:
                    $msg = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                case UPLOAD_ERR_FORM_SIZE:
                    $msg = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                case UPLOAD_ERR_PARTIAL:
                    $msg = 'The uploaded file was only partially uploaded';
                case UPLOAD_ERR_NO_FILE:
                    $msg = 'No file was uploaded';
                case UPLOAD_ERR_NO_TMP_DIR:
                    $msg = 'Missing a temporary folder';
                case UPLOAD_ERR_CANT_WRITE:
                    $msg = 'Failed to write file to disk';
                case UPLOAD_ERR_EXTENSION:
                    $msg = 'File upload stopped by extension';
                default:
                    $msg = 'Unknown upload error';
            }
        }
        echo $msg;
    } catch (Exception $e){
        echo $e->getMessage();
        echo "Sorry, the file could not be uploaded";
    }
}
