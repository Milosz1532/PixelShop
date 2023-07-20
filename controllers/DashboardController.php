<?php
class DashboardController extends Controller {
    function indexAction() {
        require_once('models/Order.php');
        require_once('models/DashboardStats.php');
        require_once('models/Announcement.php');

        $order = new Order();
        $orders = $order->getNewOrders();
        $dashboardStats = new DashboardStats();
        $dashboardStats->getDashboardStats();

        $employeeChart = Order::getEmployeesOrders();
        $ordersChart = Order::getOrdersInMonth();

        $announcements = Announcement::getAllAnnouncements();




        $this->render('dashboard/dashboard-index.php', ['newOrders' => $orders, 'dashboardStats' => $dashboardStats, 'employeeChart' => $employeeChart, 'ordersChart' => $ordersChart, 'announcements' => $announcements]);
    }

    function addAnnouncementToDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once('models/Announcement.php');
            
            $data = json_decode(file_get_contents('php://input'), true);
            

            $message = $data['message'];
            $employee_id = $data['employee_id'];
            $datetime = date('Y-m-d H:i:s');

            $announcement = new Announcement();
            $announcement->setMessage($message);
            $announcement->setEmployeeId($employee_id);
            $announcement->setDateTime($datetime);
            $result = $announcement->addAnnouncement();
            if (!$result) {
                $response = array('error' => 'Nie udało się dodać tego produktu');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }
}

?>