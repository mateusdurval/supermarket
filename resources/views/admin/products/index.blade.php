@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <div class="row" style="margin-bottom: 15px">
            <div class="col-md-6">
                <h4>Produtos em Estoque #{{ $total }}</h4>
            </div>

            <div class="col-md-6" align="right">
                <a href="{{ route('products-create') }}" class="btn btn-primary">Cadastrar Produtos <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>#ID</th>
                            <th>Nome</th>
                            <th>Marca</th>
                            <th>Descrição</th>
                            <th>Promoção</th>
                            <th>Qtd. Disponível</th>
                            <th style="width: 100px">Valor</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($products as $product)
                            <tr style="text-align: center">
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset("storage/{$product->image}") }}" class="rounded-circle" alt="img" style="max-width: 60px; max-height: 60px">
                                    @endif
                                </td>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->brand }}</td>
                                <td>
                                    @if (!$product->description)
                                        -
                                    @else
                                        {{ $product->description }}
                                    @endif
                                </td>
                                    @if($product->sale)
                                        <td><p style="background: #008f39; border-radius: 5px; padding: 2px; color: #FFF">Sim<p></td>
                                    @else
                                        <td><p style="background: #333; border-radius: 5px; padding: 2px; color: #FFF">Não<p></td>
                                    @endif
                                </td>
                                <td>{{ $product->amount }} unidades</td>
                                <td>R$ {{ $product->price }}</td>
                                <td><a href="{{ route('products-edit', $product->id) }}"><i class="fas fa-edit" style="color: #333;"></i></a></td>
                                <td><a href="javascript:void(0)" data-id="{{ $product->id }}" class="btn-delete"><i class="fas fa-trash-alt" style="color: #333;"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p>{{ $products->links() }}</p>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">OPS!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Você tem certeza que deseja excluir este produto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-confirm-delete" style="background: rgb(243, 45, 45); border: none">Sim, excluir</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let productId;
            let btnRemove;
            $(".btn-delete").on('click', function() {
                productId = $(this).data('id');
                btnRemove = $(this);
                $(".modal").modal('toggle');
            });

            $(".btn-confirm-delete").on('click', function() {
                $.ajax({
                    url: '/admin/products/destroy/'+productId,
                    method: 'POST',
                    data: { "_token": "{{ csrf_token() }}"}
                }).done(function(data) {
                    if (data == true) {
                        if (btnRemove != null) {
                            btnRemove.closest('tr').remove();
                            $(".modal").modal('toggle');
                        }
                    }
                })
            })
        })
    </script>
@endsection