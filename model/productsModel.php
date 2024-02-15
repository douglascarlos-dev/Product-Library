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
/*
    function get_all_products3(){
        $consulta = $this->database_select_all();
        return $consulta;
    }

    function get_all_products2( $array ){
        $consulta = $this->database_select_all2( $array );
        return $consulta;
    }
*/
    function get_all_products( $campo, $ordem ){
        $consulta = $this->database_select_all( $campo, $ordem );
        return $consulta;
    }

    function database_select_all3(){
        $pdo = $this->o_db;
        //$stmt = $pdo->prepare("SELECT * FROM $valor1 ORDER BY description");
        $stmt = $pdo->prepare("SELECT id, stock_keeping_unit, description, COALESCE(count, 0) AS count FROM products LEFT join (select id_products, COUNT(id_products) from photo GROUP by id_products) photo on products.id = photo.id_products GROUP BY stock_keeping_unit, description, products.id, count ORDER BY description ASC"); 
        $stmt->execute(); 
        $row = $stmt->fetchAll();
        return $row;
    }

    function database_select_all2( $array ){
        $pdo = $this->o_db;
        //$stmt = $pdo->prepare("SELECT * FROM $valor1 ORDER BY description");
        $stmt = $pdo->prepare("SELECT id, stock_keeping_unit, description, COALESCE(count, 0) AS count FROM products LEFT join (select id_products, COUNT(id_products) from photo GROUP by id_products) photo on products.id = photo.id_products GROUP BY stock_keeping_unit, description, products.id, count ORDER BY description $array[1]"); 
        $stmt->execute(); 
        $row = $stmt->fetchAll();
        return $row;
    }

    function database_select_all( $campo, $ordem ){
        
        $pdo = $this->o_db;
        //$stmt = $pdo->prepare("SELECT * FROM $valor1 ORDER BY description");
        $stmt = $pdo->prepare("SELECT id, stock_keeping_unit, description, COALESCE(count, 0) AS count FROM products LEFT join (select id_products, COUNT(id_products) from photo GROUP by id_products) photo ON products.id = photo.id_products GROUP BY stock_keeping_unit, description, products.id, count ORDER BY $campo $ordem"); 
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
    function products_list_id(){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = '" . $this->getId() . "' LIMIT 1"); 
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
    function post_products_id_update(){
        $result = $this->products_id_update();
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

    function products_id_update(){
        date_default_timezone_set('America/Sao_Paulo');
        $date = new DateTimeImmutable();
        $date = $date->format('Y-m-d H:i:s O');
        $sql_query = "SELECT * FROM products_id_update_function
                        (
                            '" . $this->getId() . "',
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

    function database_select_all_var( $busca, $campo, $ordem){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT id, stock_keeping_unit, description, COALESCE(count, 0) AS count
        FROM products
        LEFT join (select id_products, COUNT(id_products) from photo GROUP by id_products) photo
        ON products.id = photo.id_products
        WHERE description ILIKE '%$busca%' OR stock_keeping_unit ILIKE '%$busca%'
        GROUP BY stock_keeping_unit, description, products.id, count
        ORDER BY $campo $ordem"); 
        $stmt->execute(); 
        $row = $stmt->fetchAll();
        return $row;
    }

    function products_search( $campo, $ordem ){
        $consulta = $this->database_select_all_var( $this->getDescription(), $campo, $ordem );
        return $consulta;
    }

    function post_products_search( $campo, $ordem ){
        $result = $this->products_search( $campo, $ordem );
        return $result;
    }

}

?>