@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h3>Finalizar pedido </h3>
            </div>
        </div>

        <div class="row" style="border-radius: 5px; padding: 30px; background: #FFF; display: flex; flex-direction: row; margin-bottom: 80px">
            <div class="col-md-6">
                <div class="col-md-12 mb-3" style="border: 1px solid #ccc; border-radius: 5px; padding: 15px">
                    <h5><strong><i class="fas fa-map-marker-alt" style="color: rgb(243, 45, 45); margin-right: 5px"></i> Entregar em</strong></h5> 

                    <p>{{ $request->address->district}}, {{ $request->address->street }}, {{ $request->address->number}} - {{ $request->address->reference }}</p>
                    <p style="margin-top: -20px">{{ $request->address->city }}, {{ $request->address->state}} - CEP: {{ $request->address->cep}}</p>
                </div>

                <div class="col-md-12" style="border: 1px solid #ccc; border-radius: 5px; padding: 15px">
                    <h5><strong><i class="fas fa-credit-card" style="color: rgb(250, 206, 8); margin-right: 5px"></i> Método de pagamento</strong></h5>
                    
                    <p>{{ $request->card->full_name }}, {{ strtoupper($request->card->flag) }} Final {{ substr($request->card->number, -4) }}</p>
                    <p style="margin-top: -20px">Válido até: {{ str_replace("-", "/", substr($request->card->expiration_date, -5)) }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="col-md-12 mb-5" style="border: 1px solid #ccc; border-radius: 5px; padding: 15px; height: 100%">
                    <strong>Seu carrinho <i class="fas fa-shopping-cart"></i></strong>
                        <table class="table table-hover " style="text-align: center; margin-top: 10px">
                            <tbody>
                                @foreach ($carts as $cart)
                                    @foreach ($cart->products as $product)
                                        <tr>
                                            <td>
                                                @if ($product->image)
                                                    <img src="{{ asset("storage/{$product->image}") }}" class="rounded-circle" alt="img" style="max-width: 40px; max-height: 40px">
                                                @endif
                                            </td>
                                            <td>{{ $product->name }} - {{ $product->brand }}</td>
                                            <td>Qtd: {{ $cart->amount }}</td>
                                            <td>R$ {{ $product->price }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                <tr>
                                    <td colspan="4">
                                        Valor total: <span id="finalPrice" style="font-size: 18px; color: red;">R$ {{ number_format($total, 2, ',', '') }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 15px; text-align: right">
                <a href="javascript:void(0)" class="btn btn-secondary" onclick="window.history.back(-1)"><i class="fas fa-angle-left"></i> Voltar</a>
                <a href="javascript:void(0)" class="btn btn-success finish" data-id="{{ $request->id }}">Finalizar compra</a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".finish").on('click', () => {
                const requestId = $(".finish").data('id');
                $.ajax({
                    method: 'PUT',
                    url: '/user/requests/checkout',
                    data: { 
                        "requestId": requestId,
                        "_token": "{{ csrf_token() }}", 
                    }
                }).done((res) => {
                    response = JSON.parse(res);
                    if (response.success) {
                        window.location.href = '/user/requests/status';
                    }
                });
            });
        })
    </script>
@endsection