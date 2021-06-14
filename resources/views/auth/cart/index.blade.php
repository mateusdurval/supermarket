@extends('layouts.app')

@section('content')
    @if (!$total)
        <div class="container" align="center">
            <h4>OPS!</h4>
            <h5>Parece que você ainda não adicionou nenhum produto ao seu carrinho.</h5>
        </div>
    @else
        <div class="container-lg">
            <div class="col-md-12">
                <table class="table table-hover table-bordered" style="text-align:center;">
                    <h3>Seu carrinho</h3>
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th></th>
                            <th style="width: 220px">Produto</th>
                            <th>Entrega</th>
                            <th>Valor</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>

                    <tbody id="body">
                        @foreach($carts as $cart) 
                            @foreach($cart->products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset("storage/{$product->image}") }}" class="rounded-circle" alt="img" style="max-width: 60px; max-height: 60px">
                                    @endif
                                </td>
                                <td>{{ $product->name }} - {{ $product->brand }}, {{ $product->description }}</td>
                                <td>Frete Grátis</td>
                                <td id="price">R$ {{ $product->price }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger remove btnUpdateValue" data-id="{{ $product->id }}">-</button>
                                    <span style="margin: 0 10px" class="value">{{ $cart->amount }}</span>
                                    <button class="btn btn-sm btn-success add btnUpdateValue" data-id="{{ $product->id }}">+</button>
                                </td>
                                <td><a href="javascript:void(0)" class="btn-remove-request" data-id="{{ $product->id }}" style="color: #333; border: 1px solid #333; padding: 4px; border-radius: 4px">Remover <i class="far fa-trash-alt"></i></a></td>
                            </tr>
                            @endforeach
                        @endforeach
                        <tr>
                            <td colspan="5">
                                <a href="javascript:void(0)" class="btn reload" style="border: 1px solid #ccc; border-radius: 20px; margin-right: 5px; transition: all 0.3s; display: none;"><i class="fas fa-redo"></i></a>
                                Valor total: <span id="total" style="font-size: 20px; color: red">R$ {{ number_format($total, 2, ',', '') }}</span>
                            </td>
                            <td colspan="2"><a href="{{ route('verifyAddress') }}" class="btn btn-success" style="width: 100%">Próximo <i class="fas fa-angle-right"></i></a></td>
                        </tr>
                    </tbody>
                </table>   

                <a href="javascript:void(0)" class="btn btn-secondary" onclick="window.history.back(-1)"><i class="fas fa-angle-left"></i> Voltar</a>             
            </div>
        </div>
    @endif

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
                    Você tem certeza que deseja remover este produto do seu carrinho?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-confirm-delete-request" style="background: rgb(243, 45, 45); border: none">Sim, remover</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let newValue, currentValue = 0;
            let productId;

            $(".add").on('click', function() {
                const productId = $(this).closest('tr').find('button').data('id');

                const currentValue = parseInt($(this).closest('tr').find('span.value').text());
                newValue = currentValue + 1;
                $(this).closest('tr').find('span.value').text(newValue);

                updateAmout(newValue, productId);
            });

            $(".remove").on('click', function() {   
                const productId = $(this).closest('tr').find('button').data('id');

                const currentValue = parseInt($(this).closest('tr').find('span.value').text());
                if (currentValue == 1) {
                    return;
                }
                newValue = currentValue - 1;
                updateAmout(newValue, productId);
                $(this).closest('tr').find('span.value').html(newValue);
            });

            function updateAmout(value, productId) {
                $.ajax({
                    method: 'PUT',
                    url: '/carts/update-amount',
                    data: {
                        amount: value,
                        productId: productId,
                        "_token": "{{ csrf_token() }}", 
                    }
                }).done(function(res) {
                    response = JSON.parse(res);
                    if (response.success) {
                        $(".reload").css({ display: "inline" })
                    }
                });
            }

            $(".reload").on('click', () => {
                location.reload();
            });

            $(".btn-remove-request").on('click', function() {   
                productId = $(this).data('id');
                $(".modal").modal('toggle');
                let htmlClass = $(this);
                
                $(".btn-confirm-delete-request").on('click', function() {
                    $.ajax({
                        method: 'DELETE',
                        url: '/carts/destroy/'+productId,
                        data: { "_token": "{{ csrf_token() }}"}
                    }).done(function(res) {
                        console.log(res)
                        if (res.success) {
                            if (htmlClass != null) {
                                $(htmlClass).closest('tr').remove();
                                $(".modal").modal('toggle');
                            }
                        }
                    })
                })
            });
        });
    </script>
@endsection