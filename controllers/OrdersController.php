<?php
require_once('models/Order.php');
require_once('models/OrderStatus.php');
require_once('models/OrderProduct.php');
require_once('models/Customer.php');
require_once('models/Product.php');
require_once("models/Address.php");
require_once("models/Tax.php");

class OrdersController extends Controller {

    function indexAction() {
        $order = new Order();
        $orders = $order->getAllOrders();
        $this->render('orders/orders-index.php', ['orders' => $orders]);
    }

    function addOrderFormAction() {
        $customer = new Customer();
        $customers = $customer->getAllCustomers();

        // $product = new Product();
        // $products = $product->getAllProducts();
        $products = Product::getAllAvailableProducts();


        $tax = new Tax();
        $taxes = $tax->getAllTaxes();

        $this->render('orders/orders-addOrderForm.php',['customers' => $customers, 'products' => $products, 'taxes' => $taxes]);
    }

    function previewFormAction() {

        $order_id = $_GET['id'];

        $order = new Order();
        $order->getOrderData($order_id);

        $orderStatus = new OrderStatus();
        $orderStatus->setOrderId($order->getId());
        $orderStatuses = $orderStatus->getOrderStatuses();

        $product = new Product();
        $products = $product->getOrderProducts($order->getId());

        $totalPrice = 0;

        // if (productTax != 0) {
        //     totalCost += price * quantity * productTax
        // } else {
        //     totalCost += price * quantity
        // }

        foreach($products as $product) {
            $price = $product->getPrice();
            $amount = $product->getAmount();
            $tax = $product->getTaxValue();
            if ($tax != 0 ) {
                $totalPrice += $price * $amount * $tax;
            }else {
                $totalPrice += $price * $amount;
            }
        }        

        $this->render('orders/orders-previewForm.php', ['order' => $order, 'statuses' => $orderStatuses, 'products' => $products, 'totalPrice' => $totalPrice]);
    }

    function getClientAddressAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'];

            $address = new Address();
            $result = $address->getLastClientAddress($id);
            if ($result) {
                $data = array(
                    'address' => $result->getAddress(),
                    'city' => $result->getCity(),
                    'zip_code' => $result->getZipCode(),
                    'nip' => $result->getNip(),
                );
                
                header('Content-Type: application/json');
                echo json_encode($data);
            }else {
                echo json_encode([]);
            }
        }
    }

    public function addOrderToDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            // dodaj nowe zamówienie
            $client_id = intval($data[0]['clientId']);
            $employee_id = intval($data[0]['employeeId']);
            $ordered_datetime = date('Y-m-d H:i:s');
            $address = $data[1]['address'];
            $city = $data[1]['city'];
            $zip_code = $data[1]['zip_code'];
            $comments = $data[1]['comments'] == "" ? NULL : $data[1]['comments'];
            $nip = $data[1]['nip'] == "" ? NULL : $data[1]['nip'];
            $status_id = 1;


            // Sprawdzanie stanu magazynowego
            foreach ($data as $item) {
                if (isset($item['productId'])) {
                    $product_id = $item['productId'];
                    $order_amount = $item['quantity'];

                    $product = new Product();
                    $product->getProductData($product_id);

                    if($product->getAmount() < $order_amount) {
                        header('Content-Type: application/json');
                        http_response_code(400);
                        $response = array('error' => 'W magazynie jest niewystarczająca ilość produktów');
                        echo json_encode($response);
                        break;
                        exit();
                    }
                }
            }



            // dodaj adres
            $client_address = new Address();
            $client_address->setClientId($client_id);
            $client_address->setAddress($address);
            $client_address->setCity($city);
            $client_address->setZipCode($zip_code);
            $address_result = $client_address->checkClientAddress();

            if (!$address_result) {
                 // Adres nie istnieje, dodaj go do tabeli
                $client_address->addAddress();
            }


            //dodaj zamówienie
            $order = new Order();



            $orderCustomer = new Customer();
            $orderCustomer->setId($client_id);
            $order->setCustomer($orderCustomer);
            
            

            $orderEmployee = new Employee();
            $orderEmployee->setId($employee_id);
            $order->setEmployee($orderEmployee);
            
            $order->setOrderedDatetime($ordered_datetime);
            

            // $order->setAddressId($client_address->getId());
            // $orderAddress = new Address();
            // $orderAddress->setId($client_address->getId());
            // $order->setAddress($orderAddress);

            $order->setAddress($client_address);

            $order->setComments($comments);
            
            $order->setNip($nip);
            

            
            $order->addOrder();

            $order_id = $order->getId();


            //dodaj status zamówienia
            $order_status = new OrderStatus();
            $order_status->setOrderId($order_id);
            $order_status->setStatusId($status_id);
            $order_status->setDateTime($ordered_datetime);

            $order_status->addOrderStatus();



            foreach ($data as $item) {
                if (isset($item['productId'])) {

                    $amount = $item['quantity'];
                    $price = $item['productPrice'];
                    $product_id = $item['productId'];
                    $tax_id = $item['taxId'];




                    $product = new Product();
                    $product->getProductData($product_id);
                    $product->setAmount($product->getAmount()-$amount);
                    $product->updateProduct();

                    $order_product = new OrderProduct();
                    $order_product->setProductId($product_id);
                    $order_product->setOrderId($order_id);
                    $order_product->setAmount($amount);
                    $order_product->setPrice($price);
                    $order_product->setTaxId($tax_id);
                    $order_product->addOrderProduct();
                }
            }
        }
    }

    public function changeOrderStatusAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $orderId = $data['orderId'];
            $statusId = $data['statusId'];
            $order = new Order();
            $order->setId($orderId);
            $status = new OrderStatus();
            $status->setId($statusId);
            $order->setStatus($status);
            $result = $order->changeOrderStatus();

            if (!$result) {
                $response = array('error' => 'Nie udało się zmienić statusu zamówienia.');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }
}
?>
