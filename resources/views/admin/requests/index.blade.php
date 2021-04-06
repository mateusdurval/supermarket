@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="col-md-12">
            <table class="table table-hover table-bordered" style="text-align:center;">
                <h3>Seu carrinho</h3>
                <thead>
                    <tr>
                        <th></th>
                        <th>#ID</th>
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
                            <td></td>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }} - {{ $product->brand }}, {{ $product->description }}</td>
                            <td>Frete Grátis</td>
                            <td id="price">R$ {{ $product->price }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger remove">-</button>
                                <span style="margin: 0 10px" class="value">1</span>
                                <button class="btn btn-sm btn-success add">+</button>
                            </td>
                            <td><a href="">Remover</a></td>
                        </tr>
                        @endforeach
                    @endforeach
                    <tr>
                        <td colspan="4"></td>
                        <td>Valor total: R$ <span id="finalPrice">0</span></td>
                    </tr>
                </tbody>
            </table>                
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let finalPrice = 0;

            sumTotal();
            function sumTotal() {
                const totalPrices = $('tr').each(function(index, price) {
                    return price;
                })

                const prices = totalPrices.map(function(index, tr) {
                    console.log(tr.get())
                })
            }

            $(".add").on('click', function() {
                addToCart(this);
                const price = $(".value").closest('tr').find('td#price').html();
                const breakPrice = price.split(" ");
                const newPrice = breakPrice[1];
                finalPrice = finalPrice + parseFloat(newPrice.replace(',', '.'));
                $("#finalPrice").html(finalPrice);
            });

            $(".remove").on('click', function() {   
                removeToCart(this);
            });

            function addToCart(tr) {
                let currentValue = parseInt($(".value").html());
                let newValue = currentValue + 1;
                $(tr).closest('tr').find('span').html(newValue);
            }

            function removeToCart(tr) {
                let currentValue = parseInt($(".value").html());
                if (currentValue == 1)
                    return;
                let newValue = currentValue - 1;
                $(tr).closest('tr').find('span').html(newValue);
            }
        });
    </script>
@endsection