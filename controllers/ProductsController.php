<?php
class ProductsController extends Controller {

    function indexAction() {
        require_once('models/Product.php');
        require_once("models/Category.php");
        $product = new Product();
        $products = $product->getAllProducts();
        $category = new Category();
        $categories = $category->getAllCategories();
        $this->render('products/products-index.php', ['products' => $products, 'categories' => $categories]);
    }

    function addProductFormAction() {
        require_once("models/Category.php");
        $category = new Category();
        $categories = $category->getAllCategories();

        require_once("models/Tax.php");
        $tax = new Tax();
        $taxes = $tax->getAllTaxes();

        $this->render('products/products-addProductForm.php',['categories' => $categories, 'taxes' => $taxes]);
    }

    function editProductFormAction() {
        require_once("models/Category.php");
        require_once("models/Product.php");
        require_once("models/Tax.php");


        $product = new Product();
        $product->getProductData($_GET['id']);

        $category = new Category();
        $categories = $category->getAllCategories();

        $tax = new Tax();
        $taxes = $tax->getAllTaxes();

        $this->render('products/products-editProductForm.php',['product' => $product,'categories' => $categories, 'taxes' => $taxes]);
    }

    function addProductToDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once('models/Product.php');
            
            $data = json_decode(file_get_contents('php://input'), true);
            

            $name = $data['name'];
            $category_id = $data['categoryId'];
            $price = $data['price'];
            $amount = $data['amount'];
            $description = $data['description'];
            $taxId = $data['taxId'];



            $product = new Product();
            $product->setName($name);
            $product->setPrice($price);
            $product->setAmount($amount);
            $product->setCategoryId($category_id);
            $product->setDescription($description);
            $product->setTaxId($taxId);
            $result = $product->addProduct();

            if (!$result) {
                $response = array('error' => 'Nie udało się dodać tego produktu');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }

    function updateProductInDbAction() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once('models/Product.php');
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            $id = $data['id'];
            $name = $data['name'];
            $category_id = $data['categoryId'];
            $price = $data['price'];
            $amount = $data['amount'];
            $description = $data['description'];
            $taxId = $data['taxId'];

            

            $product = new Product();
            $product->setId($id);
            $product->setName($name);
            $product->setPrice($price);
            $product->setAmount($amount);
            $product->setCategoryId($category_id);
            $product->setDescription($description);
            $product->setTaxId($taxId);


             $result = $product->updateProduct();


            if (!$result) {
                $response = array('error' => 'Nie udało się edytować tego produktu');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }

    function deleteProductFromDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once('models/Product.php');
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'];
            $product = new Product();
            $product->setId($id);

            try {
                $result = $product->deleteProduct();

                if (!$result) {
                    $response = array('error' => 'Nie udało się usunąć tego produktu');
                    http_response_code(400);
                    ob_clean();
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } catch (Exception $e) {
                $response = array('error' => 'Nie udało się usunąć tego produktu');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }


    // Categories //
    function addCategoryToDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once("models/Category.php");
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            $name = $data['name'];

            $category = new Category();
            $category->setName($name);
            $result = $category->addCategory();

            if (!$result) {
                $response = array('error' => 'Nie udało się dodać kategorii');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }

    function editCategoryInDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once("models/Category.php");
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            $id = $data['id'];
            $name = $data['name'];

            $category = new Category();
            $category->setId($id);
            $category->setName($name);
            $result = $category->updateCategory();

            if (!$result) {
                $response = array('error' => 'Nie udało się dodać kategorii');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }

    function deleteCategoryFromDbAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once("models/Category.php");

            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'];
            $category = new Category();
            $category->setId($id);
            
            try {
                $result = $category->deleteCategory();
    
                if (!$result) {
                    $response = array('error' => 'Nie udało się usunąć tej kategorii');
                    http_response_code(400);
                    ob_clean();
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } catch (Exception $e) {
                $response = array('error' => 'Nie udało się usunąć tej kategorii');
                http_response_code(400);
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }
}
?>
