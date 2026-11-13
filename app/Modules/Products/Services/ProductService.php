<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Models\Product;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class ProductService extends BaseService
{
    public function all(): Collection
    {
        return $this->getAll(Product::class, 'name');
    }

    public function create(array $data): Product
    {
        return $this->createRecord(Product::class, $this->validatedData($data));
    }

    public function update(Product $product, array $data): Product
    {
        return $this->updateRecord($product, $this->validatedData($data));
    }

    private function validatedData(array $data): array
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:80'],
            'price' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'stock' => ['required', 'integer', 'min:0'],
        ])->validate();
    }

    public function delete(Product $product): void
    {
        $this->deleteRecord($product);
    }
}
