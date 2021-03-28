@extends('layouts.app')

@section('content')
    <main id="sale-offer">
        <div class="row">
            <div class="col-md-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    </ol>

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/carousel1.png') }}" class="d-block w-30"  alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/carousel2.png') }}" class="d-block w-30" alt="...">
                        </div>
                    </div>

                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>

                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <div id="products">
        <div class="row">
            @foreach($products as $product)
                    <div class="card product" style="width: 18rem;">
                        <img src="{{ asset('images/products/arroz.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }} - {{ $product->brand }} <p>FRETE GRÁTIS!</p></h5>
                            <button class="btn btn-primary add-cart" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-brand="{{ $product->brand }}" style="background: rgb(250, 206, 8); color: #FFF; font-weight: bold; border: none">
                                <i class="fas fa-cart-plus"></i> Adicionar ao carrinho
                            </button>
                        </div>

                        <div class="list-group list-group-flush">
                            <li class="list-group-item"> Por: <span>R$ {{ number_format($product->price, 2, ',', '.') }} </li>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
@endsection
