<?php
require_once ('session.php');
require_once ('mysql_access.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body>
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->

<?php
print_r($_POST);
global $current_semester;
echo("<div class=\"row\">");
//0 => not under development, 1 => under development.
$dev = 0;

//This function processes the create new event form.
function process_new()
{
    $name = $_POST['name'];
    $worth = $_POST['worth'];
    $current_semester = $_POST['semester'];
    $sql = "INSERT INTO `apo`.`events`
            (name, worth) VALUES ('".$name."',
            '".$worth."')";
        $result = mysql_query($sql);
            if(!$result)
                {
                    echo("An error occurred, please contact the webmaster");
                }else{
                    echo("The event has been added.");
                }
}

//This function displays the create new event form.
function display_create_form($active_semester){

echo
<<<END
    <form method="post" action="$_SERVER[PHP_SELF]" id="create">
        <fieldset>
             <legend>Create Event:</legend>
                <p>Please fill this out to create a new event.</p>
                Name:<br/><input type="text" name="name"/><p>
                Absence Value<br/><input type="number" min="0.0" max="5.0" step="0.5" name="worth"/><p>
                <br/><p><p>
                <input type="hidden" name="semester" value="$active_semester"/>
                <input type="hidden" name="new" value="process"/>
                <input type="submit" form="create"/>
        </fieldset>
    </form>
END;
        $sql = "SELECT * FROM `apo`.`events`";
        $result = mysql_query($sql);
        $num_rows = mysql_num_rows($result);
echo
<<<END
        <fieldset>
            <legend>Events already added:</legend>
            <p>These is/are $num_rows event(s) already added to the database</p>
END;
            while($row = mysql_fetch_array($result)){
                echo($row['name']."<br/>");
            }
        echo("</fieldset>");
}

function display_add_form($active_semester){

    $sql = "SELECT * FROM `apo`.`events`";
    $result = mysql_query($sql);
        if($result){

            echo ("<form action='".$_SERVER['PHP_SELF']."' method='post'>");
?>
                <fieldset>
                    <legend>Assign an Event:</legend>
                    <p>Please fill this out to add a new event.</p>
                    Name:<br/>
                    <select name="name">
                        <option value="NULL">Select one...</option>
<?php
                        while($row = mysql_fetch_array($result)){
                            echo ("<option value=\"".$row['name']."\">".$row['name']."</option>");
                        }
?>

                    </select><br/>
                    Date:<br/>
                    <select name="month">
                        <option value="NULL"></option>
                        <option value="01">Jan</option>
                        <option value="02">Feb</option>
                        <option value="03">Mar</option>
                        <option value="04">Apr</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">Aug</option>
                        <option value="09">Sep</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>
                    <select name="day">
                        <option value="NULL"></option>
                        <option value="01">1</option>
                        <option value="02">2</option>
                        <option value="03">3</option>
                        <option value="04">4</option>
                        <option value="05">5</option>
                        <option value="06">6</option>
                        <option value="07">7</option>
                        <option value="08">8</option>
                        <option value="09">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select><br/>
                    <select name="year">
                        <option value="NULL"></option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                    </select><p>
                    Type of event?<br/>
                    <select name="type">
                        <option value="NULL">Select one...</option>
                        <option value="All">All Chapter</option>
                        <option value="Exec">Exec ONLY</option>
                        <!--<option value="Committee">Committee</option>
                        <option value="Active">Active ONLY</option>
                        <option value="Pledge">Pledge ONLY</option>
                        <option value="Broho">Broho</option>-->
                        <option value="Trial">Trial</option>
                    </select><p>
                <input type="hidden" name="add" value="process"/>
                <input type="submit"/>
            </fieldset>
        </form>
<?php
}else{echo("bad sql".mysql_error());}
}

function process_add(){//A.K.A. FUNCTION BITCH()
    $name = $_POST['name'];
    $day = $_POST['day'];
    $year = $_POST['year'];
    $month = $_POST['month'];
    $type = $_POST['type'];

    //if the user didn't fill out any of the elements, make them start over.
    if(($name == 'NULL')||($day == 'NULL')||($month == 'NULL')||($year == 'NULL')||($type == 'NULL')){
        die("you didn't fill the form out correctly, please start over");
        ?>
            <a href="http://apo.truman.edu/attendance_admin.php">reset</a>
        <?php
    }

    //the date of the event in occurrence table
    $date = date("Y-m-d", mktime(0,0,0,$month,$day,$year));

    //lets delete ones that are older than a year
    //$condition = time() - (365 * 24 * 60 * 60);

    //successful insert. Creates the occurrence with date! 10/10/12
    $sql = "INSERT INTO `apo`.`occurrence` (e_id, date, type)
            VALUES ((SELECT e_id FROM `apo`.`events` WHERE name = '".$name."'), '".$date."','".$type."')";

    $result= mysql_query($sql);

        if($result){
            echo("successful<br/>");
            echo("An event was added for: ".$date);
        }else{
            die("error".mysql_error());
        }

    //now create the entries for each individual
    //we have to select the e_id of the event we just created & also
    //iterate over every individual from the contact_information table..
    $sql = "SELECT e_id FROM `apo`.`events` WHERE name = '".$name."' LIMIT 1";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $e_id = $row['e_id'];
        }
    $sql = "SELECT MAX(id) AS id FROM `apo`.`occurrence` WHERE e_id = '".$e_id."'";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $id = $row['id'];
        }

    //using $type... set the WHERE clause for the following SQL statement.
    if($type == 'Pledge'){
        $WHERE = "status = 'Pledge'";
    }elseif($type == 'Active'){
        $WHERE = "status != 'Alumni' AND status != 'Inactive' AND status != 'Advisor' AND status != 'Pledge'";
    }elseif($type == 'Exec'){
        $WHERE = "status = 'Elected' OR status = 'Appointed'";
    }elseif($type == 'Committee'){
        $WHERE = "status != 'Alumni' AND status != 'Inactive' AND status != 'Advisor'";
    }elseif($type == 'Broho'){
        $WHERE = "status != 'Alumni' AND status != 'Inactive' AND status != 'Advisor'";
    }elseif($type == 'All'){
        $WHERE = "status != 'Alumni' AND status != 'Inactive' AND status != 'Advisor' AND status != 'Pledge'";
    }elseif($type == 'Trial'){
        $WHERE = "id = 378";
    }

    $WHERE_ALL = " (lastname = 'Alderson' AND firstname = 'Emily') OR
