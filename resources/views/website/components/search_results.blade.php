@if (count($results) == 0)
<div class="alert alert-info">
    Não existem resultados para os termos da pesquisa.
</div>
@else
<div class="list-group">
    @foreach ($results as $result)
    @switch($result['type'])
    @case('company')
        <a href="/lojas/loja/{{ $result['id'] }}/{{ Str::slug($result['name'], '-') }}" class="list-group-item list-group-item-action">
        @break
    @case('product')
        <a href="/lojas/produto/{{ $result['id'] }}/{{ Str::slug($result['name'], '-') }}" class="list-group-item list-group-item-action">
        @break
    @case('service')
        <a href="/lojas/servico/{{ $result['id'] }}/{{ Str::slug($result['name'], '-') }}" class="list-group-item list-group-item-action">
        @break
    @default
        <a href="/lojas/categoria/{{ $result['id'] }}/{{ Str::slug($result['name'], '-') }}" class="list-group-item list-group-item-action">
    @endswitch
    <img src="{{ $result['image'] }}" class="p-2 me-2 img-thumbnail float-start">
    <div class="p-2">
        <p class="mb-0"><strong>{{ $result['name'] }}</strong></p>
        {!! $result['more'] !!}
    </div>
    </a>
    @endforeach
</div>
@endif