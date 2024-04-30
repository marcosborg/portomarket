@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.shopProductSubCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.shop-product-sub-categories.update", [$shopProductSubCategory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="shop_product_category_id">{{ trans('cruds.shopProductSubCategory.fields.shop_product_category') }}</label>
                <select class="form-control select2 {{ $errors->has('shop_product_category') ? 'is-invalid' : '' }}" name="shop_product_category_id" id="shop_product_category_id" required>
                    @foreach($shop_product_categories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('shop_product_category_id') ? old('shop_product_category_id') : $shopProductSubCategory->shop_product_category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('shop_product_category'))
                    <span class="text-danger">{{ $errors->first('shop_product_category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProductSubCategory.fields.shop_product_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.shopProductSubCategory.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $shopProductSubCategory->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProductSubCategory.fields.name_helper') }}</span>
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