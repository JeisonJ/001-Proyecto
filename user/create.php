<?php

// Required headers.
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Get database connection.
include_once "../config/database.php";
include_once "../objects/dao/user_dao.php";
include_once "../shared/generator_users.php";

$database = new Database();
$db = $database->getConnection();

$user = new UserDAO($db);

// Get posted data - obtener datos enviados.
$data = json_decode(file_get_contents("php://input"));

// Set product property values.
// $user->$credits        = 2000;//$data->name;
// $user->$reseller_name       = "jose";//$data->price;
// $user->name        = $data->name;
// $user->price       = $data->price;


$generate_users = new generatorUsers;
$users = $generate_users->generateUsers(10);

$sentencia = array();

for ($i=0; $i < count($users); $i++) { 
    
    $user_name = $users[$i][0];
    $user_pass = $users[$i][1];
    
    array_push(
        $sentencia,
        "VALUES(
            $user_name,
            $user_pass,
            '2000',
            'jose'
        )");
}

var_dump($sentencia);

// Sentencia
// $sentencia = array(
//     "INSERT INTO frpusers (user, password, credits, reseller) ", 
//         "inserts" => array("values"));

// Create the product.
// if($product->create()) {
//     echo '{';
//         echo '"message": "Product was created."';
//     echo '}';
// }
// // if unable to create the product, tell the user
// else{
//     echo '{';
//         echo '"message": "Unable to create product."';
//     echo '}';
// }
