<?php

// Mostrar reporte de errores, cambiar en producción.
// Show report of errors, change in production.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// URL de la página principal.
// URL of the main page.
$home_url = "http://localhost/PHP/WORK/001-Proyecto/";


// página dada en el parámetro URL, la página por defecto es uno / 1.
$page = isset($_GET["page"]) ? $_GET["page"] : 1;

// Numero de resultados por página.
$records_per_page = 5;

// Calculopara el limite de la sentencia SQL.
$from_record_num = ($records_per_page * $page) - $records_per_page;