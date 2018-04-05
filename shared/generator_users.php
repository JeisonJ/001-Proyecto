<?php

// Get database connection.
// include_once "../config/database.php";
// include_once "../objects/dao/user_dao.php";

// $database = new Database();
// $db = $database->getConnection();

// $user = new UserDAO($db);
// Include database and objects files.
include_once "../user/read_one.php";


class generatorUsers {
    private $dir = __DIR__."/data/";
    private $last_name = "last-names.txt";
    private $male_name = "male-names.txt";
    private $word = "word.txt";

    public $username;
    public $prefix;

    public function __construct($username, $prefix) {
        $this->username = $username;
        $this->prefix   = $prefix;
    }
    

    public function generateUsers($length) {
        $users = array();
        $users_created = get_number_users_created($this->username);
        $users_created += 1;

        $x = 0;
        for ($i=0; $i < $length; $i++) { 
            $users[$i] = array(
                $this->prefix . ($users_created + $x),
                $this->generate_password()
            );

            $x++;
        }

        return $users;
    }

    public function generate_username() {

        //srand((double)microtime()*1000000); 
        /**
         * 1. obtener los archivos last y male
         * 2. obtener las primeras 3 letras, las tres ultimas
         * 3. unirlas
         */
        // 1
        // $m_names = $this->get_files($this->male_name);
        // $l_names = $this->get_files($this->last_name);

        // $num_names = count($m_names);
        // $num_lnames = count($l_names);

        
        //$username = $this->prefix ."-". ($users_created + $x);
        $username = $this->prefix;

        // $uno = rtrim(substr($m_names[rand(0, $num_names - 1)], 0, 8)); 
        // $dos = substr($l_names[rand(0, $num_lnames - 1)], 0, 2);
        // $tres = rand(0, 100);
        // $username = strtolower($uno . $dos . $tres);

        return htmlspecialchars(strip_tags($username));
    }

    public function generate_password() {

        srand((double)microtime()*1000000); 

        $m_pass = $this->get_files($this->word);

        $num_pass = count($m_pass);
        $pass = rtrim($m_pass[rand(0, $num_pass - 1)]);
        $num_rand = rand(0, 100);

        $pass = ( $num_rand % 2 == 0) ? $num_rand.ucfirst($pass).$num_rand : $num_rand.strrev($pass).$num_rand ;

        return htmlspecialchars(strip_tags($pass));
    }

    public function get_files($file_name) {

        $url = __DIR__."/data/".$file_name;
        
        // Escribir un fichero en un array. 
        $lineas = file($url);

        return $lineas;
    }
}