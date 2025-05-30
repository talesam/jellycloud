<?php
    // Define o diretório raiz
    define('DIR_ROOT', dirname(__DIR__) );

    // inclui o bootstrap
    require_once dirname( __DIR__ ) . "/public/bootstrap.php";

    // Altera o container de acordo com a URL
    $classContainer = "bg-white";
    if ( in_array( $uri, array_merge(PUBLIC_URLS, PUBLIC_URLS_BLOCK) ) ) {
        $classContainer = "flex-grow-1 d-flex flex-column h-100 justify-content-center align-items-center";
    }

    // Verifica se a página existe
    if ( !file_exists( DIR_ROOT . "/Pages/{$uriContent}/index.php" ) ) {
        $pageError = $uriContent;
        $uriContent = "page_error";
    }

    require_once DIR_ROOT . '/Pages/helper/View.php';
    $View = new View();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $_ENV[ 'APP_DESCRIPTION' ] ?>">
    <meta name="author" content="JellyCloud">
    <meta name="theme-color" content="#AA5CC3">
    <meta name="csrf-token" content="<?php echo $_SESSION[CSRF_TOKEN_NAME] ?? ''; ?>">
    <meta name="robots" content="index, follow">

    <!-- Meta tags de segurança -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self' data:;">
    
    <title>JellyCloud - <?= $_ENV[ 'APP_DESCRIPTION' ] ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/img/favicon/jellycloud-icon.svg">
    <link rel="manifest" href="/img/favicon/site.webmanifest">

    <!-- CSS -->
    <link rel="stylesheet" href="/css/font_awesome_free.all.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/general.css">
    
    <!-- JavaScript -->
    <script src="/js/inputmask.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js" defer></script>
    <script src="/js/general.js" defer></script>
</head>

<body class="h-100" style="background: var(--macos-bg);">
    <div id="corpo" class="container-fluid min-vh-100 d-flex flex-column" style="max-width: 1400px; margin: 0 auto;">
        <div id="content" class="flex-grow-1 d-flex flex-column h-100">

            <!-- Container Principal -->
            <div id="divContentContainer" class="<?= $classContainer; ?> fade-in">
                <?php require_once DIR_ROOT . "/Pages/{$uriContent}/index.php"; ?>
            </div>

            <!-- Toast de Alerta com estilo JellyCloud -->
            <div id="divAlertToast" class="toast-container position-fixed top-0 start-50 translate-middle-x p-3 z-index-1" style="width: 400px;">
                <div id="alertToast" class="toast w-100 border-0" role="alert" aria-live="assertive" aria-atomic="true" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);">
                    <div class="toast-header border-0 bg-gradient-jellyfin text-white" style="border-radius: var(--radius-lg) var(--radius-lg) 0 0;">
                        <i class="fas fa-info-circle me-2"></i>
                        <div class="w-100 text-center">
                            <strong>JellyCloud</strong>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Fechar"></button>
                    </div>
                    <div class="toast-body text-center fw-medium" id="alertMessage" style="color: var(--macos-text); padding: 1rem;"></div>
                </div>
            </div>
        </div>

        <footer id="divFooter" class="mt-auto pt-4 pb-3" style="background: linear-gradient(135deg, rgba(255,255,255,0.8) 0%, rgba(248,249,250,0.9) 100%); backdrop-filter: blur(20px); border-top: 1px solid var(--macos-border);">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 text-center text-md-start">
                        <p class="mb-0" style="color: var(--macos-text-secondary); font-size: 14px; font-weight: 500;">
                            &copy; <?= date('Y') ?> JellyCloud | <?= $_ENV["HTTP_HOST"] ?>
                        </p>
                    </div>
                    <div class="col-12 col-md-6 text-center text-md-end">
                        <p class="mb-0" style="color: var(--macos-text-tertiary); font-size: 13px;">
                            Feito com <i class="fas fa-heart text-jellyfin"></i> para a nuvem
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        <div id="divDebug" class="mt-auto">
            <?php if ( DEBUG ) require_once dirname(__DIR__) . "/Pages/debug/index.php"; ?>
        </div>
    </div>
</body>
</html>
<?php
$executionTime = round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 2);
echo "<!-- Tempo de carregamento: {$executionTime}ms -->";

if ( !isset($_SESSION['user']) ) : ?>
<script>
    sessionStorage.removeItem('user');
</script>
<?php endif; ?>
