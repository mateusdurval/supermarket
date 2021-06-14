@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="padding: 0">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            </div>
        </div>

        <h4>Cadastre um endereço para entrega</h4>
        <form action="{{ route('address-store') }}" method="POST" style="border: 1px solid #ccc; padding: 20px; border-radius: 5px; margin-top: 15px">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="cep">CEP:</label>
                    <input type="text" name="cep" class="form-control" id="cep" placeholder="Ex.: 41515-324" autocomplete="of">
                </div>

                <div class="form-group col-md-4">
                    <label for="city">Cidade:</label>
                    <input type="text" name="city" class="form-control" id="city" placeholder="Ex.: Salvador" autocomplete="of">
                </div>

                <div class="form-group col-md-4">
                    <label for="state">Estado:</label>
                    <input type="text" name="state" class="form-control" id="state" placeholder="Ex.: BA" autocomplete="of">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="street">Rua:</label>
                    <input type="text" name="street" class="form-control" id="street" placeholder="Ex.: Rua Alameda dos Campos" autocomplete="of">
                </div>

                <div class="form-group col-md-3">
                    <label for="district">Bairro:</label>
                    <input type="text" name="district" class="form-control" id="district" placeholder="Ex.: Campo Grande" autocomplete="of">
                </div>

                <div class="form-group col-md-2">
                    <label for="number">Número:</label>
                    <input type="text" name="number" class="form-control" id="number" placeholder="Ex.: 93 A" autocomplete="of">
                </div>

                <div class="form-group col-md-4">
                    <label for="reference">Complemento:</label>
                    <input type="text" name="reference" class="form-control" id="reference" placeholder="Ex.: Casa / Andar / Apt" autocomplete="of">
                </div>
            </div>  
            
            <div class="row">
                <div class="col-md-12" align="right">
                    <a href="javascript:void(0)" onclick="window.history.back(-1)" class="btn btn-dark">Anterior</a>
                    <button type="submit" class="btn btn-success">Próximo <i class="fas fa-angle-right"></i></button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $("#cep").mask('00000-000');

            $('#cep').change(function() {
                let cep = $(this).val();
                $.ajax({
                    url: `https://viacep.com.br/ws/${cep}/json/`,
                    method: 'GET',
                }).done(function(address) {
                    $('#city').val(address.localidade);
                    $('#state').val(address.uf);
                    $('#street').val(address.logradouro);
                    $('#district').val(address.bairro);
                    $('#number').focus();
                    console.log(address);
                });
            });
        });


    </script>
@endsection