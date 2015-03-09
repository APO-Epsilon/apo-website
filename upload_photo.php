<?php
require_once ('session.php');
require_once ('mysql_access.php');
require_once ('get_photo.php');
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
function cropPhoto(){
    include('mysql_access.php');
    $user_id = $_SESSION['sessionID'];
    $photo = new Imagick();
    $sql = "SELECT content FROM user_photos WHERE user_id=$user_id;";
    $result = $db->query($sql);
    $imageBlobArray = mysqli_fetch_array($result);
    $imageBlob = $imageBlobArray['content'];
    $photo->readImageBlob($imageBlob);
    $photo->rotateImage(new ImagickPixel(), $_POST['angle']);
    $width = $photo->getImageWidth();
    $newWidth = round($width*$_POST['scale']);
    $height = $photo->getImageHeight();
    $newHeight = round($height*$_POST['scale']);
    $photo->resizeImage($newWidth, $newHeight, Imagick::FILTER_GAUSSIAN, 1);
    $photo->cropImage($_POST['w'], $_POST['h'], $_POST['x'], $_POST['y']);
    $output = $photo->getImageBlob();
    $output = $db->real_escape_string($output);
    $sql = "SELECT user_id FROM user_photos WHERE user_id=$user_id;";
    $result = $db->query($sql) or die("Error in query: " . mysqli_error());
    $sql2 = "UPDATE user_photos SET content=\"{$output}\" WHERE user_id=$user_id;";
    $db->query($sql2) or die("Error in query: " . mysqli_error($db));

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

function showCrop(){
    $photolink = getPhotoLink($_SESSION['sessionID']);
    $page = $_SERVER['PHP_SELF'];
    echo <<<END
    <div class="medium-6 small-12 columns">
        <h3>Current Photo</h3>
        <link href='/js/guillotine/css/jquery.guillotine.css' media='all' rel='stylesheet'>
    <div id='content'>
    <div class='frame'>
      <img id='sample_picture' src='$photolink'>
    </div>

    <div class="icon-bar five-up" id='controls'>
      <a class="item" id='rotate_left' title='Rotate left'><i class="fa fa-undo"></i></a>
      <a class="item" id='zoom_out' title='Zoom out'><i class="fa fa-search-minus"></i></a>
      <a class="item" id='fit' title='Fit image'><i class="fa fa-arrows-alt"></i></a>
      <a class="item" id='zoom_in' title='Zoom in'><i class="fa fa-search-plus"></i></a>
      <a class="item" id='rotate_right' title='Rotate right'><i class="fa fa-repeat"></i></a>
    </div>

    <form id="guillotineValues" action="$page" method="POST">
        <input type="hidden" id="x" name="x" />
        <input type="hidden" id="y" name="y" />
        <input type="hidden" id="w" name="w" />
        <input type="hidden" id="h" name="h" />
        <input type="hidden" id="scale" name="scale" />
        <input type="hidden" id="angle" name="angle" />
    </form>
    <br>
    <div class="row">
        <div class="small-12 columns small-centered">
            <button class="expand" onclick="submitGuillotine()">Save Cropping</button>
        </div>
    </div>
    </div>
    </div>

  <script src='/js/vendor/jquery.js'></script>
  <script src='/js/guillotine/js/jquery.guillotine.js'></script>
  <script type='text/javascript'>
    var picture;
    jQuery(function() {
      picture = $('#sample_picture');
      picture.one('load', function(){
        // Initialize plugin (with custom event)
        picture.guillotine({height: 400, width: 300});

        // Bind button actions
        $('#rotate_left').click(function(){ picture.guillotine('rotateLeft'); });
        $('#rotate_right').click(function(){ picture.guillotine('rotateRight'); });
        $('#fit').click(function(){ picture.guillotine('fit'); });
        $('#zoom_in').click(function(){ picture.guillotine('zoomIn'); });
        $('#zoom_out').click(function(){ picture.guillotine('zoomOut'); });
      }).each(function() {
        if(this.complete) $(this).load();
      });
    });
  </script>
  <script type="text/javascript">
    function submitGuillotine(){
        var data = picture.guillotine("getData");
        document.getElementById("x").value = data["x"];
        document.getElementById("y").value = data["y"];
        document.getElementById("w").value = data["w"];
        document.getElementById("h").value = data["h"];
        document.getElementById("scale").value = data["scale"];
        document.getElementById("angle").value = data["angle"];
        document.getElementById("guillotineValues").submit();
       }
   </script>
END;
}

function uploadForm(){
    $page = $_SERVER['PHP_SELF'];
    echo <<<END
    <div class="small-12 columns">
        <h2>Upload your user photo.</h2>
    </div>
    <div class="medium-6 small-12 columns end">
        <form enctype="multipart/form-data" action="$page" method="post">
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
            <input name="userfile" type="file" /> <br><br>
            <input type="submit" class="button" value="Submit" />
        </form>
    </div>
END;
}

if(!isset($_SESSION['sessionID'])){
    echo "<p>You must sign in to view this page.</p>";
}else{
    if(isset($_FILES['userfile'])){
        processForm();
    }elseif (isset($_POST['x'])) {
        cropPhoto();
    }
    uploadForm();
    $sql = "SELECT user_id FROM user_photos WHERE user_id={$_SESSION['sessionID']};";
    $result = $db->query($sql) or die("Error in query: " . mysqli_error());
    if(mysqli_num_rows($result) != 0){
        showCrop();
    }
}
?>

        </div>
    </div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
