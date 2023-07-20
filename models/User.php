<?php
require_once("Database.php");
    class User extends Database {
        private $id;
        private $login;
        private $firstName;
        private $lastName;
        private $email;
        private $isAdmin;
        private $password;

        public function __construct($id = null, $login = null, $firstName = null, $lastName = null, $email = null, $isAdmin = null) {
            $this->id = $id;
            $this->login = $login;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
            $this->isAdmin = $isAdmin;
        }

        public function getId() {
            return $this->id;
        }

        public function getLogin() {
            return $this->login;
        }

        public function getFirstName() {
            return $this->firstName;
        }

        public function getLastName() {
            return $this->lastName;
        }

        public function getEmail() {
            return $this->email;
        }

        public function isAdmin() {
            return $this->isAdmin;
        }

        public function setLogin($login) {
            $this->login = $login;
        }

        public function setPassword($password) {
            $this->password = $password;
        }


        public function findByLogin($login) {
            $query = "SELECT * FROM employees WHERE login=? AND is_deleted=0";
            $this->DBConnect();
            $result = $this->fetchOne($query,array($login));
            return $result;
        }

        public function validateAccount($login, $password) {
            $validate = $this->findByLogin($login);
            if (password_verify($password, $validate['password'])) {
                $this->id = $validate['id'];
                $this->login = $validate['login'];
                $this->firstName = $validate['first_name'];
                $this->lastName = $validate['last_name'];
                $this->email = $validate['email'];
                $this->isAdmin = $validate['is_admin'];
                return true;
            } else {
                return false;
            }
        }

        public function getData()
        {
            return [
                'id' => $this->id,
                'login' => $this->login,
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'email' => $this->email,
                'accountType' => $this->isAdmin
            ];
        }
        

        public function activateAccount() {
            $query = "SELECT * FROM employees WHERE login = ?";
            $this->DBConnect();
            $result = $this->fetchOne($query,array($this->login));
            if ($result) {
                $hashed_password = password_hash($this->password, PASSWORD_DEFAULT); 
                $data = array(
                    'is_activated' => 1,
                    'password' => $hashed_password,
                );
        
                $conditions = array(
                    'id' => $result['id']
                );
        
                $activateResult = $this->executeUpdate('employees', $data, $conditions);
        
                return $activateResult ? true : false;
            }
            return false;
        }

    }
?>