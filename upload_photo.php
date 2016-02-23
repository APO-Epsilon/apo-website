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
function show_active(){
    //Start loading external resources
    ?>
    <script src='/js/foundation/foundation.js'></script>
    <script src='/js/foundation/foundation.reveal.js'></script>
    <script src='/js/guillotine/js/jquery.guillotine.js'></script>
    <script src="/js/Hermite-resize/hermite.js"></script>
    <script src="/js/StackBlur/dist/stackblur.min.js"></script>
    <link href='/js/guillotine/css/jquery.guillotine.css' media='all' rel='stylesheet'>

    <div class="small-12 columns">
        <h2 class="text-center">Upload a User Photo</h2>
    </div>
</div>
<div id="upload_form">
    <div class="row">
        <div class="small-4 small-centered columns" id="file_div">
            <form enctype="multipart/form-data" action="#" method="post">
                <input id="userfile" name="userfile" type="file" accept="image/*" onchange="readImageFile(this)" /> <br><br>
            </form>
         </div>
    </div>
</div>
<?php
//Show our current user photo, if we have one
include('mysql_access.php');
$sql = "SELECT user_id FROM user_photos WHERE user_id={$_SESSION['sessionID']};";
$result = $db->query($sql) or die("Error in query: " . mysqli_error());
if(mysqli_num_rows($result) != 0){
    $photolink = getPhotoLink($_SESSION['sessionID']);
    ?>
<div id="current_photo_div">
    <div class="row">
        <div class="small-6 small-centered columns">
            <h3>Your Current Photo</h3>
            <img id='current_photo' src='<?php echo $photolink; ?>' width="100%">
        </div>
    </div>
</div>
    <?php
}
?>
<div id='crop_div' style="display:none;">
    <div class="row">
        <div class="small-6 small-centered columns">
            <h3>Crop Your Photo</h3>
            <div id='content'>
                <div class='frame'>
                  <img id='sample_picture' src='#'>
                </div>

                <div class="icon-bar five-up" id='controls'>
                  <a class="item" id='rotate_left' title='Rotate left'><i class="fa fa-undo"></i></a>
                  <a class="item" id='zoom_out' title='Zoom out'><i class="fa fa-search-minus"></i></a>
                  <a class="item" id='fit' title='Fit image'><i class="fa fa-arrows-alt"></i></a>
                  <a class="item" id='zoom_in' title='Zoom in'><i class="fa fa-search-plus"></i></a>
                  <a class="item" id='rotate_right' title='Rotate right'><i class="fa fa-repeat"></i></a>
                </div>

                <div class="row">
                    <div class="small-12 columns small-centered">
                        <button id="crop_button" class="expand" onclick="showCropModal()">Save Cropping</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="crop_modal" class="reveal-modal" data-reveal role="dialog" data-options="close_on_background_click:false; close_on_esc:false;">
    <div class="row">
        <div class="small-3 columns">&nbsp;</div>
        <div class="small-9 columns">
            <h3 id="crop_heading">Cropping your photo</h3>
            <p id="crop_info">Step 0: Initializing Cropping Process</p>
        </div>
        <div class="small-12 columns">
            <div id="crop_canvas_div" style="margin: 0px auto; text-align: center;"></div>
        </div>
    </div>
</div>
<div class="row">
<script>
    //Test for HTML5 canvas support
    var canvas_support = !!document.createElement("canvas").getContext;
    if (!canvas_support) {
        //Remove the image upload ability if no canvas support
        document.getElementById("file_div").innerHTML("<p>Sorry, this browser does not support the HTML5 canvas and as such cannot be used to upload a user photo. Please try again using a newer web browser</p>");
    } else {
        //Make our reveal modal work
        $(document).foundation();
        //Make the cropping not start until the modal is fully open
        $(document).on('opened.fndtn.reveal', '[data-reveal]', function() { startCrop(); });
    }
</script>
<script type='text/javascript'>
    //Set up Guillotine
    var picture;
    function startGuillotine() {
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
    }
</script>
<script type='text/javascript'>
    //Grab our picture when selected, put it in Guillotine, hide our old picture, show Guillotine
    function readImageFile(fileInput) {
        var files = fileInput.files;
        for (var i = 0; i < files.length; i++) {           
            var file = files[i];
            var imageType = /image.*/;     
            if (!file.type.match(imageType)) {
                continue;
            }           
            var img = document.getElementById("sample_picture");            
            img.file = file;    
            var reader = new FileReader();
            reader.onload = (function(aImg) { 
                return function(e) { 
                    aImg.src = e.target.result;
                    startGuillotine();
                }; 
            })(img);
            reader.readAsDataURL(file);
        }

        document.getElementById("crop_div").style.display = "block";
        document.getElementById("current_photo_div").style.display = "none";
        document.getElementById("upload_form").style.display = "none";
    }
</script>
<script>
    function showCropModal() {
        document.getElementById('crop_button').innerHTML = 'Working...';
        $('#crop_modal').foundation('reveal', 'open');
    }

    //This is where the cropping magic (hopefully) happens
    function startCrop() {
        document.getElementById('crop_info').innerHTML = 'Step 0.1: Create Canvas';
        document.getElementById('crop_canvas_div').innerHTML = "<canvas id='crop_canvas'></div>";
        var my_canvas = document.getElementById('crop_canvas');
        
        document.getElementById('crop_info').innerHTML = 'Step 0.2: Get Image';
        var my_canvas_context = my_canvas.getContext('2d');
        var canvas_image = new Image();
        canvas_image.src = document.getElementById('sample_picture').src;
        
        document.getElementById('crop_info').innerHTML = 'Step 1: Rotate Image';
        var data = picture.guillotine("getData");
        var x = data["x"];
        var y = data["y"];
        var w = data["w"];
        var h = data["h"];
        var scale = data["scale"];
        var angle = data["angle"];

        //Rotation code from http://www.ajaxblender.com/howto-rotate-image-using-javascript-canvas.html            
        var cw = canvas_image.width, ch = canvas_image.height, cx = 0, cy = 0;

        switch(angle){
            case 90:
                cw = canvas_image.height;
                ch = canvas_image.width;
                cy = canvas_image.height * (-1);
                break;
            case 180:
                cx = canvas_image.width * (-1);
                cy = canvas_image.height * (-1);
                break;
            case 270:
                cw = canvas_image.height;
                ch = canvas_image.width;
                cx = canvas_image.width * (-1);
                break;
        }

        document.getElementById('crop_info').innerHTML = 'Step 1.1: Draw Rotated Image to Canvas';

        my_canvas.width = cw;
        my_canvas.height = ch;
        my_canvas_context.rotate(angle * Math.PI / 180);
        my_canvas_context.drawImage(canvas_image, cx, cy);

        document.getElementById('crop_info').innerHTML = 'Step 2: Resize Image with Hermite-Resize';

        var hermi = Hermite.init('/js/Hermite-resize/hermite-worker.js');

        console.log("x " + x);
        console.log("y " + y);
        console.log("w " + w);
        console.log("h " + h);
        console.log("angle " + angle);
        console.log("scale " + scale);

        var hermiteWidth = my_canvas.width * scale;
        var hermiteHeight = my_canvas.height * scale;

        hermi.resize({
            source: document.getElementById('crop_canvas'),
            width: hermiteWidth,
            height: hermiteHeight,
            }, function(){
                document.getElementById('crop_info').innerHTML = 'Step 3: Crop Image to Size';
                var canvas_image = new Image();
                canvas_image.onload = function() {
                    my_canvas.width = w;
                    my_canvas.height = h;
                    my_canvas_context.drawImage(canvas_image, x, y, w, h, 0, 0, w, h);
                    if (scale > 1) {
                        document.getElementById('crop_info').innerHTML = 'Step 4: Add Blur to Enlarged Photo with StackBlur';
                        StackBlur.canvasRGB(my_canvas, 0, 0, w, h, 2);
                    }
                    document.getElementById('crop_heading').innerHTML = 'Crop Complete!';
                    document.getElementById('crop_info').innerHTML = 'Uploading Photo to Server';
                    submitPhoto();
                }
                canvas_image.src = my_canvas.toDataURL();
            }
        ); 
    }

    function dataURItoBlob(dataURI) {
        //A little help from http://stackoverflow.com/questions/4998908/convert-data-uri-to-file-then-append-to-formdata
        // convert base64/URLEncoded data component to raw binary data held in a string
        var byteString;
        if (dataURI.split(',')[0].indexOf('base64') >= 0)
            byteString = atob(dataURI.split(',')[1]);
        else
            byteString = unescape(dataURI.split(',')[1]);

        // separate out the mime component
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

        // write the bytes of the string to a typed array
        var ia = new Uint8Array(byteString.length);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        return new Blob([ia], {type:mimeString});
    }

    function submitPhoto() {
        var photoB64 = document.getElementById('crop_canvas').toDataURL('image/jpeg');
        var photoBlob = dataURItoBlob(photoB64);
        fd = new FormData();
        fd.append("user_photo", photoBlob);
        $.ajax({
            data: fd,
            type: 'POST',
            url: 'includes/upload_photo_process.php',
            cache: false,
            processData: false,
            contentType: false,
            success: function(response) {
                //If login was unsuccessful
                if (response == "Success") {
                    $("#crop_info").html("Photo Successfully Updated");
                } else {
                    $("#crop_info").html("Oops, something went wrong. Please refresh the page and try again. Error message: " + response);
                }
            },
            error: function(jqXHR, exception) {
                //If the AJAX call can't reach the login process
                if (jqXHR.status === 0) {
                    $("#crop_info").html('Oops, something is wrong with connection. Error message: Unable to connect to the network');
                } else if (jqXHR.status == 404) {
                    $("#crop_info").html('Oops, something is wrong with connection. Error message: Requested page not found [404]');
                } else if (jqXHR.status == 500) {
                    $("#crop_info").html('Oops, something is wrong with connection. Error message: Internal Server Error [500]');
                } else if (exception === 'parsererror') {
                    $("#crop_info").html('Oops, something is wrong with connection. Error message: Requested JSON parse failed');
                } else if (exception === 'timeout') {
                    $("#crop_info").html('Oops, something is wrong with connection. Error message: Time out error');
                } else if (exception === 'abort') {
                    $("#crop_info").html('Oops, something is wrong with connection. Error message: Ajax request aborted');
                } else {
                    $("#crop_info").html('Uncaught Error.\n' + jqXHR.responseText);
                }
            }
        });
    }

</script>

<?php
}

$exec_page = false;
$active_page = true;
$public_page = false;
require_once('permissions.php');

?>

    </div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
