<?php

class Reseller {
    private $id;        
    private $name;      
    private $credits;      
    private $lastlogon;   
    private $status;  
    
    
    public function __construct($id, $name, $credits, $lastlogon, $status) {

        $this->id       = $id;
        $this->name     = $name;
        $this->credits  = $credits;
        $this->lastlogon= $lastlogon;
        $this->status   = $status;      
    }


     public function getID() {
            return $this->id;
        }
        public function setID($id) {
            $this->id = $id;
        }

        public function getName() {
            return $this->name;
        }
        public function setName($name) {
            $this->name = $name;
        }

        public function getCredits() {
            return $this->credits;
        }
        public function setCredits($credits) {
            $this->credits = $credits;
        }
        
        public function getLastlogon() {
            return $this->lastlogon;
        }
        public function setLastlogon($lastlogon) {
            $this->lastlogon = $lastlogon;
        }

        public function getStatus() {
            return $this->status;
        }
        public function setStatus($status) {
            $this->status = $status;
        }
}