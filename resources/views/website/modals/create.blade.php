<!-- Modal -->
<div class="modal fade" id="create_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="create_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="create_modal_label">Criar conta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/create-account" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="name_create">Nome</label>
                        <input type="text" name="name" id="name_create" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="email_create">Email</label>
                        <input type="email" name="email" id="email_create" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password_create">Password</label>
                        <input type="password" name="password" id="password_create" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password_confirmation_create">Confirmação da password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation_create"
                            class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Criar conta</button>
                </div>
            </form>
        </div>
    </div>
</div>