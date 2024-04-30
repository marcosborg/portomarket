@extends('website.layouts.website')
@section('header')
<section id="privacy" style="position: relative; z-index: 1;">
    <div class="container d-xl-flex justify-content-xl-center align-items-xl-center" style="height: 100px;">
        <h1 class="display-3" style="color: #ffffff;">{{ $category->name }}</h1>
    </div>
</section>
@endsection
@section('content')
<div class="container pt-5">
    <div class="row flex-row">
        <div class="col-lg-4 col-md-5 col-sm-12" id="left">
            <x-search :shop_categories="$shop_categories" :category="$category" />
        </div>
        <div class="col">
            <div class="row">
                @foreach ($companies as $company)
                <div class="col">
                    <a href="/lojas/loja/{{ $company->id }}/{{ Str::slug($company->name, '-') }}">
                        <div class="card mb-4">
                            <img class="card-img-top"
                                style="height: 15vh; background-image: url('{{ $company->logo ? $company->logo->getUrl() : 'https://placehold.co/600x400?text=' . $company->name }}'); background-repeat: no-repeat; background-size: contain; background-position: center center;">
                            <div class="card-body">
                                <p class="card-title text-uppercase">{{ $company->name }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="row">
                @foreach ($products as $product)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <a href="/lojas/produto/{{ $product->id }}/{{ Str::slug($product->name, '-') }}">
                        <div class="card mb-4">
                            <img class="card-img-top"
                                style="height: 25vh; background-image: url('{{ count($product->photos) > 0 ? $product->photos[0]->getUrl() : 'https://placehold.co/600x400?text=' . $product->name }}'); background-repeat: no-repeat; background-size: contain; background-position: center center;">
                            <div class="card-body">
                                <p class="card-title text-uppercase">{{ $product->name }}</p>
                                <p class="p-0 m-0 text-secondary"><span
                                        class="{{ $product->sales_price ? 'text-decoration-line-through' : '' }}">€{{
                                        $product->price }}</span>{!! $product->sales_price ? ' <strong>€' .
                                        $product->price . '</strong>' : '' !!}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
@section('styles')
<style>
    #privacy {
        background: url("{{ $category->image->getUrl() }}") bottom center;
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
<script>
    console.log({!! $products !!})
</script>