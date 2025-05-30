<?php
    require_once DIR_ROOT . '/Pages/helper/View.php';
    $View = new View();
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="/img/jellycloud-logo.svg" alt="JellyCloud" class="logo-image">
            </div>
            <h1 class="auth-title">Redefinir Senha</h1>
            <p class="auth-subtitle">
                Digite sua nova senha para concluir a recuperação
            </p>
        </div>

        <div class="alert alert-info-jellyfin" role="alert">
            <i class="fas fa-shield-alt me-2"></i>
            <div>
                <strong>Dicas de segurança:</strong>
                <ul class="mb-0 mt-2">
                    <li>Use pelo menos 8 caracteres</li>
                    <li>Combine letras maiúsculas e minúsculas</li>
                    <li>Inclua números e símbolos especiais</li>
                </ul>
            </div>
        </div>

        <form id="formResetarSenha" class="auth-form" method="POST" action="/api/user/resetPassword">
            <div class="form-group-jellyfin">
                <label for="code" class="form-label">Código de recuperação</label>
                <div class="input-group-jellyfin">
                    <span class="input-icon">
                        <i class="fas fa-key"></i>
                    </span>
                    <input type="text" class="form-control-macos text-center" id="code" name="code" 
                           value="<?= !empty( $arrUri[2] ) ? $arrUri[2] : ''; ?>"
                           placeholder="Código de recuperação" readonly required>
                </div>
            </div>

            <div class="form-group-jellyfin">
                <label for="email" class="form-label">E-mail</label>
                <div class="input-group-jellyfin">
                    <span class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" class="form-control-macos" id="email" name="email" 
                           placeholder="Digite seu e-mail" autofocus required>
                </div>
            </div>

            <div class="form-group-jellyfin">
                <label for="nova_senha" class="form-label">Nova senha</label>
                <div class="input-group-jellyfin">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" class="form-control-macos" id="nova_senha" name="nova_senha" 
                           placeholder="Digite sua nova senha" required>
                    <button type="button" class="input-action" id="togglePassword1">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="form-group-jellyfin">
                <label for="confirmar_senha" class="form-label">Confirmar nova senha</label>
                <div class="input-group-jellyfin">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" class="form-control-macos" id="confirmar_senha" name="confirmar_senha" 
                           placeholder="Confirme sua nova senha" required>
                    <button type="button" class="input-action" id="togglePassword2">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-jellyfin btn-lg">
                    <i class="fas fa-key me-2"></i>
                    Redefinir Senha
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
    // Toggle password visibility
    function setupPasswordToggle(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        
        if (toggle && input) {
            toggle.addEventListener('click', function() {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    }

    setupPasswordToggle('togglePassword1', 'nova_senha');
    setupPasswordToggle('togglePassword2', 'confirmar_senha');

    document.getElementById('formResetarSenha').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const email = document.getElementById('email').value;
        const novaSenha = document.getElementById('nova_senha').value;
        const confirmarSenha = document.getElementById('confirmar_senha').value;
        const code = document.getElementById('code').value;

        // Validar se as senhas coincidem
        if (novaSenha !== confirmarSenha) {
            showAlert('As senhas não coincidem. Por favor, verifique e tente novamente.', false);
            return;
        }

        // Validar força da senha
        if (novaSenha.length < 8) {
            showAlert('A senha deve ter pelo menos 8 caracteres.', false);
            return;
        }

        showLoading('divTitle');
        fetch('/api/user/resetPassword', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ email: email, password: novaSenha, code: code })
        })
        .then( response => response.json() )
        .then(data => {
            sessionStorage.setItem( 'message', JSON.stringify( { message: data?.message, success: data?.success } ) );
            if (data.success) {
                window.location.href = '/login';
            } else {
                window.location.reload();
            }
        })
        .catch(error => {
            showAlert(error.message || 'Erro ao redefinir senha. Tente novamente.');
        });
    });
</script>
