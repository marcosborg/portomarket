<div class="modal-body">
    <center>
        <img src="https://comerciodacidade.pt/theme/assets/img/payment/mbway-logo.png" class="img-fluid">
    </center>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">+351</span>
        </div>
        <input type="text" class="form-control" placeholder="Telemovel" id="nrtlm">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" onclick="submitMbway({{ $referencia }}, {{ $valor }})">Enviar</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
</div>