(lastname = 'Atchley' AND firstname = 'Rebecca') OR
(lastname = 'Baharaeen' AND firstname = 'Renee') OR
(lastname = 'Banze' AND firstname = 'Ashley') OR
(lastname = 'Barczykowski' AND firstname = 'Aimee') OR
(lastname = 'Barry' AND firstname = 'Riley') OR
(lastname = 'Bavery' AND firstname = 'Erin ') OR
(lastname = 'Bayer' AND firstname = 'Justin') OR
(lastname = 'Bayer' AND firstname = 'Katie') OR
(lastname = 'Beers' AND firstname = 'Katie') OR
(lastname = 'Nikki ' AND firstname = 'Bene') OR
(lastname = 'Bess' AND firstname = 'Caitlyn') OR
(lastname = 'Birtley' AND firstname = 'Ashley') OR
(lastname = 'Blakely' AND firstname = 'Karis') OR
(lastname = 'Bode' AND firstname = 'Christina ') OR
(lastname = 'Bright' AND firstname = 'Joshua') OR
(lastname = 'Bueckendorf' AND firstname = 'Grace') OR
(lastname = 'Bulczak' AND firstname = 'Nicole') OR
(lastname = 'Burnitt-Erp' AND firstname = 'Jazmyn') OR
(lastname = 'Calhoon' AND firstname = 'Allie') OR
(lastname = 'Campbell' AND firstname = 'Devynn') OR
(lastname = 'Capehart' AND firstname = 'Dustin') OR
(lastname = 'Caputa' AND firstname = 'Maria') OR
(lastname = 'Carnahan' AND firstname = 'Mackenzie ') OR
(lastname = 'Cassilly' AND firstname = 'Tommy') OR
(lastname = 'Chau' AND firstname = 'Liz') OR
(lastname = 'Chittum' AND firstname = 'Megan') OR
(lastname = 'Choate' AND firstname = 'Lauren') OR
(lastname = 'Clayton' AND firstname = 'Megan') OR
(lastname = 'Cobb' AND firstname = 'Caitlin') OR
(lastname = 'Cooksey' AND firstname = 'Sarah') OR
(lastname = 'Coulson' AND firstname = 'Mikala') OR
(lastname = 'Craig' AND firstname = 'Lauri') OR
(lastname = 'Crouch' AND firstname = 'Alex') OR
(lastname = 'Cummiskey' AND firstname = 'Carly') OR
(lastname = 'Cunningham' AND firstname = 'Kelly') OR
(lastname = 'Daniel' AND firstname = 'Phillip') OR
(lastname = 'Davies' AND firstname = 'Michelle') OR
(lastname = 'Davis' AND firstname = 'Laura') OR
(lastname = 'Davis' AND firstname = 'Matthew') OR
(lastname = 'Dawson' AND firstname = 'Rani') OR
(lastname = 'DeCoster' AND firstname = 'Katrina') OR
(lastname = 'DeDecker' AND firstname = 'Maggie') OR
(lastname = 'Delware' AND firstname = 'Becky') OR
(lastname = 'Demien' AND firstname = 'Taylor') OR
(lastname = 'DeMoor' AND firstname = 'Anna') OR
(lastname = 'Deneke' AND firstname = 'Jonathan') OR
(lastname = 'DeZeeuw' AND firstname = 'Zane') OR
(lastname = 'Diermann' AND firstname = 'Jessica') OR
(lastname = 'Dismang' AND firstname = 'Nathan') OR
(lastname = 'Dong' AND firstname = 'Ly') OR
(lastname = 'Duesterhaus' AND firstname = 'Sarah') OR
(lastname = 'Dungan' AND firstname = 'Laura') OR
(lastname = 'Elliott' AND firstname = 'Tia') OR
(lastname = 'Ewing' AND firstname = 'Lily') OR
(lastname = 'Fabbri' AND firstname = 'Marissa') OR
(lastname = 'Findley' AND firstname = 'Nicole') OR
(lastname = 'Finnegan' AND firstname = 'Allie') OR
(lastname = 'Fish' AND firstname = 'Nicola') OR
(lastname = 'Frerichs' AND firstname = 'Valerie') OR
(lastname = 'Gehrman' AND firstname = 'Linda') OR
(lastname = 'Gillam' AND firstname = 'Matt') OR
(lastname = 'Glickert' AND firstname = 'Heidi') OR
(lastname = 'Grimsley' AND firstname = 'Kristin') OR
(lastname = 'Hahn' AND firstname = 'Sara') OR
(lastname = 'Halfmann' AND firstname = 'Victoria') OR
(lastname = 'Hall' AND firstname = 'Joe') OR
(lastname = 'Hamera' AND firstname = 'Caroline') OR
(lastname = 'Hamilton' AND firstname = 'Paige') OR
(lastname = 'Harris' AND firstname = 'Conner') OR
(lastname = 'Hartig' AND firstname = 'Jefferson') OR
(lastname = 'Hatting' AND firstname = 'Rose') OR
(lastname = 'Hayes' AND firstname = 'Kate') OR
(lastname = 'Haenni' AND firstname = 'Jamie') OR
(lastname = 'Hill' AND firstname = 'Andrew') OR
(lastname = 'Hoard' AND firstname = 'Daniel') OR
(lastname = 'Hoeglund' AND firstname = 'Alicia') OR
(lastname = 'Hoehn' AND firstname = 'Rachael ') OR
(lastname = 'Hogan' AND firstname = 'Cory') OR
(lastname = 'Holland' AND firstname = 'Chelsea') OR
(lastname = 'Holwick' AND firstname = 'Kristen') OR
(lastname = 'Hoover' AND firstname = 'Trent') OR
(lastname = 'Hughes' AND firstname = 'Matthew') OR
(lastname = 'Hung' AND firstname = 'Kevin') OR
(lastname = 'Hunt' AND firstname = 'Sarrah ') OR
(lastname = 'Janke' AND firstname = 'Liz') OR
(lastname = 'Jenisch' AND firstname = 'Brenna') OR
(lastname = 'Jin' AND firstname = 'Xiaochen') OR
(lastname = 'Johnson' AND firstname = 'Angie') OR
(lastname = 'Johnston' AND firstname = 'Katie') OR
(lastname = 'Jones' AND firstname = 'Kendra') OR
(lastname = 'Jones ' AND firstname = 'Erin ') OR
(lastname = 'Josiah' AND firstname = 'Alyssa') OR
(lastname = 'Karner' AND firstname = 'Matthew') OR
(lastname = 'Katsev' AND firstname = 'Conner') OR
(lastname = 'Kerns' AND firstname = 'Austin') OR
(lastname = 'Ketterer ' AND firstname = 'Danielle ') OR
(lastname = 'Keyes' AND firstname = 'Andrew') OR
(lastname = 'Kickham' AND firstname = 'Allison') OR
(lastname = 'Kleekamp' AND firstname = 'Philip') OR
(lastname = 'Kohl' AND firstname = 'Kristina') OR
(lastname = 'Kompalli' AND firstname = 'Upagya ') OR
(lastname = 'Kuhn' AND firstname = 'Genevieve') OR
(lastname = 'Lanza' AND firstname = 'David') OR
(lastname = 'LaPointe' AND firstname = 'Matthew') OR
(lastname = 'Lee' AND firstname = 'Kelley') OR
(lastname = 'Lee' AND firstname = 'Yewon') OR
(lastname = 'Lemmons' AND firstname = 'Paxton') OR
(lastname = 'Lotz' AND firstname = 'Kaitlyn ') OR
(lastname = 'Lovewell' AND firstname = 'Carnahan ') OR
(lastname = 'Luchtefeld' AND firstname = 'Liz') OR
(lastname = 'Lynch' AND firstname = 'Shannon') OR
(lastname = 'Madden' AND firstname = 'Connor') OR
(lastname = 'Maffitt' AND firstname = 'Zoe') OR
(lastname = 'Maguire' AND firstname = 'Misha') OR
(lastname = 'Mange' AND firstname = 'Megan') OR
(lastname = 'Mausshardt' AND firstname = 'Emily') OR
(lastname = 'McCamon' AND firstname = 'Logan') OR
(lastname = 'McElhone' AND firstname = 'Mary Catherine') OR
(lastname = 'McKinney' AND firstname = 'Kay') OR
(lastname = 'Meier' AND firstname = 'Erin ') OR
(lastname = 'Mengwasser' AND firstname = 'Kelsey') OR
(lastname = 'Miller' AND firstname = 'matt') OR
(lastname = 'Miller' AND firstname = 'Shelby') OR
(lastname = 'Milliano' AND firstname = 'Joe') OR
(lastname = 'Milligan' AND firstname = 'Morgan') OR
(lastname = 'Monti' AND firstname = 'Sophia') OR
(lastname = 'Moran' AND firstname = 'Madeline') OR
(lastname = 'Morrissey' AND firstname = 'Carly') OR
(lastname = 'Moser' AND firstname = 'Libby') OR
(lastname = 'Myers' AND firstname = 'Adam ') OR
(lastname = 'Nelson' AND firstname = 'Taylor') OR
(lastname = 'Nguyen' AND firstname = 'Hazel') OR
(lastname = 'Nguyen' AND firstname = 'An') OR
(lastname = 'Nicholson' AND firstname = 'John') OR
(lastname LIKE '%Brien' AND firstname = 'Xavier') OR
(lastname = 'Olatunde' AND firstname = 'Josh') OR
(lastname = 'Olson' AND firstname = 'Molly') OR
(lastname = 'Pasupuleti' AND firstname = 'Trushna') OR
(lastname = 'Patch' AND firstname = 'Jesse') OR
(lastname = 'Patterson' AND firstname = 'Emma') OR
(lastname = 'Petruska' AND firstname = 'Jackie') OR
(lastname = 'Pham' AND firstname = 'Mai ') OR
(lastname = 'Phillips' AND firstname = 'Abigayle') OR
(lastname = 'Phillips' AND firstname = 'Dylan ') OR
(lastname = 'Popham' AND firstname = 'Greg') OR
(lastname = 'Prost' AND firstname = 'Curtis') OR
(lastname = 'Race' AND firstname = 'Dale') OR
(lastname = 'Raithel' AND firstname = 'Austin') OR
(lastname = 'Ranchel' AND firstname = 'Marissa') OR
(lastname = 'Reiser' AND firstname = 'Alex') OR
(lastname = 'Rempel' AND firstname = 'Brittany') OR
(lastname = 'Rettke' AND firstname = 'Abby') OR
(lastname = 'Rettke' AND firstname = 'Ally') OR
(lastname = 'Revak' AND firstname = 'Rebecca') OR
(lastname = 'Revelle' AND firstname = 'Libby') OR
(lastname = 'Rickert' AND firstname = 'Ashley') OR
(lastname = 'Rigsby' AND firstname = 'Rachel') OR
(lastname = 'Rippe' AND firstname = 'Jennifer') OR
(lastname = 'Rivera' AND firstname = 'Sarah') OR
(lastname = 'Roach' AND firstname = 'David') OR
(lastname = 'Rodriguez' AND firstname = 'Sarah') OR
(lastname = 'Romine' AND firstname = 'Daniel') OR
(lastname = 'Ronan' AND firstname = 'Sadie') OR
(lastname = 'Rodriguez' AND firstname = 'Danika') OR
(lastname = 'Rosen' AND firstname = 'Shayna') OR
(lastname = 'Saale' AND firstname = 'Kristen') OR
(lastname = 'Sandbrink' AND firstname = 'Tom') OR
(lastname = 'Sanders' AND firstname = 'Megan') OR
(lastname = 'Scheulen' AND firstname = 'Nikki') OR
(lastname = 'Schmitz' AND firstname = 'Katie') OR
(lastname = 'Schowengerdt' AND firstname = 'Jessica') OR
(lastname = 'Schulz' AND firstname = 'Taylor') OR
(lastname = 'Schuman' AND firstname = 'Greg') OR
(lastname = 'Schwald' AND firstname = 'Alexis') OR
(lastname = 'Schwartz' AND firstname = 'Elizabeth') OR
(lastname = 'Schwartz' AND firstname = 'Becky') OR
(lastname = 'Self' AND firstname = 'Morgan') OR
(lastname = 'Shearer' AND firstname = 'Tiffany') OR
(lastname = 'Skidmore' AND firstname = 'Whitney') OR
(lastname = 'Smith ' AND firstname = 'Rebecca ') OR
(lastname = 'Smith' AND firstname = 'Brianna') OR
(lastname = 'Spalinger' AND firstname = 'Karli') OR
(lastname = 'Spicer' AND firstname = 'Kathryn') OR
(lastname = 'Stamp' AND firstname = 'Caroline') OR
(lastname = 'Stephenson' AND firstname = 'Austin') OR
(lastname = 'Strange' AND firstname = 'Sammi') OR
(lastname = 'Swingle' AND firstname = 'Rosalie') OR
(lastname = 'Talkington' AND firstname = 'Alyssa') OR
(lastname = 'Tata' AND firstname = 'Spoorthi') OR
(lastname = 'Templeton' AND firstname = 'Callie') OR
(lastname = 'Theis' AND firstname = 'Mariah') OR
(lastname = 'Theobald' AND firstname = 'Ed') OR
(lastname = 'Toal' AND firstname = 'Macy') OR
(lastname = 'Toalson' AND firstname = 'Paula') OR
(lastname = 'Toenjes' AND firstname = 'Daniel') OR
(lastname = 'Townsend' AND firstname = 'Bill') OR
(lastname = 'Tucker' AND firstname = 'Kaitlyn') OR
(lastname = 'Tucker' AND firstname = 'Kevin') OR
(lastname = 'Turner' AND firstname = 'Molly') OR
(lastname = 'Ulmer' AND firstname = 'Rachele') OR
(lastname = 'Vadalabene' AND firstname = 'Rebecca') OR
(lastname = 'Varley' AND firstname = 'Jared') OR
(lastname = 'Villafane' AND firstname = 'Rachel') OR
(lastname = 'Vu' AND firstname = 'Anh') OR
(lastname = 'Walde' AND firstname = 'Charlie') OR
(lastname = 'Walker' AND firstname = 'Brett') OR
(lastname = 'Ward' AND firstname = 'Elizabeth') OR
(lastname = 'Warren' AND firstname = 'KaeCee') OR
(lastname = 'Watkins Davis' AND firstname = 'Andi') OR
(lastname = 'Weber' AND firstname = 'Shannon') OR
(lastname = 'Wehner' AND firstname = 'Nick') OR
(lastname = 'West' AND firstname = 'Alex') OR
(lastname = 'Westin' AND firstname = 'Emma') OR
(lastname = 'Whelan' AND firstname = 'Alison') OR
(lastname = 'Williams' AND firstname = 'Jordyn') OR
(lastname = 'Williams' AND firstname = 'Riley') OR
(lastname = 'Wilson' AND firstname = 'Andrew') OR
(lastname = 'Winebrenner' AND firstname = 'Lynn') OR
(lastname = 'Wingbermuehle' AND firstname = 'Ronald') OR
(lastname = 'Wingert' AND firstname = 'Molly') OR
(lastname = 'Winterowd' AND firstname = 'Katie') OR
(lastname = 'Wippler' AND firstname = 'Sydney') OR
(lastname = 'Wohlstadter' AND firstname = 'Ian') OR
(lastname = 'Wong' AND firstname = 'Jenna ') OR
(lastname = 'Yang' AND firstname = 'Shu ') OR
(lastname = 'Young' AND firstname = 'Daniel') OR
(lastname = 'Young' AND firstname = 'Lauren') OR
(lastname = 'Zimmerman' AND firstname = 'Victoria') ";


    $sql = "SELECT id FROM `apo`.`contact_information` WHERE $WHERE_ALL AND $WHERE";
        $result = mysql_query($sql);
        $num_rows = mysql_num_rows($result);
        for ($i=0;$i<$num_rows;$i++){
            $ids;
            $row = mysql_fetch_assoc($result);
            $ids[$i] = $row['id'];
        }
        foreach($ids as $index => $value){
        //creates a row for each individual for the assigned event.
            $sql = "INSERT INTO `apo`.`recorded_attendance` (id,user_id)
                    VALUES ('".$id."','".$value."')";
                $result=mysql_query($sql);
        }
}

