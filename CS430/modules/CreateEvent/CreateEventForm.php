<?php
require_once('module.php');
$Header = new header();
$include = array();
$include[] = '<link rel="stylesheet" type="text/css" href="http://apo.truman.edu/CS430/includes/bootstrap/css/bootstrap.min.css"/>';
$include[] = '<link rel="stylesheet" type="text/css" href="http://apo.truman.edu/CS430/includes/bootstrap/css/bootstrap-response.min.css"/>';
$include[] = '<link rel="stylesheet" type="text/css" href="http://apo.truman.edu/CS430/modules/CreateEvent/CreateEventForm.css"/>';
$include[] = '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
$Header->head($include);

?>
	<form class="well form-inline">  
  <input type="text" class="input-small" placeholder="Email">  
  <input type="password" class="input-small" placeholder="Password">  
  <label class="checkbox">  
    <input type="checkbox"> Remember me  
  </label>  
  <button type="submit" class="btn">Sign in</button>  
</form>  




    <div class="container">

      <form class="form-horizontal">
	    <fieldset>
	      <div id="legend" class="">
	        <legend class="">Create Event</legend>
	      </div>
	    <div class="control-group">
          <!-- Text input-->
          <label class="control-label" for="input01">Event Name</label>
          <div class="controls">
            <input type="text" placeholder="" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>
    <div class="control-group">
          <!-- Text input-->
          <label class="control-label" for="input01">Location</label>
          <div class="controls">
            <input type="text" placeholder="" class="input-xlarge">
            <p class="help-block">The meeting location</p>
          </div>
        </div><div class="control-group">

          <!-- Textarea -->
          <label class="control-label">Description</label>
          <div class="controls">
            <div class="textarea">
                  <textarea type="" class=""> </textarea>
            </div>
          </div>
        </div>
    <div class="control-group">
          <!-- Textarea -->
          <label class="control-label">Notes</label>
          <div class="controls">
            <div class="textarea">
                  <textarea type="" class=""> </textarea>
            </div>
          </div>
        </div>

    </fieldset>
    <button class="btn btn-large btn-primary" type="submit">create</button>
  </form>


    </div> <!-- /container -->

<?php
new footer();
