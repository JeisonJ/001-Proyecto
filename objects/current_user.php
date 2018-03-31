<?php

include_once 'dto/reseller.php';


class CurrentUser {

    private $current_user;

    public function create_Current_User() {
        // Recuerando la session que esta en curso.
        session_start();

        // Creando un nuevo objeto de tipo Reseller.
        $this->current_user = new Reseller(
            $_SESSION['reseller_id'],
            $_SESSION['reseller_name'],
            $_SESSION['credits'],
            $_SESSION['lastlogon'],
            $_SESSION['status']
        );
    }

    public function get_Current_User() {
        return $this->current_user;
    }
}