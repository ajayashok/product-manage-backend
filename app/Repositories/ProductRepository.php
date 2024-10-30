<?php

namespace App\Repositories;

use App\Contracts\ProductRepoInterface;
use App\Imports\ProductImport;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ProductRepository implements ProductRepoInterface {
    // Import Products
    public function importProducts($file) {
        Log::info(Auth::user()->id);
        Excel::queueImport(new ProductImport(Auth::user()->id), $file);
    }

    // Get products lists
    public function getProducts() {
        return Product::where('user_id',Auth::user()->id)->paginate(10);
    }

    // products dashboard analytics
    public function getAnalytics() {
        $query = Product::query()->where('user_id',Auth::user()->id);
        $data = [
            "products_count" => $query->count(),
            "last_uploaded" => $query->orderBy('created_at','desc')->first()?->created_at?->format('D d M Y h:s:i A')
        ];

        return $data;
    }
}
