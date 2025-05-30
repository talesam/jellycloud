<div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="card-macos p-4 slide-up">
                <?= $View->getHeaderSite( 'fa-user-plus', 'Cadastro' ); ?>
                
                <form id="formRegister" method="post" action="/api/cadastrar" class="needs-validation" novalidate>
                    <div class="mb-4">
                        <label for="name" class="form-label fw-medium" style="color: var(--macos-text-secondary);">Nome completo</label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute top-50 start-0 translate-middle-y ms-3 text-jellyfin"></i>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   class="form-control-macos ps-5" 
                                   placeholder="Seu nome completo" 
                                   required 
                                   autofocus>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label fw-medium" style="color: var(--macos-text-secondary);">E-mail</label>
                        <div class="position-relative">
                            <i class="fas fa-envelope position-absolute top-50 start-0 translate-middle-y ms-3 text-jellyfin"></i>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control-macos ps-5" 
                                   placeholder="seu@email.com" 
                                   required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label fw-medium" style="color: var(--macos-text-secondary);">Senha</label>
                        <div class="position-relative">
                            <i class="fas fa-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-jellyfin"></i>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control-macos ps-5 pe-5" 
                                   placeholder="Crie uma senha segura" 
                                   required>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer icon-hover" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="phone" class="form-label fw-medium" style="color: var(--macos-text-secondary);">
                            Telefone <span class="text-macos-tertiary">(opcional)</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-phone position-absolute top-50 start-0 translate-middle-y ms-3 text-jellyfin"></i>
                            <input type="tel" 
                                   name="phone" 
                                   id="phone" 
                                   class="form-control-macos ps-5" 
                                   placeholder="(11) 99999-9999" 
                                   data-inputmask="'mask': '(99) 99999-9999'">
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn-jellyfin">
                            <i class="fas fa-user-plus me-2"></i>Criar conta
                        </button>
                        
                        <a href="/login" class="btn-macos text-center">
                            <i class="fas fa-arrow-left me-2"></i>Voltar ao login
                        </a>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>

<script>
    // Inicializa a máscara do telefone
    Inputmask({
        mask: '(99) 99999-9999',
        clearIncomplete: true,
        showMaskOnHover: false
    }).mask(document.getElementById('phone'));

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

    document.getElementById('formRegister').addEventListener('submit', function(event) {
        event.preventDefault();
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;
        const activeCode = Math.floor(100000 + Math.random() * 900000);

        const buttons = this.querySelectorAll('button');
        buttons.forEach(button => {
            button.setAttribute('disabled', 'disabled');
            button.classList.add('disabled');
        });

        showLoading( 'divTitle' );
        fetch('/api/user/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ name: name, email: email, phone: phone, password: password, code_activation: activeCode })
        })
        .then( response => response.json() )
        .then(data => {
            sessionStorage.setItem( 'message', JSON.stringify( { message: data?.message, success: data?.success } ) );
            if (data.success) {
                setTimeout(() => { window.location.href = '/login'; }, 1500);
            } else {
                setTimeout(() => { window.location.reload(); }, 1500);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showAlert(error.message || 'Erro ao tentar cadastrar. Tente novamente.');
        });
    });
</script>
