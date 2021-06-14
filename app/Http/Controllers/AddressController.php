<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserHasAdresses;
use App\Address;

use Session;
use Exception;

class AddressController extends Controller
{

    public function index() {
        $adresses = UserHasAdresses::where('user_id', auth()->user()->id);
        return view('user.address.index')->with('adresses', $adresses);
    }

    public static function create() {
        return view('user.address.create');
    }

    public function store(Request $request) {
        try {
            $userId = auth()->user()->id;
            $address = Address::create($request->all());

            $data = [
                'user_id' => $userId,
                'address_id' => $address->id
            ];

            $userHasAddress = UserHasAdresses::create($data);

            
            if ($address && $userHasAddress) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Endereço cadastrado com sucesso :P');
                return redirect()->route('verifyAddress');
            }
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }
}
