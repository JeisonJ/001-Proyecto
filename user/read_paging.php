<?php

// Require headers.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files.
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/dao/user_dao.php';

// Utilities.
$utilities = new Utilities;

// Instantiate database and user object.
$database = new Database;
$db = $database->getConnection();

// Initialize object.
$user = new UserDAO($db);

// Indica el parametro USERNAME a consultar.
$user->reseller_name = isset($_GET['reseller_name']) ? $_GET['reseller_name'] : die();

if (isset($_GET['users_quantity'])) {
//     // Query users.
     $stmt = $user->last_users_added($_GET['users_quantity']);
     $numm  = $stmt->rowCount();

     $uq = true;
} else {
    $uq = false;
}

// Query users.
$stmt = $user->readPaging($from_record_num, $records_per_page);

$num  = $stmt->rowCount();

// Check if more than 0 record found.
if($num>0) {
    // users array.
    $users_array = array();
    $users_array["records"] = array();
    $users_array["paging"]  = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //var_dump($row);

        $user_item = array(
            "id"            => $row['id'],
            "user_name"     => $row['user'],
            "password"      => $row['password'],
            "credits"       => $row['credits'],
            "reseller_name" => $row['reseller'],
            "lastuid"       => $row['lastuid']
        );

        array_push($users_array["records"], $user_item);
    }

    $page_url   = "{$home_url}user/read_paging.php?reseller_name=$user->reseller_name";
    $total_rows = $user->count();

    // Include paging.
    // Valores tomados de el archivo core.php
    $total_rows = ($uq) ? $numm : $total_rows ;
    $page_url   = ($uq) ? $page_url . "&users_quantity=$users_quantity" : $page_url ;
    $paging     = $utilities->getPaging(
        $page, $total_rows, $records_per_page, $page_url);
    $users_array["paging"] = $paging;

    echo json_encode($users_array);

} else {
    echo json_encode(
        array("message" => "No users found.")
    );
}