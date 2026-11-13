<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'category', 'price', 'stock'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2', 'stock' => 'integer'];
    }

    public function toReportRow(): array
    {
        return [
            'id' => $this->id,
            'produto' => $this->name,
            'categoria' => $this->category,
            'preco' => (float) $this->price,
            'estoque' => $this->stock,
            'data' => $this->created_at?->toDateString() ?? '',
        ];
    }
}
