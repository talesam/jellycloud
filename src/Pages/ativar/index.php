<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="/img/jellycloud-logo.svg" alt="JellyCloud" class="logo-image">
            </div>
            <h1 class="auth-title">Ativar Conta</h1>
            <p class="auth-subtitle">
                Digite o código de ativação que foi enviado para seu e-mail
            </p>
        </div>

        <div class="alert alert-info-jellyfin" role="alert">
            <i class="fas fa-envelope me-2"></i>
            <div>
                <strong>Verifique seu e-mail:</strong>
                <ul class="mb-0 mt-2">
                    <li>O código foi enviado para o e-mail cadastrado</li>
                    <li>Verifique também a pasta de spam</li>
                    <li>O código expira em 24 horas</li>
                </ul>
            </div>
        </div>

        <form id="formActivate" class="auth-form" method="POST" action="/api/user/update">
            <div class="form-group-jellyfin">
                <label for="code" class="form-label">Código de ativação</label>
                <div class="input-group-jellyfin">
                    <span class="input-icon">
                        <i class="fas fa-key"></i>
                    </span>
                    <input type="text" class="form-control-macos text-center" id="code" name="code" 
                           value="<?= !empty( $arrUri[2] ) ? $arrUri[2] : ''; ?>"
                           placeholder="Digite o código de ativação" 
                           style="letter-spacing: 0.2em; font-weight: 600;"
                           autofocus required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-jellyfin btn-lg">
                    <i class="fas fa-check-circle me-2"></i>
                    Ativar Minha Conta
                </button>
                <a href="/login" class="btn-jellyfin-outline btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>
                    Voltar ao Login
                </a>
            </div>
        </form>

        <div class="auth-footer">
            <p class="text-center text-muted">
                Não recebeu o código? 
                <a href="/resend-code" class="text-jellyfin fw-medium">Reenviar código</a>
            </p>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    const codeActivation = document.getElementById('code');
    const email = sessionStorage.getItem('user') ? JSON.parse(sessionStorage.getItem('user')).email : '';


    document.getElementById('formActivate').addEventListener('submit', function(event) {
        event.preventDefault();
        const code = document.getElementById('code').value;

        fetch('/api/user/activateByCode', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ email: email, code: code })
        })
        .then(async response => {
            const data = await response.json();
            data.status = response.status; // Adiciona o status ao objeto data
            return data;
        })
        .then(data => {
            if (data.success) {
                sessionStorage.setItem('user', JSON.stringify(data.user));
                sessionStorage.setItem('message', JSON.stringify({ message: data?.message, success: data?.success }));
                window.location.href = '/login';
            } else {
                showAlert(data.message || 'Erro ao fazer login');
            }
        })
        .catch(error => {
            showAlert(error.message || 'Erro ao fazer login. Tente novamente.');
        });
    });
</script>
