<?php

class CartController
{
    public function show()
    {
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        // On récupère le panier depuis la session
        session_start();
        $cartItems = $_SESSION['cart'] ?? []; // si pas défini, on prend un tableau vide

        $this->render('cart', [
            'cartItems' => $cartItems,
            'basePath' => $basePath
        ]);
    }

    public function add()
    {
        session_start();

        // Récupérer l'ID du produit depuis $_POST
        $productId = $_POST['product_id'] ?? null;
        if ($productId === null) {
            // Gérer l'erreur ou rediriger
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/products');
            exit;
        }

        // Charger le produit pour récupérer son nom/prix/etc. (facultatif si tu stockes juste l'ID)
        $productModel = new ProductModel();
        $product = $productModel->getProductById($productId);

        // Ajouter ou incrémenter dans le panier stocké en session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Vérifier si le produit est déjà dans le panier
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity']++;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image_url' => $product['image_url'],
                'quantity' => 1
            ];
        }

        // Rediriger vers le panier
        header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/cart');
        exit;
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
    public function remove()
    {
        session_start();
        $productId = $_POST['product_id'] ?? null;
        if ($productId === null) {

            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/cart');
            exit;
        }


        if (isset($_SESSION['cart'][$productId])) {

            unset($_SESSION['cart'][$productId]);
        }


        header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/cart');
        exit;
    }

}
