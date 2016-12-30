<?php
if(isset($_SESSION['sessionID'])){
    if($_SESSION['sessionexec'] == 1){
        $exec_authorized = false;
        if($exec_page){
            include('mysql_access.php');
            if (!isset($permissions_page)) {
                $permissions_page = $_SERVER['PHP_SELF'];
            }
            $page_id = get_page_id($permissions_page);
            $position_id = get_position_id($_SESSION['sessionposition']);
            $sql = "SELECT * FROM exec_permissions WHERE page_id = ? AND position_id = ?;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ii", $page_id, $position_id);
            if(!$stmt->execute()) {
                echo "Error: " . $stmt->errno . " " . $stmt->error;
                show_error();
                exit();
            } else {
                $stmt->store_result();
                if($stmt->num_rows != 0) {
                    $exec_authorized = true;
                }
            }
        }
        if($exec_authorized){
            show_exec();
        } elseif($active_page){
            show_active();
        } elseif($public_page){
            show_public();
        } elseif($exec_page){
            show_insuff_permissions();
        } else{
            show_error();
        }
    } else{
        if($active_page){
            show_active();
        } elseif($public_page){
            show_public();
        } elseif($exec_page){
            show_insuff_permissions();
        } else{
            show_error();
        }
    }
} else{
    if($public_page){
        show_public();
    } elseif($exec_page || $active_page){
        show_login();
    } else{
        show_error();
    }
}

function get_page_id($page_name) {
    include('mysql_access.php');
    $sql = "SELECT page_id FROM exec_permissions_pages WHERE page = ?;";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $page_name);
    if(!$stmt->execute()) {
            echo "Error: " . $stmt->errno . " " . $stmt->error;
            show_error();
            exit();
    } else {
        $stmt->bind_result($page_id);
        $stmt->fetch();
        return $page_id;
    }
}

function get_position_id($position_name) {
    include('mysql_access.php');
    $sql = "SELECT position_id FROM positions WHERE position = ?;";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $position_name);
    if(!$stmt->execute()) {
            echo "Error: " . $stmt->errno . " " . $stmt->error;
            show_error();
            exit();
    } else {
        $stmt->bind_result($position_id);
        $stmt->fetch();
        return $position_id;
    }
}

function show_error() {
    ?>
    <div class="small-12 columns">
        <h2>Oops</h2>
        <p>There's been an error. This page doesn't have any content.</p>
    </div>
    <?php
}

function show_insuff_permissions() {
    ?>
    <div class="small-12 columns">
        <h2>Sorry</h2>
        <p>Only certain members of exec can view this page.</p>
    </div>
    <?php
}

function show_login() {
    require_once('login_form.php');
}

?>
