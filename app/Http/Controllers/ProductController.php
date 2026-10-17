<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Whitelisted fields for filtering
        foreach (['category', 'brand', 'price', 'stock'] as $field) {
            if ($request->has($field)) {
                $query->where($field, $request->query($field));
            }
        }

        return $query->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string',
            'category' => 'required|string',
            'brand'    => 'required|string',
            'price'    => 'required|integer',
            'stock'    => 'required|integer',
        ]);

        return Product::create($validated);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'     => 'sometimes|required|string',
            'category' => 'sometimes|required|string',
            'brand'    => 'sometimes|required|string',
            'price'    => 'sometimes|required|integer',
            'stock'    => 'sometimes|required|integer',
        ]);

        $product->update($validated);

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent(); // Returns 204
    }
}
