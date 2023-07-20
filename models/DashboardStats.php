<?php
require_once("Database.php");
class DashboardStats extends Database {
    private $customers;
    private $orders;
    private $products;
    private $employees;

    public function getCustomers() {
        return $this->customers;
    }
    public function getOrders() {
        return $this->orders;
    }
    public function getProducts() {
        return $this->products;
    }
    public function getEmployees() {
        return $this->employees;
    }


    public function getDashboardStats() {
        $query = 'SELECT 
        (SELECT COUNT(*) FROM clients) AS clients_count, 
        (SELECT COUNT(*) FROM employees WHERE is_deleted = 0) AS employees_count,
        (SELECT COUNT(*) FROM orders) AS orders_count,
        (SELECT COUNT(*) FROM products) AS products_count';

        $this->DBConnect();
        $result = $this->fetchOne($query);
        if ($result) {
            $this->customers = $result['clients_count'];
            $this->employees = $result['employees_count'];
            $this->orders = $result['orders_count'];
            $this->products = $result['products_count'];
        }
        return ($result ? true : false);
    }

}

?>