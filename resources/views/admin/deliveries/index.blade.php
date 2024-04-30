@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.delivery.title') }}
    </div>

    <div class="card-body">
        <div class="alert alert-info">
            Recolha na loja está sempre disponível de forma gratuita para o cliente.
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Dados gerais
                    </div>
                    <form action="/admin/deliveries/updateShopProduct" method="post">
                        @csrf
                        <input type="hidden" name="shop_company_id" value="{{ $user->company[0]->shop_company->id }}">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nome da transportadora utilizada</label>
                                <input type="text" name="delivery_company" class="form-control" value="{{ $user->company[0]->shop_company->delivery_company }}">
                            </div>
                            <div class="form-group">
                                <label>Valor mínimo a cobrar</label>
                                <input type="text" name="minimum_delivery_value" class="form-control" value="{{ $user->company[0]->shop_company->minimum_delivery_value }}">
                            </div>
                            <div class="form-group">
                                <label>Transporte gratuito em compras superiores a</label>
                                <input type="text" name="delivery_free_after" class="form-control" value="{{ $user->company[0]->shop_company->delivery_free_after }}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Intervalos de peso
                    </div>
                    <div class="card-body">
                        @foreach ($user->company[0]->shop_company->delivery_ranges as $delivery_range)
                        <form action="/admin/deliveries/update_delivery_range" method="post">
                            @csrf
                            <input type="hidden" name="delivery_range_id" value="{{ $delivery_range->id }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" value="{{ $delivery_range->from }}" name="from"
                                        class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" value="{{ $delivery_range->to }}" name="to" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" value="{{ $delivery_range->value }}" name="value"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-primary">Atualizar</button>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="button" onclick="deleteDeliveryRange({{ $delivery_range->id }})"
                                            class="form-control btn btn-danger"><i
                                                class="fa-fw nav-icon fas fa-trash-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endforeach
                        <form action="/admin/deliveries/new_delivery_range" method="post">
                            @csrf
                            <input type="hidden" name="shop_company_id"
                                value="{{ $user->company[0]->shop_company->id }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>De (kg)</label>
                                        <input type="number" name="from" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Até (kg)</label>
                                        <input type="number" name="to" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Valor</label>
                                        <input type="text" name="value" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <input type="submit" value="Inserir" class="form-control btn btn-success">
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@parent
<script>
    deleteDeliveryRange = function (delivery_range_id) {
        Swal.fire({
            title: 'Tem a certeza?',
            text: "Esta ação é irreversível!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, apague!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href="/admin/deliveries/delete_delivery_range/" + delivery_range_id;
            }
         })
    }
</script>
@endsection