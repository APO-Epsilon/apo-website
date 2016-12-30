<?php
session_start();

$exec_page = true;
$active_page = false;
$public_page = false;
$permissions_page = "/exec_permissions.php";
require_once("../permissions.php");

function show_exec() {
    if (isset($_POST['request'])) {
        $request = $_POST['request'];
        if ($request == "listing") {
            if (isset($_POST['pageId'])) {
                if (is_numeric($_POST['pageId'])) {
                    list_exec_by_page($_POST['pageId']);
                }
            } elseif (isset($_POST['positionId'])) {
                if (is_numeric($_POST['positionId'])) {
                    list_page_by_exec($_POST['positionId']);
                }
            }
        } else if (all_set()) {
            if ($request == "add") {
                add_permission($_POST['pageId'], $_POST['positionId']);
            } elseif ($request == "remove") {
                remove_permission($_POST['pageId'], $_POST['positionId']);
            }
        }
    }
}

function add_permission($pageId, $positionId) {
    include('../mysql_access.php');
    $sql = "INSERT INTO exec_permissions (page_id, position_id) VALUES (?, ?);";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $pageId, $positionId);
    if(!$stmt->execute()) {
        echo "Error: Could not add $positionId permission for $pageId";
    } else {
        echo "$positionId permission added for $pageId";
    }
}

function all_set() {
    $result = false;
    if (isset($_POST['pageId'])) {
        if (is_numeric($_POST['pageId'])) {
            if (isset($_POST['positionId'])) {
                if (is_numeric($_POST['positionId'])) {
                    $result = true;
                }
            }
        }
    }
    return $result;
}

function list_exec_by_page($pageId) {
    include('../mysql_access.php');
    $sql = "SELECT positions.position, positions.position_id FROM positions LEFT JOIN exec_permissions ON positions.position_id = exec_permissions.position_id WHERE exec_permissions.page_id = ? ORDER BY positions.position_order ASC;";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $pageId);
    if(!$stmt->execute()) {
        echo "Error: " . $stmt->errno . " " . $stmt->error;
    } else {
        $stmt->bind_result($position, $positionId);
        $resultArray = array();
        while ($stmt->fetch()) {
            $resultArray[] = ["name" => $position, "id" => $positionId];
        }
        echo json_encode($resultArray);
    }
}

function list_page_by_exec($positionId) {
    include('../mysql_access.php');
    $sql = "SELECT exec_permissions_pages.page, exec_permissions_pages.page_id FROM exec_permissions_pages LEFT JOIN exec_permissions ON exec_permissions_pages.page_id = exec_permissions.page_id WHERE exec_permissions.position_id = ? ORDER BY exec_permissions_pages.page_id ASC;";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $positionId);
    if(!$stmt->execute()) {
        echo "Error: " . $stmt->errno . " " . $stmt->error;
    } else {
        $stmt->bind_result($page, $pageId);
        $resultArray = array();
        while ($stmt->fetch()) {
            $resultArray[] = ["name" => $page, "id" => $pageId];
        }
        echo json_encode($resultArray);
    }
}

function remove_permission($pageId, $positionId) {
    include('../mysql_access.php');
    $sql = "DELETE FROM exec_permissions WHERE page_id=? AND position_id=?;";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $pageId, $positionId);
    if(!$stmt->execute()) {
        echo "Error: Could not remove $positionId permission for $pageId";
    } else {
        echo "$positionId permission removed for $pageId";
    }
}