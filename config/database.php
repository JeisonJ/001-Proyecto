<?php

// Constantes definidas para usar en la conexion.
// Constants defined to use in the connection.
include_once 'connection_data.inc.php';


class Database {
    // Si alguna constante no esta definida se tomará lo que 
    // se ha definido por defecto a la derecha del (operador de fusion de null).
    private $host       = DATABASE['host']     ?? 'localhost';
    private $database   = DATABASE['database'] ?? 'database';
    private $username   = DATABASE['username'] ?? 'root';
    private $password   = DATABASE['password'] ?? '';
    private $charset    = DATABASE['charset']  ?? 'utf8';
    public  $connection = "";


    // Obtener conexión a la base de datos.
    public function getConnection() {
        $this->connection = null;

        // Capturar los posibles errores.
        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" .
                $this->database, $this->username, $this->password);

            //echo "Conexion realizada con exito. \n";
        
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        // Si todo ha ido bien retornar la conexion.
        return $this->connection;
    }

}
