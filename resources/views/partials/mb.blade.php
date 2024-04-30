<div class="modal-body">
    <center>
        <img src="https://comerciodacidade.pt/theme/assets/img/payment/mb-logo.png" class="img-fluid">
        <table class="table">
            <tr>
                <th>Entidade</th>
                <td>{{ $entity }}</td>
            </tr>
            <tr>
                <th>Referência</th>
                <td>{{ $reference }}</td>
            </tr>
            <tr>
                <th>Valor</th>
                <td>€ {{ $amount }}</td>
            </tr>
        </table>
    </center>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    <button type="button" class="btn btn-primary" onclick="sendMbByEmail()">Receber por email</button>
</div>