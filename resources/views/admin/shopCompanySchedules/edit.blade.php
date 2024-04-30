@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.shopCompanySchedule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.shop-company-schedules.update", [$shopCompanySchedule->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="shop_company_id">{{ trans('cruds.shopCompanySchedule.fields.shop_company') }}</label>
                <select class="form-control select2 {{ $errors->has('shop_company') ? 'is-invalid' : '' }}" name="shop_company_id" id="shop_company_id" required>
                    @foreach($shop_companies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('shop_company_id') ? old('shop_company_id') : $shopCompanySchedule->shop_company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('shop_company'))
                    <span class="text-danger">{{ $errors->first('shop_company') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.shop_company_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="monday_morning_opening">{{ trans('cruds.shopCompanySchedule.fields.monday_morning_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('monday_morning_opening') ? 'is-invalid' : '' }}" type="text" name="monday_morning_opening" id="monday_morning_opening" value="{{ old('monday_morning_opening', $shopCompanySchedule->monday_morning_opening) }}">
                @if($errors->has('monday_morning_opening'))
                    <span class="text-danger">{{ $errors->first('monday_morning_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.monday_morning_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="monday_morning_closing">{{ trans('cruds.shopCompanySchedule.fields.monday_morning_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('monday_morning_closing') ? 'is-invalid' : '' }}" type="text" name="monday_morning_closing" id="monday_morning_closing" value="{{ old('monday_morning_closing', $shopCompanySchedule->monday_morning_closing) }}">
                @if($errors->has('monday_morning_closing'))
                    <span class="text-danger">{{ $errors->first('monday_morning_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.monday_morning_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="moday_afternoon_opening">{{ trans('cruds.shopCompanySchedule.fields.moday_afternoon_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('moday_afternoon_opening') ? 'is-invalid' : '' }}" type="text" name="moday_afternoon_opening" id="moday_afternoon_opening" value="{{ old('moday_afternoon_opening', $shopCompanySchedule->moday_afternoon_opening) }}">
                @if($errors->has('moday_afternoon_opening'))
                    <span class="text-danger">{{ $errors->first('moday_afternoon_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.moday_afternoon_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="monday_afternoon_closing">{{ trans('cruds.shopCompanySchedule.fields.monday_afternoon_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('monday_afternoon_closing') ? 'is-invalid' : '' }}" type="text" name="monday_afternoon_closing" id="monday_afternoon_closing" value="{{ old('monday_afternoon_closing', $shopCompanySchedule->monday_afternoon_closing) }}">
                @if($errors->has('monday_afternoon_closing'))
                    <span class="text-danger">{{ $errors->first('monday_afternoon_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.monday_afternoon_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tuesday_morning_opening">{{ trans('cruds.shopCompanySchedule.fields.tuesday_morning_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('tuesday_morning_opening') ? 'is-invalid' : '' }}" type="text" name="tuesday_morning_opening" id="tuesday_morning_opening" value="{{ old('tuesday_morning_opening', $shopCompanySchedule->tuesday_morning_opening) }}">
                @if($errors->has('tuesday_morning_opening'))
                    <span class="text-danger">{{ $errors->first('tuesday_morning_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.tuesday_morning_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tuesday_morning_closing">{{ trans('cruds.shopCompanySchedule.fields.tuesday_morning_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('tuesday_morning_closing') ? 'is-invalid' : '' }}" type="text" name="tuesday_morning_closing" id="tuesday_morning_closing" value="{{ old('tuesday_morning_closing', $shopCompanySchedule->tuesday_morning_closing) }}">
                @if($errors->has('tuesday_morning_closing'))
                    <span class="text-danger">{{ $errors->first('tuesday_morning_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.tuesday_morning_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tuesday_afternoon_opening">{{ trans('cruds.shopCompanySchedule.fields.tuesday_afternoon_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('tuesday_afternoon_opening') ? 'is-invalid' : '' }}" type="text" name="tuesday_afternoon_opening" id="tuesday_afternoon_opening" value="{{ old('tuesday_afternoon_opening', $shopCompanySchedule->tuesday_afternoon_opening) }}">
                @if($errors->has('tuesday_afternoon_opening'))
                    <span class="text-danger">{{ $errors->first('tuesday_afternoon_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.tuesday_afternoon_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tuesday_afternoon_closing">{{ trans('cruds.shopCompanySchedule.fields.tuesday_afternoon_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('tuesday_afternoon_closing') ? 'is-invalid' : '' }}" type="text" name="tuesday_afternoon_closing" id="tuesday_afternoon_closing" value="{{ old('tuesday_afternoon_closing', $shopCompanySchedule->tuesday_afternoon_closing) }}">
                @if($errors->has('tuesday_afternoon_closing'))
                    <span class="text-danger">{{ $errors->first('tuesday_afternoon_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.tuesday_afternoon_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="wednesday_morning_opening">{{ trans('cruds.shopCompanySchedule.fields.wednesday_morning_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('wednesday_morning_opening') ? 'is-invalid' : '' }}" type="text" name="wednesday_morning_opening" id="wednesday_morning_opening" value="{{ old('wednesday_morning_opening', $shopCompanySchedule->wednesday_morning_opening) }}">
                @if($errors->has('wednesday_morning_opening'))
                    <span class="text-danger">{{ $errors->first('wednesday_morning_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.wednesday_morning_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="wednesday_morning_closing">{{ trans('cruds.shopCompanySchedule.fields.wednesday_morning_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('wednesday_morning_closing') ? 'is-invalid' : '' }}" type="text" name="wednesday_morning_closing" id="wednesday_morning_closing" value="{{ old('wednesday_morning_closing', $shopCompanySchedule->wednesday_morning_closing) }}">
                @if($errors->has('wednesday_morning_closing'))
                    <span class="text-danger">{{ $errors->first('wednesday_morning_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.wednesday_morning_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="wednesday_afternoon_opening">{{ trans('cruds.shopCompanySchedule.fields.wednesday_afternoon_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('wednesday_afternoon_opening') ? 'is-invalid' : '' }}" type="text" name="wednesday_afternoon_opening" id="wednesday_afternoon_opening" value="{{ old('wednesday_afternoon_opening', $shopCompanySchedule->wednesday_afternoon_opening) }}">
                @if($errors->has('wednesday_afternoon_opening'))
                    <span class="text-danger">{{ $errors->first('wednesday_afternoon_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.wednesday_afternoon_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="wednesday_afternoon_closing">{{ trans('cruds.shopCompanySchedule.fields.wednesday_afternoon_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('wednesday_afternoon_closing') ? 'is-invalid' : '' }}" type="text" name="wednesday_afternoon_closing" id="wednesday_afternoon_closing" value="{{ old('wednesday_afternoon_closing', $shopCompanySchedule->wednesday_afternoon_closing) }}">
                @if($errors->has('wednesday_afternoon_closing'))
                    <span class="text-danger">{{ $errors->first('wednesday_afternoon_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.wednesday_afternoon_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="thursday_morning_opening">{{ trans('cruds.shopCompanySchedule.fields.thursday_morning_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('thursday_morning_opening') ? 'is-invalid' : '' }}" type="text" name="thursday_morning_opening" id="thursday_morning_opening" value="{{ old('thursday_morning_opening', $shopCompanySchedule->thursday_morning_opening) }}">
                @if($errors->has('thursday_morning_opening'))
                    <span class="text-danger">{{ $errors->first('thursday_morning_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.thursday_morning_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="thursday_morning_closing">{{ trans('cruds.shopCompanySchedule.fields.thursday_morning_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('thursday_morning_closing') ? 'is-invalid' : '' }}" type="text" name="thursday_morning_closing" id="thursday_morning_closing" value="{{ old('thursday_morning_closing', $shopCompanySchedule->thursday_morning_closing) }}">
                @if($errors->has('thursday_morning_closing'))
                    <span class="text-danger">{{ $errors->first('thursday_morning_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.thursday_morning_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="thursday_afternoon_opening">{{ trans('cruds.shopCompanySchedule.fields.thursday_afternoon_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('thursday_afternoon_opening') ? 'is-invalid' : '' }}" type="text" name="thursday_afternoon_opening" id="thursday_afternoon_opening" value="{{ old('thursday_afternoon_opening', $shopCompanySchedule->thursday_afternoon_opening) }}">
                @if($errors->has('thursday_afternoon_opening'))
                    <span class="text-danger">{{ $errors->first('thursday_afternoon_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.thursday_afternoon_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="thursday_afternoon_closing">{{ trans('cruds.shopCompanySchedule.fields.thursday_afternoon_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('thursday_afternoon_closing') ? 'is-invalid' : '' }}" type="text" name="thursday_afternoon_closing" id="thursday_afternoon_closing" value="{{ old('thursday_afternoon_closing', $shopCompanySchedule->thursday_afternoon_closing) }}">
                @if($errors->has('thursday_afternoon_closing'))
                    <span class="text-danger">{{ $errors->first('thursday_afternoon_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.thursday_afternoon_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="friday_morning_opening">{{ trans('cruds.shopCompanySchedule.fields.friday_morning_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('friday_morning_opening') ? 'is-invalid' : '' }}" type="text" name="friday_morning_opening" id="friday_morning_opening" value="{{ old('friday_morning_opening', $shopCompanySchedule->friday_morning_opening) }}">
                @if($errors->has('friday_morning_opening'))
                    <span class="text-danger">{{ $errors->first('friday_morning_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.friday_morning_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="friday_morning_closing">{{ trans('cruds.shopCompanySchedule.fields.friday_morning_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('friday_morning_closing') ? 'is-invalid' : '' }}" type="text" name="friday_morning_closing" id="friday_morning_closing" value="{{ old('friday_morning_closing', $shopCompanySchedule->friday_morning_closing) }}">
                @if($errors->has('friday_morning_closing'))
                    <span class="text-danger">{{ $errors->first('friday_morning_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.friday_morning_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="friday_afternoon_opening">{{ trans('cruds.shopCompanySchedule.fields.friday_afternoon_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('friday_afternoon_opening') ? 'is-invalid' : '' }}" type="text" name="friday_afternoon_opening" id="friday_afternoon_opening" value="{{ old('friday_afternoon_opening', $shopCompanySchedule->friday_afternoon_opening) }}">
                @if($errors->has('friday_afternoon_opening'))
                    <span class="text-danger">{{ $errors->first('friday_afternoon_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.friday_afternoon_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="friday_afternoon_closing">{{ trans('cruds.shopCompanySchedule.fields.friday_afternoon_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('friday_afternoon_closing') ? 'is-invalid' : '' }}" type="text" name="friday_afternoon_closing" id="friday_afternoon_closing" value="{{ old('friday_afternoon_closing', $shopCompanySchedule->friday_afternoon_closing) }}">
                @if($errors->has('friday_afternoon_closing'))
                    <span class="text-danger">{{ $errors->first('friday_afternoon_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.friday_afternoon_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="saturday_morning_opening">{{ trans('cruds.shopCompanySchedule.fields.saturday_morning_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('saturday_morning_opening') ? 'is-invalid' : '' }}" type="text" name="saturday_morning_opening" id="saturday_morning_opening" value="{{ old('saturday_morning_opening', $shopCompanySchedule->saturday_morning_opening) }}">
                @if($errors->has('saturday_morning_opening'))
                    <span class="text-danger">{{ $errors->first('saturday_morning_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.saturday_morning_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="saturday_morning_closing">{{ trans('cruds.shopCompanySchedule.fields.saturday_morning_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('saturday_morning_closing') ? 'is-invalid' : '' }}" type="text" name="saturday_morning_closing" id="saturday_morning_closing" value="{{ old('saturday_morning_closing', $shopCompanySchedule->saturday_morning_closing) }}">
                @if($errors->has('saturday_morning_closing'))
                    <span class="text-danger">{{ $errors->first('saturday_morning_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.saturday_morning_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="saturday_afternoon_opening">{{ trans('cruds.shopCompanySchedule.fields.saturday_afternoon_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('saturday_afternoon_opening') ? 'is-invalid' : '' }}" type="text" name="saturday_afternoon_opening" id="saturday_afternoon_opening" value="{{ old('saturday_afternoon_opening', $shopCompanySchedule->saturday_afternoon_opening) }}">
                @if($errors->has('saturday_afternoon_opening'))
                    <span class="text-danger">{{ $errors->first('saturday_afternoon_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.saturday_afternoon_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="saturday_afternoon_closing">{{ trans('cruds.shopCompanySchedule.fields.saturday_afternoon_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('saturday_afternoon_closing') ? 'is-invalid' : '' }}" type="text" name="saturday_afternoon_closing" id="saturday_afternoon_closing" value="{{ old('saturday_afternoon_closing', $shopCompanySchedule->saturday_afternoon_closing) }}">
                @if($errors->has('saturday_afternoon_closing'))
                    <span class="text-danger">{{ $errors->first('saturday_afternoon_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.saturday_afternoon_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sunday_morning_opening">{{ trans('cruds.shopCompanySchedule.fields.sunday_morning_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('sunday_morning_opening') ? 'is-invalid' : '' }}" type="text" name="sunday_morning_opening" id="sunday_morning_opening" value="{{ old('sunday_morning_opening', $shopCompanySchedule->sunday_morning_opening) }}">
                @if($errors->has('sunday_morning_opening'))
                    <span class="text-danger">{{ $errors->first('sunday_morning_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.sunday_morning_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sunday_morning_closing">{{ trans('cruds.shopCompanySchedule.fields.sunday_morning_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('sunday_morning_closing') ? 'is-invalid' : '' }}" type="text" name="sunday_morning_closing" id="sunday_morning_closing" value="{{ old('sunday_morning_closing', $shopCompanySchedule->sunday_morning_closing) }}">
                @if($errors->has('sunday_morning_closing'))
                    <span class="text-danger">{{ $errors->first('sunday_morning_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.sunday_morning_closing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sunday_afternoon_opening">{{ trans('cruds.shopCompanySchedule.fields.sunday_afternoon_opening') }}</label>
                <input class="form-control timepicker {{ $errors->has('sunday_afternoon_opening') ? 'is-invalid' : '' }}" type="text" name="sunday_afternoon_opening" id="sunday_afternoon_opening" value="{{ old('sunday_afternoon_opening', $shopCompanySchedule->sunday_afternoon_opening) }}">
                @if($errors->has('sunday_afternoon_opening'))
                    <span class="text-danger">{{ $errors->first('sunday_afternoon_opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.sunday_afternoon_opening_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sunday_afternoon_closing">{{ trans('cruds.shopCompanySchedule.fields.sunday_afternoon_closing') }}</label>
                <input class="form-control timepicker {{ $errors->has('sunday_afternoon_closing') ? 'is-invalid' : '' }}" type="text" name="sunday_afternoon_closing" id="sunday_afternoon_closing" value="{{ old('sunday_afternoon_closing', $shopCompanySchedule->sunday_afternoon_closing) }}">
                @if($errors->has('sunday_afternoon_closing'))
                    <span class="text-danger">{{ $errors->first('sunday_afternoon_closing') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopCompanySchedule.fields.sunday_afternoon_closing_helper') }}</span>
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