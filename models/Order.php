<?php
require_once("Database.php");

require_once('models/Customer.php');
require_once('models/Product.php');
require_once("models/Address.php");
require_once("models/Employee.php");
require_once("models/OrderStatus.php");
    class Order extends Database {

        private $id;
        private $customer; // Class Customer
        private $employee; // Class Employee
        private $status; // Class OrderStatus
        private $address; // Class Address


        private $ordered_datetime;
        private $comments;
        private $nip;
        private $order_display_id;


        public function getId() {
            return $this->id;
        }
    
        public function setId($id) {
            $this->id = $id;
        }


        public function getCustomer() {
            return $this->customer;
        }


        public function getEmployee() {
            return $this->employee;
        }

        public function getAddress() {
            return $this->address;
        }

        public function getStatus() {
            return $this->status;
        }


        public function getProducts() {
            return $this->products;
        }

        public function setCustomer($customer) {
            $this->customer = $customer;
        }
        
        public function setEmployee($employee) {
            $this->employee = $employee;
        }
        
        public function setAddress($address) {
            $this->address = $address;
        }
        
        public function setStatus($status) {
            $this->status = $status;
        }
        
        public function setProducts($products) {
            $this->products = $products;
        }
        

    
        public function getOrderedDatetime() {
            return $this->ordered_datetime;
        }
    
        public function setOrderedDatetime($ordered_datetime) {
            $this->ordered_datetime = $ordered_datetime;
        }
    
    
        public function getComments() {
            return $this->comments;
        }
    
        public function setComments($comments) {
            $this->comments = $comments;
        }
    
        public function getNip() {
            return $this->nip;
        }
    
        public function setNip($nip) {
            $this->nip = $nip;
        }
    

        public function getDisplayId() {
            return $this->order_display_id;
        }
    
        public function setDisplayId($order_display_id) {
            $this->order_display_id = $order_display_id;
        }



        public function getNewOrders() {
            $query = 'SELECT o.id AS order_id,o.ordered_datetime, c.id as client_id,e.id as employee_id,
            c.first_name AS client_first_name, c.last_name AS client_last_name,
            c.phone_number,
            e.first_name AS employee_first_name, e.last_name AS employee_last_name, 
            IFNULL(s.name, "Brak statusu") AS status_name, IFNULL(s.id,0) AS status_id
            FROM orders o
            JOIN clients c ON o.client_id = c.id
            JOIN employees e ON o.employee_id = e.id
            LEFT JOIN statuses s ON s.id = (SELECT status_id FROM orders__statuses WHERE order_id = o.id ORDER BY date_time DESC LIMIT 1)
            ORDER BY o.ordered_datetime DESC LIMIT 10';
        
            $this->DBConnect();
            $orders = $this->fetchAll($query);
            $orderObjects = [];
            if ($orders) {
                foreach ($orders as $order) {
                    $orderObject = new Order();
                    $orderObject->setId($order['order_id']);
                    $orderObject->setOrderedDatetime($order['ordered_datetime']);
                    // $orderObject->setDisplayId('ZAM/'.sprintf("%05d", $order['order_id']).'/'.date('ymd', strtotime($order['ordered_datetime'])));
                    $orderObject->setDisplayId('ZAM/'.date('ymd', strtotime($order['ordered_datetime'])).'/'.sprintf("%05d", $order['order_id']));
                    $customer = new Customer();
                    $customer->setId($order['client_id']);
                    $customer->setFirstName($order['client_first_name']);
                    $customer->setLastName($order['client_last_name']);
                    $customer->setPhoneNumber($order['phone_number']);
                    $orderObject->setCustomer($customer);



                    $employee = new Employee();
                    $employee->setId($order['employee_id']);
                    $employee->setFirstName($order['employee_first_name']);
                    $employee->setLastName($order['employee_last_name']);
                    $orderObject->setEmployee($employee);

                    $status = new OrderStatus();
                    $status->setOrderId($order['order_id']);
                    $status->setStatusId($order['status_id']);
                    $status->setStatusName($order['status_name']);
                    $orderObject->setStatus($status);
                    $orderObjects[] = $orderObject;
                }
            }
            return $orderObjects;
        }

        public function getAllOrders() {
            $query = 'SELECT o.id AS order_id,o.ordered_datetime, c.first_name AS client_first_name, c.last_name AS client_last_name,
            e.first_name AS employee_first_name, e.last_name AS employee_last_name, IFNULL(s.name, "Brak statusu") AS status_name, IFNULL(s.id,0) AS status_id
            FROM orders o
            JOIN clients c ON o.client_id = c.id
            JOIN employees e ON o.employee_id = e.id
            LEFT JOIN statuses s ON s.id = (SELECT status_id FROM orders__statuses WHERE order_id = o.id ORDER BY date_time DESC LIMIT 1)
            ORDER BY s.id';
        
            $this->DBConnect();
            $orders = $this->fetchAll($query);
            $orderObjects = [];
            if ($orders) {
                foreach ($orders as $order) {
                    $orderObject = new Order();
                    $orderObject->setId($order['order_id']);
                    $orderObject->setOrderedDatetime($order['ordered_datetime']);
                    // $orderObject->setDisplayId('ZAM/'.sprintf("%05d", $order['order_id']).'/'.date('ymd', strtotime($order['ordered_datetime'])));
                    $orderObject->setDisplayId('ZAM/'.date('ymd', strtotime($order['ordered_datetime'])).'/'.sprintf("%05d", $order['order_id']));
            
                    $customer = new Customer();
                    $customer->setFirstName($order['client_first_name']);
                    $customer->setLastName($order['client_last_name']);
                    $orderObject->setCustomer($customer);



                    $employee = new Employee();
                    $employee->setFirstName($order['employee_first_name']);
                    $employee->setLastName($order['employee_last_name']);
                    $orderObject->setEmployee($employee);

                    $status = new OrderStatus();
                    $status->setOrderId($order['order_id']);
                    $status->setStatusId($order['status_id']);
                    $status->setStatusName($order['status_name']);
                    $orderObject->setStatus($status);
            
            
                    $orderObjects[] = $orderObject;
                };
            };
            return $orderObjects;
        }

        public static function getCustomerOrders($client_id) {
            $query = 'SELECT o.id AS order_id,o.ordered_datetime, c.first_name AS client_first_name, c.last_name AS client_last_name,
            e.first_name AS employee_first_name, e.last_name AS employee_last_name, IFNULL(s.name, "Brak statusu") AS status_name, IFNULL(s.id,0) AS status_id
            FROM orders o
            JOIN clients c ON o.client_id = c.id
            JOIN employees e ON o.employee_id = e.id
            LEFT JOIN statuses s ON s.id = (SELECT status_id FROM orders__statuses WHERE order_id = o.id ORDER BY date_time DESC LIMIT 1)
            WHERE c.id=?';

            $database = new Database();
            $database->DBConnect();
            $orders = $database->fetchAll($query, array($client_id));
            $orderObjects = [];
            if ($orders) {
                foreach ($orders as $order) {
                    $orderObject = new Order();
                    $orderObject->setId($order['order_id']);
                    $orderObject->setOrderedDatetime($order['ordered_datetime']);
                    $orderObject->setDisplayId('ZAM/'.sprintf("%05d", $order['order_id']).'/'.date('ymd', strtotime($order['ordered_datetime'])));
            
                    $customer = new Customer();
                    $customer->setFirstName($order['client_first_name']);
                    $customer->setLastName($order['client_last_name']);
                    $orderObject->setCustomer($customer);



                    $employee = new Employee();
                    $employee->setFirstName($order['employee_first_name']);
                    $employee->setLastName($order['employee_last_name']);
                    $orderObject->setEmployee($employee);

                    $status = new OrderStatus();
                    $status->setOrderId($order['order_id']);
                    $status->setStatusId($order['status_id']);
                    $status->setStatusName($order['status_name']);
                    $orderObject->setStatus($status);
            
            
                    $orderObjects[] = $orderObject;
                }
            }
            return $orderObjects;
        }

        public function findLastClientOrder($client_id) {
            $query = "SELECT address_id, nip FROM orders WHERE client_id = ? ORDER BY id DESC LIMIT 1";
            $this->DBConnect();
            $result = $this->fetchOne($query,array($client_id));
            if ($result) {
                $orderAddress = new Address();
                $orderAddress->setId($result['address_id']);
                $this->address = $orderAddress;
                $this->setNip($result['nip']);
                return true;
            } else {
                return false;
            }
        }

        public function getOrderData($id) {
            $query = 'SELECT o.id as order_id,client_id,employee_id,ordered_datetime, o.address_id, comments, nip, 
            c.first_name as client_first_name , c.last_name as client_last_name, e.first_name as employee_first_name, e.last_name as employee_last_name
            FROM orders o 
            JOIN clients c ON o.client_id = c.id
            JOIN employees e ON o.employee_id = e.id
            WHERE o.id = ?';

            $this->DBConnect();
            $result = $this->fetchOne($query,array($id));
            if ($result) {
                $this->setId($result['order_id']);
                $this->setDisplayId('ZAM/'.sprintf("%05d", $result['order_id']).'/'.date('ymd', strtotime($result['ordered_datetime'])));
                // $this->setClientId($result['client_id']);
                // $this->setEmployeeId($result['employee_id']);
                $this->setOrderedDatetime($result['ordered_datetime']);
                // $this->setAddressId($result['address_id']);
                // $this->setAddress($result['address_id']);
                $this->setComments($result['comments']);
                $this->setNip($result['nip']);
                // $this->setClientName($result['client_name']);
                // $this->setEmployeeName($result['employee_name']);


                $customer = new Customer();
                $customer->setFirstName($result['client_first_name']);
                $customer->setLastName($result['client_last_name']);
                $this->setCustomer($customer);



                $employee = new Employee();
                $employee->setFirstName($result['employee_first_name']);
                $employee->setLastName($result['employee_last_name']);
                $this->setEmployee($employee);

                $address = new Address($result['address_id']);
                $this->setAddress($address);


            } else {
                return false;
            }
        }

        public function addOrder() {
            $data = array(
                'client_id' => $this->customer->getId(),
                'employee_id' => $this->employee->getId(),
                'ordered_datetime' => $this->ordered_datetime,
                'address_id' => $this->address->getId(),
                'comments' => $this->getComments(),
                'nip' => $this->getNip()
            );
        
            $this->DBConnect();
            $result = $this->executeInsert('orders', $data);
            $this->setId($result);
        
            return $result !== false;
        }

        public function changeOrderStatus() {
            $data = array(
                'order_id' => $this->getId(),
                'status_id'=> $this->status->getId(),
                'date_time'=> date('Y-m-d H:i:s'),
            );
    
            $this->DBConnect();
            $result = $this->executeInsert('orders__statuses', $data);
    
            return $result !== false;
        }

        public static function getEmployeesOrders() {
            $query = "SELECT 
                e.first_name, e.last_name, 
                COUNT(*) AS orders_count
                FROM orders o
                JOIN employees e ON o.employee_id = e.id
                WHERE MONTH(o.ordered_datetime) = MONTH(NOW())
                GROUP BY o.employee_id
                ORDER BY orders_count DESC";

            $database = new Database();
            $database->DBConnect();
            $result = $database->fetchAll($query);
            $data = [];
            if ($result) {
                foreach($result as $emp) {
                    $data[] = $emp;
                }
            }
            return $data;
        }

        public static function getOrdersInMonth() {
            $query = 'SELECT months.month, COUNT(orders.ordered_datetime) AS orders_count
            FROM (
              SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION
              SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION
              SELECT 11 UNION SELECT 12
            ) AS months
            LEFT JOIN orders
              ON MONTH(orders.ordered_datetime) = months.month
              AND YEAR(orders.ordered_datetime) = YEAR(CURRENT_DATE())
            GROUP BY months.month';

            $database = new Database();
            $database->DBConnect();
            $result = $database->fetchAll($query);
            $data = [];
            if ($result) {
                foreach($result as $emp) {
                    $data[] = $emp;
                }
            }
            return $data;
        }
        
    }

?>