<!DOCTYPE html>
<html lang="pl">

<head>
    <link rel="stylesheet" href="./assets/css/orders.css">
</head>

<body>
    <div class="tab-title">
        <span class="material-icons">pending_actions</span>
        <h3>Zamówienia</h3>
    </div>

    <div class="row">
        <div class="orders-box-button">
            <h5 class="orders-box-title">Lista zamówień</h5>
            <a href="index.php?section=orders&action=addOrderForm"><button class="addOrder">Dodaj <span class="material-icons">add</span></button></a>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 orders-box">
            <div class="search all-orders mb-1">
                <label>
                    <input type="text" placeholder="Wyszukaj zamówienie...">
                    <span class="material-icons">search</span>
                </label>
            </div>
            <div class="table-box">
                <table class="table text-center mt-2">
                    <thead>
                        <tr>
                            <th scope="col">Numer zamówienia</th>
                            <th scope="col">Odbiorca</th>
                            <th scope="col">Przygotował</th>
                            <th scope="col">Status zamówienia</th>
                            <th class="medium-col" scope="col">Zmiana statusu</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (count($orders) > 0) {
                        foreach ($orders as $order) {
                            $id = $order->getId();
                            $display_id = $order->getDisplayId();
                            
                            $customer = $order->getCustomer();
                            $customer_name = $customer->getFirstName()." ".$customer->getLastName();

                            $employee = $order->getEmployee();
                            $employee_name = $employee->getFirstName()." ".$employee->getLastName();

                            $status = $order->getStatus();
                            $status_id = $status->getStatusId();
                            $status_name = $status->getStatusName();

                            $canceled = $status_id == 6 ? "canceled" : "";

            
                            echo '
                            <tr class="order-row '.$canceled.'" data-id='.$id.'>
                                <th class="orderId" scope="row">'.$display_id.'</th>
                                <td>'.$customer_name.'</td>
                                <td>'.$employee_name.'</td>
                                <td><span class="table-status status-'.$status_id.'"><div><span>'.$status_name.'</span></div></td>
                                <td class="medium-col-buttons">
                                    <div class="buttons">
                                        <div class="button-tooltip ' . ($status_id >= 4 ? 'disabled' : '') . '">
                                            <a data-order='.$id.' data-status=6 class="status-1"><i class="fa-solid fa-trash"></i></a>
                                            <span class="button-tooltip-text" >Anuluj zamówienie</span>
                                        </div>
                                        <div class="button-tooltip ' . ($status_id >= 2 ? 'disabled' : '') . '">
                                            <a data-order='.$id.' data-status=2 class="status-2"><i class="fa-solid fa-box-open"></i></a>
                                            <span class="button-tooltip-text">W trakcie przygotowania</span>
                                        </div>
                                        <div class="button-tooltip ' . ($status_id >= 3 ? 'disabled' : '') . '">
                                        <a data-order='.$id.' data-status=3 class="status-3"><i class="fa-solid fa-clock"></i></a>
                                            <span class="button-tooltip-text">Oczekuje na kuriera</span>
                                        </div>
                                        <div class="button-tooltip ' . ($status_id >= 4 ? 'disabled' : '') . '">
                                        <a data-order='.$id.' data-status=4 class="status-4"><i class="fa-solid fa-truck-arrow-right"></i></a>
                                            <span class="button-tooltip-text">Wysłane</span>
                                        </div>
                                        <div class="button-tooltip ' . ($status_id >= 5 ? 'disabled' : '') . '">
                                        <a data-order='.$id.' data-status=5 class="status-5"><i class="fa-solid fa-truck-ramp-box"></i></a>
                                            <span class="button-tooltip-text">Dostarczone</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            ';
                        };
                    };
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="shadow"></div>
    <script src="./assets/js/orders.js"></script>

</body>

</html>