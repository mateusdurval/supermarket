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
                    <img src="{{ asset("storage/{$product->image}") }}" class="card-img-top" alt="produto" style="padding: 15px; max-widht: 100px; max-height: 300px">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }} - {{ $product->brand }} <p>FRETE GRÁTIS!</p></h5>
                        <button class="btn btn-primary add-request" data-price="{{ $product->price }}" data-id="{{ $product->id }}"  style="background: rgb(250, 206, 8); color: #FFF; font-weight: bold; border: none">
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

    <div id="paginate">
        <div class="row">
            <div class="col-md-12">
                <p>{{ $products->links() }}</p>
            </div>
        </div>
    </div>

    <!-- TOAST -->
    <div class="toast my-toast" data-delay="4000" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 45%; right: 10px;">
        <div class="toast-header">
            <strong class="mr-auto">Notificação</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
           <p class="message"></p>
           <a href="{{ route('requests') }}" class="btn btn-sm btn-primary btn-see-car">Clique aqui para vê-lo.</a>
        </div>
    </div>

    <!-- Script to add product to cart-->
    <script>
        $(document).ready(function() {
            let productId;
            let productPrice;
            $(".add-request").on('click', function() {
                productId = $(this).data('id');
                productPrice = $(this).data('price');
                $.ajax({
                    method: 'POST',
                    url: '/admin/requests/create',
                    data: {
                        "_token": "{{ csrf_token() }}", 
                        productId: productId, 
                        productPrice: productPrice
                    }
                }).done(function(res) {
                    response = JSON.parse(res);
                    if (response.success) {
                        $(".my-toast").toast('show');
                        $(".message").html(response.message);
                    } else {
                        $(".message").html(response.message);
                        $(".my-toast").toast('show');
                        $(".toast").css({ background: '#f32d2d', color: '#FFF' })
                        $(".btn-see-car").css({ background: '#FFF', color: '#333', border: 'none' })
                    }
                })
            });
        });
    </script> 
@endsection
