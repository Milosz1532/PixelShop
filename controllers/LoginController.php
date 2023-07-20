<?php
    require_once('models/User.php');
    require_once('models/Session.php');

    if ($session->isLoggedIn() && isset($_SESSION['userData'])) {
        header("Location: index.php");
    }
    class LoginController extends Controller
    {

        public function indexAction() {
            $this->render('login/login-index.php');
        }

        public function verificationLoginAction() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                $user = new User();
                $result = $user->findByLogin($data);
                if ($result) {
                    if ($result['is_activated'] == 0) {
                        $response = array('login_status' => 3, 'login' => $result['login']);
                        ob_clean();
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    } else {
                        $response = array('login_status' => 2, 'login' => $result['login']);
                        ob_clean();
                        header('Content-Type: application/json');
                        echo json_encode($response);

                    }
                }else {
                    $response = array('error' => 'Nie istnieje taki użytkownik');
                    http_response_code(400);
                    ob_clean();
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            }    
        }

        public function validateAccountAction() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                $username = $data['login'];
                $password = $data['password'];
                $user = new User();
                $result = $user->validateAccount($username,$password);
                if ($result) {
                    $session = new Session();
                    $session->start();
                    $session->set('userData', $user->getData());
                    
                }else {
                    $response = array('error' => 'Hasło jest nieprawidłowe');
                    http_response_code(400);
                    ob_clean();
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            }    
        }

        public function activateAccountAction() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);

                $login = $data['login'];
                $password = $data['password'];

                $user = new User();
                $user->setLogin($login);
                $user->setPassword($password);
                $result = $user->activateAccount();

                if (!$result) {
                    $response = array('error' => 'Nie udało się aktywować twojego konta');
                    http_response_code(400);
                    ob_clean();
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }

            }
        }

        public function logoutAction()
        {
            $session = new Session();
            $session->start();
            $session->logout();
            header('Location: index.php');
            exit();
        }
    }

?>