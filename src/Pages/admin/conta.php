<?php
try {
    $Db = new \JellyCloud\Includes\Db();
    $res = $Db->query("SELECT * FROM users WHERE email = :email", ['email' => $_SESSION['user']['email']]);
    
    if (empty($res)) {
        throw new Exception('Usuário não encontrado.');
    }

    $user = $res[0];
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: /admin');
    exit;
}
?>

<div class="card-macos">
    <div class="card-header-jellyfin d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="fas fa-user-circle text-white me-2"></i>
            <h5 class="mb-0 text-white fw-medium">
                Meu Perfil
            </h5>
        </div>
        <div class="text-white-50 small">
            <i class="fas fa-calendar me-1"></i>
            Criado em <?= date('d/m/Y', strtotime($user['created_at'])) ?>
        </div>
    </div>
    <div class="card-body">
        <!-- User Profile Header -->
        <div class="profile-header mb-4">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h6 class="profile-name"><?= sanitizeInput($user['name']) ?></h6>
                <p class="profile-role">
                    <span class="badge-jellyfin<?= $user['role'] === 'admin' ? '' : '-outline' ?>">
                        <i class="fas fa-<?= $user['role'] === 'admin' ? 'crown' : 'user' ?> me-1"></i>
                        <?= ucfirst($user['role']) ?>
                    </span>
                </p>
            </div>
        </div>

        <form id="formAccount" method="post" action="/api/user/update">
            <div class="form-group-jellyfin">
                <label for="name" class="form-label">Nome completo</label>
                <div class="input-group-jellyfin">
                    <span class="input-icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" name="name" id="name" class="form-control-macos" 
                           placeholder="Digite seu nome completo" 
                           value="<?= sanitizeInput($user['name']) ?>" required>
                </div>
            </div>

            <div class="form-group-jellyfin">
                <label for="email" class="form-label">E-mail</label>
                <div class="input-group-jellyfin">
                    <span class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" class="form-control-macos" 
                           placeholder="Digite seu e-mail" 
                           value="<?= sanitizeInput($user['email']) ?>" required>
                </div>
            </div>

            <div class="form-group-jellyfin">
                <label for="password" class="form-label">Nova senha</label>
                <div class="input-group-jellyfin">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" id="password" class="form-control-macos" 
                           placeholder="Deixe em branco para manter a atual">
                    <button type="button" class="input-action" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Deixe em branco se não quiser alterar a senha
                </small>
            </div>

            <div class="form-group-jellyfin">
                <label for="phone" class="form-label">Telefone</label>
                <div class="input-group-jellyfin">
                    <span class="input-icon">
                        <i class="fas fa-phone"></i>
                    </span>
                    <input type="tel" name="phone" id="phone" class="form-control-macos" 
                           placeholder="(11) 99999-9999" 
                           value="<?= sanitizeInput($user['phone']) ?>" 
                           data-inputmask="'mask': '(99) 99999-9999'">
                </div>
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Campo opcional
                </small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-jellyfin btn-lg">
                    <i class="fas fa-save me-2"></i>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    document.getElementById('formAccount').addEventListener('submit', function(event) {
        event.preventDefault();
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const phone = document.getElementById('phone').value;

        fetch('/api/user/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ name, email, password, phone })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || `HTTP error! status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                sessionStorage.setItem('message', JSON.stringify({ message: data?.message, success: data?.success }));
                window.location.reload();
            } else {
                showAlert(data.message || 'Erro ao atualizar dados');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showAlert(error.message || 'Erro ao tentar atualizar dados. Tente novamente.');
        });
    });

    // Inicializa a máscara do telefone quando o DOM estiver pronto
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Inputmask !== 'undefined') {
            Inputmask({
                mask: '(99) 99999-9999',
                clearIncomplete: true,
                showMaskOnHover: false
            }).mask(document.getElementById('phone'));
        } else {
            console.error('Inputmask não está carregado');
        }
    });
</script>