<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use App\Request;
use App\Cart;

use Exception;

class RequestController extends Controller
{
    public $totalValues = [];

    public function index() {
        try {
            $total = Request::count();
            $requests = Request::with(['address', 'card', 'user'])->get();
            
            if ($requests) {
                return view('admin.requests.index')->with(['requests' => $requests, 'total' => $total]);
            } else {
                throw new Exception("Error Processing Request", 509);
            }
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    public function manage($requestId) {
        try {
            $request = Request::where('id', $requestId)->with('user', 'address')->get()->first();
            $cartUser = Cart::where('user_id', $request->user_id)->with('products')->get();

            if (!$request || !$cartUser) {
                throw new Exception("Error Processing Request", 509);
            }

            return view('admin.requests.manage')->with(['request' => $request, 'cartUser' => $cartUser]);

        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    public function updateStatus($id, $newStatus) {
        try {
            $request = Request::where('id', $id)->get()->first();
            if (!$request) {
                throw new Exception("Error Processing Request", 404);
            }
            $request->status = $newStatus;
            if ($request->save()) {
                return back();
            }
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    public function store(HttpRequest $request) {
        try {
            $userId = auth()->user()->id;

            $data = [
                'user_id' => $userId,
                'address_id' => $request->addressId,
                'card_id' => $request->cardId,
                'status' => 'AWAIT_CHECKOUT',
                'checkout' => false
            ];

            $request = Request::create($data);

            if (!$request) {
                throw new Exception("Error Processing Request", 509);
            } 

            $response = array(
                "success" => true,
            );

            return json_encode($response); 
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    public function checkout(HttpRequest $request) {
        $requestId = $request->requestId;

        $request = Request::where(['id' => $requestId, 'status' => 'AWAIT_CHECKOUT'])->get()->first();

        if (!$request) {
            throw new Exception("Error Processing Request", 509);
        }

        $request->checkout = true;
        $request->status = 'PREPARATION';

        if ($request->save()) {
            $response = array(
                "success" => true,
                "message" => 'Pedido realizado com sucesso!'
            );

            return json_encode($response);
        }
    }

    public function review() {
        try {
            $userId = auth()->user()->id;
            $request = Request::where(['user_id' => $userId])->with(['address', 'card'])->get()->first();

            $carts = Cart::where('user_id', $userId)->with('products')->get();

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

            if (!$request || !$carts) {
                throw new Exception("Error Processing Request", 509);
            }

            return view('user.request.review')->with(['request' => $request, 'carts' => $carts, 'total' => $total]);
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    public function status() {
        $userId = auth()->user()->id;
        $request = Request::where('user_id', $userId)->with(['address', 'card'])->get()->first();
        return view('user.request.status')->with(['request' => $request]);
    }
}
