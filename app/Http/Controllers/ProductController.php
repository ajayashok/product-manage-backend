<?php

namespace App\Http\Controllers;

use App\Contracts\ProductRepoInterface;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepoInterface $productRepo) {
        $this->productRepository = $productRepo;
    }

    public function dashboardAnalytics(){
        try {
            $data = $this->productRepository->getAnalytics();
        } catch (\Throwable $th) {
            return $this->errorResponse('Failed to fetch dashboard api',400,[$th->getMessage()]);
        }

        return $this->successResponse($data, 'Product Analytics');
    }

    // Product Import API
    public function productImport() {
        $validator = Validator::make(request()->all(), [
            'file' => 'required|mimes:xlsx,xls,csv', // Validate file type
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return $this->errorResponse('Validation error', 422, $validator->errors()->toArray());
        }

        try {
            $data = $this->productRepository->importProducts(request('file'));
        } catch (\Throwable $th) {
            return $this->errorResponse('Failed to import',400,[$th->getMessage()]);
        }

        return $this->successResponse($data, 'Import product successfully, Wait until its completed.');
    }

    public function productLists(){
        try {
            $data = $this->productRepository->getProducts();
        } catch (\Throwable $th) {
            return $this->errorResponse('Failed to fetch product',400,[$th->getMessage()]);
        }

        return $this->successResponse($data, 'Product Lists');
    }
}
