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
$user->password  = isset($_GET['password']) ? $_GET['password'] : die();

// Ejecutar Query para iniciar sesión.
$stmt = $user->login_user_generated();
// Devuelve el numero de filas.
$num  = $stmt->rowCount();


// Comprobar si se obtuvieron resultados en la consulta.
if ($num > 0) {
    
    // Recuperar contenido de la consulta.
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
            $user_name = $row["user"];
            $user_pass = $row["password"];
            // Aquí es donde hago uso de SESSION y redirijo al panel.
            // session_start();
            // $_SESSION["user_name"] = $user_name;
            // $_SESSION["user_name"] = $user_name;
            // header('Location: hola.php');
    }

    echo json_encode(
        array('message' => "Bienvenido! " . $user_name)
    );

} else {
    echo json_encode(
        array('message' => "Error al iniciar sesión, usuario o contraseña incorrectos.")
    );
}
