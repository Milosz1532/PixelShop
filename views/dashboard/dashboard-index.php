<!DOCTYPE html>
<html lang="pl">

<head>
    <link rel="stylesheet" href="./assets/css/dashboard.css">
</head>

<body>
    <div class="tab-title">
        <span class="material-icons">home</span>
        <h3>Dashboard</h3>
    </div>
    <!-------------------- CARDS ----------------- -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-card card-1">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3>
                                    <?php echo $dashboardStats->getCustomers() ?>
                                </h3>
                                <span>Klienci</span>
                            </div>
                            <div class="align-self-center">
                                <span class="material-icons">group</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-card card-2">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3>
                                    <?php echo $dashboardStats->getOrders() ?>
                                </h3>
                                <span>Zamówienia</span>
                            </div>
                            <div class="align-self-center">
                                <span class="material-icons">local_grocery_store</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-card card-3">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3>
                                <?php echo $dashboardStats->getProducts() ?>
                                    
                                </h3>
                                <span>Produkty</span>
                            </div>
                            <div class="align-self-center">
                                <span class="material-icons">insights</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-card card-4">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3>
                                    <?php echo $dashboardStats->getEmployees() ?>
                                </h3>
                                <span>Pracownicy</span>
                            </div>
                            <div class="align-self-center">
                                <span class="material-icons">diversity_3</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-9 col-lg-9 col-12 mt-4">
            <h5 class="dashboard-box-title">Ostatnie zamówienia</h5>
            <div class="dashboard-box orders">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th scope="col">Numer zamówienia</th>
                            <th scope="col">Klient</th>
                            <th scope="col">Przygotował</th>
                            <th scope="col">Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (count($newOrders) > 0) {
                                foreach($newOrders as $order) {

                                    $customer = $order->getCustomer();
                                    $customer_name = $customer->getFirstName()." ".$customer->getLastName();

                                    $employee = $order->getEmployee();
                                    $employee_name = $employee->getFirstName()." ".$employee->getLastName();

                                    $status = $order->getStatus();

                                    $canceled = $status->getStatusId() == 6 ? "canceled" : "";

                                    echo '
                                    <tr class="dashboard-order-row '.$canceled.'" data-id='.$order->getId().'>
                                        <th class="orderId" scope="row">'.$order->getDisplayId().'</th>
                                        <td>'.$customer_name.'</td>
                                        <td>'.$employee_name.'</td>
                                        <td><span class="table-status status-'.$status->getStatusId().'"><div><span>'.$status->getStatusName().'</span></div></td>
                                    </tr>
                                    ';
                                };
                            }
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-12 mt-4">
            <div class="messages-button">
                <h5 class="dashboard-box-title">Ważne wiadomości</h5>
                <?php if ($_SESSION['userData']['accountType'] == 1 )  echo '<span class="material-icons add-message">add</span>'?>

            </div>

            <div class="dashboard-box">
                <div class="messages">
                    <!-- <div class="message-box">
                        <div class="content">
                            <div class="icon">
                                <span>MK</span>
                            </div>
                            <span class="text"><strong>Miłosz Konopka</strong> Proszę usunąć wszystkie
                                produkty z kategorii karty graficzne</span>

                        </div>
                        <span class="date">19.03.2023 02:03</span>
                    </div> -->
                    <?php
                        foreach ($announcements as $announcement) {
                            $id = $announcement->getId();
                            $date = $announcement->getDatetime();
                            $message = $announcement->getMessage();
                            $employee_firstName = $announcement->getEmployeeFirstName();
                            $employee_lastName = $announcement->getEmployeeLastName();
                            $employee = $employee_firstName." ".$employee_lastName;
                            $icon = strtoupper(substr($employee_firstName, 0, 1)).''.strtoupper(substr($employee_lastName, 0, 1));
            
                            echo '
                                <div class="message-box">
                                    <div class="content">
                                        <div class="icon">
                                            <span>'.$icon.'</span>
                                        </div>
                                        <span class="text"><strong>'.$employee.'</strong> '.$message.'</span>
                                    </div>
                                    <span class="date">'.$date.'</span>
                                </div>
                            ';
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-8">
            <h5 class="dashboard-box-title mt-3">Ilość zamówień</h5>
            <div class="chart-box">
                <div class="chart">
                    <canvas id="dashboard-chart-1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h5 class="dashboard-box-title mt-3">Aktywność pracowników</h5>
            <div class="chart-box">
                <div class="chart pt-3">
                    <canvas id="dashboard-chart-2"></canvas>
                </div>
            </div>
        </div>
    </div>

    <section class="popup-window">
            <h5>Dodawanie wiadomości</h5>
            <textarea name="message" id="messageForm-message" cols="30" rows="3" placeholder="Wiadomość..."></textarea>
            <div class="buttons">
                <button id="cancel">Anuluj</button>
                <button id="submit">Dodaj</button>
            </div>
            <?php
                $session = new Session();
                $sessionData = $session->get('userData');
            ?>
            <input id="messageForm-employee-id" type="hidden" value="<?php echo $sessionData['id'] ?>">
    </section>
    <div class="shadow"></div>
    

    <script>
        var employeesOrdersData = <?php echo json_encode($employeeChart); ?>;
        var ordersInMonthData = <?php echo json_encode($ordersChart); ?>;
    </script>
    <script src="./assets/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./assets/js/charts.js"></script>

</body>

</html>