<?php

// Required headers.
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Get database connection.
include_once "../config/database.php";
include_once "../objects/dao/user_dao.php";
include_once "../objects/dao/reseller_dao.php";
include_once "../shared/generator_users.php";

$database = new Database();
$db = $database->getConnection();

$user = new UserDAO($db);
// Initialize object.
$reseller = new ResellerDAO($db);


// Get posted data - obtener datos enviados.
$data = json_decode(file_get_contents("php://input"));

// Set product property values.
$assigned_credits         = $data->assigned_credits;
$reseller->reseller_name  = $data->reseller_name;
$user->reseller_name      = $reseller->reseller_name;
$users_quantity           = $data->users_quantity;
$update_credits = $assigned_credits * $users_quantity;


// Consultar los datos del reseller
$stmt = $reseller->read_one_reseller();

// Recuperar contenido de la consulta.
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
     $reseller_credits   = $row['credits'];
}

session_start();

if ($reseller_credits > $update_credits) {

    // Funcion que se encarga de generar usuarios aleatorios.
    $generate_users = new generatorUsers($_SESSION["reseller_name"], $_SESSION['reseller_prefix']);
    $users = $generate_users->generateUsers($users_quantity);

    // Crear la sentencia SQL para insertar los usuarios generados en la base de datos.
    $sentencia = array();

    for ($i=0; $i < count($users); $i++) { 
        array_push($sentencia, "\n(
            '". $users[$i][0] ."',
            '". $users[$i][1] . "', 
            '". $assigned_credits . "',
            '". $reseller->reseller_name ."')" );
    }

    $query = "INSERT INTO frpusers (user, password, credits, reseller) VALUES" . implode(",", $sentencia); 


    // Create the users.
    if($user->add_generated_users($query)) {

        // Consultar los datos del reseller
        $reseller->update_reseller_credits($update_credits);

        $stmt = $user->number_users_created();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $total_created = $row["total_created"];
        }

        $stmt = $reseller->read_one_reseller();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reseller_credits   = $row['credits'];
        }

        // Actualizar las variables de sesion.
        
        $_SESSION['reseller_credits']   = $reseller_credits;
        $_SESSION['users_created']      = $total_created;

        echo '{';
            echo '"message": "users was created.",
                  "reseller_credits":"'.$_SESSION['reseller_credits'] .'"';
        echo '}';
    }
    else{
        echo '{';
            echo '"message": "Unable to create users."';
        echo '}';
    }

} else {
    echo '{';
        echo '"message": "No hay suficientes creditos."';
    echo '}';
}

