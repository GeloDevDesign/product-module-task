<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{


    public function index(Request $request)
    {
        $title = 'Products';

        $query = $request->user()
            ->products()
            ->with('categories:id,name');

        if ($request->filled('s')) {
            $search = $request->get('s');

            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'like', '%' . $search . '%')
                    ->orWhere('products.sell_price', 'like', '%' . $search . '%')
                    ->orWhereHas('categories', function ($q) use ($search) {
                        $q->where('categories.name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('per_page')) {
            if ($request->per_page != 'all') {
                $products = $query->paginate($request->per_page);
            } else {
                $products = $query->get();
            }
        } else {
            $products = $query->paginate(50);
        }

        // if ($request->filled('f')) {
        //     $filters = $request->get('f');

        //     $query->whereHas('categories', function ($q) use ($filters) {
        //         $q->whereIn('categories.id', $filters);
        //     });
        // }

        // USEFUL FOR USING BLADE
        // $products = $query->paginate(20)->appends($request->only('s', 'f'));

        // WHEN USING SPA REQUEST
        // $products = $query->paginate(20);


        $filters = [
            's' => $request->s,
            'page' => $request->page,
            'per_page' => $request->per_page,
        ];



        return view('product.index', compact('title', 'products', 'filters'));
    }




    public function create(Request $request)
    {
        $title = 'Add your new product';


        $categories = Category::all();
        return view('product.create', compact('title', 'categories'));
    }


    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'sell_price' => 'required|numeric|min:1|gt:0',
                'category_ids' => 'required|array',
                'is_active' => 'required|boolean'
            ]);



            $product = $request->user()->products()->create([
                'name' => $validated['name'],
                'sell_price' => $validated['sell_price'],
                'is_active' => $validated['is_active']
            ]);

            if (!empty($validated['category_ids'])) {
                $product->categories()->attach($validated['category_ids']);
            }

            return to_route('admin.products.index')->withSuccess('Product has been created successfully');
        } catch (\DomainException $e) {
            return redirect()->back()
                ->withError($e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $title = 'View Product';

        $categories = Category::all();

        return view('product.edit', compact('title', 'product', 'categories'));
    }


    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'sell_price' => 'required|numeric|min:1|gt:0',
                'category_ids' => 'required|array',
                'is_active' => 'required|boolean'
            ]);

            $product->update([
                'name' => $validated['name'],
                'sell_price' => $validated['sell_price'],
                'is_active' => $validated['is_active'],
            ]);

            $product->categories()->sync($validated['category_ids']);

            return to_route('admin.products.index')->withSuccess('Product has been updated successfully');
        } catch (\DomainException $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return to_route('admin.products.index')->withSuccess('Product deleted successfully.');
    }
}
