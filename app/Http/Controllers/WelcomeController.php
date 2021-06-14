<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            $products = Product::paginate(8);
            if (!$products) {
                throw new Exception("Error Processing Request", 509);
            }
            return view('welcome')->with(['products' => $products]);
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }
}
