<?php
require_once ('session.php');
require_once ('mysql_access.php');
//Code based on example at https://vikasmahajan.wordpress.com/2010/07/07/inserting-and-displaying-images-in-mysql-using-php/
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->

    <div class="row">

<?php
function uploadForm(){
    $page = $_SERVER['PHP_SELF'];
    echo <<<END
    <div class="small-12 columns">
        <h2>Upload your user photo.</h2>
    </div>
    <div class="small-12 columns">
        <form enctype="multipart/form-data" action="$page" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
        <input name="userfile" type="file" />
        <input type="submit" value="Submit" />
        </form>
    </div>
END;
}
function processForm(){
    include('mysql_access.php');
    $maxsize = $_POST['MAX_FILE_SIZE'];
    $user_id = $_SESSION['sessionID'];
    echo "<div class=\"small-12 columns\"><p>";
    try {
        if($_FILES['userfile']['error']==UPLOAD_ERR_OK) {

            //check whether file is uploaded with HTTP POST
            if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {   

                //checks size of uploaded image on server side
                if( $_FILES['userfile']['size'] < $maxsize) {  
  
                    //checks whether uploaded file is of image type
                    //if(strpos(mime_content_type($_FILES['userfile']['tmp_name']),"image")===0) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    if(strpos(finfo_file($finfo, $_FILES['userfile']['tmp_name']),"image")===0) {    

                        // prepare the image for insertion
                        $imgData =addslashes (file_get_contents($_FILES['userfile']['tmp_name']));

                        // put the image in the db...
                        $sql = "SELECT user_id FROM user_photos WHERE user_id=$user_id;";
                        $result = $db->query($sql) or die("Error in query: " . mysqli_error());
                        if(mysqli_num_rows($result) != 0){
                            $sql2 = "UPDATE user_photos SET content=\"{$imgData}\" WHERE user_id=$user_id;";
                            $db->query($sql2) or die("Error in query: " . mysqli_error());
                            $msg = "Image successfully updated!";
                        }else{
                            $sql = "INSERT INTO user_photos (user_id, content) VALUES ('{$user_id}', '{$imgData}');";
                            $db->query($sql) or die("Error in query: " . mysqli_error());
                            $msg = "Image successfully saved!";
                        }
                    }else{
                        $msg = "Sorry, that file is not an image";
                    }
                }else{
                    $msg = "Sorry, that file is too large. The maximum file size is " . $maxsize . "bytes.";
                }
            }else{
                $msg = "File upload unsuccessful.";
            }
        }else{
            switch($_FILES['userfile']['error']){
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
    echo "</p></div>";

}

if(!isset($_SESSION['sessionID'])){
    echo "<p>You must sign in to view this page.</p>";
}else{
    if(isset($_FILES['userfile'])){
        processForm();
    }
    uploadForm();
}
?>

        </div>
    </div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
