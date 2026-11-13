<?php

namespace App\Modules\Products\Http\Controllers;

use App\Modules\Products\Models\Product;
use App\Http\Controllers\Controller;
use App\Modules\Products\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private ProductService $products) {}

    public function index(): View
    {
        return view('products.index', ['products' => $this->products->all()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->products->create($request->all());
        return to_route('products.index')->with('status', 'Produto cadastrado com sucesso.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->products->update($product, $request->all());
        return to_route('products.index')->with('status', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->products->delete($product);
        return to_route('products.index')->with('status', 'Produto removido.');
    }

}