function display_log_form_init(){
    //begin form
echo
<<<END
<form method="post" action="$_SERVER[PHP_SELF]" id="show">
        <fieldset>
             <legend>Log Attendance:</legend>
             <select name="event">
                <option>Select one...</option>
END;
    //select event list information, get the name and date on the label,
    //but send only the id information as the value.
    /*$sql = "SELECT name.events AS event, date.occurrence AS date, id.occurrence AS ID
            FROM `events`, `occurrence`
            WHERE e_id.events = e_id.occurrence";*/
    $sql = "SELECT events.name AS name, occurrence.date AS date, occurrence.id AS id
            FROM events
            JOIN occurrence
            ON events.e_id=occurrence.e_id
            ORDER BY occurrence.date DESC";
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)){
                    $event = $row['name'];
                    $date = $row['date'];
                    $id = $row['id'];
        echo("<option value=$id>{$event}--{$date}</option>");
    }
    echo("</select><p>");
echo
<<<END
    <input type="hidden" name="show" value="process_init"/>
                <input type="submit"/>
</fieldset>
</form>
END;
}
function display_log_form(){

    $id = $_POST['event'];//WORKS
    $sql = "SELECT events.name AS name, occurrence.date AS date, occurrence.id AS id
            FROM events
            JOIN occurrence
            ON events.e_id=occurrence.e_id
            WHERE occurrence.id = '".$id."'
            ORDER BY occurrence.date";
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)){
                    $event = $row['name'];
                    $date = $row['date'];
        }
