let contentLoading = { "id": "", "content": "" };

function showAlert(message, success = false) {
    // Verifica se o Bootstrap está carregado
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap não está carregado');
        return;
    }

    const toast = document.getElementById('alertToast');
    if (!toast) {
        console.error('Elemento alertToast não encontrado');
        return;
    }

    const toastBody = document.getElementById('alertMessage');
    if (!toastBody) {
        console.error('Elemento alertMessage não encontrado');
        return;
    }

    const toastHeader = toast.querySelector('.toast-header');
    if (!toastHeader) {
        console.error('Elemento toast-header não encontrado');
        return;
    }

    // Remove classes de cor anteriores
    toast.classList.remove('bg-success', 'bg-danger');
    toastHeader.classList.remove('bg-success', 'bg-danger');

    // Adiciona classes de cor baseado no sucesso
    if (success) {
        // toast.classList.add('bg-success-50');
        toastHeader.classList.add('bg-success-50');
    } else {
        // toast.classList.add('bg-danger-50');
        toastHeader.classList.add('bg-danger-50');
    }
    
    toastBody.textContent = message;
    const bsToast = new bootstrap.Toast(toast);
    // preciso aqui exibir o toast mas no tempo de 5 segundos
    bsToast._config.delay = 2000; // Define o tempo de exibição para 2 segundos
    bsToast.show();
    // console.log('Toast exibido com a mensagem:', message);
}

// Função para inicializar o toast
function initToast() {
    const message = sessionStorage.getItem('message');
    if (message) {
        try {
            const messageData = JSON.parse(message);
            showAlert(messageData.message, messageData.success);
        } catch (error) {
            console.error('Erro ao processar mensagem:', error);
            showAlert('Erro ao processar mensagem', false);
        } finally {
            sessionStorage.removeItem('message');
        }
    }
}

function showLoading( idElement ) {
    const loading = document.getElementById( idElement );
    if (loading) {
        contentLoading.id = idElement;
        contentLoading.content = loading.innerHTML; 
        loading.innerHTML = `
            <div class="spinner-jellyfin d-flex align-items-center justify-content-center">
                <div class="spinner-border text-jellyfin me-2" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <span class="text-muted small">Processando...</span>
            </div>
        `;
    }

    // Desabilita todos os botões do formulário
    const buttons = document.querySelectorAll('form button, .form-actions button, .auth-form button');
    buttons.forEach(button => {
        button.setAttribute('disabled', 'disabled');
        button.classList.add('disabled', 'opacity-50');
    });
}

function hideLoading() {
    if (contentLoading.id) {
        const loading = document.getElementById( contentLoading.id );
        if (loading && contentLoading.content) {
            loading.innerHTML = contentLoading.content;
        }
    }

    // Reabilita todos os botões
    const buttons = document.querySelectorAll('form button, .form-actions button, .auth-form button');
    buttons.forEach(button => {
        button.removeAttribute('disabled');
        button.classList.remove('disabled', 'opacity-50');
    });
    
    // Limpa o contentLoading
    contentLoading = { "id": "", "content": "" };
}

// Tenta novamente quando a página estiver completamente carregada
window.addEventListener('load', initToast );
window.addEventListener('load', hideLoading );