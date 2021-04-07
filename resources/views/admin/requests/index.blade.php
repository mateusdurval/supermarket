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
                        @foreach($requests as $request) 
                            @foreach($request->product as $product)
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
                                    <button class="btn btn-sm btn-danger remove">-</button>
                                    <span style="margin: 0 10px" class="value">1</span>
                                    <button class="btn btn-sm btn-success add">+</button>
                                </td>
                                <td><a href="javascript:void(0)" class="btn-remove-request" data-id="{{ $product->id }}" style="color: #333; border: 1px solid #333; padding: 4px; border-radius: 4px">Remover <i class="far fa-trash-alt"></i></a></td>
                            </tr>
                            @endforeach
                        @endforeach
                        <tr>
                            <td colspan="5">
                                Valor total: <span id="finalPrice" style="font-size: 20px; color: red">R$ {{ number_format($total, 2, ',', '') }}</span>
                            </td>
                            <td colspan="2"><a href="" class="btn btn-success" style="width: 100%">Próximo <i class="fas fa-angle-right"></i></a></td>
                        </tr>
                    </tbody>
                </table>   

                <a href="javascript:void(0)" onclick="window.history.back(-1)"><i class="fas fa-angle-left"></i> Voltar</a>             
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
                currentValue = parseInt($(".value").html())
                console.log(currentValue);
                newValue = currentValue + 1;
                $(this).closest('tr').find('span.value').text(newValue);
            });

            $(".remove").on('click', function() {   
                currentValue = parseInt($(".value").html());
                if (currentValue == 1) {
                    return;
                }
                newValue = currentValue - 1;
                $(this).closest('tr').find('span.value').html(newValue);
            });

            $(".btn-remove-request").on('click', function() {   
                productId = $(this).data('id');
                $(".modal").modal('toggle');
                let htmlClass = $(this);
                
                $(".btn-confirm-delete-request").on('click', function() {
                    $.ajax({
                        method: 'POST',
                        url: '/admin/requests/destroy/'+productId,
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