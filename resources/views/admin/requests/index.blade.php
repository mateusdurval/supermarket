@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Pedidos</h3>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Endereço</th>
                            <th>Status / Setor</th>
                        </tr>

                        <tr>
                            @foreach($requests as $request)
                                <td>{{ $request->user->name }}</td>
                                <td>{{ $request->address->street }}, {{ $request->address->number }}</td>
                                <td>
                                    @if ($request->status == 'PREPARATION')
                                        Preparação
                                    @elseif ($request->status == 'PACKING')
                                        Embalagem
                                    @elseif ($request->status == 'DELIVERY')
                                        Entrega
                                    @elseif ($request->status == 'FINISHED')
                                        Finalizado
                                    @endif
                                </td>
                                <td style="text-align: center;"><a href="{{ route('admin-requests-manage', $request->id) }}"><i class="fas fa-pencil-alt" style="color: #000;"></i></a></td>
                            @endforeach
                        </tr>
                    </thead>                
                </table>
            </div>
        </div>
    </div>
@endsection