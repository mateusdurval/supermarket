<?php

namespace App\Http\Controllers;

use App\ProductHasCategories;
use App\Product;
use App\Category;
use App\Request;

use Exception;
use Session;

use Illuminate\Http\Request as HttpRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HttpRequest $request)
    {
        try {
            $total = Product::count();
            $products = Product::paginate(5);
            if ($products) {
                return view('admin.products.index')->with(['products' => $products, 'total' => $total]);
            } else {
                throw new Exception("Error Processing Request", 509);
            }
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @ else {
     * return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $categories = Category::all();
            return view('admin.products.create')->with('categories', $categories);
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HttpRequest $request)
    {
        try {
            $pathImage = null;

            if ($request->hasFile('image') && $request->image->isValid()) {
                $pathImage = $request->image->store('products');
            }

            $dataProduct = [
                "image" => $pathImage,
                "name" => $request->name,
                "brand" => $request->brand,
                "description" => $request->description,
                "sale" => $request->sale == 0 ? false : true,
                "amount" => $request->amount,
                "price" => number_format($request->price, 2, ',', '.')
            ];
            
            $product = Product::create($dataProduct);

            $categoryObject = Category::where('category', $request->category)->get()->first();

            $category = ProductHasCategories::create([
                'product_id' => $product->id,
                'category_id' => $categoryObject->id
            ]);

            if (!$product && $category) {
                throw new Exception("Error Processing Request", 509);
            }

            Session::flash('alert-class', 'alert-success');
            Session::flash('message', 'Produto cadastrado com sucesso!');
            return redirect()->route('products');
            
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function search(HttpRequest $request)
    {
        try {
            $query = $request->get('query');

            $products = Product::where('name', 'LIKE', "%{$query}%")->orWhere('brand', 'LIKE', "%{$query}%")->get();

            if (!$products) {
                throw new Exception("could not find products with the informed query on table `products`", 404);
            }
            return view('admin.products.search')->with('products', $products);
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($productId)
    {
        try {
            $product = Product::where('id', $productId)->get()->first();

            $categories = Category::all();

            if (!$product || !$categories) {
                throw new Exception('user or categories not found on database', 404);
            }

            return view('admin.products.edit')->with(['product' => $product, 'categories' => $categories]);

        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(HttpRequest $request)
    {
        try {
            $productId = $request->id;

            $product = Product::find($productId);
            if (!$product) {
                throw new Exception("Product not found", 404);
            }

            $categoryId = Category::where('category', $request->category)->get()->first()->id;


            $updateCategory = ProductHasCategories::where('category_id', $categoryId)->update(['category_id' => $categoryId]);
            $pathImage = null;
            if ($request->hasFile('image') && $request->image->isValid()) {
                $pathImage = $request->image->store('products');
            }

            $product->image = $pathImage;
            $product->name = $request->name;
            $product->brand = $request->brand;
            $product->description = $request->description;
            $product->sale = $request->sale == 0 ? false : true;
            $product->amount = $request->amount;
            $product->price = number_format($request->price, 2, ',', '.');

            if ($product->save()) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Produto editado com sucesso!'); 
                return redirect()->route('products');
            }
        } catch(Exceptio $err) {
            return $err.getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $productHasCategory = ProductHasCategories::where('product_id', $id)->delete();
            $product = Product::destroy($id);

            if (!$productHasCategory || !$product) {
                throw new Exception("Error Processing Request", 509);
            }
            return true;
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }
}
