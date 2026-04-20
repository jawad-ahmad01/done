<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(8);
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'sku' => 'required|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required'
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product deployed to the Matrix successfully.');
    }

  public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            // This ignores the current product ID so it doesn't trigger a 'unique' error
            'sku' => [
                'required',
                Rule::unique('products')->ignore($product->id),
            ],
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required'
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product configuration updated.');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product erased from core memory.');
    }
}