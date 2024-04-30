@extends('website.layouts.website')
@section('header')
<section id="register" style="position: relative; z-index: 1;">
    <div class="container d-xl-flex justify-content-xl-center align-items-xl-center" style="height: 100px;">
        <h1 class="display-3" style="color: #ffffff;">Registo</h1>
    </div>
</section>
@endsection
@section('content')
<!-- ======= Pricing Section ======= -->
<section id="pricing" class="pricing">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>Planos</h2>
            <p>Apresentamos dois planos para atender às necessidades específicas de cada tipo de comércio. Seja para
                vender produtos e serviços ou simplesmente exibi-los em um catálogo interativo, temos a solução ideal
                para sí.</p>
        </div>

        <div class="row justify-content-center">
            @foreach ($plans as $key => $plan)
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $key }}00">
                <div class="box">
                    <h3>{{ $plan->name }}</h3>
                    <h4><sup>€</sup>{{ $plan->price }}<span class="vat">+ IVA</span><span>por mês</span></h4>
                    <ul>
                        @foreach($plan->items as $item)
                        <li class="{{ $item->type == 0 ? 'na' : '' }}"><i class="bx bx-{{ $item->type == 0 ? 'x' : 'check' }}"></i> {!! $item->type == 0 ? '<span>' : '' !!}{{ $item->text }}{!! $item->type == 0 ? '</span>' : '' !!}</span></li>
                        @endforeach
                    </ul>
                    <a href="/registo/{{ $plan->id }}" class="buy-btn">Selecionar plano</a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section><!-- End Pricing Section -->
@endsection
@section('styles')
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