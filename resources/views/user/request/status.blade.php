@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
                @if ($request->status == 'PREPARATION')
                    <h3>Pedido realizado com sucesso! #{{ $request->id }}</h3>
                @else
                    <h3>Status do pedido #{{ $request->id }}</h3>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <div style="border-radius: 5px; background: #FFF; display: flex; justify-content: center; align-items: center; height: 200px">
                    <div class="status" style="width: 250px; display: flex; justify-content: center; align-items: center; flex-direction: column; margin-right: 25px; border: 1px solid #ccc; border-radius: 5px; padding: 10px">
                        @if ($request->status == 'PREPARATION')
                            <i class="fas fa-chart-pie" style="font-size: 30px; margin-bottom: 5px; color: red"></i>
                            <p>Em preparação</p>
                        @else 
                            <i class="fas fa-chart-pie" style="font-size: 30px; margin-bottom: 5px; color: green"></i>
                            <p>Em preparação</p>
                        @endif
                    </div>

                    <i class="fas fa-long-arrow-alt-right" style="margin-right: 25px; font-size: 30px"></i>

                    <div class="status" style="width: 250px; display: flex; justify-content: center; align-items: center; flex-direction: column; margin-right: 25px; border: 1px solid #ccc; border-radius: 5px; padding: 10px">
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

                    <i class="fas fa-long-arrow-alt-right" style="margin-right: 25px; font-size: 30px"></i>

                    <div class="status" style="width: 250px; display: flex; justify-content: center; align-items: center; flex-direction: column; border: 1px solid #ccc; border-radius: 5px; padding: 10px">
                        @if ($request->status != 'DELIVERY' && $request->status == 'PACKING' || $request->status == 'PREPARATION')
                            <i class="fas fa-truck" style="font-size: 30px; margin-bottom: 5px;"></i>
                            <p>Saiu para entrega</p>
                        @endif

                        @if ($request->status == 'DELIVERY')
                            <i class="fas fa-truck" style="font-size: 30px; margin-bottom: 5px; color: red"></i>
                            <p>Saiu para entrega</p>
                        @endif

                        @if ($request->status == 'FINISHED')
                            <i class="fas fa-truck" style="font-size: 30px; margin-bottom: 5px; color: green"></i>
                            <p>Saiu para entrega</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="text-align: center">
                @if ($request->status == 'PREPARATION')
                    <p>Seu pedido foi encaminhado ao setor de preparação</p>
                @endif

                @if ($request->status == 'PACKING')
                    <p>Seu pedido está sendo embalado</p>
                @endif

                @if ($request->status == 'DELIVERY')
                    <p>Seu pedido está indo até você</p>
                @endif


                @if ($request->status == 'FINISHED')
                    <p>Seu pedido foi entregue em {{ date( 'd/m/Y' , strtotime($request->updated_at))}} às {{ date( 'H:m' , strtotime($request->updated_at))}}</p>
                @endif
            </div>

        </div>
    </div>
@endsection