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
  <div class="small-12 columns">
    <h2>APO Epsilon Family Tree</h2><br>
    <div id='family_tree' style='overflow: auto; height: 90%;'></div>
  </div>


<?php
$exec_page = False;
$active_page = False;
$public_page = True;
require_once('permissions.php');

function show_public() {
  include('mysql_access.php');
  //generate dot for viz.js
?>
  <script type='text/vnd.graphviz' id='family_tree_script'>
  digraph "family_tree" {
  graph [ bgcolor = transparent ];
  node [  shape = polygon,
    sides = 4,
    distortion = "0.0",
    orientation = "0.0",
    skew = "0.0",
    color = blue,
    style = filled,
    fontname = "Helvetica-Outline" ];

<?php
  $colorarray = array("maroon", "red", "green", "chartreuse", "plum", "salmon", "goldenrod", "yellow", "blue", "cyan");
  $rank = "";
  $rankedge = "";
  $sql = "SELECT DISTINCT pledgeyear, pledgesem FROM (SELECT pledgeyear, pledgesem FROM contact_information UNION DISTINCT SELECT pledgeyear, pledgesem FROM alumni UNION DISTINCT SELECT pledgeyear, pledgesem FROM alumni_info)all_users WHERE pledgeyear<>\"\" AND pledgesem<>\"\" ORDER BY pledgeyear ASC, pledgesem DESC;";
    $result = $db->query($sql);
    while ($row = mysqli_fetch_array($result)) {
      $pledgeyear = $row['pledgeyear'];
      $pledgesem = $row['pledgesem'];
      if (empty($colorarrayloop)) {
        $colorarrayloop = $colorarray;
      }
      $color = array_shift($colorarrayloop);
      $rank .= "{ rank=same; \"$pledgesem $pledgeyear\"";
      $rankedge .= "\"$pledgesem $pledgeyear\"->";
      echo "\"$pledgesem $pledgeyear\" [color=$color]\n";
    $sql = "SELECT id, firstname, lastname FROM (SELECT id, firstname, lastname, pledgeyear, pledgesem FROM contact_information UNION DISTINCT SELECT id, firstname, lastname, pledgeyear, pledgesem FROM alumni UNION DISTINCT SELECT id, firstname, lastname, pledgeyear, pledgesem FROM alumni_info)all_users WHERE pledgesem=\"$pledgesem\" AND pledgeyear=\"$pledgeyear\" ORDER BY lastname ASC;";
    $result2 = $db->query($sql);
    while ($row2 = mysqli_fetch_array($result2)) {
      $id = $row2['id'];
      $firstname = $row2['firstname'];
      $lastname = $row2['lastname'];
      //make nodes
      echo "\"$id\" [label=\"$firstname $lastname\", id=\"$id\", color=$color];\n";
      //generate rank for each pledge class
      $rank .= " " . $id;
    }
    $rank .= ";}\n";
  }
  $rankedge = substr($rankedge, 0, -2);
  $rankedge .= ";\n";
  echo $rank;
  echo $rankedge;
  $sql = "SELECT big_id, little_id FROM family_tree;";
  $result = $db->query($sql);
  while ($row = mysqli_fetch_array($result)) {
    $big = $row['big_id'];
    $little = $row['little_id'];
    echo "\"$big\" -> \"$little\";\n";
  }
  echo "} </script>";
?>
  <script src='/js/viz.js/viz.min.js'></script>
  <script>document.getElementById('family_tree').innerHTML = Viz(document.getElementById('family_tree_script').innerHTML, "svg", "dot")</script>
    <div class="medium-6 small-12 columns">
      <select id="memberselect">
<?php
  //generate dropdown box
  $sql = "SELECT id, firstname, lastname FROM contact_information UNION DISTINCT SELECT id, firstname, lastname FROM alumni UNION DISTINCT SELECT id, firstname, lastname FROM alumni_info ORDER BY lastname ASC;";
  $result = $db->query($sql);
    while ($row = mysqli_fetch_array($result)) {
      echo "<option value=\"{$row['id']}\">{$row['firstname']} {$row['lastname']}</option>\n";
    }
?>
      </select>
    </div>
  <div class="medium-6 small-12 columns">
    <div id="member_info">
    </div>
  </div>
  <script>
    //jQuery is currently included on every page by the site. If this changes, include the src to it above this script
    function loadmemberinfo(id) {
      $("#member_info").load("includes/family_tree_info.php?user_id=" + id);
    }

    function showmemberontree(id) {
      var elementid = $("#" + id);
      var container = $("#family_tree");
      $("#family_tree").animate({
        scrollLeft: elementid.offset().left + elementid.get(0).getBBox().width/2 - container.offset().left + container.scrollLeft() - container.width()/2,
        scrollTop: elementid.offset().top + elementid.get(0).getBBox().height/2 - container.offset().top + container.scrollTop() - container.height()/2
      }, 600);
    }

    $("#memberselect").change(function() {
      var id = $(this).val();
      showmemberontree(id);
      loadmemberinfo(id);
    });

    $("#family_tree").on("click", "g", function(event) {
      event.stopPropagation();
      showmemberontree(this.id);
      loadmemberinfo(this.id);
      $("html, body").animate({scrollTop: $("#member_info").offset().top}, 600);
    });

    $("#member_info").on("click", ".biglittle", function() {
      var id = $(this).attr("id").substr(2);
      showmemberontree(id);
      loadmemberinfo(id);
    });
  </script>
<?php
}

?>
  </div>
</div>
    <div id="footer"></div>
</body>
</html>
