<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Products - Online Store';
        $viewData['subtitle'] = 'List of products';
        $viewData['products'] = Product::all(); // Fetch all products from the database

        return view('product.index')->with('viewData', $viewData);
    }

    public function show(string $id): View|RedirectResponse
    {
        if (! is_numeric($id) || $id < 1 || $id > count(Product::all())) {
            return redirect()->route('home.index');
        }

        $viewData = [];
        $product = Product::findOrFail($id);
        $viewData['title'] = $product['name'].' - Online Store';
        $viewData['subtitle'] = $product['name'].' - Product information';
        $viewData['product'] = $product;

        return view('product.show')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = []; // to be sent to the view
        $viewData['title'] = 'Create product';

        return view('product.create')->with('viewData', $viewData);
    }

    public function save(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|integer|min:0',
        ]);

        Product::create($request->only(['name', 'price']));

        return redirect()->route('product.success');
    }

    public function success(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = 'Product created';
        $viewData['subtitle'] = '';

        return view('product.success')->with('viewData', $viewData);
    }
}
