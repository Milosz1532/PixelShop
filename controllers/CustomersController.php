<?php
class CustomersController extends Controller {

    function indexAction() {
        require_once("models/Customer.php");
        $customer = new Customer();
        $customers = $customer->getAllCustomers();
        $this->render('customers/customers-index.php', ['customers' => $customers]);
    }

    function addCustomerFormAction() {
        $this->render('customers/customers-addCustomerForm.php');
    }

    function previewCustomerAction() {
        require_once('models/Customer.php');
        require_once('models/Order.php');
        $id = $_GET['id'];
        $customer = new Customer($id);
        $orders = Order::getCustomerOrders($id);
        $this->render('customers/customers-previewCustomer.php', ['customer' => $customer, 'orders' => $orders]);
    }

    function addCustomerToDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once("models/Customer.php");
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            $first_name = $data[0]['first_name'];
            $last_name = $data[0]['last_name'];
            $phone_number = $data[0]['phone_number'];



            $customer = new Customer();
            $customer->setPhoneNumber($phone_number);

            // Sprawdz czy numer telefonu nie jest zajęty.
            $checkNumber = $customer->checkCustomerPhoneNumber();
            if ($checkNumber) {
                $response = array('error' => 'Podany numer telefonu jest zajęty.');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            }else {
                $customer->setFirstName($first_name);
                $customer->setLastName($last_name);
                $result = $customer->addCustomer();
    
                if (!$result) {
                    $response = array('error' => 'Nie udało się dodać klienta');
                    http_response_code(400);
                    ob_clean();
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit();
                }else {
                    $response = array($result);
                    echo json_encode($response);
                }
            }
        }
    }


    public function updateCustomerInDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once("models/Customer.php");
            
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data[0]['client_id'];
            $first_name = $data[0]['first_name'];
            $last_name = $data[0]['last_name'];
            $phone_number = $data[0]['phone_number'];

            $customer = new Customer();
            $customer->setId($id);
            $customer->setFirstName($first_name);
            $customer->setLastName($last_name);
            $customer->setPhoneNumber($phone_number);
            $result = $customer->updateCustomer();

            if (!$result) {
                $response = array('error' => 'Podany numer telefonu jest już zajęty');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }


    function deleteCustomerFromDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once("models/Customer.php");
            
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data;

            $customer = new Customer();
            $customer->setId($id);

            try {
                $result = $customer->deleteCustomer();
                if (!$result) {
                    $response = array('error' => 'Nie udało się usunąć tego klienta');
                    http_response_code(400);
                    ob_clean();
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } catch (Exception $e) {
                if (!$result) {
                    $response = array('error' => 'Nie udało się usunąć tego klienta');
                    http_response_code(400);
                    ob_clean();
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            }


        }
    }
}
?>
