<?php

class User {
    private $user_id;        
    private $user_name;      
    private $user_pass;      
    private $user_credits;   
    private $user_reseller;  
    private $user_lastuid;
    
    
    public function __construct(
        $user_id, $user_name, $user_pass, $user_credits, $user_reseller, $user_lastuid) {

        $this->user_id      = $user_id;
        $this->user_name    = $user_name;
        $this->user_pass    = $user_pass;
        $this->user_credits = $user_credits;
        $this->user_reseller= $user_reseller;
        $this->user_lastuid = $user_lastuid;        
    }


     public function getID() {
            return $this->user_id;
        }
        public function setID($user_id) {
            $this->user_id = $user_id;
        }

        public function getName() {
            return $this->user_name;
        }
        public function setName($user_name) {
            $this->user_name = $user_name;
        }

        public function getPassword() {
            return $this->user_pass;
        }
        public function setPassword($user_pass) {
            $this->user_pass = $user_pass;
        }

        public function getCredits() {
            return $this->user_credits;
        }
        public function setCredits($user_credits) {
            $this->user_credits = $user_credits;
        }
        
        public function getReseller() {
            return $this->user_reseller;
        }
        public function setReseller($user_reseller) {
            $this->user_reseller = $user_reseller;
        }

        public function getLastuid() {
            return $this->user_lastuid;
        }
        public function setLastuid($user_lastuid) {
            $this->user_lastuid = $user_lastuid;
        }
}