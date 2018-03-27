<?php

// Encabezados http necesarios - CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");


// Include database and objects files.
include_once "../config/database.php";
include_once "../objects/user.php";

// Instantiate database and PorAmbito object.
$database = new Database;
$db       = $database->getConnection();

// Initialize object.
$user = new User($db);


// Indica el parametro USERNAME and PASSWORD a consultar.
$user->user_name = isset($_GET['username']) ? $_GET['username'] : die();


// Ejecutar Query para obtener estadisticas de un reseller, 
// creditos, datos en general dado su nombre.
$stmt = $user->read_one_user();
// Devuelve el numero de filas.
$num  = $stmt->rowCount();

// Comprobar si se obtuvieron resultados en la consulta.
if ($num > 0) {
    $resultados = array();
    $resultados["user_info"] = array();

    // Recuperar contenido de la consulta.
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        $resultados["user_info"] = array(
            $user_id        = $row["id"],
            $user_name      = $row["user"],
            $user_pass      = $row["password"],
            $user_credits   = $row["credits"],
            $user_reseller  = $row["reseller"],
            $user_lastuid   = $row["lastuid"]
        );

        //array_push($resultados["user_info"], $resultados_item);
    }

    echo json_encode($resultados);

} else {
    echo json_encode(
        array('message' => "No se encontraron resultados. read_one_user")
    );
}


// Obtener todos los usuarios según un reseller dado.
$stmt = $user->reseller_agreement_userlist();
// Devuelve el numero de filas.
$num  = $stmt->rowCount();

// Comprobar si se obtuvieron resultados en la consulta.
if ($num > 0) {
    //$resultados = array();
    $resultados["reseller_userlist"] = array();

    // Recuperar contenido de la consulta.
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        $resultado_item = array(
            $user_id        = $row["id"],
            $user_name      = $row["user"],
            $user_pass      = $row["password"],
            $user_credits   = $row["credits"],
            $user_reseller  = $row["reseller"],
            $user_lastuid   = $row["lastuid"]
        );

        array_push($resultados["reseller_userlist"], $resultado_item);
    }
    
    echo json_encode($resultados);
} else {
    echo json_encode(
        array('message' => "No se encontraron resultados. reseller_userlist")
    );
}


 // Obtener cantidad de usuarios que ha creado un reseller.
$stmt = $user->number_users_created();
// Devuelve el numero de filas.
$num  = $stmt->rowCount();

// Comprobar si se obtuvieron resultados en la consulta.
if ($num > 0) {
    $resultados["users_created"] = array();

    // Recuperar contenido de la consulta.
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        $resultados["users_created"] = array(
            $total_created = $row["total_created"]
        );

        //array_push($resultados["reseller_info"], $resultados_item);
    }

    echo json_encode($resultados);

} else {
    echo json_encode(
        array('message' => "No se encontraron resultados.users_created")
    );
}