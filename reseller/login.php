<?php

// Encabezados http necesarios - CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

if (isset($_POST['btn-login'])) {

    // Validando que las variables no esten vacias.
    if (empty($_POST['username']) || empty($_POST['password'])) {

        echo json_encode(
                array('message' => "Deben llenarse los campos requeridos.")
        );

    } else {
        
        // Include database and objects files.
        include_once "../config/database.php";
        include_once "../objects/reseller.php";

        // Instantiate database and PorAmbito object.
        $database = new Database;
        $db       = $database->getConnection();

        // Initialize object.
        $reseller = new Reseller($db);

        // Indica el parametro USERNAME and PASSWORD a consultar.
        $reseller->reseller_name = isset($_POST['username']) ? $_POST['username'] : die();
        $reseller->password = isset($_POST['password']) ? $_POST['password'] : die();

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
                    session_start();
                    $_SESSION["reseller_name"] = $reseller_name;
                    $_SESSION["reseller_pass"] = $reseller_pass;
                    header('Location: hola.php');
            }

            // echo json_encode(
            //     array('message' => "Bienvenido! " . $reseller_name)
            // );

        } else {
            echo json_encode(
                array('message' => "Error al iniciar sesión, usuario o contraseña incorrectos.")
            );
        }
    }

} else {
    /**
     * Si se intenta acceder directamente a esta pagina desde
     * el navegador no se cumplira la condicion planteada en
     * el if por lo tanto se redirige al usuario a index.php
     */
    header('Location: index.html');
}