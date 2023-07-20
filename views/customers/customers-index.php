<!DOCTYPE html>
<html lang="pl">

<head>
    <link rel="stylesheet" href="./assets/css/customers.css">
</head>

<body>
    <div class="tab-title">
        <span class="material-icons">assignment_ind</span>
        <h3>Klienci</h3>
    </div>

    <div class="errorBox">
        <span class="material-icons"></span>
        <span class="error-message"></span>
    </div>

    <div class="row">
        <div class="customers-box-button">
            <h5 class="customers-box-title">Lista klientów</h5>
            <button class="addCustomer">Dodaj <span class="material-icons">add</span></button>
        </div>
    </div>
    

    <div class="row mt-2">
        <div class="col-12 customers-box">
            <div class="search all-orders mb-1">
                <label>
                    <input type="text" placeholder="Wyszukaj klienta...">
                    <span class="material-icons">search</span>
                </label>
            </div>
            <div class="table-box">
                <table class="table customers-tbl text-center mt-2">
                    <thead>
                        <tr>
                            <th scope="col">Numer klienta</th>
                            <th scope="col">Imię i Nazwisko</th>
                            <th scope="col">Numer telefonu</th>
                            <th scope="col">Ilość zamówień</th>
                            <th scope="col">Operacje</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($customers as $customer) {
                            $id = $customer->getId();
                            $first_name = $customer->getFirstName();
                            $last_name = $customer->getLastName();
                            $phone_number = $customer->getPhoneNumber();
                            $orders_count = $customer->getOrdersCount();
                            $deleteId = $customer->getId();
                            echo '
                            <tr class="customer-row" data-id='.$id.'>
                                <th scope="row">'.$id.'</th>
                                <td>'.$first_name.' '.$last_name.'</td>
                                <td>'.$phone_number.'</td>
                                <td>'.$orders_count.'</td>
                                <td class="td-buttons">
                                <div class="buttons">
                                    <a class="editCustomer" data-id='.$id.' data-first-name='.$first_name.' data-last-name='.$last_name.' data-phone-number='.$phone_number.' ><button><span class="material-icons">edit</span></button></a>
                                    <a class="deleteCustomer" data-id='.$deleteId.'><button"><span class="material-icons">delete</span></button></a>
                                </div>
                            </td>
                            </tr>
                            ';
                        };
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="add-user-box">
        <h4 class="title">Dodawanie klienta</h4>
        <div class="config-input">
            <p>Imię</p>
            <input id="first_name" name="first_name" type="text" placeholder="Wprowadz imię...">
        </div>
        <div class="config-input">
            <p>Nazwisko</p>
            <input id="last_name" name="last_name" type="text" placeholder="Wprowadz nazwisko...">
        </div>
        <div class="config-input">
            <p>Numer telefonu</p>
            <input id="phone_number" name="phone_number" type="text" maxlength="10"
                placeholder="Wprowadz numer telefonu...">
        </div>
        <p class="cb-info"></p>
        <div class="buttons">
            <button id="cb-submit">Dodaj Klienta</button>
            <button id="cb-cancel">Anuluj</button>
        </div>
    </div>
    <div class="shadow"></div>
    <script src="./assets/js/customers.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>