@extends('layouts.admin')
@section('content')

<div class="card">
  <div class="card-header">
    {{ trans('cruds.myShop.title') }}
  </div>
  @if ($user->company[0]->shop_company)
  <div class="card">
    <div class="card-header">
      {{ trans('global.edit') }} {{ trans('cruds.myShop.title_singular') }}
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route("admin.my-shops.update", [$user->company[0]->shop_company->id]) }}"
        enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="company_id" value="{{ $user->company[0]->id }}">
        <input type="hidden" name="id" value="{{ $user->company[0]->shop_company->id }}">
        <input type="hidden" name="shop_company_id" value="{{ $user->company[0]->shop_company->id }}">
        <div class="form-group">
          <label for="about">{{ trans('cruds.shopCompany.fields.about') }}</label>
          <textarea class="form-control ckeditor {{ $errors->has('about') ? 'is-invalid' : '' }}" name="about"
            id="about">{!! old('about', $user->company[0]->shop_company->about) !!}</textarea>
          @if($errors->has('about'))
          <span class="text-danger">{{ $errors->first('about') }}</span>
          @endif
          <span class="help-block">{{ trans('cruds.shopCompany.fields.about_helper') }}</span>
        </div>
        <div class="form-group">
          <label for="shop_categories">{{ trans('cruds.shopCompany.fields.shop_categories') }}</label>
          <div style="padding-bottom: 4px">
            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{
              trans('global.select_all') }}</span>
            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{
              trans('global.deselect_all') }}</span>
          </div>
          <select class="form-control select2 {{ $errors->has('shop_categories') ? 'is-invalid' : '' }}"
            name="shop_categories[]" id="shop_categories" multiple>
            @foreach($shop_categories as $id => $shop_category)
            <option value="{{ $id }}" {{ (in_array($id, old('shop_categories', [])) || $user->company[0]->shop_company->
              shop_categories->contains($id)) ? 'selected' : '' }}>{{ $shop_category }}</option>
            @endforeach
          </select>
          @if($errors->has('shop_categories'))
          <span class="text-danger">{{ $errors->first('shop_categories') }}</span>
          @endif
          <span class="help-block">{{ trans('cruds.shopCompany.fields.shop_categories_helper') }}</span>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="required" for="shop_location_id">{{ trans('cruds.shopCompany.fields.shop_location')
                }}</label>
              <select class="form-control select2 {{ $errors->has('shop_location') ? 'is-invalid' : '' }}"
                name="shop_location_id" id="shop_location_id" required>
                @foreach($shop_locations as $id => $entry)
                <option value="{{ $id }}" {{ (old('shop_location_id') ? old('shop_location_id') : $user->
                  company[0]->shop_company->
                  shop_location->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                @endforeach
              </select>
              @if($errors->has('shop_location'))
              <span class="text-danger">{{ $errors->first('shop_location') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.shopCompany.fields.shop_location_helper') }}</span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="youtube">{{ trans('cruds.shopCompany.fields.youtube') }}</label>
              <input class="form-control {{ $errors->has('youtube') ? 'is-invalid' : '' }}" type="text" name="youtube"
                id="youtube" value="{{ old('youtube', $shopCompany->youtube) }}">
              @if($errors->has('youtube'))
              <span class="text-danger">{{ $errors->first('youtube') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.shopCompany.fields.youtube_helper') }}</span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="address">{{ trans('cruds.shopCompany.fields.address') }}</label>
              <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address"
                id="address" value="{{ old('address', $shopCompany->address) }}">
              @if($errors->has('address'))
              <span class="text-danger">{{ $errors->first('address') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.shopCompany.fields.address_helper') }}</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="latitude">{{ trans('cruds.shopCompany.fields.latitude') }}</label>
              <input class="form-control {{ $errors->has('latitude') ? 'is-invalid' : '' }}" type="text" name="latitude"
                id="latitude" value="{{ old('latitude', $shopCompany->latitude) }}">
              @if($errors->has('latitude'))
              <span class="text-danger">{{ $errors->first('latitude') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.shopCompany.fields.latitude_helper') }}</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="longitude">{{ trans('cruds.shopCompany.fields.longitude') }}</label>
              <input class="form-control {{ $errors->has('longitude') ? 'is-invalid' : '' }}" type="text"
                name="longitude" id="longitude" value="{{ old('longitude', $shopCompany->longitude) }}">
              @if($errors->has('longitude'))
              <span class="text-danger">{{ $errors->first('longitude') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.shopCompany.fields.longitude_helper') }}</span>
            </div>
          </div>
        </div>


        <div class="form-group">
          <label for="contacts">{{ trans('cruds.shopCompany.fields.contacts') }}</label>
          <textarea class="form-control ckeditor {{ $errors->has('contacts') ? 'is-invalid' : '' }}" name="contacts"
            id="contacts">{{ old('contacts', $user->company[0]->shop_company->contacts) }}</textarea>
          @if($errors->has('contacts'))
          <span class="text-danger">{{ $errors->first('contacts') }}</span>
          @endif
          <span class="help-block">{{ trans('cruds.shopCompany.fields.contacts_helper') }}</span>
        </div>
        <div class="form-group">
          <label for="photos">{{ trans('cruds.shopCompany.fields.photos') }}</label>
          <div class="needsclick dropzone {{ $errors->has('photos') ? 'is-invalid' : '' }}" id="photos-dropzone">
          </div>
          @if($errors->has('photos'))
          <span class="text-danger">{{ $errors->first('photos') }}</span>
          @endif
          <span class="help-block">{{ trans('cruds.shopCompany.fields.photos_helper') }}</span>
        </div>
        <label>Horários da loja</label>
        <div class="row">
          <div class="col-md-4">
            <div class="card bg-primary mb-3">
              <div class="card-header">
                <p class="card-title">Segunda</p>
              </div>
              <div class="card-body">
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da manhã</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="monday_morning_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->monday_morning_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="monday_morning_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->monday_morning_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da tarde</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="monday_afternoon_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->monday_afternoon_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="monday_afternoon_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->monday_afternoon_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card bg-primary mb-3">
              <div class="card-header">
                <p class="card-title">Terça</p>
              </div>
              <div class="card-body">
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da manhã</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="tuesday_morning_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->tuesday_morning_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="tuesday_morning_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->tuesday_morning_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da tarde</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="tuesday_afternoon_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->tuesday_afternoon_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="tuesday_afternoon_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->tuesday_afternoon_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card bg-primary mb-3">
              <div class="card-header">
                <p class="card-title">Quarta</p>
              </div>
              <div class="card-body">
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da manhã</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="wednesday_morning_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->tuesday_morning_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="wednesday_morning_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->tuesday_morning_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da tarde</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="wednesday_afternoon_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->tuesday_afternoon_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="wednesday_afternoon_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->tuesday_afternoon_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card bg-primary mb-3">
              <div class="card-header">
                <p class="card-title">Quinta</p>
              </div>
              <div class="card-body">
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da manhã</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="thursday_morning_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->thursday_morning_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="thursday_morning_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->thursday_morning_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da tarde</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="thursday_afternoon_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->thursday_afternoon_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="thursday_afternoon_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->thursday_afternoon_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card bg-primary mb-3">
              <div class="card-header">
                <p class="card-title">Sexta</p>
              </div>
              <div class="card-body">
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da manhã</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="friday_morning_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->friday_morning_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="friday_morning_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->friday_morning_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da tarde</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="friday_afternoon_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->friday_afternoon_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="friday_afternoon_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->friday_afternoon_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card bg-success mb-3">
              <div class="card-header">
                <p class="card-title">Sábado</p>
              </div>
              <div class="card-body">
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da manhã</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="saturday_morning_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->saturday_morning_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="saturday_morning_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->saturday_morning_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da tarde</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="saturday_afternoon_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->saturday_afternoon_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="saturday_afternoon_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->saturday_afternoon_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card bg-success mb-3">
              <div class="card-header">
                <p class="card-title">Domingo</p>
              </div>
              <div class="card-body">
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da manhã</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="sunday_morning_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->sunday_morning_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="sunday_morning_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->sunday_morning_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card text-dark">
                  <div class="card-body">
                    <label>Período da tarde</label>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Abertura</label>
                          <input type="time" name="sunday_afternoon_opening" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->sunday_afternoon_opening }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Encerramento</label>
                          <input type="time" name="sunday_afternoon_closing" class="form-control"
                            value="{{ $user->company[0]->shop_company->shop_company_schedules->sunday_afternoon_closing }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-danger" type="submit">
            {{ trans('global.save') }}
          </button>
        </div>
      </form>
    </div>
  </div>
  @else
  <div class="card-body">
    <h3>Parabens! O seu plano está ativo. Pode criar a sua loja.</h3>
    <a href="/admin/my-shops/create" class="btn btn-lg btn-success">Criar loja</a>
  </div>
  @endif

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
                xhr.open('POST', '{{ route('admin.shop-companies.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $user->company[0]->shop_company->id ?? 0 }}');
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
    url: '{{ route('admin.shop-companies.storeMedia') }}',
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
@if(isset($user->company[0]->shop_company) && $user->company[0]->shop_company->photos)
      var files = {!! json_encode($user->company[0]->shop_company->photos) !!}
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
@endsection
<script>
  console.log({!! $user->company[0]->shop_company->shop_company_schedules !!})
</script>