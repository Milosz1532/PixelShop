<?php
require_once('models/Session.php');
$session = new Session();
$sessionData = $session->get('userData');
if ($sessionData['accountType'] == 0) {
    header("location: index.php");
    return;
}
class EmployeesController extends Controller {
    

    function indexAction() {
        
        require_once('models/Employee.php');
        $employees = Employee::getAllEmployees();
        $this->render('employees/employees-index.php', ['employees' => $employees]);
    }

    function addEmployeeFormAction() {
        $this->render('employees/employees-addEmployeeForm.php');
    }

    function editEmployeeFormAction() {
        require_once('models/Employee.php');
        $id = $_GET['id'];
        $employee = new Employee($id);
        $this->render('employees/employees-editEmployeeForm.php', ['employee' => $employee]);
    }
    
    

    function addEmployeeToDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once('models/Employee.php');
            
            $data = json_decode(file_get_contents('php://input'), true);
            

            $first_name = $data['first_name'];
            $last_name = $data['last_name'];
            $email = $data['email'];
            $phone_number = $data['phone_number'];
            $born = $data['born'];
            $city = $data['city'];
            $login = $data['login'];
            $is_admin = ($data['is_admin'] == true ? 1 : 0);



            $employee = new Employee();
            $employee->setFirstName($first_name);
            $employee->setLastName($last_name);
            $employee->setEmail($email);
            $employee->setPhoneNumber($phone_number);
            $employee->setBorn($born);
            $employee->setCity($city);
            $employee->setLogin($login);
            $employee->setIsAdmin($is_admin);
            $result = $employee->addEmployee();

            if (!$result) {
                $response = array('error' => 'Podany login jest już zajęty');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }

    public function updateEmployeeInDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once("models/Employee.php");
            
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'];
            $first_name = $data['first_name'];
            $last_name = $data['last_name'];
            $email = $data['email'];
            $phone_number = $data['phone_number'];
            $born = $data['born'];
            $city = $data['city'];
            $login = $data['login'];
            $is_admin = ($data['is_admin'] == true ? 1 : 0);

            $employee = new Employee();
            $employee->setId($id);
            $employee->setFirstName($first_name);
            $employee->setLastName($last_name);
            $employee->setEmail($email);
            $employee->setPhoneNumber($phone_number);
            $employee->setBorn($born);
            $employee->setCity($city);
            $employee->setLogin($login);
            $employee->setIsAdmin($is_admin);
            $result = $employee->updateEmployee();

            if (!$result) {
                $response = array('error' => 'Podany login jest już zajęty');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }

    function deleteEmployeeFromDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once("models/Employee.php");
            
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data;

            $employee = new Employee();
            $employee->setId($id);
            $result = $employee->deleteEmployee();

            if (!$result) {
                $response = array('error' => 'Nie udało się usunąć tego pracownika');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }

    function resetEmployeePasswordAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once("models/Employee.php");

            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data;

            $employee = new Employee();
            $employee->setId($id);
            $result = $employee->resetEmployeePassword();

            if (!$result) {
                $response = array('error' => 'Nie udało się zresetować hasła tego pracownika');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }


}
?>
