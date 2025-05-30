<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="/img/jellycloud-logo.svg" alt="JellyCloud" class="logo-image">
            </div>
            <h1 class="auth-title text-warning">
                <i class="fas fa-shield-alt me-2"></i>
                Sistema Bloqueado
            </h1>
            <p class="auth-subtitle">
                Digite a senha de administrador para desbloquear o sistema
            </p>
        </div>

        <div class="alert alert-warning-jellyfin" role="alert">
            <i class="fas fa-lock me-2"></i>
            <div>
                <strong>Acesso Restrito:</strong>
                <ul class="mb-0 mt-2">
                    <li>Sistema em modo de manutenção</li>
                    <li>Apenas administradores podem acessar</li>
                    <li>Digite a senha de administrador para continuar</li>
                </ul>
            </div>
        </div>

        <form id="formDesbloquear" class="auth-form" method="POST" action="/api/user/desbloquear">
            <div class="form-group-jellyfin">
                <label for="password" class="form-label">Senha de Administrador</label>
                <div class="input-group-jellyfin">
                    <span class="input-icon">
                        <i class="fas fa-key"></i>
                    </span>
                    <input type="password" class="form-control-macos" id="password" name="password" 
                           placeholder="Digite a senha de administrador" autofocus required>
                    <button type="button" class="input-action" id="toggleSenha">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-jellyfin btn-lg">
                    <i class="fas fa-unlock me-2"></i>
                    Desbloquear Sistema
                </button>
                <a href="/" class="btn-jellyfin-outline btn-lg">
                    <i class="fas fa-home me-2"></i>
                    Voltar ao Início
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('toggleSenha').addEventListener('click', function() {
        const senhaInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (senhaInput.type === 'password') {
            senhaInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            senhaInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    document.getElementById('formDesbloquear').addEventListener('submit', function(event) {
        event.preventDefault();
        const password = document.getElementById('password').value;

        if (!password.trim()) {
            showAlert('Por favor, digite a senha de administrador.', false);
            return;
        }

        showLoading('divTitle');
        fetch('/api/user/desbloquear', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ password: password })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                sessionStorage.setItem('message', JSON.stringify({ message: data?.message, success: data?.success }));
                setTimeout(() => {
                    window.location.href = '/';
                }, 1500);
            } else {
                showAlert(data.message || 'Senha de administrador incorreta. Tente novamente.', false);
                hideLoading();
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showAlert('Erro ao tentar desbloquear o sistema. Tente novamente.', false);
            hideLoading();
        });
    });
</script>
