<?php
    $userId = $_SESSION['user']['id'];

    require_once( DIR_ROOT . "/Pages/helper/Files.php" );

    $Files = new Files();
?>
<link rel="stylesheet" href="/css/drag-drop.css">
<div class="card-macos">
    <div class="card-header-jellyfin d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="fas fa-folder-open text-white me-2"></i>
            <h5 class="mb-0 text-white fw-medium">
                Gerenciador de Arquivos
            </h5>
        </div>
        <div class="d-flex gap-2">
            <button class="btn-jellyfin btn-sm" onclick="file('upload', '')" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="fas fa-upload me-1"></i>
                <span class="d-none d-sm-inline">Enviar</span>
            </button>
            <button class="btn-jellyfin-outline btn-sm" onclick="file('createSubdirectory', '')" data-bs-toggle="modal" data-bs-target="#createSubDirModal">
                <i class="fas fa-folder-plus me-1"></i>
                <span class="d-none d-sm-inline">Nova Pasta</span>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="file-manager-container">
            <?= $Files->listDirectoryTree( DIR_UPLOAD . "/{$userId}" ); ?>
        </div>
    </div>
</div>

<!-- Modal de Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-jellyfin">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-jellyfin fw-semibold" id="uploadModalLabel">
                    <i class="fas fa-cloud-upload-alt me-2"></i>
                    Enviar Arquivos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm">
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input-jellyfin" type="checkbox" id="uploadTypeSwitch">
                            <label class="form-check-label text-secondary" for="uploadTypeSwitch">
                                Upload de diretório completo
                            </label>
                        </div>
                        <small class="text-muted" id="uploadHelpText">
                            <i class="fas fa-info-circle me-1"></i>
                            Formatos aceitos: <?= $_ENV['ALLOWED_EXTENSIONS'] ?>
                        </small>
                    </div>
                    <div class="mb-3">
                        <div class="file-upload-area">
                            <input type="file" class="form-control-macos" id="fileInput" accept="<?= $_ENV['ALLOWED_EXTENSIONS'] ?>" required>
                        </div>
                    </div>
                    <div class="progress mb-3 d-none">
                        <div class="progress-bar bg-jellyfin" role="progressbar" style="width: 0%"></div>
                    </div>
                    <div class="upload-files-list mb-3 d-none">
                        <h6 class="text-jellyfin fw-medium">
                            <i class="fas fa-list-ul me-2"></i>
                            Arquivos sendo enviados:
                        </h6>
                        <ul class="list-group list-group-flush" id="uploadFilesList" style="max-height: 200px; overflow-y: auto;">
                        </ul>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn-jellyfin-outline" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="button" class="btn-jellyfin" id="uploadButton">
                    <i class="fas fa-upload me-1"></i>
                    Enviar Arquivos
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-jellyfin">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-danger fw-semibold" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="alert alert-warning border-0" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    Tem certeza que deseja excluir este item? Esta ação não pode ser desfeita.
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn-jellyfin-outline" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-trash me-1"></i>
                    Sim, Excluir
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Criação de Subdiretório -->
<div class="modal fade" id="createSubDirModal" tabindex="-1" aria-labelledby="createSubDirModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-jellyfin">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-jellyfin fw-semibold" id="createModalLabel">
                    <i class="fas fa-folder-plus me-2"></i>
                    Criar Nova Pasta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="createDirName" class="form-label text-secondary">Nome da pasta:</label>
                    <input type="text" class="form-control-macos" id="createDirName" placeholder="Digite o nome da nova pasta" autofocus required>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Use apenas letras, números, hífens e underscores
                    </small>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn-jellyfin-outline" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="button" class="btn-jellyfin" id="confirmCreate">
                    <i class="fas fa-folder-plus me-1"></i>
                    Criar Pasta
                </button>
            </div>
        </div>
    </div>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
<script>
    let currentPath = '<?= isset($_GET['path']) ? $_GET['path'] : '' ?>';
    const allowedExtensions = <?= json_encode( $_ENV['ALLOWED_EXTENSIONS'] ) ?>;

    document.addEventListener('hidden.bs.modal', function () {
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('modal-open');
        document.body.style = '';
    });

    // Só use bootstrap.Modal depois que o JS do Bootstrap foi carregado!
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('uploadModal'));
    modal.hide();
</script>
<script src="/js/files.js"></script>
<script src="/js/drag-drop.js"></script>