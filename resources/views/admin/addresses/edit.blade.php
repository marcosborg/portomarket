@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.address.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.addresses.update", [$address->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.address.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $address->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address">{{ trans('cruds.address.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $address->address) }}" required>
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="city">{{ trans('cruds.address.fields.city') }}</label>
                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $address->city) }}" required>
                @if($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="zip">{{ trans('cruds.address.fields.zip') }}</label>
                <input class="form-control {{ $errors->has('zip') ? 'is-invalid' : '' }}" type="text" name="zip" id="zip" value="{{ old('zip', $address->zip) }}" required>
                @if($errors->has('zip'))
                    <span class="text-danger">{{ $errors->first('zip') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.zip_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="country_id">{{ trans('cruds.address.fields.country') }}</label>
                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id" required>
                    @foreach($countries as $id => $entry)
                        <option value="{{ $id }}" {{ (old('country_id') ? old('country_id') : $address->country->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.address.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $address->phone) }}">
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="vat">{{ trans('cruds.address.fields.vat') }}</label>
                <input class="form-control {{ $errors->has('vat') ? 'is-invalid' : '' }}" type="text" name="vat" id="vat" value="{{ old('vat', $address->vat) }}">
                @if($errors->has('vat'))
                    <span class="text-danger">{{ $errors->first('vat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.vat_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('billing_same') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="billing_same" value="0">
                    <input class="form-check-input" type="checkbox" name="billing_same" id="billing_same" value="1" {{ $address->billing_same || old('billing_same', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="billing_same">{{ trans('cruds.address.fields.billing_same') }}</label>
                </div>
                @if($errors->has('billing_same'))
                    <span class="text-danger">{{ $errors->first('billing_same') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.billing_same_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="billing_address">{{ trans('cruds.address.fields.billing_address') }}</label>
                <input class="form-control {{ $errors->has('billing_address') ? 'is-invalid' : '' }}" type="text" name="billing_address" id="billing_address" value="{{ old('billing_address', $address->billing_address) }}">
                @if($errors->has('billing_address'))
                    <span class="text-danger">{{ $errors->first('billing_address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.billing_address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="billing_city">{{ trans('cruds.address.fields.billing_city') }}</label>
                <input class="form-control {{ $errors->has('billing_city') ? 'is-invalid' : '' }}" type="text" name="billing_city" id="billing_city" value="{{ old('billing_city', $address->billing_city) }}">
                @if($errors->has('billing_city'))
                    <span class="text-danger">{{ $errors->first('billing_city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.billing_city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="billing_zip">{{ trans('cruds.address.fields.billing_zip') }}</label>
                <input class="form-control {{ $errors->has('billing_zip') ? 'is-invalid' : '' }}" type="text" name="billing_zip" id="billing_zip" value="{{ old('billing_zip', $address->billing_zip) }}">
                @if($errors->has('billing_zip'))
                    <span class="text-danger">{{ $errors->first('billing_zip') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.billing_zip_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="billing_country_id">{{ trans('cruds.address.fields.billing_country') }}</label>
                <select class="form-control select2 {{ $errors->has('billing_country') ? 'is-invalid' : '' }}" name="billing_country_id" id="billing_country_id">
                    @foreach($billing_countries as $id => $entry)
                        <option value="{{ $id }}" {{ (old('billing_country_id') ? old('billing_country_id') : $address->billing_country->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('billing_country'))
                    <span class="text-danger">{{ $errors->first('billing_country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.billing_country_helper') }}</span>
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