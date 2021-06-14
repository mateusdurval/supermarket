@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="padding: 0">
                @if (Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="padding: 0">
                <h3>Como você deseja receber a sua compra?</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4" style="margin-top: 25px; padding: 0">
                <h5>Endereço</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6" style="margin-top: 10px; background: rgba(255, 255, 255, 0.6); border-radius: 5px; display: flex; justify-content: center;">
                @foreach ($adresses->adresses as $address)
                    <div class="form-check" style="padding: 8px">
                        <input class="form-check-input" type="radio" name="address" id="address" value="{{ $address->id }}" data-address="{{ $address->id }}" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            {{ $address->street }} {{ $address->number }},
                            {{ $address->city }} - {{ $address->state }}
                            ({{ $address->cep }})
                        </label> <br>
                        <i class="fas fa-map-marker-alt" style="width: 100%; text-align: center"></i> 
                    </div>
                @endforeach
            </div>

            <div class="col-md-5" style="margin-top: 10px; margin-left: 10px; background: rgba(255, 255, 255, 0.6); border-radius: 5px; display: flex; justify-content: center;">
                <div class="form-check" style="padding: 8px">
                    <input class="form-check-input" type="radio" name="address" id="address" value="local">
                    <label class="form-check-label" for="exampleRadios1">
                        Retirar no Local
                    </label> <br>
                    <i class="fas fa-map-marker-alt" style="width: 100%; text-align: center"></i> 
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 20px; text-align: center">
            <div class="col-md-12">
                <p style="font-size: 16px">Ou se preferir, <a href="{{ route('address-create') }}">clique aqui cadastre um novo endereço :P</a></p>
            </div>
        </div>

        <div class="row" style="margin-top: 15px;">
            <div class="col-md-12" style="text-align: center">
                <a href="javascript:void(0)"class="btn btn-secondary" onclick="window.history.back(-2)"><i class="fas fa-angle-left"></i> Voltar</a>             
                <a href="{{ route('verifyCard') }}" class="btn btn-success next">Continuar <i class="fas fa-angle-right"></i></a> 
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.next').on('click', function() {
                    let addressId = $('#address').data("address");
                    localStorage.setItem('addressId', addressId);
                });
            });
    </script>
    </div>
@endsection