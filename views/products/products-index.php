<!DOCTYPE html>
<html lang="pl">

<head>
    <link rel="stylesheet" href="./assets/css/products.css">
</head>

<body>
    <div class="tab-title">
        <span class="material-icons">category</span>
        <h3>Produkty i kategorie</h3>
    </div>

    <div class="row">
        <div class="products-box-button">
            <h5 class="products-box-title">Lista produktów</h5>
            <a href="index.php?section=products&action=addProductForm"><button class="addProduct">Dodaj <span
                        class="material-icons">add</span></button></a>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 products-box">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Kategoria</th>
                        <th scope="col">Cena</th>
                        <th scope="col">Zasobność</th>
                        <th class="small-col text-right" scope="col">Operacje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($products as $product) {
                            $id = $product->getId();
                            $name = $product->getName();
                            $price = $product->getPrice();
                            $amount = $product->getAmount();
                            $category = $product->getCategoryName();

                            $handleClick = "index.php?section=products&action=editProductForm&id=".$id; // Zmienić

                            echo '
                            <tr>
                                <th scope="row">'.$id.'</th>
                                <td>'.$name.'</td>
                                <td>'.$category.'</td>
                                <td>'.$price.' zł</td>
                                <td>'.$amount.' szt.</td>
                                <td>
                                    <div class="buttons">
                                        <a href="'.$handleClick.'"><button><span class="material-icons">edit</span></button></a>
                                        <a class="deleteProduct" data-id='.$id.'><button"><span class="material-icons">delete</span></button></a>
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
    <div class="row mt-3">
        <div class="products-box-button">
            <h5 class="products-box-title">Kategorie produktów</h5>
            <button class="addProduct addCategory">Dodaj <span class="material-icons">add</span></button>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 products-box">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Produkty w kategorii</th>
                        <th class="text-right" scope="col">Operacje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($categories as $category) {
                            $id = $category->getId();
                            $name = $category->getName();
                            $num_products = $category->getNumProducts();
                            echo '
                            <tr>
                                <th scope="row">'.$id.'</th>
                                <td>'.$name.'</td>
                                <td>'.$num_products.'</td>
                                <td>
                                <div class="buttons">
                                    <a class="editCategory" data-value="'.$name.'" data-id="'.$id.'" href="categoriesData.php?categoryId='.$id.'&action=edit"><button"><button><span class="material-icons">edit</span></button></a>
                                    <a class="deleteCategory" data-id='.$id.'><button"><span class="material-icons">delete</span></button></a>
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
    <section class="popup-window">
        <form id="categoryBox" method="POST">
            <h5 id="categoryBox-title">Dodaj nową kategorię</h5>
            <input name="name" id="categoryText" type="text" placeholder="Wprowadź nazwę">
            <input id="hiddenInput" type="hidden" name="categoryId">
            <div class="buttons">
                <button id="cancel">Anuluj</button>
                <button id="submit">Dodaj</button>
            </div>
        </form>
    </section>
    <div class="shadow"></div>
    <script src="./assets/js/products.js"></script>
</body>

</html>
