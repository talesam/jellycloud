<div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
            <div class="card-macos p-4 slide-up">
                <?=  $View->getHeaderSite( 'fa-right-to-bracket', 'Login' ); ?>

                <form id="formLogin" method="post" action="/api/login" class="needs-validation" novalidate>
                    <div class="mb-4">
                        <label for="email" class="form-label fw-medium" style="color: var(--macos-text-secondary);">E-mail</label>
                        <div class="position-relative">
                            <i class="fas fa-envelope position-absolute top-50 start-0 translate-middle-y ms-3 text-jellyfin"></i>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control-macos ps-5" 
                                   placeholder="seu@email.com" 
                                   required 
                                   autofocus>
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
                                   placeholder="Sua senha" 
                                   required>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer icon-hover" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn-jellyfin">
                            <i class="fas fa-sign-in-alt me-2"></i>Entrar
                        </button>
                        
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="/cadastrar" class="btn-macos w-100 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user-plus me-2"></i>Cadastrar
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="/recuperar_senha" class="btn-macos w-100 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-unlock-alt me-2"></i>Recuperar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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

    document.getElementById('formLogin').addEventListener('submit', function(event) {
        event.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        showLoading( 'divTitle' );
        fetch('/api/login/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ email: email, password: password })
        })
        .then(async response => {
            const data = await response.json();
            data.status = response.status; // Adiciona o status ao objeto data
            return data;
        })
        .then(data => {
            if (data.success) {
                sessionStorage.setItem('user', JSON.stringify(data.user));
                sessionStorage.setItem('message', JSON.stringify({ message: data?.message, success: data?.success }));
                window.location.href = '/';
            } else {
                if ( data.status === 402 ) {
                    showAlert('Usuário necessitando de ativação!');
                    document.location.href = '/ativar'
                }
                showAlert(data.message || 'Erro ao fazer login');
            }
            hideLoading();
        })
        .catch(error => {
            showAlert(error.message || 'Erro ao fazer login. Tente novamente.');
        });
    });
</script>
