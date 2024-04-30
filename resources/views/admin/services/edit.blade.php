@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.service.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.services.update", [$service->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="shop_company_id">{{ trans('cruds.service.fields.shop_company') }}</label>
                <select class="form-control select2 {{ $errors->has('shop_company') ? 'is-invalid' : '' }}" name="shop_company_id" id="shop_company_id" required>
                    @foreach($shop_companies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('shop_company_id') ? old('shop_company_id') : $service->shop_company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('shop_company'))
                    <span class="text-danger">{{ $errors->first('shop_company') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.shop_company_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.service.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $service->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reference">{{ trans('cruds.service.fields.reference') }}</label>
                <input class="form-control {{ $errors->has('reference') ? 'is-invalid' : '' }}" type="text" name="reference" id="reference" value="{{ old('reference', $service->reference) }}">
                @if($errors->has('reference'))
                    <span class="text-danger">{{ $errors->first('reference') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.reference_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.service.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $service->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photos">{{ trans('cruds.service.fields.photos') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photos') ? 'is-invalid' : '' }}" id="photos-dropzone">
                </div>
                @if($errors->has('photos'))
                    <span class="text-danger">{{ $errors->first('photos') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.photos_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="service_duration_id">{{ trans('cruds.service.fields.service_duration') }}</label>
                <select class="form-control select2 {{ $errors->has('service_duration') ? 'is-invalid' : '' }}" name="service_duration_id" id="service_duration_id" required>
                    @foreach($service_durations as $id => $entry)
                        <option value="{{ $id }}" {{ (old('service_duration_id') ? old('service_duration_id') : $service->service_duration->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('service_duration'))
                    <span class="text-danger">{{ $errors->first('service_duration') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.service_duration_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="shop_product_categories">{{ trans('cruds.service.fields.shop_product_categories') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('shop_product_categories') ? 'is-invalid' : '' }}" name="shop_product_categories[]" id="shop_product_categories" multiple>
                    @foreach($shop_product_categories as $id => $shop_product_category)
                        <option value="{{ $id }}" {{ (in_array($id, old('shop_product_categories', [])) || $service->shop_product_categories->contains($id)) ? 'selected' : '' }}>{{ $shop_product_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('shop_product_categories'))
                    <span class="text-danger">{{ $errors->first('shop_product_categories') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.shop_product_categories_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="shop_product_sub_categories">{{ trans('cruds.service.fields.shop_product_sub_categories') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('shop_product_sub_categories') ? 'is-invalid' : '' }}" name="shop_product_sub_categories[]" id="shop_product_sub_categories" multiple>
                    @foreach($shop_product_sub_categories as $id => $shop_product_sub_category)
                        <option value="{{ $id }}" {{ (in_array($id, old('shop_product_sub_categories', [])) || $service->shop_product_sub_categories->contains($id)) ? 'selected' : '' }}>{{ $shop_product_sub_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('shop_product_sub_categories'))
                    <span class="text-danger">{{ $errors->first('shop_product_sub_categories') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.shop_product_sub_categories_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="price">{{ trans('cruds.service.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $service->price) }}" step="0.01" required>
                @if($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="tax_id">{{ trans('cruds.service.fields.tax') }}</label>
                <select class="form-control select2 {{ $errors->has('tax') ? 'is-invalid' : '' }}" name="tax_id" id="tax_id" required>
                    @foreach($taxes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('tax_id') ? old('tax_id') : $service->tax->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('tax'))
                    <span class="text-danger">{{ $errors->first('tax') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.tax_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="youtube">{{ trans('cruds.service.fields.youtube') }}</label>
                <input class="form-control {{ $errors->has('youtube') ? 'is-invalid' : '' }}" type="text" name="youtube" id="youtube" value="{{ old('youtube', $service->youtube) }}">
                @if($errors->has('youtube'))
                    <span class="text-danger">{{ $errors->first('youtube') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.youtube_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attachment_name">{{ trans('cruds.service.fields.attachment_name') }}</label>
                <input class="form-control {{ $errors->has('attachment_name') ? 'is-invalid' : '' }}" type="text" name="attachment_name" id="attachment_name" value="{{ old('attachment_name', $service->attachment_name) }}">
                @if($errors->has('attachment_name'))
                    <span class="text-danger">{{ $errors->first('attachment_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.attachment_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attachment">{{ trans('cruds.service.fields.attachment') }}</label>
                <div class="needsclick dropzone {{ $errors->has('attachment') ? 'is-invalid' : '' }}" id="attachment-dropzone">
                </div>
                @if($errors->has('attachment'))
                    <span class="text-danger">{{ $errors->first('attachment') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.attachment_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('state') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="state" value="0">
                    <input class="form-check-input" type="checkbox" name="state" id="state" value="1" {{ $service->state || old('state', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="state">{{ trans('cruds.service.fields.state') }}</label>
                </div>
                @if($errors->has('state'))
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="position">{{ trans('cruds.service.fields.position') }}</label>
                <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="number" name="position" id="position" value="{{ old('position', $service->position) }}" step="1">
                @if($errors->has('position'))
                    <span class="text-danger">{{ $errors->first('position') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.position_helper') }}</span>
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

@section('scripts')
<script>
    var uploadedPhotosMap = {}
Dropzone.options.photosDropzone = {
    url: '{{ route('admin.services.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
      uploadedPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPhotosMap[file.name]
      }
      $('form').find('input[name="photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($service) && $service->photos)
      var files = {!! json_encode($service->photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="photos[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}

</script>
<script>
    Dropzone.options.attachmentDropzone = {
    url: '{{ route('admin.services.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="attachment"]').remove()
      $('form').append('<input type="hidden" name="attachment" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="attachment"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($service) && $service->attachment)
      var file = {!! json_encode($service->attachment) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="attachment" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection