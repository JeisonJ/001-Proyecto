<?php

// Encabezados http necesarios - CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


// Include database and objects files.
include_once "../config/database.php";
include_once "../objects/user.php";

// Instantiate database and PorAmbito object.
$database = new Database;
$db       = $database->getConnection();

// Initialize object.
$user = new User($db);


// Ejecutar Query para obtener estadisticas de un reseller, 
// creditos, datos en general dado su nombre.
$stmt = $user->read_all_users();
// Devuelve el numero de filas.
$num  = $stmt->rowCount();


// Comprobar si se obtuvieron resultados en la consulta.
if ($num > 0) {
    $resultados = array();
    $resultados["user_info"] = array();

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

        array_push($resultados["user_info"], $resultado_item);
    }
    
    echo json_encode($resultados);
} else {
    echo json_encode(
        array('message' => "No se encontraron resultados.")
    );
}