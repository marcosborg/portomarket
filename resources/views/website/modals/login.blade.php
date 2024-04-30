<!-- Modal -->
<div class="modal fade" id="login_modal" tabindex="-1" aria-labelledby="login_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="login_modal_label">Login</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/client-login" method="post" id="login_form">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-orange">Login</button>
                    <p><a href="#" data-bs-toggle="modal" data-bs-target="#create_modal">Ainda não tenho conta</a></p>
                    <p><a href="/recuperar-password">Recuperar password</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@section('scripts')
<script>
    $('#login_form').ajaxForm({
            beforeSubmit: () => {
                $.LoadingOverlay('show');
            },
            success: (resp) => {
                $.LoadingOverlay('hide');
                if(resp){
                    Swal.fire(
                        'Parabens!',
                        'Pode continuar!',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Credenciais inválidas!',
                        'Tente novamente!',
                        'danger'
                    );
                }
            },
            error: (error) => {
                $.LoadingOverlay('hide');
                console.log(error);
            }
        });
</script>
@endsection