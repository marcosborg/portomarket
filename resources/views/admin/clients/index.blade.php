@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.client.title') }}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Clientes
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover datatable">
                            <thead>
                                <tr>
                                    <th class="hide"></th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Contacto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                <tr>
                                    <td class="hide"></td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->address ? $client->address->phone : '' }}</td>
                                    <td><button class="btn btn-info btn-sm"
                                            onclick="details({{ $client->id }})">Detalhes</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Pesquisar cliente
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Cliente</label>
                            <div class="input-group mb-3" id="input_search_group">
                                <input type="text" class="form-control" placeholder="Pesquisar por email ou telefone"
                                    id="search">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="button" onclick="searchUsers()"><i
                                            class="fas fa-fw fa-search">
                                        </i></button>
                                </div>
                                <ul class="list-group position-absolute" id="client_list"
                                    style="top: 40px; width: 100%;"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        Criar cliente
                    </div>
                    <form action="/admin/clients/new-client" method="post" id="new_client">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nome *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Endereço *</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Localidade *</label>
                                        <input type="text" name="city" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Código postal *</label>
                                        <input type="text" name="zip" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>País *</label>
                                        <select name="country_id" class="form-control select2" required>
                                            <option selected disabled>Selecionar</option>
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Contacto *</label>
                                        <input type="text" name="phone" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted">* Campo obrigatório.</p>
                            <button type="submit" class="btn btn-success">Gravar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="details" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" disabled name="name" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" disabled name="email" class="form-control form-control-sm">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Contacto</label>
                            <input type="text" disabled name="phone" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>País</label>
                            <input type="text" disabled name="country" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Endereço</label>
                    <input type="text" disabled name="address" class="form-control form-control-sm">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Localidade</label>
                            <input type="text" disabled name="city" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Código postal</label>
                            <input type="text" disabled name="zip" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://malsup.github.io/jquery.form.js"></script>
<script>
    $(() => {
        $('.datatable').DataTable();
        $('#new_client').ajaxForm({
            beforeSubmit: () => {
                $.LoadingOverlay('show');
            },
            success: (resp) => {
                $.LoadingOverlay('hide');
                Swal.fire(
                    'Sucesso!',
                    'O cliente foi criado!',
                    'success'
                ).then(() => {
                    $('input').each(function() {
                        $(this).val('');
                    });
                });
            },
            error: (err) => {
                $.LoadingOverlay('hide');
                let html = '';
                $.each(err.responseJSON.errors, (i, v) => {
                    $.each(v, (index, value) => {
                        html += value + '<br>';
                    });
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Aviso!',
                    html: html,
                });
            }
        })
    });
    searchUsers = () => {
        let search = $('#search').val();
        if(search.length > 6) {
            let data = {
            search: search,
        }
        $.post({
            url: '/admin/my-employees/search-users',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (resp) => {
                let html = '';
                if(resp.length > 0) {
                        $.each(resp, (i, v) => {
                        html += '<li class="list-group-item list-group-item-primary">' + v.name + '</li>';
                    });
                } else {
                    html += '<li class="list-group-item list-group-item-warning">Sem resultados.';
                }
                $('#client_list').html(html);
                setTimeout(() => {
                    $('#client_list').html('');
                    $('#search').val('')
                }, 3000);
            },
            error: (err) => {
                console.log(err);
            }
        });
    }};
    details = (client_id) => {
        $.LoadingOverlay('show');
        $.get('/admin/clients/details/' + client_id).then((resp) => {
            console.log(resp);
            $('#details input[name=name]').val(resp.name);
            $('#details input[name=email]').val(resp.email);
            if(resp.address){
                $('#details input[name=phone]').val(resp.address.phone);
                $('#details input[name=country]').val(resp.address.country.name);
                $('#details input[name=address]').val(resp.address.address);
                $('#details input[name=city]').val(resp.address.city);
                $('#details input[name=zip]').val(resp.address.zip);
            }
            $.LoadingOverlay('hide');
            $('#details').modal('show');
        });
    }
</script>
@endsection