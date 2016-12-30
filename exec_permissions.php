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
    $pageSelect = generate_page_select();
    $positionSelect = generate_position_select();
    ?>
    
    <div class="small-6 small-centered columns">
        <h1>Permissions Manager</h1>
    </div>
</div>
<div class="row">
    <form name="modeForm">
        <div class="small-3 small-offset-3 columns">
            <input type="radio" name="modeRadio" id="modeRadioPage" />
            <label for="modeRadioPage" style="width:80%;">View Permissions by Page</label>
        </div>
        <div class="small-4 columns end">
            <input type="radio" name="modeRadio" id="modeRadioPosition" />
            <label for="modeRadioPosition" style="width:80%;">View Permissions by Position</label>
        </div>
    </form>
    <div class="small-12 columns">
        <div>
            <p id="messageArea"></p>
        </div>
    </div>
</div>
<div id="byPageDiv" style="display:none;">
    <div class="row">
        <div class="small-12 columns">
            <p>Page Mode</p>
        </div>
        <form id="byPageForm">
            <div class="small-3 columns">
                <select name="pageId" id="byPagePageSelect" onchange="selectChanged()" style="width:100%;" required>
                    <option value="" disabled selected style="display:none;"></option>
                    <?php echo $pageSelect; ?>
                </select>
            </div>
            <div class="small-3 columns">
                <select name="positionId" id="byPagePositionSelect" style="width:100%;" required>
                    <option value="" disabled selected style="display:none;"></option>
                    <?php echo $positionSelect; ?>
                </select>
            </div>
            <div class="small-1 small-offset-1 columns">
                <input type="radio" name="request" id="byPageRequestAdd" value="add" required /><label for="byPageRequestAdd" class="inline">Add</label>
            </div>
            <div class="small-1 columns">
                <input type="radio" name="request" id="byPageRequestRemove" value="remove" required /><label for="byPageRequestRemove" class="inline">Remove</label>
            </div>
            <div class="small-2 small-offset-1 columns">
                <input type="submit" class="button small" value="Submit" />
            </div>
        </form>
    </div>
</div>
<div id="byPositionDiv" style="display:none;">
    <div class="row">
        <div class="small-12 columns">
            <p>Position Mode</p>
        </div>
        <form id="byPositionForm">
            <div class="small-3 columns">
                <select name="positionId" id="byPositionPositionSelect" onchange="selectChanged()" style="width:100%;" required>
                    <option value="" disabled selected style="display:none;"></option>
                    <?php echo $positionSelect; ?>
                </select>
            </div>
            <div class="small-3 columns">
                <select name="pageId" id="byPositionPageSelect" style="width:100%;" required>
                    <option value="" disabled selected style="display:none;"></option>
                    <?php echo $pageSelect; ?>
                </select>
            </div>
            <div class="small-1 small-offset-1 columns">
                <input type="radio" name="request" id="byPositionRequestAdd" value="add" required /><label for="byPositionRequestAdd" class="inline">Add</label>
            </div>
            <div class="small-1 columns">
                <input type="radio" name="request" id="byPositionRequestRemove" value="remove" required /><label for="byPositionRequestRemove" class="inline">Remove</label>
            </div>
            <div class="small-2 small-offset-1 columns">
                <input type="submit" class="button small" value="Submit" />
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="small-12 columns">
        <h4>Permissions for <span id="permissionsTitle"></span></h4>
        <div id="permissionsResults"></div>
    </div>
</div>

<script>
document.getElementById('modeRadioPage').onclick = pageMode;
document.getElementById('modeRadioPosition').onclick = positionMode;
document.getElementById('byPageRequestAdd').onclick = filterSelectBox;
document.getElementById('byPageRequestRemove').onclick = filterSelectBox;
document.getElementById('byPositionRequestAdd').onclick = filterSelectBox;
document.getElementById('byPositionRequestRemove').onclick = filterSelectBox;
document.getElementById('byPageForm').onsubmit = submitRequest;
document.getElementById('byPositionForm').onsubmit = submitRequest;


var pagesJson = [];
var positionsJson = [];

function filterSelectBox() {
    if (document.getElementById('modeRadioPage').checked) {
        selectBox = document.getElementById('byPagePositionSelect');
        completeSelectBox = document.getElementById('byPositionPositionSelect');
        requestMode = "byPage";
        selectJson = positionsJson;
    } else if (document.getElementById('modeRadioPosition').checked) {
        selectBox = document.getElementById('byPositionPageSelect');
        completeSelectBox = document.getElementById('byPagePageSelect');
        requestMode = "byPosition";
        selectJson = pagesJson;
    }
    if (document.getElementById(requestMode + 'RequestAdd').checked) {
        selectBox.innerHTML = completeSelectBox.innerHTML;
        for(var i = 0; i < selectJson.length; i++) {
            removeSelectOption(selectBox, selectJson[i].id);
        }
    } else if (document.getElementById(requestMode + 'RequestRemove').checked) {
        selectBox.innerHTML = "";
        optionResult = '<option value="" disabled selected style="display:none;"></option>';
        for(var i = 0; i < selectJson.length; i++) {
            optionResult += "<option value='" + selectJson[i].id + "''>" + selectJson[i].name + "</option>";
        }
        selectBox.innerHTML = optionResult;
    }
}

function pageMode() {
    document.getElementById('byPageDiv').style.display = '';
    document.getElementById('byPositionDiv').style.display = 'none';
    selectChanged();
}

function positionMode() {
    document.getElementById('byPageDiv').style.display = 'none';
    document.getElementById('byPositionDiv').style.display = '';
    selectChanged();
}

