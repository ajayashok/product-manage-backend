<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow,WithChunkReading, ShouldQueue
{
    protected $user_id;

    public function __construct($user_id) {
        $this->user_id = $user_id;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
      foreach ($rows as $row)
        {
            try {
                Product::create([
                    'user_id'  => $this->user_id,
                    'name'  => $row['name'],
                    'price' => (double)$row['price'],
                    'sku' => $row['sku'],
                    'description' => $row['description']
                ]);
            } catch (\Exception $th) {
                Log::info($th->getMessage());
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
