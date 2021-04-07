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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>        

        <link href="{{ asset('css/global.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('css/welcome/style.css') }}" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div id="welcome">
            <header class="header-app">
                <div class="top-header">
                    
                    <a href="/"><img src="{{ asset('images/logo.png') }}" widht="150" height="150" alt="logo"></a>

                    <form action="{{ route('products-search') }}" method="GET">
                        <input type="text" name="query" placeholder="Encontre aqui as melhores ofertas" autocomplete="off">
                        <button type="submit">OK</button>
                    </form>

                    <h4>Aproveite nossas ofertas com <span>FRETE GRÁTIS!</span></h4>
                </div>

                <div class="content-header">
                    <div class="contents">
                        <h4>Compre pelo Telefone <strong><i class="fas fa-phone-square-alt"></i> (71) 3416-6055</strong></h4>

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
                                            @if( Auth::user()->isAdmin )
                                                {{ __('(Admin)') }}
                                            @endif
                                        </a>
                                        <p style="font-size: 15px; margin-top: -5px">CPF: {{ Auth::user()->cpf }}</p>

                                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                        
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #000">
                                                {{ __('Sair') }}
                                            </a>

                                            @if( Auth::user()->isAdmin )
                                                <a class="dropdown-item" href="{{ route('products') }}" style="color: #000">
                                                    {{ __('Produtos') }}
                                                </a>
                                            @endif

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>

                                    </li>
                            @endguest
                        </div>

                        @if (!Auth::check())
                            <a href="/login" class="showModal"><i class="fas fa-shopping-cart "></i> Meu carrinho</a>
                        @else
                            <a href="{{ route('requests') }}" class="showModal"><i class="fas fa-shopping-cart "></i> Meu carrinho</a>
                        @endif
                    </div>

                    <div class="category">
                        <ul>
                            <li><i class="fas fa-broom"></i><a href="{{ route('products-search') }}?query=limpeza">Limpeza</a></li>
                            <li><i class="fas fa-pepper-hot"></i><a href="{{ route('products-search') }}?query=hortifruti">Hortifruti</a></li>
                            <li><i class="fas fa-cookie-bite"></i><a href="{{ route('products-search') }}?query=padaria">Padaria</a></li>
                            <li><i class="fas fa-drumstick-bite"></i><a href="{{ route('products-search') }}?query=alimentos">Alimentos</a></li>
                            <li><i class="fas fa-percentage"></i><a href="{{ route('products-search') }}?query=promoções">Promoções</a></li>
                            <li><i class="fas fa-ad"></i><a href="{{ route('products-search') }}?query=ofertas">Últimas Ofertas</a></li>
                        </ul>
                    </div>
                </div>
            </header>

            @if (Auth::check())
                <a href="{{ route('requests') }}" class="btn-car"><i class="fas fa-shopping-cart "></i></a>
            @else
                <a href="/login" class="btn-car"><i class="fas fa-shopping-cart "></i></a>
            @endif
            
            @yield('content')
        </div>
    </body>
</html>