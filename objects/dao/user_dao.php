<?php

class UserDAO {
    // Conexión a la base de datos y nombre de la tabla.
    private $connection;
    private $table_name = "frpusers";

    public $user_id;
    public $user_name;
    public $password;
    public $credits;
    public $reseller_name;
    public $lastuid;


    public function __construct($db) {
        $this->connection = $db;
    }
    

    /**
     * Query para obtener un reseller dado usuario y contraseña.
     * 
     * @todo Al ser igual a  @function login_reseller(); puede usarse una sola.
     */
    function login_user_generated() {

        $query = "
            SELECT user, password 
		    FROM frpusers 
		    WHERE user   = :username
		    AND password = :password; 
        ";

        // Prepare query.
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(':username', $this->user_name, PDO::PARAM_STR);
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
    function read_one_user() {

        $query = "
            SELECT id, user, password, credits, reseller, lastuid
            FROM frpusers 
            WHERE user = :user;
        "; // AND password   = :password

        // Prepare query.
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(':user', $this->user_name, PDO::PARAM_STR);
        // $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }


    // Obtener todos los reseller.
    function read_all_users() {

        $query = "
            SELECT id, user, password, credits, reseller, lastuid
            FROM frpusers;
        ";

        $stmt = $this->connection->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    // Comprobar creditos del reseller
    // Si tiene disponibles generar nombre y contraseña aleatoria e insertar
    // Actualizar creditos del reseller
    function add_generated_users() {

        $query = "
            INSERT INTO frpusers (user, password, credits, reseller) 
            VALUES(
                :username,
                :password,
                :credits,
                :reseller
            );"; 

        // Prepare query.
        $stmt = $this->connection->prepare( $query );

        // Sanitize.
        $this->user     = htmlspecialchars(strip_tags($this->user_name));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->credits  = htmlspecialchars(strip_tags($this->credits));
        $this->reseller = htmlspecialchars(strip_tags($this->reseller));

        // Asignando los valores que requiere el query.
        $stmt->bindParam(':username', $this->user_name,PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':credits',  $this->credits,  PDO::PARAM_INT);
        $stmt->bindParam(':reseller', $this->reseller_name,PDO::PARAM_STR);

        // Ejecutando query.
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    // Obtener todos los usuarios según un reseller dado.
    function reseller_agreement_userlist() {

        $query = "
            SELECT id, user, password, credits, reseller, lastuid 
            FROM frpusers 
            WHERE  reseller = :reseller;
        "; // ORDER BY credits DESC";"

        // Prepare query.
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(':reseller', $this->reseller_name, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }


    // Obtener todos los usuarios según un reseller dado.
    function last_users_added($limit) {

        $query = "
            SELECT id, user, password, credits, reseller, lastuid 
            FROM frpusers 
            WHERE  reseller = :reseller
            ORDER BY id DESC LIMIT :limit;
        "; // ORDER BY credits DESC";"

        // Prepare query.
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(':reseller', $this->reseller_name, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Obtener una cantidad de registro limitado por los 
     * parametros dados.
     *
     * @param [int]    $from_record_num  - Mostrar registros a partir del numero de indicado.
     * @param [int]    $records_per_page - Devolver solo la cantidad de registros indicados.
     * @return [array] $stmt - Resultados obtenidos en la consulta.
     */
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "
            SELECT id, user, password, credits, reseller, lastuid 
            FROM " . $this->table_name . "
            WHERE  reseller = :reseller
            ORDER BY id DESC 
            LIMIT :desde, :hasta;
        ";
    
       // prepare query statement
       $stmt = $this->connection->prepare( $query );
    
       // bind variable values
       $stmt->bindParam(':reseller', $this->reseller_name, PDO::PARAM_STR);
       $stmt->bindParam(':desde', $from_record_num, PDO::PARAM_INT);
       $stmt->bindParam(':hasta', $records_per_page, PDO::PARAM_INT);
    
       // execute query
       $stmt->execute();
    
       // return values from database
       return $stmt;
   }

   // used for paging products
    public function count(){
        $query = "
            SELECT COUNT(*) as total_rows 
            FROM " . $this->table_name . "
            WHERE  reseller = :reseller;
        ";
    
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(':reseller', $this->reseller_name, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }



    // Obtener cantidad de usuarios que ha creado un reseller.
    function number_users_created() {

        $query =  "
            SELECT COUNT(*) as total_created 
            FROM frpusers 
            WHERE reseller = :reseller;
        ";

        // Prepare query.
        $stmt = $this->connection->prepare( $query );
        $stmt->bindParam(':reseller', $this->reseller_name, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }

}