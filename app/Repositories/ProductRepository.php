<?php

namespace App\Repositories;

use App\Contracts\ProductRepoInterface;
use App\Imports\ProductImport;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;

class ProductRepository implements ProductRepoInterface {
    // Import Products
    public function importProducts($file) {
        Excel::queueImport(new ProductImport(), $file);
    }

    // Get products lists
    public function getProducts() {
        return Product::paginate(10);
    }

    // products dashboard analytics
    public function getAnalytics() {
        $query = Product::query();
        $data = [
            "products_count" => $query->count(),
            "last_uploaded" => $query->orderBy('created_at','desc')->first()?->created_at?->format('D d M Y h:s:i A')
        ];

        return $data;
    }
}
