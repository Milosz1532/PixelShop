<?php
require_once("models/Database.php");
class OrderProduct extends Database {
    private $id;
    private $product_id;
    private $order_id;
    private $amount;
    private $price;
    private $tax_id;

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function getOrderId() {
        return $this->order_id;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getTaxId() {
        return $this->tax_id;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setProductId($product_id) {
        $this->product_id = $product_id;
    }

    public function setOrderId($order_id) {
        $this->order_id = $order_id;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setTaxId($tax_id) {
        $this->tax_id = $tax_id;
    }

    public function addOrderProduct() {
        $data = array(
            'product_id' => $this->getProductId(),
            'order_id' => $this->getOrderId(),
            'amount' => $this->getAmount(),
            'price' => $this->getPrice(),
            'tax_id' => $this->getTaxId(),
        );
        $this->DBConnect();
        $result = $this->executeInsert('product__order', $data);
        return $result !== false;
    }
}


?>