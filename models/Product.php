<?php
require_once("Database.php");
class Product extends Database {
    private $id;
    private $name;
    private $price;
    private $amount;
    private $category_id;
    private $category_name;
    private $description;
    private $tax_id;
    private $tax_name;
    private $tax_value;

    // public function __construct($id = null, $name = null, $price = null, $amount = null, $category_id = null, $description = null) {
    //     parent::__construct(); // wywołanie konstruktora klasy bazowej
    //     $this->id = $id;
    //     $this->name = $name;
    //     $this->price = $price;
    //     $this->amount = $amount;
    //     $this->category_id = $category_id;
    //     $this->description = $description;
    // }
    
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getCategoryName() {
        return $this->category_name;
    }

    public function getTaxValue() {
        return $this->tax_value;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setCategoryId($category_id) {
        $this->category_id = $category_id;
    }

    public function getCategoryId() {
        return $this->category_id;
    }

    public function setCategoryName($category_name) {
        $this->category_name = $category_name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getTaxId() {
        return $this->tax_id;
    }

    public function setTaxId($tax_id) {
        $this->tax_id = $tax_id;
    }

    public function getTaxName() {
        return $this->tax_name;
    }

    public function setTaxName($tax_name) {
        $this->tax_name = $tax_name;
    }
    
    public function setTaxValue($tax_value) {
        $this->tax_value = $tax_value;
    }
    

    

    public function getAllProducts() {
        $query = "SELECT products.id, products.name, products.price, products.amount, IFNULL(categories.name, 'Brak') AS category, products.description, products.tax_id 
        FROM products 
        LEFT JOIN categories 
        ON products.category_id = categories.id
        ";
        $this->DBConnect();
        $products = $this->fetchAll($query);
        $productObjects = [];
        foreach ($products as $product) {
            $productObject = new Product();
            $productObject->setId($product['id']);
            $productObject->setName($product['name']);
            $productObject->setPrice($product['price']);
            $productObject->setAmount($product['amount']);
            $productObject->setCategoryName($product['category']);
            $productObject->setTaxId($product['tax_id']);
    
            $productObjects[] = $productObject;
        }
        return $productObjects;
    }

    public static function getAllAvailableProducts() {
        $query = "SELECT products.id, products.name, products.price, products.amount, IFNULL(categories.name, 'Brak') AS category, products.description, products.tax_id 
        FROM products 
        LEFT JOIN categories 
        ON products.category_id = categories.id
        WHERE products.amount > 0
        ";
        $database = new Database();
        $database->DBConnect();
        $products = $database->fetchAll($query);
        $productObjects = [];
        foreach ($products as $product) {
            $productObject = new Product();
            $productObject->setId($product['id']);
            $productObject->setName($product['name']);
            $productObject->setPrice($product['price']);
            $productObject->setAmount($product['amount']);
            $productObject->setCategoryName($product['category']);
            $productObject->setTaxId($product['tax_id']);
    
            $productObjects[] = $productObject;
        }
        return $productObjects;
    }

    public function getOrderProducts($orderId) {
        $query = "SELECT po.id, p.name, c.name as category_name, po.price, po.amount, po.tax_id, t.name as tax_name, t.tax as tax_value
        FROM product__order po 
        JOIN orders o ON po.order_id = o.id 
        JOIN products p ON po.product_id = p.id 
        JOIN categories c ON p.category_id = c.id
        JOIN tax_rates t ON po.tax_id = t.id
        WHERE o.id = ?";

        $this->DBConnect();
        $products = $this->fetchAll($query, array($orderId));
        $productObjects = [];
        foreach ($products as $product) {
            $productObject = new Product();
            $productObject->setId($product['id']);
            $productObject->setName($product['name']);
            $productObject->setPrice($product['price']);
            $productObject->setAmount($product['amount']);
            $productObject->setCategoryName($product['category_name']);
            $productObject->setTaxId($product['tax_id']);
            $productObject->setTaxName($product['tax_name']);
            $productObject->setTaxValue($product['tax_value']);
    
            $productObjects[] = $productObject;
        }
        return $productObjects;
    }



    public function addProduct() {
        $data = array(
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'amount' => $this->getAmount(),
            'category_id' => $this->getCategoryId(),
            'description' => $this->getDescription(),
            'tax_id' => $this->getTaxId()
        );
    
        $this->DBConnect();
        $result = $this->executeInsert('products', $data);
    
        return $result !== false;
    }

    public function updateProduct() {
        $data = array(
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'amount' => $this->getAmount(),
            'category_id' => $this->getCategoryId(),
            'description' => $this->getDescription(),
            'tax_id' => $this->getTaxId()
        );

        $conditions = array(
            'id' => $this->getId()
        );

        $this->DBConnect();
        $result = $this->executeUpdate('products', $data, $conditions);

        return $result !== false;
    }

    public function deleteProduct()
    {
        $table = 'products';
        $conditions = array('id' => $this->getId());
        $this->DBConnect();
        $result = $this->executeDelete($table, $conditions);

        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }


    

    public function getProductData($id) {
        $this->DBConnect();
        $query = "SELECT * FROM products WHERE id=?";
        $result = $this->fetchOne($query,array($id));
        if ($result) {
            $this->setId($result['id']);
            $this->setName($result['name']);
            $this->setPrice($result['price']);
            $this->setAmount($result['amount']);
            $this->setCategoryId($result['category_id']);
            $this->setDescription($result['description']);
            $this->setTaxId($result['tax_id']);
        } else {
            return false;
        }
    }


}
?>
