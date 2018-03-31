<?php

class ResellerDAO {
    // Conexión a la base de datos y nombre de la tabla.
    private $connection;
    private $table_name = "reseller";

    public $reseller_id;
    public $reseller_name;
    public $password;
    public $credits;
    public $last_logon;
    public $status;


    public function __construct($db) {
        $this->connection = $db;
    }
    

    /** 
     * Query para obtener un reseller dado usuario y contraseña.
     *
     * @todo Eliminar el uso de contraseñas planas, sustituir por funcion de encriptación.
     */
    function login_reseller() {
        
        $query = "
            SELECT reseller,password 
            FROM reseller 
            WHERE reseller = :username 
            AND password   = :password 
            AND status='1';
        ";

        // Prepare query.
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(':username', $this->reseller_name, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }


    /**
     * Finalizar sesión.
     * @todo Determinar como será su uso.
     */
    function logout() {}


    // Obtener estadisticas de un reseller, creditos dado su nombre.
    function read_one_reseller() {

        $query = "
            SELECT id, reseller, credits, lastlogon, status
            FROM reseller 
            WHERE reseller = :reseller;
        "; // AND password   = :password

        // Prepare query.
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(':reseller', $this->reseller_name, PDO::PARAM_STR);
        // $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }


    // Obtener todos los reseller.
    function read_all_resellers() {

        $query = "
            SELECT id, reseller, credits, lastlogon, status
            FROM reseller;
        ";

        $stmt = $this->connection->prepare( $query );
        $stmt->execute();

        return $stmt;
    }


    // Cantidad los usuarios según un reseller dado limitado por el 
    // total de usuarios que hay menos la cantidad de creditos, y creditos

    
    // Actualizar creditos del reseller
    function update_reseller_credits() {

        $query = "
            UPDATE reseller 
            SET credits    = :newcredits 
            WHERE reseller = :reseller;
        ";

        // Prepare query.
        $stmt = $this->connection->prepare( $query );

        // Sanitize.

        $this->credits  = htmlspecialchars(strip_tags($this->credits));
        $this->reseller_name = htmlspecialchars(strip_tags($this->reseller_name));

        // Asignando los valores que requiere el query.
        $stmt->bindParam(':newcredits', $this->credits,  PDO::PARAM_STR);
        $stmt->bindParam(':reseller',   $this->reseller_name, PDO::PARAM_INT);
    }
}