<div class="row">
    @if (count($products) > 0)
    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
        @if (!auth()->check())
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6"><button class="btn btn-outline-orange d-block w-100" type="button"
                            data-bs-toggle="modal" data-bs-target="#login_modal">Login</button></div>
                    <div class="col"><button class="btn btn-orange d-block w-100" type="button" data-bs-toggle="modal"
                            data-bs-target="#create_modal">Criar conta</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @foreach ($products as $product)
        <div class="card mb-3">
            <div class="card-body shadow">
                <div class="row">
                    <div class="col-4 text-center"><img class="img-fluid shadow-none p-2"
                            src="{{ $product['product']['photos'][0]['preview_url'] }}" />
                    </div>
                    <div class="col">
                        <p class="mt-2"><strong> {{ $product['product']['name'] }}{{ $product['variation'] ? ' (' .
                                $product['variation'] . ')' : '' }}</strong></p>
                        <p class="mt-2"><strong>€{{ !$product['product']['sales_price'] ? $product['product']['price'] :
                                $product['product']['sales_price'] }}</strong></p>
                        <p class="text-black-50"></p>
                        <div class="input-group mb-3">
                            <input class="form-control" type="number" placeholder="Qty" min="1"
                                value="{{ $product['quantity'] }}" name="qty"
                                onchange="updateQty({{ $product['product']['id'] }}, this.value)" />
                            <button class="btn btn-danger btn-sm" type="button"
                                onclick="deleteProduct({{ $product['product']['id'] }})"><i
                                    class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <p>Preço</p>
                    </div>
                    <div class="col">
                        <p class="text-end">€ {{ $total_no_delivery }}</p>
                    </div>
                </div>
                @auth
                <hr style="color: rgb(0,0,0);" />
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="delivery" id="delivery1" value="0" {{ $delivery == 0 ? 'checked' : '' }}>
                    <label class="form-check-label d-flex justify-content-between" for="delivery1">
                        <span>Recolha na loja</span><span>Gratuito</span>
                    </label>
                </div>
                @if($company->shop_company->delivery_company)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="delivery" id="delivery2" value="1" {{ $delivery == 1 ? 'checked' : '' }}>
                    <label class="form-check-label d-flex justify-content-between" for="delivery2">
                        <span>{{ $company->shop_company->delivery_company }}</span><span>€ {{ $delivery_price }}</span>
                    </label>
                </div>
                @endif

                @endauth
                <hr style="color: rgb(0,0,0);" />
                <div class="row">
                    <div class="col">
                        <p style="font-size: 18px;"><strong>Total</strong></p>
                    </div>
                    <div class="col">
                        <p class="text-end" style="font-size: 18px;"><i class="fa fa-euro"></i>€ {{ $total }}</p>
                    </div>
                </div>
            </div>
        </div>
        @if (auth()->check())
        <div class="card shadow pt-2 mt-4">
            <div class="card-header">
                Endereços
            </div>
            <div class="card-body">
                @if ($address)
                <strong>Endereço de entrega</strong>
                <p>{{ $address->address }}<br>{{ $address->zip }} {{ $address->city }}<br>{{ $address->country->name
                    }}<br>
                    {!! $address->vat ? '<strong>NIF/ NIPC: </strong>' . $address->vat : '' !!}
                </p>
                <button class="btn btn-outline-dark d-block w-100" type="button" onclick="editAddress()">Editar</button>
                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="billing_same" {{
                        $address->billing_same ? 'checked' : '' }} onchange="changeSame({{ $address->id }})">
                    <label class="form-check-label" for="billing_same">Endereço de faturação diferente do
                        endereço de entrega</label>
                </div>
                <div class="collapse" id="billing_collapse">
                    <hr>
                    <strong>Endereço de faturação</strong>
                    <p>{!! $address->billing_address ? $address->billing_address : '<span
                            class="placeholder w-50"></span>'
                        !!}
                        <br>{!! $address->billing_zip ? $address->billing_zip : '<span class="placeholder w-25"></span>'
                        !!}
                        {{ $address->billing_city }}
                        <br>{!!
                        $address->billing_country ? $address->billing_country->name : '<span
                            class="placeholder w-25"></span>' !!}
                    </p>
                    <button class="btn btn-outline-dark d-block w-100" type="button"
                        onclick="editBillingAddress()">Editar</button>
                </div>
                @else
                <button class="btn btn-outline-dark d-block w-100" type="button" onclick="createAddress()">Criar
                    endereço para continuar</button>
                @endif
            </div>
        </div>
        @if ($address)
        <div class="card shadow pt-2 mt-4">
            <div class="card-body">
                @if(isset(array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay']) && (array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay']['mb_key'] != null || array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay']['mbway_key'] != null))
                <button class="btn btn-orange d-block w-100" type="button" onclick="paymentMethods()">Concluir</button>
                @elseif (array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay']['simple_mbway_number']
                != null)
                <button class="btn btn-orange d-block w-100" type="button"
                    onclick="paySimpleMbway({{ $total }}, {{ array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay']['simple_mbway_number'] }})">Pagar
                    para MBWAY</button>
                @else
                <button class="btn btn-orange d-block w-100" type="button" onclick="justBook()">Reservar</button>
                @endif
            </div>
        </div>
        @endif
        @endif
    </div>
    @else
</div>
<div class="alert alert-primary" role="alert">
    Não existem produtos ou serviços no seu carrinho!
</div>
@endif
<script>
    askMbwayPayment = () => {
        if ($('#celphone').val() !== ''){
            
            $.LoadingOverlay('show', {
                image: '',
                text: 'Operação financeira inicializada com sucesso'
            });

            let data = {
                cart: {!! collect(session()->get('cart')) !!},
                user: {!! $user !!},
                address: {!! $address !!},
                type: 'mbway',
                delivery: {!! $delivery !!},
                celphone: $('#celphone').val()
            }

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/cart/generate-payments',
                type: 'POST',
                dataType: 'json',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    console.log(response);
                    // verificar pagamento
                    setInterval(() => {
                        checkMbwayPayment(response.IdPedido);
                    }, 10000);
                },
                error: function(xhr, status, error) {
                    $.LoadingOverlay('hide');
                    console.error(error);
                }
            });
        } else {
            Swal.fire('Validação', 'Número de telemóvel necessário', 'error');
        }

    }

    checkMbwayPayment = (idPedido) => {
        let mbway_key = $('#mbway_key').val();
        $.get('/cart/check-mbway-payment/' + idPedido + '/' + mbway_key).then((resp) => {
            console.log(resp);
            if(resp == 'Operação financeira concluída com sucesso'){
                $('.loadingoverlay > div').html(resp);
                setTimeout(() => {
                    $.LoadingOverlay('hide');
                    Swal.fire(resp, 'Pode continuar', 'success').then(() => {
                        deleteCart();
                        setTimeout(() => {
                            window.location.href="/";
                        }, 500);
                    });
                }, 1000);
            } else if (resp == 'Operação financeira inicializada com sucesso' || resp == 'Operação financeira não encontrada') {
                $('.loadingoverlay > div').html('Aguardamos conclusão da operação');
            } else {
                $('.loadingoverlay > div').html(resp);
                setTimeout(() => {
                    $.LoadingOverlay('hide');
                    Swal.fire('Pagamento cancelado', resp, 'error').then(() => {
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    });
                }, 1000);
            }
        });
    }

    generatePayment = (type) => {

        $('#payment_methods').modal('hide');

        switch (type) {
            case 'mbway':
                $('#mbway_modal').modal('show');
                break;
            default:
                $.LoadingOverlay('show');
                let data = {
                    cart: {!! collect(session()->get('cart')) !!},
                    user: {!! $user !!},
                    address: {!! $address !!},
                    type: type,
                    delivery: {!! $delivery !!},
                }
            
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '/cart/generate-payments',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(resp) {
                        $.LoadingOverlay('hide');
                        $('#mb_modal').modal('show');
                        let html = '<tr>';
                        html += '<th>Entidade</th>';
                        html += '<td>' + resp.Entity + '</td>';
                        html += '</tr>';
                        html += '<tr>';
                        html += '<th>Referência</th>';
                        html += '<td>' + resp.Reference.replace(/(\d{3})(?=\d)/g, "$1 ") + '</td>';
                        html += '</tr>';
                        html += '<tr>';
                        html += '<th>Valor</th>';
                        html += '<td>€ ' + parseFloat(resp.Amount).toFixed(2) + '</td>';
                        html += '</tr>';
                        $('#mb_modal tbody').html(html);~
                        $('#RequestId').val(resp.RequestId);
                        console.log(resp);
                    },
                    error: function(xhr, status, error) {
                        $.LoadingOverlay('hide');
                        // Lógica de manipulação de erro
                        console.error(error);
                    }
                });
            break;
        }

    }

    paySimpleMbway = (total, simple_mbway_number) => {
        $.LoadingOverlay('show');
            let data = {
                cart: {!! collect(session()->get('cart')) !!},
                user: {!! $user !!},
                address: {!! $address !!},
                type: 'simple mbway',
                delivery: {!! $delivery !!},
            }

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/cart/generate-payments',
                type: 'POST',
                dataType: 'json',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $.LoadingOverlay('hide');
                    console.log(response);
                    $('#simple_mbway_modal').modal('show');
                    $('#simple_mbway_modal span').text(total);
                    $('#simple_mbway_modal h3').text(simple_mbway_number);
                },
                error: function(xhr, status, error) {
                    $.LoadingOverlay('hide');
                    console.error(error);
                }
            });
    }

    justBook = () => {
        $.LoadingOverlay('show');
            let data = {
                cart: {!! collect(session()->get('cart')) !!},
                user: {!! $user !!},
                address: {!! $address !!},
                type: 'reserva',
            }

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/cart/generate-payments',
                type: 'POST',
                dataType: 'json',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $.LoadingOverlay('hide');
                    swal.fire('Reservado', 'Vamos contactar para cuidar do pagamento e entrega.', 'success').then(() => {
                        deleteCart();
                        setTimeout(() => {
                            window.location.href="/";
                        }, 500);
                    });
                },
                error: function(xhr, status, error) {
                    $.LoadingOverlay('hide');
                    console.error(error);
                }
            });
    }

    $(()=>{
        $('input[name=delivery]').on('change', function() {
            var delivery = $(this).val();
            $.get('/lojas/changeDelivery/' + delivery).then(()=>{
                getCheckout();
            });
        });
    });

    console.log({!! $company !!})

</script>