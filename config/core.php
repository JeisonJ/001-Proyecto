<?php

// Mostrar reporte de errores, cambiar en producción.
// Show report of errors, change in production.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// URL de la página principal.
// URL of the main page.

$data = json_decode(file_get_contents(__DIR__ ."../../config.json"));

if ($data->dev) {
    $home_url = $data->url->root;
} else {
    $home_url = $data->url->envRoot;
}

//$home_url = "http://localhost/PHP/WORK/001-Proyecto/";


// página dada en el parámetro URL, la página por defecto es uno / 1.
$page = isset($_GET["page"]) ? $_GET["page"] : 1;

// Numero de resultados por página.
$records_per_page = 5;

// Calculo para el limite de la sentencia SQL.
$from_record_num = ($records_per_page * $page) - $records_per_page;   

if (isset($_GET['users_quantity'])) {

    $users_quantity  = $_GET['users_quantity'];

    if ($records_per_page > $users_quantity) {
        $records_per_page = $users_quantity;
    }
    
    if ($from_record_num == $users_quantity) {
        $from_record_num = $users_quantity;
    } 

} 