echo
<<<END
<form method="post" action="$_SERVER[PHP_SELF]" id="log">
        <fieldset>
             <legend>Log Attendance for: {$event}--{$date}</legend><br/>
END;
    //BEGIN NEW FORM
        //interject checkboxes
    $sql = "SELECT contact_information.id AS id, contact_information.firstname,
            contact_information.lastname, recorded_attendance.attended,
            recorded_attendance.user_id,occurrence.type,contact_information.status
            FROM contact_information
            JOIN recorded_attendance
            ON contact_information.id=recorded_attendance.user_id
            JOIN occurrence
            ON recorded_attendance.id=occurrence.id
            WHERE contact_information.status != 'Alumni'
            AND contact_information.status != 'Inactive'
            AND contact_information.status != 'Advisor'
            AND contact_information.status != 'Pledge'
            AND recorded_attendance.id = $id
            AND recorded_attendance.attended = 0
            AND ((lastname = 'Alderson' AND firstname = 'Emily') OR
(lastname = 'Atchley' AND firstname = 'Rebecca') OR
(lastname = 'Baharaeen' AND firstname = 'Renee') OR
(lastname = 'Banze' AND firstname = 'Ashley') OR
(lastname = 'Barczykowski' AND firstname = 'Aimee') OR
(lastname = 'Barry' AND firstname = 'Riley') OR
(lastname = 'Bavery' AND firstname = 'Erin ') OR
(lastname = 'Bayer' AND firstname = 'Justin') OR
(lastname = 'Bayer' AND firstname = 'Katie') OR
(lastname = 'Beers' AND firstname = 'Katie') OR
(lastname = 'Nikki ' AND firstname = 'Bene') OR
(lastname = 'Bess' AND firstname = 'Caitlyn') OR
(lastname = 'Birtley' AND firstname = 'Ashley') OR
(lastname = 'Blakely' AND firstname = 'Karis') OR
(lastname = 'Bode' AND firstname = 'Christina ') OR
(lastname = 'Bright' AND firstname = 'Joshua') OR
(lastname = 'Bueckendorf' AND firstname = 'Grace') OR
(lastname = 'Bulczak' AND firstname = 'Nicole') OR
(lastname = 'Burnitt-Erp' AND firstname = 'Jazmyn') OR
(lastname = 'Calhoon' AND firstname = 'Allie') OR
(lastname = 'Campbell' AND firstname = 'Devynn') OR
(lastname = 'Capehart' AND firstname = 'Dustin') OR
(lastname = 'Caputa' AND firstname = 'Maria') OR
(lastname = 'Carnahan' AND firstname = 'Mackenzie ') OR
(lastname = 'Cassilly' AND firstname = 'Tommy') OR
(lastname = 'Chau' AND firstname = 'Liz') OR
(lastname = 'Chittum' AND firstname = 'Megan') OR
(lastname = 'Choate' AND firstname = 'Lauren') OR
(lastname = 'Clayton' AND firstname = 'Megan') OR
(lastname = 'Cobb' AND firstname = 'Caitlin') OR
(lastname = 'Cooksey' AND firstname = 'Sarah') OR
(lastname = 'Coulson' AND firstname = 'Mikala') OR
(lastname = 'Craig' AND firstname = 'Lauri') OR
(lastname = 'Crouch' AND firstname = 'Alex') OR
(lastname = 'Cummiskey' AND firstname = 'Carly') OR
(lastname = 'Cunningham' AND firstname = 'Kelly') OR
(lastname = 'Daniel' AND firstname = 'Phillip') OR
(lastname = 'Davies' AND firstname = 'Michelle') OR
(lastname = 'Davis' AND firstname = 'Laura') OR
(lastname = 'Davis' AND firstname = 'Matthew') OR
(lastname = 'Dawson' AND firstname = 'Rani') OR
(lastname = 'DeCoster' AND firstname = 'Katrina') OR
(lastname = 'DeDecker' AND firstname = 'Maggie') OR
(lastname = 'Delware' AND firstname = 'Becky') OR
(lastname = 'Demien' AND firstname = 'Taylor') OR
(lastname = 'DeMoor' AND firstname = 'Anna') OR
(lastname = 'Deneke' AND firstname = 'Jonathan') OR
(lastname = 'DeZeeuw' AND firstname = 'Zane') OR
(lastname = 'Diermann' AND firstname = 'Jessica') OR
(lastname = 'Dismang' AND firstname = 'Nathan') OR
(lastname = 'Dong' AND firstname = 'Ly') OR
(lastname = 'Duesterhaus' AND firstname = 'Sarah') OR
(lastname = 'Dungan' AND firstname = 'Laura') OR
(lastname = 'Elliott' AND firstname = 'Tia') OR
(lastname = 'Ewing' AND firstname = 'Lily') OR
(lastname = 'Fabbri' AND firstname = 'Marissa') OR
(lastname = 'Findley' AND firstname = 'Nicole') OR
(lastname = 'Finnegan' AND firstname = 'Allie') OR
(lastname = 'Fish' AND firstname = 'Nicola') OR
(lastname = 'Frerichs' AND firstname = 'Valerie') OR
(lastname = 'Gehrman' AND firstname = 'Linda') OR
(lastname = 'Gillam' AND firstname = 'Matt') OR
(lastname = 'Glickert' AND firstname = 'Heidi') OR
(lastname = 'Grimsley' AND firstname = 'Kristin') OR
(lastname = 'Hahn' AND firstname = 'Sara') OR
(lastname = 'Halfmann' AND firstname = 'Victoria') OR
(lastname = 'Hall' AND firstname = 'Joe') OR
(lastname = 'Hamera' AND firstname = 'Caroline') OR
(lastname = 'Hamilton' AND firstname = 'Paige') OR
(lastname = 'Harris' AND firstname = 'Conner') OR
(lastname = 'Hartig' AND firstname = 'Jefferson') OR
(lastname = 'Hatting' AND firstname = 'Rose') OR
(lastname = 'Hayes' AND firstname = 'Kate') OR
(lastname = 'Haenni' AND firstname = 'Jamie') OR
(lastname = 'Hill' AND firstname = 'Andrew') OR
(lastname = 'Hoard' AND firstname = 'Daniel') OR
(lastname = 'Hoeglund' AND firstname = 'Alicia') OR
(lastname = 'Hoehn' AND firstname = 'Rachael ') OR
(lastname = 'Hogan' AND firstname = 'Cory') OR
(lastname = 'Holland' AND firstname = 'Chelsea') OR
(lastname = 'Holwick' AND firstname = 'Kristen') OR
(lastname = 'Hoover' AND firstname = 'Trent') OR
(lastname = 'Hughes' AND firstname = 'Matthew') OR
(lastname = 'Hung' AND firstname = 'Kevin') OR
(lastname = 'Hunt' AND firstname = 'Sarrah ') OR
(lastname = 'Janke' AND firstname = 'Liz') OR
(lastname = 'Jenisch' AND firstname = 'Brenna') OR
(lastname = 'Jin' AND firstname = 'Xiaochen') OR
(lastname = 'Johnson' AND firstname = 'Angie') OR
(lastname = 'Johnston' AND firstname = 'Katie') OR
(lastname = 'Jones' AND firstname = 'Kendra') OR
(lastname = 'Jones ' AND firstname = 'Erin ') OR
(lastname = 'Josiah' AND firstname = 'Alyssa') OR
(lastname = 'Karner' AND firstname = 'Matthew') OR
(lastname = 'Katsev' AND firstname = 'Conner') OR
(lastname = 'Kerns' AND firstname = 'Austin') OR
(lastname = 'Ketterer ' AND firstname = 'Danielle ') OR
(lastname = 'Keyes' AND firstname = 'Andrew') OR
(lastname = 'Kickham' AND firstname = 'Allison') OR
(lastname = 'Kleekamp' AND firstname = 'Philip') OR
(lastname = 'Kohl' AND firstname = 'Kristina') OR
(lastname = 'Kompalli' AND firstname = 'Upagya ') OR
(lastname = 'Kuhn' AND firstname = 'Genevieve') OR
(lastname = 'Lanza' AND firstname = 'David') OR
(lastname = 'LaPointe' AND firstname = 'Matthew') OR
(lastname = 'Lee' AND firstname = 'Kelley') OR
(lastname = 'Lee' AND firstname = 'Yewon') OR
(lastname = 'Lemmons' AND firstname = 'Paxton') OR
(lastname = 'Lotz' AND firstname = 'Kaitlyn ') OR
(lastname = 'Lovewell' AND firstname = 'Carnahan ') OR
(lastname = 'Luchtefeld' AND firstname = 'Liz') OR
(lastname = 'Lynch' AND firstname = 'Shannon') OR
(lastname = 'Madden' AND firstname = 'Connor') OR
(lastname = 'Maffitt' AND firstname = 'Zoe') OR
(lastname = 'Maguire' AND firstname = 'Misha') OR
(lastname = 'Mange' AND firstname = 'Megan') OR
(lastname = 'Mausshardt' AND firstname = 'Emily') OR
(lastname = 'McCamon' AND firstname = 'Logan') OR
(lastname = 'McElhone' AND firstname = 'Mary Catherine') OR
(lastname = 'McKinney' AND firstname = 'Kay') OR
(lastname = 'Meier' AND firstname = 'Erin ') OR
(lastname = 'Mengwasser' AND firstname = 'Kelsey') OR
(lastname = 'Miller' AND firstname = 'matt') OR
(lastname = 'Miller' AND firstname = 'Shelby') OR
(lastname = 'Milliano' AND firstname = 'Joe') OR
(lastname = 'Milligan' AND firstname = 'Morgan') OR
(lastname = 'Monti' AND firstname = 'Sophia') OR
(lastname = 'Moran' AND firstname = 'Madeline') OR
(lastname = 'Morrissey' AND firstname = 'Carly') OR
(lastname = 'Moser' AND firstname = 'Libby') OR
(lastname = 'Myers' AND firstname = 'Adam ') OR
(lastname = 'Nelson' AND firstname = 'Taylor') OR
(lastname = 'Nguyen' AND firstname = 'Hazel') OR
(lastname = 'Nguyen' AND firstname = 'An') OR
(lastname = 'Nicholson' AND firstname = 'John') OR
(lastname LIKE '%Brien' AND firstname = 'Xavier') OR
(lastname = 'Olatunde' AND firstname = 'Josh') OR
(lastname = 'Olson' AND firstname = 'Molly') OR
(lastname = 'Pasupuleti' AND firstname = 'Trushna') OR
(lastname = 'Patch' AND firstname = 'Jesse') OR
(lastname = 'Patterson' AND firstname = 'Emma') OR
(lastname = 'Petruska' AND firstname = 'Jackie') OR
(lastname = 'Pham' AND firstname = 'Mai ') OR
(lastname = 'Phillips' AND firstname = 'Abigayle') OR
(lastname = 'Phillips' AND firstname = 'Dylan ') OR
(lastname = 'Popham' AND firstname = 'Greg') OR
(lastname = 'Prost' AND firstname = 'Curtis') OR
(lastname = 'Race' AND firstname = 'Dale') OR
(lastname = 'Raithel' AND firstname = 'Austin') OR
(lastname = 'Ranchel' AND firstname = 'Marissa') OR
(lastname = 'Reiser' AND firstname = 'Alex') OR
(lastname = 'Rempel' AND firstname = 'Brittany') OR
(lastname = 'Rettke' AND firstname = 'Abby') OR
(lastname = 'Rettke' AND firstname = 'Ally') OR
(lastname = 'Revak' AND firstname = 'Rebecca') OR
(lastname = 'Revelle' AND firstname = 'Libby') OR
(lastname = 'Rickert' AND firstname = 'Ashley') OR
(lastname = 'Rigsby' AND firstname = 'Rachel') OR
(lastname = 'Rippe' AND firstname = 'Jennifer') OR
(lastname = 'Rivera' AND firstname = 'Sarah') OR
(lastname = 'Roach' AND firstname = 'David') OR
(lastname = 'Rodriguez' AND firstname = 'Sarah') OR
(lastname = 'Romine' AND firstname = 'Daniel') OR
(lastname = 'Ronan' AND firstname = 'Sadie') OR
(lastname = 'Rodriguez' AND firstname = 'Danika') OR
(lastname = 'Rosen' AND firstname = 'Shayna') OR
(lastname = 'Saale' AND firstname = 'Kristen') OR
(lastname = 'Sandbrink' AND firstname = 'Tom') OR
(lastname = 'Sanders' AND firstname = 'Megan') OR
(lastname = 'Scheulen' AND firstname = 'Nikki') OR
(lastname = 'Schmitz' AND firstname = 'Katie') OR
(lastname = 'Schowengerdt' AND firstname = 'Jessica') OR
(lastname = 'Schulz' AND firstname = 'Taylor') OR
(lastname = 'Schuman' AND firstname = 'Greg') OR
(lastname = 'Schwald' AND firstname = 'Alexis') OR
(lastname = 'Schwartz' AND firstname = 'Elizabeth') OR
(lastname = 'Schwartz' AND firstname = 'Becky') OR
(lastname = 'Self' AND firstname = 'Morgan') OR
(lastname = 'Shearer' AND firstname = 'Tiffany') OR
(lastname = 'Skidmore' AND firstname = 'Whitney') OR
(lastname = 'Smith ' AND firstname = 'Rebecca ') OR
(lastname = 'Smith' AND firstname = 'Brianna') OR
(lastname = 'Spalinger' AND firstname = 'Karli') OR
(lastname = 'Spicer' AND firstname = 'Kathryn') OR
(lastname = 'Stamp' AND firstname = 'Caroline') OR
(lastname = 'Stephenson' AND firstname = 'Austin') OR
(lastname = 'Strange' AND firstname = 'Sammi') OR
(lastname = 'Swingle' AND firstname = 'Rosalie') OR
(lastname = 'Talkington' AND firstname = 'Alyssa') OR
(lastname = 'Tata' AND firstname = 'Spoorthi') OR
(lastname = 'Templeton' AND firstname = 'Callie') OR
(lastname = 'Theis' AND firstname = 'Mariah') OR
(lastname = 'Theobald' AND firstname = 'Ed') OR
(lastname = 'Toal' AND firstname = 'Macy') OR
(lastname = 'Toalson' AND firstname = 'Paula') OR
(lastname = 'Toenjes' AND firstname = 'Daniel') OR
(lastname = 'Townsend' AND firstname = 'Bill') OR
(lastname = 'Tucker' AND firstname = 'Kaitlyn') OR
(lastname = 'Tucker' AND firstname = 'Kevin') OR
(lastname = 'Turner' AND firstname = 'Molly') OR
(lastname = 'Ulmer' AND firstname = 'Rachele') OR
(lastname = 'Vadalabene' AND firstname = 'Rebecca') OR
(lastname = 'Varley' AND firstname = 'Jared') OR
(lastname = 'Villafane' AND firstname = 'Rachel') OR
(lastname = 'Vu' AND firstname = 'Anh') OR
(lastname = 'Walde' AND firstname = 'Charlie') OR
(lastname = 'Walker' AND firstname = 'Brett') OR
(lastname = 'Ward' AND firstname = 'Elizabeth') OR
(lastname = 'Warren' AND firstname = 'KaeCee') OR
(lastname = 'Watkins Davis' AND firstname = 'Andi') OR
(lastname = 'Weber' AND firstname = 'Shannon') OR
(lastname = 'Wehner' AND firstname = 'Nick') OR
(lastname = 'West' AND firstname = 'Alex') OR
(lastname = 'Westin' AND firstname = 'Emma') OR
(lastname = 'Whelan' AND firstname = 'Alison') OR
(lastname = 'Williams' AND firstname = 'Jordyn') OR
(lastname = 'Williams' AND firstname = 'Riley') OR
(lastname = 'Wilson' AND firstname = 'Andrew') OR
(lastname = 'Winebrenner' AND firstname = 'Lynn') OR
(lastname = 'Wingbermuehle' AND firstname = 'Ronald') OR
(lastname = 'Wingert' AND firstname = 'Molly') OR
(lastname = 'Winterowd' AND firstname = 'Katie') OR
(lastname = 'Wippler' AND firstname = 'Sydney') OR
(lastname = 'Wohlstadter' AND firstname = 'Ian') OR
(lastname = 'Wong' AND firstname = 'Jenna ') OR
(lastname = 'Yang' AND firstname = 'Shu ') OR
(lastname = 'Young' AND firstname = 'Daniel') OR
(lastname = 'Young' AND firstname = 'Lauren') OR
(lastname = 'Zimmerman' AND firstname = 'Victoria'))
            ORDER BY lastname, firstname DESC";
        $result = mysql_query($sql);

        $num_rows = mysql_num_rows($result);
        for ($i=0;$i<$num_rows;$i++){
            $ids;
            $row = mysql_fetch_assoc($result);
            $type = $row['type'];
            if($type == 'Exec'){
                $status = $row['status'];
                if($status == 'Elected' || $status == 'Appointed'){
                    $ids[$i] = $row['id'];
                }
            }else{
                $ids[$i] = $row['id'];
            }
        }


        foreach($ids as $index => $value){
        //Pound it into the ground
            //begin checkbox interjection.
            $sql = "SELECT firstname, lastname FROM `apo`.`contact_information` WHERE id = $value";
                $result = mysql_query($sql);
                while($row = mysql_fetch_array($result)){
                // begin band aid
                            $firstname = $row['firstname'];
                            $lastname = $row['lastname'];
                }
                //works correctly to display the names of each individual
                //
            /*$sql = "SELECT attended FROM `recorded_attendance` WHERE id = $value";
                $result = mysql_query($sql);
                while($row = mysql_fetch_array($result)){
                    $attended = $row['attended'];
                }
            if($attended == 0){*/
                echo("<input type=\"checkbox\" name=\"attended[]\" value=\"$value\" checked>{$lastname}, $firstname<br>");
            //}//commented out for now because the form does not change when you select a new date.
            //in the future, incorporate javascript to update the names listed on a new selection.
            //for now, simply update based on the selection.
            //name=\"attended[]\" appends the next checked box to the array
        }
    //resume form
