@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3><strong>Adicione um novo cartão<strong></h3>    
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-10">
                <form action="{{ route('card-store') }}" method="POST" style="background: #FFF; border-radius: 5px; padding: 20px 30px;">
                @csrf
                    <input type="hidden" name="flag" id="flag">

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <img src="{{ asset("images/flags.jpg") }}" alt="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="number">Número do cartão</label>
                            <input type="text" class="form-control" name="number" id="number" placeholder="**** **** **** ****" required>
                            <div id="validNumber" class="valid-feedback"></div>
                            <div id="invalidNumber" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="full_name">Nome completo</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Ex.: Raphael Gomes Silva" required>
                            <div id="validNname" class="valid-feedback "></div>
                            <div id="invalidName" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="expiration_date">Data de vencimento</label>
                            <input type="month" class="form-control" id="expiration_date" name="expiration_date" placeholder="Ex.: 01/01/1111" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="cvc">Código de segurança</label>
                            <input type="text" class="form-control" id="cvc" name="cvc" placeholder="Ex.: 398" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-4">
                            <label for="cpf">CPF do titular do cartão</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Ex.: 000.000.000-00" required>
                        </div>
                    </div>

                    <a href="javascript:void(0)" class="btn btn-secondary" onclick="window.history.back(-1)"><i class="fas fa-angle-left"></i> Voltar</a>
                    <button type="submit" class="btn btn-primary" style="width: 30%; text-align: center">Adicionar cartão</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $("#cpf").mask('000.000.000-00');
            $("#number").mask('0000 0000 0000 0000');
            $("#cvc").mask('000');
        });
    </script>


    <script>
        $(document).ready(function() {
            $("#number").keyup(function() {
                let number = $(this).val();
                if (number.length == 19) {
                    let flag = getCardFlag(number);
                    if (flag != false) {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $("#validNumber").html(flag.toUpperCase());

                        $("#flag").val(flag);
                    } else {
                        $(this).removeClass('is-valid');
                        $(this).addClass('is-invalid');
                        $("#invalidNumber").html('Cartão inválido');
                    }
                }
            });

            $("#full_name").on('change', function() {
                let name = $(this).val();
                const regex = /[0-9]/;
                if (regex.test(name)) {
                    $(this).removeClass('is-valid');
                    $(this).addClass('is-invalid');
                    $("#invalidName").html('Nome inválido');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                }
            });

            $("#cvc").on('change', function() {
                let cvc = $(this).val();
                if (cvc.length >= 3) {
                    $(this).addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid');
                }
            });

            $("#cpf").on('change', function() {
                let cpf = $(this).val();
                if (cpf.length >= 14) {
                    $(this).addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid');
                }
            });

            $("#expiration_date").on('change', function() {
                $(this).addClass('is-valid');
            });
        });

        function getCardFlag(cardnumber) {
            const number = cardnumber.replace(/[^0-9]+/g, '');

            const cards = {
                visa      : /^4[0-9]{12}(?:[0-9]{3})/,
                mastercard : /^5[1-5][0-9]{14}/,
                diners    : /^3(?:0[0-5]|[68][0-9])[0-9]{11}/,
                amex      : /^3[47][0-9]{13}/,
                discover  : /^6(?:011|5[0-9]{2})[0-9]{12}/,
                hipercard  : /^(606282\d{10}(\d{3})?)|(3841\d{15})/,
                elo        : /^((((636368)|(438935)|(504175)|(451416)|(636297))\d{0,10})|((5067)|(4576)|(4011))\d{0,12})/,
                jcb        : /^(?:2131|1800|35\d{3})\d{11}/,       
                aura      : /^(5078\d{2})(\d{2})(\d{11})$/     
            };

            for (let flag in cards) {
                if(cards[flag].test(number)) {
                    return flag;
                }
            }       
            return false;
        }
    </script>
@endsection