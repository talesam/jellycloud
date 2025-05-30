<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="/img/jellycloud-logo.svg" alt="JellyCloud" class="logo-image">
            </div>
            <h1 class="auth-title text-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Página Não Encontrada
            </h1>
            <p class="auth-subtitle">
                Oops! A página que você está procurando não existe.
            </p>
        </div>

        <div class="alert alert-danger-jellyfin" role="alert">
            <i class="fas fa-search me-2"></i>
            <div>
                <strong>Página solicitada:</strong> 
                <code class="text-danger">"<?= sanitizeInput($pageError); ?>"</code>
                <ul class="mb-0 mt-2">
                    <li>Verifique se o endereço está correto</li>
                    <li>A página pode ter sido movida ou removida</li>
                    <li>Tente usar o menu de navegação</li>
                </ul>
            </div>
        </div>

        <div class="form-actions">
            <a href="/" class="btn-jellyfin btn-lg">
                <i class="fas fa-home me-2"></i>
                Voltar ao Início
            </a>
            <a href="javascript:history.back()" class="btn-jellyfin-outline btn-lg">
                <i class="fas fa-arrow-left me-2"></i>
                Página Anterior
            </a>
        </div>
    </div>
</div>