echo
<<<END
    <input type="hidden" name="event" value= $id />
    <input type="hidden" name="log" value="process"/>
                <input type="submit"/>
</fieldset>
</form>
END;
}

function process_log(){
    $attended = $_POST['attended'];//array passed to here
    $id = $_POST['event'];//WORKS
    $size = count($attended);//count elements
    for($i=0;$i<$size;$i++){//do something for each, index begins at 0.
        //echo("<br/>".$i." ".$attended[$i]);//WOW, it works, echo for testing
        $attendance = $attended[$i];
        $sql = "UPDATE `recorded_attendance` SET attended = 1
                WHERE attended = 0 AND user_id = '".$attendance."'
                AND id = '".$id."'";
            $result = mysql_query($sql);
            if($result){
            }else{
            echo(mysql_error());
            }
    }
}
function check_attendance(){

echo
<<<END
<form method="post" action="$_SERVER[PHP_SELF]" id="show">
        <fieldset>
             <legend>Check Attendance:</legend>
             <select name="event">
                <option>Select one...</option>
END;

    $sql = "SELECT events.name AS name, occurrence.date AS date, occurrence.id AS id
            FROM events
            JOIN occurrence
            ON events.e_id=occurrence.e_id
            WHERE semester != 'Spring 2013'
            ORDER BY occurrence.date DESC";
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)){
                    $event = $row['name'];
                    $date = $row['date'];
                    $id = $row['id'];
        echo("<option value=$id>{$event}--{$date}</option>");
    }
    echo("</select><p>");
