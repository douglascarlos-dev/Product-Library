<?php
include_once 'connection.php';

class Products extends Connection {
    private $id;
    private $stock_keeping_unit;
    private $description;
    private $created;
    private $updated;

    public function setId($id){
        $this->id=$id;
        return $this;
    }
    public function setStockKeepingUnit($stock_keeping_unit){
        $this->stock_keeping_unit=$stock_keeping_unit;
        return $this;
    }
    public function setDescription($description){
        $this->description=$description;
        return $this;
    }
    public function setCreated($created){
        $this->created=$created;
        return $this;
    }
    public function setUpdated($updated){
        $this->updated=$updated;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getStockKeepingUnit()
    {
        return $this->stock_keeping_unit;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function getUpdated()
    {
        return $this->updated;
    }

    function get_all_products(){
        $consulta = $this->database_select_all('products');
        return $consulta;
    }

    function database_select_all($valor1){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT * FROM $valor1 ORDER BY id"); 
        $stmt->execute(); 
        $row = $stmt->fetchAll();
        return $row;
    }

    function post_products_new(){
        $result = $this->products_insert();
        return $result;
    }

    function products_insert(){
        $sql_query = "SELECT * FROM products_insert_function
                        (
                            '" . $this->getStockKeepingUnit() . "',
                            '" . $this->getDescription() . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    function products_list(){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT * FROM products WHERE stock_keeping_unit = '" . $this->getStockKeepingUnit() . "' LIMIT 1"); 
        $stmt->execute(); 
        $row = $stmt->fetch();
        $products = new Products();
        $products->setStockKeepingUnit($row[1]);
        $products->setDescription($row[2]);
        return $products;
    }

    function post_products_update(){
        $result = $this->products_update();
        return $result;
    }

    function products_update(){
        date_default_timezone_set('America/Sao_Paulo');
        $date = new DateTimeImmutable();
        $date = $date->format('Y-m-d H:i:s O');
        $sql_query = "SELECT * FROM products_update_function
                        (
                            '" . $this->getStockKeepingUnit() . "',
                            '" . $this->getDescription() . "',
                            '" . $date . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    function products_delete(){
        $sql_query = "SELECT * FROM products_remove_function
                        (
                            '" . $this->getStockKeepingUnit() . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->rowCount();
        @rmdir("foto/".$this->getStockKeepingUnit());
        return $row;
    }

    function post_products_delete(){
        $result = $this->products_delete();
        return $result;
    }

}

?>