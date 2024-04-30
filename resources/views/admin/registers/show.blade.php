@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.register.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.registers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.register.fields.id') }}
                        </th>
                        <td>
                            {{ $register->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.register.fields.name') }}
                        </th>
                        <td>
                            {{ $register->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.register.fields.email') }}
                        </th>
                        <td>
                            {{ $register->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.register.fields.company_name') }}
                        </th>
                        <td>
                            {{ $register->company_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.register.fields.phone') }}
                        </th>
                        <td>
                            {{ $register->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.register.fields.message') }}
                        </th>
                        <td>
                            {{ $register->message }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.registers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection