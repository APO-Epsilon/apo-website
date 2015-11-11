<?php
require_once ('session.php');
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
    function show_exec() {
        //Let's get a whole bunch of data
        include('../mysql_access.php');
        //Let's count all the registrants
        $sql = "SELECT COUNT(*) AS num_reg FROM conf_contact_information;";
        $result = $db->query($sql);
        $row = mysqli_fetch_assoc($result);
        $num_reg = $row['num_reg'];

        //Summarize those T-Shirt sizes
        $sql = "SELECT shirt, COUNT(id) AS num_shirts FROM conf_contact_information GROUP BY shirt ORDER BY FIELD(shirt, 'S', 'M', 'L', 'XL', '2XL', '3XL');";
        $result = $db->query($sql);
        $shirt_sizes = "<p>";
        $shirt_data = "";
        while($row = mysqli_fetch_assoc($result)) {
            $shirt_sizes .= $row['shirt'] . ": " . $row['num_shirts'] . "<br>";
            $shirt_data .= "{'shirtsize': '" . $row['shirt'] . "', 'Number of Shirts Ordered': " . $row['num_shirts'] . "},\n";
        }
        $shirt_sizes .= "</p>";
        $shirt_data = rtrim($shirt_data, ",\n");

        //Who needs housing?
        $sql = "SELECT housing, COUNT(id) AS num_housing FROM conf_contact_information GROUP BY housing ORDER BY housing DESC;";
        $result = $db->query($sql);
        $housing = "<p>";
        $housing_data = "";
        while($row = mysqli_fetch_assoc($result)) {
            $housing .= $row['housing'] . ": " . $row['num_housing'] . "<br>";
            $housing_data .= "{'Needs housing': '" . $row['housing'] . "', 'Brothers': " . $row['num_housing'] . "},\n";
        }
        $housing .= "</p>";
        $housing_data = rtrim($housing_data, ",\n");

        //All them chapters coming
        $sql = "SELECT RTRIM(CONCAT(chapter1, ' ', chapter2, ' ', chapter3)) AS chapter, COUNT(id) AS num_chapter FROM conf_contact_information GROUP BY chapter ORDER BY num_chapter DESC;";
        $result = $db->query($sql);
        $chapters = "<p>";
        $chapters_data = "";
        while($row = mysqli_fetch_assoc($result)) {
            $chapters .= $row['chapter'] . ": " . $row['num_chapter'] . "<br>";
            $chapters_data .= "{'Chapter Name': '" . $row['chapter'] . "', 'Number Registered': " . $row['num_chapter'] . "},\n";
        }
        $chapters .= "</p>";
        $chapters_data = rtrim($chapters_data, ",\n");

        //How are y'all paying?
        $sql = "SELECT payment, COUNT(id) as num_paying FROM conf_contact_information GROUP BY payment ORDER BY num_paying DESC;";
        $result = $db->query($sql);
        $payment = "<p>";
        $payment_data = "";
        while($row = mysqli_fetch_assoc($result)) {
            $payment .= $row['payment'] . ": " . $row['num_paying'] . "<br>";
            $payment_data .= "{'Payment Method': '" . $row['payment'] . "', 'Number': " . $row['num_paying'] . "},\n";
        }
        $payment .= "</p>";
        $payment_data = rtrim($payment_data, ",\n");

        //Get all the details
        $sql = "SELECT *, RTRIM(CONCAT(chapter1, ' ', chapter2, ' ', chapter3)) AS chapter, CONCAT('(', tel1, ') ', tel2, '-', tel3) AS phone FROM conf_contact_information ORDER BY id ASC;";
        $result = $db->query($sql);
        $registrants = "";
        while($row = mysqli_fetch_assoc($result)) {
            $registrants .= "<tr><td>" . $row['firstname'] . "</td><td>" . $row['lastname'] . "</td><td>" . $row['email'] . "</td><td>" . $row['phone'] . "</td><td>" . $row['shirt'] . "</td><td>" . $row['allergytext'] . "</td><td>" . $row['housing'] . "</td><td>" . $row['chapter'] . "</td><td>" . $row['payment'] . "</td><td>" . $row['guests'] . "</td></tr>";
        }

        ?>

    <div class="small-12 columns">
        <h1>Registration Summary</h1>
        <h3>Number registered: <?php echo $num_reg; ?></h3>
    </div>
    <div class="medium-6 small-12 columns">
        <h3>Shirt Sizes</h3>
        <div id="shirtdiv" style="height: 30%;"></div>
        <?php echo $shirt_sizes; ?>
    </div>
    <div class="medium-6 small-12 columns">
        <h3>Brother Housing</h3>
        <div id="housingdiv" style="height: 30%;"></div>
        <?php echo $housing; ?>
    </div>
</div>
<div class="row">
    <div class="medium-6 small-12 columns">
        <h3>Chapters</h3>
        <div id="chapterdiv" style="height: 30%;"></div>
        <?php echo $chapters; ?>
    </div>
    <div class="medium-6 small-12 columns">
        <h3>Payment Summary</h3>
        <div id="paymentdiv" style="height: 30%;"></div>
        <?php echo $payment; ?>
    </div>
</div>
<div class="row">
    <div class="small-12 columns">
        <h3>Registrants</h3>
        <table>
        	<tr>
        		<th>First Name</th>
        		<th>Last Name</th>
        		<th>Email</th>
        		<th>Phone Number</th>
        		<th>Shirt Size</th>
        		<th>Allergies</th>
        		<th>Brother Housing</th>
        		<th>Chapter</th>
        		<th>Payment</th>
        		<th>Guests</th>
    		</tr>
    		<?php echo $registrants; ?>
		</table>
    </div>

    <script src="/js/d3/d3.min.js"></script>
    <script src="/js/d3plus/d3plus.min.js"></script>
    <script>

        var shirtdata = [
            <?php echo $shirt_data; ?>
        ]

        var housingdata = [
        	<?php echo $housing_data; ?>
        ]

        var chapterdata = [
        	<?php echo $chapters_data; ?>
        ]

        var paymentdata = [
        	<?php echo $payment_data; ?>
        ]

        var shirtvisualization = d3plus.viz()
            .container("#shirtdiv")
            .data(shirtdata)
            .type("bar")
            .id("shirtsize")
            .x({"value": "shirtsize", "grid": false, "ticks": {"size": 0}, "label": "Shirts"})
            .y({"value": "Number of Shirts Ordered"})
            .title("Shirt Sizes")
            .draw()

        var housingvisualization = d3plus.viz()
            .container("#housingdiv")
            .data(housingdata)
            .type("pie")
            .id("Needs housing")
            .size("Brothers")
            .title("Brother Housing")
            .draw()

        var chaptervisualization = d3plus.viz()
            .container("#chapterdiv")
            .data(chapterdata)
            .type("bar")
            .id("Chapter Name")
            .x({"value": "Chapter Name", "grid": false, "ticks": {"size": 0}})
            .y({"value": "Number Registered"})
            .title("Chapter Registrations")
            .draw()

        var paymentvisualization = d3plus.viz()
            .container("#paymentdiv")
            .data(paymentdata)
            .type("pie")
            .id("Payment Method")
            .size("Number")
            .title("Payment Method")
            .draw()

    </script>

        <?php
    }
    
    function show_public() {
        ?>

    <div class="small-12 columns">
        <h1>Oops</h1>
        <p>It appears that you're in the wrong place. This page is only for the Conference Chair</p>
    </div>

        <?php
    }
    
    $exec_page = True;
    $active_page = False;
    $public_page = True;
    require_once('permissions.php');

?>

</div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
