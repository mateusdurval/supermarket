<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductHasCategory;
use Exception;
use Session;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $products = Product::paginate(8);
            $categories = ProductHasCategory::all();
            if (!$products && !$categories) {
                throw new Exception("Error Processing Request", 509);
            }
            return view('welcome')->with(['products' => $products, 'categories' => $categories]);
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    public function index2(Request $request)
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
            return $err.getMessage();
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
            $categories = ProductHasCategory::all();
            if (!$categories) {
                throw new Exception("Error Processing Request", 500);
            }
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
    public function store(Request $request)
    {
        try {
            $pathImage = null;

            if ($request->hasFile('image') && $request->image->isValid()) {
                $pathImage = $request->image->store('products');
            }

            $categoryId = ProductHasCategory::where('category', $request->category)->get()->first()->id;
            
            $dataProduct = [
                "image" => $pathImage,
                "category_id" => $categoryId,
                "name" => $request->name,
                "brand" => $request->brand,
                "description" => $request->description,
                "sale" => $request->sale == 0 ? false : true,
                "amount" => $request->amount,
                "price" => number_format($request->price, 2, ',', '.')
            ];

            $product = Product::create($dataProduct);

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
    public function search(Request $request)
    {
        try {
            $query = $request->get('query');
            $category = ProductHasCategory::where('category', 'LIKE', "%{$query}%")->get()->first();
            if (!$category) {
                $products = Product::where('name', 'LIKE', "%{$query}%")->orWhere('brand', 'LIKE', "%{$query}%")->get();
            } else {
                $products = Product::where('category_id', $category->id)->get();
                if (!$products) {
                    throw new Exception("could not find products with the informed query on table `products`", 404);
                }
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
            $product = Product::find($productId)->with('category')->get()->first();
            $categories = ProductHasCategory::all();
            
            if (!$product && !$categories) {
                throw new Exception('user not found', 404);
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
    public function update(Request $request)
    {
        try {
            $productId = $request->id;
            $product = Product::find($productId);

            $pathImage = null;

            if ($request->hasFile('image') && $request->image->isValid()) {
                $pathImage = $request->image->store('products');
            }

            if (!$product)
                throw new Exception("Product not found", 404);
            
            $product->image = $pathImage;
            $product->name = $request->name;
            $product->brand = $request->brand;
            $product->description = $request->description;
            $product->category = $request->category;
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
            $product = Product::destroy($id);
            if (!$product) {
                throw new Exception("Error Processing Request", 509);
            }
            return true;
        } catch(Exception $err) {
            return $err.getMessage();
        }
    }
}
