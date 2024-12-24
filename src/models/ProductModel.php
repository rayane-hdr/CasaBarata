<?php


class ProductModel
{

    private $pdo;


    public function __construct()
    {
        require __DIR__ . '/../../config.php';

        $dsn = 'pgsql:host=' . $config['db_host'] . ';port=' . $config['db_port'] . ';dbname=' . $config['db_name'];

        try {
            $this->pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }

    }


    public function getAllProducts(): array
    {
        $sql = "SELECT * FROM products ORDER BY name ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }


    public function getProductById(int $id): ?array
    {
        $sql = "SELECT * FROM products WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();

        return $product ?: null;
    }


    public function addProduct(string $name, string $description, float $price, string $imageUrl, int $stock, ?int $categoryId = null): int
    {
        $sql = "INSERT INTO products (name, description, price, image_url, stock, category_id) 
                VALUES (:name, :description, :price, :image_url, :stock, :category_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image_url' => $imageUrl,
            'stock' => $stock,
            'category_id' => $categoryId
        ]);

        return (int) $this->pdo->lastInsertId();
    }


    public function updateProduct(int $id, string $name, string $description, float $price, string $imageUrl, int $stock, ?int $categoryId = null): bool
    {
        $sql = "UPDATE products 
                SET name = :name,
                    description = :description,
                    price = :price,
                    image_url = :image_url,
                    stock = :stock,
                    category_id = :category_id
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image_url' => $imageUrl,
            'stock' => $stock,
            'category_id' => $categoryId
        ]);
    }


    public function deleteProduct(int $id): bool
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }


    public function searchProducts(string $keyword): array
    {
        $sql = "SELECT * FROM products 
                WHERE name LIKE :keyword
                   OR description LIKE :keyword
                ORDER BY name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll();
    }


    public function getProductsByCategory(int $categoryId): array
    {
        $sql = "SELECT * FROM products WHERE category_id = :category_id ORDER BY name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchAll();
    }


    public function updateStock(int $id, int $newStock): bool
    {
        $sql = "UPDATE products SET stock = :stock WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'stock' => $newStock
        ]);
    }
}
