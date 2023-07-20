<!DOCTYPE html>
<html lang="pl">

<head>

</head>

<body>
    <div class="tab-title emp-config">
        <span class="material-icons">edit</span>
        <h3>Zarządzanie produktami</h3>
    </div>
    
    <div class="config-box mt-4">
        <form id="productForm" method="post" novalidate>
            <h5 class="title">Dodaj produkt</h5>
            <div class="row mt-4">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 ">
                    <div class="config-input obligatory">
                        <p>Nazwa produktu</p>
                        <input id="name" name="name" type="text" placeholder="Wprowadz nazwę...">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 ">
                    <div class="config-input">
                        <p>Kategoria</p>
                        <select id="category" name="category">
                            <option value="0" selected>Brak kategorii</option>
                            <?php
                                foreach($categories as $category) {
                                    echo '<option value="'.$category->getId().'">'.$category->getName().'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 ">
                    <div class="config-input obligatory">
                        <p>Cena NETTO</p>
                        <input id="price" name="price" type="number" min="0" placeholder="Wprowadz cene...">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 ">
                    <div class="config-input obligatory">
                        <p>Zasobność</p>
                        <input id="amount" name="amount" type="number" min="0" placeholder="Wprowadz zasobność...">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 ">
                    <div class="config-input">
                        <p>Rodzaj podatku</p>
                        <select id="tax" name="tax">
                            <?php
                                foreach($taxes as $tax) {
                                    echo '<option value="'.$tax->getId().'">'.$tax->getName().'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-12">
                    <div class="config-input">
                        <p>Opis produktu</p>
                        <textarea id="description" name="description" placeholder="Wprowadz opis produktu"></textarea>
                    </div>
                </div>
                
            </div>
            <div class="row mt-4">
                <div class="buttons">
                    <button id="cancelButton" class="config-button">Anuluj</button>
                    <button id="submitButton" class="config-button">Dodaj produkt</button>
                </div>
            </div>
        </form>
    </div>

    <script src="./assets/js/products.js"></script>
</body>

</html>