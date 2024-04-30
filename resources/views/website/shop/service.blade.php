@extends('website.layouts.website')
@section('description')
{{ $service->shop_product_categories[0]->company->name }} | {{ $service->name }}
@endsection
@section('header')
<section id="privacy" style="position: relative; z-index: 1;">
    <div class="container d-xl-flex justify-content-xl-center align-items-xl-center" style="height: 100px;">
        <h1 class="display-3" style="color: #ffffff;">{{ $service->name }}</h1>
    </div>
</section>
@endsection
@section('content')
<div class="container p-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Slider main container -->
            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2"
                zoom="true">
                <div class="swiper-wrapper">
                    @foreach ($service->photos as $photo)
                    <div class="swiper-slide">
                        <div class="swiper-zoom-container">
                            <img src="{{ $photo->original_url }}" />
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div thumbsSlider="" class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($service->photos as $photo)
                    <div class="swiper-slide">
                        <img src="{{ $photo->original_url }}" />
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h2>{{ $service->name }}</h2>
            <small><strong>Referencia: </strong>{{ $service->reference }}</small><br>
            <strong>{{ $service->shop_product_categories[0]->company->name }}</strong><br>
            <i class="bi bi-stopwatch-fill"></i> {{ $service->service_duration->name }}
            <h1 class="mt-4">€ <span id="price">{{ $service->price }}</span></h1>
            @auth
            <button type="button" class="btn btn-orange btn-lg mt-4" data-bs-toggle="modal"
                data-bs-target="#calendar_modal">Agendar</button>
            @else
            <button type="button" class="btn btn-orange btn-lg mt-4" data-bs-toggle="modal"
                data-bs-target="#login_modal">Login para agendar</button>
            @endauth

            <div class="mt-4">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a class="btn btn-primary"
                        href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;title={{ $service->name }}"
                        target="_blank">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a class="btn btn-success"
                        href="https://api.whatsapp.com/send?text={{ $service->name }}:%20{{ url()->current() }}"
                        target="_blank">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
                @if ($service->shop_product_categories &&
                $service->shop_product_categories[0]->company->shop_company->whatsapp)
                <button class="btn btn-success btn-sm d-block mt-4" type="button" data-bs-toggle="collapse"
                    data-bs-target="#whatsapp_box" aria-expanded="false">
                    Contactar por Whatsapp
                </button>
                <div class="collapse" id="whatsapp_box">
                    <div class="form-group mt-4">
                        <textarea name="whatsapp" id="whatsapp" rows="5" class="form-control"
                            placeholder="Escreva a sua mensagem aqui."></textarea>
                    </div>
                    <button type="button" class="btn btn-success btn-sm mt-4"
                        onclick="sendWhatsappMsg(910898931)">Enviar
                        mensagem</button>
                </div>
                @endif
                <div class="card mt-5">
                    <div class="card-header text-center">
                        Descrição
                    </div>
                    <div class="card-body">
                        {!! $service->description !!}
                    </div>
                </div>
            </div>
            <a href="/lojas/produtos/{{ $service->shop_product_categories[0]->company_id }}/todos/{{ Str::slug($service->shop_product_categories[0]->company->name, '-') }}"
                class="btn btn-orange mt-5 mb-5">Outros produtos da loja</a>
        </div>
    </div>
</div>
<input type="hidden" id="service_id" value="{{ $service->id }}">
<!-- Modal -->
<div class="modal fade" id="calendar_modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agendar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="employees_modal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agendar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Selecionar profissional</label>
                    <select name="employee_id" id="employee_id" class="form-control">
                        <option selected disabled>Selecionar</option>
                        @foreach ($service->service_employees as $service_employee)
                        <option value="{{ $service_employee->id }}">{{ $service_employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Hora preferencial de atendimento</label>
                    <input type="time" class="form-control" name="time" id="time" step="1800">
                </div>
                <div class="alert alert-info mt-2">
                    Sujeito a confirmação
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="schedule_service">Pedir agendamento</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
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

    .swiper {
        width: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        object-fit: contain;
    }

    .swiper {
        width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    .swiper-slide {
        background-size: contain;
        background-position: center;
    }

    .mySwiper2 {
        width: 100%;
    }

    .mySwiper {
        box-sizing: border-box;
        padding: 10px 0;
    }

    .mySwiper .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
    }

    .mySwiper .swiper-slide-thumb-active {
        opacity: 1;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: var(--bs-nav-pills-link-active-color);
        background-color: #e2742b;
    }

    .nav-fill .nav-item .nav-link,
    .nav-justified .nav-item .nav-link {
        width: 100%;
        padding: 0px;
    }

    .fc-scroller.fc-day-grid-container {
        height: 100% !important;
    }

    .fc-day,
    .fc-day-top {
        cursor: pointer;
    }

    .fc-day:hover,
    .fc-day-top:hover {
        background: #ccc;
        cursor: pointer;
    }

    .disabled {
        pointer-events: none;
        cursor: default;
        background: #eeeeee;
    }
</style>
@endsection
@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/locale/pt.js"></script>
<script>
    console.log({!! $service !!})
    var swiper = new Swiper(".mySwiper", {
      loop: true,
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
      zoom: true,
      loop: true,
      spaceBetween: 10,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      thumbs: {
        swiper: swiper,
      },
    });
    const calendar = document.getElementById('calendar_modal');
    calendar.addEventListener('shown.bs.modal', event => {
        var today = moment();
        $('#calendar').fullCalendar({
            dayRender: function(date, cell) {
                if(date < today){
                    cell.addClass('disabled');
                }
            },
            dayClick: function(date) {
                if(date >= today){
                    const day = date.format();
                    $('#calendar_modal').modal('hide');
                    $('#employees_modal').modal('show');
                    $('#schedule_service').on('click', function() {
                        const employee_id = $('#employee_id').val();
                        const time = $('#time').val();
                        const service_id = $('#service_id').val();
                        if(time && employee_id){
                            $.LoadingOverlay('show');
                            $.get('/cart/shop_schedules/' + day + '/' + time + '/' + employee_id + '/' + service_id).done((resp) => {
                                $('#employees_modal').modal('hide');
                                swal.fire('Pedido enviado com sucesso.', 'Aguarde confirmação.', 'success');
                                $.LoadingOverlay('hide');
                            });
                        } else {
                            swal.fire('Validação!', 'Os capos são obrigatórios', 'error');
                        }
                    });
                }
            }
        });
    });
</script>
@endsection