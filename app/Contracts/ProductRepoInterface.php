<?php

namespace App\Contracts;

interface ProductRepoInterface {
    public function importProducts(array $products);
    public function getProducts();
    public function getAnalytics();
}