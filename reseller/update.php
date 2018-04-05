<?php

// Encabezados necesarios.
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and objects files.
include_once "../config/database.php";
include_once "../objects/dao/reseller_dao.php";

// Instantiate database and PorAmbito object.
$database = new Database;
$db       = $database->getConnection();

// Initialize object.
$reseller = new ResellerDAO($db);

/**
 * Obtener datos enviados por medio del POST en formato json.
 * Obtiene y muestra el código.
 * http://php.net/manual/es/function.file-get-contents.php
 */
$data = json_decode(file_get_contents("php://input"));

// ID que se usará para indicar el registro a editar.
$reseller->reseller_name = $data->reseller_name;
$reseller->prefix = $data->user_prefix;


// Ejecutar actualización.
if ($reseller->update_reseller_prefix()) {
    echo json_encode(
        array('message' => "Registro actualizado con exito.")
    );

    session_start();
    $_SESSION['reseller_prefix'] = $reseller->prefix;

} else {
    // Si no se ha podido realizar el registro, avisar el usuario. 
    echo json_encode(
        array('message' => "No se ha podido realizar la actualización del registro.")
    );
}