<?php

namespace App\Http\Controllers;

use Exception;
use Session;

use App\Card;
use App\UserHasCards;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = UserHasCards::where('user_id', auth()->user()->id)->with('cards');
        return view('user.card.index')->with('cards', $cards);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function create()
    {
        return view('user.card.create');
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
            $verifyIfAlreadyExist = Card::where('number', $request->number)->first();

            if (!$verifyIfAlreadyExist) {
                $card = Card::create($request->all());

                $userHasCards = UserHasCards::create([
                    'user_id' => auth()->user()->id,
                    'card_id' => $card->id
                ]);

                if (!$card) {
                    throw new Exception("Error Processing Request", 509);
                }

                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Cartão cadastrado com sucesso :D');

                return redirect()->route('verifyCard');
            } else {
                return redirect()->route('card-create');
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', 'Esse cartão já está cadastrado.');
            }
        } catch(Exception $err) {
            return $err->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }
}
