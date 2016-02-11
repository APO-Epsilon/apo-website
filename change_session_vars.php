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
function vars_form() {
  include ('mysql_access.php');
?>
  <div class="small-12 columns">
    <h1>Change Session Vars</h1>
    <p>The webmaster committee's tool to change identities for debugging</p>
    <br>
  </div>
  <div class="medium-8 small-12 medium-offset-2 columns end">
    <div class="row">
      <form name="sessionvarsform" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
      <div class="small-6 columns">
        <label for="member">Member</label>
        <select name="member" id="member">
          <?php
            //generate dropdown box
            $sql = "SELECT id, firstname, lastname FROM contact_information ORDER BY lastname ASC;";
            $result = $db->query($sql);
              while ($row = mysqli_fetch_array($result)) {
                echo "<option value=\"{$row['id']}\">{$row['firstname']} {$row['lastname']}</option>\n";
              }
          ?>
        </select>
      </div>
      <div class="small-6 columns">
        <label for="exec">Exec Position</label>
        <select name="exec" id="exec">
          <option value=""></option>
          <?php
            //generate dropdown box
            $sql = "SELECT position FROM positions ORDER BY position_order ASC;";
            $result = $db->query($sql);
              while ($row = mysqli_fetch_array($result)) {
                echo "<option value=\"{$row['position']}\">{$row['position']}</option>\n";
              }
          ?>
        </select>
      </div>
      <div class="small-6 columns">
        <br>
        <input type="submit" class="button expand" name="action" value="Reset Vars"/>
      </div>
      <div class="small-6 columns">
        <br>
        <input type="submit" class="button expand" name="action" value="Submit"/>
      </div>
      </form>
    </div>
  </div>

  <!-- This script uses jquery -->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#member").val('<?php echo $_SESSION['sessionID'] ?>');
      $("#exec").val('<?php echo $_SESSION['sessionposition'] ?>');
    });
  </script>

<?php
}

function process_form() {
  include ('mysql_access.php');
  if ($_POST['action'] == "Reset Vars") {
    if (isset($_SESSION['sessionIDOriginal'])) {
      $sessionIDOriginal = $_SESSION['sessionIDOriginal'];
      unset($_SESSION['sessionIDOriginal']);
      $sql = "SELECT id, firstname, lastname, username, exec, position FROM contact_information WHERE id = $sessionIDOriginal;";
      $query = $db->query($sql);
      $result = mysqli_fetch_array($query);
      $_SESSION['sessionUsername'] = $result['username'];
      $_SESSION['sessionFirstname'] = $result['firstname'];
      $_SESSION['sessionLastname'] = $result['lastname'];
      $_SESSION['sessionID'] = $result['id'];
      $_SESSION['sessionexec'] = $result['exec'];
      $_SESSION['sessionposition'] = $result['position'];
    }
  }

  if ($_POST['action'] == "Submit") {
    if (!isset($_SESSION['sessionIDOriginal'])) {
      $_SESSION['sessionIDOriginal'] = $_SESSION['sessionID'];
    }
    $sql = "SELECT id, firstname, lastname, username FROM contact_information WHERE id = {$_POST['member']};";
    $query = $db->query($sql);
    $result = mysqli_fetch_array($query);
    $_SESSION['sessionUsername'] = $result['username'];
    $_SESSION['sessionFirstname'] = $result['firstname'];
    $_SESSION['sessionLastname'] = $result['lastname'];
    $_SESSION['sessionID'] = $result['id'];
    if ($_POST['exec'] == "") {
      $_SESSION['sessionexec'] = "0";
      $_SESSION['sessionposition'] = "";
    } else {
      $_SESSION['sessionexec'] = "1";
      $_SESSION['sessionposition'] = $_POST['exec'];
    }
  }
}

$exec_page = False;
$active_page = True;
$public_page = False;
require_once('permissions.php');
function show_active() {
  if (isset($_SESSION['sessionIDOriginal'])) {
    $sessionID = $_SESSION['sessionIDOriginal'];
  } else {
    $sessionID = $_SESSION['sessionID'];
  }

  if ($sessionID == 426 || $sessionID == 443 || $sessionID == 739 || $sessionID == 668 || $sessionID == 851 || $sessionID == 1012 ) {        //list users ids for webmaster committee here to allow access - current: 426-Justin 443-Kevin 739-Austin 668-Carnahan
    if (isset($_POST['action'])){
      process_form();
    }
    vars_form();
  } else {
    echo "<p>You need to be a member of the webmaster committee to see this section.</p>";
  }
}
?>

  </div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
