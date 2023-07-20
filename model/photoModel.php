<?php
include_once 'connection.php';

class Address extends Connection {
    private $id;
    private $name;
    private $sequence;
    private $created;
    private $updated;
    private $id_products;

    public function setId($id){
        $this->id=$id;
        return $this;
    }

    public function getId(){
        return $this->id;
    }
}

?>