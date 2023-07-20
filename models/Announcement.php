<?php
require_once("Database.php");
class Announcement extends Database {

    private $id;
    private $datetime;
    private $message;
    private $employee_id;
    private $employee_firstName;
    private $employee_lastName;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDatetime() {
        return $this->datetime;
    }

    public function setDatetime($datetime) {
        $this->datetime = $datetime;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getEmployeeId() {
        return $this->employee_id;
    }

    public function setEmployeeId($employee_id) {
        $this->employee_id = $employee_id;
    }

    public function getEmployeeFirstName() {
        return $this->employee_firstName;
    }

    public function setEmployeeFirstName($employee_firstName) {
        $this->employee_firstName = $employee_firstName;
    }

    public function getEmployeeLastName() {
        return $this->employee_lastName;
    }

    public function setEmployeeLastName($employee_lastName) {
        $this->employee_lastName = $employee_lastName;
    }

    public function addAnnouncement() {
        $data = array(
            'datetime' => $this->datetime,
            'message' => $this->message,
            'employee_id' => $this->employee_id
        );

        $this->DBConnect();
        $result = $this->executeInsert('announcements', $data);
    
        return $result !== false;

    }

    

    public static function getAllAnnouncements() {
        $query = 'SELECT a.id as announcement_id, a.datetime, a.message, a.employee_id, e.first_name,e.last_name FROM `announcements` a
        JOIN employees e ON e.id = a.employee_id ORDER BY datetime DESC LIMIT 10';
        $database = new Database();
        $database->DBConnect();
        $announcements = $database->fetchAll($query);
        $announcementsObjects = [];
        if ($announcements) {
            foreach ($announcements as $announcement) {
                $announcementObject = new Announcement();
                $announcementObject->setId($announcement['announcement_id']);
                $announcementObject->setDatetime($announcement['datetime']);
                $announcementObject->setMessage($announcement['message']);
                $announcementObject->setEmployeeId($announcement['employee_id']);
                $announcementObject->setEmployeeFirstName($announcement['first_name']);
                $announcementObject->setEmployeeLastName($announcement['last_name']);
                $announcementsObjects[] = $announcementObject;
            }
        }
        return $announcementsObjects;
    }
    
}
?>
