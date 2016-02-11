<?php
require_once ('session.php');
require_once ('mysql_access.php');
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
    <?php

page_header();

function list_members_status_form($sql, $positions_options) {
  include ('mysql_access.php');

  $result = $db->query($sql) or exit("Error");

  while ($row = mysqli_fetch_array($result)) {
    if ($row['exec'] == 1 ) {
      $is_exec = "CHECKED";
      $is_not_exec = "";
    } else {
      $is_exec = "";
      $is_not_exec = "CHECKED";
    }

    echo<<<END
  <tr>
    <td>
      $row[firstname] $row[lastname]
    </td>
    <td>
      <select name="member[$row[id]][status]">
        <option>$row[status]</option>
        <option value="REMOVE">REMOVE</option>
        <option value="Active">Active</option>
        <option value="Alumni">Alumni</option>
        <option value="Appointed">Appointed</option>
        <option value="Associate">Associate</option>
        <option value="Early Alum">Early Alum</option>
        <option value="Elected">Elected</option>
        <option value="Inactive">Inactive</option>
        <option value="Pledge">Pledge</option>
        <option value="Pledge Exec">Pledge Exec</option>
        <option value="Advisor">Advisor</option>
        <option value="poor_standing">Poor Standing</option>
      </select>

    </td>
    <td>
      <select name="member[$row[id]][position]">
        <option>$row[position]</option>
        <option></option>
        $positions_options
      </select>
    </td>
    <td>
      <input type="radio" name="member[$row[id]][exec_access]" value="1" $is_exec/> Exec |
      <input type="radio" name="member[$row[id]][exec_access]" value="0" $is_not_exec/> Not Exec
    </td>
  </tr>
END;
  }
}

function get_positions() {
  include ('mysql_access.php');
  $sql = "SELECT `position` FROM `positions`";
  $result = $db->query($sql);

  $positions_options = "";
  while ($row = mysqli_fetch_array($result)) {
    $positions_options = $positions_options . "<option>$row[position]</option>";
  }
  return $positions_options;
}


function process_user($member, $user_id) {
  include ('mysql_access.php');
  $sql = "UPDATE `contact_information` SET `status` = '$member[status]', `position` = '$member[position]', `exec` = '$member[exec_access]' WHERE `id` = '$user_id' LIMIT 1";
  //echo $sql . "<br/>";
  $result = $db->query($sql);

}

function remove_user() {
  include ('mysql_access.php');
  $sql = "DELETE FROM `apo`.`contact_information` WHERE `contact_information`.`status` = 'REMOVE'";
  $result = $db->query($sql);

}

function process_input() {
  foreach ($_POST['member'] as $member_id => $member) {
    process_user($member, $member_id);
    remove_user();
  }
}


if ($_SESSION['sessionexec'] != 1) {
  die(Error);
}

echo "<div class='row'>";
echo "<br>";

if (isset($_POST['submitted'])) {
  process_input();
}

if (isset($_GET['filter'])) {
  $filter = $_GET['filter'];

  if ($filter == 'Actives') {
    $sql = "SELECT * FROM `contact_information` WHERE `status` = 'Active' ORDER BY `lastname`";
  } elseif ($filter == 'Inactives') {
    $sql = "SELECT * FROM `contact_information` WHERE `status` = 'Inactive' ORDER BY `lastname`";
  } elseif ($filter == 'board') {
    $sql = "SELECT * FROM `contact_information` WHERE `status` = 'Elected' OR `status` = 'Appointed' ORDER BY `lastname`";
  } elseif ($filter == 'exec') {
    $sql = "SELECT * FROM `contact_information` WHERE `exec` = '1' ORDER BY `lastname`";
  } elseif ($filter == 'pledge') {
    $sql = "SELECT * FROM `contact_information` WHERE `status` = 'Pledge' OR `status` = 'Pledge Exec' ORDER BY `lastname`";
  } elseif ($filter == 'poor_standing') {
    $sql = "SELECT * FROM `contact_information` WHERE `status` = 'poor_standing'";
  }elseif ($filter == 'all') {
    $sql = "SELECT * FROM `contact_information` ORDER BY `lastname`";
  } else {
    $sql = "SELECT * FROM `contact_information` WHERE status != 'Active' ORDER BY `lastname`";
  }
} else {
    $sql = "SELECT * FROM `contact_information` ORDER BY `lastname`";
}

$positions_options = get_positions();
?>
This page will help for mass edits to member statuses.  Click on a link below to filter to specific groups.

<ul>
<li>
  <a href='member_statuses.php?filter=Actives'>Actives</a>
</li>
<li>
  <a href='member_statuses.php?filter=Inactives'>Inactive</a>
</li>
<li>
  <a href='member_statuses.php?filter=board'>Board</a>
</li>
<li>
  <a href='member_statuses.php?filter=exec'>Exec Powers</a>
</li>
<li>
  <a href='member_statuses.php?filter=pledge'>Pledges</a>
</li>
<li>
  <a href='member_statuses.php?filter=poor_standing'>Poor Standing</a>
</li>
<li>
  <a href='member_statuses.php?filter=Nonactives'>Not Actives</a>
</li>
<li>
  <a href='member_statuses.php?filter=all'>All</a>
</li>
</ul>

<form action="member_statuses.php" method="POST">
<input type="hidden" name="submitted" value="1"/>
<table>
  <tr>
    <td>Name</td>
    <td>Status</td>
    <td>Position</td>
    <td>Exec?</td>
  </tr>

<?php
list_members_status_form($sql, $positions_options);
?>

</table>
<p align="center">
<input type="submit" value="Submit"/>
</p>
</form>

</div>
   <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
