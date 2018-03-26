<?php

// Encabezados http necesarios - CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");


// Include database and objects files.
include_once "../config/database.php";
include_once "../objects/reseller.php";

// Instantiate database and PorAmbito object.
$database = new Database;
$db       = $database->getConnection();

// Initialize object.
$reseller = new Reseller($db);

// Array para almacenar la informacion mostrada para produccion
$all_resultados['all_resultados'] = array();

// Indica el parametro USERNAME and PASSWORD a consultar.
$reseller->reseller_name = isset($_GET['username']) ? $_GET['username'] : die();
$reseller->password = isset($_GET['password']) ? $_GET['password'] : die();

// Ejecutar Query para iniciar sesión.
$stmt = $reseller->login_reseller();
// Devuelve el numero de filas.
$num  = $stmt->rowCount();


// Comprobar si se obtuvieron resultados en la consulta.
if ($num > 0) {
    
    // Recuperar contenido de la consulta.
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
            $reseller_name = $row["reseller"];
            $reseller_pass = $row["password"];
            // Aquí es donde hago uso de SESSION y redirijo al panel.
            // session_start();
            // $_SESSION["reseller_name"] = $reseller_name;
            // $_SESSION["reseller_pass"] = $reseller_pass;
            // header('Location: hola.php');
    }

    echo json_encode(
        array('message' => "Bienvenido! " . $reseller_name)
    );

} else {
    echo json_encode(
        array('message' => "Error al iniciar sesión, usuario o contraseña incorrectos.")
    );
}
