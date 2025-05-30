<div class="card-macos">
    <div class="card-header-jellyfin d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="fas fa-users text-white me-2"></i>
            <h5 class="mb-0 text-white fw-medium">
                Gerenciar Usuários
            </h5>
        </div>
        <div class="text-white-50 small">
            <i class="fas fa-info-circle me-1"></i>
            <span id="usersCount">0 usuários</span>
        </div>
    </div>
    <div class="card-body p-0"> 
        <div id="usersTable" class="users-table-container">
            <div class="table-responsive">
                <table id="usersList" class="table-jellyfin">
                    <thead class="table-header-jellyfin">
                        <tr>
                            <th class="text-center" style="width: 100px;">Ações</th>
                            <th style="min-width: 200px;">Nome</th>
                            <th style="min-width: 250px;">Email</th>
                            <th style="min-width: 150px;">Telefone</th>
                            <th class="text-center" style="width: 80px;">Status</th>
                            <th class="text-center" style="width: 100px;">Perfil</th>
                            <th style="min-width: 180px;">Criado em</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="spinner-jellyfin">
                                    <div class="spinner-border text-jellyfin" role="status">
                                        <span class="visually-hidden">Carregando...</span>
                                    </div>
                                </div>
                                <p class="text-muted mt-2">Carregando usuários...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Paginação -->
        <div class="pagination-container">
            <nav aria-label="Navegação de páginas">
                <ul class="pagination-jellyfin justify-content-center" id="pagination">
                    <!-- Os botões de paginação serão inseridos aqui via JavaScript -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-jellyfin">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-danger fw-semibold" id="deleteModalLabel">
                    <i class="fas fa-user-times me-2"></i>
                    Excluir Usuário
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger border-0" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Atenção!</strong> Esta ação não pode ser desfeita.
                </div>
                <p class="mb-0">
                    Tem certeza que deseja excluir o usuário <strong class="text-jellyfin" id="userName"></strong>?
                </p>
                <small class="text-muted">
                    Todos os arquivos e dados associados a este usuário serão removidos permanentemente.
                </small>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn-jellyfin-outline" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-user-times me-1"></i>
                    Sim, Excluir Usuário
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let userEmailToDelete = null;
    let currentPage = 1;
    const itemsPerPage = 10;

    // Função para carregar os usuários
    function loadUsers(page = 1) {
        currentPage = page;
        fetch(`/api/user/getList`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ page: page, limit: itemsPerPage })
        })
        .then( response => response.json() )
        .then(data => {
            const dataResponse = data.data;
            if (data.success === false) {
                throw new Error(data.message || 'Erro ao carregar usuários!');
            }
            if (!Array.isArray(dataResponse.users)) {
                throw new Error('Formato de dados inválido: lista de usuários não encontrada');
            }
            renderUsers(dataResponse.users);
            renderPagination(dataResponse.total, dataResponse.current_page, dataResponse.last_page);
        })
        .catch(error => {
            console.error('Erro:', error);
            showAlert(error.message || 'Erro ao carregar usuários. Por favor, tente novamente mais tarde.', false);
            // Limpa a tabela em caso de erro
            document.getElementById('usersList').innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Não foi possível carregar os usuários
                    </td>
                </tr>
            `;
            // Limpa a paginação
            document.getElementById('pagination').innerHTML = '';
        });
    }

    // Função para renderizar os usuários na tabela
    function renderUsers(users) {
        const tbody = document.getElementById('usersList').getElementsByTagName('tbody')[0];
        const usersCount = document.getElementById('usersCount');
        tbody.innerHTML = '';

        if (!Array.isArray(users) || users.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Nenhum usuário encontrado</p>
                        </div>
                    </td>
                </tr>
            `;
            if (usersCount) usersCount.textContent = '0 usuários';
            return;
        }

        // Atualiza contador
        if (usersCount) {
            usersCount.textContent = `${users.length} usuário${users.length !== 1 ? 's' : ''}`;
        }

        users.forEach(user => {
            const activeStatus = user.active 
                ? '<span class="badge-jellyfin-success"><i class="fas fa-check-circle me-1"></i>Ativo</span>'
                : '<span class="badge-jellyfin-danger"><i class="fas fa-times-circle me-1"></i>Inativo</span>';
            
            const roleLabel = user.role === 'admin' 
                ? '<span class="badge-jellyfin"><i class="fas fa-crown me-1"></i>Admin</span>'
                : '<span class="badge-jellyfin-outline"><i class="fas fa-user me-1"></i>Usuário</span>';

            tbody.innerHTML += `
                <tr class="table-row-jellyfin">
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn-action dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-jellyfin">
                                <li><a class="dropdown-item" href="#" onclick="activateUser('${user.email}')">
                                    <i class="fas fa-toggle-on text-jellyfin me-2"></i> Ativar/Desativar
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete('${user.email}', '${user.name}')">
                                    <i class="fas fa-trash me-2"></i> Excluir
                                </a></li>
                            </ul>
                        </div>
                    </td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-details">
                                <div class="user-name">${user.name}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="text-primary">${user.email}</span></td>
                    <td><span class="text-muted">${user.phone || 'Não informado'}</span></td>
                    <td class="text-center">${activeStatus}</td>
                    <td class="text-center">${roleLabel}</td>
                    <td>
                        <small class="text-muted">
                            ${new Date(user.created_at).toLocaleDateString('pt-BR')}
                            <br>
                            ${new Date(user.created_at).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'})}
                        </small>
                    </td>
                </tr>
            `;
        });
    }

    // Função para renderizar a paginação
    function renderPagination(total, currentPage, lastPage) {
        const pagination = document.getElementById('pagination');
        if (!pagination) {
            console.error('Elemento de paginação não encontrado!');
            return;
        }
        pagination.innerHTML = '';

        // Primeira página
        pagination.innerHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadUsers(1)" aria-label="Primeira">
                    <i class="fas fa-angle-double-left"></i>
                </a>
            </li>
        `;

        // Página anterior
        pagination.innerHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadUsers(${currentPage - 1})" aria-label="Anterior">
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>
        `;

        // Página atual
        pagination.innerHTML += `
            <li class="page-item active">
                <span class="page-link">Página ${currentPage} de ${lastPage}</span>
            </li>
        `;

        // Próxima página
        pagination.innerHTML += `
            <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadUsers(${currentPage + 1})" aria-label="Próxima">
                    <i class="fas fa-angle-right"></i>
                </a>
            </li>
        `;

        // Última página
        pagination.innerHTML += `
            <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadUsers(${lastPage})" aria-label="Última">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            </li>
        `;

        // Informações de paginação (agora no final)
        pagination.innerHTML += `
            <li class="page-item disabled">
                <span class="page-link">
                    <small>Total: ${total} registros</small>
                </span>
            </li>
        `;
    }

    function activateUser(email) {
        if (email) {
            fetch('/api/user/activate', {
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
                if (data.success) {
                    showAlert(data.message, data.success);
                    loadUsers(currentPage);
                } else {
                    showAlert(data.message || 'Erro ao tentar ativar/desativar usuário!');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('Erro ao tentar ativar/desativar usuário!', false);
            });
        }
    }

    function confirmDelete(email, name) {
        userEmailToDelete = email;
        document.getElementById('userName').textContent = name;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (userEmailToDelete) {
            fetch('/api/user/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ email: userEmailToDelete })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, data.success);
                    loadUsers(currentPage);
                } else {
                    showAlert(data.message || 'Erro ao tentar excluir usuário!');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('Erro ao tentar excluir usuário!', false);
            });

            // Fecha o modal
            const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            deleteModal.hide();
        }
    });

    // Carrega os usuários quando a página é carregada
    document.addEventListener('DOMContentLoaded', () => {
        loadUsers(1);
    });
</script>