<?php
/**
 * Arquivo: wp-content/themes/novoicode/page-login.php
 * Template Name: Página de Login Personalizada
 */
?>

<?php
error_log('🎯 ============ PÁGINA LOGIN CARREGADA ============');
error_log('🔗 Login Page - URL atual: ' . home_url($_SERVER['REQUEST_URI']));
error_log('📋 Login Page - GET params: ' . print_r($_GET, true));
error_log('📋 Login Page - SESSION: ' . print_r($_SESSION, true));
error_log('👤 Login Page - Usuário logado: ' . (is_user_logged_in() ? 'SIM' : 'NÃO'));
?>

<style>
    /* Reset para a página de login */
    .login-page {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-wrapper {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 420px;
        position: relative;
        overflow: hidden;
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-logo {
        height: 80px;
        margin-bottom: 15px;
        object-fit: cover;
    }

    .login-title {
        color: #126EEA;
        font-size: 32px;
        font-weight: bold;
        margin: 0 0 8px 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .login-subtitle {
        color: #666;
        margin: 0;
        font-size: 14px;
        font-weight: 500;
    }

    .login-options {
        margin-bottom: 20px;
    }

    .login-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: #333;
        border: 2px solid #e1e5e9;
        padding: 15px 20px;
        border-radius: 10px;
        text-decoration: none;
        width: 100%;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 15px;
        font-weight: 600;
    }

    .login-button:hover {
        border-color: #126EEA;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(18, 110, 234, 0.15);
        text-decoration: none;
        color: #333;
    }

    .login-button:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(18, 110, 234, 0.1);
    }

    .login-button img {
        width: 24px;
        height: 24px;
        margin-right: 12px;
        object-fit: contain;
    }

    .ic-login-fields {
        display: none;
        animation: fadeInUp 0.5s ease;
    }

    .ic-login-fields.show {
        display: block;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #126EEA;
        box-shadow: 0 0 0 3px rgba(18, 110, 234, 0.1);
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        cursor: pointer;
        color: #555;
    }

    .remember-me input {
        margin-right: 8px;
    }

    .lost-password {
        color: #126EEA;
        text-decoration: none;
        font-weight: 500;
    }

    .lost-password:hover {
        text-decoration: underline;
        color: #0d5fc1;
    }

    .login-submit {
        width: 100%;
        background: #126EEA;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
        position: relative;
    }

    .login-submit:hover {
        background: #0d5fc1;
        transform: translateY(-1px);
    }

    .login-submit:disabled {
        background: #cccccc;
        cursor: not-allowed;
        transform: none;
    }

    .alert {
        border: none;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
    }

    .recaptcha-info {
        font-size: 12px;
        color: #666;
        text-align: center;
        margin-top: 10px;
    }

    .grecaptcha-badge {
        visibility: hidden;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 480px) {
        .login-wrapper {
            padding: 30px 20px;
            margin: 10px;
        }

        .form-options {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .login-button {
            padding: 12px 16px;
            font-size: 14px;
        }
    }
</style>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ICODE</title>

    <!-- Bootstrap CSS -->
    <link href="<?php echo SITEPATH; ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="<?php echo SITEPATH; ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href="<?php echo SITEPATH; ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

    <!-- Remixicon -->
    <link href="<?php echo SITEPATH; ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="<?php echo SITEPATH; ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- CSS Customizado -->
    <link href="<?php echo SITEPATH; ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo SITEPATH; ?>assets/css/novoicode.css" rel="stylesheet">

    <!-- Favicon -->
    <link href="<?php echo get_option('portal_input_1'); ?>" rel="icon">

    <!-- Google reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_V3_SITE_KEY; ?>" async defer></script>
</head>

<body class="login-page">
    <div class="login-container">
        <div class="login-wrapper">
            <div class="login-header">
                <img src="<?php echo get_option('portal_input_1'); ?>" alt="Logo ICODE" class="login-logo">
                <h1 class="login-title">ICODE</h1>
                <p class="login-subtitle">Faça login em sua conta</p>
            </div>

            <div class="login-options">
                <!-- Botão Login Unicamp -->
                <a href="<?php echo esc_url(site_url('/googlelogin')); ?>?redirect_to=<?php echo urlencode(isset($_GET['redirect_to']) ? $_GET['redirect_to'] : '/perfil'); ?>"
                    class="login-button unicamp-login">
                    <img src="<?php echo SITEPATH; ?>assets/img/unicamp.png" alt="Unicamp">
                    <span>Login @unicamp, @dac</span>
                </a>

                <!-- Botão Login com IC -->
                <button type="button" class="login-button ic-login" id="toggle-ic-login">
                    <img src="<?php echo get_option('portal_input_1'); ?>" alt="IC">
                    <span>Login com LDAP-IC</span>
                </button>
            </div>

            <!-- Formulário de Login IC (inicialmente oculto) -->
            <div class="ic-login-fields" id="ic-login-fields">
                <form name="loginform" id="loginform"
                    action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>" method="post">
                    
                    <br>
                    <div class="form-group">
                        <input type="text" name="log" id="user_login" class="form-control" placeholder="Usuário IC"
                            required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="pwd" id="user_pass" class="form-control" placeholder="Senha IC"
                            required>
                    </div>

                    <!-- Campo hidden para o token reCAPTCHA -->
                    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

                    <input type="hidden" name="redirect_to"
                        value="<?php echo isset($_GET['redirect_to']) ? esc_url($_GET['redirect_to']) : '/perfil'; ?>">

                    <br>    
                    <button type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary login-submit">
                        <span id="submit-text">Entrar</span>
                        <div id="submit-loading" style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Verificando...
                        </div>
                    </button>

                    <div class="recaptcha-info">
                        Este site é protegido pelo reCAPTCHA e está sujeito à 
                        <a href="https://policies.google.com/privacy" target="_blank">Política de Privacidade</a> e 
                        <a href="https://policies.google.com/terms" target="_blank">Termos de Serviço</a> do Google.
                    </div>
                </form>
            </div>

            <?php
            // APENAS mensagem de erro de login (removida mensagem de logout)
            if (isset($_GET['login']) && $_GET['login'] == 'failed'): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> Erro no login. Verifique suas credenciais e tente novamente.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['recaptcha']) && $_GET['recaptcha'] == 'failed'): ?>
                <div class="alert alert-warning mt-3" role="alert">
                    <i class="bi bi-shield-exclamation"></i> Falha na verificação de segurança. Tente novamente.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo includes_url('js/jquery/jquery.js'); ?>"></script>

    <!-- Bootstrap JS -->
    <script src="<?php echo SITEPATH; ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mensagem no console indicando que o reCAPTCHA está ativo
        console.log('🔒 reCAPTCHA v3 está ativo no ICODE - Proteção contra bots habilitada');
        console.log('ℹ️ Site Key: <?php echo RECAPTCHA_V3_SITE_KEY; ?>');

        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('toggle-ic-login');
            const icFields = document.getElementById('ic-login-fields');
            let icVisible = false;

            toggleButton.addEventListener('click', function () {
                icVisible = !icVisible;

                if (icVisible) {
                    icFields.classList.add('show');
                    toggleButton.style.borderColor = '#126EEA';
                    toggleButton.style.backgroundColor = '#f8f9ff';

                    // Scroll suave para o formulário
                    setTimeout(() => {
                        icFields.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }, 300);

                    // Log quando o formulário é aberto
                    console.log('📝 Formulário de login LDAP-IC aberto');
                } else {
                    icFields.classList.remove('show');
                    toggleButton.style.borderColor = '#e1e5e9';
                    toggleButton.style.backgroundColor = 'white';
                    
                    console.log('📝 Formulário de login LDAP-IC fechado');
                }
            });

            // Validação do formulário com reCAPTCHA
            const loginForm = document.getElementById('loginform');
            if (loginForm) {
                loginForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const username = document.getElementById('user_login').value.trim();
                    const password = document.getElementById('user_pass').value.trim();
                    const submitBtn = document.getElementById('wp-submit');
                    const submitText = document.getElementById('submit-text');
                    const submitLoading = document.getElementById('submit-loading');

                    if (!username || !password) {
                        alert('Por favor, preencha todos os campos.');
                        return false;
                    }

                    // Desabilitar botão e mostrar loading
                    submitBtn.disabled = true;
                    submitText.style.display = 'none';
                    submitLoading.style.display = 'block';

                    console.log('🔄 Iniciando verificação reCAPTCHA para usuário: ' + username);

                    // Executar reCAPTCHA
                    grecaptcha.ready(function() {
                        grecaptcha.execute('<?php echo RECAPTCHA_V3_SITE_KEY; ?>', {action: 'login'}).then(function(token) {
                            console.log('✅ reCAPTCHA token gerado com sucesso');
                            
                            // Adicionar token ao formulário
                            document.getElementById('recaptchaResponse').value = token;
                            
                            // Re-enviar formulário
                            console.log('🚀 Enviando formulário de login...');
                            loginForm.submit();
                        }).catch(function(error) {
                            console.error('❌ Erro no reCAPTCHA:', error);
                            // Re-enable button on error
                            submitBtn.disabled = false;
                            submitText.style.display = 'block';
                            submitLoading.style.display = 'none';
                            alert('Erro na verificação de segurança. Tente novamente.');
                        });
                    });
                });
            }

            // Focar no campo de usuário quando o formulário for aberto
            toggleButton.addEventListener('click', function () {
                if (icVisible) {
                    setTimeout(() => {
                        document.getElementById('user_login')?.focus();
                    }, 400);
                }
            });

            // Executar reCAPTCHA quando o formulário for aberto (pré-carregamento)
            toggleButton.addEventListener('click', function() {
                if (icVisible) {
                    grecaptcha.ready(function() {
                        grecaptcha.execute('<?php echo RECAPTCHA_V3_SITE_KEY; ?>', {action: 'login'})
                            .then(function(token) {
                                console.log('🔧 reCAPTCHA pré-carregado para melhor performance');
                            })
                            .catch(function(error) {
                                console.warn('⚠️ Erro no pré-carregamento do reCAPTCHA:', error);
                            });
                    });
                }
            });

            // Verificar se o reCAPTCHA está carregado corretamente
            window.addEventListener('load', function() {
                if (typeof grecaptcha !== 'undefined') {
                    console.log('✅ reCAPTCHA v3 carregado com sucesso');
                } else {
                    console.error('❌ reCAPTCHA v3 não carregou corretamente');
                }
            });
        });
    </script>
</body>

</html>