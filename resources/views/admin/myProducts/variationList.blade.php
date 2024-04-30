@foreach ($shopProductVariations as $shopProductVariation)
<li class="list-group-item shop_product_variation_list" data-shop-product-variation="{{ $shopProductVariation->id }}">
    <div class="row">
        <div class="col-md-4">
            <div>
                <img src="/theme/assets/img/arrows.svg" style="width: 10px; margin-right: 20px;">{{
                $shopProductVariation->name }}
            </div>
        </div>
        <input type="hidden" name="shop_product_variation_id" value="{{ $shopProductVariation->id }}">
        <div class="col-md-2">
            <input type="text" name="price" class="form-control" value="{{ $shopProductVariation->price }}" placeholder="Preço">
        </div>
        <div class="col-md-2">
            <input type="text" name="stock" class="form-control" value="{{ $shopProductVariation->stock }}" placeholder="Stock">
        </div>
        <div class="col-md-2">
            <input type="number" name="weight" class="form-control" value="{{ $shopProductVariation->weight }}" placeholder="Peso (kg)">
        </div>
        <div class="col-md-2 text-right">
            <button onclick="deleteShopProductVariation({{ $shopProductVariation->id }})" type="button"
                class="btn btn-sm bg-transparent">
                <span class="text-muted"><i class="fas fa-trash"></i></span>
            </button>
        </div>
    </div>
</li>
@endforeach