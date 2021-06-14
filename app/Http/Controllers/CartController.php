<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use App\Cart;
use Exception;

class CartController extends Controller
{
    public $totalValues = [];
    public $auxAmount = 0;

    public function index() {
        try {
            $user = auth()->user();
            $carts = Cart::where('user_id', $user->id)->with('products')->get();
            if (!$carts) {
                throw new Exception("Error Processing Request", 509); 
            }

            $totalPrice = $this->totalPrice($carts);

            return view('auth.cart.index')->with(['carts' => $carts, 'total' => $totalPrice]);
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    public function create(HttpRequest $request) {
        try {
            $productId = $request->productId;
            $productPrice = $request->productPrice;
            $userId = auth()->user()->id;

            $verifyIfAlreadyExist = Cart::where('user_id', $userId)->where('product_id', $productId)->get()->first();

            if ($verifyIfAlreadyExist) {
                throw new Exception("Este produto já foi adicionado no carrinho.", 409);
            }

            $cart = Cart::create([
                'user_id' => auth()->user()->id,
                'product_id' => $productId,
                'amount' => 1
            ]);

            if (!$request) {
                throw new Exception("Error Processing Request", 509);
            }

            $response = array(
                "success" => true,
                "message" => 'O produto foi adicionado ao seu carrinho!'
            );

            return json_encode($response);  

        } catch(Exception $err) {
            $response = array( 
                "success" => false, 
                "message" => $err->getMessage()
            ); 

            return json_encode($response);
        }
    }

    public function destroy($id) {
        try {
            $productFromRequest = Cart::where('product_id', $id)->where('user_id', auth()->user()->id)->delete();
            if ($productFromRequest) {
                return [
                    'success' => true,
                    'message' => 'O produto foi removido do seu carrinho!'
                ];
            } else {
                throw new Exception("Houve um erro ao remover o produto do carrinho.", 1);
            }
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    public function status()
    {
        return view('auth.requests.status');
    }

    public function totalPrice($carts) {
        $allPrices = array_map(function($cart) {
            $prices = array_map(function($product, $amount) {
                $priceFormatted = str_replace(",",".", $product['price']);
                if (!empty($priceFormatted)) {
                    $this->totalValues[] = $priceFormatted * $amount;
                    return $priceFormatted;
                }
            }, $cart['products'], [ $cart['amount'] ]);
            $this->auxAmount = $cart['amount'];
            return $prices;
        }, $carts->toArray());

        $total = array_sum($this->totalValues);

        return $total;
    }

    public function amountProduct(HttpRequest $request) {
        $userId = auth()->user()->id;
        $productId = $request->productId;
        $amount = $request->amount;

        $cart = Cart::where('user_id', $userId)->where('product_id', $productId)->get()->first();
        
        $cart->amount = $amount;
        $cart->save();

        $response = array(
            "success" => true,
        );

        return json_encode($response);
    }
}
    