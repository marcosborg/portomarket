<div class="card mb-5">
    <div class="card-header">
        Pesquisar nas lojas
    </div>
    <div class="card-body">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="O que procura?" id="searchField"
                onkeydown="handleKeyPress(event)">
            <button class="btn btn-orange" type="button" onclick="searchInShop()"><i class="bi bi-search"></i></button>
        </div>
        <div class="list-group">
            @foreach ($shop_categories as $shop_category)
            <a href="/lojas/categoria/{{ $shop_category->id }}/{{ Str::slug($shop_category->name, '-') }}" class="list-group-item list-group-item-action {{ isset($category) && $category->id == $shop_category->id ?
                                'active' : '' }}">{{ $shop_category->name
                }}</a>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="searchResult" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Resultados da pesquisa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    function handleKeyPress(event) {
        if (event.keyCode === 13) { // Verifica se a tecla pressionada é a tecla Enter
            searchInShop();
            event.preventDefault(); // Impede o comportamento padrão de submissão do formulário
        }
    }
    searchInShop = () => {
        $.LoadingOverlay('show');
        let search = $('#searchField').val();
        let data = {
            search: search,
        }
        $.get('/lojas/searchInShop/' + search).then((resp) => {
            $.LoadingOverlay('hide');
            $('#searchResult').modal('show');
            $('#searchResult .modal-body').html(resp);
            $('#searchField').val('');
        });
    }
    function detectScreenSize() {
                if (window.innerWidth <= 767) {
                    $('#left').addClass('order-2');
                } else {
                    $('#left').removeClass('order-2');
                }
            }
        
            // Chama a função inicialmente para verificar o tamanho da tela no carregamento da página
            detectScreenSize();
        
            // Adiciona um ouvinte de evento de redimensionamento da janela
            window.addEventListener('resize', detectScreenSize);
</script>
@endsection
