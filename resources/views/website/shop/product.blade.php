@extends('website.layouts.website')
@section('facebook_image')
@if (count($product->photos) > 0)
<meta property="og:image" content="{{ $product->photos[0]->original_url }}" />
@endif
@endsection
@section('description')
{{ $product->shop_product_categories->count() > 0 ? $product->shop_product_categories[0]->company->name : '' }} | {{ $product->name }}
@endsection
@section('header')
<section id="privacy" style="position: relative; z-index: 1;">
    <div class="container d-xl-flex justify-content-xl-center align-items-xl-center" style="height: 100px;">
        <h1 class="display-3" style="color: #ffffff;">{{ $product->name }}</h1>
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
                    @foreach ($product->photos as $photo)
                    <div class="swiper-slide">
                        <div class="swiper-zoom-container">
                            <picture>
                                <img src="{{ $photo->original_url }}" />
                            </picture>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div thumbsSlider="" class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($product->photos as $photo)
                    <div class="swiper-slide">
                        <img src="{{ $photo->original_url }}" />
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <form action="/cart/add-to-cart" method="post" id="cart_submit">
                <h2>{{ $product->name }}</h2>
                <small><strong>Referencia: </strong>{{ $product->reference }}</small><br>
                <strong>{{ $product->shop_product_categories->count() > 0 ? $product->shop_product_categories[0]->company->name : '' }}</strong>
                @if (!$product->sales_price)
                <h1 class="mt-4">€ <span id="price">{{ $product->price }}</span></h1>
                @else
                <h1 class="mt-4"><s style="
                    color: #888;
                    font-weight: 200;
                    font-size: 30px;
                    margin-right: 20px;
                ">€ <span id="price">{{ $product->price }}</span></s>€ {{ $product->sales_price }}</h1>
                @endif
                <label class="mt-4 mb-2">Quantidade</label>
                <div class="input-group mb-3 w-50">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="decreaseBtn">-</button>
                    </div>
                    <input type="number" class="form-control text-center" value="1" min="1" max="10" disabled>
                    <input type="hidden" name="qty" value="1">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="increaseBtn">+</button>
                    </div>
                </div>
                <div class="form-group w-50">
                    <label>Selecione a sua escolha</label>
                    <select name="shop_product_variation_id" class="form-control mt-1">
                        @foreach ($product->shop_product_variations as $key => $shop_product_variation)
                        <option {{ $key==0 ? 'selected' : '' }} value="{{ $shop_product_variation->id }}">{{ $shop_product_variation->name }}</option>
                        @endforeach
                    </select>
                </div>
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-orange btn-lg mt-4">Comprar</button>
            </form>
            <div class="mt-4">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a class="btn btn-primary"
                        href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&title={{ $product->name }}{{ count($product->photos) > 0 ? '&picture=' . $product->photos[0]->getUrl() : '' }}"
                        target="_blank">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a class="btn btn-success"
                        href="https://api.whatsapp.com/send?text={{ $product->name }}:%20{{ url()->current() }}"
                        target="_blank">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
                @if ($product->shop_product_categories->count() > 0 &&
                $product->shop_product_categories[0]->company->shop_company->whatsapp)
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
                        onclick="sendWhatsappMsg({{ $product->shop_product_categories->count() > 0 ? $product->shop_product_categories[0]->company->shop_company->whatsapp : '' }})">Enviar
                        mensagem</button>
                </div>
                @endif
            </div>
            <div class="card mt-5">
                <div class="card-header text-center">
                    Descrição
                </div>
                <div class="card-body">
                    {!! $product->description !!}
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header">
                    <ul class="nav nav nav-pills nav-fill" role="tablist">
                        <li class="nav-item" role="presentation">
                            @if (!$product->youtube && !$product->attachment)
                            Características
                            @else
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#features"
                                type="button" role="tab">Características</button>
                            @endif
                        </li>
                        @if ($product->youtube)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#video" type="button"
                                role="tab">Vídeo</button>
                        </li>
                        @endif
                        @if ($product->attachment)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#others" type="button"
                                role="tab">Outros</button>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="features" role="tabpanel">
                            <ul class="list-group">
                                @foreach ($product->shop_product_features as $feature)
                                <li class="list-group-item">{{ $feature->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @if ($product->youtube)
                        <div class="tab-pane fade" id="video" role="tabpanel">
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/{{ $product->youtube }}?controls=0"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>

                        </div>
                        @endif
                        @if ($product->attachment)
                        <div class="tab-pane fade" id="others" role="tabpanel">
                            <a target="_new" href="{{ $product->attachment->getUrl() }}"
                                class="btn btn-primary btn-sm">{{ $product->attachment_name }}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <a href="/lojas/produtos/{{ $product->shop_product_categories->count() > 0 ? $product->shop_product_categories[0]->company_id : '' }}/todos/{{ Str::slug($product->shop_product_categories->count() > 0 ? $product->shop_product_categories[0]->company->name : '', '-') }}"
                class="btn btn-orange mt-5 mb-5">Outros produtos da loja</a>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
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
</style>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    console.log({!! $product !!})
    document.getElementById("decreaseBtn").addEventListener("click", function() {
      var input = document.querySelector(".form-control");
      var value = parseInt(input.value);
      if (value > 1) {
        value = value - 1
        input.value = value;
      }
      $('input[name=qty]').val(value);
    });

    document.getElementById("increaseBtn").addEventListener("click", function() {
      var input = document.querySelector(".form-control");
      var value = parseInt(input.value);
      if (value < 10) {
        value = value + 1;
        input.value = value;
      }
      $('input[name=qty]').val(value);
    });

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
    $(() => {
        $('#cart_submit').ajaxForm({
            beforeSubmit: () => {
                $.LoadingOverlay('show');
            },
            success: (resp) => {
                $.LoadingOverlay('hide');
                if(resp == true){
                    showCart();
                    Swal.fire({
                        title: 'Quer ir para checkout?',
                        showCancelButton: true,
                        cancelButtonText: 'Quero continuar na loja',
                        confirmButtonText: 'Sim!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href="/lojas/checkout";
                        }
                    });
                } else {
                    Swal.fire({
                            title: 'Tem a certeza?',
                            text: "Não é possível adicionar ao carrinho produtos de outra empresa devido ao processo de pagamento final. Se confirmar, o carrinho vai ser reiniciado.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Pode reiniciar o carrinho com este produto!'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            deleteCart();
                            setTimeout(() => {
                                $('#cart_submit').submit();
                            }, 500);
                        }
                    });
                }
            }
        });
    });
    sendWhatsappMsg = (whatsapp) => {
        let message = $('#whatsapp').val();
        let url = "https://api.whatsapp.com/send?phone=+351" + whatsapp + "&text=" + message;
        window.open(url, '_blank', 'width=800,height=600');
    }
</script>
@endsection