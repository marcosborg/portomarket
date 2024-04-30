@extends('layouts.admin')
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
@section('content')
<h3 class="page-title">{{ trans('global.systemCalendar') }}</h3>
<div class="card">
    <div class="card-header">
        {{ trans('global.systemCalendar') }}
    </div>

    <div class="card-body">
        <div id='calendar'></div>
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
                    <div class="form-group">
                        <label>Funcionário</label>
                        <select name="service_employee_id" class="form-control" required>
                            @foreach ($service_employees as $service_employee)
                            <option value="{{ $service_employee->id }}">{{ $service_employee->name }}</option>
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
    $(() => {
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
    });
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
@stop