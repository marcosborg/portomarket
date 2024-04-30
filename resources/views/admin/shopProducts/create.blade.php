@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.shopProduct.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.shop-products.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.shopProduct.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reference">{{ trans('cruds.shopProduct.fields.reference') }}</label>
                <input class="form-control {{ $errors->has('reference') ? 'is-invalid' : '' }}" type="text" name="reference" id="reference" value="{{ old('reference', '') }}">
                @if($errors->has('reference'))
                    <span class="text-danger">{{ $errors->first('reference') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.reference_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.shopProduct.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description') !!}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photos">{{ trans('cruds.shopProduct.fields.photos') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photos') ? 'is-invalid' : '' }}" id="photos-dropzone">
                </div>
                @if($errors->has('photos'))
                    <span class="text-danger">{{ $errors->first('photos') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.photos_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="shop_product_categories">{{ trans('cruds.shopProduct.fields.shop_product_categories') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('shop_product_categories') ? 'is-invalid' : '' }}" name="shop_product_categories[]" id="shop_product_categories" multiple>
                    @foreach($shop_product_categories as $id => $shop_product_category)
                        <option value="{{ $id }}" {{ in_array($id, old('shop_product_categories', [])) ? 'selected' : '' }}>{{ $shop_product_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('shop_product_categories'))
                    <span class="text-danger">{{ $errors->first('shop_product_categories') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.shop_product_categories_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="shop_product_sub_categories">{{ trans('cruds.shopProduct.fields.shop_product_sub_categories') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('shop_product_sub_categories') ? 'is-invalid' : '' }}" name="shop_product_sub_categories[]" id="shop_product_sub_categories" multiple>
                    @foreach($shop_product_sub_categories as $id => $shop_product_sub_category)
                        <option value="{{ $id }}" {{ in_array($id, old('shop_product_sub_categories', [])) ? 'selected' : '' }}>{{ $shop_product_sub_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('shop_product_sub_categories'))
                    <span class="text-danger">{{ $errors->first('shop_product_sub_categories') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.shop_product_sub_categories_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price">{{ trans('cruds.shopProduct.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}" step="0.01">
                @if($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sales_price">{{ trans('cruds.shopProduct.fields.sales_price') }}</label>
                <input class="form-control {{ $errors->has('sales_price') ? 'is-invalid' : '' }}" type="number" name="sales_price" id="sales_price" value="{{ old('sales_price', '') }}" step="0.01">
                @if($errors->has('sales_price'))
                    <span class="text-danger">{{ $errors->first('sales_price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.sales_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sales_label">{{ trans('cruds.shopProduct.fields.sales_label') }}</label>
                <input class="form-control {{ $errors->has('sales_label') ? 'is-invalid' : '' }}" type="text" name="sales_label" id="sales_label" value="{{ old('sales_label', '') }}">
                @if($errors->has('sales_label'))
                    <span class="text-danger">{{ $errors->first('sales_label') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.sales_label_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="tax_id">{{ trans('cruds.shopProduct.fields.tax') }}</label>
                <select class="form-control select2 {{ $errors->has('tax') ? 'is-invalid' : '' }}" name="tax_id" id="tax_id" required>
                    @foreach($taxes as $id => $entry)
                        <option value="{{ $id }}" {{ old('tax_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('tax'))
                    <span class="text-danger">{{ $errors->first('tax') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.tax_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="youtube">{{ trans('cruds.shopProduct.fields.youtube') }}</label>
                <input class="form-control {{ $errors->has('youtube') ? 'is-invalid' : '' }}" type="text" name="youtube" id="youtube" value="{{ old('youtube', '') }}">
                @if($errors->has('youtube'))
                    <span class="text-danger">{{ $errors->first('youtube') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.youtube_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('state') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="state" value="0">
                    <input class="form-check-input" type="checkbox" name="state" id="state" value="1" {{ old('state', 0) == 1 || old('state') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="state">{{ trans('cruds.shopProduct.fields.state') }}</label>
                </div>
                @if($errors->has('state'))
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attachment_name">{{ trans('cruds.shopProduct.fields.attachment_name') }}</label>
                <input class="form-control {{ $errors->has('attachment_name') ? 'is-invalid' : '' }}" type="text" name="attachment_name" id="attachment_name" value="{{ old('attachment_name', '') }}">
                @if($errors->has('attachment_name'))
                    <span class="text-danger">{{ $errors->first('attachment_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.attachment_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attachment">{{ trans('cruds.shopProduct.fields.attachment') }}</label>
                <div class="needsclick dropzone {{ $errors->has('attachment') ? 'is-invalid' : '' }}" id="attachment-dropzone">
                </div>
                @if($errors->has('attachment'))
                    <span class="text-danger">{{ $errors->first('attachment') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.attachment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="position">{{ trans('cruds.shopProduct.fields.position') }}</label>
                <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="number" name="position" id="position" value="{{ old('position', '') }}" step="1">
                @if($errors->has('position'))
                    <span class="text-danger">{{ $errors->first('position') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.position_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="stock">{{ trans('cruds.shopProduct.fields.stock') }}</label>
                <input class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" type="number" name="stock" id="stock" value="{{ old('stock', '0') }}" step="1">
                @if($errors->has('stock'))
                    <span class="text-danger">{{ $errors->first('stock') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.stock_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="shipping_cost">{{ trans('cruds.shopProduct.fields.shipping_cost') }}</label>
                <input class="form-control {{ $errors->has('shipping_cost') ? 'is-invalid' : '' }}" type="number" name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost', '') }}" step="0.01">
                @if($errors->has('shipping_cost'))
                    <span class="text-danger">{{ $errors->first('shipping_cost') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.shipping_cost_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="weight">{{ trans('cruds.shopProduct.fields.weight') }}</label>
                <input class="form-control {{ $errors->has('weight') ? 'is-invalid' : '' }}" type="number" name="weight" id="weight" value="{{ old('weight', '') }}" step="1">
                @if($errors->has('weight'))
                    <span class="text-danger">{{ $errors->first('weight') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shopProduct.fields.weight_helper') }}</span>
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
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.shop-products.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $shopProduct->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<script>
    var uploadedPhotosMap = {}
Dropzone.options.photosDropzone = {
    url: '{{ route('admin.shop-products.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
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
@if(isset($shopProduct) && $shopProduct->photos)
      var files = {!! json_encode($shopProduct->photos) !!}
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
    url: '{{ route('admin.shop-products.storeMedia') }}',
    maxFilesize: 5, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
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
@if(isset($shopProduct) && $shopProduct->attachment)
      var file = {!! json_encode($shopProduct->attachment) !!}
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