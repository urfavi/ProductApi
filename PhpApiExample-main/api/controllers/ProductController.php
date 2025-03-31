<?php

require_once "repositories/ProductRepository.php";
require_once "repositories/interface/IProductRepository.php";

class ProductController {
    private $productRepository;

    public function __construct() {
        $this->productRepository = new ProductRepository();
    }

    public function GetAllProduct() {
    echo json_encode($this->productRepository->GetAllProduct());
    }

    public function GetAllLatestProductPrice()
    {
        echo json_encode($this->productRepository->GetAllLatestProductPrice() ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function GetProductById($productId) 
    {
        $result = $this->productRepository->GetProductById($productId);

        echo json_encode(!empty($result) ? $result : ["error" => "Product not found"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
