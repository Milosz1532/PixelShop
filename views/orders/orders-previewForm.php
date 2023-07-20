<!DOCTYPE html>
<html lang="pl">

<head>
    <link rel="stylesheet" href="./assets/css/orders.css">
</head>

<body>
    <div class="tab-title emp-config">
        <span class="material-icons">edit</span>
        <h3>Podgląd zamówienia</h3>
    </div>


    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12 order-box-mode">
            <div class="box scroll-box">
                <h5 class="title">Informacje o zamówieniu</h5>
                <div class="col-12"></div>
                <div class="preview-info">
                    <p>Zamówienie numer: <span>
                        <?php echo $order->getDisplayId() ?>
                        </span></p>
                    <p>Data utworzenia: <span>
                        <?php echo $order->getOrderedDatetime() ?>
                        </span></p>
                    <p>Przygotował: <span>
                        <?php echo ''.$order->getEmployee()->getFirstName().' '.$order->getEmployee()->getLastName()?>
                        </span></p>
                    <p>Telefon do klienta:<span>
                        <?php echo $order->getCustomer()->getPhoneNumber(); ?>
                        </span></p>
                </div>


                <p class="total-title">Historia statusów</p>
                <table class="table total-status-table text-center">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Numer</th>
                            <th scope="col">Nazwa</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Statusy -->
                        <?php
                            foreach($statuses as $status) {
                                $id = $status->getStatusId();
                                $status_name = $status->getStatusName();
                                $status_date = $status->getDateTime();

                                echo '
                                <tr class="status-row">
                                    <th scope="row">'.$id.'</th>
                                    <td>'.$status_name.'</td>
                                    <td>'.$status_date.'</td>
                                </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
        <!-- PRODUKTY -->
        <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12 order-box-mode">
            <div class="box products">
                <h5 class="title">Produkty w zamówieniu</h5>
                <div class="col-12"></div>

                <div class="table-scroll-box">
                    <table class="table text-center total-products-table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nazwa</th>
                                <th scope="col">Kategoria</th>
                                <th class="price-cell" scope="col">Cena</th>
                                <th scope="col">Podatek</th>
                                <th scope="col">Ilość</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- LISTA -->
                            <?php
                                $temp_id = 1;
                                foreach($products as $product) {
                                    $id = $product->getId();
                                    $name = $product->getName();
                                    $price = $product->getPrice();
                                    $category = $product->getCategoryName();
                                    $tax = $product->getTaxName();
                                    $amount = $product->getAmount();

                                    echo '
                                    <tr class="product-row">
                                        <th scope="row">'.$temp_id.'</th>
                                        <td>'.$name.'</td>
                                        <td>'.$category.'</td>
                                        <td>'.$price.'</td>
                                        <td>'.$tax.'</td>
                                        <td>'.$amount.'</td>
                                    </tr>
                                    ';
                                    $temp_id++;
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
                            placeholder="Wprowadz adres dostawy..." disabled
                            value="<?php echo $order->getAddress()->getAddress() ?>">
                    </div>
                    <div class="orders-input">
                        <p>Miasto</p>
                        <input id="total_city" name="total_city" type="text" placeholder="Wprowadz miasto..." disabled
                            value="<?php echo $order->getAddress()->getCity()  ?>">
                    </div>
                    <div class="orders-input">
                        <p>Kod pocztowy</p>
                        <input id="total_zip_code" name="total_zip_code" type="text"
                            placeholder="Wprowadz kod pocztowy..." disabled
                            value="<?php echo $order->getAddress()->getZipCode();  ?>">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-12 text-center">
                    <h5 class="title">Dane do faktury</h5>
                    <hr>
                    <div class="orders-input">
                        <p>Imię i Nazwisko</p>
                        <input id="clientName" disabled name="name" type="text"
                            placeholder="Wprowadz imię i nazwisko..."
                            value="<?php echo ''.$order->getCustomer()->getFirstName().' '.$order->getCustomer()->getLastName() ?>">
                    </div>
                    <div class="orders-input">
                        <p>NIP / PESEL</p>
                        <input id="total_nip" name="total_nip" type="text" maxlength="11"
                            placeholder="Wprowadz NIP/PESEL..." disabled value="<?php echo $order->getNip() ?>">
                    </div>

                    <div class="orders-input">
                        <p>Łączny koszt</p>
                        <input id="totalCost" name="totalCost" type="text" disabled
                            value="<?php echo $totalPrice?> zł">

                    </div>
                </div>
                <div class="col-12">
                <div class="orders-input">
                        <p>Uwagi do zamówienia</p>
                        <textarea id="total_comments" name="total_comments" type="text" placeholder="Wprowadz uwagi..."
                            disabled><?php echo $order->getComments() ?></textarea>
                    </div>
                    <div class="text-left ">
                        <p class="total-info"></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" id="employeeId" value="<?php echo $_SESSION['userData']['id']; ?>">
    <div class="mode-buttons justify-content-center">
        <a href="index.php?section=orders"><button>Powrót</button></a>
    </div>
    </section>
    </main>
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
            <input id="phone_number" name="phone_number" type="text" maxlength="9"
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