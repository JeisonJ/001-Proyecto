<?php

// Encabezados http necesarios - CORS
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: access");
// header("Access-Control-Allow-Methods: GET");
// header("Access-Control-Allow-Credentials: true");
// header("Content-Type: application/json; charset=UTF-8");


// Include database and objects files.
include_once "../config/database.php";
include_once "../objects/dao/reseller_dao.php";

/**
 * Undocumented function
 *
 * @param [type] $username
 * @return void
 */
function get_Reseller($username) {
    // Instantiate database and PorAmbito object.
    $database = new Database;
    $db       = $database->getConnection();

    // Initialize object.
    $reseller = new ResellerDAO($db);


    // Indica el parametro USERNAME and PASSWORD a consultar.
    //$reseller->reseller_name = isset($_GET['username']) ? $_GET['username'] : die();
    $reseller->reseller_name = $username;

    // Ejecutar Query para obtener estadisticas de un reseller, 
    // creditos, datos en general dado su nombre.
    $stmt = $reseller->read_one_reseller();
    // Devuelve el numero de filas.
    $num  = $stmt->rowCount();

    // Comprobar si se obtuvieron resultados en la consulta.
    if ($num > 0) {
        $resultados["reseller_info"] = array();

        // Recuperar contenido de la consulta.
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            $resultados["reseller_info"] = array(
                'reseller_id'       => $row["id"],
                'reseller_name'      => $row["reseller"],
                'reseller_credits'   => $row["credits"],
                'reseller_lastlogon' => $row["lastlogon"],
                'reseller_status'    => $row["status"]
            );

            //array_push($resultados["reseller_info"], $resultados_item);
        }

        //echo json_encode($resultados);
        return $resultados;

    } else {
        // echo json_encode(
        //     array('message' => "No se encontraron resultados.")
        // );

        $resultados["reseller_info"] = array('message' => "No se encontraron resultados.");
        return $resultados;
    }

}
