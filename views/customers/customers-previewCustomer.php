<!DOCTYPE html>
<html lang="pl">

<head>
    <link rel="stylesheet" href="./assets/css/customers.css">
</head>

<body>
    <div class="tab-title emp-config">
        <span class="material-icons">edit</span>
        <h3>Podgląd klienta</h3>
    </div>
    <div class="config-box mt-4">
        <h5 class="title">Dane osobowe</h5>
        <div class="row mt-4">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 text-center">
                <div class="config-input">
                    <p>Numer klienta</p>
                    <input type="text" value="<?php echo $customer->getId();?>" disabled>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 text-center">
                <div class="config-input">
                    <p>Imię</p>
                    <input type="text" value="<?php echo $customer->getFirstName(); ?>" disabled>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 text-center">
                <div class="config-input">
                    <p>Nazwisko</p>
                    <input type="text" value="<?php echo $customer->getLastName(); ?>" disabled>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 text-center">
                <div class="config-input">
                    <p>Numer telefonu</p>
                    <input type="text" value="<?php echo $customer->getPhoneNumber(); ?>" disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="config-box mt-3">
        <h5 class="title">Lista zamówień</h5>
        <div class="table-box mt-3">
            <table class="table customers-tbl text-center mt-2">
                <thead>
                    <tr>
                        <th scope="col">Numer zamówienia</th>
                        <th scope="col">Przygotował</th>
                        <th scope="col">Data złożenia</th>
                        <th scope="col">Status</th>
                        <th scope="col">Zmiana statusu</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if (count($orders) > 0) {
                        foreach ($orders as $order) {
                            $id = $order->getId();
                            $display_id = $order->getDisplayId();

                            $date_time = $order->getOrderedDatetime();

                            $employee = $order->getEmployee();
                            $employee_name = $employee->getFirstName()." ".$employee->getLastName();

                            $status = $order->getStatus();
                            $status_id = $status->getStatusId();
                            $status_name = $status->getStatusName();

                            $canceled = $status_id == 6 ? "canceled" : "";

            
                            echo '
                            <tr class="customerOrder-row" data-id='.$id.'>
                                <th class="orderId" scope="row">'.$display_id.'</th>
                                <td>'.$employee_name.'</td>
                                <td>'.$date_time.'</td>
                                <td><span class="table-status status-'.$status_id.'"><div><span>'.$status_name.'</span></div></td>
                                <td class="medium-col-buttons">
                                    <div class="status-buttons">
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

    <div class="mode-buttons justify-content-center">
        <a href="index.php?section=customers"><button class="submit-button">Powrót</button></a>
    </div>

    <script src="./assets/js/customers.js"></script>

</body>

                                