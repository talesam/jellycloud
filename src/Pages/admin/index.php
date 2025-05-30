<?php
    $uriAdminContent = isset( $arrUri[2] ) ? $arrUri[2] : "conta";
?>

<div class="container-fluid">
    <div class="card-macos p-0 fade-in">
        <!-- Header do Admin com gradiente Jellyfin -->
        <div class="bg-gradient-jellyfin text-white p-4" style="border-radius: var(--radius-lg) var(--radius-lg) 0 0;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <a href="/" class="me-4">
                        <img src="/img/jellycloud-logo.svg" alt="JellyCloud" style="max-width: 200px; filter: brightness(0) invert(1);">
                    </a>
                </div>
                <div class="text-end">
                    <div class="d-flex align-items-center gap-3">
                        <div class="cursor-pointer" title="<?= $_SESSION['user']['name']; ?>" onclick="window.location.href = '/admin/conta';">
                            <i class="fas fa-user me-2"></i>
                            <span class="fw-medium"><?= $_SESSION['user']['email']; ?></span>
                        </div>
                        <div class="vr" style="opacity: 0.5;"></div>
                        <div title="Último login" style="opacity: 0.9;">
                            <i class="fas fa-clock me-1"></i>
                            <span class="small"><?= date('d/m/Y H:i', strtotime($_SESSION['user']['last_login'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layout principal com sidebar e conteúdo -->
        <div class="d-flex" style="min-height: 600px;">
            <!-- Sidebar elegante -->
            <div id="divMenu" class="bg-macos-surface-secondary border-end p-3" style="width: 280px; border-color: var(--macos-border);">
                <nav class="d-flex flex-column gap-2">
                    <a href="/admin/conta" class="nav-link-jellyfin <?php echo $uriAdminContent === 'conta' ? 'active' : ''; ?>">
                        <i class="fas fa-user me-3"></i>
                        <span>Minha conta</span>
                    </a>

                    <?php if ( $_SESSION['user']['role'] === 'admin' ) : ?>
                        <a href="/admin/configuracoes" class="nav-link-jellyfin <?php echo $uriAdminContent === 'configuracoes' ? 'active' : ''; ?>">
                            <i class="fas fa-cogs me-3"></i>
                            <span>Configurações</span>
                        </a>
                    <?php endif; ?>

                    <a href="/admin/files" class="nav-link-jellyfin <?php echo $uriAdminContent === 'files' ? 'active' : ''; ?>">
                        <i class="fas fa-cloud me-3"></i>
                        <span>Meus arquivos</span>
                    </a>

                    <?php if ( $_SESSION['user']['role'] === 'admin' ) : ?>
                        <a href="/admin/usuarios" class="nav-link-jellyfin <?php echo $uriAdminContent === 'usuarios' ? 'active' : ''; ?>">
                            <i class="fas fa-users me-3"></i>
                            <span>Usuários</span>
                        </a>
                    <?php endif; ?>

                    <a href="#" onclick="showModalAdmin('/admin/sair'); return false;" class="mb-1 d-flex align-items-center btn 
                        <?php echo $uriAdminContent === 'sair' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                        <i class="fas fa-right-to-bracket me-1"></i>
                        <span class="mb-0">Sair</span>
                    </a>

                </div>
            </div>
            <div id="divContent" class="w-75 bg-white p-1">
                <?php
                    $file = dirname( __DIR__ ) . "/admin/{$uriAdminContent}.php";
                    if  ( file_exists( $file ) ) {
                        require_once $file;
                    } else {
                        echo "<div class='alert alert-warning'>Página não encontrada</div>";
                    }
                ?>
            </div>
        </div>

    </div>
</div>

<!-- Modal de Confirmação de Saída -->
<div id="divModalAdmin" role="dialog" aria-labelledby="logoutModalLabel" class="modal fade toast-container">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="divModalAdminHeader" class="modal-header bg-info-50 text-white">
                <i class="fa-solid text-white fa-triangle-exclamation me-2"></i>
                <h5 class="modal-title w-100 text-center" id="titleModalAdmin">Confirmar Saída</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div id="divModalAdminBody" class="modal-body">
                -
            </div>
            <div id="divModalAdminFooter" class="modal-footer">
                <button id="btnAdminCanel" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnAdminConfirm" type="button" class="btn btn-primary">Sim</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const adminModal = new bootstrap.Modal(document.getElementById('divModalAdmin'), { backdrop: 'static', keyboard: false });
        window.adminModal = adminModal;
    });

    function showModalAdmin(target, data = {} ) {
        const modalBody = document.getElementById('divModalAdminBody');
        const titleBody = document.getElementById('titleModalAdmin');

        switch (target) {
            case '/admin/sair':
                modalBody.textContent = 'Você tem certeza que deseja sair?';
                titleBody.textContent = 'Confirmar Saída'; 
                document.getElementById('btnAdminConfirm').onclick = function() {
                    window.location.href = target;
                }
                break;
            case '/api/configurations/toggleblocksite':
                modalBody.textContent = 'Você tem certeza que deseja Bloquear/Desbloquear o site?';
                titleBody.textContent = 'Bloquear/Desbloquear Site';
                document.getElementById('btnAdminConfirm').onclick = function() {
                    getAjaxAdmin( target, data );
                }
                break;
            case '/api/configurations/toggledebug':
                modalBody.textContent = 'Você tem certeza que deseja Ativar/Desativar o modo de depuração?';
                titleBody.textContent = 'Ativar/Desativar Depuração';
                document.getElementById('btnAdminConfirm').onclick = function() {
                    getAjaxAdmin( target, data );
                }
                break;
            default:
                modalBody.textContent = 'Você tem certeza de algo?';
        }

        adminModal.show();
        return false;
    }

    function getAjaxAdmin( url, data = {} ) {
        return fetch( url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify( data )
        } )
        .then( response => response.json() )
        .then(data => {
            if ( data.success ) {
                sessionStorage.setItem( 'message', JSON.stringify( { message: data?.message, success: data?.success } ) );
                window.location.reload();
            } else {
                adminModal.hide();
                showAlert(data.message, false);
            }
        })
    }
</script>