<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="/img/jellycloud-logo.svg" alt="JellyCloud" class="logo-image">
            </div>
            <h1 class="auth-title">Recuperar Senha</h1>
            <p class="auth-subtitle">
                Digite seu e-mail para receber o link de recuperação
            </p>
        </div>

        <div class="alert alert-info-jellyfin" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <div>
                <strong>Instruções:</strong>
                <ul class="mb-0 mt-2">
                    <li>Verifique sua caixa de spam se não receber o e-mail</li>
                    <li>O link de recuperação expira em 1 hora</li>
                    <li>Entre em contato com o suporte se persistir o problema</li>
                </ul>
            </div>
        </div>

        <form id="formRecuperarSenha" class="auth-form" method="POST" action="/api/recuperar_senha">
            <div class="form-group-jellyfin">
                <label for="email" class="form-label">E-mail cadastrado</label>
                <div class="input-group-jellyfin">
                    <span class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" class="form-control-macos" id="email" name="email" 
                           placeholder="Digite seu e-mail" autofocus required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-jellyfin btn-lg">
                    <i class="fas fa-paper-plane me-2"></i>
                    Enviar Link de Recuperação
                </button>
                <a href="/login" class="btn-jellyfin-outline btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>
                    Voltar ao Login
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('formRecuperarSenha').addEventListener('submit', function(event) {
        event.preventDefault();
        const email = document.getElementById('email').value;

        showLoading('divTitle');
        fetch('/api/user/recoverPassword', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            sessionStorage.setItem('message', JSON.stringify({ message: data?.message, success: data?.success } ) );
            if (data.success) {
                window.location.href = '/login';
            } else {
                window.location.reload();
            }
        })
        .catch(error => {
            showAlert(error.message || 'Erro ao enviar e-mail de recuperação. Tente novamente.');
        });
    });
</script>