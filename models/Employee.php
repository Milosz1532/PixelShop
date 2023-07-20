<?php
require_once("Database.php");
class Employee extends Database {

    private $id;
    private $first_name;
    private $last_name;
    private $email;
    private $phone_number;
    private $born;
    private $city;
    private $login;
    private $password;
    private $is_activated;
    private $is_admin;
    private $is_deleted;

    public function getId() {
        return $this->id;
    }

    public function getIsDeleted() {
        return $this->is_deleted;
    }


    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhoneNumber() {
        return $this->phone_number;
    }

    public function getBorn() {
        return $this->born;
    }

    public function getCity() {
        return $this->city;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getIsActivated() {
        return $this->is_activated;
    }

    public function getIsAdmin() {
        return $this->is_admin;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhoneNumber($phone_number) {
        $this->phone_number = $phone_number;
    }

    public function setBorn($born) {
        $this->born = $born;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setIsActivated($is_activated) {
        $this->is_activated = $is_activated;
    }

    public function setIsAdmin($is_admin) {
        $this->is_admin = $is_admin;
    }

    public function setIsDeleted($is_deleted) {
        $this->is_deleted = $is_deleted;
    }

    public function __construct($id = null) {
        if ($id) {
            $this->id = $id;
            $this->getEmployeeData();
        }
    }

    public function getEmployeeData() {
        $query = "SELECT * FROM employees WHERE id=?";
        $this->DBConnect();
        $result = $this->fetchOne($query, array($this->id));
        if ($result) {
            $this->first_name = $result['first_name'];
            $this->last_name = $result['last_name'];
            $this->email = $result['email'];
            $this->phone_number = $result['phone_number'];
            $this->born = $result['born'];
            $this->city = $result['city'];
            $this->login = $result['login'];
            $this->is_admin = $result['is_admin'];
        }
    }

    public function addEmployee() {
        $data = array(
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'born' => $this->born,
            'city' => $this->email,
            'login' => $this->login,
            'is_admin' => $this->is_admin
        );
    
        $this->DBConnect();
        
        $checkLogin = "SELECT * FROM employees WHERE login=?";
        $checkLoginResult = $this->fetchOne($checkLogin, array($this->login));
        if ($checkLoginResult == false) {
            $result = $this->executeInsert('employees', $data);
            return true;
        }else {
            return false;
        }
    
        return $result !== false;
    }

    public function updateEmployee() {
        $data = array(
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'born' => $this->born,
            'city' => $this->email,
            'login' => $this->login,
            'is_admin' => $this->is_admin
        );

        $conditions = array(
            'id' => $this->id
        );

        $this->DBConnect();

        $checkLogin = "SELECT * FROM employees WHERE login=? AND id!=?";
        $checkLoginResult = $this->fetchOne($checkLogin, array($this->login, $this->id));
        if ($checkLoginResult == false) {
            $result = $this->executeUpdate('employees', $data, $conditions);
            return true;
        }else {
            return false;
        }
    }

    public function deleteEmployee() {
        // $table = 'employees';
        // $conditions = array('id' => $this->id);
        // $this->DBConnect();
        // $result = $this->executeDelete($table, $conditions);
        // return $result;
        // // if ($result > 0) {
        // //     return true;
        // // } else {
        // //     return false;
        // // }
        $data = array(
            'is_deleted' => 1,
        );

        $conditions = array(
            'id' => $this->id
        );

        $this->DBConnect();
        $result = $this->executeUpdate('employees', $data, $conditions);

        return $result ? true : false;
    }

    public function resetEmployeePassword() {
        $data = array(
            'is_activated' => 0,
        );

        $conditions = array(
            'id' => $this->id
        );

        $this->DBConnect();
        $result = $this->executeUpdate('employees', $data, $conditions);

        return $result ? true : false;

    }



    public static function getAllEmployees() {
        $database = new Database();
        $database->DBConnect();
        $query = 'SELECT * FROM `employees` ORDER BY is_deleted';
        $employees = $database->fetchAll($query);
        $employeesObjects = [];
        foreach ($employees as $employee) {
            $employeeObject = new Employee();
            $employeeObject->setId($employee['id']);
            $employeeObject->setFirstName($employee['first_name']);
            $employeeObject->setLastName($employee['last_name']);
            $employeeObject->setIsAdmin($employee['is_admin']);
            $employeeObject->setIsDeleted($employee['is_deleted']);

            $employeesObjects[] = $employeeObject;
        }
        return $employeesObjects;
    }
}
?>
