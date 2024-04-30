@extends('website.layouts.website')
@section('description')
Checkout
@endsection
@section('header')
<section id="privacy" style="position: relative; z-index: 1;">
    <div class="container d-xl-flex justify-content-xl-center align-items-xl-center" style="height: 100px;">
        <h1 class="display-3" style="color: #ffffff;">Checkout</h1>
    </div>
</section>
@endsection
@section('content')
<div class="container p-5">
    <div class="container" id="inner_checkout"></div>
</div>
<!-- Modal -->
<div class="modal fade" id="create_address_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="create_address_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="create_address_label">Endereço</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/cart/create-address" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user ? $user->id : '' }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Código Postal</label>
                        <input type="text" name="zip" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Localidade</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>País</label>
                        <select name="country_id" class="form-control" required>
                            @foreach ($countries as $country)
                            <option {{ $country->id == 170 ? 'selected' : '' }} value="{{ $country->id }}">{{
                                $country->name
                                }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Número de contribuinte</label>
                        <input type="text" name="vat" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Gravar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="edit_address_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="edit_address_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit_address_label">Atualizar endereço</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/cart/update-address" method="post">
                @csrf
                <input type="hidden" name="address_id" value="{{ $address ? $address->id : '' }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" name="address" class="form-control" required
                            value="{{ $address ? $address->address : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Código Postal</label>
                        <input type="text" name="zip" class="form-control" required
                            value="{{ $address ? $address->zip : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Localidade</label>
                        <input type="text" name="city" class="form-control" required
                            value="{{ $address ? $address->city : '' }}">
                    </div>
                    <div class="form-group">
                        <label>País</label>
                        <select name="country_id" class="form-control" required>
                            @foreach ($countries as $country)
                            <option {{ $address && $country->id == $address->country_id ? 'selected' : '' }} value="{{
                                $country->id
                                }}">{{
                                $country->name
                                }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ $address ? $address->phone : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Número de contribuinte</label>
                        <input type="text" name="vat" class="form-control" value="{{ $address ? $address->vat : '' }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="edit_billing_address_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="edit_billing_address_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit_billing_address_label">Atualizar endereço de faturação</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/cart/update-billing-address" method="post">
                @csrf
                <input type="hidden" name="address_id" value="{{ $address ? $address->id : '' }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" name="billing_address" class="form-control" required
                            value="{{ $address ? $address->billing_address : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Código Postal</label>
                        <input type="text" name="billing_zip" class="form-control" required
                            value="{{ $address ? $address->billing_zip : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Localidade</label>
                        <input type="text" name="billing_city" class="form-control" required
                            value="{{ $address ? $address->billing_city : '' }}">
                    </div>
                    <div class="form-group">
                        <label>País</label>
                        <select name="billing_country_id" class="form-control" required>
                            @foreach ($countries as $country)
                            @if ($address && $address->billing_country_id)
                            <option {{ $country->id == $address->billing_country_id ? 'selected' : '' }} value="{{
                                $country->id }}">{{
                                $country->name
                                }}</option>
                            @else
                            <option {{ $country->id == 170 ? 'selected' : '' }} value="{{
                                $country->id }}">{{
                                $country->name
                                }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="payment_methods" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Pagamento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(isset(array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay'])
                &&
                array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay']['mb_key']
                != null)
                <button class="btn btn-outline-info d-block w-100">
                    <img src="/theme/assets/img/payment/mbway-logo.png" alt="MBWay" class="img-fluid"
                        onclick="generatePayment('mbway')">
                </button>
                @endif
                @if(isset(array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay'])
                &&
                array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay']['mbway_key']
                != null)
                <button class="btn btn-outline-info d-block w-100 mt-3">
                    <img src="/theme/assets/img/payment/mb-logo.png" alt="Multibanco" class="img-fluid"
                        onclick="generatePayment('multibanco')">
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mbway_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="mbway_modal_Label" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mbway_modal_Label">MBWAY</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="/theme/assets/img/payment/mbway-logo.png" alt="MBWay" class="img-fluid">
                <div class="form-group">
                    <label>Número de telemóvel</label>
                    <input type="text" class="form-control" id="celphone">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" onclick="askMbwayPayment()">Pedir pagamento</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mb_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="mb_modal_Label" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mb_modal_Label">MULTIBANCO</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="/theme/assets/img/payment/mb-logo.png" alt="MBWay" class="img-fluid">
                </div>
                <table class="table table-striped">
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" onclick="sendMbPayment()">Enviar por email</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="simple_mbway_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="mb_modal_Label" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mb_modal_Label">MBWAY</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="/theme/assets/img/payment/mbway-logo.png" alt="MBWay" class="img-fluid">
                </div>
                <p>Pode pagar o valor de <strong><span></span> €</strong> para o número:</p>
                <h3></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" onclick="simpleMbwayPayed()">Já paguei</button>
            </div>
        </div>
    </div>
</div>
@if (array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay'] &&
array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay']['mb_key'])
<input type="hidden" id="mbway_key"
    value="{{ array_values(session()->get('cart'))[0]['product']['shop_product_categories'][0]['company']['ifThenPay']['mbway_key'] }}">
@endif
<input type="hidden" id="RequestId">
@endsection
@section('styles')
<style>
    #privacy {
        background: url("/theme/assets/img/hero-bg.jpg") bottom center;
        background-size: cover;
        margin-top: 70px;
    }

    #privacy::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }
</style>
@endsection
@section('scripts')
@parent
<script>
    $(() => {
        getCheckout();
        $('#create_address_modal form').ajaxForm({
            beforeSubmit: () => {
                $.LoadingOverlay('show');
            },
            success: (resp) => {
                $.LoadingOverlay('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Pode continuar',
                }).then(() => {
                    $('#create_address_modal').modal('hide');
                    setTimeout(() => {
                        location.reload(); 
                    }, 500);
                });
            },
            error: (error) => {
                $.LoadingOverlay('hide');
                let html = '';
                $.each(JSON.parse(error.responseText).errors, (i, v) => {
                    $.each(v, (index, value) => {
                    html += value + '<br />';
                    });
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Erro de validação',
                    html: html,
                });
            }
        });
        $('#edit_address_modal form').ajaxForm({
            beforeSubmit: () => {
                $.LoadingOverlay('show');
            },
            success: (resp) => {
                $.LoadingOverlay('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Pode continuar',
                }).then(() => {
                    $('#edit_address_modal').modal('hide');
                    setTimeout(() => {
                        location.reload(); 
                    }, 500);
                });
            },
            error: (error) => {
                $.LoadingOverlay('hide');
                let html = '';
                $.each(JSON.parse(error.responseText).errors, (i, v) => {
                    $.each(v, (index, value) => {
                    html += value + '<br />';
                    });
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Erro de validação',
                    html: html,
                });
            }
        });
        $('#edit_billing_address_modal form').ajaxForm({
            beforeSubmit: () => {
                $.LoadingOverlay('show');
            },
            success: (resp) => {
                $.LoadingOverlay('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Pode continuar',
                }).then(() => {
                    $('#edit_address_modal').modal('hide');
                    setTimeout(() => {
                        location.reload(); 
                    }, 500);
                });
            },
            error: (error) => {
                $.LoadingOverlay('hide');
                let html = '';
                $.each(JSON.parse(error.responseText).errors, (i, v) => {
                    $.each(v, (index, value) => {
                    html += value + '<br />';
                    });
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Erro de validação',
                    html: html,
                });
            }
        });
    });
    getCheckout = () => {
        $.get('/lojas/inner-checkout').then((resp) => {
            $('#inner_checkout').html(resp);
            checkSame();
        });
    }
    updateQty = (product_id, value) => {
        $.get('/cart/change-qty/' + product_id + '/' + value).then((resp) => {
            getCheckout();
        });
    }
    deleteProduct = (product_id) => {
        $.get('/cart/delete-product/' + product_id).then((resp) => {
            getCheckout();
            showCart();
        });
    }
    checkSame = () => {
        if($('#billing_same').prop('checked') == true) {
            $('#billing_collapse').collapse('show');
        } else {
            $('#billing_collapse').collapse('hide');
        }
    }
    changeSame = (address_id) => {
        console.log(address_id);
        $.get('/cart/change-same/' + address_id).then(() => {
            getCheckout();
        });
    }
    createAddress = () => {
        $('#create_address_modal').modal('show');
    }
    editAddress = () => {
        $('#edit_address_modal').modal('show');
    }
    editBillingAddress = () => {
        $('#edit_billing_address_modal').modal('show');
    }
    paymentMethods = () => {
        $('#payment_methods').modal('show');
    }
    sendMbPayment = () => {
        $.LoadingOverlay('show');
        let reference = $('#mb_modal table').html();
        let requestId = $('#RequestId').val();
        let data = {
            reference: reference,
            requestId: requestId
        };
        $.ajax({
            url: '/cart/send-mb-payment',
            type: 'POST',
            data: data,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(resp) {
                $.LoadingOverlay('hide');
                Swal.fire('Enviado com sucesso', 'Pode consultar o seu email', 'success').then(() => {
                    deleteCart();
                    setTimeout(() => {
                        window.location.href="/";
                    }, 500);
                });
                console.log(resp);
            },
            error: function(error) {
                $.LoadingOverlay('hide');
                console.log(error);
            }
        });
    }
    simpleMbwayPayed = () => {
        deleteCart();
        setTimeout(() => {
            window.location.href="/";
        }, 500);
    }
    
</script>
@endsection