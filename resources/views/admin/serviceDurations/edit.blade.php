@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.serviceDuration.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.service-durations.update", [$serviceDuration->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.serviceDuration.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $serviceDuration->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.serviceDuration.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="minutes">{{ trans('cruds.serviceDuration.fields.minutes') }}</label>
                <input class="form-control {{ $errors->has('minutes') ? 'is-invalid' : '' }}" type="number" name="minutes" id="minutes" value="{{ old('minutes', $serviceDuration->minutes) }}" step="1" required>
                @if($errors->has('minutes'))
                    <span class="text-danger">{{ $errors->first('minutes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.serviceDuration.fields.minutes_helper') }}</span>
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