echo
<<<END
    <input type="hidden" name="check" value="process"/>
    <input type="submit"/>
</fieldset>
</form>
END;
}

function show_attendance(){
    //this will gather the event name and date from the submitted id.
    //condense to function
    $id = $_POST['event'];//WORKS
    $sql = "SELECT events.name AS name, occurrence.date AS date, occurrence.id AS id
            FROM events
            JOIN occurrence
            ON events.e_id=occurrence.e_id
            WHERE occurrence.id = '".$id."'
            ORDER BY occurrence.date";
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)){
                    $event = $row['name'];
                    $date = $row['date'];
        }
    echo
<<<END
        <fieldset>
             <legend>Recorded Attendance for: {$event}--{$date}
             <a href="attendance_export.php?id={$id}">export</a></legend><br/>
END;
    //BEGIN NEW FORM
        //interject checkboxes
    $sql = "SELECT contact_information.id AS id, contact_information.firstname,
            contact_information.lastname, recorded_attendance.attended,
            recorded_attendance.user_id
            FROM contact_information
            JOIN recorded_attendance
            ON contact_information.id=recorded_attendance.user_id
            WHERE contact_information.status != 'Alumni'
            AND contact_information.status != 'Inactive'
            AND contact_information.status != 'Advisor'
            AND contact_information.status != 'Pledge'
            AND recorded_attendance.id = $id
            AND recorded_attendance.attended = 1
            ORDER BY lastname, firstname DESC";
        $result = mysql_query($sql);

        $num_rows = mysql_num_rows($result);
        for ($i=0;$i<$num_rows;$i++){
            $ids;
            $row = mysql_fetch_assoc($result);
            $ids[$i] = $row['id'];
        }


        foreach($ids as $index => $value){
        //Pound it into the ground
            //begin checkbox interjection.
            $sql = "SELECT firstname, lastname FROM `apo`.`contact_information` WHERE id = $value";
                $result = mysql_query($sql);
                while($row = mysql_fetch_array($result)){
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                }
                //works correctly to display the names of each individual
                //
            /*$sql = "SELECT attended FROM `recorded_attendance` WHERE id = $value";
                $result = mysql_query($sql);
                while($row = mysql_fetch_array($result)){
                    $attended = $row['attended'];
                }
            if($attended == 0){*/
                echo("{$lastname}, $firstname<br/>");
            //}//commented out for now because the form does not change when you select a new date.
            //in the future, incorporate javascript to update the names listed on a new selection.
            //for now, simply update based on the selection.
            //name=\"attended[]\" appends the next checked box to the array
        }
    echo("</fieldset>");
}

