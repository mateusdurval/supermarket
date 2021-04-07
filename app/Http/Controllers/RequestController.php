<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use App\Request;
use Exception;

class RequestController extends Controller
{
    public $totalValues = [];

    public function index() {
        try {
            $user = auth()->user();
            $requests = Request::where('user_id', $user->id)->with('product')->get();
            if (!$requests) {
                throw new Exception("Error Processing Request", 509); 
            }

            $allPrices = array_map(function($request) {
                $prices = array_map(function($product) {
                    $priceFormatted = str_replace(",",".", $product['price']);
                    if (!empty($priceFormatted)) {
                        $this->totalValues[] = $priceFormatted;
                        return $priceFormatted;
                    }
                }, $request['product']);
                return $prices;
            }, $requests->toArray());

            $total = array_sum($this->totalValues);

            return view('admin.requests.index')->with(['requests' => $requests, 'total' => $total]);
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    public function create(HttpRequest $request) {
        try {
            $productId = $request->productId;
            $productPrice = $request->productPrice;
            $userId = auth()->user()->id;

            $verifyIfAlreadyExist = Request::where('user_id', $userId)->where('product_id', $productId)->get()->first();

            if ($verifyIfAlreadyExist) {
                throw new Exception("Este produto já foi adicionado no carrinho.", 409);
            }

            $request = Request::create([
                'user_id' => auth()->user()->id,
                'product_id' => $productId,
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
            $productFromRequest = Request::where('product_id', $id)->delete();
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
}
    