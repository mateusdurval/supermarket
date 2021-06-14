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
                <h3>Como você deseja pagar suas compras?</h3>
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-6" style="margin-top: 10px; background: rgba(255, 255, 255, 0.6); border-radius: 5px; display: flex; justify-content: center;">
                @foreach ($cards->cards as $card)
                    <div class="form-check" style="padding: 8px;">
                        <input class="form-check-input" type="radio" name="card" id="card" value="{{ $card->id }}" data-card="{{ $card->id }}" checked>
                        <label class="form-check-label" for="exampleRadios1" style="text-align: center">
                            {{ strtoupper($card->full_name) }} - {{ strtoupper($card->flag) }} Final {{ substr($card->number, -4) }} <br>
                            Valid Thru: {{ str_replace("-", "/", substr($card->expiration_date, -5)) }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="col-md-5" style="margin-top: 10px; margin-left: 30px; background: rgba(255, 255, 255, 0.6); border-radius: 5px; display: flex; justify-content: center;">
                <div class="form-check" style="padding: 8px;">
                    <input class="form-check-input" type="radio" name="address" id="address" value="pix">
                    <label class="form-check-label" for="exampleRadios1" style="text-align: center">
                        Pagamento com PIX <br>
                        <strong<>CNPJ: 84.484.762/0001-09
                    </label>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 20px; text-align: center;">
                <div class="col-md-12" style="text-align: center">
                    <p style="font-size: 16px">Ou se preferir, <a href="{{ route('card-create') }}">clique aqui adicionar um novo cartão :D</a></p>
                </div>
            </div>
        <div>

        <div class="row" style="margin-top: 15px; width: 100%">
            <div class="col-md-12" style="text-align: center">
                <a href="javascript:void(0)" class="btn btn-secondary" onclick="window.history.back(-2)"><i class="fas fa-angle-left"></i> Voltar</a>             
                <a href="javascript:void(0)" class="btn btn-success finish">Próximo <i class="fas fa-angle-right"></i></a> 
            </div>
        </div>

    <script>
        $(document).ready(function() {
            $('.finish').on('click', function() {
                let cardId = $('#card').data("card");
                let addressId = parseInt(localStorage.getItem('addressId'));

                $.ajax({
                    url: '/user/requests/store',
                    method: 'POST',
                    data: { 
                        "_token": "{{ csrf_token() }}", 
                        "cardId": cardId, 
                        "addressId": addressId 
                    }
                }).done((res) => {
                    response = JSON.parse(res);
                    if (response.success == true) {
                        window.location.href = "http://localhost:8000/user/requests/review"
                    }
                });
            });
        });
    </script>
@endsection