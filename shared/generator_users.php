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
                $this->generateStrongPassword()
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

        $pass = ( $num_rand % 2 == 0) ? ucfirst($pass).$num_rand : $num_rand.strrev($pass).$num_rand ;

        return $pass;
    }

    // Generates a strong password of N length containing at least one lower case letter,
    // one uppercase letter, one digit, and one special character. The remaining characters
    // in the password are chosen at random from those four sets.
    //
    // The available characters in each set are user friendly - there are no ambiguous
    // characters such as i, l, 1, o, 0, etc. This, coupled with the $add_dashes option,
    // makes it much easier for users to manually type or speak their passwords.
    //
    // Note: the $add_dashes option will increase the length of the password by
    // floor(sqrt(N)) characters.
    // https://gist.github.com/compermisos/cf11aed742d2e1fbd994e083b4b0fa78

    function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds') {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if(!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;

}

//take a array and get random index, same function of array_rand, only diference is
// intent use secure random algoritn on fail use mersene twistter, and on fail use defaul array_rand
function tweak_array_rand($array){
	if (function_exists('random_int')) {
		return random_int(0, count($array) - 1);
	} elseif(function_exists('mt_rand')) {
		return mt_rand(0, count($array) - 1);
	} else {
		return array_rand($array);
	}
}

    public function get_files($file_name) {

        $url = __DIR__."/data/".$file_name;
        
        // Escribir un fichero en un array. 
        $lineas = file($url);

        return $lineas;
    }
}