//only President, Rec Sec, and Webmaster can access this page
$position = $_SESSION['sessionposition'];
echo "$position";
if($position != "Webmaster" && $position != "President"){echo("you do not have permission to view this page.");
}else{
?>
<a href="http://apo.truman.edu/attendance_admin.php">reset</a>
<?php


if (isset($dev) && ($dev == 1)){
    echo("This page is under development right now, call me if you absolutely need to record attendance.");
}
elseif (isset($_POST['new']) && ('process' == $_POST['new'])) {
   process_new();
}elseif (isset($_POST['add']) && ('process' == $_POST['add'])) {
    process_add();
}elseif (isset($_POST['show']) && ('show_create' == $_POST['show'])) {
    display_create_form($current_semester);
}elseif (isset($_POST['show']) && ('show_add' == $_POST['show'])) {
    display_add_form($current_semester);
}elseif (isset($_POST['log']) && ('process' == $_POST['log'])) {
    process_log();
}elseif (isset($_POST['show']) && ('show_log' == $_POST['show'])) {
    display_log_form_init();
}elseif (isset($_POST['show']) && ('process_init' == $_POST['show'])) {
    display_log_form();
}elseif (isset($_POST['show']) && ('check' == $_POST['show'])) {
    check_attendance();
}elseif (isset($_POST['check']) && ('process' == $_POST['check'])) {
    show_attendance();
}else{

echo
<<<END
    <form method="post" action="$_SERVER[PHP_SELF]" id="navigate">
        <fieldset>
             <legend>Where do you want to go?</legend>
                Go to...<br/>
                     <select name="show">
                        <option>Select one...</option>
                        <option value="show_create">create</option>
                        <option value="show_add">assign</option>
                        <option value="show_log">log</option>
                        <option value="check">check</option>
                     </select><br/><p><p>
                <input type="submit"/>
        </fieldset>
    </form>

END;
}
}
?>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>