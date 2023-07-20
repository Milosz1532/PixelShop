<?php
require_once("Database.php");
class Customer extends Database {

    private $id;
    private $first_name;
    private $last_name;
    private $phone_number;
    private $orders_count;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function getPhoneNumber() {
        return $this->phone_number;
    }

    public function setPhoneNumber($phone_number) {
        $this->phone_number = $phone_number;
    }

    public function getOrdersCount() {
        return $this->orders_count;
    }

    public function setOrdersCount($orders_count) {
        $this->orders_count = $orders_count;
    }

    public function __construct($id = null) {
        if ($id) {
            $this->id = $id;
            $this->getCustomerData();
        }
    }

    public function getCustomerData() {
        $query = 'SELECT * FROM clients WHERE id=?';
        $this->DBConnect();
        $result = $this->fetchOne($query, array($this->id));
        if ($result) {
            $this->first_name = $result['first_name'];
            $this->last_name = $result['last_name'];
            $this->phone_number = $result['phone_number'];
        }
    }



    public function getAllCustomers() {
        $query = 'SELECT c.id AS client_id,c.first_name,c.last_name,c.phone_number,COUNT(o.id) AS orders_count FROM clients c
        LEFT JOIN orders o ON o.client_id = c.id GROUP BY c.id';

        $this->DBConnect();
        $customers = $this->fetchAll($query);
        $customerObjects = [];
        foreach ($customers as $customer) {
            $customerObject = new Customer();
            $customerObject->setId($customer['client_id']);
            $customerObject->setFirstName($customer['first_name']);
            $customerObject->setLastName($customer['last_name']);
            $customerObject->setPhoneNumber($customer['phone_number']);
            $customerObject->setOrdersCount($customer['orders_count']);

            $customerObjects[] = $customerObject;
        }
        return $customerObjects;
    }

    public function checkCustomerPhoneNumber() {
        $query = "SELECT * FROM clients WHERE phone_number=?";
        $this->DBConnect();
        $result = $this->fetchOne($query, array($this->phone_number));
        return ($result ? true : false);
    }

    public function addCustomer() {
        $data = array(
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
        );
    
        $this->DBConnect();
        $result = $this->executeInsert('clients', $data);
    
        return $result;
    }

    
    public function updateCustomer() {
        $data = array(
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,

        );

        $conditions = array(
            'id' => $this->id
        );

        $this->DBConnect();

        $checkNumber = "SELECT * FROM clients WHERE phone_number=? AND id!=?";
        $checkNumberResult = $this->fetchOne($checkNumber, array($this->phone_number, $this->id));
        if ($checkNumberResult == false) {
            $result = $this->executeUpdate('clients', $data, $conditions);
            return true;
        }else {
            return false;
        }
    }


    public function deleteCustomer() {
        $table = 'clients';
        $conditions = array('id' => $this->id);
        $this->DBConnect();
        $result = $this->executeDelete($table, $conditions);

        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>
