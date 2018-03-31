<?php

// Encabezados http necesarios - CORS
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: access");
// header("Access-Control-Allow-Methods: GET");
// header("Access-Control-Allow-Credentials: true");
// header("Content-Type: application/json; charset=UTF-8");

if (isset($_POST['btn-login'])) {

    // Validando que las variables no esten vacias.
    if (empty($_POST['username']) || empty($_POST['password'])) {

        echo json_encode(
                array('message' => "Deben llenarse los campos requeridos.")
        );

    } else {
        
        // Include database and objects files.
        include_once "../config/database.php";
        include_once "../objects/dao/reseller_dao.php";
        include_once "../user/read_one.php";
        

        // Instantiate database and PorAmbito object.
        $database = new Database;
        $db       = $database->getConnection();

        // Initialize object.
        $reseller = new ResellerDAO($db);

        // Indica el parametro USERNAME and PASSWORD a consultar.
        $reseller->reseller_name = isset($_POST['username']) ? $_POST['username'] : die();
        $reseller->password = isset($_POST['password']) ? $_POST['password'] : die();

        // Ejecutar Query para iniciar sesión.
        $stmt = $reseller->login_reseller();
        // Devuelve el numero de filas.
        $num  = $stmt->rowCount();


        // Comprobar si se obtuvieron resultados en la consulta.
        if ($num > 0) {

            // Query para obtener los datos
            $stmt = $reseller->read_one_reseller();

            $users_created = get_number_users_created($reseller->reseller_name);
            
            // Recuperar contenido de la consulta.
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    
                    // Aquí es donde hago uso de SESSION y redirijo al panel.
                    session_start();
                    $_SESSION['session_start']      = true;
                    $_SESSION['reseller_id']        = $row['id'];
                    $_SESSION["reseller_name"]      = $row["reseller"];
                    $_SESSION['reseller_credits']   = $row['credits'];
                    $_SESSION['reseller_lastlogon'] = $row['lastlogon'];
                    $_SESSION['reseller_status']    = $row['status'];
                    $_SESSION['users_created']      = $users_created;

                    header('Location: ../public/dashboard.php');
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
    header('Location: ../index.php');
}