function removeSelectOption(selectBox, optionValue) {
    for (var i = 0; i < selectBox.options.length; i++) {
        if (selectBox.options[i].value == optionValue) {
            selectBox.remove(i);
            break;
        }
    }
}

function selectChanged() {
    if (document.getElementById('modeRadioPage').checked) {
        requestField = "pageId";
        element = document.getElementById('byPagePageSelect');
    } else if (document.getElementById('modeRadioPosition').checked) {
        requestField = "positionId";
        element = document.getElementById('byPositionPositionSelect');
    }
    value = element.value;
    if (value != "") {
        text = element.options[element.selectedIndex].text;
        fd = new FormData();
        fd.append("request", "listing");
        fd.append(requestField, value);
        ajaxRequest(fd, function(result) {
            resultJson = JSON.parse(result);
            if (document.getElementById('modeRadioPage').checked) {
                positionsJson = resultJson;
            } else if (document.getElementById('modeRadioPosition').checked) {
                pagesJson = resultJson;
            }
            setPermissionsResults(resultJson, text);
            filterSelectBox();
        });
    } else {
        document.getElementById("permissionsTitle").innerHTML = "";
        document.getElementById('permissionsResults').innerHTML = "";
    }
}

function setPermissionsResults(resultJson, text) {
    var result = "";
    document.getElementById("permissionsTitle").innerHTML = text;
    for(var i = 0; i < resultJson.length; i++) {
        result += "<p>" + resultJson[i].name + "</p>";
    }
    document.getElementById('permissionsResults').innerHTML = result;
}

function submitRequest(event) {
    event.preventDefault();
    fd = new FormData();
    fd.append("request", this.elements['request'].value);
    fd.append("pageId", this.elements['pageId'].value);
    fd.append("positionId", this.elements['positionId'].value);
    ajaxRequest(fd, selectChanged);
}

function ajaxRequest(fd, callback) {
    $.ajax({
        data: fd,
        type: 'POST',
        url: 'includes/exec_permissions_process.php',
        cache: false,
        processData: false,
        contentType: false,
        success: callback,
        error: function(jqXHR, exception) {
            //If the AJAX call can't reach the page
            if (jqXHR.status === 0) {
                $("#messageArea").html('Oops, something is wrong with connection. Error message: Unable to connect to the network');
            } else if (jqXHR.status == 404) {
                $("#messageArea").html('Oops, something is wrong with connection. Error message: Requested page not found [404]');
            } else if (jqXHR.status == 500) {
                $("#messageArea").html('Oops, something is wrong with connection. Error message: Internal Server Error [500]');
            } else if (exception === 'parsererror') {
                $("#messageArea").html('Oops, something is wrong with connection. Error message: Requested JSON parse failed');
            } else if (exception === 'timeout') {
                $("#messageArea").html('Oops, something is wrong with connection. Error message: Time out error');
            } else if (exception === 'abort') {
                $("#messageArea").html('Oops, something is wrong with connection. Error message: Ajax request aborted');
            } else {
                $("#messageArea").html('Uncaught Error.\n' + jqXHR.responseText);
            }
        }
    });
}
</script>

<?php
}

function generate_page_select() {
    include('mysql_access.php');
    //Generate Page Dropdown
    $sql = "SELECT page_id, page FROM exec_permissions_pages;";
    $stmt = $db->prepare($sql);
    if(!$stmt->execute()) {
        return "Error: " . $stmt->errno . " " . $stmt->error;
    } else {
        $stmt->bind_result($pageId, $page);
        $pageSelect = "";
        while ($stmt->fetch()) {
            $pageSelect .= "<option value='$pageId'>$page</option>\n";
        }
        return $pageSelect;
    }
}

function generate_position_select() {
    include('mysql_access.php');
    //Generate Page Dropdown
    $sql = "SELECT position_id, position FROM positions;";
    $stmt = $db->prepare($sql);
    if(!$stmt->execute()) {
        return "Error: " . $stmt->errno . " " . $stmt->error;
    } else {
        $stmt->bind_result($positionId, $position);
        $positionSelect = "";
        while ($stmt->fetch()) {
            $positionSelect .= "<option value='$positionId'>$position</option>\n";
        }
        return $positionSelect;
    }
}

function list_pages() {
    include('mysql_access.php');
    $sql = "SELECT page, entry_id FROM exec_permissions_pages ORDER BY page ASC;";
    $result = $db->query($sql);
    echo "<div class=\"medium-6 small-12 columns\">";
    echo "<h2>Current Pages</h2>";
    echo "<table><tr><th>Page Name</th><th>Edit Permissions</th></tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tr><td>{$row['page']}</td><td><a href=\"{$_SERVER['PHP_SELF']}?page_id={$row['entry_id']}\" class=\"button expand\">Edit</a></td></tr>";
    }
    echo "</table></div>";
}

function list_positions() {
    include('mysql_access.php');
    $sql = "SELECT position, position_id FROM positions ORDER BY position_order ASC;";
    $result = $db->query($sql);
    echo "<div class=\"medium-6 small-12 columns\">";
    echo "<h2>Current Positions</h2>";
    echo "<table><tr><th>Position</th><th>Edit Permissions</th></tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tr><td>{$row['position']}</td><td><a href=\"{$_SERVER['PHP_SELF']}?position_id={$row['position_id']}\" class=\"button expand\">Edit</a></td></tr>";
    }
    echo "</table></div>";
}


$exec_page = true;
$active_page = false;
$public_page = false;

require_once('permissions.php');

?>

</div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
