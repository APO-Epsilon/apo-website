<?php
require_once ('session.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <nav id="nav" role="navigation"></nav>
    <div id="header"></div>

<div class="row">
<?php 

$exec_page = False;
$active_page = True;
$public_page = False;
require_once('permissions.php');

function show_active() {
	include('mysql_access.php');
	//Generate a dropdown box
	$sql = "SELECT id, lastname, firstname FROM contact_information UNION DISTINCT SELECT id, lastname, firstname FROM alumni UNION DISTINCT SELECT id, lastname, firstname FROM alumni_info ORDER BY lastname ASC;";
	$result = $db->query($sql);
	$dropdown_options = "<option value=\"\"></option>";
	//Add the options to $dropdown_options
	while ($row = mysqli_fetch_array($result)) {
		$dropdown_options .= "<option value=\"{$row['id']}\">{$row['lastname']}, {$row['firstname']}</option>";
	}
	?>
	<div class="small-12 columns text-center">
		<h2>Add Family</h2>
	</div>
	
	<form id="familytreeadd" method="get" action="includes/family_tree_add_ajax.php">
		<div class="medium-6 small-12 columns">
			<h3>Bigs</h3>
			<fieldset>
				<div id="bigs"><!--Big dropdowns added here-->
					<select id="bigselect" name="big-1" autofocus>
						<?php echo $dropdown_options; ?>
					</select>
				</div>
			<button type="button" id="add_big_button">Add Another</button>
			</fieldset>
		</div>
		<div class="medium-6 small-12 columns">
			<h3>Littles</h3>
			<fieldset>
				<div id="littles"><!--Little dropdowns added here-->
					<select id="littleselect" name="little-1">
	 					<?php echo $dropdown_options ?>
					</select>
				</div>
			<button type="button" id="add_little_button">Add Another</button>
			</fieldset>
		</div>
		<div class="small-6 columns">
			<input type="submit" class="button expand" value="Submit"/>
		</div>
	</form>
	<div class="small-12 columns">
		<h3>Results</h3>
		<div id="add_results"></div><!-- Results get added in this div -->
	</div>
	<!-- This script requires jQuery. It is currently included on every page, but make sure to include it should that change -->
	<script>
		$(document).ready(function() {
			//Keep track of how many we add
			big_count = 2;
			little_count = 2;
			//Catch the submit and perform our ajax call instead
			$("#familytreeadd").submit(function() {
				$.ajax({
					data: $(this).serialize(),
					type: $(this).attr('method'),
					url: $(this).attr('action'),
					success: function(response) {
						$("#add_results").html(response); //Put our results in the result div
					}
				});
				return false;
			});
		});
		
		function add_big_select() {
			//Add a big select box
			var id = 'big-' + big_count;
			var big_input = $("#bigselect").clone();
			big_input.attr('id', id);
			big_input.attr('name', id);
			$("#bigs").append("<br>");
			$("#bigs").append(big_input);
			$("#" + id).focus();
			big_count += 1;
		}

		function add_little_select() {
			//Add a little select box
			id = 'little-' + little_count;
			var little_input = $("#littleselect").clone();
			little_input.attr('id', id);
			little_input.attr('name', id);
			$("#littles").append("<br>");
			$("#littles").append(little_input);
			$("#" + id).focus();
			little_count += 1;
		}

		//When our add big button is clicked, call the above function
		$("#add_big_button").on("click", function() {
			add_big_select();
		});

		//When our add little button is clicked, call the above function
		$("#add_little_button").on("click", function() {
			add_little_select();
		});

	</script>
<?php
}
?>
    </div>
    <div id="footer"></div>
</body>
</html>
