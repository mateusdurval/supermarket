<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserHasAdresses;
use App\UserHasCards;
use App\User;

use Session;

class UserController extends Controller
{
    public function verifyAddress() {
        $userId = auth()->user()->id;
        $userAddress = UserHasAdresses::where('user_id', $userId)->with('adresses')->first();
        if ($userAddress == null) {
            return redirect()->route('address-create');
        }

        $adresses = $userAddress->adresses();
        return view('user.address.index')->with('adresses', $userAddress);
    }

    public function resetPassword() {
        return view('auth.passwords.reset');
    }

    public function actionResetPassword(Request $request) {
        try {
            $pass = $request->password;
            $userId = auth()->user()->id;
            $user = User::where('id', $userId)->get()->first();

            if (!$user) {
                throw new Exception("user nof found", 404);
            }

            if (password_verify($pass, $user->password)) {
                if ($request->newPassword == $request->confirmNewPassword) {
                    $user->password = bcrypt($request->newPassword);
                    $user->save();
                    Session::flash('alert-class', 'alert-success');
                    Session::flash('message', 'Senha alterada com sucesso :P');
                    return back();
                } else {
                    Session::flash('alert-class', 'alert-warning');
                    Session::flash('message', 'As senhas informadas não conferem :/');
                    return back();
                }
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', 'A senha digitada está incorreta :(');
                return back();
            }
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    public function verifyCard() {
        $userId = auth()->user()->id;
        $userCards = UserHasCards::where('user_id', $userId)->with('cards')->first();
        
        if (!$userCards) {
            return redirect()->route('card-create');
        }

        return view('user.card.index')->with('cards', $userCards);
    }
}
