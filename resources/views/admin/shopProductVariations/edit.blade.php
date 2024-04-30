@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.shopProductVariation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.shop-product-variations.update", [$shopProductVariation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="shop_product_id">{{ trans('cruds.shopProductVariation.fields.shop_product') }}</label>
                <select class="form-control select2 {{ $errors->has('shop_product') ? 'is-invalid' : '' }}" name="shop_product_id" id="shop_product_id" required>
                    @foreach($shop_products as $id => $entry)
                        <option value="{{ $id }}" {{ (old('shop_product_id') ? old('shop_product_id') : $shopProductVariation->shop_product->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('shop_product'))
                    <span class="text-danger">{{ $errors->first('shop_product') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProductVariation.fields.shop_product_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.shopProductVariation.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $shopProductVariation->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProductVariation.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price">{{ trans('cruds.shopProductVariation.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $shopProductVariation->price) }}" step="0.01">
                @if($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProductVariation.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="stock">{{ trans('cruds.shopProductVariation.fields.stock') }}</label>
                <input class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" type="number" name="stock" id="stock" value="{{ old('stock', $shopProductVariation->stock) }}" step="1">
                @if($errors->has('stock'))
                    <span class="text-danger">{{ $errors->first('stock') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProductVariation.fields.stock_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="weight">{{ trans('cruds.shopProductVariation.fields.weight') }}</label>
                <input class="form-control {{ $errors->has('weight') ? 'is-invalid' : '' }}" type="number" name="weight" id="weight" value="{{ old('weight', $shopProductVariation->weight) }}" step="1">
                @if($errors->has('weight'))
                    <span class="text-danger">{{ $errors->first('weight') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProductVariation.fields.weight_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection