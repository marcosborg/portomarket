@extends('website.layouts.website')
@section('header')
<section id="register" style="position: relative; z-index: 1;">
    <div class="container d-xl-flex justify-content-xl-center align-items-xl-center" style="height: 100px;">
        <h1 class="display-3" style="color: #ffffff;">Registo</h1>
    </div>
</section>
@endsection
@section('content')
<section id="pricing" class="pricing">
    <div class="container" data-aos="fade-up">

        <div class="row">
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="box">
                    <h3>{{ $plan->name }}</h3>
                    <h4><sup>€</sup>{{ $plan->price }}<span class="vat">+ IVA</span><span>por mês</span></h4>
                    <ul>
                        @foreach($plan->items as $item)
                        <li class="{{ $item->type == 0 ? 'na' : '' }}"><i class="bx bx-{{ $item->type == 0 ? 'x' : 'check' }}"></i> {!! $item->type == 0 ?
                            '<span>' : '' !!}{{ $item->text }}{!! $item->type == 0 ? '</span>' : '' !!}</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-8 mb-4">
                <div class="box">
                    <h3>Registo de empresa</h3>
                    <form action="/forms/formRegister" method="post">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Nome">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmação da password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="company" class="form-control" placeholder="Empresa">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="vat" class="form-control" placeholder="Contribuinte">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="address" class="form-control" placeholder="Endereço">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="zip" class="form-control" placeholder="Código postal">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="location" class="form-control" placeholder="Localidade">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="country" class="form-control" placeholder="País" value="Portugal" disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h3>Tipo de subscrição</h3>
                        @foreach ($plan->subscriptionTypes as $key => $subscriptionType)
                        <div class="form-check">
                            <input value="{{ $subscriptionType->id }}" class="form-check-input" {{ $key == 0 ? 'checked' : '' }} type="radio" name="subscription_type_id" id="radio-{{ $key }}">
                            <label class="form-check-label" for="radio-{{ $key }}">
                                Subscrever {{ $subscriptionType->months }} meses com {{ $subscriptionType->discount }}% de desconto
                            </label>
                        </div>
                        @endforeach
                        <div class="form-group mt-5">
                            <div class="needsclick dropzone" id="logo-dropzone"></div>
                        </div>
                        <button type="submit" class="buy-btn mt-5">Avançar</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section><!-- End Pricing Section -->
@endsection
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
<style>
    #register {
        background: url("/theme/assets/img/hero-bg.jpg") bottom center;
        background-size: cover;
        margin-top: 70px;
    }

    #register::before {
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script>
    Dropzone.options.logoDropzone = {
        url: '{{ route('forms.companies.storeMedia') }}',
        maxFilesize: 2, // MB
        acceptedFiles: '.jpeg,.jpg,.png',
        maxFiles: 1,
        addRemoveLinks: true,
        dictDefaultMessage: 'Pode arrastar para aqui o seu logotipo.</br>Pode colocar ficheiros em formato JPEG ou PNG.</br>O ficheiro não deve ser maior do que 2MB',
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 2,
            width: 4096,
            height: 4096
        },
        success: function(file, response) {
            $('form').find('input[name="logo"]').remove()
            $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
        },
        removedfile: function(file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="logo"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function() {
            @if(isset($company) && $company->logo)
            var file = {
                !!json_encode($company->logo) !!
            }
            this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function(file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>
<script>
    
    $(() => {
        $('form').ajaxForm({
            beforeSubmit: () => {
                $.LoadingOverlay('show');
            },
            success: (resp) => {
                $.LoadingOverlay('hide');
                Swal.fire(
                    'A conta foi criada!',
                    'Será redirecionado para o dashboard onde poderá terminar o processo de registo procedendo ao pagamento do plano selecionado.',
                    'success'
                ).then(() => {
                    window.location.href = '/admin';
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
    
</script>
@endsection