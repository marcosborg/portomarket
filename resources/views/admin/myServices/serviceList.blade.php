@foreach($services as $key => $service)
<tr data-entry-id="{{ $service->id }}" data-service_id="{{ $service->id }}" data-position="{{ $service->position }}">
    <td class="hide">

    </td>
    <td>
        <img src="/theme/assets/img/arrows.svg" style="width: 10px; margin: 0 20px;">
    </td>
    <td>
        {{ $service->name ?? '' }}
    </td>
    <td>
        {{ $service->reference ?? '' }}
    </td>
    <td>
        @foreach($service->photos as $key => $media)
        <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
            <img src="{{ $media->getUrl('thumb') }}">
        </a>
        @endforeach
    </td>
    <td>
        {{ $service->service_duration->name ?? '' }}
    </td>
    <td>
        @foreach($service->shop_product_categories as $key => $item)
        <span class="badge badge-info">{{ $item->name }}</span>
        @endforeach
    </td>
    <td>
        @foreach($service->shop_product_sub_categories as $key => $item)
        <span class="badge badge-info">{{ $item->name }}</span>
        @endforeach
    </td>
    <td>
        {{ $service->price ?? '' }}
    </td>
    <td>
        {{ $service->tax->name ?? '' }}
    </td>
    <td>
        <span style="display:none">{{ $service->state ?? '' }}</span>
        <input type="checkbox" disabled="disabled" {{ $service->state ? 'checked' : '' }}>
    </td>
    <td>
        @can('my_service_access')
        <a class="btn btn-xs btn-info" href="/admin/my-services/edit/{{ $service->id }}">
            {{ trans('global.edit') }}
        </a>
        @endcan

        @can('my_service_access')
        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST"
            onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
        </form>
        @endcan

    </td>

</tr>
@endforeach