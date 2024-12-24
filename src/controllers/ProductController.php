<?php
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController
{
    public function list()
    {
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $productModel = new ProductModel();
        $products = $productModel->getAllProducts();
        $this->render('products', ['products' => $products, 'basePath' => $basePath]);
    }


    public function detail($id)
    {
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $productModel = new ProductModel();
        $product = $productModel->getProductById($id);
        if (!$product) {
            (new MainController())->notFound();
            return;
        }
        $this->render('product-detail', ['product' => $product, 'basePath' => $basePath]);
    }




    private function render($view, $data = [])
    {
        extract($data);
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once __DIR__ . '/../views/partials/header.php';
            require_once $viewFile;
            require_once __DIR__ . '/../views/partials/footer.php';
        } else {
            echo "View not found: $view";
        }
    }
}
