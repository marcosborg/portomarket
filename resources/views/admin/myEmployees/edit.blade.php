@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.myEmployee.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.service-employees.update", [$serviceEmployee->id]) }}"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="hidden" name="shop_company_id" value="{{ $shop_company->id }}">
            <input type="hidden" name="myEmployee" value="1">
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.serviceEmployee.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                    id="name" value="{{ old('name', $serviceEmployee->name) }}" required>
                @if($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.serviceEmployee.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="services">{{ trans('cruds.serviceEmployee.fields.service') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all')
                        }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{
                        trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('services') ? 'is-invalid' : '' }}"
                    name="services[]" id="services" multiple>
                    @foreach($services as $id => $service)
                    <option value="{{ $id }}" {{ (in_array($id, old('services', [])) || $serviceEmployee->
                        services->contains($id)) ? 'selected' : '' }}>{{ $service }}</option>
                    @endforeach
                </select>
                @if($errors->has('services'))
                <span class="text-danger">{{ $errors->first('services') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.serviceEmployee.fields.service_helper') }}</span>
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