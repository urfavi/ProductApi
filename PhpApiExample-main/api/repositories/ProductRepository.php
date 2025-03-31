<?php
require_once "config/Database.php";
require_once "repositories/interface/IProductRepository.php";

class ProductRepository implements IProductRepository {
    private $databaseConnection;
    private Database $database;
    
    public function __construct() {
        $this->database = Database::getInstance();
        $this->databaseConnection = $this->database->getConnection();
    }

    // Retrieves all products with price and product date
    public function GetAllProduct() 
    {
        $query = "SELECT 
                    Product.ProductId, 
                    Product.ProductName, 
                    ProductDetails.ProductPrice, 
                    ProductDetails.ProductDate 
                  FROM Product 
                  INNER JOIN ProductDetails ON ProductDetails.ProductId = Product.ProductId";

        return $this->ExecuteSqlQuery($query, []);
    }

    // Retrieves all products along with their latest prices and product date
    public function GetAllLatestProductPrice() 
    {
        $query = "SELECT 
                    Product.ProductId, 
                    Product.ProductName, 
                    ProductDetails.ProductPrice, 
                    ProductDetails.ProductDate 
                  FROM Product 
                  INNER JOIN ProductDetails ON ProductDetails.ProductId = Product.ProductId 
                  WHERE ProductDetails.ProductDate = (
                      SELECT MAX(ProductDate) 
                      FROM ProductDetails 
                      WHERE ProductDetails.ProductId = Product.ProductId
                  )";

        return $this->ExecuteSqlQuery($query, []);
    }

    // Retrieve product by ID
    public function GetProductById($productId) 
    {
        $query = "SELECT 
                    Product.ProductId, 
                    Product.ProductName, 
                    ProductDetails.ProductPrice, 
                    ProductDetails.ProductDate 
                  FROM Product 
                  INNER JOIN ProductDetails ON ProductDetails.ProductId = Product.ProductId
                  WHERE Product.ProductId = :productId";

        $params = [
            ':productId' => $productId
        ];

        return $this->ExecuteSqlQuery($query, $params);
    }

    private function ExecuteSqlQuery(string $query, array $params) {
        $statementObject = $this->databaseConnection->prepare($query);
        $statementObject->execute($params);

        if (stripos($query, "SELECT") === 0) {
            return $statementObject->fetchAll(PDO::FETCH_ASSOC);
        }

        return null;
    }
}
