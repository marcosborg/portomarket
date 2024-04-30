@foreach($shopProducts as $key => $shopProduct)
<tr data-product_id="{{ $shopProduct->id }}" data-position="{{ $shopProduct->position }}">
    <td class="hide"></td>
    <td>
        <img src="/theme/assets/img/arrows.svg" style="width: 10px; margin: 0 20px;">
    </td>
    <td>
        {{ $shopProduct->name ?? '' }}
    </td>
    <td>
        {{ $shopProduct->reference ?? '' }}
    </td>
    <td>
        @foreach($shopProduct->photos as $key => $media)
        <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
            <img src="{{ $media->getUrl('thumb') }}">
        </a>
        @endforeach
    </td>
    <td>
        @foreach($shopProduct->shop_product_categories as $key => $item)
        <span class="badge badge-info">{{ $item->name }}</span>
        @endforeach
    </td>
    <td>
        {!! $shopProduct->sales_price ? '<s>' : '' !!}{{ $shopProduct->price ?? '' }}{!! $shopProduct->sales_price ? '</s>' : '' !!}
        {!! $shopProduct->sales_price ? '<br>' . $shopProduct->sales_price : '' !!}
    </td>
    <td>
        {{ $shopProduct->shipping_cost ?? '' }}
    </td>
    <td>
        {{ $shopProduct->tax->tax ?? '' }}
    </td>
    <td>
        {{ $shopProduct->stock }}
    </td>
    <td>
        {{ $shopProduct->weight }}
    </td>
    <td>
        <span style="display:none">{{ $shopProduct->state ?? '' }}</span>
        <input type="checkbox" disabled="disabled" {{ $shopProduct->state ? 'checked' : '' }}>
    </td>
    <td>
        @if (Gate::allows('shop_product_edit') || Gate::allows('my_product_access'))
        <a class="btn btn-xs btn-info" href="/admin/my-products/edit/{{ $shopProduct->id }}">
            {{ trans('global.edit') }}
        </a>
        @endif

        @if (Gate::allows('shop_product_delete') || Gate::allows('my_product_access'))
        <form action="{{ route('admin.shop-products.destroy', $shopProduct->id) }}" method="POST"
            onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
            <input type="hidden" name="shopProduct" value="1">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
        </form>
        @endif

    </td>

</tr>
@endforeach