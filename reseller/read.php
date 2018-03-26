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
$stmt = $reseller->read_all_reseller();
// Devuelve el numero de filas.
$num  = $stmt->rowCount();
