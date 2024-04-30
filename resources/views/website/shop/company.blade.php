@extends('website.layouts.website')
@section('header')
<section id="privacy" style="position: relative; z-index: 1;">
    <div class="container d-xl-flex justify-content-xl-center align-items-xl-center" style="height: 100px;">
        <h1 class="display-3" style="color: #ffffff;">{{ $company->name }}</h1>
    </div>
</section>
@endsection
@section('content')
<div class="container pt-5">
    <div class="row">
        <div class="col-lg-4 col-md-5 col-sm-12" id="left">
            <x-search :shop_categories="$shop_categories" />
        </div>
        <div class="col-lg-8 col-md-7 col-sm-12">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-3">
                        <img src="{{ $company->logo->getUrl() }}" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-9 p-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $company->name }}</h5>
                            <p class="card-text">
                                <i class="bi bi-geo-alt-fill"></i>
                                @if ($company->shop_company)
                                {{ $company->shop_company->address }}
                                @else
                                {{ $company->address }}, {{ $company->zip }}, {{ $company->location }}
                                @endif
                                <br>
                                <i class="bi bi-envelope"></i> {{ $company->email }}
                                {!! $company->shop_company ? $company->shop_company->contacts : '' !!}
                            </p>
                            <a class="btn btn-orange"
                                href="/lojas/produtos/{{ $company->id }}/todos/{{ Str::slug($company->name, '-') }}">Produtos</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div id="product-photos" class="carousel slide mb-5">
                        <div class="carousel-inner">
                            @foreach ($company->shop_company->photos as $key => $photo)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ $photo->getUrl() }}" class="d-block w-100" alt="...">
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#product-photos"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#product-photos"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    {!! $company->shop_company->about !!}
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $company->shop_company->latitude }},{{ $company->shop_company->longitude }}&zoom=17&size=800x400&markers=color:red%7C{{ $company->shop_company->latitude }},{{ $company->shop_company->longitude }}&key=AIzaSyAAYYxvit-qTdOhu1Gr78b4GMHUirs_N_c"
                        class="img-fluid" style="width: 100%">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('styles')
<style>
    #privacy {
        background: url("{{ $company->shop_company && count($company->shop_company->photos) > 0 ? $company->shop_company->photos[0]->getUrl() : '/theme/assets/img/hero-bg.jpg' }}") bottom center;
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

    img {
        max-width: 100%;
    }
</style>
@endsection