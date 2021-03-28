<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CompraCerta.com: faça suas compras!</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

        <!-- Fontawesome -->
        <script src="https://kit.fontawesome.com/f8b439a839.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

        <link href="{{ asset('css/global.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('css/car-modal/style.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('css/welcome/style.css') }}" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div id="welcome">
            <header class="header-app">
                <div class="top-header">
                    
                    <a href="/"><img src="{{ asset('images/logo.png') }}" widht="150" height="150" alt="logo"></a>

                    <form action="">
                        <input type="text" name="search" placeholder="Encontre aqui as melhores ofertas" autocomplete="off">
                        <button type="submit">OK</button>
                    </form>

                    <h4>Aproveite nossas ofertas com <span>FRETE GRÁTIS!</span></h4>
                </div>

                <div class="content-header">
                    <div class="contents">
                        <h4>Compre pelo telefone <strong><i class="fas fa-phone-square-alt"></i> (71) 3416-6055</strong></h4>

                        <div class="login">
                            <i class="fas fa-user"></i>
                            @guest
                                @if (Route::has('register'))
                                    <div class="login-contents">
                                        <a href="{{ route('login') }}">Entre ou cadastre-se</a>
                                        <p>para ver seus pedidos</p>
                                    </div>
                                @endif

                                @else 
                                    <li class="nav-item dropdown" style="list-style-type: none;">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>
                                        <p style="font-size: 15px; margin-top: -5px">CPF: {{ Auth::user()->cpf }}</p>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #000">
                                                {{ __('Sair') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>

                                    </li>
                            @endguest
                        </div>
 
                        <a href="javascript:void(0)" class="showModal"><i class="fas fa-shopping-cart "></i> Meu carrinho</a>
                    </div>

                    <div class="category">
                        <ul>
                            <li><i class="fas fa-broom"></i><a href="">Limpeza</a></li>
                            <li><i class="fas fa-pepper-hot"></i><a href="">Hortifúti</a></li>
                            <li><i class="fas fa-cookie-bite"></i><a href="">Padaria</a></li>
                            <li><i class="fas fa-drumstick-bite"></i><a href="">Alimentos</a></li>
                            <li><i class="fas fa-percentage"></i><a href="">Promoções</a></li>
                            <li><i class="fas fa-ad"></i><a href="">Últimas fertas</a></li>
                        </ul>
                    </div>
                </div>
            </header>

            @yield('content')

            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        </div>
    </body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $(".add-cart").on('click', function() {
            let data = $(this).data()
            console.log(data)

            $.ajax({
                method: "POST",
                url: "/request/add-product",
                data: { data, "_token": $("#token").val()}
            })
        })
    })
</script>