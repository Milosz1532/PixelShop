<?php
require_once("models/Database.php");
class OrderStatus extends Database {
    private $id;
    private $order_id;
    private $status_id;
    private $status_name;
    private $date_time;

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getOrderId() {
        return $this->order_id;
    }

    public function getStatusId() {
        return $this->status_id;
    }

    public function getDateTime() {
        return $this->date_time;
    }

    public function getStatusName() {
        return $this->status_name;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setOrderId($order_id) {
        $this->order_id = $order_id;
    }

    public function setStatusId($status_id) {
        $this->status_id = $status_id;
    }

    public function setDateTime($date_time) {
        $this->date_time = $date_time;
    }

    public function setStatusName($status_name) {
        $this->status_name = $status_name;
    }

    public function addOrderStatus() {
        $data = array(
            'order_id' => $this->getOrderId(),
            'status_id' => $this->getStatusId(),
            'date_time' => $this->getDateTime(),
        );
        $this->DBConnect();
        $result = $this->executeInsert('orders__statuses', $data);
        return $result !== false;
    }

    public function getOrderStatuses() {
        $query = "SELECT os.id,os.order_id,status_id, s.name as status_name,date_time FROM orders__statuses os
        JOIN statuses s ON s.id = os.status_id
        WHERE order_id =?";

        $this->DBConnect();
        $statuses = $this->fetchAll($query,array($this->getOrderId()));
        $statusesObjects = [];
        foreach ($statuses as $status) {
            $statusObject = new OrderStatus();
            $statusObject->setId($status['id']);
            $statusObject->setOrderId($status['order_id']);
            $statusObject->setStatusId($status['status_id']);
            $statusObject->setStatusName($status['status_name']);
            $statusObject->setDateTime($status['date_time']);

            $statusesObjects[] = $statusObject;
        }
        return $statusesObjects;
    }
}

?>