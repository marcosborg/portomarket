@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.shopProductFeature.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.shop-product-features.update", [$shopProductFeature->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="shop_product_id">{{ trans('cruds.shopProductFeature.fields.shop_product') }}</label>
                <select class="form-control select2 {{ $errors->has('shop_product') ? 'is-invalid' : '' }}" name="shop_product_id" id="shop_product_id" required>
                    @foreach($shop_products as $id => $entry)
                        <option value="{{ $id }}" {{ (old('shop_product_id') ? old('shop_product_id') : $shopProductFeature->shop_product->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('shop_product'))
                    <span class="text-danger">{{ $errors->first('shop_product') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProductFeature.fields.shop_product_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.shopProductFeature.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $shopProductFeature->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProductFeature.fields.name_helper') }}</span>
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