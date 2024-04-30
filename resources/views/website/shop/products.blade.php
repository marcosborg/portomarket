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
    <div class="d-grid gap-2" id="filter-button">
        <button type="button" class="btn btn-outline-warning mb-5" data-bs-toggle="modal" data-bs-target="#filter">
            Filtro <i class="bi bi-funnel"></i>
        </button>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-5 col-sm-12" id="left">
            <div class="card mb-5">
                <div class="card-header">
                    Pesquisar nas lojas
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="O que procura?" id="searchField"
                            onkeydown="handleKeyPress(event)">
                        <button class="btn btn-orange" type="button" onclick="searchInShop()"><i
                                class="bi bi-search"></i></button>
                    </div>
                    <div class="list-group">
                        <a href="/lojas/produtos/{{ $company->id }}/todos/{{ Str::slug($company->name, '-') }}"
                            class="list-group-item list-group-item-action {{ $shop_product_category_id == 'todos'  ? 'active' : '' }}">Todos</a>
                        @foreach ($shop_product_categories as $shop_product_category)
                        <a href="/lojas/produtos/{{ $company->id }}/{{ $shop_product_category->id }}/{{ Str::slug($company->name, '-') }}"
                            class="list-group-item list-group-item-action {{ $shop_product_category_id == $shop_product_category->id ? 'active' : '' }}">{{
                            $shop_product_category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <!-- ======= Portfolio Section ======= -->
            <section id="portfolio" class="portfolio">
                <div class="container">
                    @if (count($shop_product_sub_categories) > 0)
                    <div class="card mb-5" id="subcategory">
                        <div class="card-body">
                            <ul id="portfolio-flters">
                                <li data-filter="*" class="filter-active">Todas</li>
                                @foreach ($shop_product_sub_categories as $shop_product_sub_category)
                                <li data-filter=".filter-{{ $shop_product_sub_category->id }}">{{
                                    $shop_product_sub_category->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div class="row portfolio-container">

                        @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 portfolio-item  
                            @foreach($product->shop_product_sub_categories as $value)
                            filter-{{ $value->id }}
                            @endforeach
                            wow fadeInUp">
                            <div class="portfolio-wrap">
                                <a href="/lojas/produto/{{ $product->id }}/{{ Str::slug($product->name, '-') }}">
                                    <div
                                        style="background-size: auto 100%; background-repeat: no-repeat; background-position: center center; background-image: url('{{ $product->photos && count($product->photos) > 0 ? $product->photos[0]->getUrl() : 'https://placehold.co/600x400?text=' . $product->name }}'); height:250px; width:100%;">
                                    </div>
                                    <div class="portfolio-info p-2">
                                        <p>{{ $product->name }}</p>
                                        <p class="p-0 m-0 text-secondary"><span
                                                class="{{ $product->sales_price ? 'text-decoration-line-through' : '' }}">€{{
                                                $product->price }}</span>{!! $product->sales_price ? ' <strong>€' .
                                                $product->price . '</strong>' : '' !!}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        @foreach ($services as $service)
                        <div class="col-lg-4 col-md-6 portfolio-item  
                        @foreach($service->shop_product_sub_categories as $value)
                        filter-{{ $value->id }}
                        @endforeach
                        wow fadeInUp">
                            <div class="portfolio-wrap">
                                <a href="/lojas/servico/{{ $service->id }}/{{ Str::slug($service->name, '-') }}">
                                    <div
                                        style="background-size: auto 100%; background-repeat: no-repeat; background-position: center center; background-image: url('{{ $service->photos && count($service->photos) > 0 ? $service->photos[0]->getUrl() : 'https://placehold.co/600x400?text=' . $service->name }}'); height:250px; width:100%;">
                                    </div>
                                    <div class="portfolio-info p-2">
                                        <p>{{ $service->name }}</p>
                                        <p class="p-0 m-0 text-secondary"><span class="{{ $service->price }}"></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </section><!-- End Portfolio Section -->
        </div>
    </div>
</div>

<div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Filtrar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="list-group">
                            <a href="/lojas/produtos/{{ $company->id }}/todos/{{ Str::slug($company->name, '-') }}"
                                class="list-group-item list-group-item-action {{ $shop_product_category_id == 'todos'  ? 'active' : '' }}">Todos</a>
                            @foreach ($shop_product_categories as $shop_product_category)
                            <a href="/lojas/produtos/{{ $company->id }}/{{ $shop_product_category->id }}/{{ Str::slug($company->name, '-') }}"
                                class="list-group-item list-group-item-action {{ $shop_product_category_id == $shop_product_category->id ? 'active' : '' }}">{{
                                $shop_product_category->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if (count($shop_product_sub_categories) > 0)
                <div class="card mb-5">
                    <div class="card-body">
                        <ul id="portfolio-flters">
                            <li data-filter="*" class="filter-active" onclick="$('#filter').modal('hide')">Todas</li>
                            @foreach ($shop_product_sub_categories as $shop_product_sub_category)
                            <li data-filter=".filter-{{ $shop_product_sub_category->id }}" onclick="$('#filter').modal('hide')">{{
                                $shop_product_sub_category->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
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


<!-- Modal -->
<div class="modal fade" id="searchResult" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Resultados da pesquisa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    function handleKeyPress(event) {
        if (event.keyCode === 13) { // Verifica se a tecla pressionada é a tecla Enter
            searchInShop();
            event.preventDefault(); // Impede o comportamento padrão de submissão do formulário
        }
    }
    searchInShop = () => {
        $.LoadingOverlay('show');
        let search = $('#searchField').val();
        let data = {
            search: search,
        }
        $.get('/lojas/searchInShop/' + search).then((resp) => {
            $.LoadingOverlay('hide');
            $('#searchResult').modal('show');
            $('#searchResult .modal-body').html(resp);
            $('#searchField').val('');
        });
    }
    function detectScreenSize() {
                if (window.innerWidth <= 767) {
                    $('#left').addClass('order-2');
                    $('#subcategory').addClass('d-none');
                    $('#filter-button').removeClass('d-none');
                } else {
                    $('#left').removeClass('order-2');
                    $('#subcategory').removeClass('d-none');
                    $('#filter-button').addClass('d-none');
                }
            }
        
            // Chama a função inicialmente para verificar o tamanho da tela no carregamento da página
            detectScreenSize();
        
            // Adiciona um ouvinte de evento de redimensionamento da janela
            window.addEventListener('resize', detectScreenSize);
</script>
@endsection
<script>
    console.log({!! $services !!})
</script>