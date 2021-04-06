@extends('layouts.app')

@section('content')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
    <script>
        $(document).ready(function () { 
            $("#price").mask('#.0#');
        });
    </script>    

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('products-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $product->id }}">

                    <div class="form-row">
                        <div class="col-md-3">
                            <label for="image">Imagem</label>
                            <input type="file" id="image" name="image" class="form-control-file" value="{{ $product->image }}">
                        </div>

                        <div class="col-md-3">
                            <label for="name">Nome</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Ex.: Arroz Branco" value="{{ $product->name }}">
                        </div>

                        <div class="col-md-3">
                            <label for="brand">Marca</label>
                            <input type="text" id="brand" name="brand" class="form-control" placeholder="Ex.: Camil" value="{{ $product->brand }}">
                        </div>

                        <div class="col-md-3">
                            <label for="description">Descrição</label>
                            <input type="text" id="description" name="description" class="form-control" placeholder="Ex.: Parboilizado tipo A" value="{{ $product->description }}">
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 10px">
                        <div class="col-md-3">
                        <label for="category">Categoria</label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="{{ $product->category->category }}" selected>{{ $product->category->category }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="sale">Promoção</label>
                            <select name="sale" id="sale" class="form-control">
                                <option selected>
                                    @if ($product->sale == '1')
                                        Sim
                                    @else
                                        Não
                                    @endif
                                </option>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="amount">Quantidade Disponível</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="Ex.: 20" value="{{ $product->amount }}">
                        </div>

                        <div class="col-md-3">
                            <label for="price">Valor</label>
                            <input type="text" id="price" name="price" class="form-control" placeholder="Ex.: R$ 4,56" value="{{ $product->price }}">
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 15px">
                        <button type="submit" class="btn" style="margin-right: 7px; color: #FFF; background: rgb(250, 206, 8);">Atualizar Produto</button>
                        <a href="{{ route('products') }}" class="btn btn-dark">Voltar</a>
                    </div>
                </form>
            </div>  
        </div>
    </div>
@endsection