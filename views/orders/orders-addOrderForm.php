<!DOCTYPE html>
<html lang="pl">

<head>
    <link rel="stylesheet" href="./assets/css/orders.css">
</head>

<body>
    <div class="tab-title emp-config">
        <span class="material-icons">edit</span>
        <h3>Kreator zamówień</h3>
    </div>




    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12 order-box-mode">
            <div class="box">
                <h5 class="title">Wybierz klienta</h5>
                <div class="col-12"></div>
                <div class="row">
                    <div class="search client">
                        <label>
                            <input type="text" placeholder="Wyszukaj klienta...">
                            <span class="material-icons">search</span>
                        </label>
                    </div>
                </div>
                <div class="table-scroll-box">
                    <table class="table text-center clients-table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Imię</th>
                                <th scope="col">Nazwisko</th>
                                <th scope="col">Telefon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($customers as $customer) {
                                    $id = $customer->getId();
                                    $first_name = $customer->getFirstName();
                                    $last_name = $customer->getLastName();
                                    $phone_number = $customer->getPhoneNumber();

                                    echo '
                                    <tr class="select-client" data-client-id="'.$id.'">
                                        <th scope="row">'.$id.'</th>
                                        <td class="client_first_name">'.$first_name.'</td>
                                        <td class="client_last_name">'.$last_name.'</td>
                                        <td class="client_phone_number">'.$phone_number.'</td>
                                    </tr> 
                                    ';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="buttons d-flex justify-content-center mt-2">
                    <button class="addClient-button">Dodaj klienta</button>
                </div>
            </div>
        </div>
        <!-- PRODUKTY -->
        <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12 order-box-mode">
            <div class="box products">
                <h5 class="title">Wybierz produkty</h5>
                <div class="col-12"></div>
                <div class="row">
                    <div class="search product">
                        <label>
                            <input type="text" placeholder="Wyszukaj produkt...">
                            <span class="material-icons">search</span>
                        </label>
                    </div>
                </div>
                <div class="table-scroll-box">
                    <table class="table text-center products-table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nazwa</th>
                                <th scope="col">Kategoria</th>
                                <th scope="col">Cena</th>
                                <th scope="col">Zasobność</th>
                                <th scope="col">Podatek</th>
                                <th scope="col">Ilość</th>
                            </tr>
                        </thead>



                        <tbody>
                            <?php
                                foreach($products as $product) {
                                    $id = $product->getId();
                                    $name = $product->getName();
                                    $category = $product->getCategoryName();
                                    $price = $product->getPrice();
                                    $amount = $product->getAmount();
                                    $tax_id = $product->getTaxId();


                                    echo '
                                        <tr class="product-row">
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck'.$id.'">
                                                    <label class="custom-control-label" for="customCheck'.$id.'">'.$id.'</label>
                                                </div>
                                            </td>
                                            <td>'.$name.'</td>
                                            <td>'.$category.'</td>
                                            <td class="price-cell">'.$price.'</td>
                                            <td>'.$amount.'</td>
                                            <td class="tax-cell">
                                                <select name="selectTax" class="selectTax">';
                                                foreach($taxes as $tax) {
                                                    $selected = ($tax->getId() == $tax_id) ? 'selected' : '';
                                                    echo '<option value="'.$tax->getId().'" data-tax="'.$tax->getTax().'" '.$selected.'>'.$tax->getName().'</option>';
                                                }
                                                echo '
                                                </select>
                                            </td>
                                            <td class="quantity-cell">
                                                <input type="number" min="1" value="1" max="'.$amount.'">
                                            </td>
                                        </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 total-box ">
        <div class="box total">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-12 text-center">
                    <h5 class="title">Dane do dostawy</h5>
                    <hr>
                    <div class="orders-input">
                        <p>Adres dostawy</p>
                        <input id="total_address" name="total_address" type="text"
                            placeholder="Wprowadz adres dostawy...">
                    </div>
                    <div class="orders-input">
                        <p>Miasto</p>
                        <input id="total_city" name="total_city" type="text" placeholder="Wprowadz miasto...">
                    </div>
                    <div class="orders-input">
                        <p>Kod pocztowy</p>
                        <input id="total_zip_code" name="total_zip_code" type="text"
                            placeholder="Wprowadz kod pocztowy...">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-12 text-center">
                    <h5 class="title">Dane do faktury</h5>
                    <hr>
                    <div class="orders-input">
                        <p>Imię i Nazwisko</p>
                        <input id="clientName" disabled name="name" type="text"
                            placeholder="Wprowadz imię i nazwisko...">
                    </div>
                    <div class="orders-input">
                        <p>NIP / PESEL</p>
                        <input id="total_nip" name="total_nip" type="text" maxlength="11"
                            placeholder="Wprowadz NIP/PESEL...">
                    </div>
                    <!-- <div class="orders-input">
                        <p>Opodatkowanie</p>
                        <select name="selectTax" id="selectTax">
                        </select>
                    </div> -->
                    <div class="orders-input">
                        <p>Łączny koszt</p>
                        <input id="totalCost" name="totalCost" type="text" disabled>
                    </div>
                </div>
                <div class="col-12 text-center">
                <div class="orders-input">
                        <p>Uwagi do zamówienia</p>
                        <textarea id="total_comments" name="total_comments" type="text"
                            placeholder="Wprowadz uwagi..."></textarea>
                    </div>
                </div>
                <div class="text-left ">
                        <p class="total-info"></p>
                    </div>
            </div>

        </div>
    </div>
    <input type="hidden" id="employeeId" value="<?php echo $_SESSION['userData']['id']; ?>">
    <div class="mode-buttons">
        <button class="cancel-button">Anuluj</button>
        <button class="submit-button">Utwórz zamówienie</button>
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


    <script src="./assets/js/orders.js"></script>

</body>

</html>