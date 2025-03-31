<?php

interface IProductRepository {
    public function GetAllProduct();
    public function GetAllLatestProductPrice();
    public function GetProductById($productId);
}