<?php
require_once("models/Database.php");
require_once("models/Order.php");

class Address extends Database {
    private $id;
    private $client_id;
    private $address;
    private $city;
    private $zip_code;
    private $nip;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getClientId() {
        return $this->client_id;
    }

    public function setClientId($client_id) {
        $this->client_id = $client_id;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getZipCode() {
        return $this->zip_code;
    }

    public function setZipCode($zip_code) {
        $this->zip_code = $zip_code;
    }

    public function getNip() {
        return $this->nip;
    }

    public function setNip($nip) {
        $this->nip = $nip;
    }

    public function __construct($id = null) {
        if ($id) {
            $this->id = $id;
            $this->getAddressData();
        }
    }

    public function getAddressData() {
        $query = "SELECT * FROM addresses WHERE id=?";
        $this->DBConnect();
        $result = $this->fetchOne($query, array($this->id));
        if ($result) {
            $this->id = $result['id'];
            $this->client_id = $result['client_id'];
            $this->address = $result['address'];
            $this->city = $result['city'];
            $this->zip_code = $result['zip_code'];
        }
    }

    public function getLastClientAddress($client_id) {
        // pobranie id ostatniego zamówienia klienta
        $order = new Order();
        $findResult = $order->findLastClientOrder($client_id);
        if ($findResult) {
            $address_id = $order->getAddress()->getId();
            $nip = $order->getNip();
    
            // pobranie adresu klienta z tabeli addresses
            $query = "SELECT address, city, zip_code FROM addresses WHERE id = ?";
            $this->DBConnect();
            $result = $this->fetchOne($query, array($address_id));
    
            if ($result) {
                $address = new Address();
                $address->setAddress($result['address']);
                $address->setCity($result['city']);
                $address->setZipCode($result['zip_code']);
                $address->setNip($nip);
                return $address;
            } else {
                return false;
            }
        }
        
    }

    public function addAddress() {
        $data = array(
            'client_id' => $this->getClientId(),
            'address' => $this->getAddress(),
            'city' => $this->getCity(),
            'zip_code' => $this->getZipCode(),
        );
    
        $this->DBConnect();
        $result = $this->executeInsert('addresses', $data);
        $this->setId($result);
    
        return $result !== false;
    }

    public function checkClientAddress() {
        $query = "SELECT id FROM addresses WHERE client_id = ? AND address = ? AND city = ? AND zip_code = ?";
        $this->DBConnect();
        $result = $this->fetchOne($query, array($this->getClientId(),$this->getAddress(),$this->getCity(),$this->getZipCode()));
        if ($result) {
            $this->setId($result['id']);
            return true;
        }else {

            return false;
        }
    }
}

?>