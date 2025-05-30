<div class="card-macos">
    <div class="card-header-jellyfin d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="fas fa-cogs text-white me-2"></i>
            <h5 class="mb-0 text-white fw-medium">
                Configurações do Sistema
            </h5>
        </div>
        <div class="text-white-50 small">
            <i class="fas fa-shield-alt me-1"></i>
            Painel Administrativo
        </div>
    </div>
    <div class="card-body p-0">
        <div class="settings-container">
            <!-- Debug Setting -->
            <div class="setting-item">
                <div class="setting-icon">
                    <i class="fas fa-bug"></i>
                </div>
                <div class="setting-content">
                    <div class="setting-header">
                        <h6 class="setting-title">Modo Debug</h6>
                        <div class="setting-toggle">
                            <button class="btn-toggle <?= DEBUG ? 'active' : '' ?>" 
                                    onclick="showModalAdmin( '/api/configurations/toggledebug', { email: '<?= $_SESSION['user']['email'] ?>' } )">
                                <span class="toggle-slider"></span>
                            </button>
                        </div>
                    </div>
                    <p class="setting-description">
                        Ativa ou desativa o modo de depuração do sistema. Quando ativo, exibe informações detalhadas de debug.
                    </p>
                    <div class="setting-status">
                        <span class="badge-jellyfin<?= DEBUG ? '' : '-outline' ?>">
                            <i class="fas fa-<?= DEBUG ? 'check-circle' : 'times-circle' ?> me-1"></i>
                            <?= DEBUG ? 'Ativo' : 'Inativo' ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Site Lock Setting -->
            <div class="setting-item">
                <div class="setting-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="setting-content">
                    <div class="setting-header">
                        <h6 class="setting-title">Bloqueio do Sistema</h6>
                        <div class="setting-toggle">
                            <button class="btn-toggle <?= $config['block'] ? 'active' : '' ?>" 
                                    onclick="showModalAdmin( '/api/configurations/toggleblocksite', { email: '<?= $_SESSION['user']['email'] ?>' } )">
                                <span class="toggle-slider"></span>
                            </button>
                        </div>
                    </div>
                    <p class="setting-description">
                        Bloqueia o acesso ao sistema para usuários comuns. Apenas administradores podem acessar quando bloqueado.
                        Útil durante manutenções programadas.
                    </p>
                    <div class="setting-status">
                        <span class="badge-jellyfin<?= $config['block'] ? '-danger' : '-success' ?>">
                            <i class="fas fa-<?= $config['block'] ? 'shield-alt' : 'unlock' ?> me-1"></i>
                            <?= $config['block'] ? 'Bloqueado' : 'Liberado' ?>
                        </span>
                        <?php if ($config['block']): ?>
                        <div class="alert alert-warning mt-2 mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Atenção:</strong> Sistema bloqueado para usuários comuns
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
