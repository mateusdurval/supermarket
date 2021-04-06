<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use App\Request;

class RequestController extends Controller
{

    public function index() {
        try {
            $user = auth()->user();
            $requests = Request::where('user_id', $user->id)->with('product')->get();
            if (!$requests) {
                throw new Exception("Error Processing Request", 509); 
            }

            $allPrices = array_map(function($request) {
                $prices = array_map(function($product) {
                    $toFloat = str_replace(",",".", $product['price']);
                    return $toFloat;
                }, $request['product']);
                return $prices;
            }, $requests->toArray());

            $myCollection = collect([]);
            foreach($allPrices as $values) {
                foreach($values as $price) {
                    echo $price;
                    $myCollection->merge($price);
                }
            }
            
            dd($myCollection);

            return view('admin.requests.index')->with(['requests' => $requests]);
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    public function create(HttpRequest $request) {
        try {
            $productId = $request->productId;
            $productPrice = $request->productPrice;

            $request = Request::create([
                'user_id' => auth()->user()->id,
                'product_id' => $productId,
            ]);

            if (!$request) {
                throw new Exception("Error Processing Request", 509);
            }

            return [
                'success' => true,
                'message' => 'O produto foi adicionado ao seu carrinho!'
            ];

        } catch(Exception $err) {
            return $err->getMessage();
        }
    }
}
    