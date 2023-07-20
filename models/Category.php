<?php
require_once("Database.php");
class Category extends Database {

    private $id;
    private $name;
    private $num_products;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getNumProducts() {
        return $this->num_products;
    }

    public function setNumProducts($num_products) {
        $this->num_products = $num_products;
    }


    public function getAllCategories() {
        $query = "SELECT categories.id,categories.name, COUNT(products.id) as num_products
        FROM categories
        LEFT JOIN products ON categories.id = products.category_id
        GROUP BY categories.id";

        $this->DBConnect();
        $categories = $this->fetchAll($query);
        $categoryObjects = [];
        foreach ($categories as $category) {
            $categoryObject = new Category();
            $categoryObject->setId($category['id']);
            $categoryObject->setName($category['name']);
            $categoryObject->setNumProducts($category['num_products']);
            $categoryObjects[] = $categoryObject;
        }
        return $categoryObjects;
    }

    public function addCategory() {
        $data = array(
            'name' => $this->getName(),
        );
    
        $this->DBConnect();
        $result = $this->executeInsert('categories', $data);
    
        return $result !== false;
    }

    public function updateCategory() {
        $data = array(
            'name' => $this->getName(),
        );

        $conditions = array(
            'id' => $this->getId()
        );

        $this->DBConnect();
        $result = $this->executeUpdate('categories', $data, $conditions);

        return $result !== false;
    }

    public function deleteCategory()
    {
        $table = 'categories';
        $conditions = array('id' => $this->getId());
        $this->DBConnect();
        $result = $this->executeDelete($table, $conditions);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
?>
