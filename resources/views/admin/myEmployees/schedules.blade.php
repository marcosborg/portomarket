@extends('layouts.admin')
@section('content')
@section('styles')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
<style>
    .list-group-item-action {
        cursor: pointer;
    }

    .fc-title {
        color: #fff;
    }

    .fc-event-container a {
        cursor: pointer;
    }
</style>
@endsection
<h3 class="text-center">Agenda de {{ $service_employee->name }}</h3>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab1" data-toggle="tab" data-target="#tab-content-1" type="button"
            role="tab" aria-controls="tab1" aria-selected="true">Calendário</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab2" data-toggle="tab" data-target="#tab-content-2" type="button" role="tab"
            aria-controls="tab2" aria-selected="false">Marcações</button>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="tab-content-1" role="tabpanel" aria-labelledby="tab-content-1">
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Calendário
                    </div>
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Para hoje
                    </div>
                    <div class="card-body">
                        @if ($today_shop_schedules->count() == 0)
                        <div class="alert alert-info" role="alert">Não tem marcações para hoje</div>
                        @endif
                        <ul class="list-group">
                            @foreach ($today_shop_schedules as $today_shop_schedule)
                            <li class="list-group-item list-group-item-action"
                                onclick="editSchedule({{ $today_shop_schedule->id }})">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $today_shop_schedule->client ?
                                        $today_shop_schedule->client->name : '' }}</h5>
                                    <small>{{ \Carbon\Carbon::parse($today_shop_schedule->start_time)->format('H:i') }}
                                        - {{
                                        \Carbon\Carbon::parse($today_shop_schedule->end_time)->format('H:i') }}</small>
                                </div>
                                <p class="mb-1">{{ $today_shop_schedule->service->name }}</p>
                                <p class="text-muted">{{ $today_shop_schedule->notes }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="tab-content-2" role="tabpanel" aria-labelledby="tab-content-2">
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Horários
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover datatable">
                                <thead>
                                    <tr>
                                        <th class="hide">

                                        </th>
                                        <th>
                                            Dia
                                        </th>
                                        <th>
                                            Hora
                                        </th>
                                        <th>
                                            Serviço
                                        </th>
                                        <th>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shop_schedules as $shop_schedule)
                                    <tr>
                                        <td class="hide">

                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($shop_schedule->start_time)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($shop_schedule->start_time)->format('H:i') }} - {{
                                            \Carbon\Carbon::parse($shop_schedule->end_time)->format('H:i') }}
                                        </td>
                                        <td>
                                            {{ $shop_schedule->service->name }}
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-info"
                                                onclick="editSchedule({{ $shop_schedule->id }})">Editar</button>
                                            <a class="btn btn-xs btn-danger"
                                                href="/admin/my-employees/delete-schedule/{{ $shop_schedule->id }}"
                                                onclick="return confirm('{{ trans('global.areYouSure') }}');">
                                                {{ trans('global.delete') }}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Criar marcação
                    </div>
                    <div class="card-body">
                        <form action="{{ route("admin.shop-schedules.store") }}" method="POST">
                            @csrf
                            <input type="hidden" name="mySchedules" value="1">
                            <input type="hidden" name="service_employee_id" value="{{ $service_employee->id }}">
                            <input type="hidden" name="user_id" value="">
                            <div class="form-group">
                                <label>Cliente</label>
                                <div class="input-group mb-3" id="input_search_group">
                                    <input type="text" class="form-control"
                                        placeholder="Pesquisar por email ou telefone" id="search">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="button" onclick="searchUsers()"><i
                                                class="fas fa-fw fa-search">
                                            </i></button>
                                    </div>
                                    <ul class="list-group position-absolute" id="client_list"
                                        style="top: 40px; width: 100%;"></ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Início do serviço</label>
                                <input type="text" class="form-control datetime" name="start_time">
                            </div>
                            <input type="hidden" name="end_time" value="">
                            <div class="form-group">
                                <label>Serviço</label>
                                <select name="service_id" class="form-control">
                                    <option selected disabled>Selecionar</option>
                                    @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }} - {{
                                        $service->service_duration->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Anotações</label>
                                <textarea name="notes" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Criar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editSchedule" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Marcação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/my-employees/update-schedule" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id">
                    <input type="hidden" name="service_employee_id" value="{{ $service_employee->id }}">
                    <div class="form-group">
                        <label>Cliente</label>
                        <input type="text" class="form-control" name="client" disabled>
                    </div>
                    <div class="form-group">
                        <label>Início do serviço</label>
                        <input type="text" class="form-control datetime" name="start_time">
                    </div>
                    <div class="form-group">
                        <label>Fim do serviço</label>
                        <input type="text" class="form-control datetime" name="end_time">
                    </div>
                    <div class="form-group">
                        <label class="required" for="service_id">{{ trans('cruds.shopSchedule.fields.service')
                            }}</label>
                        <select class="form-control" name="service_id" required>
                            @foreach ($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://malsup.github.io/jquery.form.js"></script>
<script>
    $(()=>{
        $('.datatable').DataTable();
        $('#editSchedule form').ajaxForm({
            beforeSubmit: () => {
                $.LoadingOverlay('show');
            },
            success: (resp) => {
                $.LoadingOverlay('hide');
                Swal.fire(
                    'Sucesso!',
                    'A marcação foi atualizada!',
                    'success'
                ).then(() => {
                    location.reload()
                });
            }
        });
        $('#tab2').on('shown.bs.tab', function(e) {
            $('.datatable').DataTable().destroy();
            $('.datatable').DataTable();
        });
    });
    editSchedule = (id) => {
        $.LoadingOverlay('show');
        $.get('/admin/my-employees/get-schedule/' + id).then((resp) => {
            $.LoadingOverlay('hide');
            $('#editSchedule input[name=id]').val(resp.id);
            $('#editSchedule input[name=client]').val(resp.client.name);
            $('#editSchedule input[name=start_time]').val(resp.start_time);
            $('#editSchedule input[name=end_time]').val(resp.end_time);
            $('#editSchedule select[name=service_id]').val(resp.service_id);
            $('#editSchedule').modal('show');
        });
    }
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
                        html += '<li class="list-group-item list-group-item-action list-group-item-primary" onclick="selectClient(' + v.id + ')">' + v.name + '</li>';
                    });
                } else {
                    html += '<li class="list-group-item list-group-item-warning">Sem resultados. <button type="button" class="btn btn-primary btn-sm float-right" onclick="createClient()">Criar cliente</button></li>';
                }
                $('#client_list').html(html);
            },
            error: (err) => {
                console.log(err);
            }
        });
    }};
    selectClient = (user_id) => {
        $.get('/admin/my-employees/get-client/' + user_id).then((resp) => {
            $('#client_list').html('');
            $('#input_search_group').addClass('hide');
            $('#client_selected').html('<li class="list-group-item list-group-item-primary">' + resp.name + '<button type="button" class="btn btn-link btn-sm float-right" onclick="restart()">X</button></li>');
            $('input[name=user_id').val(resp.id);
            $('#search').val('');
        });
    }
    createClient = () => {
        console.log('createClient');
    }
    restart = () => {
        $('#input_search_group').removeClass('hide');
        $('#client_selected').html('');
        $('input[name=user_id').val('');
    }
</script>
<script>
    $(document).ready(function () {
            // page is now ready, initialize the calendar...
            events={!! json_encode($events) !!};
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                events: events,
                eventClick: function(calEvent, jsEvent, view) {
                    editSchedule(calEvent.id);
                },
                timeFormat: 'HH:mm'
            })
        });
</script>
@endsection