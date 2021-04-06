@extends('layouts.app')

@section('content')
    <div id="products">
        <div class="row">
            @foreach($products as $product)
                <div class="card product" style="width: 18rem; padding: 15px">
                    <img src="{{ asset("storage/{$product->image}") }}" class="card-img-top" alt="produto" style="max-widht: 100px; max-height: 300px">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }} - {{ $product->brand }} <p>FRETE GRÁTIS!</p></h5>
                        <button class="btn btn-primary add-cart" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-brand="{{ $product->brand }}" style="background: rgb(250, 206, 8); color: #FFF; font-weight: bold; border: none">
                            <i class="fas fa-cart-plus"></i> Adicionar ao carrinho
                        </button>
                    </div>

                    <div class="list-group list-group-flush">
                        <li class="list-group-item"> Por: <span>R$ {{$product->price }}</li>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection