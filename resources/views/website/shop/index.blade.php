@extends('website.layouts.website')
@section('header')
<section id="privacy" style="position: relative; z-index: 1;">
    <div class="container d-xl-flex justify-content-xl-center align-items-xl-center" style="height: 100px;">
        <h1 class="display-3" style="color: #ffffff;">Lojas</h1>
    </div>
</section>
@endsection
@section('content')
<div class="container pt-5">
    <div class="row">
        <div class="col-lg-4 col-md-5 col-sm-12">
            <x-search :shop_categories="$shop_categories" />
        </div>
        <div class="col">
            <div id="categories_slider" class="carousel slide mb-5">
                <div class="carousel-inner">
                    @foreach ($shop_categories_slide as $key => $shop_categories)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($shop_categories as $category)
                            <div class="col">
                                <a href="/lojas/categoria/{{ $category->id }}/{{ Str::slug($category->name, '-') }}">
                                    <div class="card">
                                        <img class="card-img-top"
                                            style="height: 15vh; background-image: url('{{ $category->image->getUrl() }}'); background-size: cover; background-position: center center;">
                                        <div class="card-body">
                                            <p class="card-title text-uppercase">{{ $category->name }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#categories_slider"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#categories_slider"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div id="products_slider" class="carousel slide mb-5">
                <div class="carousel-inner">
                    @foreach ($shop_products as $key => $products)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($products as $product)
                            <div class="col">
                                <a href="/lojas/produto/{{ $product->id }}/{{ Str::slug($product->name, '-') }}">
                                    <div class="card">
                                        <img class="card-img-top"
                                            style="height: 25vh; background-image: url('{{ count($product->photos) > 0 ? $product->photos[0]->getUrl() : 'https://placehold.co/600x400?text=' . $product->name }}'); background-size: contain; background-repeat: no-repeat; background-position: center center;">
                                        <div class="card-body">
                                            <p class="card-title text-uppercase">{{ $product->name }}</p>
                                            <p class="p-0 m-0 text-secondary"><span
                                                    class="{{ $product->sales_price ? 'text-decoration-line-through' : '' }}">€{{
                                                    $product->price }}</span>{!! $product->sales_price ? '  <strong>€' . $product->price . '</strong>' : '' !!}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#products_slider"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#products_slider"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div id="companies_slider" class="carousel slide mb-5">
                <div class="carousel-inner">
                    @foreach ($companies as $key => $companies_row)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($companies_row as $company)
                            <div class="col">
                                <a href="/lojas/loja/{{ $company->id }}/{{ Str::slug($company->name, '-') }}">
                                    <div class="card">
                                        <img class="card-img-top"
                                            style="height: 15vh; background-image: url('{{ $company->logo ? $company->logo->getUrl() : 'https://placehold.co/600x400?text=' . $company->name }}'); background-size: cover; background-position: center center;">
                                        <div class="card-body">
                                            <p class="card-title text-uppercase">{{ $company->name }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#companies_slider"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#companies_slider"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>

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