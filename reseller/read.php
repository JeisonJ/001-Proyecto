<?php

// Encabezados http necesarios - CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


// Include database and objects files.
include_once "../config/database.php";
include_once "../objects/reseller.php";

// Instantiate database and PorAmbito object.
$database = new Database;
$db       = $database->getConnection();

// Initialize object.
$reseller = new Reseller($db);


// Ejecutar Query para obtener estadisticas de un reseller, 
// creditos, datos en general dado su nombre.
$stmt = $reseller->read_all_resellers();
// Devuelve el numero de filas.
$num  = $stmt->rowCount();


// Comprobar si se obtuvieron resultados en la consulta.
if ($num > 0) {
    $resultados = array();
    $resultados["reseller_info"] = array();

    // Recuperar contenido de la consulta.
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        $resultado_item = array(
            $reseller_id        = $row["id"],
            $reseller_name      = $row["reseller"],
            $reseller_credits   = $row["credits"],
            $reseller_lastlogon = $row["lastlogon"],
            $reseller_status    = $row["status"]
        );

        array_push($resultados["reseller_info"], $resultado_item);
    }
    
    echo json_encode($resultados);
} else {
    echo json_encode(
        array('message' => "No se encontraron resultados.")
    );
}