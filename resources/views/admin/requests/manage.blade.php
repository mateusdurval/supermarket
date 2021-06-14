@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="padding:0; text-align: center">
            <div class="col-md-12">
                <h3>Número do Pedido - #{{ $request->id }}</h3>

                <div class="col-md-12 mb-4">
                    <div style="border-radius: 5px; background: #FFF; display: flex; justify-content: center; align-items: center; height: 180px">
                        <div class="status" style="width: 150px; display: flex; justify-content: center; align-items: center; flex-direction: column; margin-right: 25px; border: 1px solid #ccc; border-radius: 5px; padding: 10px">
                            @if ($request->status == 'PREPARATION')
                                <i class="fas fa-chart-pie" style="font-size: 30px; margin-bottom: 5px; color: red"></i>
                                <p>Em preparação</p>
                            @else 
                                <i class="fas fa-chart-pie" style="font-size: 30px; margin-bottom: 5px; color: green"></i>
                                <p>Em preparação</p>
                            @endif
                        </div>

                        @if ($request->status == 'PREPARATION')
                            <p style="margin-right: 10px">Encaminhar</p>
                            <a href="{{ route('update-status', [$request->id, 'PACKING']) }}" class="btn btn-sm btn-success" style="margin-right: 25px; font-size: 30px"><i class="fas fa-long-arrow-alt-right"></i></a>
                        @else
                            <a href="javascript:void(0)" class="btn btn-sm" style="background: #ccc; margin-right: 25px; font-size: 30px"><i class="fas fa-long-arrow-alt-right" style="color: #FFF"></i></a>
                        @endif

                        <div class="status" style="width: 150px; display: flex; justify-content: center; align-items: center; flex-direction: column; margin-right: 25px; border: 1px solid #ccc; border-radius: 5px; padding: 9px">
                            @if ($request->status == 'PREPARATION')
                                <i class="fas fa-box-open" style="font-size: 30px; margin-bottom: 5px"></i>
                                <p>Embalagem</p>
                            @endif

                            @if ($request->status == 'PACKING')
                                <i class="fas fa-box-open" style="font-size: 30px; margin-bottom: 5px; color: red"></i>
                                <p>Embalagem</p>
                            @endif

                            @if ($request->status != 'PACKING' && $request->status == 'DELIVERY' || $request->status == 'FINISHED')
                                <i class="fas fa-box-open" style="font-size: 30px; margin-bottom: 5px; color: green"></i>
                                <p>Embalagem</p>
                            @endif
                        </div>

                        @if ($request->status == 'PACKING')
                            <a href="{{ route('update-status', [$request->id, 'DELIVERY']) }}" class="btn btn-sm btn-success" style="margin-right: 25px; font-size: 30px"><i class="fas fa-long-arrow-alt-right"></i></a>
                        @else
                            <a href="javascript:void(0)" class="btn btn-sm" style="background: #ccc; margin-right: 25px; font-size: 30px"><i class="fas fa-long-arrow-alt-right" style="color: #FFF"></i></a>
                        @endif

                        <div class="status" style="width: 150px; display: flex; justify-content: center; align-items: center; flex-direction: column; border: 1px solid #ccc; border-radius: 5px; padding: 10px; margin-right: 20px">
                            @if ($request->status != 'DELIVERY' && $request->status == 'PACKING' || $request->status == 'PREPARATION')
                                <i class="fas fa-truck" style="font-size: 30px; margin-bottom: 5px;"></i>
                                <p>Saiu p/ entrega</p>
                            @endif

                            @if ($request->status == 'DELIVERY')
                                <i class="fas fa-truck" style="font-size: 30px; margin-bottom: 5px; color: red"></i>
                                <p>Saiu p/ entrega</p>
                            @endif

                            @if ($request->status == 'FINISHED')
                                <i class="fas fa-truck" style="font-size: 30px; margin-bottom: 5px; color: green"></i>
                                <p>Saiu p/ entrega</p>
                            @endif
                        </div>

                        @if ($request->status == 'DELIVERY')
                            <a href="{{ route('update-status', [$request->id, 'FINISHED']) }}" class="btn btn-sm btn-success" style="margin-right: 25px; font-size: 30px"><i class="fas fa-check"></i></a>
                        @else
                            <a href="javascript:void(0)" class="btn btn-sm" style="background: #ccc; margin-right: 25px; font-size: 30px"><i class="fas fa-check" style="color: #FFF"></i></a>
                        @endif

                        @if ($request->status == 'FINISHED')
                            <strong style="color: green; font-size: 15px">Entregue {{ date( 'd/m/Y' , strtotime($request->updated_at))}} às {{ date( 'H:m' , strtotime($request->updated_at))}}</strong>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="display: flex; flex-direction: row; margin-bottom: 100px; background: #FFF; padding: 25px; border-radius: 5px; height: 330px">
                <div class="col-md-6" style="overflow: scroll; margin-bottom: 20px">
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item list-group-item-action active" style="background: #ccc; border: none" aria-current="true">Carrinho de Produtos</li>
                        @foreach ($cartUser as $cart)
                            @foreach ($cart->products as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto" style="display: flex; justify-content: center; align-items: center">
                                        <div class="fw-bold"> #{{ $product->id }}  </div>
                                        <div class="fw-bold"><img src="{{ asset("storage/{$product->image}") }}" class="rounded-circle" alt="img" style="max-width: 60px; max-height: 60px"></div>
                                        <div class="fw-bold" style="margin-left: 20px">{{ $product->name }} - {{ $product->brand }}</div>
                                    </div>
                                    <span class="badge bg-danger rounded-pill" style="color: #fff">{{ $cart->amount }}</span>
                                </li>
                            @endforeach
                        @endforeach
                    </ol>
                </div>

                <div class="col-md-6 mb-5" style="padding: 20px; flex-direction: column; border: 1px solid #ccc; border-radius: 5px">
                    <div class="col-md-12 mb-4">
                        <h5><strong><i class="fas fa-map-marker-alt" style="color: rgb(243, 45, 45); margin-right: 5px"></i> Entregar para entrega</strong></h5> 

                        <p>{{ $request->address->district}}, {{ $request->address->street }}, {{ $request->address->number}} - {{ $request->address->reference }}</p>
                        <p style="margin-top: -20px">{{ $request->address->city }}, {{ $request->address->state}} - CEP: {{ $request->address->cep}}</p>
                    </div>

                    <div class="col-md-12">
                        <h5><strong><i class="fas fa-credit-card" style="color: rgb(243, 45, 45); margin-right: 5px"></i> Informações de pagamento</strong></h5>

                        <p>{{ strtoupper($request->card->flag) }} Final {{ substr($request->card->number, -4) }} - {{ strtoupper($request->card->full_name) }}</p>
                        <p style="margin-top: -20px">Válido até: {{ str_replace("-", "/", substr($request->card->expiration_date, -5)) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection