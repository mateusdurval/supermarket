@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('products-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-row">
                        <div class="col-md-3">
                            <label for="image">Imagem</label>
                            <input type="file" id="image" name="image" class="form-control-file">
                        </div>

                        <div class="col-md-3">
                            <label for="name">Nome</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Ex.: Arroz Branco" required>
                        </div>

                        <div class="col-md-3">
                            <label for="brand">Marca</label>
                            <input type="text" id="brand" name="brand" class="form-control" placeholder="Ex.: Camil" required>
                        </div>

                        <div class="col-md-3">
                            <label for="description">Descrição</label>
                            <input type="text" id="description" name="description" class="form-control" placeholder="Ex.: Parboilizado tipo A" required>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 10px">
                        <div class="col-md-3">
                            <label for="category">Categoria</label>
                            <select name="category" id="category" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="sale">Promoção</label>
                            <select name="sale" id="sale" class="form-control" required>
                                <option value="0" selected>Não</option>
                                <option value="1">Sim</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="amount">Quantidade Disponível</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="Ex.: 20" required>
                        </div>

                        <div class="col-md-3">
                            <label for="price">Valor</label>
                            <input type="text" id="price" name="price" class="form-control" placeholder="Ex.: R$ 4,56" required>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 15px;">
                        <button type="submit" class="btn btn-success" style="color: #FFF; margin-right: 7px">Cadastrar Produto</button>
                        <a href="{{ route('products') }}" class="btn btn-dark">Voltar</a>
                    </div>
                </form>
            </div>  
        </div>
    </div>
@endsection