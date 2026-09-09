<?php if (current_user_can('administrator')) { ?>

    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema ICODE - Documentação Técnica</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                line-height: 1.6;
                color: #333;
                background-color: #f8f9fa;
            }

            .container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 20px;
            }

            header {
                background: linear-gradient(135deg, #2c3e50, #3498db);
                color: white;
                padding: 2rem 0;
                margin-bottom: 2rem;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .header-content {
                text-align: center;
            }

            h1 {
                font-size: 2.5rem;
                margin-bottom: 0.5rem;
            }

            .subtitle {
                font-size: 1.2rem;
                opacity: 0.9;
            }

            .tab-content {
                background: white;
                padding: 2rem;
                border-radius: 0 10px 10px 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                min-height: 600px;
            }

            h2 {
                color: #2c3e50;
                border-bottom: 3px solid #3498db;
                padding-bottom: 0.5rem;
                margin-bottom: 1.5rem;
            }

            h3 {
                color: #34495e;
                margin: 1.5rem 0 1rem 0;
            }

            .grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 1.5rem;
                margin: 1.5rem 0;
            }

            .card {
                background: #f8f9fa;
                padding: 1.5rem;
                border-radius: 8px;
                border-left: 4px solid #3498db;
                transition: transform 0.2s;
            }

            .card:hover {
                transform: translateY(-2px);
            }

            .card h4 {
                color: #2c3e50;
                margin-bottom: 0.5rem;
            }

            .variable-list {
                list-style: none;
            }

            .variable-list li {
                background: white;
                margin: 0.5rem 0;
                padding: 1rem;
                border-radius: 6px;
                border: 1px solid #e9ecef;
            }

            .variable-name {
                font-weight: bold;
                color: #e74c3c;
                display: block;
                margin-bottom: 0.25rem;
            }

            .variable-desc {
                color: #666;
                font-size: 0.9rem;
            }

            .tech-stack {
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
                margin: 1rem 0;
            }

            .tech-item {
                background: #3498db;
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 20px;
                font-size: 0.9rem;
            }

            .auth-methods {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            .auth-card {
                background: #f8f9fa;
                padding: 1.5rem;
                border-radius: 8px;
                text-align: center;
            }

            .nav-tabs {
                border-bottom: 3px solid #3498db;
                display: none;
                /* Oculta as tabs originais */
            }

            .nav-tabs .nav-link {
                border: none;
                color: #2c3e50;
                font-weight: 500;
                padding: 1rem 1.5rem;
                transition: all 0.3s;
            }

            .nav-tabs .nav-link:hover {
                background-color: #e9ecef;
                border: none;
            }

            .nav-tabs .nav-link.active {
                background-color: #3498db;
                color: white;
                border: none;
                border-radius: 8px 8px 0 0;
            }

            code {
                background: #2c3e50;
                color: #ecf0f1;
                padding: 0.2rem 0.4rem;
                border-radius: 3px;
                font-family: 'Courier New', monospace;
            }

            pre {
                background: #2c3e50;
                color: #ecf0f1;
                padding: 1rem;
                border-radius: 5px;
                overflow-x: auto;
            }

            h2 span {
                font-size: 15px;
                float: right;
                margin-top: 15px;
            }

            /* Novos estilos para os dropdowns */
            .dropdown-nav {
                display: flex;
                gap: 1rem;
                margin-bottom: 1rem;
                flex-wrap: wrap;
            }

            .dropdown-nav .dropdown {
                flex: 1;
                min-width: 200px;
            }

            .dropdown-nav .dropdown-toggle {
                width: 100%;
                text-align: left;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: #3498db;
                color: white;
                border: none;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                transition: all 0.3s;
                font-weight: 600;
                font-size: 1.1rem;
            }

            .dropdown-nav .dropdown-toggle:hover {
                background: #2980b9;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .dropdown-nav .dropdown-menu {
                width: 100%;
                max-height: 500px;
                overflow-y: auto;
                border: none;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }

            .dropdown-nav .dropdown-item {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #f8f9fa;
                transition: all 0.2s;
                color: #2c3e50;
            }

            .dropdown-nav .dropdown-item:hover {
                background: #e9ecef;
                color: #2c3e50;
                transform: translateX(5px);
            }

            .dropdown-nav .dropdown-item.active {
                background: #3498db;
                color: white;
            }

            .current-section {
                background: #e8f4fd;
                padding: 0.75rem 1rem;
                border-radius: 5px;
                margin-top: 0.5rem;
                font-size: 0.9rem;
                color: #2c3e50;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                border-left: 4px solid #3498db;
            }

            h2 span {
                font-size: 15px;
                float: right;
                margin-top: 15px;
            }

            @media (max-width: 768px) {
                .auth-methods {
                    grid-template-columns: 1fr;
                }

                .grid {
                    grid-template-columns: 1fr;
                }

                h1 {
                    font-size: 2rem;
                }

                .dropdown-nav {
                    flex-direction: column;
                }

                .dropdown-nav .dropdown {
                    min-width: 100%;
                }
            }

            /* Botão Scroll Up */
            .scroll-top-btn {
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 50px;
                height: 50px;
                background: #3498db;
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 1.5rem;
                cursor: pointer;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .scroll-top-btn:hover {
                background: #2980b9;
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(52, 152, 219, 0.4);
            }

            .scroll-top-btn.show {
                opacity: 1;
                visibility: visible;
            }

            /* Responsivo */
            @media (max-width: 768px) {
                .scroll-top-btn {
                    bottom: 20px;
                    right: 20px;
                    width: 45px;
                    height: 45px;
                    font-size: 1.3rem;
                }
            }
        </style>


    </head>

    <body>
        <div class="container">

            <!-- Botão Scroll Up -->
            <button id="scrollTopBtn" class="scroll-top-btn" title="Voltar ao topo">
                <i class="bi bi-caret-up-square"></i>
            </button>

            <header>
                <div class="header-content">
                    <h1>🖥️ Sistema ICODE</h1>
                    <p class="subtitle">Plataforma de Gestão de Conteúdos dos Colegiados do IC</p>
                </div>
            </header>

            <!-- ===== NOVO MENU DROPDOWN ===== -->
            <div class="dropdown-nav">
                <!-- Botão NOVOICODE -->
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-layers me-2"></i>Sobre o Sistema</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="showTab('introducao')">
                                <i class="bi bi-info-circle"></i>Introdução
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('colegiados')">
                                <i class="bi bi-building"></i>Colegiados
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('autenticacao')">
                                <i class="bi bi-shield-lock"></i>Autenticação
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('arquitetura')">
                                <i class="bi bi-diagram-3"></i>Arquitetura
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('variaveis-globais')">
                                <i class="bi bi-gear"></i>Variáveis
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('htaccess')">
                                <i class="bi bi-file-earmark-code"></i>.htaccess
                            </a></li>
                    </ul>
                </div>

                <!-- Botão PLUGIN -->
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-plug me-2"></i>Plugin novoicode</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="showTab('plugin-novoicode')">
                                <i class="bi bi-plug"></i>Sobre o Plugin
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('admin-pages')">
                                <i class="bi bi-layout-text-window"></i>Plugin/AdminPages
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('admin-settings')">
                                <i class="bi bi-sliders"></i>Plugin/Settings
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('pdf-parser')">
                                <i class="bi bi-file-pdf"></i>Plugin/PDFParser
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('sistema-categorias-ano')">
                                <i class="bi bi-calendar"></i>Plugin/Categorias
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('frontend')">
                                <i class="bi bi-layout-text-sidebar"></i>Plugin/Frontend
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('login')">
                                <i class="bi bi-key"></i>Plugin/Login
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('pdf')">
                                <i class="bi bi-file-earmark-pdf"></i>Plugin/PDF
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('permalink')">
                                <i class="bi bi-link-45deg"></i>Plugin/Permalink
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('types')">
                                <i class="bi bi-grid-3x3-gap"></i>Plugin/Types
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('user')">
                                <i class="bi bi-people"></i>Plugin/User
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('usermeta')">
                                <i class="bi bi-person-badge"></i>Plugin/Usermeta
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('functions')">
                                <i class="bi bi-gear"></i>Plugin/Functions
                            </a></li>
                    </ul>
                </div>

                <!-- Botão THEME -->
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-palette me-2"></i>Theme novoicode</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-style')">
                                <i class="bi bi-palette"></i>Sobre o Tema
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-header')">
                                <i class="bi bi-layout-sidebar-inset"></i>Tema/Header
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-footer')">
                                <i class="bi bi-layout-sidebar-inset-reverse"></i>Tema/Footer
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-archive')">
                                <i class="bi bi-archive"></i>Tema/Archive
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-category')">
                                <i class="bi bi-folder"></i>Tema/Category
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-single')">
                                <i class="bi bi-file-text"></i>Tema/Single
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-frontpage')">
                                <i class="bi bi-house"></i>Tema/FrontPage
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-search')">
                                <i class="bi bi-search"></i>Tema/Search
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-calendarios')">
                                <i class="bi bi-calendar"></i>Tema/Page-Calendarios
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-perfil')">
                                <i class="bi bi-person"></i>Tema/Page-Perfil
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-pessoas')">
                                <i class="bi bi-people"></i>Tema/Page-Pessoas
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-relatoriofinanceiro')">
                                <i class="bi bi-graph-up"></i>Tema/Page-Financeiro
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-sobre')">
                                <i class="bi bi-info-circle"></i>Tema/Page-Sobre
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-login')">
                                <i class="bi bi-key"></i>Tema/Page-Login
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-googlelogin')">
                                <i class="bi bi-google"></i>Tema/Page-GoogleLogin
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-novo')">
                                <i class="bi bi-plus-circle"></i>Tema/Page-Novo
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-editar')">
                                <i class="bi bi-pencil-square"></i>Tema/Page-Editar
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-share')">
                                <i class="bi bi-share"></i>Tema/Page-Share
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-arquivos')">
                                <i class="bi bi-folder"></i>Tema/Page-Arquivos
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-page-chatgemini')">
                                <i class="bi bi-robot"></i>Tema/Page-ChatGemini
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="showTab('theme-component-chats')">
                                <i class="bi bi-chat-dots"></i>Tema/Component-Chats
                            </a></li>
                    </ul>
                </div>
            </div>

            <!-- Indicador da seção atual -->
            <div class="current-section">
                <i class="bi bi-eye"></i>
                <span id="currentSection">Visualizando: Introdução</span>
            </div>

            <!-- ===== TABS ORIGINAIS (OCULTAS) ===== -->
            <ul class="nav nav-tabs" id="icodeTabs" role="tablist">

                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="introducao-tab" data-bs-toggle="tab" data-bs-target="#introducao"
                        type="button" role="tab" aria-controls="introducao" aria-selected="true">
                        <i class="bi bi-info-circle me-2"></i>Introdução
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="colegiados-tab" data-bs-toggle="tab" data-bs-target="#colegiados"
                        type="button" role="tab" aria-controls="colegiados" aria-selected="false">
                        <i class="bi bi-building me-2"></i>Colegiados
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="autenticacao-tab" data-bs-toggle="tab" data-bs-target="#autenticacao"
                        type="button" role="tab" aria-controls="autenticacao" aria-selected="false">
                        <i class="bi bi-shield-lock me-2"></i>Autenticação
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="arquitetura-tab" data-bs-toggle="tab" data-bs-target="#arquitetura"
                        type="button" role="tab" aria-controls="arquitetura" aria-selected="false">
                        <i class="bi bi-diagram-3 me-2"></i>Arquitetura
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="variaveis-tab" data-bs-toggle="tab" data-bs-target="#variaveis-globais"
                        type="button" role="tab" aria-controls="variaveis-globais" aria-selected="false">
                        <i class="bi bi-gear me-2"></i>Variáveis
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="htaccess-tab" data-bs-toggle="tab" data-bs-target="#htaccess" type="button"
                        role="tab" aria-controls="htaccess" aria-selected="false">
                        <i class="bi bi-file-earmark-code me-2"></i>.htaccess
                    </button>
                </li>

                <!-- ===== NOVOICODE PLUGIN TABS -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="plugin-tab" data-bs-toggle="tab" data-bs-target="#plugin-novoicode"
                        type="button" role="tab" aria-controls="plugin-novoicode" aria-selected="false">
                        <i class="bi bi-plug me-2"></i>Plugin
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="admin-pages-tab" data-bs-toggle="tab" data-bs-target="#admin-pages"
                        type="button" role="tab" aria-controls="admin-pages" aria-selected="false">
                        <i class="bi bi-layout-text-window me-2"></i>Plugin/AdminPages
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#admin-settings"
                        type="button" role="tab" aria-controls="admin-settings" aria-selected="false">
                        <i class="bi bi-sliders me-2"></i>Plugin/Settings
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pdf-parser-tab" data-bs-toggle="tab" data-bs-target="#pdf-parser"
                        type="button" role="tab" aria-controls="pdf-parser" aria-selected="false">
                        <i class="bi bi-file-pdf me-2"></i>Plugin/PDFParser
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="categorias-tab" data-bs-toggle="tab"
                        data-bs-target="#sistema-categorias-ano" type="button" role="tab"
                        aria-controls="sistema-categorias-ano" aria-selected="false">
                        <i class="bi bi-calendar me-2"></i>Plugin/Categorias
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="frontend-tab" data-bs-toggle="tab" data-bs-target="#frontend" type="button"
                        role="tab" aria-controls="frontend" aria-selected="false">
                        <i class="bi bi-layout-text-sidebar me-2"></i>Plugin/Frontend
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
                        role="tab" aria-controls="login" aria-selected="false">
                        <i class="bi bi-key me-2"></i>Plugin/Login
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pdf-tab" data-bs-toggle="tab" data-bs-target="#pdf" type="button"
                        role="tab" aria-controls="pdf" aria-selected="false">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Plugin/PDF
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="permalink-tab" data-bs-toggle="tab" data-bs-target="#permalink"
                        type="button" role="tab" aria-controls="permalink" aria-selected="false">
                        <i class="bi bi-link-45deg me-2"></i>Plugin/Permalink
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="types-tab" data-bs-toggle="tab" data-bs-target="#types" type="button"
                        role="tab" aria-controls="types" aria-selected="false">
                        <i class="bi bi-grid-3x3-gap me-2"></i>Plugin/Types
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user" type="button"
                        role="tab" aria-controls="user" aria-selected="false">
                        <i class="bi bi-people me-2"></i>Plugin/User
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="usermeta-tab" data-bs-toggle="tab" data-bs-target="#usermeta" type="button"
                        role="tab" aria-controls="usermeta" aria-selected="false">
                        <i class="bi bi-person-badge me-2"></i>Plugin/Usermeta
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="functions-tab" data-bs-toggle="tab" data-bs-target="#functions"
                        type="button" role="tab" aria-controls="functions" aria-selected="false">
                        <i class="bi bi-gear me-2"></i>Plugin/Functions
                    </button>
                </li>

                <!-- ===== NOVOICODE THEME TABS -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-style-tab" data-bs-toggle="tab" data-bs-target="#theme-style"
                        type="button" role="tab" aria-controls="theme-style" aria-selected="false">
                        <i class="bi bi-palette me-2"></i>Tema
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-header-tab" data-bs-toggle="tab" data-bs-target="#theme-header"
                        type="button" role="tab" aria-controls="theme-header" aria-selected="false">
                        <i class="bi bi-layout-sidebar-inset me-2"></i>Tema/Header
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-footer-tab" data-bs-toggle="tab" data-bs-target="#theme-footer"
                        type="button" role="tab" aria-controls="theme-footer" aria-selected="false">
                        <i class="bi bi-layout-sidebar-inset-reverse me-2"></i>Tema/Footer
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-archive-tab" data-bs-toggle="tab" data-bs-target="#theme-archive"
                        type="button" role="tab" aria-controls="theme-archive" aria-selected="false">
                        <i class="bi bi-archive me-2"></i>Tema/Archive
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-category-tab" data-bs-toggle="tab" data-bs-target="#theme-category"
                        type="button" role="tab" aria-controls="theme-category" aria-selected="false">
                        <i class="bi bi-folder me-2"></i>Tema/Category
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-single-tab" data-bs-toggle="tab" data-bs-target="#theme-single"
                        type="button" role="tab" aria-controls="theme-single" aria-selected="false">
                        <i class="bi bi-file-text me-2"></i>Tema/Single
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-frontpage-tab" data-bs-toggle="tab" data-bs-target="#theme-frontpage"
                        type="button" role="tab" aria-controls="theme-frontpage" aria-selected="false">
                        <i class="bi bi-house me-2"></i>Tema/FrontPage
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-search-tab" data-bs-toggle="tab" data-bs-target="#theme-search"
                        type="button" role="tab" aria-controls="theme-search" aria-selected="false">
                        <i class="bi bi-search me-2"></i>Tema/Search
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-calendarios-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-page-calendarios" type="button" role="tab"
                        aria-controls="theme-page-calendarios" aria-selected="false">
                        <i class="bi bi-calendar me-2"></i>Tema/Page-Calendarios
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-perfil-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-page-perfil" type="button" role="tab" aria-controls="theme-page-perfil"
                        aria-selected="false">
                        <i class="bi bi-person me-2"></i>Tema/Page-Perfil
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-pessoas-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-page-pessoas" type="button" role="tab" aria-controls="theme-page-pessoas"
                        aria-selected="false">
                        <i class="bi bi-people me-2"></i>Tema/Page-Pessoas
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-relatoriofinanceiro-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-page-relatoriofinanceiro" type="button" role="tab"
                        aria-controls="theme-page-relatoriofinanceiro" aria-selected="false">
                        <i class="bi bi-graph-up me-2"></i>Tema/Page-Financeiro
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-sobre-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-page-sobre" type="button" role="tab" aria-controls="theme-page-sobre"
                        aria-selected="false">
                        <i class="bi bi-info-circle me-2"></i>Tema/Page-Sobre
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-login-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-page-login" type="button" role="tab" aria-controls="theme-page-login"
                        aria-selected="false">
                        <i class="bi bi-key me-2"></i>Tema/Page-Login
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-googlelogin-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-page-googlelogin" type="button" role="tab"
                        aria-controls="theme-page-googlelogin" aria-selected="false">
                        <i class="bi bi-google me-2"></i>Tema/Page-GoogleLogin
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-novo-tab" data-bs-toggle="tab" data-bs-target="#theme-page-novo"
                        type="button" role="tab" aria-controls="theme-page-novo" aria-selected="false">
                        <i class="bi bi-plus-circle me-2"></i>Tema/Page-Novo
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-editar-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-page-editar" type="button" role="tab" aria-controls="theme-page-editar"
                        aria-selected="false">
                        <i class="bi bi-pencil-square me-2"></i>Tema/Page-Editar
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-share-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-page-share" type="button" role="tab" aria-controls="theme-page-share"
                        aria-selected="false">
                        <i class="bi bi-share me-2"></i>Tema/Page-Share
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-arquivos-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-page-arquivos" type="button" role="tab" aria-controls="theme-page-arquivos"
                        aria-selected="false">
                        <i class="bi bi-folder me-2"></i>Tema/Page-Arquivos
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-page-chatgemini-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-page-chatgemini" type="button" role="tab"
                        aria-controls="theme-page-chatgemini" aria-selected="false">
                        <i class="bi bi-robot me-2"></i>Tema/Page-ChatGemini
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="theme-component-chats-tab" data-bs-toggle="tab"
                        data-bs-target="#theme-component-chats" type="button" role="tab"
                        aria-controls="theme-component-chats" aria-selected="false">
                        <i class="bi bi-chat-dots me-2"></i>Tema/Component-Chats
                    </button>
                </li>

            </ul>


            <!-- ===== TABS CONTENT ===== -->
            <div class="tab-content" id="icodeTabContent">

                <!-- Tab Introdução -->
                <div class="tab-pane fade show active" id="introducao" role="tabpanel" aria-labelledby="introducao-tab">
                    <h2>📋 Introdução</h2>
                    <p>O <strong>Sistema ICODE</strong> é uma plataforma web desenvolvida pelo Instituto de Computação (IC)
                        da Universidade Estadual de Campinas (Unicamp) para gerenciamento centralizado de conteúdos e
                        documentos dos colegiados do instituto.</p>

                    <h3>🎯 Objetivo</h3>
                    <p>Servir como um repositório unificado e sistema de gestão para as principais entidades do IC,
                        garantindo segurança, controle de acesso e uma experiência adaptada aos processos institucionais.
                    </p>
                </div>

                <!-- Tab Colegiados -->
                <div class="tab-pane fade" id="colegiados" role="tabpanel" aria-labelledby="colegiados-tab">
                    <h2>🏛️ Colegiados Atendidos</h2>
                    <div class="grid">
                        <div class="card">
                            <h4>Congregação</h4>
                            <p>Órgão máximo deliberativo do instituto</p>
                        </div>
                        <div class="card">
                            <h4>Conselho Interdepartamental (CI)</h4>
                            <p>Conselho responsável pela integração entre departamentos</p>
                        </div>
                        <div class="card">
                            <h4>Departamento de Sistema de Computação (DSC)</h4>
                        </div>
                        <div class="card">
                            <h4>Departamento de Sistemas de Informação (DSI)</h4>
                        </div>
                        <div class="card">
                            <h4>Departamento de Teoria de Computação (DTC)</h4>
                        </div>
                        <div class="card">
                            <h4>Comissão Diretora de Informática (CDI)</h4>
                            <p>Comissão responsável pela infraestrutura de TI</p>
                        </div>
                    </div>
                </div>


                <!-- Tab Autenticação -->
                <div class="tab-pane fade" id="autenticacao" role="tabpanel" aria-labelledby="autenticacao-tab">
                    <h2>🔐 Sistema de Autenticação</h2>
                    <div class="auth-methods">
                        <div class="auth-card">
                            <h4>🎓 Contas Unicamp/DAC</h4>
                            <p>Utilizando o sistema SISE de autenticação central</p>
                        </div>
                        <div class="auth-card">
                            <h4>💻 Conta IC</h4>
                            <p>Através do LDAP interno do Instituto de Computação</p>
                        </div>
                    </div>
                    <p><strong>Acesso restrito:</strong> O sistema possui controle granular de permissões baseado nos
                        colegiados e funções dos usuários.</p>
                </div>


                <!-- Tab Arquitetura -->
                <div class="tab-pane fade" id="arquitetura" role="tabpanel" aria-labelledby="arquitetura-tab">
                    <h2>🏗️ Arquitetura Técnica</h2>

                    <h3>🔄 Plataforma Base</h3>
                    <p>Desenvolvido sobre <strong>WordPress</strong> como plataforma base, aproveitando sua robustez e
                        flexibilidade.</p>

                    <h3>🎨 Customizações</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>Plugin Personalizado</h4>
                            <code>/wp-content/plugins/novoicode/</code>
                        </div>
                        <div class="card">
                            <h4>Tema Customizado</h4>
                            <code>/wp-content/themes/novoicode/</code>
                        </div>
                    </div>

                    <h3>🛠️ Stack Tecnológico</h3>
                    <div class="tech-stack">
                        <span class="tech-item">HTML 5</span>
                        <span class="tech-item">CSS 3</span>
                        <span class="tech-item">JavaScript</span>
                        <span class="tech-item">React</span>
                        <span class="tech-item">PHP 8</span>
                        <span class="tech-item">WordPress 6</span>
                        <span class="tech-item">MySQL 8</span>
                    </div>

                    <h3>📦 Dependências Externas</h3>
                    <p>Utiliza apenas o plugin <strong>classic-editor</strong> como dependência externa. Não são utilizados
                        temas ou plugins comerciais de terceiros.</p>
                </div>


                <!-- Tab Variáveis Globais -->
                <div class="tab-pane fade" id="variaveis-globais" role="tabpanel" aria-labelledby="variaveis-tab">
                    <h2>⚙️ Variáveis Globais do Sistema</h2>
                    <p>Configurações definidas no arquivo <code>wp-config.php</code></p>

                    <h3>🔧 Configurações Básicas do WordPress</h3>
                    <ul class="variable-list">
                        <li>
                            <span class="variable-name">WP_HOME</span>
                            <span class="variable-desc">URL base do site WordPress</span>
                        </li>
                        <li>
                            <span class="variable-name">WP_SITEURL</span>
                            <span class="variable-desc">URL do core do WordPress</span>
                        </li>
                        <li>
                            <span class="variable-name">FS_METHOD</span>
                            <span class="variable-desc">Método de acesso ao sistema de arquivos</span>
                        </li>
                    </ul>

                    <h3>🗄️ Configuração de Banco de Dados</h3>
                    <ul class="variable-list">
                        <li>
                            <span class="variable-name">DB_NAME</span>
                            <span class="variable-desc">Nome do banco de dados</span>
                        </li>
                        <li>
                            <span class="variable-name">DB_USER</span>
                            <span class="variable-desc">Usuário do banco de dados</span>
                        </li>
                        <li>
                            <span class="variable-name">DB_PASSWORD</span>
                            <span class="variable-desc">Senha do banco de dados</span>
                        </li>
                        <li>
                            <span class="variable-name">DB_HOST</span>
                            <span class="variable-desc">Host do servidor de banco de dados</span>
                        </li>
                        <li>
                            <span class="variable-name">DB_CHARSET</span>
                            <span class="variable-desc">Charset utilizado no banco de dados</span>
                        </li>
                    </ul>

                    <h3>📧 Configuração de E-mail (SMTP)</h3>
                    <ul class="variable-list">
                        <li>
                            <span class="variable-name">SMTP_USER</span>
                            <span class="variable-desc">Usuário do servidor SMTP</span>
                        </li>
                        <li>
                            <span class="variable-name">SMTP_PASS</span>
                            <span class="variable-desc">Senha do servidor SMTP</span>
                        </li>
                        <li>
                            <span class="variable-name">SMTP_HOST</span>
                            <span class="variable-desc">Host do servidor SMTP</span>
                        </li>
                        <li>
                            <span class="variable-name">SMTP_PORT</span>
                            <span class="variable-desc">Porta do servidor SMTP</span>
                        </li>
                        <li>
                            <span class="variable-name">SMTP_SECURE</span>
                            <span class="variable-desc">Tipo de segurança (SSL/TLS)</span>
                        </li>
                        <li>
                            <span class="variable-name">SMTP_FROM</span>
                            <span class="variable-desc">E-mail remetente padrão</span>
                        </li>
                        <li>
                            <span class="variable-name">SMTP_NAME</span>
                            <span class="variable-desc">Nome do remetente padrão</span>
                        </li>
                    </ul>

                    <h3>🛡️ Integração com reCAPTCHA v3</h3>
                    <ul class="variable-list">
                        <li>
                            <span class="variable-name">RECAPTCHA_V3_SITE_KEY</span>
                            <span class="variable-desc">Chave pública do reCAPTCHA v3</span>
                        </li>
                        <li>
                            <span class="variable-name">RECAPTCHA_V3_SECRET_KEY</span>
                            <span class="variable-desc">Chave secreta do reCAPTCHA v3</span>
                        </li>
                    </ul>

                    <h3>🔗 Integração com Google OAuth</h3>
                    <ul class="variable-list">
                        <li>
                            <span class="variable-name">GOOGLE_CLIENT_ID</span>
                            <span class="variable-desc">Client ID para autenticação Google</span>
                        </li>
                        <li>
                            <span class="variable-name">GOOGLE_CLIENT_SECRET</span>
                            <span class="variable-desc">Client Secret para autenticação Google</span>
                        </li>
                        <li>
                            <span class="variable-name">GOOGLE_TOKEN_URL</span>
                            <span class="variable-desc">URL para obtenção de tokens OAuth</span>
                        </li>
                        <li>
                            <span class="variable-name">GOOGLE_USERINFO_URL</span>
                            <span class="variable-desc">URL para obtenção de informações do usuário</span>
                        </li>
                        <li>
                            <span class="variable-name">GOOGLE_AUTH_URL</span>
                            <span class="variable-desc">URL para autenticação OAuth</span>
                        </li>
                    </ul>

                    <h3>🏫 Configurações Específicas do IC</h3>
                    <ul class="variable-list">
                        <li>
                            <span class="variable-name">INTRANET</span>
                            <span class="variable-desc">URL base da intranet do IC:
                                https://intranet.ic.unicamp.br/pub</span>
                        </li>
                        <li>
                            <span class="variable-name">SITEPATH</span>
                            <span class="variable-desc">Caminho para o tema personalizado:
                                /wp-content/themes/novoicode/</span>
                        </li>
                    </ul>
                </div>


                <!-- Tab .htaccess -->
                <div class="tab-pane fade" id="htaccess" role="tabpanel" aria-labelledby="htaccess-tab">
                    <h2>🔧 Arquivo .htaccess</h2>
                    <p>Arquivo de configuração do servidor Apache para controle de acesso, redirecionamentos e segurança.
                    </p>

                    <h3>🛡️ Regras de Segurança</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📝 Bloqueio de debug.log</h4>
                            <p>Bloqueia acesso ao arquivo debug.log para usuários não autenticados</p>
                            <code>RewriteCond %{REQUEST_URI} ^/wp-content/debug\.log$</code>
                        </div>
                        <div class="card">
                            <h4>🚫 Proteção do .git</h4>
                            <p>Bloqueia acesso completo ao diretório .git e seus conteúdos</p>
                            <code>RewriteRule ^\.git - [F,L,NC]</code>
                        </div>
                        <div class="card">
                            <h4>📁 Arquivos Sensíveis</h4>
                            <p>Bloqueia acesso a arquivos de configuração e desenvolvimento</p>
                            <code>commitar.sh, .env, composer.json, etc.</code>
                        </div>
                    </div>

                    <h3>🔀 Regras de Redirecionamento</h3>
                    <ul class="variable-list">
                        <li>
                            <span class="variable-name">CSP Report</span>
                            <span class="variable-desc">Endpoint para relatórios de Content Security Policy</span>
                            <code>RewriteRule ^csp-report/?$ - [L]</code>
                        </li>
                        <li>
                            <span class="variable-name">Logout Customizado</span>
                            <span class="variable-desc">URL amigável para logout do sistema</span>
                            <code>RewriteRule ^^logout$ /wp-login.php?action=logout [QSA,L]</code>
                        </li>
                        <li>
                            <span class="variable-name">Proteção de PDFs</span>
                            <span class="variable-desc">Redireciona acesso a PDFs para script de controle</span>
                            <code>RewriteRule ^wp-content/uploads/(.*\.pdf)$ /file.php?file=$1</code>
                        </li>
                    </ul>

                    <h3>⚙️ Configurações de MIME Type</h3>
                    <div class="card">
                        <h4>📜 Configuração JavaScript</h4>
                        <p>Correções específicas para tipos MIME de arquivos JavaScript</p>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><code>AddType application/javascript .js</code></li>
                            <li><code>Header unset X-Content-Type-Options</code></li>
                            <li>Força Content-Type para JS (especialmente TinyMCE)</li>
                        </ul>
                    </div>

                    <h3>🎯 Funcionalidades Principais</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Controle de Acesso</span>
                        <span class="tech-item">Segurança de Arquivos</span>
                        <span class="tech-item">URLs Amigáveis</span>
                        <span class="tech-item">Proteção .git</span>
                        <span class="tech-item">CSP Reports</span>
                    </div>
                </div>


                <!-- Tab Plugin -->
                <div class="tab-pane fade" id="plugin-novoicode" role="tabpanel" aria-labelledby="plugin-tab">
                    <h2>🔌 Plugin novoicode<span>/wp-content/plugins/novoicode/</span></h2>
                    <p>Plugin principal do Sistema ICODE responsável pelas funcionalidades customizadas, gerenciamento de
                        usuários, controle de acessos e indexação de documentos PDF.</p>

                    <h3>📁 Estrutura de Diretórios</h3>
                    <div class="card">
                        <h4>🌳 Árvore do Plugin</h4>
                        <pre
                            style="background: #2c3e50; color: #ecf0f1; padding: 1rem; border-radius: 5px; overflow-x: auto; font-family: 'Courier New', monospace; font-size: 0.9rem;">
        .
        ├── 📄 <strong>novoicode.php</strong>                 <em># Arquivo principal do plugin</em>
        ├── 📁 <strong>assets/</strong>                      <em># Recursos de frontend</em>
        │   ├── 📁 css/
        │   │   └── 🎨 novoicode.css        <em># Estilos customizados</em>
        │   └── 📁 js/
        │       └── ⚡ novoicode.js          <em># JavaScript customizado</em>
        └── 📁 <strong>includes/</strong>                    <em># Funcionalidades principais</em>
            ├── ⚙️ elfinder.php              <em># Gerenciador de arquivos</em>
            ├── ⚙️ functions.php             <em># Funções gerais do sistema</em>
            ├── 📁 <strong>pages/</strong>                   <em># Páginas administrativas</em>
            │   ├── ℹ️ about.php             <em># Página "Sobre o ICODE"</em>
            │   ├── 📊 acessos.php           <em># Registro de acessos</em>
            │   ├── 🍔 menu.php              <em># Estrutura do menu admin</em>
            │   ├️ pdfparser.php             <em># Indexação de PDFs</em>
            │   └── ⚙️ settings.php          <em># Configurações do sistema</em>
            └── 📁 <strong>src/</strong>                     <em># Módulos funcionais</em>
                ├️ cat.php                   <em># Sistema de categorias por ano</em>
                ├️ frontend.php              <em># Funcionalidades do tema</em>
                ├️ login.php                 <em># Sistema de autenticação</em>
                ├️ pdf.php                   <em># Processamento de PDFs</em>
                ├️ permalink.php             <em># URLs amigáveis</em>
                ├️ types.php                 <em># Custom Post Types</em>
                ├️ usermeta.php              <em># Metadados de usuário</em>
                └️ user.php                  <em># Gestão de usuários</em>

        7 diretórios, 18 arquivos
                </pre>
                        <p><strong>Exclusões:</strong> Diretórios <code>elFinder</code> e <code>pdfparser</code> omitidos da
                            árvore</p>
                    </div>

                    <h3>🎯 Arquivo Principal</h3>
                    <div class="card">
                        <h4>📄 novoicode.php</h4>
                        <p>Arquivo core do plugin que inicializa todas as funcionalidades e dependências</p>

                        <h5>🔧 Funcionalidades Principais:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Plugin Header:</strong> Metadados e informações do plugin</li>
                            <li><strong>Hooks de Ativação:</strong> <code>register_activation_hook()</code></li>
                            <li><strong>Hooks de Desativação:</strong> <code>register_deactivation_hook()</code></li>
                            <li><strong>Includes:</strong> Carregamento de todos os módulos</li>
                        </ul>

                        <h5>📋 Metadados do Plugin:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Campo</th>
                                    <th style="padding: 0.3rem; text-align: left;">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>Plugin Name</strong></td>
                                    <td style="padding: 0.3rem;">Novo ICODE</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>Plugin URI</strong></td>
                                    <td style="padding: 0.3rem;">https://ic.unicamp.br/~everton</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>Description</strong></td>
                                    <td style="padding: 0.3rem;">Plugin Novo ICODE</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>Author</strong></td>
                                    <td style="padding: 0.3rem;">EvM.</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><strong>Version</strong></td>
                                    <td style="padding: 0.3rem;">1.0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📦 Módulos do Sistema</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🎨 Assets</h4>
                            <p>Arquivos de frontend (CSS e JavaScript)</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem;">
                                <li><code>📄 assets/css/novoicode.css</code></li>
                                <li><code>📄 assets/js/novoicode.js</code></li>
                            </ul>
                            <p><strong>Propósito:</strong> Estilos e comportamentos da interface administrativa</p>
                        </div>

                        <div class="card">
                            <h4>🔧 Includes</h4>
                            <p>Funcionalidades principais e utilitárias</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem;">
                                <li><code>📄 includes/functions.php</code></li>
                                <li><code>📄 includes/elfinder.php</code></li>
                            </ul>
                            <p><strong>Propósito:</strong> Funções gerais e gerenciador de arquivos</p>
                        </div>

                        <div class="card">
                            <h4>📄 Pages</h4>
                            <p>Páginas do painel administrativo</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem;">
                                <li><code>📄 pages/menu.php</code></li>
                                <li><code>📄 pages/settings.php</code></li>
                                <li><code>📄 pages/acessos.php</code></li>
                                <li><code>📄 pages/about.php</code></li>
                                <li><code>📄 pages/pdfparser.php</code></li>
                            </ul>
                            <p><strong>Propósito:</strong> Interface de gestão do sistema</p>
                        </div>

                        <div class="card">
                            <h4>⚙️ Source</h4>
                            <p>Módulos funcionais do sistema</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem;">
                                <li><code>📄 src/user.php</code></li>
                                <li><code>📄 src/login.php</code></li>
                                <li><code>📄 src/pdf.php</code></li>
                                <li><code>📄 src/types.php</code></li>
                                <li><code>📄 src/usermeta.php</code></li>
                                <li><code>📄 src/frontend.php</code></li>
                                <li><code>📄 src/permalink.php</code></li>
                                <li><code>📄 src/cat.php</code></li>
                            </ul>
                            <p><strong>Propósito:</strong> Lógica de negócio e funcionalidades específicas</p>
                        </div>
                    </div>

                    <h3>🗃️ Banco de Dados - Tabelas Criadas</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📈 Tabela de Acessos</h4>
                            <code>{prefix}_acessos</code>
                            <p>Registro detalhado de todos os acessos ao sistema para auditoria</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>id:</strong> INT AUTO_INCREMENT PRIMARY KEY</li>
                                <li><strong>user:</strong> TEXT NOT NULL (usuário que acessou)</li>
                                <li><strong>ipadress:</strong> TEXT NOT NULL (endereço IP do acesso)</li>
                                <li><strong>url:</strong> TEXT NOT NULL (URL acessada)</li>
                                <li><strong>time:</strong> DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL</li>
                            </ul>
                        </div>
                        <div class="card">
                            <h4>📄 Tabela de Indexação PDF</h4>
                            <code>{prefix}_pdf_index</code>
                            <p>Armazenamento de conteúdo extraído de PDFs para busca full-text</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>id:</strong> INT AUTO_INCREMENT PRIMARY KEY</li>
                                <li><strong>arquivo:</strong> VARCHAR(255) NOT NULL (nome do arquivo PDF)</li>
                                <li><strong>url:</strong> VARCHAR(255) NOT NULL (URL do arquivo)</li>
                                <li><strong>texto:</strong> LONGTEXT NOT NULL (conteúdo extraído)</li>
                                <li><strong>tipo:</strong> VARCHAR(10) NOT NULL (tipo do documento)</li>
                                <li><strong>ano:</strong> INT(4) NOT NULL (ano do documento)</li>
                                <li><strong>id_post:</strong> INT(10) NOT NULL (ID do post relacionado)</li>
                                <li><strong>INDEX:</strong> Campo 'arquivo' indexado</li>
                            </ul>
                        </div>
                    </div>

                    <h3>⚡ Funcionalidades Principais</h3>
                    <ul class="variable-list">
                        <li>
                            <span class="variable-name">🎭 Controle de Usuários</span>
                            <span class="variable-desc">Remove papéis padrão do WordPress (Author e Contributor) e
                                implementa sistema customizado baseado em LDAP IC e permissões granulares</span>
                        </li>
                        <li>
                            <span class="variable-name">📊 Auditoria de Acessos</span>
                            <span class="variable-desc">Registro detalhado de todos os acessos ao sistema com IP, usuário,
                                URL e timestamp para compliance e segurança</span>
                        </li>
                        <li>
                            <span class="variable-name">🔍 Indexação de PDF</span>
                            <span class="variable-desc">Sistema de busca full-text em documentos PDF usando Smalot PDF
                                Parser com limpeza automática de indexações orphaned</span>
                        </li>
                        <li>
                            <span class="variable-name">🔐 Autenticação Customizada</span>
                            <span class="variable-desc">Integração com SISE e LDAP do IC usando reCAPTCHA v3 para proteção
                                contra bots e criação automática de usuários</span>
                        </li>
                        <li>
                            <span class="variable-name">⚙️ Painel Administrativo</span>
                            <span class="variable-desc">Páginas customizadas para gestão do sistema incluindo configurações,
                                relatórios de acesso e ferramentas de manutenção</span>
                        </li>
                        <li>
                            <span class="variable-name">🏛️ Colegiados Dinâmicos</span>
                            <span class="variable-desc">Sistema de Custom Post Types configuráveis para cada colegiado com
                                permissões específicas e estrutura organizacional</span>
                        </li>
                        <li>
                            <span class="variable-name">🔄 Processamento de Documentos</span>
                            <span class="variable-desc">Conversão DOC→PDF via LibreOffice e junção de PDFs via Ghostscript
                                com interface AJAX para operações em lote</span>
                        </li>
                    </ul>

                    <h3>🔄 Hooks de Ativação/Desativação</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🚀 Ativação</h4>
                            <code>register_activation_hook(__FILE__, 'add_db_acessos')</code>
                            <p>Executado quando o plugin é ativado no WordPress</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Criação de Tabelas:</strong> <code>{prefix}_acessos</code> e
                                    <code>{prefix}_pdf_index</code>
                                </li>
                                <li><strong>Remoção de Roles:</strong> Author e Contributor do WordPress</li>
                                <li><strong>Rewrite Rules:</strong> <code>flush_rewrite_rules()</code> para URLs
                                    customizadas</li>
                                <li><strong>Verificação:</strong> <code>dbDelta()</code> para criação segura de tabelas</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>🛑 Desativação</h4>
                            <code>register_deactivation_hook(__FILE__, 'deactivate')</code>
                            <p>Executado quando o plugin é desativado no WordPress</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Limpeza de Rules:</strong> <code>flush_rewrite_rules()</code></li>
                                <li><strong>Manutenção:</strong> Preserva dados das tabelas criadas</li>
                                <li><strong>Otimização:</strong> Remove apenas regras específicas do plugin</li>
                            </ul>
                        </div>
                    </div>

                    <h3>🎯 Módulos Carregados</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Gerenciamento de Usuários</span>
                        <span class="tech-item">Metadados Customizados</span>
                        <span class="tech-item">Sistema de Login</span>
                        <span class="tech-item">Categorias</span>
                        <span class="tech-item">Permalinks</span>
                        <span class="tech-item">Processamento PDF</span>
                        <span class="tech-item">Frontend</span>
                        <span class="tech-item">Parser PDF</span>
                        <span class="tech-item">Custom Post Types</span>
                        <span class="tech-item">Controle de Acesso</span>
                        <span class="tech-item">APIs Intranet</span>
                        <span class="tech-item">Auditoria</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Características Técnicas</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>Arquitetura Modular:</strong> Código organizado em componentes especializados</li>
                            <li><strong>Integração Profunda:</strong> Hooks em todos os níveis do WordPress</li>
                            <li><strong>Segurança Robusta:</strong> Nonce verification, capability checks e sanitização</li>
                            <li><strong>Performance:</strong> Operações assíncronas e processamento em lote</li>
                            <li><strong>Manutenibilidade:</strong> Estrutura clara e documentação completa</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Plugin Admin Pages -->
                <div class="tab-pane fade" id="admin-pages" role="tabpanel" aria-labelledby="admin-pages-tab">
                    <h2>📊 Páginas Administrativas<span>/wp-content/plugins/novoicode/includes/pages/</span></h2>
                    <p>Seção do painel administrativo do WordPress com páginas customizadas para gestão e monitoramento do
                        sistema ICODE.</p>

                    <h3>🍔 Estrutura do Menu</h3>
                    <div class="card">
                        <h4>🎯 Menu Principal "ICODE"</h4>
                        <code>add_menu_page('ICODE', 'ICODE', 'edit_posts', 'icode', 'function_about', 'dashicons-screenoptions', 1)</code>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Posição:</strong> 1 (primeiro item do menu)</li>
                            <li><strong>Capacidade:</strong> edit_posts</li>
                            <li><strong>Ícone:</strong> dashicons-screenoptions</li>
                        </ul>
                    </div>

                    <div class="grid">
                        <div class="card">
                            <h4>📈 Submenu: Acessos</h4>
                            <code>add_submenu_page('icode', 'Acessos', 'Acessos', 'edit_posts', 'icode_acessos', 'function_acessos', 2)</code>
                            <p>Registro detalhado dos acessos ao sistema</p>
                        </div>
                        <div class="card">
                            <h4>📄 Submenu: PDFParser</h4>
                            <code>add_submenu_page('icode', 'PDFParser', 'PDFParser', 'edit_posts', 'icode_pdfparser', 'function_pdfparser', 3)</code>
                            <p>Ferramenta de indexação e parser de documentos PDF</p>
                        </div>
                    </div>

                    <h3>📋 Página "Sobre o Novo ICODE"</h3>
                    <div class="card">
                        <h4>ℹ️ Página de Informações</h4>
                        <p>Apresenta informações básicas sobre o sistema e links relevantes</p>
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; margin-top: 0.5rem;">
                            <h5 style="color: #2c3e50; margin-bottom: 0.5rem;">Conteúdo Exibido:</h5>
                            <ul style="list-style-position: inside;">
                                <li><strong>Descrição:</strong> Sistema de Gerenciamento de Conteúdos do IC, Unicamp</li>
                                <li><strong>Link do Projeto:</strong> GitLab do ICODE</li>
                                <li><strong>Site do Desenvolvedor:</strong> Página pessoal do Everton</li>
                            </ul>
                        </div>
                    </div>

                    <h3>📊 Página "Registro de Acessos"</h3>
                    <div class="card">
                        <h4>👥 Monitoramento de Acesso</h4>
                        <p>Tabela com os últimos 500 acessos registrados no sistema</p>

                        <h5>📋 Estrutura da Tabela:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">Campo</th>
                                    <th style="padding: 0.5rem; text-align: left;">Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>Usuário</strong></td>
                                    <td style="padding: 0.5rem;">Nome do usuário que realizou o acesso</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>IP</strong></td>
                                    <td style="padding: 0.5rem;">Endereço IP de origem do acesso</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>URL</strong></td>
                                    <td style="padding: 0.5rem;">Página ou recurso acessado</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;"><strong>Data</strong></td>
                                    <td style="padding: 0.5rem;">Data e hora no formato DD/MM/YYYY , HH:MM:SS</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 style="margin-top: 1rem;">🔍 Query de Dados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem;">
                    SELECT * FROM {prefix}_acessos ORDER BY id DESC LIMIT 500
                </code>
                    </div>

                    <h3>⚙️ Funções de Carregamento</h3>
                    <ul class="variable-list">
                        <li>
                            <span class="variable-name">function_about()</span>
                            <span class="variable-desc">Carrega a página "Sobre" -
                                <code>includes/pages/about.php</code></span>
                        </li>
                        <li>
                            <span class="variable-name">function_acessos()</span>
                            <span class="variable-desc">Carrega a página de "Acessos" -
                                <code>includes/pages/acessos.php</code></span>
                        </li>
                        <li>
                            <span class="variable-name">function_pdfparser()</span>
                            <span class="variable-desc">Carrega a página "PDFParser" -
                                <code>includes/pages/pdfparser.php</code></span>
                        </li>
                    </ul>

                    <h3>🎯 Funcionalidades das Páginas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Monitoramento</span>
                        <span class="tech-item">Auditoria</span>
                        <span class="tech-item">Relatórios</span>
                        <span class="tech-item">Gestão PDF</span>
                        <span class="tech-item">Dashboard</span>
                    </div>
                </div>


                <!-- Tab Plugin Settings -->
                <div class="tab-pane fade" id="admin-settings" role="tabpanel" aria-labelledby="settings-tab">
                    <h2>⚙️ Página de Configurações<span>/wp-content/plugins/novoicode/includes/pages/settings.php</span>
                    </h2>
                    <p>Página administrativa para configuração global do sistema ICODE, incluindo personalização, gestão de
                        usuários e definição dos colegiados.</p>

                    <h3>📍 Localização no Menu</h3>
                    <div class="card">
                        <h4>🔧 Submenu de Configurações</h4>
                        <code>add_submenu_page('icode', 'Configurações', 'Configurações', 'edit_posts', 'pagina-inicial', 'portal_page_html', 1)</code>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Posição:</strong> 1 (primeiro submenu)</li>
                            <li><strong>Capacidade:</strong> edit_posts</li>
                            <li><strong>Função:</strong> portal_page_html()</li>
                        </ul>
                    </div>

                    <h3>📋 Campos de Configuração</h3>

                    <div class="grid">
                        <div class="card">
                            <h4>🏷️ Nome do Site</h4>
                            <code>portal_input_0</code>
                            <p><strong>Tipo:</strong> Texto | <strong>Obrigatório:</strong> ✅</p>
                            <p>Nome exibido do sistema ICODE</p>
                        </div>

                        <div class="card">
                            <h4>🖼️ Logo do Sistema</h4>
                            <code>portal_input_1</code>
                            <p><strong>Tipo:</strong> URL | <strong>Obrigatório:</strong> ✅</p>
                            <p>Upload de imagem com preview (100x100px recomendado)</p>
                        </div>

                        <div class="card">
                            <h4>📧 E-mails Editores</h4>
                            <code>portal_input_2</code>
                            <p><strong>Tipo:</strong> Array de e-mails</p>
                            <p>Lista de e-mails dos usuários com permissão de edição</p>
                        </div>

                        <div class="card">
                            <h4>👑 E-mails Administradores</h4>
                            <code>portal_input_4</code>
                            <p><strong>Tipo:</strong> Array de e-mails</p>
                            <p>Lista de e-mails dos administradores do sistema</p>
                        </div>
                    </div>

                    <h3>📝 Configuração de Textos</h3>
                    <div class="card">
                        <h4>📄 Texto Personalizado</h4>
                        <code>portal_input_5</code>
                        <p><strong>Tipo:</strong> Editor WYSIWYG</p>
                        <p>Utiliza <code>wp_editor()</code> para conteúdo formatado</p>
                        <p><strong>Sanitização:</strong> <code>wp_kses_post</code></p>
                    </div>

                    <h3>🏛️ Configuração dos Colegiados</h3>
                    <div class="card">
                        <h4>🎯 Tipos Registrados</h4>
                        <p>Configuração em array para definição dos colegiados do sistema</p>

                        <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">Campo</th>
                                    <th style="padding: 0.5rem; text-align: left;">Descrição</th>
                                    <th style="padding: 0.5rem; text-align: left;">Exemplo</th>
                                    <th style="padding: 0.5rem; text-align: center;">Obrig.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><code>portal_input_6</code></td>
                                    <td style="padding: 0.5rem;">Nomes dos tipos</td>
                                    <td style="padding: 0.5rem;">Congrega,CI,DSC,DSI,DTC,CDI</td>
                                    <td style="padding: 0.5rem; text-align: center;">✅</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><code>portal_input_7</code></td>
                                    <td style="padding: 0.5rem;">Slugs dos tipos</td>
                                    <td style="padding: 0.5rem;">congrega,ci,dsc,dsi,dtc,cdi</td>
                                    <td style="padding: 0.5rem; text-align: center;">✅</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><code>portal_input_8</code></td>
                                    <td style="padding: 0.5rem;">Ícones Bootstrap</td>
                                    <td style="padding: 0.5rem;">bi bi-people-fill,bi bi-person-lines-fill,...</td>
                                    <td style="padding: 0.5rem; text-align: center;">✅</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;"><code>portal_input_9</code></td>
                                    <td style="padding: 0.5rem;">Textos descritivos</td>
                                    <td style="padding: 0.5rem;">Congregação,Conselho Interdepartamental,...</td>
                                    <td style="padding: 0.5rem; text-align: center;">✅</td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="background: #fff3cd; padding: 0.75rem; border-radius: 4px; margin-top: 1rem;">
                            <strong>⚠️ Validação:</strong> Todos os campos devem ter o mesmo número de elementos separados
                            por
                            vírgulas
                        </div>
                    </div>

                    <h3>🎯 Tipos Obrigatórios</h3>
                    <div class="card">
                        <h4>📌 Colegiados Essenciais</h4>
                        <code>portal_input_10</code>
                        <p><strong>Tipo:</strong> Texto | <strong>Obrigatório:</strong> ✅</p>
                        <p>Slugs dos tipos que são obrigatórios no sistema (ex: congrega,ci)</p>
                        <p><strong>Valor padrão:</strong> "congrega,ci"</p>
                    </div>

                    <h3>🛡️ Sistema de Validação</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🎯 Validação Client-Side</h4>
                            <p>JavaScript para verificação em tempo real:</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem;">
                                <li>Consistência no número de elementos</li>
                                <li>Campos obrigatórios preenchidos</li>
                                <li>Feedback visual imediato</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>🛡️ Validação Server-Side</h4>
                            <p>PHP com sanitização específica:</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem;">
                                <li><code>portal_sanitize_emails_array()</code> - E-mails</li>
                                <li><code>portal_sanitize_slugs()</code> - Slugs</li>
                                <li><code>portal_validate_tipos_consistency()</code> - Consistência</li>
                            </ul>
                        </div>
                    </div>

                    <h3>📊 Funções de Sanitização</h3>
                    <ul class="variable-list">
                        <li>
                            <span class="variable-name">sanitize_text_field</span>
                            <span class="variable-desc">Para campos de texto simples</span>
                        </li>
                        <li>
                            <span class="variable-name">esc_url_raw</span>
                            <span class="variable-desc">Para URL da logo</span>
                        </li>
                        <li>
                            <span class="variable-name">portal_sanitize_emails_array</span>
                            <span class="variable-desc">Valida e filtra array de e-mails</span>
                        </li>
                        <li>
                            <span class="variable-name">wp_kses_post</span>
                            <span class="variable-desc">Para conteúdo HTML do editor</span>
                        </li>
                        <li>
                            <span class="variable-name">portal_sanitize_slugs</span>
                            <span class="variable-desc">Para slugs formatados</span>
                        </li>
                    </ul>

                    <h3>🎯 Funcionalidades da Página</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Configuração Global</span>
                        <span class="tech-item">Gestão Colegiados</span>
                        <span class="tech-item">Validação Dupla</span>
                        <span class="tech-item">Upload de Mídia</span>
                        <span class="tech-item">Sanitização</span>
                        <span class="tech-item">Editor Rich Text</span>
                    </div>
                </div>


                <!-- Tab Plugin PDF Parser -->
                <div class="tab-pane fade" id="pdf-parser" role="tabpanel" aria-labelledby="pdf-parser-tab">
                    <h2>📄 PDF Parser - Sistema de
                        Indexação<span>/wp-content/plugins/novoicode/includes/pages/pdfparser.php</span></h2>
                    <p>Ferramenta administrativa para indexação automatizada de documentos PDF no sistema ICODE, permitindo
                        busca full-text em documentos dos colegiados.</p>

                    <h3>📍 Localização</h3>
                    <div class="card">
                        <h4>🔍 Acesso ao Parser</h4>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Admin:</strong> Menu ICODE → PDFParser</li>
                            <li><strong>Frontend:</strong> Disponível para editores no tema</li>
                            <li><strong>Permissão:</strong> edit_posts</li>
                        </ul>
                    </div>

                    <h3>⚙️ Formulário de Configuração</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📝 Tipo de Post</h4>
                            <p>Seleção do colegiado/tipo de conteúdo</p>
                            <code>&lt;select name="tipo"&gt;</code>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Fonte:</strong> <code>get_post_types()</code></li>
                                <li><strong>Exclui:</strong> post, page, attachment</li>
                                <li><strong>Exemplo:</strong> congrega, ci, dsc, etc.</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>📅 Ano do Documento</h4>
                            <p>Seleção do ano dos documentos a indexar</p>
                            <code>&lt;select name="ano"&gt;</code>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Range:</strong> 2008 até ano atual</li>
                                <li><strong>Padrão:</strong> Ano corrente</li>
                                <li><strong>Formato:</strong> YYYY</li>
                            </ul>
                        </div>
                    </div>

                    <h3>📁 Estrutura de Diretórios</h3>
                    <div class="card">
                        <h4>🗂️ Organização de Arquivos</h4>
                        <code>wp-content/uploads/{tipo}/{ano}/{id_post}/</code>

                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; margin-top: 0.5rem;">
                            <h5 style="color: #2c3e50;">Exemplo de Estrutura:</h5>
                            <pre style="padding: 0.5rem; border-radius: 3px; font-size: 0.9rem;">
        wp-content/uploads/
        ├── congrega/
        │   └── 2025/
        │       ├── 1512/
        │       │   └── ata/
        │       │   └── deliberacoes/
        │       │   └── pautas/
        │       │   └── privado/
        │       └── 1525/
        │       │   └── ata/
        │       │   └── deliberacoes/
        │       │   └── pautas/
        │       │   └── privado/
        └── ci/
            └── 2025/
        │       ├── 1302/
        │       │   └── ata/
        │       │   └── deliberacoes/
        │       │   └── pautas/
        │       │   └── privado/
        │       └── 1408/
        │       │   └── ata/
        │       │   └── deliberacoes/
        │       │   └── pautas/
        │       │   └── privado/</pre>
                        </div>

                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Diretório base:</strong> <code>wp-content/uploads/{tipo}/{ano}/</code></li>
                            <li><strong>Subdiretórios:</strong> IDs dos posts ou nomes</li>
                            <li><strong>Exclusão:</strong> Diretório "privado" é ignorado</li>
                        </ul>
                    </div>

                    <h3>🔍 Processo de Indexação</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>1. 📂 Varredura de Diretórios</h4>
                            <p>Busca recursiva por arquivos PDF</p>
                            <code>RecursiveDirectoryIterator + RecursiveIteratorIterator</code>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li>Ignora diretórios "." e ".."</li>
                                <li>Exclui pasta "privado"</li>
                                <li>Coleta caminhos completos</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>2. 🆔 Identificação de Posts</h4>
                            <p>Extrai ID do post do nome do diretório</p>
                            <code>is_numeric($subdir) ? intval($subdir) : 0</code>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li>Subdiretórios numéricos = ID do post</li>
                                <li>Subdiretórios textuais = ID 0</li>
                                <li>Mantém relacionamento com conteúdo</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>3. 🌐 Geração de URLs</h4>
                            <p>Converte caminhos físicos em URLs acessíveis</p>
                            <code>str_replace(ABSPATH, '', $arquivo)</code>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li>Remove ABSPATH do caminho</li>
                                <li>Normaliza barras (Windows/Linux)</li>
                                <li>Prepara para acesso web</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>4. 📊 Interface de Progresso</h4>
                            <p>Feedback visual em tempo real</p>
                            <code>JavaScript + AJAX</code>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li>Barra de progresso animada</li>
                                <li>Status por arquivo</li>
                                <li>Contagem total e atual</li>
                            </ul>
                        </div>
                    </div>

                    <h3>🔄 Processamento Assíncrono</h3>
                    <div class="card">
                        <h4>⚡ Sistema AJAX</h4>
                        <p>Indexação não-bloqueante via JavaScript</p>

                        <h5>📤 Requisições AJAX:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        await fetch(admin_url("admin-ajax.php"), {
            method: "POST",
            body: new URLSearchParams({
                action: "novoicode_indexar_pdf",
                arquivo: arquivoAtual,
                url: urlAtual,
                tipo: tipo,
                ano: ano,
                id: idAtual
            })
        })
                </code>

                        <h5>🎯 Parâmetros Enviados:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Campo</th>
                                    <th style="padding: 0.3rem; text-align: left;">Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>action</code></td>
                                    <td style="padding: 0.3rem;">novoicode_indexar_pdf</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>arquivo</code></td>
                                    <td style="padding: 0.3rem;">Caminho físico do PDF</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>url</code></td>
                                    <td style="padding: 0.3rem;">URL acessível do PDF</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>tipo</code></td>
                                    <td style="padding: 0.3rem;">Tipo de post/colegiado</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>ano</code></td>
                                    <td style="padding: 0.3rem;">Ano do documento</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><code>id</code></td>
                                    <td style="padding: 0.3rem;">ID do post relacionado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🛡️ Tratamento de Erros</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>❌ Diretório Não Encontrado</h4>
                            <p>Verifica existência do path</p>
                            <code>if (!file_exists($base_dir))</code>
                            <p>Exibe mensagem de erro amigável</p>
                        </div>

                        <div class="card">
                            <h4>📭 Nenhum PDF Encontrado</h4>
                            <p>Verifica se há arquivos para processar</p>
                            <code>if (empty($arquivos))</code>
                            <p>Informa ausência de documentos</p>
                        </div>

                        <div class="card">
                            <h4>🚨 Erros de Processamento</h4>
                            <p>Tratamento individual por arquivo</p>
                            <code>try/catch + finally</code>
                            <p>Continua processamento mesmo com erros</p>
                        </div>
                    </div>

                    <h3>🎯 Funcionalidades do Parser</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Indexação Full-Text</span>
                        <span class="tech-item">Processamento Assíncrono</span>
                        <span class="tech-item">Busca em PDF</span>
                        <span class="tech-item">Progresso em Tempo Real</span>
                        <span class="tech-item">Organização por Ano</span>
                        <span class="tech-item">Relacionamento com Posts</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Armazenamento no Banco</h4>
                        <p>Os dados indexados são armazenados na tabela <code>{prefix}_pdf_index</code> com os campos:</p>
                        <ul style="list-style-position: inside;">
                            <li><strong>arquivo:</strong> Nome do arquivo PDF</li>
                            <li><strong>url:</strong> URL de acesso ao documento</li>
                            <li><strong>texto:</strong> Conteúdo extraído (LONGTEXT)</li>
                            <li><strong>tipo:</strong> Tipo/colegiado do documento</li>
                            <li><strong>ano:</strong> Ano de publicação</li>
                            <li><strong>id_post:</strong> ID do post relacionado</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Plugin Categorias -->
                <div class="tab-pane fade" id="sistema-categorias-ano" role="tabpanel" aria-labelledby="categorias-tab">
                    <h2>📅 Sistema de Categorias por Ano<span>/wp-content/plugins/novoicode/includes/src/cat.php</span></h2>
                    <p>Módulo responsável pela gestão automática de categorias baseadas em anos para organização temporal
                        dos
                        documentos dos colegiados.</p>

                    <h3>🎯 Objetivo Principal</h3>
                    <div class="card">
                        <p>Implementar um sistema de categorização automática por ano para todos os tipos de conteúdo do
                            ICODE,
                            facilitando a organização e filtragem temporal dos documentos.</p>
                    </div>

                    <h3>🔄 Funcionalidades do Módulo</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>1. 🗓️ Criação Automática de Anos</h4>
                            <code>create_year_categories()</code>
                            <p>Cria categorias de ano automaticamente no sistema</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Período:</strong> 2004 até ano atual</li>
                                <li><strong>Hook:</strong> <code>init</code></li>
                                <li><strong>Verificação:</strong> <code>term_exists()</code></li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>2. 📦 Metabox de Seleção</h4>
                            <code>add_year_category_metabox()</code>
                            <p>Adiciona seletor de anos na interface de edição</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Posição:</strong> sidebar</li>
                                <li><strong>Contexto:</strong> default</li>
                                <li><strong>Prioridade:</strong> normal</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>3. 💾 Salvamento Seguro</h4>
                            <code>save_year_category_selection()</code>
                            <p>Processa e valida a seleção de ano</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Segurança:</strong> Nonce verification</li>
                                <li><strong>Validação:</strong> Permissões + Autosave</li>
                                <li><strong>Hook:</strong> <code>save_post</code></li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>4. ⚡ Pré-seleção Automática</h4>
                            <code>preselect_category_for_custom_type()</code>
                            <p>Seleciona automaticamente o ano corrente em novos posts</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Condição:</strong> Apenas novos posts</li>
                                <li><strong>Ano padrão:</strong> Ano atual</li>
                                <li><strong>Hook:</strong> <code>wp_insert_post</code></li>
                            </ul>
                        </div>
                    </div>

                    <h3>⚙️ Configuração Dinâmica</h3>
                    <div class="card">
                        <h4>🎯 Tipos de Post Suportados</h4>
                        <p>Os tipos são carregados dinamicamente das configurações:</p>
                        <code>$slugs_array = explode(',', get_option('portal_input_7'));</code>

                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; margin-top: 0.5rem;">
                            <h5 style="color: #2c3e50;">Fluxo de Carregamento:</h5>
                            <ol style="margin-left: 1rem;">
                                <li>Lê <code>portal_input_7</code> das configurações</li>
                                <li>Explode por vírgulas em array</li>
                                <li>Aplica <code>trim()</code> em cada item</li>
                                <li>Filtra array vazio</li>
                                <li>Aplica apenas aos tipos listados</li>
                            </ol>
                        </div>
                    </div>

                    <h3>🔧 Implementação Técnica</h3>

                    <h4>🗓️ Geração de Categorias de Ano</h4>
                    <div class="card">
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        function create_year_categories() {
            $start_year = 2004;
            $current_year = date('Y');
    
            for ($year = $start_year; $year <= $current_year; $year++) {
                if (!term_exists($year, 'category')) {
                    wp_insert_term($year, 'category', [
                        'slug' => $year,
                    ]);
                }
            }
        }
                </code>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Início:</strong> 2004 (ano base do sistema)</li>
                            <li><strong>Término:</strong> Ano atual (dinâmico)</li>
                            <li><strong>Verificação:</strong> Evita duplicação com <code>term_exists()</code></li>
                            <li><strong>Slug:</strong> Usa o ano como slug (ex: "2023")</li>
                        </ul>
                    </div>

                    <h4>🎛️ Renderização do Metabox</h4>
                    <div class="card">
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        function render_year_category_metabox($post) {
            $selected = '';
            $terms = wp_get_post_terms($post->ID, 'category', ['fields' => 'slugs']);
            if (!empty($terms)) {
                $selected = $terms[0];
            }
    
            $start_year = 2004;
            $current_year = date('Y');
    
            echo '&lt;select name="year_category_select" style="width:100%;"&gt;';
            echo '&lt;option value=""&gt;-- Selecione o Ano --&lt;/option&gt;';
    
            for ($year = $current_year; $year >= $start_year; $year--) {
                $is_selected = ($selected == $year) ? 'selected' : '';
                echo "&lt;option value='{$year}' {$is_selected}&gt;{$year}&lt;/option&gt;";
            }
    
            echo '&lt;/select&gt;';
            wp_nonce_field('save_year_category_metabox', 'year_category_metabox_nonce');
        }
                </code>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Ordenação:</strong> Anos em ordem decrescente</li>
                            <li><strong>Seleção atual:</strong> Recupera termos do post</li>
                            <li><strong>Segurança:</strong> Nonce field para proteção</li>
                            <li><strong>UI:</strong> Select box com 100% de largura</li>
                        </ul>
                    </div>

                    <h3>🛡️ Sistema de Segurança</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🔒 Verificação de Nonce</h4>
                            <code>wp_verify_nonce($_POST['year_category_metabox_nonce'], 'save_year_category_metabox')</code>
                            <p>Protege contra CSRF attacks</p>
                        </div>

                        <div class="card">
                            <h4>🚫 Prevenção de Autosave</h4>
                            <code>defined('DOING_AUTOSAVE') && DOING_AUTOSAVE</code>
                            <p>Evita processamento durante autosave</p>
                        </div>

                        <div class="card">
                            <h4>👮 Verificação de Permissões</h4>
                            <code>current_user_can('edit_post', $post_id)</code>
                            <p>Garante que usuário tem capacidade</p>
                        </div>

                        <div class="card">
                            <h4>🎯 Filtro por Tipo de Post</h4>
                            <code>in_array($current_post_type, $slugs_array)</code>
                            <p>Aplica apenas aos tipos do ICODE</p>
                        </div>
                    </div>

                    <h3>⚡ Comportamento Automático</h3>
                    <div class="card">
                        <h4>🆕 Pré-seleção em Novos Posts</h4>
                        <p>Quando um novo post é criado em qualquer tipo do ICODE:</p>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Condição:</strong> <code>!$update</code> (não é atualização)</li>
                            <li><strong>Ano:</strong> Ano atual automaticamente</li>
                            <li><strong>Busca:</strong> <code>get_term_by('slug', $current_year, 'category')</code></li>
                            <li><strong>Atribuição:</strong> <code>wp_set_post_terms()</code></li>
                        </ul>
                    </div>

                    <h3>🎯 Funcionalidades do Sistema</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Categorização Automática</span>
                        <span class="tech-item">Interface Amigável</span>
                        <span class="tech-item">Segurança Robustecida</span>
                        <span class="tech-item">Configuração Dinâmica</span>
                        <span class="tech-item">Pré-seleção Inteligente</span>
                        <span class="tech-item">Organização Temporal</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Integração com o Sistema</h4>
                        <p>Este módulo se integra com:</p>
                        <ul style="list-style-position: inside;">
                            <li><strong>Configurações:</strong> Carrega tipos de <code>portal_input_7</code></li>
                            <li><strong>WordPress Core:</strong> Utiliza sistema nativo de categorias</li>
                            <li><strong>Editor:</strong> Metabox na interface de edição</li>
                            <li><strong>Busca:</strong> Facilita filtros por ano no frontend</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Plugin Frontend -->
                <div class="tab-pane fade" id="frontend" role="tabpanel" aria-labelledby="frontend-tab">
                    <h2>🎨 Frontend - Funcionalidades do
                        Tema<span>/wp-content/plugins/novoicode/includes/src/frontend.php</span></h2>
                    <p>Módulo responsável por gerenciar todos os assets, scripts, estilos e funcionalidades do frontend do
                        sistema ICODE.</p>

                    <h3>📦 Sistema de Assets</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🎨 Estilos (CSS)</h4>
                            <p>Framework e bibliotecas de estilo carregadas:</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Bootstrap 5</strong> - Framework CSS</li>
                                <li><strong>Bootstrap Icons</strong> - Ícones</li>
                                <li><strong>Boxicons & Remixicon</strong> - Ícones adicionais</li>
                                <li><strong>Quill Editor</strong> - Editor rich text</li>
                                <li><strong>DataTables</strong> - Tabelas interativas</li>
                                <li><strong>Font Awesome</strong> - Conjunto de ícones</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>⚡ Scripts (JavaScript)</h4>
                            <p>Bibliotecas JavaScript e funcionalidades:</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>ApexCharts</strong> - Gráficos</li>
                                <li><strong>Chart.js</strong> - Visualização de dados</li>
                                <li><strong>Quill</strong> - Editor de texto</li>
                                <li><strong>DataTables</strong> - Tabelas com export</li>
                                <li><strong>JSZip</strong> - Exportação Excel</li>
                                <li><strong>Bootstrap Bundle</strong> - Componentes</li>
                            </ul>
                        </div>
                    </div>

                    <h3>📝 Gestão de Conteúdo</h3>

                    <h4>✏️ Criar/Editar Posts</h4>
                    <div class="card">
                        <code>handle_editar_post()</code>
                        <p>Sistema completo de criação e edição de conteúdo</p>

                        <h5>🔄 Fluxo de Processamento:</h5>
                        <ol style="margin-left: 1rem;">
                            <li><strong>Verificação:</strong> Valida ID e tipo do post</li>
                            <li><strong>Criação/Atualização:</strong> <code>wp_insert_post()</code> ou
                                <code>wp_update_post()</code>
                            </li>
                            <li><strong>Metadados:</strong> Atualiza campos customizados</li>
                            <li><strong>Estrutura:</strong> Cria diretórios automáticos</li>
                            <li><strong>Redirecionamento:</strong> Para o post criado/editado</li>
                        </ol>

                        <h5>📁 Estrutura de Diretórios Criada:</h5>
                        <code>wp-content/uploads/{tipo}/{categoria}/{id_post}/[pautas, deliberacoes, ata, privado]</code>
                    </div>

                    <h4>🗑️ Exclusão de Posts</h4>
                    <div class="card">
                        <code>handle_post_deletion()</code>
                        <p>Exclusão segura com remoção de arquivos</p>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Verificação:</strong> Permissões do usuário</li>
                            <li><strong>Exclusão:</strong> Post + metadados</li>
                            <li><strong>Limpeza:</strong> Diretórios e arquivos</li>
                            <li><strong>Recursivo:</strong> <code>delete_directory_recursively()</code></li>
                        </ul>
                    </div>

                    <h3>👤 Sistema de Perfil</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📝 Atualização de Perfil</h4>
                            <code>handle_atualizar_perfil_usuario()</code>
                            <p>AJAX para atualização de dados do usuário</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Nome/Sobrenome:</strong> Atualização via <code>wp_update_user()</code></li>
                                <li><strong>Avatar:</strong> Upload com <code>media_handle_upload()</code></li>
                                <li><strong>Validação:</strong> Tipos de arquivo permitidos</li>
                                <li><strong>Resposta:</strong> JSON para feedback</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>🟢 Usuários Online</h4>
                            <code>get_users_online()</code>
                            <p>Sistema de monitoramento de atividade</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Tracking:</strong> Meta <code>last_active</code></li>
                                <li><strong>Threshold:</strong> 5 minutos padrão</li>
                                <li><strong>Hook:</strong> <code>init</code> para atualização</li>
                                <li><strong>Consulta:</strong> <code>get_users()</code> com meta</li>
                            </ul>
                        </div>
                    </div>

                    <h3>📊 Componentes do Frontend</h3>

                    <h4>👥 Página de Pessoas</h4>
                    <div class="card">
                        <p>Interface com abas para docentes e funcionários</p>
                        <div class="grid">
                            <div class="card">
                                <h5>🎓 Docentes</h5>
                                <code>table_docentes()</code>
                                <p>Integração com intranet para lista de docentes</p>
                                <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                    <li><strong>Fonte:</strong> <code>lista_docentes_intranet()</code></li>
                                    <li><strong>Campos:</strong> Nome, Departamento, Email</li>
                                    <li><strong>Avatar:</strong> Imagem do perfil</li>
                                </ul>
                            </div>

                            <div class="card">
                                <h5>💼 Funcionários</h5>
                                <code>table_funcionarios()</code>
                                <p>Lista de funcionários com papéis traduzidos</p>
                                <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                    <li><strong>Fonte:</strong> <code>lista_funcionarios_intranet()</code></li>
                                    <li><strong>Papéis:</strong> <code>traduz_papel(papel_usuario())</code></li>
                                    <li><strong>Estrutura:</strong> Similar aos docentes</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h4>📈 Gráfico de Acessos</h4>
                    <div class="card">
                        <code>chart_data()</code>
                        <p>Dados para visualização de acessos no sistema</p>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Consulta:</strong> TOP 10 URLs mais acessadas</li>
                            <li><strong>Formato:</strong> Arrays para Chart.js/ApexCharts</li>
                            <li><strong>Filtro:</strong> Exclui página inicial ("/")</li>
                        </ul>
                    </div>

                    <h3>🛠️ Funcionalidades Avançadas</h3>

                    <h4>📧 Sistema de Email</h4>
                    <div class="card">
                        <code>ajax_enviar_email_convocacao()</code>
                        <p>Sistema de envio de convocações por email</p>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Conteúdo:</strong> Post + membros + descrição</li>
                            <li><strong>URLs:</strong> Conversão para absolutas</li>
                            <li><strong>Headers:</strong> HTML + charset UTF-8</li>
                            <li><strong>Segurança:</strong> Permissões e sanitização</li>
                        </ul>
                    </div>

                    <h4>🔗 Correção de Links</h4>
                    <div class="card">
                        <code>corrigir_links_arquivos()</code>
                        <p>Sistema inteligente de correção de links para arquivos</p>

                        <h5>🎯 Funcionalidades:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Busca:</strong> Arquivos em subdiretórios</li>
                            <li><strong>Similaridade:</strong> 90% para nomes aproximados</li>
                            <li><strong>Marcacao:</strong> "(para membros)" para arquivos privados</li>
                            <li><strong>Limpeza:</strong> Remove links quebrados</li>
                        </ul>

                        <h5>🔄 Processamento:</h5>
                        <ol style="margin-left: 1rem;">
                            <li>Parse HTML com <code>DOMDocument</code></li>
                            <li>Identifica links de arquivos</li>
                            <li>Busca arquivo nos diretórios</li>
                            <li>Atualiza URL e adiciona marcações</li>
                            <li>Remove links não encontrados</li>
                        </ol>
                    </div>

                    <h4>🛡️ reCAPTCHA v3</h4>
                    <div class="card">
                        <p>Proteção contra bots no sistema de login</p>
                        <div class="grid">
                            <div class="card">
                                <h5>🎨 Frontend</h5>
                                <code>adicionar_recaptcha_login()</code>
                                <p>Injeção do script reCAPTCHA no formulário</p>
                                <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                    <li><strong>Action:</strong> "login"</li>
                                    <li><strong>Token:</strong> Hidden input</li>
                                    <li><strong>Render:</strong> Execução automática</li>
                                </ul>
                            </div>

                            <div class="card">
                                <h5>🔐 Backend</h5>
                                <code>verificar_recaptcha_login()</code>
                                <p>Validação do token no servidor</p>
                                <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                    <li><strong>Score:</strong> Mínimo 0.5</li>
                                    <li><strong>Verificação:</strong> API Google</li>
                                    <li><strong>Erro:</strong> WP_Error se falhar</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h4>📂 Ordenação de Arquivos</h4>
                    <div class="card">
                        <code>salvar_ordenacao_arquivos()</code>
                        <p>Sistema de ordenação customizada para arquivos</p>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Armazenamento:</strong> Arquivo <code>.order.ini</code></li>
                            <li><strong>Formato:</strong> Serialized PHP array</li>
                            <li><strong>Segurança:</strong> Nonce verification</li>
                            <li><strong>Permissões:</strong> <code>edit_posts</code> required</li>
                        </ul>
                    </div>

                    <h3>🎯 Funcionalidades Diversas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Breadcrumbs</span>
                        <span class="tech-item">Calendário</span>
                        <span class="tech-item">Tipos Dinâmicos</span>
                        <span class="tech-item">Thumbnails</span>
                        <span class="tech-item">Media Upload</span>
                        <span class="tech-item">URL Helpers</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Integração com WordPress</h4>
                        <p>Este módulo se integra profundamente com o WordPress através de:</p>
                        <ul style="list-style-position: inside;">
                            <li><strong>Hooks:</strong> <code>wp_enqueue_scripts</code>, <code>admin_enqueue_scripts</code>
                            </li>
                            <li><strong>AJAX:</strong> <code>wp_ajax_*</code> para funcionalidades assíncronas</li>
                            <li><strong>APIs:</strong> Media, Users, Posts, Email</li>
                            <li><strong>Security:</strong> Nonce, Capabilities, Sanitization</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Plugin Login -->
                <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="login-tab">
                    <h2>🔐 Sistema de Autenticação<span>/wp-content/plugins/novoicode/includes/src/login.php</span></h2>
                    <p>Sistema completo de autenticação customizada integrando LDAP IC, reCAPTCHA v3 e gestão de sessões.
                    </p>

                    <h3>🎯 Visão Geral</h3>
                    <div class="card">
                        <p>Módulo responsável por todo o fluxo de autenticação do sistema ICODE, incluindo:</p>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Login personalizado</strong> - Página customizada em /login</li>
                            <li><strong>Integração LDAP IC</strong> - Autenticação com servidor do Instituto</li>
                            <li><strong>Proteção reCAPTCHA v3</strong> - Prevenção contra bots</li>
                            <li><strong>Gestão de sessões</strong> - Controle de acesso e redirecionamentos</li>
                            <li><strong>Permissões dinâmicas</strong> - Atribuição automática de papéis</li>
                        </ul>
                    </div>

                    <h3>🔄 Fluxo de Autenticação</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>1. 🚀 Inicialização</h4>
                            <code>start_session_if_not_started()</code>
                            <p>Inicia sessão PHP se não estiver ativa</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Hook:</strong> <code>init</code></li>
                                <li><strong>Verificação:</strong> <code>session_id()</code></li>
                                <li><strong>Ação:</strong> <code>session_start()</code></li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>2. 🎨 Personalização Login</h4>
                            <code>tf_wp_admin_login_customization()</code>
                            <p>Customiza visual do login admin do WordPress</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Favicon:</strong> Logo das configurações</li>
                                <li><strong>Background:</strong> Cor personalizada</li>
                                <li><strong>Logo:</strong> Imagem do sistema</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>3. 🔀 Redirecionamentos</h4>
                            <p>Sistema inteligente de navegação</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Login padrão → /login</strong></li>
                                <li><strong>Logados em /login → /perfil</strong></li>
                                <li><strong>Logout → /login</strong></li>
                                <li><strong>Login sucesso → /perfil</strong></li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>4. 🛡️ Autenticação</h4>
                            <code>custom_wp_authenticate()</code>
                            <p>Processo principal de login</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>reCAPTCHA v3</strong> - Verificação</li>
                                <li><strong>LDAP IC</strong> - Autenticação</li>
                                <li><strong>WordPress</strong> - Criação/Atualização</li>
                                <li><strong>Permissões</strong> - Atribuição</li>
                            </ul>
                        </div>
                    </div>

                    <h3>🔐 Integração LDAP IC</h3>

                    <h4>🔑 Autenticação</h4>
                    <div class="card">
                        <code>usuarioIClogin($username, $password)</code>
                        <p>Valida credenciais no servidor de autenticação do IC</p>

                        <h5>📤 Requisição:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        POST https://auth.ic.unicamp.br/login
        Body: username={username}&password={password}
                </code>

                        <h5>📥 Resposta Esperada:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>username_ic</strong> - Identificador único</li>
                            <li><strong>nome</strong> - Nome completo</li>
                            <li><strong>username_unicamp</strong> - Usuário Unicamp</li>
                        </ul>
                    </div>

                    <h4>👤 Dados do Usuário</h4>
                    <div class="card">
                        <code>usuarioICdados($usernameic)</code>
                        <p>Obtém informações detalhadas do usuário via LDAP</p>

                        <h5>🎯 Tipos de Referência:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>lab</strong> - Para usuários RA (ra{6 dígitos})</li>
                            <li><strong>ic</strong> - Para outros usuários</li>
                        </ul>

                        <h5>📋 Dados Retornados:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>mail</strong> - Email institucional</li>
                            <li><strong>givenname</strong> - Primeiro nome</li>
                            <li><strong>sn</strong> - Sobrenome</li>
                        </ul>
                    </div>

                    <h3>⚙️ Gestão de Usuários</h3>

                    <h4>🎭 Atualização de Permissões</h4>
                    <div class="card">
                        <code>atualizar_permissoes_usuario($user_id, $email)</code>
                        <p>Sistema dinâmico de atribuição de permissões</p>

                        <h5>📊 Regras de Permissão:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Tipo</th>
                                    <th style="padding: 0.3rem; text-align: left;">Admin/Editor</th>
                                    <th style="padding: 0.3rem; text-align: left;">Usuário Comum</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>membro</strong></td>
                                    <td style="padding: 0.3rem;">✅ Todos os tipos</td>
                                    <td style="padding: 0.3rem;">🔄 <code>retorna_membro($email)</code>&ensp;<small>(veja: Plugin/User)</small></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>arquivo_privado</strong></td>
                                    <td style="padding: 0.3rem;">✅ Todos os tipos</td>
                                    <td style="padding: 0.3rem;">🔍 Verificação por colegiado</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><strong>post_privado</strong></td>
                                    <td style="padding: 0.3rem;">✅ Todos os tipos</td>
                                    <td style="padding: 0.3rem;">❌ Negado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h4>🖼️ Gestão de Avatar</h4>
                    <div class="card">
                        <code>atualizar_avatar_usuario($user_id, $email)</code>
                        <p>Sistema automático de avatar a partir da intranet</p>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Fonte:</strong> <code>retornaPhoto($email)</code></li>
                            <li><strong>Importação:</strong> <code>importar_imagem_para_midia()</code></li>
                            <li><strong>Armazenamento:</strong> Meta <code>wp_user_avatar</code></li>
                        </ul>
                    </div>

                    <h3>🛡️ Sistema de Segurança</h3>

                    <h4>🤖 Proteção reCAPTCHA v3</h4>
                    <div class="card">
                        <code>verify_recaptcha($username)</code>
                        <p>Validação de token reCAPTCHA para prevenir bots</p>

                        <h5>📋 Requisitos:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Token:</strong> Presente no POST</li>
                            <li><strong>Score:</strong> Mínimo 0.5</li>
                            <li><strong>Success:</strong> true da API Google</li>
                            <li><strong>Exceção:</strong> Usuário admin</li>
                        </ul>

                        <h5>🔗 API Call:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        POST https://www.google.com/recaptcha/api/siteverify
        Body: secret={SECRET_KEY}&response={TOKEN}&remoteip={IP}
                </code>
                    </div>

                    <h4>🔒 Processo de Autenticação Principal</h4>
                    <div class="card">
                        <code>custom_wp_authenticate($user, $username, $password)</code>
                        <p>Fluxo completo de autenticação customizada</p>

                        <h5>🔄 Fluxo Detalhado:</h5>
                        <ol style="margin-left: 1rem;">
                            <li><strong>Validação:</strong> Credenciais não vazias</li>
                            <li><strong>Admin Check:</strong> Login WordPress para admin</li>
                            <li><strong>reCAPTCHA:</strong> Verificação para outros usuários</li>
                            <li><strong>LDAP Auth:</strong> <code>usuarioIClogin()</code></li>
                            <li><strong>LDAP Data:</strong> <code>usuarioICdados()</code></li>
                            <li><strong>User Management:</strong> Criação/Atualização</li>
                            <li><strong>Permissions:</strong> <code>atualizar_permissoes_usuario()</code></li>
                            <li><strong>Avatar:</strong> <code>atualizar_avatar_usuario()</code></li>
                            <li><strong>Login:</strong> <code>realizar_login_usuario()</code></li>
                            <li><strong>Redirect:</strong> Para /perfil</li>
                        </ol>
                    </div>

                    <h3>🚪 Sistema de Logout</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🔍 Detecção</h4>
                            <code>icode_check_logout()</code>
                            <p>Monitora requisições de logout</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Parâmetro:</strong> <code>?icode_logout=1</code></li>
                                <li><strong>Hook:</strong> <code>init</code></li>
                                <li><strong>Ação:</strong> Chama <code>icode_logout()</code></li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>🗑️ Execução</h4>
                            <code>icode_logout()</code>
                            <p>Processo completo de logout</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Sessão:</strong> Destroy PHP session</li>
                                <li><strong>WordPress:</strong> <code>wp_logout()</code></li>
                                <li><strong>Redirect:</strong> Para /login</li>
                            </ul>
                        </div>
                    </div>

                    <h3>🎯 Funcionalidades de Login</h3>
                    <div class="tech-stack">
                        <span class="tech-item">LDAP Integration</span>
                        <span class="tech-item">reCAPTCHA v3</span>
                        <span class="tech-item">Session Management</span>
                        <span class="tech-item">Dynamic Roles</span>
                        <span class="tech-item">Auto Avatar</span>
                        <span class="tech-item">Custom Redirects</span>
                        <span class="tech-item">User Auto-Create</span>
                        <span class="tech-item">Permission System</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Características Especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>Admin Local:</strong> Apenas usuário 'admin' usa autenticação WordPress padrão</li>
                            <li><strong>Logs Detalhados:</strong> Extensive error logging para debugging</li>
                            <strong>Permissões Dinâmicas:</strong> Atualizadas a cada login baseado no email</li>
                            <li><strong>Integração Total:</strong> Com sistemas existentes do IC/Unicamp</li>
                            <li><strong>Segurança Robusta:</strong> Múltiplas camadas de proteção</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Plugin PDF -->
                <div class="tab-pane fade" id="pdf" role="tabpanel" aria-labelledby="pdf-tab">
                    <h2>📄 Sistema de Gestão de PDF<span>/wp-content/plugins/novoicode/includes/src/pdf.php</span></h2>
                    <p>Módulo completo para processamento, indexação, conversão e busca de documentos PDF no sistema ICODE.
                    </p>

                    <h3>🎯 Funcionalidades Principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🔍 Busca em PDF</h4>
                            <p>Integração com busca do WordPress para pesquisar dentro de documentos PDF</p>
                            <code>pre_get_posts filter</code>
                        </div>
                        <div class="card">
                            <h4>🔄 Conversão DOC→PDF</h4>
                            <p>Conversão automática de documentos Word para PDF usando LibreOffice</p>
                            <code>novoicode_converter_pdf()</code>
                        </div>
                        <div class="card">
                            <h4>📑 Junção de PDFs</h4>
                            <p>Fusão de múltiplos PDFs em um único documento usando Ghostscript</p>
                            <code>novoicode_exportar_pdf()</code>
                        </div>
                        <div class="card">
                            <h4>🏷️ Indexação Full-Text</h4>
                            <p>Indexação de conteúdo PDF para busca textual usando Smalot PDF Parser</p>
                            <code>novoicode_indexar_pdf()</code>
                        </div>
                    </div>

                    <h3>🔍 Sistema de Busca em PDF</h3>
                    <div class="card">
                        <code>pre_get_posts filter</code>
                        <p>Integra resultados de PDFs nas buscas do WordPress</p>

                        <h5>📋 Fluxo de Busca:</h5>
                        <ol style="margin-left: 1rem;">
                            <li><strong>Intercepta:</strong> Query de busca principal</li>
                            <li><strong>Consulta:</strong> Tabela <code>pdf_index</code> por termo</li>
                            <li><strong>Filtra:</strong> Adiciona resultados ao <code>the_content</code></li>
                            <li><strong>Exibe:</strong> Lista de PDFs encontrados</li>
                        </ol>

                        <h5>🔍 Query de Busca:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        SELECT arquivo FROM {prefix}_pdf_index WHERE texto LIKE '%{termo}%'
                </code>
                    </div>

                    <h3>🔄 Sistema de Conversão DOC→PDF</h3>
                    <div class="card">
                        <code>novoicode_converter_pdf()</code>
                        <p>Conversão de documentos Word para PDF usando LibreOffice headless</p>

                        <h5>📋 Validações:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Parâmetros:</strong> Paths e destino obrigatórios</li>
                            <li><strong>Arquivos:</strong> Apenas .doc e .docx</li>
                            <li><strong>Destino:</strong> Diretório com permissão de escrita</li>
                            <li><strong>Existência:</strong> Verifica se arquivos existem</li>
                        </ul>

                        <h5>⚙️ Comando LibreOffice:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        export HOME=/var/www && export XDG_CONFIG_HOME=/var/www/.config && export XDG_CACHE_HOME=/var/www/.cache && soffice --headless --convert-to pdf --outdir {destPath} {arquivos}
                </code>

                        <h5>📤 Resposta JSON:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>sucesso:</strong> true/false</li>
                            <li><strong>mensagem:</strong> Feedback do processo</li>
                            <li><strong>arquivos:</strong> Quantidade processada</li>
                        </ul>
                    </div>

                    <h3>📑 Sistema de Junção de PDFs</h3>
                    <div class="card">
                        <code>novoicode_exportar_pdf()</code>
                        <p>Fusão de múltiplos PDFs em um único arquivo usando Ghostscript</p>

                        <h5>🔄 Comportamento Inteligente:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Destino Existente:</strong> Adiciona ao início da fusão</li>
                            <li><strong>Arquivo Temporário:</strong> Cria em <code>sys_get_temp_dir()</code></li>
                            <li><strong>Validação:</strong> Apenas arquivos .pdf</li>
                            <li><strong>Segurança:</strong> <code>escapeshellarg()</code> para paths</li>
                        </ul>

                        <h5>⚙️ Comando Ghostscript:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile={destPath} {arquivos}
                </code>

                        <h5>📤 Resposta JSON:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>url:</strong> URL acessível do PDF gerado</li>
                            <li><strong>caminho:</strong> Caminho físico do arquivo</li>
                            <li><strong>arquivos:</strong> Quantidade fundida</li>
                        </ul>
                    </div>

                    <h3>🏷️ Sistema de Indexação PDF</h3>
                    <div class="card">
                        <code>novoicode_indexar_pdf()</code>
                        <p>Indexação full-text de documentos PDF para busca</p>

                        <h5>📊 Gerenciamento de Índice:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Limpeza:</strong> Remove indexações de diretórios excluídos</li>
                            <li><strong>Verificação:</strong> Confirma existência física dos arquivos</li>
                            <li><strong>Duplicação:</strong> Evita reindexação desnecessária</li>
                            <li><strong>Timeout:</strong> <code>set_time_limit(300)</code> para processamento</li>
                        </ul>

                        <h5>🔍 Processo de Indexação:</h5>
                        <ol style="margin-left: 1rem;">
                            <li><strong>Parser:</strong> <code>Smalot\PdfParser\Parser</code></li>
                            <li><strong>Extração:</strong> <code>$pdf->getText()</code></li>
                            <li><strong>Limite:</strong> 100.000 caracteres por documento</li>
                            <li><strong>Armazenamento:</strong> Tabela <code>pdf_index</code></li>
                        </ol>

                        <h5>🗃️ Estrutura da Tabela:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Campo</th>
                                    <th style="padding: 0.3rem; text-align: left;">Tipo</th>
                                    <th style="padding: 0.3rem; text-align: left;">Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>arquivo</code></td>
                                    <td style="padding: 0.3rem;">VARCHAR(255)</td>
                                    <td style="padding: 0.3rem;">Caminho físico do PDF</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>url</code></td>
                                    <td style="padding: 0.3rem;">VARCHAR(255)</td>
                                    <td style="padding: 0.3rem;">URL acessível</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>texto</code></td>
                                    <td style="padding: 0.3rem;">LONGTEXT</td>
                                    <td style="padding: 0.3rem;">Conteúdo extraído</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>tipo</code></td>
                                    <td style="padding: 0.3rem;">VARCHAR(10)</td>
                                    <td style="padding: 0.3rem;">Tipo/colegiado</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>ano</code></td>
                                    <td style="padding: 0.3rem;">INT(4)</td>
                                    <td style="padding: 0.3rem;">Ano do documento</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><code>id_post</code></td>
                                    <td style="padding: 0.3rem;">INT(10)</td>
                                    <td style="padding: 0.3rem;">ID do post relacionado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📂 Sistema de Listagem de PDFs</h3>
                    <div class="card">
                        <code>novoicode_listar_pdfs()</code>
                        <p>Listagem recursiva de todos os PDFs de um tipo/ano específico</p>

                        <h5>🔍 Processo de Varredura:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Recursivo:</strong> <code>RecursiveDirectoryIterator</code></li>
                            <li><strong>Filtro:</strong> Ignora diretório "privado"</li>
                            <li><strong>ID Post:</strong> Extrai do nome do subdiretório</li>
                            <li><strong>URLs:</strong> Converte caminhos físicos para web</li>
                        </ul>

                        <h5>📤 Resposta JSON:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>arquivos:</strong> Array de caminhos físicos</li>
                            <li><strong>urls:</strong> Array de URLs acessíveis</li>
                            <li><strong>ids:</strong> Array de IDs de posts</li>
                            <li><strong>total:</strong> Quantidade total de PDFs</li>
                        </ul>
                    </div>

                    <h3>🔧 Dependências e Requisitos</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📚 Bibliotecas PHP</h4>
                            <ul style="list-style-position: inside; margin-top: 0.5rem;">
                                <li><strong>Smalot PDF Parser</strong> - Extração de texto</li>
                                <li><strong>WordPress DB</strong> - Operações de banco</li>
                                <li><strong>RecursiveIterator</strong> - Varredura de diretórios</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>⚙️ Ferramentas de Sistema</h4>
                            <ul style="list-style-position: inside; margin-top: 0.5rem;">
                                <li><strong>LibreOffice</strong> - Conversão DOC→PDF</li>
                                <li><strong>Ghostscript</strong> - Fusão de PDFs</li>
                                <li><strong>Bash/Shell</strong> - Execução de comandos</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>🗄️ Estrutura de Banco</h4>
                            <ul style="list-style-position: inside; margin-top: 0.5rem;">
                                <li><strong>Tabela:</strong> <code>{prefix}_pdf_index</code></li>
                                <li><strong>Índice:</strong> Campo <code>arquivo</code></li>
                                <li><strong>Chave:</strong> <code>id</code> AUTO_INCREMENT</li>
                            </ul>
                        </div>
                    </div>

                    <h3>🎯 Funcionalidades do Sistema PDF</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Full-Text Search</span>
                        <span class="tech-item">DOC to PDF Conversion</span>
                        <span class="tech-item">PDF Merging</span>
                        <span class="tech-item">Auto Indexing</span>
                        <span class="tech-item">Content Extraction</span>
                        <span class="tech-item">Batch Processing</span>
                        <span class="tech-item">AJAX Interface</span>
                        <span class="tech-item">File Management</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Características Especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>Manutenção Automática:</strong> Limpeza de indexações orphaned</li>
                            <li><strong>Processamento em Lote:</strong> Suporte a múltiplos arquivos</li>
                            <li><strong>Integração Nativa:</strong> Busca transparente com WordPress</li>
                            <li><strong>Gestão de Erros:</strong> Respostas JSON detalhadas</li>
                            <li><strong>Otimização:</strong> Limite de texto e timeouts</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Plugin Permalink -->
                <div class="tab-pane fade" id="permalink" role="tabpanel" aria-labelledby="permalink-tab">
                    <h2>🔗 Sistema de URLs Amigáveis<span>/wp-content/plugins/novoicode/includes/src/permalink.php</span>
                    </h2>
                    <p>Sistema avançado de gerenciamento de permalinks e rewrite rules para os custom post types do ICODE.
                    </p>

                    <h3>🎯 Objetivo do Sistema</h3>
                    <div class="card">
                        <p>Criar URLs amigáveis e semanticamente corretas para todos os colegiados do sistema ICODE,
                            seguindo o padrão:</p>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        /{colegiado}/{ano}/{slug-do-post}/
                </code>
                        <p><strong>Exemplo:</strong> <code>/congrega/2024/reuniao-ordinaria-janeiro/</code></p>
                    </div>

                    <h3>🔄 Sistema de Substituição de Permalinks</h3>
                    <div class="card">
                        <code>replace_category_in_permalink($permalink, $post)</code>
                        <p>Substitui o placeholder <code>%category%</code> nos permalinks dos custom post types</p>

                        <h5>📋 Fluxo de Processamento:</h5>
                        <ol style="margin-left: 1rem;">
                            <li><strong>Filtro:</strong> <code>post_type_link</code> com prioridade 10</li>
                            <li><strong>Verificação:</strong> Apenas para custom post types (não posts normais)</li>
                            <li><strong>Extrai:</strong> Primeira categoria do post usando <code>get_the_terms()</code></li>
                            <li><strong>Substitui:</strong> <code>%category%</code> pelo slug da categoria</li>
                            <li><strong>Fallback:</strong> "sem-categoria" se não houver categoria</li>
                        </ol>

                        <h5>🎯 Estrutura Resultante:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Antes:</strong> <code>/{colegiado}/%category%/{slug}/</code></li>
                            <li><strong>Depois:</strong> <code>/{colegiado}/2024/{slug}/</code></li>
                        </ul>
                    </div>

                    <h3>🛣️ Sistema de Rewrite Rules</h3>

                    <h4>🌐 Regras para Todos os Custom Post Types</h4>
                    <div class="card">
                        <code>custom_rewrite_rules_for_all_post_types()</code>
                        <p>Cria regras dinâmicas para todos os custom post types registrados</p>

                        <h5>📊 Regras Criadas:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Padrão URL</th>
                                    <th style="padding: 0.3rem; text-align: left;">Query WordPress</th>
                                    <th style="padding: 0.3rem; text-align: left;">Prioridade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>^colegiado/?$</code></td>
                                    <td style="padding: 0.3rem;"><code>post_type=colegiado</code></td>
                                    <td style="padding: 0.3rem;">🔝 <strong>top</strong></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><code>^colegiado/([^/]+)/([^/]+)/?$</code></td>
                                    <td style="padding: 0.3rem;"><code>post_type=colegiado&category_name=$1&name=$2</code>
                                    </td>
                                    <td style="padding: 0.3rem;">🔻 <strong>bottom</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🎯 Captura de Parâmetros:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>colegiado:</strong> Tipo do post</li>
                            <li><strong>$1:</strong> Nome da categoria (ano)</li>
                            <li><strong>$2:</strong> Slug do post</li>
                        </ul>
                    </div>

                    <h4>🎯 Regras Específicas para Tipos ICODE</h4>
                    <div class="card">
                        <code>custom_rewrite_rules_for_types()</code>
                        <p>Regras customizadas baseadas nos slugs configurados no sistema</p>

                        <h5>📋 Fonte de Dados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        $slugs_array = explode(',', get_option('portal_input_7'));
                </code>

                        <h5>🔄 Processamento:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Leitura:</strong> Slugs da configuração <code>portal_input_7</code></li>
                            <li><strong>Limpeza:</strong> <code>trim()</code> em cada item</li>
                            <li><strong>Filtro:</strong> Remove entradas vazias</li>
                            <li><strong>Geração:</strong> Cria regras para cada slug</li>
                        </ul>
                    </div>

                    <h3>🔧 Correção de Conflitos</h3>
                    <div class="card">
                        <code>fix_category_rewrite_rules()</code>
                        <p>Garante que categorias normais do WordPress continuem funcionando</p>

                        <h5>🛡️ Regras de Proteção:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Padrão</th>
                                    <th style="padding: 0.3rem; text-align: left;">Propósito</th>
                                    <th style="padding: 0.3rem; text-align: left;">Prioridade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>^category/([^/]+)/?$</code></td>
                                    <td style="padding: 0.3rem;">Categorias WordPress padrão</td>
                                    <td style="padding: 0.3rem;">🔝 <strong>top</strong></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><code>^([0-9]{4})/?$</code></td>
                                    <td style="padding: 0.3rem;">Acesso direto por ano</td>
                                    <td style="padding: 0.3rem;">🔝 <strong>top</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🎯 Estratégia de Prioridades:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Alta (top):</strong> Categorias e arquivos</li>
                            <li><strong>Baixa (bottom):</strong> Posts individuais com categoria</li>
                            <li><strong>Objetivo:</strong> Evitar conflitos entre regras</li>
                        </ul>
                    </div>

                    <h3>🔄 Sistema de Manutenção</h3>
                    <div class="card">
                        <code>flush_rewrite_rules_properly()</code>
                        <p>Limpeza e reconstrução inteligente das regras de rewrite</p>

                        <h5>🔍 Detecção de Mudanças:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Comparação:</strong> Slugs atuais vs última limpeza</li>
                            <li><strong>Armazenamento:</strong> Option <code>last_rewrite_flush_properly</code></li>
                            <li><strong>Condição:</strong> Executa apenas se houver mudanças</li>
                        </ul>

                        <h5>🧹 Processo de Limpeza:</h5>
                        <ol style="margin-left: 1rem;">
                            <li><strong>Remove:</strong> <code>delete_option('rewrite_rules')</code></li>
                            <li><strong>Reconstrói:</strong> <code>flush_rewrite_rules()</code></li>
                            <li><strong>Atualiza:</strong> Option com slugs atuais</li>
                            <li><strong>Log:</strong> Registro para debugging</li>
                        </ol>
                    </div>

                    <h3>🎯 Estrutura de URLs do Sistema</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📁 Página de Arquivo</h4>
                            <code>/{colegiado}/</code>
                            <p>Lista todos os posts do colegiado</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Exemplo:</strong> <code>/congrega/</code></li>
                                <li><strong>Query:</strong> <code>post_type=congrega</code></li>
                                <li><strong>Prioridade:</strong> top</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>📄 Post Individual</h4>
                            <code>/{colegiado}/{ano}/{slug}/</code>
                            <p>Post específico com categoria/ano</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Exemplo:</strong> <code>/congrega/2024/reuniao-janeiro/</code></li>
                                <li><strong>Query:</strong>
                                    <code>post_type=congrega&category_name=2024&name=reuniao-janeiro</code>
                                </li>
                                <li><strong>Prioridade:</strong> bottom</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>📅 Categoria/Ano</h4>
                            <code>/category/{ano}/</code>
                            <p>Página de categoria padrão WordPress</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Exemplo:</strong> <code>/category/2024/</code></li>
                                <li><strong>Query:</strong> <code>category_name=2024</code></li>
                                <li><strong>Prioridade:</strong> top</li>
                            </ul>
                        </div>
                    </div>

                    <h3>🛠️ Hooks e Filtros Utilizados</h3>
                    <div class="tech-stack">
                        <span class="tech-item">post_type_link</span>
                        <span class="tech-item">init</span>
                        <span class="tech-item">add_rewrite_rule</span>
                        <span class="tech-item">flush_rewrite_rules</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Características Avançadas</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>Dinâmico:</strong> Adapta-se aos tipos configurados</li>
                            <li><strong>Sem Conflitos:</strong> Sistema de prioridades robusto</li>
                            <li><strong>Otimizado:</strong> Reconstrução apenas quando necessário</li>
                            <li><strong>Compatível:</strong> Mantém funcionalidades WordPress</li>
                            <li><strong>Semântico:</strong> URLs descritivas e organizadas</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Plugin Types -->
                <div class="tab-pane fade" id="types" role="tabpanel" aria-labelledby="types-tab">
                    <h2>🏛️ Sistema de Custom Post Types
                        Dinâmicos<span>/wp-content/plugins/novoicode/includes/src/types.php</span></h2>
                    <p>Sistema completo para criação dinâmica de custom post types baseado nas configurações do sistema
                        ICODE.</p>

                    <h3>🎯 Visão Geral</h3>
                    <div class="card">
                        <p>Cria automaticamente custom post types para cada colegiado configurado no sistema, incluindo:</p>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Post Types Dinâmicos</strong> - Baseados em configurações</li>
                            <li><strong>Submenus Administrativos</strong> - Integração com menu ICODE</li>
                            <li><strong>Sistema de Permissões</strong> - Capabilities customizadas</li>
                            <li><strong>Meta Boxes Dinâmicos</strong> - Campos específicos por tipo</li>
                            <li><strong>Interface Otimizada</strong> - Reorganização de metaboxes</li>
                        </ul>
                    </div>

                    <h3>🔄 Criação de Custom Post Types</h3>
                    <div class="card">
                        <code>create_custom_post_types_dinamicos()</code>
                        <p>Cria dinamicamente os custom post types baseado nas configurações</p>

                        <h5>📋 Fontes de Configuração:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Option</th>
                                    <th style="padding: 0.3rem; text-align: left;">Conteúdo</th>
                                    <th style="padding: 0.3rem; text-align: left;">Exemplo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>portal_input_6</code></td>
                                    <td style="padding: 0.3rem;">Nomes dos tipos</td>
                                    <td style="padding: 0.3rem;">Congrega,CI,DSC,DSI,DTC,CDI</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><code>portal_input_7</code></td>
                                    <td style="padding: 0.3rem;">Slugs dos tipos</td>
                                    <td style="padding: 0.3rem;">congrega,ci,dsc,dsi,dtc,cdi</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>⚙️ Configuração do Post Type:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Supports:</strong> title, editor, revisions</li>
                            <li><strong>Taxonomies:</strong> category (para anos)</li>
                            <li><strong>Rewrite:</strong> <code>{slug}/%category%</code></li>
                            <li><strong>Capability:</strong> <code>post</code> + <code>{slug}</code></li>
                            <li><strong>Archive:</strong> true (página de lista)</li>
                            <li><strong>Menu Icon:</strong> dashicons-groups</li>
                        </ul>
                    </div>

                    <h3>🍔 Sistema de Menu Administrativo</h3>
                    <div class="card">
                        <code>add_custom_post_types_submenus()</code>
                        <p>Adiciona submenus dinâmicos para cada tipo no menu principal ICODE</p>

                        <h5>🎯 Estrutura do Menu:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Menu Principal</th>
                                    <th style="padding: 0.3rem; text-align: left;">Submenu</th>
                                    <th style="padding: 0.3rem; text-align: left;">URL</th>
                                    <th style="padding: 0.3rem; text-align: left;">Capacidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 0.3rem;">ICODE</td>
                                    <td style="padding: 0.3rem;">Congrega</td>
                                    <td style="padding: 0.3rem;"><code>edit.php?post_type=congrega</code></td>
                                    <td style="padding: 0.3rem;">edit_posts</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔧 Função de Adição:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        add_submenu_page('icode', $nome, $nome, 'edit_posts', 'edit.php?post_type=' . $slug)
                </code>
                    </div>

                    <h3>👮 Sistema de Permissões</h3>
                    <div class="card">
                        <code>add_capabilities_to_roles_custom_types()</code>
                        <p>Atribui capabilities específicas para editores e administradores</p>

                        <h5>🎯 Roles Afetados:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>editor</strong> - Usuários com permissão de edição</li>
                            <li><strong>administrator</strong> - Administradores do sistema</li>
                        </ul>

                        <h5>🔑 Capabilities Adicionadas:</h5>
                        <div class="grid" style="margin-top: 0.5rem;">
                            <div class="card">
                                <h6>📖 Leitura</h6>
                                <ul style="list-style-position: inside; font-size: 0.8rem;">
                                    <li><code>read_{slug}</code></li>
                                    <li><code>read_private_{slug}</code></li>
                                </ul>
                            </div>
                            <div class="card">
                                <h6>✏️ Edição</h6>
                                <ul style="list-style-position: inside; font-size: 0.8rem;">
                                    <li><code>edit_{slug}</code></li>
                                    <li><code>edit_others_{slug}</code></li>
                                    <li><code>edit_published_{slug}</code></li>
                                </ul>
                            </div>
                            <div class="card">
                                <h6>🚀 Publicação</h6>
                                <ul style="list-style-position: inside; font-size: 0.8rem;">
                                    <li><code>publish_{slug}</code></li>
                                </ul>
                            </div>
                            <div class="card">
                                <h6>🗑️ Exclusão</h6>
                                <ul style="list-style-position: inside; font-size: 0.8rem;">
                                    <li><code>delete_others_{slug}</code></li>
                                    <li><code>delete_private_{slug}</code></li>
                                    <li><code>delete_published_{slug}</code></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h3>📦 Sistema de Meta Boxes Dinâmicos</h3>

                    <h4>🔧 Criação dos Meta Boxes</h4>
                    <div class="card">
                        <code>add_dynamic_meta_boxes()</code>
                        <p>Cria meta boxes específicos para cada tipo de post</p>

                        <h5>🎯 Meta Boxes Criados:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Meta Box</th>
                                    <th style="padding: 0.3rem; text-align: left;">Função</th>
                                    <th style="padding: 0.3rem; text-align: left;">Contexto</th>
                                    <th style="padding: 0.3rem; text-align: left;">Prioridade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">Reunião Privada</td>
                                    <td style="padding: 0.3rem;"><code>render_privado_field</code></td>
                                    <td style="padding: 0.3rem;">side</td>
                                    <td style="padding: 0.3rem;">default</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">Data da Reunião</td>
                                    <td style="padding: 0.3rem;"><code>render_date_field</code></td>
                                    <td style="padding: 0.3rem;">advanced</td>
                                    <td style="padding: 0.3rem;">default</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;">Membros</td>
                                    <td style="padding: 0.3rem;"><code>render_member_field</code></td>
                                    <td style="padding: 0.3rem;">advanced</td>
                                    <td style="padding: 0.3rem;">default</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h4>🎨 Renderização dos Campos</h4>
                    <div class="grid">
                        <div class="card">
                            <h5>🔒 Campo Privado</h5>
                            <code>render_privado_field()</code>
                            <p>Checkbox para marcar reunião como privada</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Tipo:</strong> Checkbox</li>
                                <li><strong>Valor:</strong> 1 (marcado) ou 0 (desmarcado)</li>
                                <li><strong>Meta Key:</strong> <code>{slug}_privado</code></li>
                                <li><strong>Função:</strong> <code>get_post_meta()</code> + <code>checked()</code></li>
                            </ul>
                        </div>

                        <div class="card">
                            <h5>📅 Campo Data</h5>
                            <code>render_date_field()</code>
                            <p>Input datetime-local para data da reunião</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Tipo:</strong> datetime-local</li>
                                <li><strong>Ícone:</strong> <code>bx bxs-up-arrow-square</code></li>
                                <li><strong>Meta Key:</strong> <code>{slug}_date</code></li>
                                <li><strong>Sanitização:</strong> <code>sanitize_text_field</code></li>
                            </ul>
                        </div>

                        <div class="card">
                            <h5>👥 Campo Membros</h5>
                            <code>render_member_field()</code>
                            <p>Editor WYSIWYG para composição de membros</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Tipo:</strong> Editor WordPress</li>
                                <li><strong>Fonte:</strong> Intranet via shortcode</li>
                                <li><strong>Meta Key:</strong> <code>{slug}_member</code></li>
                                <li><strong>Sanitização:</strong> <code>wp_kses_post</code></li>
                            </ul>
                        </div>
                    </div>

                    <h3>🎨 Otimização da Interface</h3>
                    <div class="card">
                        <p>Reorganização inteligente dos meta boxes na tela de edição</p>

                        <h5>🔄 Fluxo de Reorganização:</h5>
                        <ol style="margin-left: 1rem;">
                            <li><strong>After Title:</strong> Meta boxes "advanced" movidos para após o título</li>
                            <li><strong>After Editor:</strong> Meta boxes "default" movidos para após o editor</li>
                            <li><strong>Remoção:</strong> Meta boxes originais removidos para evitar duplicação</li>
                        </ol>

                        <h5>🎯 Hooks Utilizados:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><code>edit_form_after_title</code> - Para meta boxes avançados</li>
                            <li><code>edit_form_after_editor</code> - Para meta boxes padrão</li>
                        </ul>
                    </div>

                    <h3>💾 Sistema de Salvamento</h3>
                    <div class="card">
                        <code>save_dynamic_postmeta()</code>
                        <p>Salvamento seguro dos meta fields customizados</p>

                        <h5>🛡️ Verificações de Segurança:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Autosave:</strong> <code>DOING_AUTOSAVE</code> check</li>
                            <li><strong>Revision:</strong> <code>wp_is_post_revision</code> check</li>
                            <li><strong>Permissions:</strong> <code>current_user_can('edit_post')</code></li>
                            <li><strong>Post Type:</strong> Verifica se é um tipo ICODE válido</li>
                        </ul>

                        <h5>💾 Campos Salvos:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Campo</th>
                                    <th style="padding: 0.3rem; text-align: left;">Tipo</th>
                                    <th style="padding: 0.3rem; text-align: left;">Sanitização</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>{slug}_privado</code></td>
                                    <td style="padding: 0.3rem;">Checkbox</td>
                                    <td style="padding: 0.3rem;">'1' ou '0'</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>{slug}_date</code></td>
                                    <td style="padding: 0.3rem;">Datetime</td>
                                    <td style="padding: 0.3rem;"><code>sanitize_text_field</code></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><code>{slug}_member</code></td>
                                    <td style="padding: 0.3rem;">HTML</td>
                                    <td style="padding: 0.3rem;"><code>wp_kses_post</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🎯 Funcionalidades do Sistema</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Dynamic CPTs</span>
                        <span class="tech-item">Admin Menus</span>
                        <span class="tech-item">Custom Capabilities</span>
                        <span class="tech-item">Meta Boxes</span>
                        <span class="tech-item">UI Optimization</span>
                        <span class="tech-item">Auto Configuration</span>
                        <span class="tech-item">Security</span>
                        <span class="tech-item">Integration</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Características Especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>Totalmente Dinâmico:</strong> Adapta-se às configurações</li>
                            <li><strong>Integração Completa:</strong> Menu, permissões e interface</li>
                            <li><strong>Segurança Robusta:</strong> Verificações em múltiplos níveis</li>
                            <li><strong>UX Otimizado:</strong> Interface reorganizada e intuitiva</li>
                            <li><strong>Manutenível:</strong> Código centralizado e reutilizável</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Plugin User -->
                <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                    <h2>👥 Sistema de Gestão de Usuários<span>/wp-content/plugins/novoicode/includes/src/user.php</span>
                    </h2>
                    <p>Sistema completo para integração com dados de usuários da intranet do IC e gestão de membros dos
                        colegiados.</p>

                    <h3>🎯 Funcionalidades Principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🎓 Docentes IC</h4>
                            <p>Integração com lista de docentes ativos do Instituto</p>
                            <code>lista_docentes_intranet()</code>
                        </div>
                        <div class="card">
                            <h4>💼 Funcionários IC</h4>
                            <p>Integração com lista de funcionários ativos do Instituto</p>
                            <code>lista_funcionarios_intranet()</code>
                        </div>
                        <div class="card">
                            <h4>🏛️ Membros Colegiados</h4>
                            <p>Busca de composição dos colegiados por departamento</p>
                            <code>lista_usuarios_colegiado()</code>
                        </div>
                        <div class="card">
                            <h4>🔍 Verificação de Membro</h4>
                            <p>Sistema hierárquico para determinar perfil de acesso</p>
                            <code>retorna_membro()</code>
                        </div>
                    </div>

                    <h3>🎓 Sistema de Docentes</h3>
                    <div class="card">
                        <code>lista_docentes_intranet()</code>
                        <p>Obtém lista completa de docentes ativos do IC via API da intranet</p>

                        <h5>🔗 Endpoint da API:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        GET $INTRANET/docentes/siteic
                </code>

                        <h5>📊 Estrutura de Dados Processada:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Campo</th>
                                    <th style="padding: 0.3rem; text-align: left;">Descrição</th>
                                    <th style="padding: 0.3rem; text-align: left;">Fonte API</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>nome</strong></td>
                                    <td style="padding: 0.3rem;">Nome completo</td>
                                    <td style="padding: 0.3rem;">Nome</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>photo_url</strong></td>
                                    <td style="padding: 0.3rem;">Foto pessoal</td>
                                    <td style="padding: 0.3rem;">Foto Pessoal</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>cargo</strong></td>
                                    <td style="padding: 0.3rem;">Cargo acadêmico</td>
                                    <td style="padding: 0.3rem;">Cargo</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>email</strong></td>
                                    <td style="padding: 0.3rem;">Email institucional</td>
                                    <td style="padding: 0.3rem;">Email</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>departamento</strong></td>
                                    <td style="padding: 0.3rem;">Sigla do departamento</td>
                                    <td style="padding: 0.3rem;">Extraído de Departamento</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><strong>matricula</strong></td>
                                    <td style="padding: 0.3rem;">Número de matrícula</td>
                                    <td style="padding: 0.3rem;">Matrícula</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔍 Processamento de Departamento:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        preg_match('/ - (\bD[STC][SICT]\b)$/', $departamento, $matches)
                </code>
                        <p>Extrai sigla do departamento (DSC, DSI, DTC) do campo completo</p>
                    </div>

                    <h3>💼 Sistema de Funcionários</h3>
                    <div class="card">
                        <code>lista_funcionarios_intranet()</code>
                        <p>Obtém lista completa de funcionários ativos do IC via API da intranet</p>

                        <h5>🔗 Endpoint da API:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        GET $INTRANET/funcionarios/siteic
                </code>

                        <h5>📊 Campos Adicionais vs Docentes:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>secao</strong> - Seção de lotação (exclusivo funcionários)</li>
                            <li><strong>❌ departamento</strong> - Não aplicável a funcionários</li>
                            <li><strong>❌ lattes</strong> - Não aplicável a funcionários</li>
                        </ul>
                    </div>

                    <h3>🏛️ Sistema de Colegiados</h3>
                    <div class="card">
                        <code>lista_usuarios_colegiado($depto)</code>
                        <p>Obtém lista de emails de todos os membros de um colegiado específico</p>

                        <h5>🔗 Endpoint da API:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        GET $INTRANET/composicao_{depto}/json?modo=short
                </code>

                        <h5>👥 Estrutura Hierárquica Buscada:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Categoria</th>
                                    <th style="padding: 0.3rem; text-align: left;">Cargos/Roles</th>
                                    <th style="padding: 0.3rem; text-align: left;">Campos Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>Liderança</strong></td>
                                    <td style="padding: 0.3rem;">Chefe, Vice-Chefe, Sec. Acad.</td>
                                    <td style="padding: 0.3rem;">email_inst, email_sise</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>Docentes</strong></td>
                                    <td style="padding: 0.3rem;">Corpo docente</td>
                                    <td style="padding: 0.3rem;">email_inst, email_sise</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><strong>Titulares</strong></td>
                                    <td style="padding: 0.3rem;">Membros titulares</td>
                                    <td style="padding: 0.3rem;">email_inst, email_sise</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><strong>Suplentes</strong></td>
                                    <td style="padding: 0.3rem;">Membros suplentes</td>
                                    <td style="padding: 0.3rem;">email_inst, email_sise</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔄 Processamento de Emails:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Coleta:</strong> Todos os emails institucionais e SISE</li>
                            <li><strong>Filtro:</strong> <code>array_filter()</code> para remover vazios</li>
                            <li><strong>Unificação:</strong> <code>array_unique()</code> para evitar duplicatas</li>
                        </ul>
                    </div>

                    <h3>🔍 Sistema Hierárquico de Verificação</h3>
                    <div class="card">
                        <code>retorna_membro($email)</code>
                        <p>Determina os colegiados aos quais um usuário pertence usando lógica hierárquica</p>

                        <h5>🎯 Ordem de Verificação:</h5>
                        <ol style="margin-left: 1rem;">
                            <li><strong>Tipos Obrigatórios:</strong> Acesso garantido a tipos configurados</li>
                            <li><strong>Colegiados:</strong> Verificação por participação ativa</li>
                            <li><strong>Departamento:</strong> Vinculação por lotação acadêmica</li>
                        </ol>

                        <h5>1. 🎯 Tipos Obrigatórios</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        $grupos = array_map('trim', explode(',', get_option('portal_input_10', '')))
                </code>
                        <p>Configuração global que define tipos de acesso obrigatório para todos</p>

                        <h5>2. 🏛️ Verificação em Colegiados</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        in_array($email, lista_usuarios_colegiado($slug), true)
                </code>
                        <p>Verificação estrita de email na lista do colegiado</p>

                        <h5>3. 🎓 Vinculação por Departamento</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Busca:</strong> Email na lista de docentes</li>
                            <li><strong>Extrai:</strong> Departamento do docente</li>
                            <li><strong>Converte:</strong> Para slug (ex: "DSC" → "dsc")</li>
                            <li><strong>Valida:</strong> Se é um tipo configurado válido</li>
                            <li><strong>Adiciona:</strong> Ao array de grupos</li>
                        </ul>

                        <h5>🔄 Processamento Final:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        return array_unique($grupos)
                </code>
                        <p>Remove duplicatas e retorna array limpo</p>
                    </div>

                    <h3>🛠️ Funções Auxiliares</h3>
                    <div class="card">
                        <code>get_tipos_configurados()</code>
                        <p>Função utilitária para obter array de tipos configurados</p>

                        <h5>📋 Processamento:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        array_map('trim', explode(',', get_option('portal_input_7', '')))
                </code>

                        <h5>🎯 Uso no Sistema:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Validação:</strong> Verificar se departamento é tipo válido</li>
                            <li><strong>Iteração:</strong> Loop por todos os tipos configurados</li>
                            <li><strong>Filtro:</strong> Apenas tipos existentes nas configurações</li>
                        </ul>
                    </div>

                    <h3>🛡️ Sistema de Tratamento de Erros</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🔗 Erros de Conexão</h4>
                            <code>is_wp_error($response)</code>
                            <p>Verifica erros na requisição HTTP</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Log:</strong> <code>error_log()</code> com mensagem</li>
                                <li><strong>Retorno:</strong> Array vazio <code>[]</code></li>
                                <li><strong>JSON:</strong> <code>'[]'</code> para manter estrutura</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>📄 Erros de JSON</h4>
                            <code>json_last_error() !== JSON_ERROR_NONE</code>
                            <p>Valida parsing de resposta JSON</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Detecção:</strong> <code>json_last_error()</code></li>
                                <li><strong>Mensagem:</strong> <code>json_last_error_msg()</code></li>
                                <li><strong>Fallback:</strong> Array vazio</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>🔍 Erros de Estrutura</h4>
                            <p>Verificações de estrutura de dados esperada</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Caminho:</strong> <code>isset($data['data']['ativos'])</code></li>
                                <li><strong>Tipo:</strong> <code>is_array($data['data']['ativos'])</code></li>
                                <li><strong>Fallback:</strong> Array vazio se estrutura inválida</li>
                            </ul>
                        </div>
                    </div>

                    <h3>🎯 Funcionalidades do Sistema</h3>
                    <div class="tech-stack">
                        <span class="tech-item">API Integration</span>
                        <span class="tech-item">User Management</span>
                        <span class="tech-item">Role Detection</span>
                        <span class="tech-item">Data Processing</span>
                        <span class="tech-item">Error Handling</span>
                        <span class="tech-item">Hierarchical Logic</span>
                        <span class="tech-item">JSON Processing</span>
                        <span class="tech-item">Cache Management</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Características Especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>Integração em Tempo Real:</strong> Dados sempre atualizados da intranet</li>
                            <li><strong>Lógica Hierárquica:</strong> Múltiplas camadas de verificação</li>
                            <strong>Tratamento Robusto:</strong> Sistema resiliente a falhas de API</li>
                            <li><strong>Performance:</strong> Processamento eficiente de grandes datasets</li>
                            <li><strong>Manutenibilidade:</strong> Código modular e reutilizável</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Plugin Usermeta -->
                <div class="tab-pane fade" id="usermeta" role="tabpanel" aria-labelledby="usermeta-tab">
                    <h2>👤 Sistema de Metadados de
                        Usuário<span>/wp-content/plugins/novoicode/includes/src/usermeta.php</span></h2>
                    <p>Sistema completo de gestão de metadados de usuários, incluindo avatares, permissões, papéis e campos
                        customizados.</p>

                    <h3>🎯 Funcionalidades Principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🖼️ Avatar Automático</h4>
                            <p>Sistema de busca e importação de avatares da intranet</p>
                            <code>retornaPhoto() + importar_imagem_para_midia()</code>
                        </div>
                        <div class="card">
                            <h4>🎭 Sistema de Papéis</h4>
                            <p>Atribuição dinâmica de papéis baseada em email</p>
                            <code>papel_usuario() + traduz_papel()</code>
                        </div>
                        <div class="card">
                            <h4>🔐 Controle de Acesso</h4>
                            <p>Sistema granular de permissões por URL e tipo</p>
                            <code>permite_url()</code>
                        </div>
                        <div class="card">
                            <h4>📋 Campos de Perfil</h4>
                            <p>Interface administrativa para metadados customizados</p>
                            <code>adicionar_campo_*_perfil_checkbox()</code>
                        </div>
                    </div>

                    <h3>🖼️ Sistema de Avatar Automático</h3>

                    <h4>🔍 Busca de Avatar</h4>
                    <div class="card">
                        <code>retornaPhoto($email)</code>
                        <p>Busca URL da foto do usuário nas listas da intranet</p>

                        <h5>🔎 Ordem de Busca:</h5>
                        <ol style="margin-left: 1rem;">
                            <li><strong>Docentes:</strong> <code>lista_docentes_intranet()</code></li>
                            <li><strong>Funcionários:</strong> <code>lista_funcionarios_intranet()</code></li>
                            <li><strong>Fallback:</strong> String vazia se não encontrado</li>
                        </ol>

                        <h5>📊 Processamento:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>JSON Decode:</strong> Converte resposta da API</li>
                            <li><strong>Iteração:</strong> Busca email em cada registro</li>
                            <li><strong>Retorno:</strong> <code>photo_url</code> ou string vazia</li>
                        </ul>
                    </div>

                    <h4>📥 Importação para Mídia</h4>
                    <div class="card">
                        <code>importar_imagem_para_midia($image_url, $user_id)</code>
                        <p>Importa imagem da URL para biblioteca de mídia do WordPress</p>

                        <h5>📋 Requisitos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
                </code>

                        <h5>🔄 Fluxo de Importação:</h5>
                        <ol style="margin-left: 1rem;">
                            <li><strong>Download:</strong> <code>download_url($image_url)</code></li>
                            <li><strong>Array File:</strong> Prepara estrutura para upload</li>
                            <li><strong>Sideload:</strong> <code>media_handle_sideload()</code></li>
                            <li><strong>Limpeza:</strong> <code>@unlink($tmp)</code> em caso de erro</li>
                            <li><strong>Retorno:</strong> ID do attachment ou false</li>
                        </ol>
                    </div>

                    <h4>🎨 Filtro de Avatar WordPress</h4>
                    <div class="card">
                        <code>custom_user_avatar_if_available()</code>
                        <p>Substitui o avatar padrão do WordPress pelo avatar customizado</p>

                        <h5>🎯 Hook:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        add_filter('get_avatar', 'custom_user_avatar_if_available', 10, 5)
                </code>

                        <h5>🔍 Identificação do Usuário:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Tipo de Input</th>
                                    <th style="padding: 0.3rem; text-align: left;">Método de Busca</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">ID Numérico</td>
                                    <td style="padding: 0.3rem;"><code>get_user_by('id', $id_or_email)</code></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">Objeto com user_id</td>
                                    <td style="padding: 0.3rem;"><code>get_user_by('id', $id_or_email->user_id)</code></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;">Email String</td>
                                    <td style="padding: 0.3rem;"><code>get_user_by('email', $id_or_email)</code></td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🖼️ Geração do HTML:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        &lt;img alt='{alt}' src='{avatar_url}' class='avatar avatar-{size} photo' height='{size}' width='{size}' /&gt;
                </code>
                    </div>

                    <h3>🎭 Sistema de Papéis e Permissões</h3>

                    <h4>🔧 Definição de Papel</h4>
                    <div class="card">
                        <code>papel_usuario($email)</code>
                        <p>Determina o papel do usuário baseado nas listas de email configuradas</p>

                        <h5>🎯 Hierarquia de Papéis:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Papel</th>
                                    <th style="padding: 0.3rem; text-align: left;">Configuração</th>
                                    <th style="padding: 0.3rem; text-align: left;">Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">👑 Administrator</td>
                                    <td style="padding: 0.3rem;"><code>portal_input_4</code></td>
                                    <td style="padding: 0.3rem;">Acesso total ao sistema</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">✏️ Editor</td>
                                    <td style="padding: 0.3rem;"><code>portal_input_2</code></td>
                                    <td style="padding: 0.3rem;">Permissão de edição</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;">👤 Subscriber</td>
                                    <td style="padding: 0.3rem;">(Padrão)</td>
                                    <td style="padding: 0.3rem;">Acesso básico de leitura</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>⚙️ Processamento:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Normalização:</strong> <code>strtolower()</code> nos emails</li>
                            <li><strong>Conversão:</strong> Option para array com <code>(array)</code></li>
                            <li><strong>Verificação:</strong> <code>in_array()</code> com strict true</li>
                        </ul>
                    </div>

                    <h4>🌐 Tradução de Papéis</h4>
                    <div class="card">
                        <code>traduz_papel($role)</code>
                        <p>Traduz slugs de papéis para nomes amigáveis em português</p>

                        <h5>📚 Mapa de Traduções:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Slug</th>
                                    <th style="padding: 0.3rem; text-align: left;">Tradução</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>administrator</code></td>
                                    <td style="padding: 0.3rem;">Administrador</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>editor</code></td>
                                    <td style="padding: 0.3rem;">Editor</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><code>subscriber</code></td>
                                    <td style="padding: 0.3rem;">Assinante</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🛡️ Fallback:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        return $traducoes[$role] ?? $role;
                </code>
                        <p>Retorna o próprio slug se não houver tradução</p>
                    </div>

                    <h3>🔐 Sistema de Controle de Acesso</h3>
                    <div class="card">
                        <code>permite_url($url, $user_id)</code>
                        <p>Sistema granular de permissão baseado na URL acessada</p>

                        <h5>🔍 Análise da URL:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        $partes_url = explode("/", $url);
        $url_membro = $partes_url[5] ?? '';           // Tipo do colegiado
        $url_membro_arquivo_privado = $partes_url[8] ?? ''; // "privado" se for arquivo privado
                </code>

                        <h5>🎯 Lógica de Permissão:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Tipo de Acesso</th>
                                    <th style="padding: 0.3rem; text-align: left;">Condição</th>
                                    <th style="padding: 0.3rem; text-align: left;">Permissão</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">📄 Conteúdo Público</td>
                                    <td style="padding: 0.3rem;">Arquivo não é "privado"</td>
                                    <td style="padding: 0.3rem;"><code>$tem_acesso_membro</code></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;">🔒 Conteúdo Privado</td>
                                    <td style="padding: 0.3rem;">Arquivo é "privado"</td>
                                    <td style="padding: 0.3rem;"><code>$tem_acesso_membro && $tem_acesso_privado</code></td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>📝 Log de Acesso:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Registro:</strong> Todas as tentativas de acesso</li>
                            <li><strong>Info:</strong> Usuário + resultado da permissão</li>
                            <li><strong>Debug:</strong> Via <code>error_log()</code></li>
                        </ul>
                    </div>

                    <h3>📋 Sistema de Campos de Perfil</h3>

                    <h4>🔧 Função Base de Tipos</h4>
                    <div class="card">
                        <code>get_tipos_membro_dinamicos($tipo)</code>
                        <p>Gera arrays de tipos para os diferentes campos de perfil</p>

                        <h5>🎯 Tipos Suportados:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Parâmetro</th>
                                    <th style="padding: 0.3rem; text-align: left;">Descrição</th>
                                    <th style="padding: 0.3rem; text-align: left;">Exemplo de Label</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>membro</code></td>
                                    <td style="padding: 0.3rem;">Membro básico</td>
                                    <td style="padding: 0.3rem;">"Congrega"</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>post_privado</code></td>
                                    <td style="padding: 0.3rem;">Acesso a posts privados</td>
                                    <td style="padding: 0.3rem;">"Acesso a posts privados do Congrega"</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><code>arquivo_privado</code></td>
                                    <td style="padding: 0.3rem;">Acesso a arquivos privados</td>
                                    <td style="padding: 0.3rem;">"Acesso a arquivos privados do Congrega"</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h4>👥 Campos de Membro</h4>
                    <div class="grid">
                        <div class="card">
                            <h5>🔑 Membro Básico</h5>
                            <code>adicionar_campo_membro_perfil_checkbox()</code>
                            <p>Acesso geral ao colegiado</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Meta Key:</strong> <code>membro</code></li>
                                <li><strong>UI:</strong> Checkboxes desabilitados</li>
                                <li><strong>Fonte:</strong> "seleção automática, fonte: Intranet"</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h5>📝 Posts Privados</h5>
                            <code>adicionar_campo_membro_post_privado_perfil_checkbox()</code>
                            <p>Acesso a posts marcados como privados</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Meta Key:</strong> <code>membro_post_privado</code></li>
                                <li><strong>UI:</strong> Checkboxes desabilitados</li>
                                <li><strong>Nota:</strong> "Acesso a posts privados do {colegiado}"</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h5>📁 Arquivos Privados</h5>
                            <code>adicionar_campo_membro_arquivo_privado_perfil_checkbox()</code>
                            <p>Acesso a arquivos em diretório privado</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Meta Key:</strong> <code>membro_arquivo_privado</code></li>
                                <li><strong>UI:</strong> Checkboxes desabilitados</li>
                                <li><strong>Nota:</strong> "Acesso a arquivos privados do {colegiado}"</li>
                            </ul>
                        </div>
                    </div>

                    <h4>✅ Campo de Aceite</h4>
                    <div class="card">
                        <code>adicionar_campo_aceite_perfil()</code>
                        <p>Checkbox para aceitação dos termos do sistema ICODE</p>

                        <h5>🎯 Características:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Meta Key:</strong> <code>aceite</code></li>
                            <li><strong>Valores:</strong> '1' (aceito) ou '0' (não aceito)</li>
                            <li><strong>Hooks:</strong> <code>show_user_profile</code> + <code>edit_user_profile</code></li>
                            <li><strong>Salvamento:</strong> <code>personal_options_update</code> +
                                <code>edit_user_profile_update</code>
                            </li>
                        </ul>

                        <h5>🔒 Verificação de Permissão:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        if (!current_user_can('edit_user', $user_id)) { return; }
                </code>
                    </div>

                    <h3>🎯 Funcionalidades do Sistema</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Avatar Management</span>
                        <span class="tech-item">Role System</span>
                        <span class="tech-item">Access Control</span>
                        <span class="tech-item">Profile Fields</span>
                        <span class="tech-item">Media Handling</span>
                        <span class="tech-item">Permission Logic</span>
                        <span class="tech-item">User Interface</span>
                        <span class="tech-item">Data Sanitization</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Características Especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>Avatar Automático:</strong> Importação transparente da intranet</li>
                            <li><strong>Permissões Granulares:</strong> Controle fino por tipo de conteúdo</li>
                            <li><strong>Interface Intuitiva:</strong> Campos desabilitados com fonte clara</li>
                            <li><strong>Segurança:</strong> Verificações de capacidade em todas as operações</li>
                            <li><strong>Integração:</strong> Total com sistemas existentes do WordPress</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Plugin Functions -->
                <div class="tab-pane fade" id="functions" role="tabpanel" aria-labelledby="functions-tab">
                    <h2>⚙️ Funções Gerais do Sistema<span>/wp-content/plugins/novoicode/includes/functions.php</span></h2>
                    <p>Módulo com funções utilitárias e de configuração geral do sistema ICODE, incluindo segurança,
                        redirecionamentos e integrações.</p>

                    <h3>🎯 Funcionalidades Principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🔐 Sistema de Sessão</h4>
                            <p>Gestão de sessões PHP para controle de estado</p>
                            <code>iniciar_sessao_personalizada()</code>
                        </div>
                        <div class="card">
                            <h4>🔄 Redirecionamentos</h4>
                            <p>Controle inteligente de navegação e acesso</p>
                            <code>icode_redirect()</code>
                        </div>
                        <div class="card">
                            <h4>🎨 Assets Admin</h4>
                            <p>Carregamento de scripts e estilos no painel</p>
                            <code>styles_and_scripts_plugin()</code>
                        </div>
                        <div class="card">
                            <h4>👮 Controle de Acesso</h4>
                            <p>Gestão de permissões e restrições</p>
                            <code>general_configuration_role_caps()</code>
                        </div>
                    </div>

                    <h3>🔐 Sistema de Sessão</h3>
                    <div class="card">
                        <code>iniciar_sessao_personalizada()</code>
                        <p>Inicializa sessão PHP se não estiver ativa</p>

                        <h5>🎯 Hook:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        add_action('init', 'iniciar_sessao_personalizada')
                </code>

                        <h5>🔍 Verificação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        if (!session_id()) { session_start(); }
                </code>
                        <p>Evita conflitos com sessões já iniciadas</p>
                    </div>

                    <h3>🔄 Sistema de Redirecionamento</h3>
                    <div class="card">
                        <code>icode_redirect()</code>
                        <p>Sistema inteligente de redirecionamento para usuários não autenticados</p>

                        <h5>🎯 Condições de Exceção:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Condição</th>
                                    <th style="padding: 0.3rem; text-align: left;">Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>is_user_logged_in()</code></td>
                                    <td style="padding: 0.3rem;">Usuário já está logado</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>is_page('login')</code></td>
                                    <td style="padding: 0.3rem;">Já está na página de login</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>is_page('googlelogin')</code></td>
                                    <td style="padding: 0.3rem;">Login via Google</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>is_admin()</code></td>
                                    <td style="padding: 0.3rem;">Área administrativa</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>DOING_AJAX</code></td>
                                    <td style="padding: 0.3rem;">Requisições AJAX</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;"><code>REST_REQUEST</code></td>
                                    <td style="padding: 0.3rem;">API REST</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;"><code>wp_doing_cron()</code></td>
                                    <td style="padding: 0.3rem;">Tarefas agendadas</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🎯 Lógica de Redirecionamento:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Página Inicial:</strong> Redireciona para <code>/perfil</code></li>
                            <li><strong>Outras Páginas:</strong> Mantém URL atual</li>
                            <li><strong>Sessão:</strong> Armazena destino em <code>$_SESSION['ldap_login_redirect']</code>
                            </li>
                            <li><strong>URL Final:</strong> <code>/login?redirect_to={url_encoded}</code></li>
                        </ul>

                        <h5>📝 Logs de Debug:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        error_log('Iniciada SESSION no functions.php icode_redirect() ==> ' . $_SESSION['ldap_login_redirect'])
                </code>
                    </div>

                    <h3>🎨 Sistema de Assets do Admin</h3>
                    <div class="card">
                        <code>styles_and_scripts_plugin()</code>
                        <p>Carrega todos os scripts e estilos necessários no painel administrativo</p>

                        <h5>🎯 Hook:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        add_action("admin_enqueue_scripts", "styles_and_scripts_plugin")
                </code>

                        <h5>📦 CSS Carregados:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Biblioteca</th>
                                    <th style="padding: 0.3rem; text-align: left;">URL</th>
                                    <th style="padding: 0.3rem; text-align: left;">Propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">DataTables CSS</td>
                                    <td style="padding: 0.3rem;">CDN 1.10.19</td>
                                    <td style="padding: 0.3rem;">Tabelas interativas</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">DataTables Buttons</td>
                                    <td style="padding: 0.3rem;">CDN 1.5.6</td>
                                    <td style="padding: 0.3rem;">Botões de exportação</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">Bootstrap 5</td>
                                    <td style="padding: 0.3rem;">CDN 5.3.0</td>
                                    <td style="padding: 0.3rem;">Framework CSS</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;">Custom CSS</td>
                                    <td style="padding: 0.3rem;">/wp-content/plugins/novoicode/assets/css/novoicode.css</td>
                                    <td style="padding: 0.3rem;">Estilos personalizados</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>⚡ JavaScript Carregados:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Biblioteca</th>
                                    <th style="padding: 0.3rem; text-align: left;">Dependências</th>
                                    <th style="padding: 0.3rem; text-align: left;">Propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">DataTables</td>
                                    <td style="padding: 0.3rem;">jQuery</td>
                                    <td style="padding: 0.3rem;">Tabelas dinâmicas</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">DataTables Buttons</td>
                                    <td style="padding: 0.3rem;">DataTables</td>
                                    <td style="padding: 0.3rem;">Exportação de dados</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">Bootstrap 5</td>
                                    <td style="padding: 0.3rem;">jQuery</td>
                                    <td style="padding: 0.3rem;">Componentes UI</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;">Custom JS</td>
                                    <td style="padding: 0.3rem;">jQuery</td>
                                    <td style="padding: 0.3rem;">Funcionalidades ICODE</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>👮 Sistema de Controle de Acesso</h3>

                    <h4>🔧 Configuração de Papéis</h4>
                    <div class="card">
                        <code>general_configuration_role_caps()</code>
                        <p>Ajusta permissões específicas para o papel de editor</p>

                        <h5>🎯 Hook:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        add_action('admin_init', 'general_configuration_role_caps', 999)
                </code>

                        <h5>🚫 Permissões Removidas:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><code>list_users</code> - Listar usuários</li>
                            <li><code>create_users</code> - Criar usuários</li>
                            <li><code>remove_users</code> - Remover usuários</li>
                            <li><code>promote_users</code> - Promover usuários</li>
                            <li><code>edit_users</code> - Editar usuários</li>
                        </ul>

                        <h5>✅ Permissões Adicionadas:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><code>manage_options</code> - Gerenciar opções</li>
                            <li><code>edit_posts</code> - Editar posts próprios</li>
                            <li><code>edit_others_posts</code> - Editar posts de outros</li>
                            <li><code>publish_posts</code> - Publicar posts</li>
                            <li><code>delete_posts</code> - Excluir posts próprios</li>
                            <li><code>delete_others_posts</code> - Excluir posts de outros</li>
                        </ul>
                    </div>

                    <h4>🚫 Bloqueio de Admin</h4>
                    <div class="card">
                        <code>bloquear_acesso_admin()</code>
                        <p>Restringe acesso ao /wp-admin para não administradores</p>

                        <h5>🎯 Condições de Permissão:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Administradores:</strong> Acesso total permitido</li>
                            <li><strong>Editores:</strong> Apenas <code>admin-post.php</code></li>
                            <li><strong>AJAX:</strong> Requisições AJAX permitidas</li>
                            <li><strong>Redirecionamento:</strong> Para /404 se bloqueado</li>
                        </ul>

                        <h5>🔍 Detecção de Página Permitida:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        strpos($_SERVER['REQUEST_URI'], 'admin-post.php') !== false
                </code>
                    </div>

                    <h3>📧 Sistema de Email SMTP</h3>
                    <div class="card">
                        <code>configurar_smtp() + wp_smtp()</code>
                        <p>Configuração do sistema de email via SMTP usando constantes definidas</p>

                        <h5>🎯 Hooks:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        add_action('init', 'configurar_smtp')
        add_action('phpmailer_init', 'wp_smtp')
                </code>

                        <h5>⚙️ Configurações SMTP:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.3rem; text-align: left;">Configuração</th>
                                    <th style="padding: 0.3rem; text-align: left;">Constante</th>
                                    <th style="padding: 0.3rem; text-align: left;">Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">Servidor</td>
                                    <td style="padding: 0.3rem;"><code>SMTP_HOST</code></td>
                                    <td style="padding: 0.3rem;">Host do servidor SMTP</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">Autenticação</td>
                                    <td style="padding: 0.3rem;"><code>SMTP_USER</code>/<code>SMTP_PASS</code></td>
                                    <td style="padding: 0.3rem;">Credenciais de login</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">Segurança</td>
                                    <td style="padding: 0.3rem;"><code>SMTP_SECURE</code></td>
                                    <td style="padding: 0.3rem;">SSL/TLS</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.3rem;">Porta</td>
                                    <td style="padding: 0.3rem;"><code>SMTP_PORT</code></td>
                                    <td style="padding: 0.3rem;">Porta do servidor</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.3rem;">Remetente</td>
                                    <td style="padding: 0.3rem;"><code>SMTP_FROM</code>/<code>SMTP_NAME</code></td>
                                    <td style="padding: 0.3rem;">Email e nome do remetente</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📊 Sistema de Registro de Acessos</h3>
                    <div class="card">
                        <code>registerdb($user, $ip, $url)</code>
                        <p>Registra acessos dos usuários no banco de dados para auditoria</p>

                        <h5>🎯 Hook:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        add_action('registerdb', 'registerdb')
                </code>

                        <h5>📋 Valores Padrão:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Usuário:</strong> " --- " se NULL</li>
                            <li><strong>URL:</strong> "/" se NULL</li>
                            <li><strong>IP:</strong> Usa valor fornecido</li>
                            <li><strong>Time:</strong> <code>current_time('mysql')</code></li>
                        </ul>

                        <h5>💾 Inserção no Banco:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        $wpdb->insert($table_name, array('user' => $user, 'ipadress' => $ip, 'url' => $url, 'time' => current_time('mysql')))
                </code>
                    </div>

                    <h3>🔗 Sistema de API IC</h3>
                    <div class="card">
                        <code>icapi($attr)</code>
                        <p>Shortcode para integração com APIs da intranet do IC</p>

                        <h5>🎯 Registro:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        add_shortcode('icapi', 'icapi')
                </code>

                        <h5>📋 Parâmetros Obrigatórios:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>tipo:</strong> Tipo de endpoint da API</li>
                            <li><strong>saida:</strong> Formato de saída desejado</li>
                        </ul>

                        <h5>🔗 Construção da URL:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        $string = INTRANET . "/" . $attr['tipo'] . "/" . $attr['saida']
                </code>

                        <h5>📤 Retorno:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Conteúdo:</strong> Resposta da API via <code>file_get_contents()</code></li>
                            <li><strong>Fonte:</strong> Link para a URL consultada</li>
                            <li><strong>Erro:</strong> Mensagem de erro se parâmetros faltarem</li>
                        </ul>
                    </div>

                    <h3>🎯 Funcionalidades Diversas</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📝 Renomear Menu</h4>
                            <code>wd_admin_menu_rename()</code>
                            <p>Customização de labels do menu administrativo</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Hook:</strong> <code>admin_menu</code></li>
                                <li><strong>Global:</strong> <code>$menu</code> do WordPress</li>
                                <li><strong>Exemplo:</strong> Comentado para "Blog IC"</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>👤 Admin Bar</h4>
                            <code>after_setup_theme hook</code>
                            <p>Controle da barra administrativa superior</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Administradores:</strong> Barra oculta</li>
                                <li><strong>Outros Usuários:</strong> Barra oculta</li>
                                <li><strong>Função:</strong> <code>show_admin_bar(false)</code></li>
                            </ul>
                        </div>

                        <div class="card">
                            <h4>📏 Espaço no Perfil</h4>
                            <code>adicionar_linha_espaco()</code>
                            <p>Adiciona espaçamento no formulário de perfil</p>
                            <ul style="list-style-position: inside; margin-top: 0.5rem; font-size: 0.9rem;">
                                <li><strong>Hooks:</strong> <code>show_user_profile</code> + <code>edit_user_profile</code>
                                </li>
                                <li><strong>Saída:</strong> Duas quebras de linha <code>&lt;br&gt;</code></li>
                            </ul>
                        </div>
                    </div>

                    <h3>🎯 Funcionalidades do Sistema</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Session Management</span>
                        <span class="tech-item">Access Control</span>
                        <span class="tech-item">Asset Loading</span>
                        <span class="tech-item">Role Configuration</span>
                        <span class="tech-item">SMTP Email</span>
                        <span class="tech-item">Audit Logging</span>
                        <span class="tech-item">API Integration</span>
                        <span class="tech-item">Security</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Características Especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>Segurança Robusta:</strong> Múltiplas camadas de proteção</li>
                            <li><strong>UX Otimizado:</strong> Redirecionamentos inteligentes</li>
                            <li><strong>Integração Completa:</strong> APIs e serviços externos</li>
                            <li><strong>Auditoria:</strong> Registro detalhado de acessos</li>
                            <li><strong>Manutenibilidade:</strong> Código organizado e documentado</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Tema Style -->
                <div class="tab-pane fade" id="theme-style" role="tabpanel" aria-labelledby="theme-style-tab">
                    <h2>🎨 Tema novoicode<span>/wp-content/themes/novoicode/style.css</span></h2>
                    <p>Arquivo principal de definição e estilos do tema personalizado ICODE.</p>

                    <h3>📋 Definições do Tema</h3>
                    <div class="card">
                        <h4>🏷️ Cabeçalho WordPress</h4>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">Diretiva</th>
                                    <th style="padding: 0.5rem; text-align: left;">Valor</th>
                                    <th style="padding: 0.5rem; text-align: left;">Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>Theme Name</strong></td>
                                    <td style="padding: 0.5rem;">novoicodeIC Theme</td>
                                    <td style="padding: 0.5rem;">Nome do tema no painel</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>Description</strong></td>
                                    <td style="padding: 0.5rem;">Tema Básico para o sistema novoicodeIC</td>
                                    <td style="padding: 0.5rem;">Descrição do propósito</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>Requires PHP</strong></td>
                                    <td style="padding: 0.5rem;">8.0</td>
                                    <td style="padding: 0.5rem;">Versão mínima do PHP</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>Author</strong></td>
                                    <td style="padding: 0.5rem;">Everton Messias</td>
                                    <td style="padding: 0.5rem;">Desenvolvedor</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;"><strong>Author URI</strong></td>
                                    <td style="padding: 0.5rem;">https://ic.unicamp.br/~everton</td>
                                    <td style="padding: 0.5rem;">URL do autor</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🎯 Características do Tema</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📱 Responsivo</h4>
                            <p>Design adaptável para diferentes dispositivos</p>
                            <code>Mobile First</code>
                        </div>
                        <div class="card">
                            <h4>🎨 Bootstrap 5</h4>
                            <p>Framework CSS para componentes modernos</p>
                            <code>Bootstrap Integration</code>
                        </div>
                        <div class="card">
                            <h4>⚡ Performance</h4>
                            <p>Assets otimizados e carregamento eficiente</p>
                            <code>Optimized Assets</code>
                        </div>
                        <div class="card">
                            <h4>🔧 Customizável</h4>
                            <p>Estrutura modular para fácil manutenção</p>
                            <code>Modular Structure</code>
                        </div>
                    </div>

                    <h3>📁 Estrutura de Arquivos</h3>
                    <div class="card">
                        <h4>🌳 Árvore do Tema</h4>
                        <pre
                            style="background: #2c3e50; color: white; padding: 1rem; border-radius: 5px; overflow-x: auto;">
        novoicode/
        ├── 📄 404.php
        ├── 📄 archive.php
        ├── 📁 assets/
        │   ├── 📁 css/
        │   │   ├── 🎨 novoicode.css
        │   │   └── 🎨 style.css
        │   └── 📁 js/
        │       ├── ⚡ componentChats.js
        │       ├── ⚡ componentMD.js
        │       ├── ⚡ main.js
        │       ├── ⚡ react-dom.js
        │       ├── ⚡ react.js
        │       └── ⚡ react-markdown.js
        ├── 📄 category.php
        ├── 📄 footer.php
        ├── 📄 front-page.php
        ├── 📄 header.php
        ├── 📄 index.php
        ├── 📄 page-arquivos.php
        ├── 📄 page-calendarios.php
        ├── 📄 page-chatgemini.php
        ├── 📄 page-editar.php
        ├── 📄 page-googlelogin.php
        ├── 📄 page-login.php
        ├── 📄 page-novo.php
        ├── 📄 page-perfil.php
        ├── 📄 page-pessoas.php
        ├── 📄 page-relatoriofinanceiro.php
        ├── 📄 page-share.php
        ├── 📄 page-sobre.php
        ├── 📄 page-teste.php
        ├── 🖼️ screenshot.png
        ├── 📄 search.php
        └── 📄 single.php</pre>
                    </div>

                    <h3>🎨 Sistema de Estilos</h3>
                    <div class="card">
                        <h4>📦 Assets CSS</h4>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">Arquivo</th>
                                    <th style="padding: 0.5rem; text-align: left;">Localização</th>
                                    <th style="padding: 0.5rem; text-align: left;">Propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>style.css</strong></td>
                                    <td style="padding: 0.5rem;">/novoicode/style.css</td>
                                    <td style="padding: 0.5rem;">Definições do tema + estilos</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>novoicode.css</strong></td>
                                    <td style="padding: 0.5rem;">/assets/css/novoicode.css</td>
                                    <td style="padding: 0.5rem;">Estilos customizados</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card">
                        <h4>⚡ Assets JavaScript</h4>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">Arquivo</th>
                                    <th style="padding: 0.5rem; text-align: left;">Tecnologia</th>
                                    <th style="padding: 0.5rem; text-align: left;">Funcionalidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>main.js</strong></td>
                                    <td style="padding: 0.5rem;">Vanilla JS</td>
                                    <td style="padding: 0.5rem;">Funcionalidades gerais</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>componentChats.js</strong></td>
                                    <td style="padding: 0.5rem;">React</td>
                                    <td style="padding: 0.5rem;">Componente de chat</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>componentMD.js</strong></td>
                                    <td style="padding: 0.5rem;">React</td>
                                    <td style="padding: 0.5rem;">Markdown render</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;"><strong>react*.js</strong></td>
                                    <td style="padding: 0.5rem;">React</td>
                                    <td style="padding: 0.5rem;">Bibliotecas React</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📄 Templates Principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🏠 Front Page</h4>
                            <p>Página inicial personalizada</p>
                            <code>front-page.php</code>
                        </div>
                        <div class="card">
                            <h4>👤 Páginas de Usuário</h4>
                            <p>Perfil, login, edição</p>
                            <code>page-perfil.php</code>
                            <code>page-login.php</code>
                        </div>
                        <div class="card">
                            <h4>📊 Sistema</h4>
                            <p>Arquivos, relatórios, chat</p>
                            <code>page-arquivos.php</code>
                            <code>page-chatgemini.php</code>
                        </div>
                        <div class="card">
                            <h4>🎯 Utilitários</h4>
                            <p>Calendários, pessoas, sobre</p>
                            <code>page-calendarios.php</code>
                            <code>page-pessoas.php</code>
                        </div>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Características Técnicas</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>PHP 8.0+:</strong> Compatível com versões modernas</li>
                            <li><strong>Bootstrap 5:</strong> Interface responsiva</li>
                            <li><strong>React Components:</strong> Componentes interativos</li>
                            <li><strong>Estrutura Modular:</strong> Fácil manutenção</li>
                            <li><strong>Páginas Customizadas:</strong> Funcionalidades específicas</li>
                        </ul>
                    </div>
                </div>


                <!-- Tab Tema Header -->
                <div class="tab-pane fade" id="theme-header" role="tabpanel" aria-labelledby="theme-header-tab">
                    <h2>🚀 Header do Tema<span>/wp-content/themes/novoicode/header.php</span></h2>
                    <p>Cabeçalho principal do tema com navegação inteligente, sistema de tipos dinâmicos e interface
                        responsiva.</p>

                    <h3>🎯 Funcionalidades Principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📊 Registro de Acesso</h4>
                            <p>Auditoria em tempo real de usuários</p>
                            <code>registerdb()</code>
                        </div>
                        <div class="card">
                            <h4>🎨 Navegação Dinâmica</h4>
                            <p>Menu baseado em tipos e permissões</p>
                            <code>generate_type_links()</code>
                        </div>
                        <div class="card">
                            <h4>🔍 Busca Contextual</h4>
                            <p>Pesquisa específica por tipo</p>
                            <code>url_active()</code>
                        </div>
                        <div class="card">
                            <h4>👥 Perfil Inteligente</h4>
                            <p>Dropdown com avatar e ações</p>
                            <code>wp_get_current_user()</code>
                        </div>
                    </div>

                    <h3>📊 Sistema de Registro de Acessos</h3>
                    <div class="card">
                        <code>registerdb(wp_get_current_user()->user_login, $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'])</code>
                        <p>Registra cada acesso no banco de dados para auditoria</p>

                        <h5>📋 Dados Coletados:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">Campo</th>
                                    <th style="padding: 0.5rem; text-align: left;">Valor</th>
                                    <th style="padding: 0.5rem; text-align: left;">Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>Usuário</strong></td>
                                    <td style="padding: 0.5rem;"><code>wp_get_current_user()->user_login</code></td>
                                    <td style="padding: 0.5rem;">Login do usuário atual</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>IP</strong></td>
                                    <td style="padding: 0.5rem;"><code>$_SERVER['REMOTE_ADDR']</code></td>
                                    <td style="padding: 0.5rem;">Endereço IP do cliente</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;"><strong>URL</strong></td>
                                    <td style="padding: 0.5rem;"><code>$_SERVER['REQUEST_URI']</code></td>
                                    <td style="padding: 0.5rem;">Página acessada</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🎨 Sistema de Tipos Dinâmicos</h3>
                    <div class="card">
                        <h4>⚙️ Configuração dos Tipos</h4>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">Opção</th>
                                    <th style="padding: 0.5rem; text-align: left;">Chave</th>
                                    <th style="padding: 0.5rem; text-align: left;">Formato</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>Nomes</strong></td>
                                    <td style="padding: 0.5rem;"><code>portal_input_6</code></td>
                                    <td style="padding: 0.5rem;">Lista separada por vírgulas</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>Slugs</strong></td>
                                    <td style="padding: 0.5rem;"><code>portal_input_7</code></td>
                                    <td style="padding: 0.5rem;">Lista separada por vírgulas</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;"><strong>Ícones</strong></td>
                                    <td style="padding: 0.5rem;"><code>portal_input_8</code></td>
                                    <td style="padding: 0.5rem;">Classes Bootstrap Icons</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🔗 Geração de Links Dinâmicos</h3>
                    <div class="card">
                        <code>generate_type_links($membro, $nomes_array, $slugs_array, $icons_array, $current_year, $location)</code>
                        <p>Cria links de navegação baseados nas permissões do usuário</p>

                        <h5>🎯 Parâmetros:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">Parâmetro</th>
                                    <th style="padding: 0.5rem; text-align: left;">Tipo</th>
                                    <th style="padding: 0.5rem; text-align: left;">Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>$membro</strong></td>
                                    <td style="padding: 0.5rem;">Array</td>
                                    <td style="padding: 0.5rem;">Tipos do usuário (user_meta)</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><strong>$location</strong></td>
                                    <td style="padding: 0.5rem;">String</td>
                                    <td style="padding: 0.5rem;">'header' ou 'sidebar'</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;"><strong>$current_year</strong></td>
                                    <td style="padding: 0.5rem;">String</td>
                                    <td style="padding: 0.5rem;">Ano atual para URLs</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔐 Lógica de Permissões:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        if ($is_admin || (is_array($membro) && in_array($slug, $membro)))
                </code>
                        <p>Administradores veem todos os tipos, usuários normais apenas seus tipos</p>

                        <h5>🌐 Estrutura de URL:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        "/" . $slug . "/" . $current_year
                </code>
                    </div>

                    <h3>🔍 Sistema de Busca Contextual</h3>
                    <div class="card">
                        <h4>🎯 Detecção de Contexto</h4>
                        <code>url_active()[1]</code>
                        <p>Identifica o tipo atual baseado na URL para contextualizar a busca</p>

                        <h5>🔧 Implementação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        if (in_array($current_slug, $slugs_array)) {
            // Renderiza formulário de busca específico
        }
                </code>

                        <h5>📝 Formulário de Busca:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Action:</strong> <code>/<?php echo $current_slug; ?>/</code></li>
                            <li><strong>Placeholder:</strong> "Pesquisar em [Nome do Tipo]"</li>
                            <li><strong>Ícone:</strong> Dinâmico baseado no tipo</li>
                            <li><strong>Query:</strong> <code><?php the_search_query(); ?></code></li>
                        </ul>
                    </div>

                    <h3>👤 Sistema de Perfil do Usuário</h3>
                    <div class="card">
                        <h4>🖼️ Avatar Dinâmico</h4>
                        <code>get_user_meta($user->ID, 'wp_user_avatar', true)</code>
                        <p>Sistema prioritário de avatares: Custom → WordPress Padrão</p>

                        <h5>🔄 Fluxo de Avatar:</h5>
                        <ol style="list-style-position: inside; margin-top: 0.5rem;">
                            <li>Verifica <code>wp_user_avatar</code> (ID do attachment)</li>
                            <li>Se existir, usa <code>wp_get_attachment_url()</code></li>
                            <li>Caso contrário, usa <code>get_avatar_url()</code> padrão</li>
                        </ol>

                        <h5>📋 Informações do Dropdown:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">Item</th>
                                    <th style="padding: 0.5rem; text-align: left;">Link</th>
                                    <th style="padding: 0.5rem; text-align: left;">Ícone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Meu Perfil</td>
                                    <td style="padding: 0.5rem;"><code>/perfil</code></td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-person"></i></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Painel WP (Admin)</td>
                                    <td style="padding: 0.5rem;"><code>/wp-admin</code></td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-wordpress"></i></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Sair</td>
                                    <td style="padding: 0.5rem;"><code>?icode_logout=1</code></td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-box-arrow-right"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📱 Estrutura do Header</h3>
                    <div class="card">
                        <h4>🏷️ Logo e Título</h4>
                        <code>get_option('portal_input_0') & get_option('portal_input_1')</code>
                        <p>Configurações dinâmicas do portal</p>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>portal_input_0:</strong> Nome do portal</li>
                            <li><strong>portal_input_1:</strong> URL do favicon/logo</li>
                        </ul>

                        <h4>🔔 Barra de Ícones</h4>
                        <code>icon-bar</code>
                        <p>Links rápidos para tipos (visível apenas com aceite)</p>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        if (!empty($saved_aceite)) { /* Mostra icon-bar */ }
                </code>
                    </div>

                    <h3>📐 Sidebar Inteligente</h3>
                    <div class="card">
                        <h4>🎮 Controle de Visibilidade</h4>
                        <code>if (!empty($saved_aceite))</code>
                        <p>Sidebar só é exibida após usuário aceitar termos</p>

                        <h5>📋 Itens Fixos da Sidebar:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">Página</th>
                                    <th style="padding: 0.5rem; text-align: left;">Link</th>
                                    <th style="padding: 0.5rem; text-align: left;">Ícone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Busca Avançada</td>
                                    <td style="padding: 0.5rem;"><code>/</code></td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-search"></i></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Calendários</td>
                                    <td style="padding: 0.5rem;"><code>/calendarios</code></td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-calendar"></i></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Perfil</td>
                                    <td style="padding: 0.5rem;"><code>/perfil</code></td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-person"></i></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Pessoas</td>
                                    <td style="padding: 0.5rem;"><code>/pessoas</code></td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-person-fill"></i></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Financeiro</td>
                                    <td style="padding: 0.5rem;"><code>/relatoriofinanceiro</code></td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-wallet2"></i></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Sobre</td>
                                    <td style="padding: 0.5rem;"><code>/sobre</code></td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-code-square"></i></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Arquivos</td>
                                    <td style="padding: 0.5rem;"><code>/arquivos</code></td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-filetype-pdf"></i></td>
                                </tr>
                            </tbody>
                        </table>

                        <h4>👥 Usuários Online (Admin/Editor)</h4>
                        <code>get_users_online()</code>
                        <p>Lista de usuários ativos no sistema (apenas para administradores e editores)</p>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        if (current_user_can('administrator') || current_user_can('editor'))
                </code>
                    </div>

                    <h3>🎯 Tecnologias e Integrações</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Bootstrap Icons</span>
                        <span class="tech-item">Font Awesome</span>
                        <span class="tech-item">Google Fonts</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">Responsive Design</span>
                        <span class="tech-item">Dynamic Menus</span>
                        <span class="tech-item">User Meta</span>
                        <span class="tech-item">Session Management</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 Características Especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>Navegação Contextual:</strong> Menus adaptados ao usuário</li>
                            <li><strong>Busca Inteligente:</strong> Pesquisa específica por tipo</li>
                            <li><strong>Interface Responsiva:</strong> Mobile-first design</li>
                            <li><strong>Auditoria Completa:</strong> Registro de todos os acessos</li>
                            <li><strong>Controle de Acesso:</strong> Permissões granulares</li>
                            <li><strong>Performance:</strong> Carregamento otimizado de assets</li>
                        </ul>
                    </div>
                </div>


                <!-- ===== tab content - tema footer ===== -->
                <div class="tab-pane fade" id="theme-footer" role="tabpanel" aria-labelledby="theme-footer-tab">
                    <h2>🔚 Footer do Tema<span>/wp-content/themes/novoicode/footer.php</span></h2>
                    <p>Rodapé limpo e funcional com créditos institucionais, botão de voltar ao topo e carregamento
                        otimizado de scripts.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🏛️ créditos institucionais</h4>
                            <p>Link para o Instituto de Computação</p>
                            <code>credits</code>
                        </div>
                        <div class="card">
                            <h4>⬆️ voltar ao topo</h4>
                            <p>Navegação rápida com smooth scroll</p>
                            <code>back-to-top</code>
                        </div>
                        <div class="card">
                            <h4>⚡ scripts otimizados</h4>
                            <p>Carregamento no final do body</p>
                            <code>wp_footer()</code>
                        </div>
                        <div class="card">
                            <h4>🎨 design minimalista</h4>
                            <p>Interface limpa e profissional</p>
                            <code>footer</code>
                        </div>
                    </div>

                    <h3>🏛️ estrutura do footer</h3>
                    <div class="card">
                        <h4>📋 elementos principais</h4>
                        <code>footer + credits + back-to-top</code>
                        <p>Composição simples mas funcional</p>

                        <h5>🎯 seções do footer:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">elemento</th>
                                    <th style="padding: 0.5rem; text-align: left;">tag</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">rodapé principal</td>
                                    <td style="padding: 0.5rem;"><code>&lt;footer&gt;</code></td>
                                    <td style="padding: 0.5rem;">container principal</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">créditos</td>
                                    <td style="padding: 0.5rem;"><code>&lt;div class="credits"&gt;</code></td>
                                    <td style="padding: 0.5rem;">link institucional</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">voltar ao topo</td>
                                    <td style="padding: 0.5rem;"><code>&lt;a class="back-to-top"&gt;</code></td>
                                    <td style="padding: 0.5rem;">botão flutuante</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">scripts WordPress</td>
                                    <td style="padding: 0.5rem;"><code>&lt;?php wp_footer(); ?&gt;</code></td>
                                    <td style="padding: 0.5rem;">hooks e scripts do WP</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🔗 créditos institucionais</h3>
                    <div class="card">
                        <h4>🎓 link do instituto</h4>
                        <code>&lt;a target="_blank" href="https://ic.unicamp.br/"&gt;</code>
                        <p>Vinculação com a instituição mantenedora</p>

                        <h5>🎯 características do link:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>target="_blank":</strong> Abre em nova aba</li>
                            <li><strong>href absoluto:</strong> URL completa do IC</li>
                            <li><strong>texto descritivo:</strong> "Instituto de Computação"</li>
                            <li><strong>sem rel:</strong> Link normal sem atributos extras</li>
                        </ul>

                        <h5>🌐 contexto institucional:</h5>
                        <div
                            style="background: #f8f9fa; border: 1px solid #dee2e6; padding: 1rem; border-radius: 5px; margin-top: 0.5rem;">
                            <strong>Instituto de Computação - UNICAMP</strong><br>
                            <small>Instituição responsável pelo desenvolvimento e manutenção do sistema ICODE</small>
                        </div>
                    </div>

                    <h3>⬆️ botão voltar ao topo</h3>
                    <div class="card">
                        <h4>🎮 navegação rápida</h4>
                        <code>back-to-top</code>
                        <p>Botão flutuante para retornar ao início da página</p>

                        <h5>🎯 implementação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;a href="#" class="back-to-top d-flex align-items-center justify-content-center"&gt;
                        &lt;i class="bi bi-arrow-up-short"&gt;&lt;/i&gt;
                    &lt;/a&gt;
                            </code>

                        <h5>🎨 características visuais:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">propriedade</th>
                                    <th style="padding: 0.5rem; text-align: left;">valor</th>
                                    <th style="padding: 0.5rem; text-align: left;">efeito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">flexbox</td>
                                    <td style="padding: 0.5rem;">
                                        <code>d-flex align-items-center justify-content-center</code>
                                    </td>
                                    <td style="padding: 0.5rem;">centralização perfeita</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">ícone</td>
                                    <td style="padding: 0.5rem;"><code>bi bi-arrow-up-short</code></td>
                                    <td style="padding: 0.5rem;">seta para cima compacta</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">comportamento</td>
                                    <td style="padding: 0.5rem;"><code>href="#"</code></td>
                                    <td style="padding: 0.5rem;">scroll suave via JavaScript</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>⚡ sistema de scripts</h3>
                    <div class="card">
                        <h4>📦 carregamento otimizado</h4>
                        <code>wp_footer() + main.js</code>
                        <p>Scripts carregados no final para melhor performance</p>

                        <h5>🎯 ordem de carregamento:</h5>
                        <ol style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>wp_footer():</strong> Scripts do WordPress e plugins</li>
                            <li><strong>main.js:</strong> JavaScript customizado do tema</li>
                            <li><strong>fechamento:</strong> Tags <code>&lt;/body&gt;</code> e <code>&lt;/html&gt;</code>
                            </li>
                        </ol>

                        <h5>🔧 main.js personalizado:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;script src="&lt;?php echo SITEPATH; ?&gt;assets/js/main.js"&gt;&lt;/script&gt;
                            </code>
                        <p>Arquivo JavaScript principal com funcionalidades do tema</p>

                        <h5>🔄 hook do WordPress:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;?php wp_footer(); ?&gt;
                            </code>
                        <p>Inclui scripts de plugins, estilos e funcionalidades do WordPress</p>
                    </div>

                    <h3>🎨 design e estilos</h3>
                    <div class="card">
                        <h4>💎 abordagem minimalista</h4>
                        <p>Footer limpo com foco na funcionalidade essencial</p>

                        <h5>🎯 princípios de design:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>simplicidade:</strong> Apenas elementos necessários</li>
                            <li><strong>profissionalismo:</strong> Identidade institucional clara</li>
                            <li><strong>usabilidade:</strong> Navegação intuitiva</li>
                            <li><strong>performance:</strong> Código leve e eficiente</li>
                        </ul>

                        <h5>📱 responsividade:</h5>
                        <p>Layout adaptável que funciona em todos os dispositivos, mantendo a funcionalidade do botão voltar
                            ao topo</p>
                    </div>

                    <h3>🔧 constantes e variáveis</h3>
                    <div class="card">
                        <h4>🌐 SITEPATH</h4>
                        <code>&lt;?php echo SITEPATH; ?&gt;</code>
                        <p>Constante que define o caminho base do tema</p>

                        <h5>🎯 uso no footer:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    src="&lt;?php echo SITEPATH; ?&gt;assets/js/main.js"
                            </code>
                        <p>Garante que o caminho do script sempre esteja correto, independente da instalação</p>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">Bootstrap Icons</span>
                        <span class="tech-item">PHP</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">JavaScript</span>
                        <span class="tech-item">Flexbox</span>
                        <span class="tech-item">Responsive Design</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>performance otimizada:</strong> Scripts carregados no final do body</li>
                            <li><strong>acessibilidade:</strong> Navegação por teclado suportada</li>
                            <li><strong>branding institucional:</strong> Identidade visual consistente</li>
                            <li><strong>experiência do usuário:</strong> Navegação rápida com botão voltar ao topo</li>
                            <li><strong>manutenibilidade:</strong> Código limpo e bem estruturado</li>
                            <li><strong>compatibilidade:</strong> Funciona com todos os plugins WordPress</li>
                        </ul>
                    </div>

                    <h3>🔗 integração com o sistema</h3>
                    <div class="card">
                        <h4>🔄 fluxo de carregamento</h4>
                        <p>Como o footer se integra com o resto do tema</p>

                        <h5>📋 sequência de execução:</h5>
                        <ol style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><code>get_header()</code> - Carrega o cabeçalho</li>
                            <li><strong>Conteúdo da página</strong> - Template específico</li>
                            <li><code>get_footer()</code> - Carrega este arquivo</li>
                            <li><strong>Scripts WordPress</strong> - <code>wp_footer()</code></li>
                            <li><strong>Scripts customizados</strong> - <code>main.js</code></li>
                            <li><strong>Fechamento</strong> - <code>&lt;/body&gt;&lt;/html&gt;</code></li>
                        </ol>
                    </div>
                </div>


                <!-- ===== tab content - tema archive ===== -->
                <div class="tab-pane fade" id="theme-archive" role="tabpanel" aria-labelledby="theme-archive-tab">
                    <h2>📁 Archive do Tema<span>/wp-content/themes/novoicode/archive.php</span></h2>
                    <p>Template de arquivo para listagem de documentos por tipo, com controle de acesso e grid de anos.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🔐 controle de acesso</h4>
                            <p>Verificação de permissões por tipo</p>
                            <code>aceite + membro</code>
                        </div>
                        <div class="card">
                            <h4>📅 grid de anos</h4>
                            <p>Navegação temporal de documentos</p>
                            <code>years-grid</code>
                        </div>
                        <div class="card">
                            <h4>👥 membros dinâmicos</h4>
                            <p>Lista de membros via API</p>
                            <code>icapi shortcode</code>
                        </div>
                        <div class="card">
                            <h4>🎨 interface responsiva</h4>
                            <p>Design adaptativo Bootstrap</p>
                            <code>section archive</code>
                        </div>
                    </div>

                    <h3>🔐 sistema de controle de acesso</h3>
                    <div class="card">
                        <h4>📋 verificação em duas etapas</h4>

                        <h5>1. aceite dos termos</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
            echo '&lt;script&gt;window.location.href = "/perfil";&lt;/script&gt;';
                </code>
                        <p>Redireciona para perfil se usuário não aceitou termos</p>

                        <h5>2. permissão por tipo</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        $is_admin = current_user_can('administrator');
        $current_type = url_active()[1];

        if (!$is_admin && (!is_array($membro) || !in_array($current_type, $membro))) {
            // mostra mensagem de permissão negada
        }
                </code>
                        <p>administradores têm acesso total, usuários apenas aos seus tipos</p>

                        <h5>🚫 mensagem de negação</h5>
                        <div
                            style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 1rem; border-radius: 5px; margin-top: 0.5rem;">
                            <h4 style="text-align:center; color: #856404; margin: 0;">você não está no <b><u>membros
                                        <?php echo print_type($current_type, 'nome') ?>
                                    </u></b>, consulte o administrador.</h4>
                        </div>
                    </div>

                    <h3>📊 estrutura da página</h3>
                    <div class="card">
                        <h4>🏷️ cabeçalho e breadcrumbs</h4>
                        <code>pagetitle</code>
                        <p>Área superior com título, ícone e navegação</p>

                        <h5>🎯 componentes:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">elemento</th>
                                    <th style="padding: 0.5rem; text-align: left;">código</th>
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">ícone</td>
                                    <td style="padding: 0.5rem;"><code>print_type(url_active()[1],'icone')</code></td>
                                    <td style="padding: 0.5rem;">ícone dinâmico do tipo</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">título</td>
                                    <td style="padding: 0.5rem;"><code>print_type(url_active()[1],'texto')</code></td>
                                    <td style="padding: 0.5rem;">nome completo do tipo</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">breadcrumb</td>
                                    <td style="padding: 0.5rem;"><code>/<?php echo url_active()[1]; ?></code></td>
                                    <td style="padding: 0.5rem;">navegação hierárquica</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📅 grid de anos dinâmico</h3>
                    <div class="card">
                        <h4>🔄 lógica de geração</h4>
                        <code>get_terms() + for loop</code>
                        <p>Cria cards de anos baseado nas categorias existentes</p>

                        <h5>📋 obtenção de categorias:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        $categorias = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => true,
            'orderby' => 'slug',
            'order' => 'ASC',
            'object_ids' => get_posts(array(
                'post_type' => url_active()[1],
                'numberposts' => -1,
                'fields' => 'ids',
            )),
        ));
                </code>

                        <h5>🎯 cálculo de range:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>ano inicial:</strong> <code>$year_init = intval($categorias[0]->name)</code></li>
                            <li><strong>ano atual:</strong> <code>$current_year = (int) date('Y')</code></li>
                            <li><strong>loop:</strong>
                                <code>for ($year = $current_year; $year >= $year_init; $year--)</code>
                            </li>
                        </ul>

                        <h5>🎨 diferenciação visual:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">ano</th>
                                    <th style="padding: 0.5rem; text-align: left;">classe css</th>
                                    <th style="padding: 0.5rem; text-align: left;">aparência</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">atual</td>
                                    <td style="padding: 0.5rem;"><code>ano-atual</code></td>
                                    <td style="padding: 0.5rem;">destaque especial</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">passados</td>
                                    <td style="padding: 0.5rem;"><code>ano-passado</code></td>
                                    <td style="padding: 0.5rem;">aparência normal</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>👥 seção de membros</h3>
                    <div class="card">
                        <h4>🔗 integração com API</h4>
                        <code>icapi shortcode</code>
                        <p>Carrega lista de membros dinamicamente da intranet</p>

                        <h5>🎯 implementação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        echo apply_filters('the_content', do_shortcode('[icapi tipo="composicao_' . url_active()[1] . '" saida="html"]'));
                </code>

                        <h5>📊 estrutura da chamada:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>endpoint:</strong> <code>composicao_[tipo_atual]</code></li>
                            <li><strong>formato:</strong> <code>html</code></li>
                            <li><strong>processamento:</strong> <code>apply_filters('the_content', ...)</code></li>
                        </ul>
                    </div>

                    <h3>🎨 estrutura html e classes</h3>
                    <div class="card">
                        <h4>📱 grid responsivo</h4>
                        <code>col-xl-1 col-lg-1 col-md-2 col-sm-3 col-4</code>
                        <p>Sistema de colunas adaptativo para diferentes dispositivos</p>

                        <h5>📐 breakpoints:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">dispositivo</th>
                                    <th style="padding: 0.5rem; text-align: left;">colunas</th>
                                    <th style="padding: 0.5rem; text-align: left;">classe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">extra large</td>
                                    <td style="padding: 0.5rem;">12 colunas</td>
                                    <td style="padding: 0.5rem;"><code>col-xl-1</code></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">large</td>
                                    <td style="padding: 0.5rem;">12 colunas</td>
                                    <td style="padding: 0.5rem;"><code>col-lg-1</code></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">medium</td>
                                    <td style="padding: 0.5rem;">6 colunas</td>
                                    <td style="padding: 0.5rem;"><code>col-md-2</code></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">small</td>
                                    <td style="padding: 0.5rem;">4 colunas</td>
                                    <td style="padding: 0.5rem;"><code>col-sm-3</code></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">extra small</td>
                                    <td style="padding: 0.5rem;">3 colunas</td>
                                    <td style="padding: 0.5rem;"><code>col-4</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🔧 funções personalizadas utilizadas</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📍 url_active()</h4>
                            <p>Detecta o tipo atual da URL</p>
                            <code>url_active()[1]</code>
                        </div>
                        <div class="card">
                            <h4>🏷️ print_type()</h4>
                            <p>Retorna informações do tipo</p>
                            <code>print_type($slug, $campo)</code>
                        </div>
                        <div class="card">
                            <h4>🔗 icapi()</h4>
                            <p>Shortcode de integração com API</p>
                            <code>[icapi tipo="X" saida="html"]</code>
                        </div>
                        <div class="card">
                            <h4>👤 get_users_online()</h4>
                            <p>Lista usuários ativos (indireto)</p>
                            <code>implícito no header</code>
                        </div>
                    </div>

                    <h3>🎯 tecnologias e integrações</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">Bootstrap Icons</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">Custom Taxonomies</span>
                        <span class="tech-item">REST API</span>
                        <span class="tech-item">Responsive Grid</span>
                        <span class="tech-item">User Meta</span>
                        <span class="tech-item">Access Control</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>acesso granular:</strong> controle preciso por tipo de usuário</li>
                            <li><strong>navegação temporal:</strong> grid intuitivo de anos</li>
                            <li><strong>dados dinâmicos:</strong> integração em tempo real com API</li>
                            <li><strong>design responsivo:</strong> adaptação perfeita a todos os dispositivos</li>
                            <li><strong>performance otimizada:</strong> consultas eficientes ao banco</li>
                            <li><strong>experiência do usuário:</strong> feedback claro sobre permissões</li>
                        </ul>
                    </div>
                </div>


                <!-- ===== tab content - tema category ===== -->
                <div class="tab-pane fade" id="theme-category" role="tabpanel" aria-labelledby="theme-category-tab">
                    <h2>📂 Category do Tema<span>/wp-content/themes/novoicode/category.php</span></h2>
                    <p>Template de categoria com listagem de posts, sistema de indexação PDF e gerenciador de arquivos
                        integrado.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📊 tabela dinâmica</h4>
                            <p>Listagem com DataTable</p>
                            <code>.tcategory</code>
                        </div>
                        <div class="card">
                            <h4>🔒 posts privados</h4>
                            <p>Controle de acesso granular</p>
                            <code>membro_post_privado</code>
                        </div>
                        <div class="card">
                            <h4>📁 gerenciador de arquivos</h4>
                            <p>Integração com elFinder</p>
                            <code>data-elfinder</code>
                        </div>
                        <div class="card">
                            <h4>🔍 indexação PDF</h4>
                            <p>Sistema de OCR automático</p>
                            <code>modalIndex</code>
                        </div>
                    </div>

                    <h3>🔐 sistema de controle de acesso</h3>
                    <div class="card">
                        <h4>📋 verificação em duas etapas</h4>

                        <h5>1. aceite dos termos</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
            echo '&lt;script&gt;window.location.href = "/perfil";&lt;/script&gt;';
                </code>

                        <h5>2. permissão por tipo</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        $is_admin = current_user_can('administrator');
        $current_type = url_active()[1];

        if (!$is_admin && (!is_array($membro) || !in_array($current_type, $membro))) {
            // mostra mensagem de permissão negada
        }
                </code>
                    </div>

                    <h3>📊 estrutura da tabela de posts</h3>
                    <div class="card">
                        <h4>⚙️ configuração do datatable</h4>
                        <code>dataConfig</code>
                        <p>Configuração completa para tabelas interativas</p>

                        <h5>🎯 configurações principais:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">configuração</th>
                                    <th style="padding: 0.5rem; text-align: left;">valor</th>
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">ordenação</td>
                                    <td style="padding: 0.5rem;"><code>[[2, 'desc']]</code></td>
                                    <td style="padding: 0.5rem;">por data (decrescente)</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">dom</td>
                                    <td style="padding: 0.5rem;"><code>'Brit'</code></td>
                                    <td style="padding: 0.5rem;">botões + informações + tabela</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">paginação</td>
                                    <td style="padding: 0.5rem;"><code>iDisplayLength: 50</code></td>
                                    <td style="padding: 0.5rem;">50 registros por página</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">idioma</td>
                                    <td style="padding: 0.5rem;"><code>language: {}</code></td>
                                    <td style="padding: 0.5rem;">português brasileiro</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🔒 sistema de posts privados</h3>
                    <div class="card">
                        <h4>👤 controle de acesso granular</h4>
                        <code>membro_post_privado</code>
                        <p>Posts que só usuários específicos podem visualizar</p>

                        <h5>🔍 verificação de permissão:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        $membro_post_privado = get_user_meta(wp_get_current_user()->ID, 'membro_post_privado', true);
        $user_membro_post_privado = is_array($membro_post_privado) && in_array(url_active()[1], $membro_post_privado);

        $post_privado = get_post_meta($post_id, url_active()[1] . '_privado', true);

        if (!empty($post_privado) && $post_privado != $user_membro_post_privado) {
            continue; // pula post privado sem permissão
        }
                </code>

                        <h5>🎨 indicação visual:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>ícone:</strong> <code>bi-file-earmark-lock2</code> (vermelho)</li>
                            <li><strong>classe:</strong> <code>link-privado</code></li>
                            <li><strong>tooltip:</strong> "Post Privado"</li>
                        </ul>
                    </div>

                    <h3>📁 sistema de gerenciador de arquivos</h3>
                    <div class="card">
                        <h4>🖼️ modal elfinder</h4>
                        <code>elfinderModal</code>
                        <p>Interface completa de gerenciamento de arquivos</p>

                        <h5>🎯 implementação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        document.querySelectorAll('a[data-elfinder]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                const postId = this.getAttribute('data-post-id');
                const postTitle = this.getAttribute('data-post-title');
        
                document.getElementById('elfinderIframe').src = url;
                document.getElementById('elfinderModalLabel').innerText = `(#${postId}) ${postTitle}`;
        
                const modal = new bootstrap.Modal(document.getElementById('elfinderModal'));
                modal.show();
            });
        });
                </code>

                        <h5>📂 estrutura de diretórios:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>posts:</strong> <code>/uploads/[tipo]/[ano]/[post_id]/</code></li>
                            <li><strong>outros:</strong> <code>/uploads/[tipo]/[ano]/outros/</code></li>
                            <li><strong>verificação:</strong> <code>is_dir($dir_file_abs)</code></li>
                        </ul>
                    </div>

                    <h3>🔍 sistema de indexação pdf</h3>
                    <div class="card">
                        <h4>⚡ indexação em lote</h4>
                        <code>modalIndex</code>
                        <p>Processamento assíncrono de múltiplos PDFs</p>

                        <h5>🔄 fluxo de indexação:</h5>
                        <ol style="list-style-position: inside; margin-top: 0.5rem;">
                            <li>Lista PDFs via AJAX (<code>novoicode_listar_pdfs</code>)</li>
                            <li>Processa um por um (<code>novoicode_indexar_pdf</code>)</li>
                            <li>Barra de progresso em tempo real</li>
                            <li>Feedback visual do status</li>
                        </ol>

                        <h5>📊 elementos de interface:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">elemento</th>
                                    <th style="padding: 0.5rem; text-align: left;">id</th>
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">contador</td>
                                    <td style="padding: 0.5rem;"><code>total-pdfs</code></td>
                                    <td style="padding: 0.5rem;">quantidade de PDFs</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">barra de progresso</td>
                                    <td style="padding: 0.5rem;"><code>progresso</code></td>
                                    <td style="padding: 0.5rem;">progresso visual</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">status</td>
                                    <td style="padding: 0.5rem;"><code>status</code></td>
                                    <td style="padding: 0.5rem;">descrição do processo</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🎨 elementos de interface</h3>
                    <div class="card">
                        <h4>🔧 botões de ação</h4>
                        <code>btn-editors</code>
                        <p>Área de ações para editores e administradores</p>

                        <h5>🎯 botões disponíveis:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">botão</th>
                                    <th style="padding: 0.5rem; text-align: left;">condição</th>
                                    <th style="padding: 0.5rem; text-align: left;">ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Início</td>
                                    <td style="padding: 0.5rem;">sempre</td>
                                    <td style="padding: 0.5rem;">volta para archive</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Novo Post</td>
                                    <td style="padding: 0.5rem;">ano atual + não subscriber</td>
                                    <td style="padding: 0.5rem;">cria novo post</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Indexar PDFs</td>
                                    <td style="padding: 0.5rem;">não subscriber</td>
                                    <td style="padding: 0.5rem;">abre modal de indexação</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🔗 criação de novo post</h3>
                    <div class="card">
                        <h4>🚀 redirecionamento inteligente</h4>
                        <code>createPostBtn</code>
                        <p>Sistema que gera ID único e redireciona para editor</p>

                        <h5>🎯 implementação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        global $wpdb;
        $last_post_id = $wpdb->get_var("SELECT MAX(ID) FROM $wpdb->posts WHERE post_status != 'trash'");
        $next_free_id = $last_post_id + 1;

        window.location.href = "/painel/novo/?tipo=<?php echo url_active()[1]; ?>&cat=<?php echo url_active()[2]; ?>&novoid=<?php echo $next_free_id; ?>";
                </code>

                        <h5>📋 parâmetros da URL:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>tipo:</strong> tipo atual (<code>url_active()[1]</code>)</li>
                            <li><strong>cat:</strong> categoria/ano (<code>url_active()[2]</code>)</li>
                            <li><strong>novoid:</strong> próximo ID disponível</li>
                        </ul>
                    </div>

                    <h3>🎯 tecnologias e integrações</h3>
                    <div class="tech-stack">
                        <span class="tech-item">DataTables</span>
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">elFinder</span>
                        <span class="tech-item">AJAX</span>
                        <span class="tech-item">PDF Parser</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">Access Control</span>
                        <span class="tech-item">Modal System</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>performance:</strong> paginação client-side com DataTables</li>
                            <li><strong>segurança:</strong> múltiplas camadas de controle de acesso</li>
                            <li><strong>usabilidade:</strong> interface intuitiva com feedback visual</li>
                            <li><strong>produtividade:</strong> ferramentas integradas para editores</li>
                            <li><strong>busca:</strong> indexação completa de conteúdo PDF</li>
                            <li><strong>organização:</strong> gerenciamento visual de arquivos</li>
                        </ul>
                    </div>
                </div>


                <!-- ===== tab content - tema single ===== -->
                <div class="tab-pane fade" id="theme-single" role="tabpanel" aria-labelledby="theme-single-tab">
                    <h2>📄 Single do Tema<span>/wp-content/themes/novoicode/single.php</span></h2>
                    <p>Template de post individual com sistema completo de visualização, impressão, ordenação de arquivos e
                        controle de acesso granular.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🖨️ sistema de impressão</h4>
                            <p>Exportação otimizada para PDF</p>
                            <code>imprimirConteudo()</code>
                        </div>
                        <div class="card">
                            <h4>📁 ordenação de arquivos</h4>
                            <p>Drag & drop com SortableJS</p>
                            <code>table-sortable</code>
                        </div>
                        <div class="card">
                            <h4>🔒 acesso granular</h4>
                            <p>Controle por post e arquivo</p>
                            <code>membro_post_privado</code>
                        </div>
                        <div class="card">
                            <h4>🔄 gerenciamento</h4>
                            <p>Edição, exclusão, compartilhamento</p>
                            <code>btn-editors</code>
                        </div>
                    </div>

                    <h3>🔐 sistema de controle de acesso</h3>
                    <div class="card">
                        <h4>📋 verificação em camadas</h4>

                        <h5>1. aceite dos termos</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
                        echo '&lt;script&gt;window.location.href = "/perfil";&lt;/script&gt;';
                            </code>

                        <h5>2. permissão por tipo</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (!$is_admin && (!is_array($membro) || !in_array($current_type, $membro))) {
                        // mostra mensagem de permissão negada
                    }
                            </code>

                        <h5>3. posts privados</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    // admin sempre tem acesso
                    if ($is_admin || (is_array($membro_post_privado) && in_array(url_active()[1], $membro_post_privado))) {
                        $user_membro_post_privado = true;
                    }

                    if ($post_privado && !$user_membro_post_privado && !$is_admin)
                        echo '&lt;script&gt;window.location.href = "/404";&lt;/script&gt;';
                            </code>

                        <h5>4. arquivos privados</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    // admin sempre tem acesso
                    if ($is_admin || (is_array($membro_arquivo_privado) && in_array(url_active()[1], $membro_arquivo_privado))) {
                        $user_membro_arquivo_privado = true;
                    }
                            </code>
                    </div>

                    <h3>🖨️ sistema de impressão avançado</h3>
                    <div class="card">
                        <h4>🎯 funcionalidades</h4>
                        <code>imprimirConteudo()</code>
                        <p>Geração de documento otimizado para impressão</p>

                        <h5>🔧 processamento de conteúdo:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>remoção de hiperlinks:</strong> <code>removerHiperlinks()</code></li>
                            <li><strong>estilos dedicados:</strong> CSS otimizado para impressão</li>
                            <li><strong>janela dedicada:</strong> Não interfere na navegação</li>
                            <li><strong>estrutura semântica:</strong> Cabeçalho, membros, conteúdo</li>
                        </ul>

                        <h5>🎨 css de impressão:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    @media print {
                        body * { visibility: hidden; }
                        .printable-content, .printable-content * { visibility: visible; }
                        .printable-content { position: absolute; left: 0; top: 0; width: 100%; }
                        .no-print { display: none !important; }
                    }
                            </code>

                        <h5>📊 elementos impressos:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">seção</th>
                                    <th style="padding: 0.5rem; text-align: left;">classe</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">cabeçalho</td>
                                    <td style="padding: 0.5rem;"><code>print-header</code></td>
                                    <td style="padding: 0.5rem;">título e data</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">membros</td>
                                    <td style="padding: 0.5rem;"><code>print-membros</code></td>
                                    <td style="padding: 0.5rem;">lista de participantes</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">conteúdo</td>
                                    <td style="padding: 0.5rem;"><code>print-conteudo</code></td>
                                    <td style="padding: 0.5rem;">conteúdo principal</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📁 sistema de ordenação de arquivos</h3>
                    <div class="card">
                        <h4>🎮 drag & drop</h4>
                        <code>SortableJS</code>
                        <p>Ordenação visual com persistência automática</p>

                        <h5>⚙️ inicialização:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    new Sortable(table.querySelector('tbody'), {
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        chosenClass: 'sortable-chosen',
                        onEnd: function(evt) {
                            salvarOrdenacao(evt.from, evt.item.closest('.card').querySelector('.card-title').textContent);
                        }
                    });
                            </code>

                        <h5>💾 persistência:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>arquivo:</strong> <code>.order.ini</code> em cada subpasta</li>
                            <li><strong>formato:</strong> Array PHP serializado</li>
                            <li><strong>ajax:</strong> <code>salvar_ordenacao_arquivos</code></li>
                            <li><strong>feedback:</strong> Highlight visual temporário</li>
                        </ul>

                        <h5>🎨 estilos visuais:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">estado</th>
                                    <th style="padding: 0.5rem; text-align: left;">classe</th>
                                    <th style="padding: 0.5rem; text-align: left;">aparência</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">arrastando</td>
                                    <td style="padding: 0.5rem;"><code>sortable-ghost</code></td>
                                    <td style="padding: 0.5rem;">opacidade 40%</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">selecionado</td>
                                    <td style="padding: 0.5rem;"><code>sortable-chosen</code></td>
                                    <td style="padding: 0.5rem;">background + shadow</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">hover editor</td>
                                    <td style="padding: 0.5rem;"><code>editor-sortable</code></td>
                                    <td style="padding: 0.5rem;">background destacado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📊 estrutura de arquivos</h3>
                    <div class="card">
                        <h4>📂 organização por tipo</h4>
                        <code>listarArquivos()</code>
                        <p>Sistema de categorização de anexos</p>

                        <h5>📁 subpastas:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">pasta</th>
                                    <th style="padding: 0.5rem; text-align: left;">visibilidade</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">pautas</td>
                                    <td style="padding: 0.5rem;">público</td>
                                    <td style="padding: 0.5rem;">documentos pré-reunião</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">deliberacoes</td>
                                    <td style="padding: 0.5rem;">público</td>
                                    <td style="padding: 0.5rem;">decisões tomadas</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">ata</td>
                                    <td style="padding: 0.5rem;">público</td>
                                    <td style="padding: 0.5rem;">registro da reunião</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">privado</td>
                                    <td style="padding: 0.5rem;">restrito</td>
                                    <td style="padding: 0.5rem;">documentos internos</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔍 caminhos do sistema:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $relative_path = "/$post_type/$category/$post_id";
                    $URL = "$base_url$relative_path/";  // URL de acesso
                    $DIR = "$base_dir$relative_path";   // Caminho físico
                            </code>
                    </div>

                    <h3>🎨 interface de usuário</h3>
                    <div class="card">
                        <h4>🔧 barra de ferramentas</h4>
                        <code>btn-editors</code>
                        <p>Ações contextuais para usuários com permissão</p>

                        <h5>🎯 botões disponíveis:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">botão</th>
                                    <th style="padding: 0.5rem; text-align: left;">cor</th>
                                    <th style="padding: 0.5rem; text-align: left;">ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Voltar</td>
                                    <td style="padding: 0.5rem;"><span style="color: #6c757d;">●</span> Light</td>
                                    <td style="padding: 0.5rem;">Retorna à listagem</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Imprimir</td>
                                    <td style="padding: 0.5rem;"><span style="color: #212529;">●</span> Dark</td>
                                    <td style="padding: 0.5rem;">Abre diálogo de impressão</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Compartilhar</td>
                                    <td style="padding: 0.5rem;"><span style="color: #6c757d;">●</span> Secondary</td>
                                    <td style="padding: 0.5rem;">Abre modal de compartilhamento</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Editar</td>
                                    <td style="padding: 0.5rem;"><span style="color: #198754;">●</span> Success</td>
                                    <td style="padding: 0.5rem;">Redireciona para editor</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Apagar</td>
                                    <td style="padding: 0.5rem;"><span style="color: #dc3545;">●</span> Danger</td>
                                    <td style="padding: 0.5rem;">Abre confirmação de exclusão</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🔄 modais do sistema</h3>
                    <div class="card">
                        <h4>📤 compartilhamento</h4>
                        <code>shareModal</code>
                        <p>Interface de compartilhamento em iframe</p>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;iframe src="/share?post_id=&lt;?php echo $post_id; ?&gt;" 
                            style="width: 100%; height: 600px; border: none;"&gt;&lt;/iframe&gt;
                            </code>

                        <h4>🗑️ exclusão</h4>
                        <code>deleteModal</code>
                        <p>Confirmação segura de exclusão</p>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;a href="&lt;?php echo home_url('/?delete_post=' . $post_id . '&path=' . $path); ?&gt;" 
                    class="btn btn-danger"&gt;Apagar&lt;/a&gt;
                            </code>
                    </div>

                    <h3>🔧 funções personalizadas</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📂 listarArquivos()</h4>
                            <p>Listagem inteligente com ordenação</p>
                            <code>scandir() + .order.ini</code>
                        </div>
                        <div class="card">
                            <h4>📍 url_active()</h4>
                            <p>Detecção de contexto da URL</p>
                            <code>url_active()[1] // tipo</code>
                        </div>
                        <div class="card">
                            <h4>🏷️ print_type()</h4>
                            <p>Informações dinâmicas do tipo</p>
                            <code>print_type($slug, $campo)</code>
                        </div>
                        <div class="card">
                            <h4>🔍 salvar_ordenacao()</h4>
                            <p>Persistência via AJAX</p>
                            <code>admin-ajax.php</code>
                        </div>
                    </div>

                    <h3>🎯 tecnologias e integrações</h3>
                    <div class="tech-stack">
                        <span class="tech-item">SortableJS</span>
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">Bootstrap Icons</span>
                        <span class="tech-item">AJAX</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">Modal System</span>
                        <span class="tech-item">Print CSS</span>
                        <span class="tech-item">File Management</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>segurança robusta:</strong> 4 camadas de controle de acesso</li>
                            <li><strong>experiência rica:</strong> Drag & drop com feedback visual</li>
                            <li><strong>produtividade:</strong> Ferramentas integradas para editores</li>
                            <li><strong>acessibilidade:</strong> Navegação por teclado suportada</li>
                            <li><strong>performance:</strong> Carregamento otimizado de recursos</li>
                            <li><strong>usabilidade:</strong> Interface intuitiva e responsiva</li>
                        </ul>
                    </div>
                </div>


                <!-- ===== tab content - tema frontpage ===== -->
                <div class="tab-pane fade" id="theme-frontpage" role="tabpanel" aria-labelledby="theme-frontpage-tab">
                    <h2>🏠 FrontPage do Tema<span>/wp-content/themes/novoicode/front-page.php</span></h2>
                    <p>Página inicial do sistema com busca avançada, chat com IA e carousel de últimas publicações.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🔍 busca avançada</h4>
                            <p>Sistema de pesquisa unificada</p>
                            <code>search-form</code>
                        </div>
                        <div class="card">
                            <h4>🤖 chat com ia</h4>
                            <p>Assistente inteligente React</p>
                            <code>componentChats</code>
                        </div>
                        <div class="card">
                            <h4>📰 últimas publicações</h4>
                            <p>Carousel dinâmico</p>
                            <code>publicationsCarousel</code>
                        </div>
                        <div class="card">
                            <h4>🎨 interface moderna</h4>
                            <p>Design responsivo com tabs</p>
                            <code>nav-tabs</code>
                        </div>
                    </div>

                    <h3>🔐 controle de acesso</h3>
                    <div class="card">
                        <h4>📋 verificação de aceite</h4>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
            echo '&lt;script&gt;window.location.href = "/perfil";&lt;/script&gt;';
                </code>
                        <p>Redireciona para perfil se usuário não aceitou termos</p>

                        <h4>🔒 acesso ao chat ia</h4>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        if ($user_membro_arquivo_privado || current_user_can('administrator') || current_user_can('editor')) {
            // mostra chat IA
        } else {
            // mostra mensagem de acesso restrito
        }
                </code>
                        <p>Chat IA disponível apenas para usuários autorizados</p>
                    </div>

                    <h3>📊 sistema de tabs</h3>
                    <div class="card">
                        <h4>🎮 navegação por abas</h4>
                        <code>nav-tabs</code>
                        <p>Interface com duas abas principais</p>

                        <h5>📋 abas disponíveis:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">aba</th>
                                    <th style="padding: 0.5rem; text-align: left;">ícone</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Busca Avançada</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-search"></i></td>
                                    <td style="padding: 0.5rem;">Formulário de pesquisa + carousel</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">IA do ICODE</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-robot"></i></td>
                                    <td style="padding: 0.5rem;">Chatbot com React</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>⚡ melhorias de usabilidade:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>foco automático:</strong> Campo de busca focado ao abrir aba</li>
                            <li><strong>transição suave:</strong> Animação entre abas</li>
                            <li><strong>estado ativo:</strong> Controle visual da aba selecionada</li>
                        </ul>
                    </div>

                    <h3>🔍 sistema de busca</h3>
                    <div class="card">
                        <h4>📝 formulário de pesquisa</h4>
                        <code>search-form</code>
                        <p>Busca unificada em toda a base do ICODE</p>

                        <h5>🎯 características:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>action:</strong> <code>/</code> (página atual)</li>
                            <li><strong>método:</strong> <code>GET</code></li>
                            <li><strong>campo:</strong> <code>name="s"</code> (padrão WordPress)</li>
                            <li><strong>placeholder:</strong> "Digite sua pesquisa..."</li>
                            <li><strong>valor persistente:</strong> <code>&lt;?php the_search_query(); ?&gt;</code></li>
                        </ul>

                        <h5>🎨 design responsivo:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        class="flex-grow-1" // campo de input
        class="flex-shrink-0" // botão de pesquisa
                </code>
                    </div>

                    <h3>📰 carousel de publicações</h3>
                    <div class="card">
                        <h4>🔄 últimas publicações</h4>
                        <code>publicationsCarousel</code>
                        <p>Exibição dinâmica dos posts mais recentes</p>

                        <h5>🔧 configuração do carousel:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">configuração</th>
                                    <th style="padding: 0.5rem; text-align: left;">valor</th>
                                    <th style="padding: 0.5rem; text-align: left;">efeito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">intervalo</td>
                                    <td style="padding: 0.5rem;">4000ms</td>
                                    <td style="padding: 0.5rem;">transição automática</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">itens por slide</td>
                                    <td style="padding: 0.5rem;">2</td>
                                    <td style="padding: 0.5rem;">otimização de espaço</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">controle pausa</td>
                                    <td style="padding: 0.5rem;">mouseenter/leave</td>
                                    <td style="padding: 0.5rem;">melhor experiência</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">navegação</td>
                                    <td style="padding: 0.5rem;">botões prev/next</td>
                                    <td style="padding: 0.5rem;">controle manual</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>📊 lógica de coleta de posts:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        $post_types = explode(',',get_option('portal_input_7'));
        foreach ($post_types as $post_type):
            $args = [
                'post_type' => $post_type,
                'posts_per_page' => 1,
                'post_status' => 'publish',
            ];
            // coleta último post de cada tipo
        endforeach;
                </code>
                    </div>

                    <h3>🤖 sistema de chat com ia</h3>
                    <div class="card">
                        <h4>⚛️ aplicação react</h4>
                        <code>chat-container</code>
                        <p>Interface moderna com componentes React</p>

                        <h5>📦 dependências carregadas:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">biblioteca</th>
                                    <th style="padding: 0.5rem; text-align: left;">arquivo</th>
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">React</td>
                                    <td style="padding: 0.5rem;">react.js</td>
                                    <td style="padding: 0.5rem;">framework base</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">React DOM</td>
                                    <td style="padding: 0.5rem;">react-dom.js</td>
                                    <td style="padding: 0.5rem;">renderização</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">React Markdown</td>
                                    <td style="padding: 0.5rem;">react-markdown.js</td>
                                    <td style="padding: 0.5rem;">renderização markdown</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Component MD</td>
                                    <td style="padding: 0.5rem;">componentMD.js</td>
                                    <td style="padding: 0.5rem;">componente markdown</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Component Chats</td>
                                    <td style="padding: 0.5rem;">componentChats.js</td>
                                    <td style="padding: 0.5rem;">componente principal</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🚫 estado de acesso restrito:</h5>
                        <div
                            style="background: #f8f9fa; border: 1px solid #dee2e6; padding: 1rem; border-radius: 5px; margin-top: 0.5rem;">
                            <div class="text-center py-3">
                                <img src="<?php echo SITEPATH; ?>assets/img/ic_noite.jpg" class="img-fluid rounded-3 mb-3"
                                    style="max-height: 200px; object-fit: cover;" alt="ICODE Noite" />
                                <h5 class="text-muted">Acesso ao Chat IA</h5>
                                <p class="text-muted">Solução em desenvolvimento e avaliação.</p>
                            </div>
                        </div>
                    </div>

                    <h3>🎨 elementos de interface</h3>
                    <div class="card">
                        <h4>💎 design system</h4>
                        <p>Componentes visuais consistentes</p>

                        <h5>🎯 elementos principais:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">elemento</th>
                                    <th style="padding: 0.5rem; text-align: left;">classe</th>
                                    <th style="padding: 0.5rem; text-align: left;">estilo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Card principal</td>
                                    <td style="padding: 0.5rem;"><code>main-card-container</code></td>
                                    <td style="padding: 0.5rem;">Container centralizado</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Cards de publicação</td>
                                    <td style="padding: 0.5rem;"><code>publication-card</code></td>
                                    <td style="padding: 0.5rem;">Shadow + border-0</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Área de chat</td>
                                    <td style="padding: 0.5rem;"><code>card-chat</code></td>
                                    <td style="padding: 0.5rem;">Estilo dedicado</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Ícones</td>
                                    <td style="padding: 0.5rem;"><code>bg-primary bg-opacity-10</code></td>
                                    <td style="padding: 0.5rem;">Fundo sutil</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>⚡ scripts e interatividade</h3>
                    <div class="card">
                        <h4>🎮 controle do carousel</h4>
                        <code>carousel control</code>
                        <p>Navegação manual e comportamentos inteligentes</p>

                        <h5>🔧 funcionalidades javascript:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>controle manual:</strong> Botões prev/next personalizados</li>
                            <li><strong>pausa inteligente:</strong> Pausa ao pairar mouse</li>
                            <li><strong>retomada automática:</strong> Retoma ao remover mouse</li>
                            <li><strong>inicialização Bootstrap:</strong> <code>new bootstrap.Carousel()</code></li>
                        </ul>

                        <h5>🎯 eventos configurados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
        carouselElement.addEventListener('mouseenter', function() { carousel.pause(); });
        carouselElement.addEventListener('mouseleave', function() { carousel.cycle(); });
                </code>
                    </div>

                    <h3>🎯 tecnologias e integrações</h3>
                    <div class="tech-stack">
                        <span class="tech-item">React</span>
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">Bootstrap Icons</span>
                        <span class="tech-item">Carousel</span>
                        <span class="tech-item">WordPress Query</span>
                        <span class="tech-item">AJAX</span>
                        <span class="tech-item">Markdown</span>
                        <span class="tech-item">Responsive Design</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>interface moderna:</strong> Design limpo e profissional</li>
                            <li><strong>experiência responsiva:</strong> Adaptável a todos dispositivos</li>
                            <li><strong>performance otimizada:</strong> Carregamento eficiente de recursos</li>
                            <li><strong>acessibilidade:</strong> Navegação por teclado e leitores de tela</li>
                            <li><strong>usabilidade:</strong> Feedback visual e transições suaves</li>
                            <li><strong>tecnologia avançada:</strong> Integração com React e IA</li>
                        </ul>
                    </div>
                </div>


                <!-- ===== tab content - tema search ===== -->
                <div class="tab-pane fade" id="theme-search" role="tabpanel" aria-labelledby="theme-search-tab">
                    <h2>🔍 Search do Tema<span>/wp-content/themes/novoicode/search.php</span></h2>
                    <p>Sistema de busca avançada com resultados em posts e PDFs, interface em abas e controle de acesso
                        inteligente.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📝 busca em posts</h4>
                            <p>Pesquisa em conteúdo WordPress</p>
                            <code>WP_Query</code>
                        </div>
                        <div class="card">
                            <h4>📄 busca em PDFs</h4>
                            <p>Pesquisa em texto de documentos</p>
                            <code>pdf_index</code>
                        </div>
                        <div class="card">
                            <h4>🎨 interface em abas</h4>
                            <p>Navegação organizada por tipo</p>
                            <code>nav-tabs</code>
                        </div>
                        <div class="card">
                            <h4>🔍 excerpt inteligente</h4>
                            <p>Trechos com contexto da busca</p>
                            <code>smart_search_excerpt()</code>
                        </div>
                    </div>

                    <h3>🔐 sistema de controle de acesso</h3>
                    <div class="card">
                        <h4>📋 verificação de permissões</h4>

                        <h5>1. aceite dos termos</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
                        echo '&lt;script&gt;window.location.href = "/perfil";&lt;/script&gt;';
                            </code>

                        <h5>2. definição de escopo</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if ($is_admin) {
                        // Admin pode ver qualquer tipo
                        $tipo = in_array(url_active()[1],$post_types) ? url_active()[1] : $post_types;
                    } else {
                        // Usuário normal - apenas seus tipos
                        $tipo = in_array(url_active()[1],$post_types) ? url_active()[1] : get_user_meta($user_id, 'membro', true);
                    }
                            </code>

                        <h5>3. filtro de conteúdo privado</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $post_privado = get_post_meta($post_id, $tipo . '_privado', true);
                    if ($post_privado && !$user_privado) {
                        continue; // pula posts privados sem permissão
                    }
                            </code>
                    </div>

                    <h3>📊 lógica de busca inteligente</h3>
                    <div class="card">
                        <h4>🎯 definição de contexto</h4>
                        <code>$tipo + $title + $subtitle</code>
                        <p>Determina o escopo da busca baseado no usuário e URL</p>

                        <h5>🔧 fluxo de decisão:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">usuário</th>
                                    <th style="padding: 0.5rem; text-align: left;">URL ativa</th>
                                    <th style="padding: 0.5rem; text-align: left;">escopo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Admin</td>
                                    <td style="padding: 0.5rem;">Tipo específico</td>
                                    <td style="padding: 0.5rem;">Apenas o tipo</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Admin</td>
                                    <td style="padding: 0.5rem;">Busca avançada</td>
                                    <td style="padding: 0.5rem;">Todos os tipos</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Usuário</td>
                                    <td style="padding: 0.5rem;">Tipo específico</td>
                                    <td style="padding: 0.5rem;">Apenas o tipo</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Usuário</td>
                                    <td style="padding: 0.5rem;">Busca avançada</td>
                                    <td style="padding: 0.5rem;">Seus tipos apenas</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🔍 sistema de excerpt inteligente</h3>
                    <div class="card">
                        <h4>🎯 trechos contextuais</h4>
                        <code>smart_search_excerpt()</code>
                        <p>Gera trechos destacando os termos de busca</p>

                        <h5>🔄 fluxo do algoritmo:</h5>
                        <ol style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>limpeza:</strong> Remove tags HTML do conteúdo</li>
                            <li><strong>localização:</strong> Encontra primeira ocorrência do termo</li>
                            <li><strong>contexto:</strong> Extrai 200 chars antes/depois</li>
                            <li><strong>formatação:</strong> Adiciona "..." e destaque em negrito</li>
                            <li><strong>fallback:</strong> Excerpt normal se não encontrar</li>
                        </ol>

                        <h5>🎨 exemplo de saída:</h5>
                        <div
                            style="background: #f8f9fa; border: 1px solid #dee2e6; padding: 1rem; border-radius: 5px; margin-top: 0.5rem;">
                            <small>... texto anterior <strong>termo buscado</strong> texto posterior ...</small>
                        </div>

                        <h5>⚙️ parâmetros da função:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    function smart_search_excerpt($content, $search_term, $chars_before_after = 200)
                            </code>
                    </div>

                    <h3>📝 busca em posts</h3>
                    <div class="card">
                        <h4>⚙️ query WordPress</h4>
                        <code>WP_Query</code>
                        <p>Busca padrão do WordPress com filtros customizados</p>

                        <h5>🎯 parâmetros da busca:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $args = array(
                        's' => $s,                    // termo de busca
                        'post_type' => $tipo,         // tipos permitidos
                        'posts_per_page' => -1,       // todos os resultados
                        'orderby' => 'date',          // ordenação por data
                        'order' => 'DESC'             // mais recentes primeiro
                    );
                            </code>

                        <h5>📊 estrutura da tabela:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">coluna</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                    <th style="padding: 0.5rem; text-align: left;">formato</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Título</td>
                                    <td style="padding: 0.5rem;">Link + título + excerpt</td>
                                    <td style="padding: 0.5rem;">Hierarquizado</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Data</td>
                                    <td style="padding: 0.5rem;">Data de publicação</td>
                                    <td style="padding: 0.5rem;">dd/mm/YYYY, HH:ii</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📄 busca em PDFs</h3>
                    <div class="card">
                        <h4>🗄️ consulta ao banco</h4>
                        <code>pdf_index table</code>
                        <p>Busca no índice de conteúdo extraído de PDFs</p>

                        <h5>🎯 query SQL dinâmica:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (is_array($tipo)) {
                        // Múltiplos tipos - usa IN()
                        $placeholders = implode(',', array_fill(0, count($tipo), '%s'));
                        $query_pdf = $wpdb->prepare("SELECT * FROM $tabela WHERE texto LIKE %s AND tipo IN ($placeholders) ORDER BY ano DESC", ...);
                    } else {
                        // Tipo único - usa =
                        $query_pdf = $wpdb->prepare("SELECT * FROM $tabela WHERE texto LIKE %s AND tipo = %s ORDER BY ano DESC", ...);
                    }
                            </code>

                        <h5>📊 estrutura da tabela PDF:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">campo</th>
                                    <th style="padding: 0.5rem; text-align: left;">tipo</th>
                                    <th style="padding: 0.5rem; text-align: left;">uso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">texto</td>
                                    <td style="padding: 0.5rem;">LONGTEXT</td>
                                    <td style="padding: 0.5rem;">Conteúdo extraído</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">arquivo</td>
                                    <td style="padding: 0.5rem;">VARCHAR</td>
                                    <td style="padding: 0.5rem;">Caminho do arquivo</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">tipo</td>
                                    <td style="padding: 0.5rem;">VARCHAR</td>
                                    <td style="padding: 0.5rem;">Tipo do post</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">ano</td>
                                    <td style="padding: 0.5rem;">YEAR</td>
                                    <td style="padding: 0.5rem;">Ano de referência</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">id_post</td>
                                    <td style="padding: 0.5rem;">INT</td>
                                    <td style="padding: 0.5rem;">ID do post relacionado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🎨 interface de usuário</h3>
                    <div class="card">
                        <h4>📑 sistema de abas</h4>
                        <code>nav-tabs</code>
                        <p>Navegação organizada entre posts e PDFs</p>

                        <h5>🎯 componentes das abas:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">aba</th>
                                    <th style="padding: 0.5rem; text-align: left;">ícone</th>
                                    <th style="padding: 0.5rem; text-align: left;">badge</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Posts</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-file-earmark-text"></i></td>
                                    <td style="padding: 0.5rem;"><code>posts-count</code></td>
                                    <td style="padding: 0.5rem;">Conteúdo WordPress</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">PDFs</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-file-pdf"></i></td>
                                    <td style="padding: 0.5rem;"><code>pdfs-count</code></td>
                                    <td style="padding: 0.5rem;">Documentos indexados</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>📊 contadores dinâmicos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    document.getElementById('posts-count').textContent = '&lt;?php echo $posts_count; ?&gt;';
                    document.getElementById('pdfs-count').textContent = '&lt;?php echo $pdfs_count; ?&gt;';
                            </code>
                    </div>

                    <h3>⚡ datatables configuration</h3>
                    <div class="card">
                        <h4>🎛️ tabelas interativas</h4>
                        <code>dataConfig</code>
                        <p>Configuração completa para tabelas paginadas e ordenáveis</p>

                        <h5>🎯 configurações principais:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">configuração</th>
                                    <th style="padding: 0.5rem; text-align: left;">valor</th>
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">ordenação</td>
                                    <td style="padding: 0.5rem;"><code>[[1, 'desc']]</code></td>
                                    <td style="padding: 0.5rem;">Data/Ano decrescente</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">paginação</td>
                                    <td style="padding: 0.5rem;"><code>pageLength: 25</code></td>
                                    <td style="padding: 0.5rem;">25 itens por página</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">DOM</td>
                                    <td style="padding: 0.5rem;">
                                        <code>&lt;"top"lf&gt;rt&lt;"bottom"ip&gt;&lt;"clear"&gt;</code>
                                    </td>
                                    <td style="padding: 0.5rem;">Layout personalizado</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">idioma</td>
                                    <td style="padding: 0.5rem;"><code>language: {}</code></td>
                                    <td style="padding: 0.5rem;">Português brasileiro</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔄 inicialização dinâmica:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    function initDataTables() {
                        $('.tcategory').each(function() {
                            if (!$.fn.DataTable.isDataTable(this)) {
                                $(this).DataTable(dataConfig);
                            }
                        });
                    }
                            </code>
                    </div>

                    <h3>🔗 processamento de URLs</h3>
                    <div class="card">
                        <h4>🌐 geração de links</h4>
                        <code>site_url() + ABSPATH</code>
                        <p>Conversão de caminhos físicos para URLs web</p>

                        <h5>🎯 exemplo PDF:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $url_site = site_url();
                    $url = $url_site . str_replace(ABSPATH, '/', $r->arquivo);
                            </code>
                        <p>Converte <code>/var/www/.../wp-content/uploads/...</code> para
                            <code>https://site.com/wp-content/uploads/...</code>
                        </p>
                    </div>

                    <h3>🎯 tecnologias e integrações</h3>
                    <div class="tech-stack">
                        <span class="tech-item">DataTables</span>
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">Bootstrap Icons</span>
                        <span class="tech-item">jQuery</span>
                        <span class="tech-item">WP_Query</span>
                        <span class="tech-item">MySQL</span>
                        <span class="tech-item">AJAX</span>
                        <span class="tech-item">Responsive Design</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>busca unificada:</strong> Posts e PDFs na mesma interface</li>
                            <li><strong>contexto inteligente:</strong> Trechos que mostram onde o termo foi encontrado</li>
                            <li><strong>controle granular:</strong> Permissões por tipo e conteúdo privado</li>
                            <li><strong>performance:</strong> Paginação client-side com DataTables</li>
                            <li><strong>experiência rica:</strong> Interface moderna e responsiva</li>
                            <li><strong>acessibilidade:</strong> Navegação por teclado e leitores de tela</li>
                        </ul>
                    </div>
                </div>


                <!-- ===== tab content - tema page calendarios ===== -->
                <div class="tab-pane fade" id="theme-page-calendarios" role="tabpanel"
                    aria-labelledby="theme-page-calendarios-tab">
                    <h2>📅 Page Calendários do Tema<span>/wp-content/themes/novoicode/page-calendarios.php</span></h2>
                    <p>Sistema unificado de calendários institucionais com abas para diferentes órgãos colegiados.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🏛️ calendário congregação</h4>
                            <p>Agenda da congregação</p>
                            <code>mostrar_calendario('congrega')</code>
                        </div>
                        <div class="card">
                            <h4>👥 calendário CI</h4>
                            <p>Conselho Interdepartamental</p>
                            <code>mostrar_calendario('ci')</code>
                        </div>
                        <div class="card">
                            <h4>🏢 calendário departamentos</h4>
                            <p>Agenda departamental</p>
                            <code>mostrar_calendario('depto')</code>
                        </div>
                        <div class="card">
                            <h4>🎨 interface em abas</h4>
                            <p>Navegação organizada</p>
                            <code>nav-tabs</code>
                        </div>
                    </div>

                    <h3>🔐 controle de acesso</h3>
                    <div class="card">
                        <h4>📋 verificação de aceite</h4>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
                        echo '&lt;script&gt;window.location.href = "/perfil";&lt;/script&gt;';
                            </code>
                        <p>Redireciona para perfil se usuário não aceitou termos</p>
                    </div>

                    <h3>📊 estrutura da página</h3>
                    <div class="card">
                        <h4>🏷️ cabeçalho e navegação</h4>
                        <code>pagetitle + breadcrumb</code>
                        <p>Área superior com título, ano atual e breadcrumbs</p>

                        <h5>🎯 elementos do cabeçalho:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">elemento</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                    <th style="padding: 0.5rem; text-align: left;">detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Título</td>
                                    <td style="padding: 0.5rem;">Calendários <?php echo $current_year ?></td>
                                    <td style="padding: 0.5rem;">Ano atual dinâmico</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Ícone</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-calendar"></i></td>
                                    <td style="padding: 0.5rem;">Bootstrap Icons</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Breadcrumb</td>
                                    <td style="padding: 0.5rem;">Home → [página_atual]</td>
                                    <td style="padding: 0.5rem;">Navegação hierárquica</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Botão Voltar</td>
                                    <td style="padding: 0.5rem;">Link para Home</td>
                                    <td style="padding: 0.5rem;">Navegação rápida</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔗 breadcrumbs dinâmicos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    echo "&lt;a href='/" . url_active()[1] . "'&gt;" . url_active()[1] . "&lt;/a&gt;";
                    echo "&lt;a href='/" . url_active()[1] . "/" . url_active()[2] . "'&gt;" . url_active()[2] . "&lt;/a&gt;";
                            </code>
                    </div>

                    <h3>🎨 sistema de abas</h3>
                    <div class="card">
                        <h4>📑 navegação por órgãos</h4>
                        <code>nav-tabs</code>
                        <p>Interface organizada em abas para diferentes calendários</p>

                        <h5>🎯 abas disponíveis:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">aba</th>
                                    <th style="padding: 0.5rem; text-align: left;">órgão</th>
                                    <th style="padding: 0.5rem; text-align: left;">ícone</th>
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Congregação</td>
                                    <td style="padding: 0.5rem;">Congregação</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-people-fill"></i></td>
                                    <td style="padding: 0.5rem;">Calendário principal</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">CI</td>
                                    <td style="padding: 0.5rem;">Conselho Interdepartamental</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-person-lines-fill"></i></td>
                                    <td style="padding: 0.5rem;">Calendário do CI</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Departamentos</td>
                                    <td style="padding: 0.5rem;">Departamentos</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-person-vcard"></i></td>
                                    <td style="padding: 0.5rem;">Calendários departamentais</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>⚡ inicialização:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;ul class="nav nav-tabs" id="calendarioTabs" role="tablist"&gt;
                        &lt;li class="nav-item" role="presentation"&gt;
                            &lt;button class="nav-link active" id="congrega-tab" data-bs-toggle="tab" 
                                    data-bs-target="#congrega-tab-pane" type="button" role="tab" 
                                    aria-controls="congrega-tab-pane" aria-selected="true"&gt;
                                &lt;i class="bi bi-people-fill me-2"&gt;&lt;/i&gt;Congregação
                            &lt;/button&gt;
                        &lt;/li&gt;
                        // ... outras abas
                    &lt;/ul&gt;
                            </code>
                    </div>

                    <h3>📅 sistema de calendários</h3>
                    <div class="card">
                        <h4>🔄 função principal</h4>
                        <code>mostrar_calendario($tipo)</code>
                        <p>Função que renderiza os calendários específicos de cada órgão</p>

                        <h5>🎯 parâmetros:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">parâmetro</th>
                                    <th style="padding: 0.5rem; text-align: left;">valor</th>
                                    <th style="padding: 0.5rem; text-align: left;">descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">congrega</td>
                                    <td style="padding: 0.5rem;">'congrega'</td>
                                    <td style="padding: 0.5rem;">Calendário da Congregação</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">ci</td>
                                    <td style="padding: 0.5rem;">'ci'</td>
                                    <td style="padding: 0.5rem;">Conselho Interdepartamental</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">depto</td>
                                    <td style="padding: 0.5rem;">'depto'</td>
                                    <td style="padding: 0.5rem;">Departamentos</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>📊 implementação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;div class="tab-pane fade show active" id="congrega-tab-pane" role="tabpanel" 
                        aria-labelledby="congrega-tab" tabindex="0"&gt;
                        &lt;div class="p-4"&gt;
                            &lt;h5 class="card-title text-primary mb-4"&gt;Calendário da Congregação&lt;/h5&gt;
                            &lt;?php echo mostrar_calendario('congrega') ?&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                            </code>
                    </div>

                    <h3>🎯 elementos de interface</h3>
                    <div class="card">
                        <h4>💎 design consistente</h4>
                        <p>Elementos visuais padronizados em todas as abas</p>

                        <h5>🎨 padrões visuais:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">elemento</th>
                                    <th style="padding: 0.5rem; text-align: left;">estilo</th>
                                    <th style="padding: 0.5rem; text-align: left;">propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Título da aba</td>
                                    <td style="padding: 0.5rem;"><code>card-title text-primary</code></td>
                                    <td style="padding: 0.5rem;">Destaque visual</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Conteúdo</td>
                                    <td style="padding: 0.5rem;"><code>p-4</code></td>
                                    <td style="padding: 0.5rem;">Padding consistente</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Margem inferior</td>
                                    <td style="padding: 0.5rem;"><code>mb-4</code></td>
                                    <td style="padding: 0.5rem;">Espaçamento adequado</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Botão voltar</td>
                                    <td style="padding: 0.5rem;"><code>btn btn-light</code></td>
                                    <td style="padding: 0.5rem;">Ação secundária</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>⚡ interatividade JavaScript</h3>
                    <div class="card">
                        <h4>🎮 controle de abas</h4>
                        <code>DOMContentLoaded event</code>
                        <p>Melhoria da experiência do usuário com transições suaves</p>

                        <h5>🔧 funcionalidades:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>transição suave:</strong> Animação entre abas</li>
                            <li><strong>controle de estado:</strong> Classe active dinâmica</li>
                            <li><strong>seleção múltipla:</strong> Prevenção de conflitos</li>
                        </ul>

                        <h5>🎯 implementação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    document.addEventListener('DOMContentLoaded', function() {
                        const tabTriggers = [].slice.call(document.querySelectorAll('#calendarioTabs button'));
                        tabTriggers.forEach(function(tabTrigger) {
                            tabTrigger.addEventListener('click', function() {
                                // Remove classe ativa de todas as abas
                                tabTriggers.forEach(function(trigger) {
                                    trigger.classList.remove('active');
                                });
                                // Adiciona classe ativa na aba clicada
                                this.classList.add('active');
                            });
                        });
                    });
                            </code>
                    </div>

                    <h3>🔧 funções e integrações</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📍 url_active()</h4>
                            <p>Detecção de contexto da URL</p>
                            <code>url_active()[1] // página</code>
                        </div>
                        <div class="card">
                            <h4>📅 mostrar_calendario()</h4>
                            <p>Renderização de calendários</p>
                            <code>mostrar_calendario($tipo)</code>
                        </div>
                        <div class="card">
                            <h4>👤 get_user_meta()</h4>
                            <p>Verificação de aceite</p>
                            <code>get_user_meta($user_id, 'aceite')</code>
                        </div>
                        <div class="card">
                            <h4>🏷️ get_header()</h4>
                            <p>Cabeçalho WordPress</p>
                            <code>get_header()</code>
                        </div>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">Bootstrap Icons</span>
                        <span class="tech-item">JavaScript</span>
                        <span class="tech-item">PHP</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">Responsive Design</span>
                        <span class="tech-item">Tab System</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>organização clara:</strong> Abas separadas por órgãos colegiados</li>
                            <li><strong>acesso controlado:</strong> Verificação de aceite de termos</li>
                            <li><strong>navegação intuitiva:</strong> Breadcrumbs e botão voltar</li>
                            <li><strong>design responsivo:</strong> Adaptável a todos dispositivos</li>
                            <li><strong>performance:</strong> Carregamento otimizado de recursos</li>
                            <li><strong>acessibilidade:</strong> Atributos ARIA para leitores de tela</li>
                        </ul>
                    </div>

                    <h3>🌐 contexto institucional</h3>
                    <div class="card">
                        <h4>🏛️ órgãos colegiados</h4>
                        <p>Estrutura organizacional refletida na interface</p>

                        <h5>🎯 hierarquia institucional:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Congregação:</strong> Órgão máximo deliberativo</li>
                            <li><strong>CI - Conselho Interdepartamental:</strong> Órgão consultivo e deliberativo</li>
                            <li><strong>Departamentos:</strong> Unidades acadêmicas básicas</li>
                        </ul>

                        <h5>📅 propósito dos calendários:</h5>
                        <p>Coordenação e divulgação das atividades regulares de cada órgão, incluindo reuniões, prazos e
                            eventos institucionais.</p>
                    </div>
                </div>


                <!-- ===== tab content - tema page perfil ===== -->
                <div class="tab-pane fade" id="theme-page-perfil" role="tabpanel" aria-labelledby="theme-page-perfil-tab">
                    <h2>👤 Page Perfil do Tema<span>/wp-content/themes/novoicode/page-perfil.php</span></h2>
                    <p>Sistema completo de gerenciamento de perfil do usuário com aceite de termos, atualização de dados e
                        controle de permissões.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📝 aceite de termos</h4>
                            <p>Contrato de uso do sistema</p>
                            <code>portal_input_5</code>
                        </div>
                        <div class="card">
                            <h4>📊 informações do usuário</h4>
                            <p>Dados pessoais e permissões</p>
                            <code>user_meta</code>
                        </div>
                        <div class="card">
                            <h4>🖼️ upload de avatar</h4>
                            <p>Foto de perfil personalizada</p>
                            <code>wp_user_avatar</code>
                        </div>
                        <div class="card">
                            <h4>📧 notificação por email</h4>
                            <p>Confirmação de cadastro</p>
                            <code>wp_mail()</code>
                        </div>
                    </div>

                    <h3>🔐 sistema de aceite de termos</h3>
                    <div class="card">
                        <h4>📋 fluxo de aceite</h4>
                        <code>aceite user_meta</code>
                        <p>Controle de acesso baseado na aceitação dos termos</p>

                        <h5>🎯 verificação inicial:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $saved_aceite = get_user_meta($current_user->ID, 'aceite', true);
                    if (empty($saved_aceite)) {
                        // Mostra formulário de aceite
                    } else {
                        // Mostra perfil completo
                    }
                            </code>

                        <h5>📝 conteúdo dos termos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    echo get_option('portal_input_5');
                            </code>
                        <p>Conteúdo HTML personalizável via painel administrativo</p>

                        <h5>🔄 processamento do aceite:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (isset($_POST['btn_save'])) {
                        $aceite_valor = $_POST['btn_save'];
                        update_user_meta($current_user->ID, 'aceite', $aceite_valor);
                
                        // Envia email de confirmação
                        // Redireciona usuário
                    }
                            </code>
                    </div>

                    <h3>📧 sistema de notificação por email</h3>
                    <div class="card">
                        <h4>📨 confirmação de cadastro</h4>
                        <code>wp_mail()</code>
                        <p>Email automático com cópia para administração</p>

                        <h5>🎯 configuração do email:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $para = $current_user->user_email;
                    $assunto = 'Confirmação de criação de conta';
                    $mensagem = wpautop("&lt;h4&gt;Usuário: " . $current_user->user_email . "&lt;/h4&gt;&lt;br&gt;" . $conteudo);
                    $headers = [
                        'Content-Type: text/html; charset=UTF-8',
                        'Cc: icti@unicamp.br'
                    ];
                    wp_mail($para, $assunto, $mensagem, $headers);
                            </code>

                        <h5>📋 características do email:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>formato HTML:</strong> Layout formatado</li>
                            <li><strong>cópia para ICTI:</strong> Transparência administrativa</li>
                            <li><strong>conteúdo personalizável:</strong> Mesmo texto dos termos</li>
                            <li><strong>charset UTF-8:</strong> Suporte a caracteres especiais</li>
                        </ul>
                    </div>

                    <h3>👤 seção de informações do perfil</h3>
                    <div class="card">
                        <h4>📊 dados do usuário</h4>
                        <code>wp_get_current_user()</code>
                        <p>Exibição organizada das informações do usuário</p>

                        <h5>🎯 informações exibidas:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">campo</th>
                                    <th style="padding: 0.5rem; text-align: left;">fonte</th>
                                    <th style="padding: 0.5rem; text-align: left;">exemplo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Nome</td>
                                    <td style="padding: 0.5rem;"><code>user_firstname</code></td>
                                    <td style="padding: 0.5rem;">João</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Sobrenome</td>
                                    <td style="padding: 0.5rem;"><code>user_lastname</code></td>
                                    <td style="padding: 0.5rem;">Silva</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Email</td>
                                    <td style="padding: 0.5rem;"><code>user_email</code></td>
                                    <td style="padding: 0.5rem;">usuario@unicamp.br</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Papel</td>
                                    <td style="padding: 0.5rem;"><code>user_roles</code></td>
                                    <td style="padding: 0.5rem;">Editor, Assinante</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Avatar</td>
                                    <td style="padding: 0.5rem;"><code>wp_user_avatar</code></td>
                                    <td style="padding: 0.5rem;">URL da imagem</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🎨 estilo da lista:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    ul.triangulo li::before { content: "►"; }
                    ul.triangulo li ul li::before { content: "●"; }
                            </code>
                    </div>

                    <h3>🔐 sistema de permissões</h3>
                    <div class="card">
                        <h4>👥 tipos de membro</h4>
                        <code>membro user_meta</code>
                        <p>Controle de acesso a diferentes tipos de conteúdo</p>

                        <h5>🎯 níveis de permissão:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">tipo</th>
                                    <th style="padding: 0.5rem; text-align: left;">meta key</th>
                                    <th style="padding: 0.5rem; text-align: left;">descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Membro</td>
                                    <td style="padding: 0.5rem;"><code>membro</code></td>
                                    <td style="padding: 0.5rem;">Tipos de conteúdo principais</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Posts Privados</td>
                                    <td style="padding: 0.5rem;"><code>membro_post_privado</code></td>
                                    <td style="padding: 0.5rem;">Acesso a posts restritos</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Arquivos Privados</td>
                                    <td style="padding: 0.5rem;"><code>membro_arquivo_privado</code></td>
                                    <td style="padding: 0.5rem;">Acesso a arquivos restritos</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔧 processamento dos dados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $tipos_membro_usuario = get_user_meta($current_user->ID, 'membro', true);
                    $membro = is_array($tipos_membro_usuario) && !empty($tipos_membro_usuario) 
                        ? implode(', ', $tipos_membro_usuario) 
                        : '';
                            </code>
                    </div>

                    <h3>🖼️ sistema de avatar</h3>
                    <div class="card">
                        <h4>📸 upload de imagem</h4>
                        <code>wp_user_avatar meta</code>
                        <p>Sistema de foto de perfil personalizada</p>

                        <h5>🎯 fluxo do avatar:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $avatar_id = get_user_meta($current_user->ID, 'wp_user_avatar', true);
                    $current_user_avatar = $avatar_id 
                        ? wp_get_attachment_url($avatar_id) 
                        : get_avatar_url($current_user->ID);
                            </code>

                        <h5>📁 características do upload:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>formatos suportados:</strong> JPG, JPEG, PNG</li>
                            <li><strong>fallback:</strong> Gravatar padrão se não hustom avatar</li>
                            <li><strong>armazenamento:</strong> Media Library do WordPress</li>
                            <li><strong>estilo:</strong> Circular com borda</li>
                        </ul>
                    </div>

                    <h3>✏️ formulário de atualização</h3>
                    <div class="card">
                        <h4>🔄 atualização via AJAX</h4>
                        <code>FormData + Fetch API</code>
                        <p>Atualização assíncrona sem recarregar a página</p>

                        <h5>🎯 campos editáveis:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">campo</th>
                                    <th style="padding: 0.5rem; text-align: left;">name</th>
                                    <th style="padding: 0.5rem; text-align: left;">tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Nome</td>
                                    <td style="padding: 0.5rem;"><code>novo_nome</code></td>
                                    <td style="padding: 0.5rem;">text</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Sobrenome</td>
                                    <td style="padding: 0.5rem;"><code>novo_sobrenome</code></td>
                                    <td style="padding: 0.5rem;">text</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Avatar</td>
                                    <td style="padding: 0.5rem;"><code>novo_avatar</code></td>
                                    <td style="padding: 0.5rem;">file</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>⚡ JavaScript AJAX:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    document.querySelector(".alterar-perfil form").addEventListener("submit", function (e) {
                        e.preventDefault();
                        const formData = new FormData(form);
                
                        fetch('&lt;?php echo admin_url("admin-ajax.php"); ?&gt;', {
                            method: 'POST',
                            body: formData,
                        }).then(res => res.json())
                        .then(data => {
                            // Feedback visual e atualização do avatar
                        });
                    });
                            </code>
                    </div>

                    <h3>🔄 redirecionamentos inteligentes</h3>
                    <div class="card">
                        <h4>🎯 lógica de navegação</h4>
                        <code>session + redirect</code>
                        <p>Sistema que lembra a página original do usuário</p>

                        <h5>🎯 após aceite:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if ($aceite_valor === '1') {
                        $redirect_to = $_SESSION['ldap_login_redirect'];
                        echo '&lt;script&gt;window.location.href = "' . $redirect_to . '";&lt;/script&gt;';
                    } else {
                        wp_logout();
                        echo '&lt;script&gt;window.location.href = "/login";&lt;/script&gt;';
                    }
                            </code>

                        <h5>🔐 logout personalizado:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;a class="btn btn-primary" href="&lt;?php echo esc_url(site_url('?icode_logout=1')); ?&gt;"&gt;
                        &amp;ensp;Sair&amp;ensp;
                    &lt;/a&gt;
                            </code>
                    </div>

                    <h3>🔧 funções personalizadas</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📍 url_active()</h4>
                            <p>Detecção de contexto da URL</p>
                            <code>url_active()[1] // página atual</code>
                        </div>
                        <div class="card">
                            <h4>🏷️ traduz_papel()</h4>
                            <p>Tradução de roles do WordPress</p>
                            <code>traduz_papel($role)</code>
                        </div>
                        <div class="card">
                            <h4>📊 registerdb()</h4>
                            <p>Registro de acesso do usuário</p>
                            <code>registerdb($user, $ip, $url)</code>
                        </div>
                        <div class="card">
                            <h4>🔐 icode_logout</h4>
                            <p>Logout personalizado do sistema</p>
                            <code>?icode_logout=1</code>
                        </div>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">Bootstrap Icons</span>
                        <span class="tech-item">Fetch API</span>
                        <span class="tech-item">FormData</span>
                        <span class="tech-item">PHP Sessions</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">AJAX</span>
                        <span class="tech-item">wp_mail</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>segurança reforçada:</strong> Aceite de termos obrigatório</li>
                            <li><strong>transparência:</strong> Email de confirmação com cópia</li>
                            <li><strong>experiência fluida:</strong> Atualizações via AJAX</li>
                            <li><strong>personalização:</strong> Avatar customizável</li>
                            <li><strong>acessibilidade:</strong> Navegação intuitiva</li>
                            <li><strong>controle granular:</strong> Sistema de permissões detalhado</li>
                        </ul>
                    </div>
                </div>


                <!-- ===== tab content - tema page pessoas ===== -->
                <div class="tab-pane fade" id="theme-page-pessoas" role="tabpanel" aria-labelledby="theme-page-pessoas-tab">
                    <h2>👥 Page Pessoas do Tema<span>/wp-content/themes/novoicode/page-pessoas.php</span></h2>
                    <p>Diretório institucional com listagem de docentes e funcionários integrado à intranet do IC.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🎓 lista de docentes</h4>
                            <p>Corpo docente do instituto</p>
                            <code>table_docentes()</code>
                        </div>
                        <div class="card">
                            <h4>👨‍💼 lista de funcionários</h4>
                            <p>Equipe técnica e administrativa</p>
                            <code>table_funcionarios()</code>
                        </div>
                        <div class="card">
                            <h4>🎨 interface em abas</h4>
                            <p>Navegação organizada</p>
                            <code>nav-tabs</code>
                        </div>
                        <div class="card">
                            <h4>🔗 integração intranet</h4>
                            <p>Dados em tempo real</p>
                            <code>INTRANET constante</code>
                        </div>
                    </div>

                    <h3>🔐 controle de acesso</h3>
                    <div class="card">
                        <h4>📋 verificação de aceite</h4>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
                        echo '&lt;script&gt;window.location.href = "/perfil";&lt;/script&gt;';
                            </code>
                        <p>Redireciona para perfil se usuário não aceitou termos</p>
                    </div>

                    <h3>📊 estrutura da página</h3>
                    <div class="card">
                        <h4>🏷️ cabeçalho e navegação</h4>
                        <code>pagetitle + breadcrumb</code>
                        <p>Área superior com título e breadcrumbs dinâmicos</p>

                        <h5>🎯 elementos do cabeçalho:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">elemento</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                    <th style="padding: 0.5rem; text-align: left;">detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Título</td>
                                    <td style="padding: 0.5rem;">Pessoas do ICODE</td>
                                    <td style="padding: 0.5rem;">Identificação clara</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Ícone</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-person-fill"></i></td>
                                    <td style="padding: 0.5rem;">Bootstrap Icons</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Breadcrumb</td>
                                    <td style="padding: 0.5rem;">Home → [página_atual]</td>
                                    <td style="padding: 0.5rem;">Navegação hierárquica</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Botão Voltar</td>
                                    <td style="padding: 0.5rem;">Link para Home</td>
                                    <td style="padding: 0.5rem;">Navegação rápida</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔗 breadcrumbs dinâmicos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    echo "&lt;a href='/" . url_active()[1] . "'&gt;" . url_active()[1] . "&lt;/a&gt;";
                    echo "&lt;a href='/" . url_active()[1] . "/" . url_active()[2] . "'&gt;" . url_active()[2] . "&lt;/a&gt;";
                            </code>
                    </div>

                    <h3>🎨 sistema de abas</h3>
                    <div class="card">
                        <h4>📑 navegação por categoria</h4>
                        <code>nav-tabs</code>
                        <p>Interface organizada em abas para diferentes categorias de pessoas</p>

                        <h5>🎯 abas disponíveis:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">aba</th>
                                    <th style="padding: 0.5rem; text-align: left;">categoria</th>
                                    <th style="padding: 0.5rem; text-align: left;">ícone</th>
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Docentes</td>
                                    <td style="padding: 0.5rem;">Corpo Docente</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-mortarboard-fill"></i></td>
                                    <td style="padding: 0.5rem;">Professores e pesquisadores</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Funcionários</td>
                                    <td style="padding: 0.5rem;">Equipe TAE</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-person-badge"></i></td>
                                    <td style="padding: 0.5rem;">Técnicos e administrativos</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>⚡ inicialização:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;ul class="nav nav-tabs" id="pessoasTabs" role="tablist"&gt;
                        &lt;li class="nav-item" role="presentation"&gt;
                            &lt;button class="nav-link active" id="docentes-tab" data-bs-toggle="tab" 
                                    data-bs-target="#docentes-tab-pane" type="button" role="tab" 
                                    aria-controls="docentes-tab-pane" aria-selected="true"&gt;
                                &lt;i class="bi bi-mortarboard-fill me-2"&gt;&lt;/i&gt;Docentes
                            &lt;/button&gt;
                        &lt;/li&gt;
                        // ... outras abas
                    &lt;/ul&gt;
                            </code>
                    </div>

                    <h3>🎓 aba de docentes</h3>
                    <div class="card">
                        <h4>📚 corpo docente</h4>
                        <code>table_docentes()</code>
                        <p>Lista completa dos professores e pesquisadores do instituto</p>

                        <h5>🎯 estrutura da tabela:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">coluna</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                    <th style="padding: 0.5rem; text-align: left;">detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Avatar</td>
                                    <td style="padding: 0.5rem;">Foto</td>
                                    <td style="padding: 0.5rem;">Imagem do docente</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Nome</td>
                                    <td style="padding: 0.5rem;">Nome completo</td>
                                    <td style="padding: 0.5rem;">Identificação</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Membro</td>
                                    <td style="padding: 0.5rem;">Participação</td>
                                    <td style="padding: 0.5rem;">Colegiados/Comissões</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">E-Mail</td>
                                    <td style="padding: 0.5rem;">Contato</td>
                                    <td style="padding: 0.5rem;">Email institucional</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔗 fonte de dados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;small class="fonte"&gt;&lt;b&gt;Fonte&lt;/b&gt;: &lt;a href="&lt;?php echo INTRANET ?&gt;/docentes/siteic" target="_blank"&gt;&lt;?php echo INTRANET ?&gt;/docentes/siteic&lt;/a&gt;&lt;/small&gt;
                            </code>
                    </div>

                    <h3>👨‍💼 aba de funcionários</h3>
                    <div class="card">
                        <h4>🏢 equipe TAE</h4>
                        <code>table_funcionarios()</code>
                        <p>Lista da equipe técnica e administrativa do instituto</p>

                        <h5>🎯 estrutura da tabela:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">coluna</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                    <th style="padding: 0.5rem; text-align: left;">detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Avatar</td>
                                    <td style="padding: 0.5rem;">Foto</td>
                                    <td style="padding: 0.5rem;">Imagem do funcionário</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Nome</td>
                                    <td style="padding: 0.5rem;">Nome completo</td>
                                    <td style="padding: 0.5rem;">Identificação</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Papel</td>
                                    <td style="padding: 0.5rem;">Função</td>
                                    <td style="padding: 0.5rem;">Cargo/Atribuição</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">E-Mail</td>
                                    <td style="padding: 0.5rem;">Contato</td>
                                    <td style="padding: 0.5rem;">Email institucional</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔗 fonte de dados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;small class="fonte"&gt;&lt;b&gt;Fonte&lt;/b&gt;: &lt;a href="&lt;?php echo INTRANET ?&gt;/funcionarios/siteic" target="_blank"&gt;&lt;?php echo INTRANET ?&gt;/funcionarios/siteic&lt;/a&gt;&lt;/small&gt;
                            </code>
                    </div>

                    <h3>🎨 elementos de interface</h3>
                    <div class="card">
                        <h4>💎 design responsivo</h4>
                        <p>Interface moderna e adaptável para todos os dispositivos</p>

                        <h5>🎯 componentes visuais:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">elemento</th>
                                    <th style="padding: 0.5rem; text-align: left;">classe</th>
                                    <th style="padding: 0.5rem; text-align: left;">propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Tabela responsiva</td>
                                    <td style="padding: 0.5rem;"><code>table-responsive</code></td>
                                    <td style="padding: 0.5rem;">Scroll horizontal em mobile</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Cabeçalho escuro</td>
                                    <td style="padding: 0.5rem;"><code>thead-dark</code></td>
                                    <td style="padding: 0.5rem;">Destaque visual</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Linhas listradas</td>
                                    <td style="padding: 0.5rem;"><code>table-striped</code></td>
                                    <td style="padding: 0.5rem;">Melhor legibilidade</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Título colorido</td>
                                    <td style="padding: 0.5rem;"><code>text-primary</code></td>
                                    <td style="padding: 0.5rem;">Destaque da seção</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>⚡ interatividade JavaScript</h3>
                    <div class="card">
                        <h4>🎮 controle de abas</h4>
                        <code>DOMContentLoaded event</code>
                        <p>Melhoria da experiência do usuário com transições suaves</p>

                        <h5>🔧 funcionalidades:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>transição suave:</strong> Animação entre abas</li>
                            <li><strong>controle de estado:</strong> Classe active dinâmica</li>
                            <li><strong>seleção única:</strong> Apenas uma aba ativa por vez</li>
                        </ul>

                        <h5>🎯 implementação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    document.addEventListener('DOMContentLoaded', function() {
                        const tabTriggers = [].slice.call(document.querySelectorAll('#pessoasTabs button'));
                        tabTriggers.forEach(function(tabTrigger) {
                            tabTrigger.addEventListener('click', function() {
                                // Remove classe ativa de todas as abas
                                tabTriggers.forEach(function(trigger) {
                                    trigger.classList.remove('active');
                                });
                                // Adiciona classe ativa na aba clicada
                                this.classList.add('active');
                            });
                        });
                    });
                            </code>
                    </div>

                    <h3>🔗 integração com intranet</h3>
                    <div class="card">
                        <h4>🌐 dados em tempo real</h4>
                        <code>INTRANET constante</code>
                        <p>Conexão direta com os sistemas institucionais</p>

                        <h5>🎯 características:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>atualização automática:</strong> Dados sempre atualizados</li>
                            <li><strong>transparência:</strong> Fonte dos dados claramente indicada</li>
                            <li><strong>consistência:</strong> Mesmas informações da intranet</li>
                            <li><strong>acesso direto:</strong> Links para fonte original</li>
                        </ul>

                        <h5>🔧 funções de integração:</h5>
                        <div class="grid">
                            <div class="card">
                                <h4>table_docentes()</h4>
                                <p>Busca e formata dados dos docentes</p>
                                <code>INTRANET + /docentes/siteic</code>
                            </div>
                            <div class="card">
                                <h4>table_funcionarios()</h4>
                                <p>Busca e formata dados dos funcionários</p>
                                <code>INTRANET + /funcionarios/siteic</code>
                            </div>
                        </div>
                    </div>

                    <h3>🔧 funções personalizadas</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📍 url_active()</h4>
                            <p>Detecção de contexto da URL</p>
                            <code>url_active()[1] // página atual</code>
                        </div>
                        <div class="card">
                            <h4>🎓 table_docentes()</h4>
                            <p>Listagem de docentes</p>
                            <code>table_docentes()</code>
                        </div>
                        <div class="card">
                            <h4>👨‍💼 table_funcionarios()</h4>
                            <p>Listagem de funcionários</p>
                            <code>table_funcionarios()</code>
                        </div>
                        <div class="card">
                            <h4>🌐 INTRANET</h4>
                            <p>URL base da intranet</p>
                            <code>constante INTRANET</code>
                        </div>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">Bootstrap Icons</span>
                        <span class="tech-item">JavaScript</span>
                        <span class="tech-item">PHP</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">REST API</span>
                        <span class="tech-item">Responsive Design</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>dados atualizados:</strong> Integração em tempo real com intranet</li>
                            <li><strong>organização clara:</strong> Abas separadas por categoria</li>
                            <li><strong>transparência:</strong> Fontes dos dados claramente indicadas</li>
                            <li><strong>design responsivo:</strong> Adaptável a todos dispositivos</li>
                            <li><strong>navegação intuitiva:</strong> Breadcrumbs e botão voltar</li>
                            <li><strong>acessibilidade:</strong> Atributos ARIA para leitores de tela</li>
                        </ul>
                    </div>

                    <h3>🏛️ contexto institucional</h3>
                    <div class="card">
                        <h4>👥 comunidade acadêmica</h4>
                        <p>Diretório completo da comunidade do Instituto de Computação</p>

                        <h5>🎯 propósito do sistema:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>visibilidade:</strong> Apresentação do corpo docente e técnico</li>
                            <li><strong>comunicação:</strong> Facilita contato entre membros</li>
                            <li><strong>transparência:</strong> Estrutura organizacional clara</li>
                            <li><strong>integração:</strong> Conexão com sistemas institucionais</li>
                        </ul>
                    </div>
                </div>


                <!-- ===== tab content - tema page relatoriofinanceiro ===== -->
                <div class="tab-pane fade" id="theme-page-relatoriofinanceiro" role="tabpanel"
                    aria-labelledby="theme-page-relatoriofinanceiro-tab">
                    <h2>📊 Page Relatório Financeiro do
                        Tema<span>/wp-content/themes/novoicode/page-relatoriofinanceiro.php</span></h2>
                    <p>Página de integração com Power BI para visualização de relatórios financeiros do Instituto de
                        Computação.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📈 integração power bi</h4>
                            <p>Relatórios financeiros interativos</p>
                            <code>Power BI Embedded</code>
                        </div>
                        <div class="card">
                            <h4>💰 dados financeiros</h4>
                            <p>Transparência orçamentária</p>
                            <code>iframe embedding</code>
                        </div>
                        <div class="card">
                            <h4>🎨 interface limpa</h4>
                            <p>Design focado no conteúdo</p>
                            <code>full-width iframe</code>
                        </div>
                        <div class="card">
                            <h4>🔐 acesso controlado</h4>
                            <p>Restrito a usuários autorizados</p>
                            <code>aceite verification</code>
                        </div>
                    </div>

                    <h3>🔐 controle de acesso</h3>
                    <div class="card">
                        <h4>📋 verificação de aceite</h4>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
                        echo '&lt;script&gt;window.location.href = "/perfil";&lt;/script&gt;';
                            </code>
                        <p>Redireciona para perfil se usuário não aceitou termos</p>
                    </div>

                    <h3>📊 estrutura da página</h3>
                    <div class="card">
                        <h4>🏷️ cabeçalho minimalista</h4>
                        <code>pagetitle + breadcrumb</code>
                        <p>Área superior com título e navegação, mantendo foco no relatório</p>

                        <h5>🎯 elementos do cabeçalho:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">elemento</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                    <th style="padding: 0.5rem; text-align: left;">detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Título</td>
                                    <td style="padding: 0.5rem;">Relatório Financeiro do IC</td>
                                    <td style="padding: 0.5rem;">Identificação clara do propósito</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Breadcrumb</td>
                                    <td style="padding: 0.5rem;">Home → [página_atual]</td>
                                    <td style="padding: 0.5rem;">Navegação hierárquica</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Botão Voltar</td>
                                    <td style="padding: 0.5rem;">Link para Home</td>
                                    <td style="padding: 0.5rem;">Navegação rápida</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔗 breadcrumbs dinâmicos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    echo "&lt;a href='/" . url_active()[1] . "'&gt;" . url_active()[1] . "&lt;/a&gt;";
                    echo "&lt;a href='/" . url_active()[1] . "/" . url_active()[2] . "'&gt;" . url_active()[2] . "&lt;/a&gt;";
                            </code>
                    </div>

                    <h3>📈 integração com power bi</h3>
                    <div class="card">
                        <h4>🔗 embed de relatório</h4>
                        <code>iframe Power BI</code>
                        <p>Incorporção de relatório financeiro interativo do Microsoft Power BI</p>

                        <h5>🎯 configuração do iframe:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;iframe src="https://app.powerbi.com/view?r=eyJrIjoiYzA2YmU0ODAtODY3YS00YWRiLTliMmYtYmMyOGNjYWI1YTg4IiwidCI6ImI0NzQxYTgyLTZiNmUtNDNhNS1hZDZlLTEwNDQ1MTFhYWVkNiJ9" 
                            style="border:none;height:1000px;width:100%;" 
                            title="Relatório Financeiro do IC"&gt;
                    &lt;/iframe&gt;
                            </code>

                        <h5>🔧 parâmetros do iframe:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">parâmetro</th>
                                    <th style="padding: 0.5rem; text-align: left;">valor</th>
                                    <th style="padding: 0.5rem; text-align: left;">propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">src</td>
                                    <td style="padding: 0.5rem;">URL Power BI</td>
                                    <td style="padding: 0.5rem;">Relatório específico</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">height</td>
                                    <td style="padding: 0.5rem;">1000px</td>
                                    <td style="padding: 0.5rem;">Altura fixa adequada</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">width</td>
                                    <td style="padding: 0.5rem;">100%</td>
                                    <td style="padding: 0.5rem;">Largura responsiva</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">border</td>
                                    <td style="padding: 0.5rem;">none</td>
                                    <td style="padding: 0.5rem;">Visual limpo</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">title</td>
                                    <td style="padding: 0.5rem;">Relatório Financeiro do IC</td>
                                    <td style="padding: 0.5rem;">Acessibilidade</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🎨 design e layout</h3>
                    <div class="card">
                        <h4>💎 foco no conteúdo</h4>
                        <p>Interface minimalista que prioriza a visualização do relatório</p>

                        <h5>🎯 características do design:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>layout limpo:</strong> Sem elementos desnecessários</li>
                            <li><strong>espaço dedicado:</strong> Iframe em container full-width</li>
                            <li><strong>responsividade:</strong> Adaptável a diferentes telas</li>
                            <li><strong>hierarquia visual:</strong> Cabeçalho compacto</li>
                        </ul>

                        <h5>📐 estrutura de containers:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;section class="section"&gt;
                        &lt;div class="row"&gt;
                            &lt;div class="col-lg-12"&gt;
                                &lt;div class="card"&gt;
                                    &lt;div class="card-body"&gt;
                                        &lt;!-- Iframe Power BI --&gt;
                                    &lt;/div&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                    &lt;/section&gt;
                            </code>
                    </div>

                    <h3>🔗 url do power bi</h3>
                    <div class="card">
                        <h4>🌐 configuração do embed</h4>
                        <code>Power BI View URL</code>
                        <p>URL específica para visualização pública/incorporada do relatório</p>

                        <h5>🎯 estrutura da URL:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    https://app.powerbi.com/view?r=eyJrIjoiYzA2YmU0ODAtODY3YS00YWRiLTliMmYtYmMyOGNjYWI1YTg4IiwidCI6ImI0NzQxYTgyLTZiNmUtNDNhNS1hZDZlLTEwNDQ1MTFhYWVkNiJ9
                            </code>

                        <h5>🔍 componentes da URL:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">parâmetro</th>
                                    <th style="padding: 0.5rem; text-align: left;">valor</th>
                                    <th style="padding: 0.5rem; text-align: left;">descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">r</td>
                                    <td style="padding: 0.5rem;">Token do relatório</td>
                                    <td style="padding: 0.5rem;">Identificador único do relatório</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">id</td>
                                    <td style="padding: 0.5rem;">ID do workspace</td>
                                    <td style="padding: 0.5rem;">Área de trabalho do Power BI</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>⚡ considerações de performance</h3>
                    <div class="card">
                        <h4>🚀 otimizações</h4>
                        <p>Características que garantem boa experiência do usuário</p>

                        <h5>🎯 aspectos de performance:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>carregamento assíncrono:</strong> Iframe não bloqueia página</li>
                            <li><strong>altura fixa:</strong> Evita recálculos de layout</li>
                            <li><strong>sem recursos pesados:</strong> Página leve e rápida</li>
                            <li><strong>cache do Power BI:</strong> Relatórios otimizados</li>
                        </ul>
                    </div>

                    <h3>🔧 funções personalizadas</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📍 url_active()</h4>
                            <p>Detecção de contexto da URL</p>
                            <code>url_active()[1] // página atual</code>
                        </div>
                        <div class="card">
                            <h4>🔐 get_user_meta()</h4>
                            <p>Verificação de aceite</p>
                            <code>get_user_meta($user_id, 'aceite')</code>
                        </div>
                        <div class="card">
                            <h4>🏷️ get_header()</h4>
                            <p>Cabeçalho WordPress</p>
                            <code>get_header()</code>
                        </div>
                        <div class="card">
                            <h4>🔚 get_footer()</h4>
                            <p>Rodapé WordPress</p>
                            <code>get_footer()</code>
                        </div>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Power BI</span>
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">PHP</span>
                        <span class="tech-item">WordPress</span>
                        <span class="tech-item">iframe</span>
                        <span class="tech-item">Responsive Design</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>integração seamless:</strong> Relatório incorporado sem interrupções</li>
                            <li><strong>dados em tempo real:</strong> Atualização automática via Power BI</li>
                            <li><strong>interatividade completa:</strong> Todas as funcionalidades do Power BI disponíveis
                            </li>
                            <li><strong>segurança:</strong> Acesso controlado por aceite de termos</li>
                            <li><strong>performance:</strong> Carregamento otimizado do relatório</li>
                            <li><strong>acessibilidade:</strong> Título descritivo para leitores de tela</li>
                        </ul>
                    </div>

                    <h3>🏛️ contexto institucional</h3>
                    <div class="card">
                        <h4>💰 transparência financeira</h4>
                        <p>Relatório que demonstra o compromisso com a transparência na gestão de recursos</p>

                        <h5>🎯 propósito do relatório:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>prestação de contas:</strong> Demonstração da aplicação de recursos</li>
                            <li><strong>tomada de decisão:</strong> Base para planejamento estratégico</li>
                            <li><strong>transparência:</strong> Acesso às informações financeiras</li>
                            <li><strong>conformidade:</strong> Atendimento a requisitos institucionais</li>
                        </ul>

                        <h5>📊 tipos de dados typically incluídos:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li>Orçamento x Realizado</li>
                            <li>Despesas por categoria</li>
                            <li>Receitas e fontes de recursos</li>
                            <li>Evolução temporal</li>
                            <li>Comparativos e métricas</li>
                        </ul>
                    </div>
                </div>


                <!-- ===== tab content - tema page sobre ===== -->
                <div class="tab-pane fade" id="theme-page-sobre" role="tabpanel" aria-labelledby="theme-page-sobre-tab">
                    <h2>ℹ️ Page Sobre do Tema<span>/wp-content/themes/novoicode/page-sobre.php</span></h2>
                    <p>Página informativa sobre o sistema ICODE com estatísticas de acesso, links importantes e registro de
                        auditoria para administradores.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📊 estatísticas de acesso</h4>
                            <p>Gráfico de páginas mais visitadas</p>
                            <code>ApexCharts</code>
                        </div>
                        <div class="card">
                            <h4>🔗 links importantes</h4>
                            <p>Documentação e repositório</p>
                            <code>external links</code>
                        </div>
                        <div class="card">
                            <h4>📋 registro de acessos</h4>
                            <p>Auditoria completa (admin/editor)</p>
                            <code>DataTables</code>
                        </div>
                        <div class="card">
                            <h4>🎨 dashboard informativo</h4>
                            <p>Interface organizada em cards</p>
                            <code>Bootstrap Cards</code>
                        </div>
                    </div>

                    <h3>🔐 controle de acesso</h3>
                    <div class="card">
                        <h4>📋 verificação de aceite</h4>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
                        echo '&lt;script&gt;window.location.href = "/perfil";&lt;/script&gt;';
                            </code>
                        <p>Redireciona para perfil se usuário não aceitou termos</p>

                        <h4>👥 acesso administrativo</h4>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (current_user_can('administrator') || current_user_can('editor')) {
                        // Mostra registro de acessos
                    }
                            </code>
                        <p>Seção de auditoria visível apenas para administradores e editores</p>
                    </div>

                    <h3>📊 estrutura da página</h3>
                    <div class="card">
                        <h4>🏷️ cabeçalho e navegação</h4>
                        <code>pagetitle + breadcrumb</code>
                        <p>Área superior com título, ícone e breadcrumbs dinâmicos</p>

                        <h5>🎯 elementos do cabeçalho:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">elemento</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                    <th style="padding: 0.5rem; text-align: left;">detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Título</td>
                                    <td style="padding: 0.5rem;">Sobre o ICODE</td>
                                    <td style="padding: 0.5rem;">Identificação clara</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Ícone</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-code-square"></i></td>
                                    <td style="padding: 0.5rem;">Bootstrap Icons</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Breadcrumb</td>
                                    <td style="padding: 0.5rem;">Home → [página_atual]</td>
                                    <td style="padding: 0.5rem;">Navegação hierárquica</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Botão Voltar</td>
                                    <td style="padding: 0.5rem;">Link para Home</td>
                                    <td style="padding: 0.5rem;">Navegação rápida</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔗 breadcrumbs dinâmicos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    echo "&lt;a href='/" . url_active()[1] . "'&gt;" . url_active()[1] . "&lt;/a&gt;";
                    echo "&lt;a href='/" . url_active()[1] . "/" . url_active()[2] . "'&gt;" . url_active()[2] . "&lt;/a&gt;";
                            </code>
                    </div>

                    <h3>🔗 seção de links importantes</h3>
                    <div class="card">
                        <h4>📚 recursos do sistema</h4>
                        <code>external links</code>
                        <p>Links para documentação, repositório e informações do desenvolvedor</p>

                        <h5>🎯 links disponíveis:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">link</th>
                                    <th style="padding: 0.5rem; text-align: left;">destino</th>
                                    <th style="padding: 0.5rem; text-align: left;">ícone</th>
                                    <th style="padding: 0.5rem; text-align: left;">propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Tutorial Completo</td>
                                    <td style="padding: 0.5rem;">/tutorial/</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-box-arrow-up-right"></i></td>
                                    <td style="padding: 0.5rem;">Documentação do usuário</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Projeto no GitLab</td>
                                    <td style="padding: 0.5rem;">https://gitlab.ic.unicamp.br/everton/novoicode</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-box-arrow-up-right"></i></td>
                                    <td style="padding: 0.5rem;">Código fonte</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Site do Desenvolvedor</td>
                                    <td style="padding: 0.5rem;">https://ic.unicamp.br/~everton</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-box-arrow-up-right"></i></td>
                                    <td style="padding: 0.5rem;">Contato e informações</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🎨 estrutura da lista:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;ul&gt;
                        &lt;li&gt;&amp;ensp;&lt;a href="/tutorial/" target="_blank"&gt;&lt;i class="bi bi-box-arrow-up-right"&gt;&lt;/i&gt;&amp;ensp;Tutorial Completo&lt;/a&gt;&lt;/li&gt;
                        // ... outros links
                    &lt;/ul&gt;
                            </code>
                    </div>

                    <h3>📈 sistema de estatísticas</h3>
                    <div class="card">
                        <h4>📊 gráfico de barras</h4>
                        <code>ApexCharts</code>
                        <p>Visualização interativa das páginas mais acessadas do sistema</p>

                        <h5>🎯 configuração do gráfico:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    new ApexCharts(document.querySelector("#barChart"), {
                        series: [{ data: [&lt;?php echo chart_data('count') ?&gt;] }],
                        chart: { type: 'bar', height: 350 },
                        plotOptions: {
                            bar: { borderRadius: 4, horizontal: true }
                        },
                        dataLabels: { enabled: true },
                        xaxis: { categories: [&lt;?php echo chart_data('url') ?&gt;] }
                    }).render();
                            </code>

                        <h5>🔧 características do gráfico:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">configuração</th>
                                    <th style="padding: 0.5rem; text-align: left;">valor</th>
                                    <th style="padding: 0.5rem; text-align: left;">efeito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">tipo</td>
                                    <td style="padding: 0.5rem;">bar</td>
                                    <td style="padding: 0.5rem;">Gráfico de barras</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">orientação</td>
                                    <td style="padding: 0.5rem;">horizontal</td>
                                    <td style="padding: 0.5rem;">Barras horizontais</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">altura</td>
                                    <td style="padding: 0.5rem;">350px</td>
                                    <td style="padding: 0.5rem;">Altura fixa</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">bordas</td>
                                    <td style="padding: 0.5rem;">borderRadius: 4</td>
                                    <td style="padding: 0.5rem;">Cantos arredondados</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">rótulos</td>
                                    <td style="padding: 0.5rem;">enabled: true</td>
                                    <td style="padding: 0.5rem;">Valores visíveis</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📋 registro de acessos (admin/editor)</h3>
                    <div class="card">
                        <h4>👁️ auditoria do sistema</h4>
                        <code>DataTables</code>
                        <p>Tabela interativa com histórico completo de acessos ao sistema</p>

                        <h5>🎯 configuração do DataTable:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $('#ptacessos').DataTable({
                        order: [[3, 'desc']],           // Ordena por data (decrescente)
                        dom: 'lBfrtip',                 // Layout com botões
                        buttons: [],                    // Sem botões extras
                        aLengthMenu: [[25, 50, 75, -1], [25, 50, 75, "All"]],
                        iDisplayLength: 25,             // 25 registros por página
                        language: { /* Português */ }
                    });
                            </code>

                        <h5>🗄️ estrutura da tabela:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">coluna</th>
                                    <th style="padding: 0.5rem; text-align: left;">campo</th>
                                    <th style="padding: 0.5rem; text-align: left;">detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Usuário</td>
                                    <td style="padding: 0.5rem;">user</td>
                                    <td style="padding: 0.5rem;">Login do usuário</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">IP</td>
                                    <td style="padding: 0.5rem;">ipadress</td>
                                    <td style="padding: 0.5rem;">Endereço IP</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">URL</td>
                                    <td style="padding: 0.5rem;">url</td>
                                    <td style="padding: 0.5rem;">Página acessada</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Data/Hora</td>
                                    <td style="padding: 0.5rem;">time</td>
                                    <td style="padding: 0.5rem;">Timestamp do acesso</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔍 consulta ao banco:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'acessos';
                    $sql = "SELECT * FROM $table_name ORDER BY id DESC LIMIT 500;";
                    $results = $wpdb->get_results($sql);
                            </code>
                    </div>

                    <h3>🔧 funções personalizadas</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📈 chart_data()</h4>
                            <p>Gera dados para gráficos</p>
                            <code>chart_data('count|url')</code>
                        </div>
                        <div class="card">
                            <h4>📍 url_active()</h4>
                            <p>Detecção de contexto da URL</p>
                            <code>url_active()[1] // página atual</code>
                        </div>
                        <div class="card">
                            <h4>📊 registerdb()</h4>
                            <p>Registro de acessos (implícito)</p>
                            <code>tabela acessos</code>
                        </div>
                        <div class="card">
                            <h4>👤 current_user_can()</h4>
                            <p>Verificação de permissões</p>
                            <code>administrator|editor</code>
                        </div>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">ApexCharts</span>
                        <span class="tech-item">DataTables</span>
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">Bootstrap Icons</span>
                        <span class="tech-item">jQuery</span>
                        <span class="tech-item">PHP</span>
                        <span class="tech-item">MySQL</span>
                        <span class="tech-item">WordPress</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>transparência:</strong> Links para código fonte e documentação</li>
                            <li><strong>análise de dados:</strong> Estatísticas visuais de uso</li>
                            <li><strong>auditoria completa:</strong> Registro detalhado de acessos</li>
                            <li><strong>segurança:</strong> Controle de acesso por níveis</li>
                            <li><strong>interatividade:</strong> Gráficos e tabelas dinâmicas</li>
                            <li><strong>performance:</strong> Limite de 500 registros na auditoria</li>
                        </ul>
                    </div>

                    <h3>🏛️ contexto institucional</h3>
                    <div class="card">
                        <h4>🌐 sobre o ICODE</h4>
                        <p>Sistema desenvolvido para gestão documental e colegiada do Instituto de Computação</p>

                        <h5>🎯 propósito da página:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>transparência:</strong> Informações sobre o desenvolvimento</li>
                            <li><strong>documentação:</strong> Acesso a tutoriais e código fonte</li>
                            <li><strong>monitoramento:</strong> Estatísticas de uso do sistema</li>
                            <li><strong>governança:</strong> Auditoria para administradores</li>
                        </ul>

                        <h5>🔗 ecossistema de desenvolvimento:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>GitLab IC:</strong> Versionamento e colaboração</li>
                            <li><strong>WordPress:</strong> Plataforma base</li>
                            <li><strong>Bootstrap:</strong> Framework front-end</li>
                            <li><strong>MySQL:</strong> Banco de dados</li>
                        </ul>
                    </div>
                </div>

                <!-- ===== tab content - tema page login ===== -->
                <div class="tab-pane fade" id="theme-page-login" role="tabpanel" aria-labelledby="theme-page-login-tab">
                    <h2>🔐 Page Login do Tema<span>/wp-content/themes/novoicode/page-login.php</span></h2>
                    <p>Sistema de autenticação personalizado com múltiplos métodos de login, interface moderna e proteção
                        reCAPTCHA v3.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🏫 login unicamp</h4>
                            <p>Autenticação institucional</p>
                            <code>OAuth Google</code>
                        </div>
                        <div class="card">
                            <h4>🔧 login ldap-ic</h4>
                            <p>Acesso local do IC</p>
                            <code>LDAP Integration</code>
                        </div>
                        <div class="card">
                            <h4>🤖 proteção recaptcha</h4>
                            <p>Segurança contra bots</p>
                            <code>reCAPTCHA v3</code>
                        </div>
                        <div class="card">
                            <h4>🎨 design moderno</h4>
                            <p>Interface responsiva</p>
                            <code>Gradient Background</code>
                        </div>
                    </div>

                    <h3>🎨 design e interface</h3>
                    <div class="card">
                        <h4>💫 design system</h4>
                        <code>CSS Customizado</code>
                        <p>Interface moderna com gradiente, animações e design responsivo</p>

                        <h5>🎯 características visuais:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">elemento</th>
                                    <th style="padding: 0.5rem; text-align: left;">estilo</th>
                                    <th style="padding: 0.5rem; text-align: left;">efeito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Background</td>
                                    <td style="padding: 0.5rem;">Gradient 135°</td>
                                    <td style="padding: 0.5rem;">#667eea → #764ba2</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Container</td>
                                    <td style="padding: 0.5rem;">White card + Shadow</td>
                                    <td style="padding: 0.5rem;">Elevação e contraste</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Botões</td>
                                    <td style="padding: 0.5rem;">Hover effects</td>
                                    <td style="padding: 0.5rem;">translateY + shadow</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Animações</td>
                                    <td style="padding: 0.5rem;">fadeInUp</td>
                                    <td style="padding: 0.5rem;">Transição suave</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Responsivo</td>
                                    <td style="padding: 0.5rem;">Mobile-first</td>
                                    <td style="padding: 0.5rem;">Adaptável</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🎨 paleta de cores:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    .login-page {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    }

                    .login-title {
                        color: #126EEA;  /* Azul institucional */
                    }
                            </code>
                    </div>

                    <h3>🔐 métodos de autenticação</h3>
                    <div class="card">
                        <h4>🔑 opções de login</h4>
                        <p>Múltiplos métodos de acesso para diferentes perfis de usuário</p>

                        <h5>🎯 botões de login:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">método</th>
                                    <th style="padding: 0.5rem; text-align: left;">destino</th>
                                    <th style="padding: 0.5rem; text-align: left;">público</th>
                                    <th style="padding: 0.5rem; text-align: left;">ícone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Login Unicamp</td>
                                    <td style="padding: 0.5rem;">/googlelogin</td>
                                    <td style="padding: 0.5rem;">@unicamp, @dac</td>
                                    <td style="padding: 0.5rem;"><img src="<?php echo SITEPATH; ?>assets/img/unicamp.png"
                                            style="width: 20px; height: 20px;"></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Login LDAP-IC</td>
                                    <td style="padding: 0.5rem;">Formulário local</td>
                                    <td style="padding: 0.5rem;">Usuários IC</td>
                                    <td style="padding: 0.5rem;"><img src="<?php echo get_option('portal_input_1'); ?>"
                                            style="width: 20px; height: 20px;"></td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔗 redirecionamento inteligente:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    ?redirect_to=<?php echo urlencode(isset($_GET['redirect_to']) ? $_GET['redirect_to'] : '/perfil'); ?>
                            </code>
                        <p>Mantém a página de destino original do usuário</p>
                    </div>

                    <h3>📝 formulário ldap-ic</h3>
                    <div class="card">
                        <h4>🎮 interface dinâmica</h4>
                        <code>JavaScript Toggle</code>
                        <p>Formulário que aparece/oculta com animação suave</p>

                        <h5>🎯 funcionalidades do formulário:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>toggle animado:</strong> Aparece/oculta com fadeInUp</li>
                            <li><strong>auto-focus:</strong> Foco automático no campo usuário</li>
                            <li><strong>scroll suave:</strong> Rola para o formulário quando aberto</li>
                            <li><strong>feedback visual:</strong> Botão muda de cor quando ativo</li>
                        </ul>

                        <h5>⚡ controle JavaScript:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    toggleButton.addEventListener('click', function() {
                        icVisible = !icVisible;
                        if (icVisible) {
                            icFields.classList.add('show');
                            toggleButton.style.borderColor = '#126EEA';
                            toggleButton.style.backgroundColor = '#f8f9ff';
                        }
                    });
                            </code>
                    </div>

                    <h3>🤖 sistema recaptcha v3</h3>
                    <div class="card">
                        <h4>🛡️ proteção avançada</h4>
                        <code>Google reCAPTCHA v3</code>
                        <p>Proteção invisível contra bots e ataques automatizados</p>

                        <h5>🎯 implementação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    &lt;script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_V3_SITE_KEY; ?>" async defer&gt;&lt;/script&gt;

                    &lt;input type="hidden" name="recaptcha_response" id="recaptchaResponse"&gt;

                    grecaptcha.execute('<?php echo RECAPTCHA_V3_SITE_KEY; ?>', {action: 'login'})
                        .then(function(token) {
                            document.getElementById('recaptchaResponse').value = token;
                        });
                            </code>

                        <h5>🔧 características:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>invisível:</strong> Não requer interação do usuário</li>
                            <li><strong>baseado em score:</strong> Analisa comportamento</li>
                            <li><strong>pré-carregamento:</strong> Executa quando formulário é aberto</li>
                            <li><strong>action específica:</strong> 'login' para contexto claro</li>
                        </ul>
                    </div>

                    <h3>⚡ validação e feedback</h3>
                    <div class="card">
                        <h4>🎯 experiência do usuário</h4>
                        <code>Form Validation + Loading States</code>
                        <p>Sistema completo de validação e feedback em tempo real</p>

                        <h5>🎯 estados do formulário:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">estado</th>
                                    <th style="padding: 0.5rem; text-align: left;">indicador</th>
                                    <th style="padding: 0.5rem; text-align: left;">ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Envio</td>
                                    <td style="padding: 0.5rem;">Botão desabilitado + spinner</td>
                                    <td style="padding: 0.5rem;">Previne múltiplos envios</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Validação</td>
                                    <td style="padding: 0.5rem;">Verificação de campos</td>
                                    <td style="padding: 0.5rem;">Campos obrigatórios</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Erro</td>
                                    <td style="padding: 0.5rem;">Alertas visuais</td>
                                    <td style="padding: 0.5rem;">Feedback claro</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Sucesso</td>
                                    <td style="padding: 0.5rem;">Redirecionamento</td>
                                    <td style="padding: 0.5rem;">Navegação automática</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔄 fluxo de envio:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    1. Valida campos obrigatórios
                    2. Desabilita botão + mostra loading
                    3. Executa reCAPTCHA
                    4. Adiciona token ao formulário
                    5. Submete formulário
                            </code>
                    </div>

                    <h3>🚨 tratamento de erros</h3>
                    <div class="card">
                        <h4>⚠️ mensagens de feedback</h4>
                        <code>URL Parameters + Alertas</code>
                        <p>Sistema de feedback para diferentes cenários de erro</p>

                        <h5>🎯 tipos de erro tratados:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">parâmetro</th>
                                    <th style="padding: 0.5rem; text-align: left;">mensagem</th>
                                    <th style="padding: 0.5rem; text-align: left;">ícone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">login=failed</td>
                                    <td style="padding: 0.5rem;">Erro nas credenciais</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-exclamation-triangle"></i></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">recaptcha=failed</td>
                                    <td style="padding: 0.5rem;">Falha na verificação</td>
                                    <td style="padding: 0.5rem;"><i class="bi bi-shield-exclamation"></i></td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔍 detecção de erros:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (isset($_GET['login']) && $_GET['login'] == 'failed'): 
                        // Mostra alerta de credenciais inválidas
                    endif;

                    if (isset($_GET['recaptcha']) && $_GET['recaptcha'] == 'failed'):
                        // Mostra alerta de falha no reCAPTCHA
                    endif;
                            </code>
                    </div>

                    <h3>📱 responsividade</h3>
                    <div class="card">
                        <h4>📐 design mobile-first</h4>
                        <code>Media Queries</code>
                        <p>Interface otimizada para todos os dispositivos</p>

                        <h5>🎯 breakpoints:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">dispositivo</th>
                                    <th style="padding: 0.5rem; text-align: left;">max-width</th>
                                    <th style="padding: 0.5rem; text-align: left;">ajustes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 0.5rem;">Mobile</td>
                                    <td style="padding: 0.5rem;">480px</td>
                                    <td style="padding: 0.5rem;">Padding reduzido, layout vertical</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>📱 media query:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    @media (max-width: 480px) {
                        .login-wrapper {
                            padding: 30px 20px;
                            margin: 10px;
                        }
                        .form-options {
                            flex-direction: column;
                            gap: 15px;
                        }
                    }
                            </code>
                    </div>

                    <h3>🔧 recursos carregados</h3>
                    <div class="card">
                        <h4>📦 dependências</h4>
                        <p>Bibliotecas e recursos necessários para o funcionamento da página</p>

                        <h5>🎯 assets carregados:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">recurso</th>
                                    <th style="padding: 0.5rem; text-align: left;">tipo</th>
                                    <th style="padding: 0.5rem; text-align: left;">propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Bootstrap CSS/JS</td>
                                    <td style="padding: 0.5rem;">Framework</td>
                                    <td style="padding: 0.5rem;">Componentes e responsividade</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Bootstrap Icons</td>
                                    <td style="padding: 0.5rem;">Ícones</td>
                                    <td style="padding: 0.5rem;">Elementos visuais</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">jQuery</td>
                                    <td style="padding: 0.5rem;">JavaScript</td>
                                    <td style="padding: 0.5rem;">Compatibilidade</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">reCAPTCHA v3</td>
                                    <td style="padding: 0.5rem;">Segurança</td>
                                    <td style="padding: 0.5rem;">Proteção contra bots</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">CSS Customizado</td>
                                    <td style="padding: 0.5rem;">Estilos</td>
                                    <td style="padding: 0.5rem;">Design personalizado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">Bootstrap Icons</span>
                        <span class="tech-item">jQuery</span>
                        <span class="tech-item">PHP</span>
                        <span class="tech-item">reCAPTCHA v3</span>
                        <span class="tech-item">CSS3</span>
                        <span class="tech-item">JavaScript</span>
                        <span class="tech-item">Responsive Design</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>segurança reforçada:</strong> Proteção reCAPTCHA v3 contra bots</li>
                            <li><strong>múltiplos acessos:</strong> Suporte a diferentes métodos de autenticação</li>
                            <li><strong>experiência moderna:</strong> Design com gradientes e animações</li>
                            <li><strong>interface intuitiva:</strong> Formulário dinâmico com toggle</li>
                            <li><strong>feedback claro:</strong> Mensagens de erro específicas</li>
                            <li><strong>performance otimizada:</strong> Pré-carregamento de recursos</li>
                        </ul>
                    </div>
                </div>

                <!-- ===== tab content - tema page googlelogin ===== -->
                <div class="tab-pane fade" id="theme-page-googlelogin" role="tabpanel"
                    aria-labelledby="theme-page-googlelogin-tab">
                    <h2>🔐 Page GoogleLogin do Tema<span>/wp-content/themes/novoicode/page-googlelogin.php</span></h2>
                    <p>Processador de autenticação OAuth 2.0 para login com contas Google institucionais da UNICAMP.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🔄 fluxo oauth 2.0</h4>
                            <p>Autenticação padrão Google</p>
                            <code>Authorization Code</code>
                        </div>
                        <div class="card">
                            <h4>🎓 domínios permitidos</h4>
                            <p>Restrição institucional</p>
                            <code>@unicamp.br</code>
                        </div>
                        <div class="card">
                            <h4>👤 gestão de usuários</h4>
                            <p>Criação/atualização automática</p>
                            <code>wp_create_user()</code>
                        </div>
                        <div class="card">
                            <h4>🖼️ avatar automático</h4>
                            <p>Importa foto do Google</p>
                            <code>importar_imagem_para_midia()</code>
                        </div>
                    </div>

                    <h3>🔄 fluxo oauth 2.0</h3>
                    <div class="card">
                        <h4>📋 processo de autenticação</h4>
                        <code>Google OAuth 2.0</code>
                        <p>Fluxo completo de autorização com código de acesso</p>

                        <h5>🎯 etapas do fluxo:</h5>
                        <ol style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>redirecionamento inicial:</strong> Para Google Auth sem código</li>
                            <li><strong>autorização do usuário:</strong> Tela de consentimento Google</li>
                            <li><strong>retorno com código:</strong> Callback com code parameter</li>
                            <li><strong>troca por token:</strong> Code → Access Token</li>
                            <li><strong>obtenção de dados:</strong> Userinfo com access token</li>
                            <li><strong>processamento local:</strong> Criação/autenticação usuário</li>
                        </ol>

                        <h5>🔗 urls do google:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">tipo</th>
                                    <th style="padding: 0.5rem; text-align: left;">url</th>
                                    <th style="padding: 0.5rem; text-align: left;">uso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Auth</td>
                                    <td style="padding: 0.5rem;"><code>GOOGLE_AUTH_URL</code></td>
                                    <td style="padding: 0.5rem;">Início do fluxo</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Token</td>
                                    <td style="padding: 0.5rem;"><code>GOOGLE_TOKEN_URL</code></td>
                                    <td style="padding: 0.5rem;">Troca code→token</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">UserInfo</td>
                                    <td style="padding: 0.5rem;"><code>GOOGLE_USERINFO_URL</code></td>
                                    <td style="padding: 0.5rem;">Dados do usuário</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🔐 parâmetros de autenticação</h3>
                    <div class="card">
                        <h4>⚙️ configuração oauth</h4>
                        <code>Auth Parameters</code>
                        <p>Parâmetros específicos para o fluxo de autorização</p>

                        <h5>🎯 parâmetros de inicialização:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $redirect_params = [
                        'client_id' => GOOGLE_CLIENT_ID,
                        'redirect_uri' => home_url('/googlelogin'),
                        'response_type' => 'code',
                        'scope' => 'email profile',
                        'access_type' => 'online',
                        'prompt' => 'select_account'
                    ];
                            </code>

                        <h5>🔧 explicação dos parâmetros:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">parâmetro</th>
                                    <th style="padding: 0.5rem; text-align: left;">valor</th>
                                    <th style="padding: 0.5rem; text-align: left;">propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">scope</td>
                                    <td style="padding: 0.5rem;">email profile</td>
                                    <td style="padding: 0.5rem;">Acesso a email e perfil básico</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">access_type</td>
                                    <td style="padding: 0.5rem;">online</td>
                                    <td style="padding: 0.5rem;">Token temporário</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">prompt</td>
                                    <td style="padding: 0.5rem;">select_account</td>
                                    <td style="padding: 0.5rem;">Força seleção de conta</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">response_type</td>
                                    <td style="padding: 0.5rem;">code</td>
                                    <td style="padding: 0.5rem;">Fluxo authorization code</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🔄 troca de token</h3>
                    <div class="card">
                        <h4>🎫 code → access_token</h4>
                        <code>Token Exchange</code>
                        <p>Processo de troca do código de autorização por token de acesso</p>

                        <h5>🎯 parâmetros do token:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $token_params = [
                        'code' => $_GET['code'],
                        'client_id' => GOOGLE_CLIENT_ID,
                        'client_secret' => GOOGLE_CLIENT_SECRET,
                        'redirect_uri' => home_url('/googlelogin'),
                        'grant_type' => 'authorization_code'
                    ];
                            </code>

                        <h5>📤 requisição HTTP:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $response = wp_remote_post(GOOGLE_TOKEN_URL, [
                        'headers' => [
                            'Content-Type' => 'application/x-www-form-urlencoded'
                        ],
                        'body' => http_build_query($token_params),
                        'timeout' => 30
                    ]);
                            </code>

                        <h5>🔍 validação da resposta:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>status code 200:</strong> Requisição bem-sucedida</li>
                            <li><strong>JSON válido:</strong> Estrutura de dados correta</li>
                            <li><strong>access_token presente:</strong> Token recebido com sucesso</li>
                            <li><strong>logging detalhado:</strong> Auditoria completa</li>
                        </ul>
                    </div>

                    <h3>👤 obtenção de dados do usuário</h3>
                    <div class="card">
                        <h4>📊 perfil do google</h4>
                        <code>UserInfo Endpoint</code>
                        <p>Recuperação das informações do perfil do usuário autenticado</p>

                        <h5>🎯 dados obtidos:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">campo</th>
                                    <th style="padding: 0.5rem; text-align: left;">fonte</th>
                                    <th style="padding: 0.5rem; text-align: left;">uso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">email</td>
                                    <td style="padding: 0.5rem;"><code>$userinfo['email']</code></td>
                                    <td style="padding: 0.5rem;">Identificação principal</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">given_name</td>
                                    <td style="padding: 0.5rem;"><code>$userinfo['given_name']</code></td>
                                    <td style="padding: 0.5rem;">Primeiro nome</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">family_name</td>
                                    <td style="padding: 0.5rem;"><code>$userinfo['family_name']</code></td>
                                    <td style="padding: 0.5rem;">Sobrenome</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">picture</td>
                                    <td style="padding: 0.5rem;"><code>$userinfo['picture']</code></td>
                                    <td style="padding: 0.5rem;">Avatar/foto</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔐 requisição autenticada:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $userinfo_response = wp_remote_get(GOOGLE_USERINFO_URL, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $token_data['access_token'],
                            'Content-Type' => 'application/json'
                        ],
                        'timeout' => 30
                    ]);
                            </code>
                    </div>

                    <h3>🎓 controle de domínios</h3>
                    <div class="card">
                        <h4>🏫 restrição institucional</h4>
                        <code>Domain Validation</code>
                        <p>Verificação de domínios permitidos e exceções</p>

                        <h5>🎯 domínios permitidos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $dominio = substr(strrchr($email, "@"), 1);
                    $emails_excecao = get_option('portal_input_3', []);

                    if ($dominio !== 'unicamp.br' && $dominio !== 'dac.unicamp.br' && !in_array($email, (array) $emails_excecao)) {
                        wp_die('Acesso negado. Somente e-mails @unicamp.br, @dac.unicamp.br ou convidados.');
                    }
                            </code>

                        <h5>🔧 configuração de exceções:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>portal_input_3:</strong> Lista de emails exceção</li>
                            <li><strong>array casting:</strong> Garante tipo correto</li>
                            <li><strong>case insensitive:</strong> Email convertido para minúsculas</li>
                            <li><strong>domínio explícito:</strong> Verificação específica</li>
                        </ul>
                    </div>

                    <h3>👥 gestão de usuários</h3>
                    <div class="card">
                        <h4>🔄 criação/atualização</h4>
                        <code>User Management</code>
                        <p>Sistema automático de criação e atualização de usuários WordPress</p>

                        <h5>🎯 fluxo do usuário:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $user = get_user_by('email', $email);

                    if (!$user) {
                        // Criar novo usuário
                        $user_id = wp_create_user($username, wp_generate_password(), $email);
                        // Atualizar informações
                        wp_update_user([...]);
                    } else {
                        // Usuário existente - apenas log
                        error_log('Usuário Google existente: ' . $username);
                    }
                            </code>

                        <h5>🔧 processamento de username:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $username = preg_replace('/@.*/', '', $email); // Remove domínio do email
                            </code>
                        <p>Exemplo: <code>usuario@unicamp.br</code> → <code>usuario</code></p>
                    </div>

                    <h3>🖼️ sistema de avatar</h3>
                    <div class="card">
                        <h4>📸 importação de foto</h4>
                        <code>Avatar Import</code>
                        <p>Importação automática da foto de perfil do Google</p>

                        <h5>🎯 processo de importação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (!empty($userinfo['picture'])) {
                        $avatar_id = importar_imagem_para_midia($userinfo['picture'], $user->ID);
                        if ($avatar_id) {
                            update_user_meta($user->ID, 'wp_user_avatar', $avatar_id);
                        }
                    }
                            </code>

                        <h5>🔧 função personalizada:</h5>
                        <p><code>importar_imagem_para_midia()</code> - Função que baixa e importa a imagem para a Media
                            Library do WordPress</p>
                    </div>

                    <h3>🔐 sistema de permissões</h3>
                    <div class="card">
                        <h4>🎯 atribuição de papéis</h4>
                        <code>Role Assignment</code>
                        <p>Atribuição automática de papéis baseada no email do usuário</p>

                        <h5>🎯 funções utilizadas:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                    <th style="padding: 0.5rem; text-align: left;">propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;"><code>papel_usuario($email)</code></td>
                                    <td style="padding: 0.5rem;">Determina role baseado no email</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;"><code>atualizar_permissoes_usuario()</code></td>
                                    <td style="padding: 0.5rem;">Atualiza permissões específicas</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🚫 restrição de admin:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if ($username === 'admin') {
                        wp_die('Login de admin não permitido via Google');
                    }
                            </code>
                    </div>

                    <h3>🔄 autenticação wordpress</h3>
                    <div class="card">
                        <h4>🔓 login automático</h4>
                        <code>WP Authentication</code>
                        <p>Processo completo de autenticação no WordPress</p>

                        <h5>🎯 sequência de autenticação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    wp_set_current_user($user->ID);
                    wp_set_auth_cookie($user->ID);
                    do_action('wp_login', $user->user_login, $user);
                            </code>

                        <h5>🎯 redirecionamento:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $redirect_to = home_url('/perfil');
                    // Limpa sessão de redirecionamento
                    unset($_SESSION['ldap_login_redirect']);
                    wp_redirect($redirect_to);
                            </code>
                    </div>

                    <h3>🚨 tratamento de erros</h3>
                    <div class="card">
                        <h4>⚠️ sistema robusto</h4>
                        <code>Error Handling</code>
                        <p>Tratamento completo de exceções com logging detalhado</p>

                        <h5>🎯 tipos de erro tratados:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>erros de rede:</strong> <code>wp_remote_* failures</code></li>
                            <li><strong>respostas HTTP:</strong> Status codes diferentes de 200</li>
                            <li><strong>JSON inválido:</strong> <code>json_last_error()</code></li>
                            <li><strong>dados faltantes:</strong> Email não disponível</li>
                            <li><strong>domínio negado:</strong> Restrição institucional</li>
                            <li><strong>criação de usuário:</strong> <code>wp_create_user() failures</code></li>
                        </ul>

                        <h5>📝 logging detalhado:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    error_log('Resposta do Google Token - Código: ' . $response_code);
                    error_log('Resposta do Google Token - Body: ' . $response_body);
                    error_log('Login Google bem-sucedido para: ' . $email);
                            </code>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">OAuth 2.0</span>
                        <span class="tech-item">Google API</span>
                        <span class="tech-item">PHP cURL</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">JSON</span>
                        <span class="tech-item">Session Management</span>
                        <span class="tech-item">Error Handling</span>
                        <span class="tech-item">User Management</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>segurança robusta:</strong> Fluxo OAuth 2.0 padrão</li>
                            <li><strong>controle institucional:</strong> Restrição por domínio</li>
                            <li><strong>experiência seamless:</strong> Criação automática de usuários</li>
                            <li><strong>personalização:</strong> Avatar importado do Google</li>
                            <li><strong>auditoria completa:</strong> Logging detalhado</li>
                            <li><strong>tratamento de erros:</strong> Sistema robusto com try/catch</li>
                            <li><strong>integração nativa:</strong> Usa funções WordPress padrão</li>
                        </ul>
                    </div>
                </div>

                <!-- ===== tab content - tema page novo ===== -->
                <div class="tab-pane fade" id="theme-page-novo" role="tabpanel" aria-labelledby="theme-page-novo-tab">
                    <h2>📝 Page Novo do Tema<span>/wp-content/themes/novoicode/page-novo.php</span></h2>
                    <p>Interface de criação e edição de reuniões institucionais com controle de permissões e formulário
                        avançado.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🔐 controle de acesso</h4>
                            <p>Restrição por papéis de usuário</p>
                            <code>administrator, editor</code>
                        </div>
                        <div class="card">
                            <h4>📋 formulário dinâmico</h4>
                            <p>Criação de posts customizados</p>
                            <code>CKEditor integration</code>
                        </div>
                        <div class="card">
                            <h4>🔒 sistema de privacidade</h4>
                            <p>Toggle visual para posts privados</p>
                            <code>privado toggle</code>
                        </div>
                        <div class="card">
                            <h4>🔗 slugs automáticos</h4>
                            <p>Geração automática de URLs</p>
                            <code>slug generation</code>
                        </div>
                    </div>

                    <h3>🔐 sistema de permissões</h3>
                    <div class="card">
                        <h4>🎯 controle de acesso</h4>
                        <code>Role-Based Access</code>
                        <p>Verificação rigorosa de papéis de usuário para acesso à página</p>

                        <h5>🎯 papéis permitidos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $allowed_roles = ['administrator', 'editor'];
                    if (!array_intersect($allowed_roles, $current_user->roles)) {
                        wp_redirect('/404');
                        exit;
                    }
                            </code>

                        <h5>🔧 verificação adicional:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
                        echo '&lt;script&gt;window.location.href = "/perfil";&lt;/script&gt;';
                            </code>

                        <h5>📊 auditoria de acesso:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    registerdb($current_user->user_login, $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI']);
                            </code>
                    </div>

                    <h3>📋 estrutura do formulário</h3>
                    <div class="card">
                        <h4>🏗️ layout responsivo</h4>
                        <code>Bootstrap Grid</code>
                        <p>Interface organizada em grid responsivo com múltiplas seções</p>

                        <h5>🎯 estrutura de colunas:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">coluna</th>
                                    <th style="padding: 0.5rem; text-align: left;">largura</th>
                                    <th style="padding: 0.5rem; text-align: left;">conteúdo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Principal</td>
                                    <td style="padding: 0.5rem;">col-lg-8</td>
                                    <td style="padding: 0.5rem;">Título do Post</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Data</td>
                                    <td style="padding: 0.5rem;">col-lg-3</td>
                                    <td style="padding: 0.5rem;">Data da Reunião</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Privado</td>
                                    <td style="padding: 0.5rem;">col-lg-1</td>
                                    <td style="padding: 0.5rem;">Toggle de Privacidade</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔗 campos ocultos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <input type="hidden" name="action" value="editar_post">
                    <input type="hidden" name="id" value="<?php echo $novoid; ?>">
                    <input type="hidden" name="tipo" value="<?php echo esc_attr($tipo); ?>">
                    <input type="hidden" name="cat" value="<?php echo esc_attr($cat); ?>">
                            </code>
                    </div>

                    <h3>🔒 sistema de privacidade</h3>
                    <div class="card">
                        <h4>👁️ toggle visual</h4>
                        <code>Privacy Toggle</code>
                        <p>Interface intuitiva para controle de visibilidade do post</p>

                        <h5>🎯 implementação CSS:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    .privado-toggle {
                        display: block;
                        margin-top: -10px;
                        font-size: 2.1rem;
                        cursor: pointer;
                        user-select: none;
                        transition: color 0.3s;
                    }
                    .privado-toggle.locked { color: #c00; }
                    .privado-toggle.unlocked { color: #000; }
                            </code>

                        <h5>🔧 lógica JavaScript:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    icon.addEventListener('click', function () {
                        checkbox.checked = !checkbox.checked;
                        icon.classList.remove('bi-lock-fill', 'bi-unlock-fill', 'locked', 'unlocked');
                        if (checkbox.checked) {
                            icon.classList.add('bi-lock-fill', 'locked');
                        } else {
                            icon.classList.add('bi-unlock-fill', 'unlocked');
                        }
                    });
                            </code>

                        <h5>🎨 estados visuais:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>🔓 desbloqueado:</strong> Ícone cinza - Post público</li>
                            <li><strong>🔒 bloqueado:</strong> Ícone vermelho - Post privado</li>
                            <li><strong>🔄 toggle:</strong> Clique alterna entre estados</li>
                        </ul>
                    </div>

                    <h3>📝 editores avançados</h3>
                    <div class="card">
                        <h4>🛠️ integração CKEditor</h4>
                        <code>WYSIWYG Editors</code>
                        <p>Dois editores ricos com configurações específicas para diferentes tipos de conteúdo</p>

                        <h5>🎯 editor de membros:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    CKEDITOR.replace('membro', {
                        contentsCss: '/wp-content/themes/novoicode/assets/css/style.css',
                        bodyClass: 'conteudo-editor',
                        extraPlugins: 'autogrow',
                        autoGrow_maxHeight: Infinity,
                        removePlugins: 'resize',
                        toolbar: [ ['Bold', 'Italic', '-', 'Undo', 'Redo'] ]
                    });
                            </code>

                        <h5>🎯 editor de conteúdo:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    CKEDITOR.replace('conteudo', {
                        contentsCss: '/wp-content/themes/novoicode/assets/css/style.css',
                        bodyClass: 'conteudo-editor',
                        extraPlugins: 'justify,autogrow',
                        autoGrow_maxHeight: Infinity,
                        removePlugins: 'resize',
                        toolbar: [
                            { name: 'insert', items: ['InserirPDF', 'CorrigirLinks'] },
                            { name: 'links', items: ['Link', 'Unlink'] },
                            { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo'] },
                            // ... mais itens da toolbar
                        ]
                    });
                            </code>

                        <h5>🔌 plugins customizados:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>InserirPDF:</strong> Inserção de documentos PDF</li>
                            <li><strong>CorrigirLinks:</strong> Correção automática de links</li>
                            <li><strong>AutoGrow:</strong> Expansão automática da altura</li>
                        </ul>
                    </div>

                    <h3>🔗 sistema de slugs</h3>
                    <div class="card">
                        <h4>🔄 geração automática</h4>
                        <code>Slug Generation</code>
                        <p>Sistema inteligente para criação de URLs amigáveis baseadas no título</p>

                        <h5>🎯 função de normalização:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    function gerarSlug(texto) {
                        return texto
                            .toLowerCase()
                            .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                            .replace(/[^a-z0-9\s-]/g, '')
                            .trim()
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-');
                    }
                            </code>

                        <h5>🎯 triggers automáticos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    // Gera slug quando campo título perde foco
                    titulo.addEventListener('blur', sugerirSlug);

                    // Gera slug quando campo slug ganha foco (se vazio)
                    slug.addEventListener('focus', sugerirSlug);
                            </code>

                        <h5>🔧 processamento do slug:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>minúsculas:</strong> Converte todo texto para minúsculas</li>
                            <li><strong>sem acentos:</strong> Remove caracteres acentuados</li>
                            <li><strong>caracteres válidos:</strong> Mantém apenas letras, números, hífens</li>
                            <li><strong>espaços para hífens:</strong> Substitui espaços por hífens</li>
                            <li><strong>hífens únicos:</strong> Remove hífens consecutivos</li>
                        </ul>
                    </div>

                    <h3>📊 integração com API</h3>
                    <div class="card">
                        <h4>🔗 dados dinâmicos</h4>
                        <code>ICAPI Integration</code>
                        <p>Carregamento automático de membros através da API interna</p>

                        <h5>🎯 shortcode de membros:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $value_member = do_shortcode('[icapi tipo="composicao_' . $tipo . '" saida="html/?modo=short"]');
                            </code>

                        <h5>🎯 estrutura da URL:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <?php echo esc_url(home_url('/')) . $tipo . '/' . $cat . '/'; ?>
                            </code>

                        <h5>🔧 parâmetros dinâmicos:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">parâmetro</th>
                                    <th style="padding: 0.5rem; text-align: left;">fonte</th>
                                    <th style="padding: 0.5rem; text-align: left;">uso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">tipo</td>
                                    <td style="padding: 0.5rem;"><code>$_GET['tipo']</code></td>
                                    <td style="padding: 0.5rem;">Tipo de reunião</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">cat</td>
                                    <td style="padding: 0.5rem;"><code>$_GET['cat']</code></td>
                                    <td style="padding: 0.5rem;">Categoria</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">novoid</td>
                                    <td style="padding: 0.5rem;"><code>$_GET['novoid']</code></td>
                                    <td style="padding: 0.5rem;">ID do novo post</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🎯 fluxo de processamento</h3>
                    <div class="card">
                        <h4>🔄 sequência de operações</h4>
                        <code>Processing Flow</code>
                        <p>Fluxo completo desde o acesso até o salvamento do post</p>

                        <h5>🎯 etapas do processo:</h5>
                        <ol style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>verificação de aceite:</strong> Confirma aceitação dos termos</li>
                            <li><strong>validação de permissões:</strong> Verifica papéis do usuário</li>
                            <li><strong>registro de acesso:</strong> Log no banco de dados</li>
                            <li><strong>carregamento de parâmetros:</strong> Tipo, categoria, ID</li>
                            <li><strong>renderização do formulário:</strong> Interface com dados</li>
                            <li><strong>processamento do submit:</strong> Action: editar_post</li>
                            <li><strong>redirecionamento:</strong> Retorno para lista</li>
                        </ol>

                        <h5>🔗 action do formulário:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
                            </code>

                        <h5>📤 dados submetidos:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>titulo:</strong> Título da reunião</li>
                            <li><strong>data:</strong> Data e hora da reunião</li>
                            <li><strong>slug:</strong> URL amigável</li>
                            <li><strong>member:</strong> Lista de membros (HTML)</li>
                            <li><strong>conteudo:</strong> Conteúdo principal (HTML)</li>
                            <li><strong>privado:</strong> Status de visibilidade</li>
                        </ul>
                    </div>

                    <h3>🎨 interface do usuário</h3>
                    <div class="card">
                        <h4>💡 elementos visuais</h4>
                        <code>User Interface</code>
                        <p>Componentes e recursos visuais para melhor experiência do usuário</p>

                        <h5>🎯 breadcrumb navigation:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Criar Post</li>
                    </ol>
                            </code>

                        <h5>🎯 botões de ação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <div class="btn-editors">
                        <a class="btn btn-light" href="/<?php echo $tipo . '/' . $cat ?>">
                            <i class="bi bi-skip-backward-fill"></i>&ensp;Voltar
                        </a>&emsp;
                    </div>
                            </code>

                        <h5>🎯 feedback visual:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-floppy"></i>&emsp;Salvar&emsp;
                    </button>
                            </code>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">PHP</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">CKEditor 4</span>
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">JavaScript</span>
                        <span class="tech-item">REST API</span>
                        <span class="tech-item">Role Management</span>
                        <span class="tech-item">Form Validation</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>segurança robusta:</strong> Múltiplas camadas de verificação</li>
                            <li><strong>interface intuitiva:</strong> Design limpo e funcional</li>
                            <li><strong>editores avançados:</strong> CKEditor com plugins customizados</li>
                            <li><strong>responsividade:</strong> Layout adaptável a diferentes dispositivos</li>
                            <li><strong>acessibilidade:</strong> Ícones e labels descritivos</li>
                            <li><strong>performance:</strong> Carregamento otimizado de recursos</li>
                            <li><strong>auditoria:</strong> Registro completo de acessos</li>
                        </ul>
                    </div>
                </div>

                <!-- ===== tab content - tema page editar ===== -->
                <div class="tab-pane fade" id="theme-page-editar" role="tabpanel" aria-labelledby="theme-page-editar-tab">
                    <h2>✏️ Page Editar do Tema<span>/wp-content/themes/novoicode/page-editar.php</span></h2>
                    <p>Interface avançada de edição de reuniões institucionais com gerenciamento de anexos e correção
                        automática de links.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🔐 controle de acesso</h4>
                            <p>Validação de permissões por papel</p>
                            <code>administrator, editor</code>
                        </div>
                        <div class="card">
                            <h4>📋 edição completa</h4>
                            <p>Formulário com dados pré-carregados</p>
                            <code>post metadata</code>
                        </div>
                        <div class="card">
                            <h4>📎 gerenciador de anexos</h4>
                            <p>Integração com sistema de arquivos</p>
                            <code>iframe integration</code>
                        </div>
                        <div class="card">
                            <h4>🔗 correção de links</h4>
                            <p>Sistema automático de atualização</p>
                            <code>CKEditor plugin</code>
                        </div>
                    </div>

                    <h3>🔐 sistema de segurança</h3>
                    <div class="card">
                        <h4>🎯 validação de acesso</h4>
                        <code>Multi-Layer Security</code>
                        <p>Múltiplas camadas de verificação antes do acesso à edição</p>

                        <h5>🎯 verificações sequenciais:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    // 1. Verificação de aceite de termos
                    if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
                        echo '&lt;script&gt;window.location.href = "/perfil";&lt;/script&gt;';

                    // 2. Validação de papéis permitidos
                    $allowed_roles = ['administrator', 'editor'];
                    if (!array_intersect($allowed_roles, $current_user->roles)) {
                        wp_redirect('/404');
                        exit;
                    }

                    // 3. Registro de auditoria
                    registerdb($current_user->user_login, $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI']);

                    // 4. Validação do ID do post
                    if (!isset($_GET['id'])) {
                        echo '<div class="alert alert-danger">ID não especificado.</div>';
                        get_footer();
                        exit;
                    }
                            </code>

                        <h5>🔧 recuperação do post:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $post = get_post(intval($_GET['id']));
                    if (!$post) {
                        echo '<div class="alert alert-danger">Post não encontrado.</div>';
                        get_footer();
                        exit;
                    }
                            </code>
                    </div>

                    <h3>📋 estrutura de dados</h3>
                    <div class="card">
                        <h4>🏗️ metadados do post</h4>
                        <code>Post Metadata</code>
                        <p>Recuperação e organização dos dados específicos do tipo de post</p>

                        <h5>🎯 informações básicas:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $tipo = get_post_type($post->ID);
                    $cat = get_the_category($post->ID)[0]->name;
                    $base_dir = ABSPATH . "wp-content/uploads/$tipo/$cat/{$post->ID}";
                            </code>

                        <h5>🔍 escaneamento de arquivos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $arquivos = [];
                    $urls = [];

                    if (file_exists($base_dir)) {
                        $iterator = new RecursiveIteratorIterator(
                            new RecursiveDirectoryIterator($base_dir, RecursiveDirectoryIterator::SKIP_DOTS)
                        );

                        foreach ($iterator as $arquivo) {
                            if (pathinfo($arquivo, PATHINFO_EXTENSION) === 'pdf') {
                                $arquivos[] = (string) $arquivo;
                                $subpath = str_replace(ABSPATH, '', (string) $arquivo);
                                $url_pdf = '/' . str_replace('\\', '/', $subpath);
                                $urls[] = esc_url($url_pdf);
                            }
                        }
                    }
                            </code>

                        <h5>📊 campos do formulário:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">campo</th>
                                    <th style="padding: 0.5rem; text-align: left;">fonte</th>
                                    <th style="padding: 0.5rem; text-align: left;">uso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">titulo</td>
                                    <td style="padding: 0.5rem;"><code>$post->post_title</code></td>
                                    <td style="padding: 0.5rem;">Título principal</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">data</td>
                                    <td style="padding: 0.5rem;"><code>get_post_meta($post->ID, $tipo . '_date')</code></td>
                                    <td style="padding: 0.5rem;">Data da reunião</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">slug</td>
                                    <td style="padding: 0.5rem;"><code>$post->post_name</code></td>
                                    <td style="padding: 0.5rem;">URL amigável</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">membros</td>
                                    <td style="padding: 0.5rem;"><code>get_post_meta($post->ID, $tipo . '_member')</code>
                                    </td>
                                    <td style="padding: 0.5rem;">Lista de participantes</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🎨 interface do usuário</h3>
                    <div class="card">
                        <h4>💡 elementos de navegação</h4>
                        <code>User Interface</code>
                        <p>Componentes visuais para melhor experiência de edição</p>

                        <h5>🎯 breadcrumb e botões:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <div class="btn-editors">
                        <a class="btn btn-light" href="/<?php echo $tipo . '/' . $cat ?>">
                            <i class="bi bi-skip-backward-fill"></i>&ensp;Voltar
                        </a>&emsp;
                        <a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-secondary">
                            <i class="bi bi-eye"></i>&ensp;Ver Post
                        </a>
                    </div>
                            </code>

                        <h5>🔒 toggle de privacidade:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <div class="box-privado mb-3">
                        <label class="form-label"><strong>Privado</strong></label>
                        <?php $value = get_post_meta($post->ID, $tipo . '_privado', true); ?>
                        <input type="checkbox" id="privado" name="<?php echo $tipo; ?>_privado" value="1" 
                            <?php checked($value, '1'); ?> />
                        <i id="togglePrivado" class="privado-toggle bi 
                    <?php echo $value == '1' ? 'bi-lock-fill locked' : 'bi-unlock-fill unlocked'; ?>"
                            title="Post Privado">
                        </i>
                    </div>
                            </code>

                        <h5>🎯 estados visuais:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>🔓 desbloqueado:</strong> Ícone preto - Post público</li>
                            <li><strong>🔒 bloqueado:</strong> Ícone vermelho - Post privado</li>
                            <li><strong>🔄 interativo:</strong> Clique alterna estados</li>
                        </ul>
                    </div>

                    <h3>📎 gerenciador de anexos</h3>
                    <div class="card">
                        <h4>🖼️ integração iframe</h4>
                        <code>File Manager</code>
                        <p>Sistema embutido para gerenciamento de arquivos PDF</p>

                        <h5>🎯 condição de exibição:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (is_dir($base_dir)) { 
                        // Exibir gerenciador de anexos
                    }
                            </code>

                        <h5>🔧 iframe de arquivos:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <iframe src="/arquivos?tipo=<?php echo $tipo; ?>&ano=<?php echo $cat; ?>&post_id=<?php echo $post->ID; ?>"
                        style="width: 100%; height: 600px; border: none;"></iframe>
                            </code>

                        <h5>🎯 modais de suporte:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>modalArquivos:</strong> Seleção de PDFs para inserção</li>
                            <li><strong>modalCorrecao:</strong> Feedback da correção de links</li>
                            <li><strong>responsivos:</strong> Design adaptável a diferentes telas</li>
                        </ul>
                    </div>

                    <h3>🔌 plugins CKEditor customizados</h3>
                    <div class="card">
                        <h4>🛠️ extensões personalizadas</h4>
                        <code>Custom Plugins</code>
                        <p>Dois plugins desenvolvidos especificamente para o sistema</p>

                        <h5>🎯 plugin InserirPDF:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    CKEDITOR.plugins.add('inserirpdf', {
                        init: function(editor) {
                            editor.addCommand('abrirModalPDF', {
                                exec: function(editor) {
                                    // Abre modal para seleção de PDF
                                    // Insere link com detecção de privacidade
                                }
                            });
                            editor.ui.addButton('InserirPDF', {
                                label: 'Inserir PDF no Post',
                                command: 'abrirModalPDF',
                                toolbar: 'insert'
                            });
                        }
                    });
                            </code>

                        <h5>🎯 plugin CorrigirLinks:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    CKEDITOR.plugins.add('corrigirlinks', {
                        init: function(editor) {
                            editor.addCommand('corrigirLinksArquivos', {
                                exec: function(editor) {
                                    // Envia conteúdo para correção via AJAX
                                    // Atualiza editor com links corrigidos
                                }
                            });
                        }
                    });
                            </code>

                        <h5>🔧 configuração do editor:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    CKEDITOR.replace('conteudo', {
                        extraPlugins: 'inserirpdf,corrigirlinks,justify,autogrow',
                        toolbar: [
                            { name: 'insert', items: ['InserirPDF', 'CorrigirLinks'] },
                            // ... demais itens
                        ]
                    });
                            </code>
                    </div>

                    <h3>🔄 sistema de correção de links</h3>
                    <div class="card">
                        <h4>🔗 atualização automática</h4>
                        <code>Link Correction</code>
                        <p>Processo AJAX para correção em massa de links de arquivos</p>

                        <h5>🎯 fluxo AJAX:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    fetch('/wp-admin/admin-ajax.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && typeof data.changes !== 'undefined') {
                            editor.setData(data.content); // Atualiza editor
                            // Mostra feedback no modal
                        }
                    });
                            </code>

                        <h5>📤 dados da requisição:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    const formData = new URLSearchParams();
                    formData.append('action', 'corrigir_links_arquivos');
                    formData.append('post_id', postId);
                    formData.append('tipo', tipo);
                    formData.append('ano', ano);
                    formData.append('conteudo', content);
                            </code>

                        <h5>🎯 tipos de feedback:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>✅ sucesso:</strong> Links corrigidos com contagem</li>
                            <li><strong>ℹ️ informação:</strong> Nenhuma alteração necessária</li>
                            <li><strong>❌ erro:</strong> Falha no processamento</li>
                        </ul>
                    </div>

                    <h3>📋 gestão de membros</h3>
                    <div class="card">
                        <h4>👥 carregamento inteligente</h4>
                        <code>Member Management</code>
                        <p>Sistema que prioriza dados existentes com fallback para API</p>

                        <h5>🎯 lógica de carregamento:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (get_post_meta($post->ID, $tipo . '_member', true) == "") {
                        $value_member = do_shortcode('[icapi tipo="composicao_' . $tipo . '" saida="html/?modo=short"]');
                    } else {
                        $value_member = get_post_meta($post->ID, $tipo . '_member', true);
                    }
                    $membros = apply_filters('the_content', $value_member);
                            </code>

                        <h5>🔧 processamento de conteúdo:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>prioridade:</strong> Metadados existentes primeiro</li>
                            <li><strong>fallback:</strong> Shortcode da API se vazio</li>
                            <li><strong>filtros:</strong> Aplicação de filtros WordPress</li>
                            <li><strong>segurança:</strong> Escape apropriado para output</li>
                        </ul>
                    </div>

                    <h3>📊 sistema de revisões</h3>
                    <div class="card">
                        <h4>🕒 histórico de alterações</h4>
                        <code>Revision System</code>
                        <p>Integração com sistema nativo de revisões do WordPress</p>

                        <h5>🎯 recuperação de revisões:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $revisions = wp_get_post_revisions($post->ID);

                    if (!empty($revisions)) {
                        echo '<ul>';
                        foreach ($revisions as $revision) {
                            $autor = get_the_author_meta('display_name', $revision->post_author);
                            $data = get_the_date('d/m/Y H:i', $revision);
                            echo '<li><strong>' . esc_html($autor) . '</strong> em ' . esc_html($data) . '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p>Nenhuma revisão disponível.</p>';
                    }
                            </code>

                        <h5>🔍 informações exibidas:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">dado</th>
                                    <th style="padding: 0.5rem; text-align: left;">fonte</th>
                                    <th style="padding: 0.5rem; text-align: left;">formato</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Autor</td>
                                    <td style="padding: 0.5rem;"><code>get_the_author_meta()</code></td>
                                    <td style="padding: 0.5rem;">Nome de exibição</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Data</td>
                                    <td style="padding: 0.5rem;"><code>get_the_date()</code></td>
                                    <td style="padding: 0.5rem;">d/m/Y H:i</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">PHP</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">CKEditor 4</span>
                        <span class="tech-item">JavaScript</span>
                        <span class="tech-item">AJAX</span>
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">RecursiveIterator</span>
                        <span class="tech-item">REST API</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>segurança robusta:</strong> Múltiplas camadas de verificação</li>
                            <li><strong>interface intuitiva:</strong> Design limpo com feedback visual</li>
                            <li><strong>plugins customizados:</strong> CKEditor extendido com funcionalidades específicas
                            </li>
                            <li><strong>correção automática:</strong> Sistema inteligente de atualização de links</li>
                            <li><strong>gestão de arquivos:</strong> Integração completa com sistema de anexos</li>
                            <li><strong>auditoria completa:</strong> Histórico de revisões e registro de acessos</li>
                            <li><strong>performance:</strong> Carregamento otimizado e processamento assíncrono</li>
                        </ul>
                    </div>
                </div>

                <!-- ===== tab content - tema page share ===== -->
                <div class="tab-pane fade" id="theme-page-share" role="tabpanel" aria-labelledby="theme-page-share-tab">
                    <h2>📤 Page Share do Tema<span>/wp-content/themes/novoicode/page-share.php</span></h2>
                    <p>Sistema de compartilhamento e envio de convocações de reuniões por e-mail com validação avançada de
                        URLs.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📧 envio de e-mails</h4>
                            <p>Sistema de convocação automática</p>
                            <code>AJAX Form Submission</code>
                        </div>
                        <div class="card">
                            <h4>🔗 validação de URLs</h4>
                            <p>Verificação rigorosa de links</p>
                            <code>URL Validation</code>
                        </div>
                        <div class="card">
                            <h4>👁️ preview em tempo real</h4>
                            <p>Visualização instantânea do e-mail</p>
                            <code>Live Preview</code>
                        </div>
                        <div class="card">
                            <h4>📋 conteúdo dinâmico</h4>
                            <p>Dados automáticos da reunião</p>
                            <code>Post Metadata</code>
                        </div>
                    </div>

                    <h3>📋 estrutura de dados</h3>
                    <div class="card">
                        <h4>🏗️ informações da reunião</h4>
                        <code>Post Data Retrieval</code>
                        <p>Recuperação e formatação dos dados específicos da reunião</p>

                        <h5>🎯 dados recuperados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $post = get_post($_GET['post_id']);
                    $post_type = get_post_type($post);
                    $category = get_the_category($post->ID)[0]->name ?? '';
                    $data_iso = get_post_meta($post->ID, $post_type . '_date', true);
                    $data = DateTime::createFromFormat('Y-m-d\TH:i', $data_iso);
                    $formatada = $data ? $data->format('d/m/Y, H:i') : '';
                    $current_user = wp_get_current_user();
                    $email = $current_user->user_email;
                            </code>

                        <h5>🔧 processamento de dados:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">dado</th>
                                    <th style="padding: 0.5rem; text-align: left;">fonte</th>
                                    <th style="padding: 0.5rem; text-align: left;">formato</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Título</td>
                                    <td style="padding: 0.5rem;"><code>$post->post_title</code></td>
                                    <td style="padding: 0.5rem;">Texto original</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Data</td>
                                    <td style="padding: 0.5rem;"><code>post_type_date meta</code></td>
                                    <td style="padding: 0.5rem;">d/m/Y, H:i</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">E-mail usuário</td>
                                    <td style="padding: 0.5rem;"><code>wp_get_current_user()</code></td>
                                    <td style="padding: 0.5rem;">user_email</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">URL permanente</td>
                                    <td style="padding: 0.5rem;"><code>get_permalink()</code></td>
                                    <td style="padding: 0.5rem;">URL completa</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📧 formulário de envio</h3>
                    <div class="card">
                        <h4>🔄 estrutura do formulário</h4>
                        <code>Email Form</code>
                        <p>Formulário completo com campos pré-preenchidos e validações</p>

                        <h5>🎯 campos do formulário:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <form id="form-envio-email">
                        <input type="hidden" name="action" value="enviar_email_convocacao">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr($post->ID); ?>">
                
                        <!-- Remetente (readonly) -->
                        <input type="text" value="<?php echo esc_attr($email); ?>" name="remetente" readonly>
                
                        <!-- Destinatários -->
                        <input type="text" id="email" name="email" required 
                            value="staff@ic.unicamp.br,admic@ic.unicamp.br">
                
                        <!-- Assunto -->
                        <input type="text" id="title" name="title" required 
                            value="<?php echo esc_attr($post->post_title); ?>">
                
                        <!-- Link da reunião -->
                        <input type="text" id="link" name="link" required placeholder="https://...">
                
                        <!-- Descrição (hidden) -->
                        <textarea id="descricao" name="descricao" style="display: none;"></textarea>
                    </form>
                            </code>

                        <h5>🔧 características dos campos:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>remetente:</strong> E-mail do usuário atual (somente leitura)</li>
                            <li><strong>destinatários:</strong> Lista de e-mails separados por vírgula</li>
                            <li><strong>assunto:</strong> Pré-preenchido com título da reunião</li>
                            <li><strong>link:</strong> Campo obrigatório com validação rigorosa</li>
                            <li><strong>descrição:</strong> Campo hidden com conteúdo formatado</li>
                        </ul>
                    </div>

                    <h3>🔗 sistema de validação de URLs</h3>
                    <div class="card">
                        <h4>🛡️ validação rigorosa</h4>
                        <code>URL Validation</code>
                        <p>Sistema completo de validação com feedback visual em tempo real</p>

                        <h5>🎯 função de validação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    function validarURL(url) {
                        url = url.trim();
                
                        // Verificação básica de protocolo
                        if (!url.startsWith('http://') && !url.startsWith('https://')) {
                            return { url: url, valida: false };
                        }
                
                        // Expressão regular para validação
                        const padraoURL = /^(https?:\/\/)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(:\d+)?(\/[^\s]*)?$/;
                
                        if (!padraoURL.test(url)) {
                            return { url: url, valida: false };
                        }
                
                        // Validação específica para IPs
                        const semProtocolo = url.replace(/^https?:\/\//, '');
                        if (/^\d+\.\d+\.\d+\.\d+$/.test(semProtocolo.split('/')[0])) {
                            const partesIP = semProtocolo.split('/')[0].split('.');
                            if (partesIP.length !== 4) return { url: url, valida: false };
                            for (let parte of partesIP) {
                                const num = parseInt(parte);
                                if (isNaN(num) || num < 0 || num > 255) {
                                    return { url: url, valida: false };
                                }
                            }
                        }
                
                        return { url: url, valida: true };
                    }
                            </code>

                        <h5>🎯 estados de validação:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">estado</th>
                                    <th style="padding: 0.5rem; text-align: left;">cor</th>
                                    <th style="padding: 0.5rem; text-align: left;">mensagem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Vazio</td>
                                    <td style="padding: 0.5rem; color: #ffc107;">⚠️</td>
                                    <td style="padding: 0.5rem;">"Digite o link da reunião"</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Válido</td>
                                    <td style="padding: 0.5rem; color: #28a745;">✅</td>
                                    <td style="padding: 0.5rem;">"✓ URL válida"</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Inválido</td>
                                    <td style="padding: 0.5rem; color: #dc3545;">❌</td>
                                    <td style="padding: 0.5rem;">"URL inválida - deve começar com http:// ou https://"</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>👁️ sistema de preview</h3>
                    <div class="card">
                        <h4>🔄 atualização em tempo real</h4>
                        <code>Live Preview</code>
                        <p>Visualização instantânea do conteúdo do e-mail com formatação HTML</p>

                        <h5>🎯 função de atualização:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    function atualizarPreview() {
                        const link = linkInput.value.trim();
                        const urlValidada = validarURL(link);
                
                        let linkHtml;
                        if (!link) {
                            linkHtml = '[Link não informado]';
                        } else if (urlValidada.valida) {
                            linkHtml = `<a href="${urlValidada.url}" target="_blank">${urlValidada.url}</a>`;
                        } else {
                            linkHtml = `<span style="color: red; font-weight: bold;">${link}</span>`;
                        }
                
                        const conteudoPreview = `
                            <h3>De ordem, convocamos os Membros... ${postTitle}</h3>
                            <ul>
                                <li>Link para a Reunião: ${linkHtml}</li>
                                <li>Data: ${formatada}</li>
                                <li>URL da Reunião: <a href="${permalink}">${permalink}</a></li>
                            </ul>
                        `;
                
                        previewDescricao.innerHTML = conteudoPreview;
                    }
                            </code>

                        <h5>🔧 elementos do preview:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>cabeçalho:</strong> Texto padrão de convocação</li>
                            <li><strong>link da reunião:</strong> Dinâmico com validação visual</li>
                            <li><strong>data formatada:</strong> No formato brasileiro</li>
                            <li><strong>URL permanente:</strong> Link para a página da reunião</li>
                            <li><strong>membros:</strong> Lista de participantes da reunião</li>
                            <li><strong>conteúdo:</strong> Corpo principal da reunião</li>
                        </ul>
                    </div>

                    <h3>🔄 processamento AJAX</h3>
                    <div class="card">
                        <h4>📤 envio assíncrono</h4>
                        <code>AJAX Submission</code>
                        <p>Sistema de envio com feedback visual e tratamento de erros</p>

                        <h5>🎯 fluxo de envio:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                
                        // Validação final
                        const link = linkInput.value.trim();
                        const urlValidada = validarURL(link);
                
                        if (!link) {
                            alert('Por favor, digite o link da reunião');
                            return;
                        }
                
                        if (!urlValidada.valida) {
                            const confirmar = confirm('A URL está inválida. Deseja enviar mesmo assim?');
                            if (!confirmar) return;
                        }

                        // Atualizar UI
                        btn.disabled = true;
                        btn.innerText = 'Enviando...';

                        // Envio AJAX
                        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                            method: 'POST',
                            body: new FormData(this)
                        })
                        .then(res => res.text())
                        .then(data => {
                            document.getElementById('resposta').innerHTML = data;
                            btn.disabled = false;
                            btn.innerText = 'Enviar';
                        })
                        .catch(err => {
                            // Tratamento de erro
                        });
                    });
                            </code>

                        <h5>🎯 estados do botão:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">estado</th>
                                    <th style="padding: 0.5rem; text-align: left;">texto</th>
                                    <th style="padding: 0.5rem; text-align: left;">status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Normal</td>
                                    <td style="padding: 0.5rem;">"Enviar"</td>
                                    <td style="padding: 0.5rem;">Ativo</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Processando</td>
                                    <td style="padding: 0.5rem;">"Enviando..."</td>
                                    <td style="padding: 0.5rem;">Desativado</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Concluído</td>
                                    <td style="padding: 0.5rem;">"Enviar"</td>
                                    <td style="padding: 0.5rem;">Reativado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📊 conteúdo dinâmico</h3>
                    <div class="card">
                        <h4>🎨 seções do e-mail</h4>
                        <code>Dynamic Content</code>
                        <p>Três seções principais com conteúdo gerado automaticamente</p>

                        <h5>🎯 seção de preview:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <div id="preview-descricao" style="min-height: 200px; border: 1px solid #ddd; padding: 15px; background: #f9f9f9;">
                        <!-- Conteúdo atualizado via JavaScript -->
                    </div>
                            </code>

                        <h5>🎯 seção de membros:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <div class="card-body">
                        <?php echo apply_filters('the_content', get_post_meta($post->ID, $post_type . '_member', true)); ?>
                    </div>
                            </code>

                        <h5>🎯 seção de conteúdo:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    <div class="card-body">
                        <?php echo apply_filters('the_content', $post->post_content); ?>
                    </div>
                            </code>

                        <h5>🔧 características:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>filtros WordPress:</strong> <code>apply_filters('the_content')</code></li>
                            <li><strong>metadados:</strong> Uso de campos personalizados</li>
                            <li><strong>formatação:</strong> Manutenção de estilos CSS</li>
                            <li><strong>segurança:</strong> Escape apropriado de dados</li>
                        </ul>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">PHP</span>
                        <span class="tech-item">JavaScript</span>
                        <span class="tech-item">AJAX</span>
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">Form Validation</span>
                        <span class="tech-item">Regular Expressions</span>
                        <span class="tech-item">HTML5</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>validação robusta:</strong> Sistema completo de verificação de URLs</li>
                            <li><strong>feedback visual:</strong> Estados claros e mensagens informativas</li>
                            <li><strong>preview em tempo real:</strong> Visualização instantânea do conteúdo</li>
                            <li><strong>interface intuitiva:</strong> Design limpo com Bootstrap 5</li>
                            <li><strong>conteúdo dinâmico:</strong> Dados automáticos da reunião</li>
                            <li><strong>tratamento de erros:</strong> Confirmações para URLs inválidas</li>
                            <li><strong>performance:</strong> Processamento assíncrono sem reload</li>
                            <li><strong>acessibilidade:</strong> Labels claros e feedback auditivo</li>
                        </ul>
                    </div>
                </div>

                <!-- ===== tab content - tema page arquivos ===== -->
                <div class="tab-pane fade" id="theme-page-arquivos" role="tabpanel"
                    aria-labelledby="theme-page-arquivos-tab">
                    <h2>📁 Page Arquivos do Tema<span>/wp-content/themes/novoicode/page-arquivos.php</span></h2>
                    <p>Gerenciador de arquivos avançado com elFinder, conversão de documentos, junção de PDFs e sistema de
                        indexação integrado.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>📁 gerenciador de arquivos</h4>
                            <p>Interface completa elFinder</p>
                            <code>elfinder</code>
                        </div>
                        <div class="card">
                            <h4>🔄 conversão de documentos</h4>
                            <p>Word para PDF automático</p>
                            <code>doc2pdf</code>
                        </div>
                        <div class="card">
                            <h4>📄 junção de PDFs</h4>
                            <p>Merge de múltiplos documentos</p>
                            <code>exportarpdf</code>
                        </div>
                        <div class="card">
                            <h4>🔍 indexação de conteúdo</h4>
                            <p>OCR e busca em PDFs</p>
                            <code>indexarpdf</code>
                        </div>
                    </div>

                    <h3>🔐 sistema de controle de acesso</h3>
                    <div class="card">
                        <h4>👥 permissões por função</h4>
                        <code>roles + capabilities</code>
                        <p>Controle granular baseado em papéis do WordPress</p>

                        <h5>🎯 níveis de acesso:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                    <th style="padding: 0.5rem; text-align: left;">permissões</th>
                                    <th style="padding: 0.5rem; text-align: left;">comandos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Administrador</td>
                                    <td style="padding: 0.5rem;">Acesso total</td>
                                    <td style="padding: 0.5rem;">Todos os comandos</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Editor</td>
                                    <td style="padding: 0.5rem;">Upload/Download</td>
                                    <td style="padding: 0.5rem;">Sem criar pastas</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Assinante</td>
                                    <td style="padding: 0.5rem;">Somente leitura</td>
                                    <td style="padding: 0.5rem;">Apenas visualização</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔧 detecção de função:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $user = wp_get_current_user();
                    $roles = $user->roles;
                    $is_admin = in_array('administrator', $roles);
                    $is_editor = in_array('editor', $roles);
                    $is_subscriber = in_array('subscriber', $roles);
                            </code>
                    </div>

                    <h3>🎮 modos de operação</h3>
                    <div class="card">
                        <h4>📋 configuração dinâmica</h4>
                        <code>modo + parâmetros URL</code>
                        <p>Interface adaptável baseada no contexto</p>

                        <h5>🎯 parâmetros de URL:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">parâmetro</th>
                                    <th style="padding: 0.5rem; text-align: left;">tipo</th>
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">tipo</td>
                                    <td style="padding: 0.5rem;">String</td>
                                    <td style="padding: 0.5rem;">Tipo de conteúdo (ex: consuni, cong)</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">ano</td>
                                    <td style="padding: 0.5rem;">Number</td>
                                    <td style="padding: 0.5rem;">Ano de referência</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">post_id</td>
                                    <td style="padding: 0.5rem;">Number/String</td>
                                    <td style="padding: 0.5rem;">ID do post ou "outros"</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">modo</td>
                                    <td style="padding: 0.5rem;">String</td>
                                    <td style="padding: 0.5rem;">"selecionar" para modo restrito</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🌐 modo seleção:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (modo === 'selecionar') {
                        // Interface restrita para seleção de PDFs
                        options.getFileCallback = function(file) {
                            if (file && file.mime === 'application/pdf') {
                                window.parent.postMessage({name: file.name, url: file.url}, '*');
                            }
                        };
                    }
                            </code>
                    </div>

                    <h3>🔄 sistema de conversão de documentos</h3>
                    <div class="card">
                        <h4>📝 word para pdf</h4>
                        <code>doc2pdf command</code>
                        <p>Conversão automática de documentos Word para PDF</p>

                        <h5>🎯 implementação:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    elFinder.prototype.commands.doc2pdf = function() {
                        this.title = 'Converter Word para PDF';
                        this.alwaysEnabled = false;
                        this.updateOnSelect = true;
                
                        this.getstate = function() {
                            // Verifica se há arquivos Word selecionados
                            const selected = this.fm.selectedFiles();
                            const temWord = selected.some(file =>
                                file.name.toLowerCase().endsWith('.doc') || 
                                file.name.toLowerCase().endsWith('.docx')
                            );
                            return temWord ? 0 : -1;
                        };
                    };
                            </code>

                        <h5>📊 fluxo de conversão:</h5>
                        <ol style="list-style-position: inside; margin-top: 0.5rem;">
                            <li>Valida seleção de arquivos Word</li>
                            <li>Envia para backend via AJAX</li>
                            <li>Processa conversão com LibreOffice</li>
                            <li>Salva no diretório /privado</li>
                            <li>Feedback visual com progresso</li>
                        </ol>
                    </div>

                    <h3>📄 sistema de junção de PDFs</h3>
                    <div class="card">
                        <h4>🧩 merge de documentos</h4>
                        <code>exportarpdf command</code>
                        <p>Combina múltiplos PDFs em um único documento</p>

                        <h5>🎯 características:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>seleção múltipla:</strong> Combina vários PDFs de uma vez</li>
                            <li><strong>ordenação:</strong> Mantém ordem de seleção</li>
                            <li><strong>destino inteligente:</strong> Salva em /privado com nome baseado no permalink</li>
                            <li><strong>download automático:</strong> Link para baixar resultado</li>
                        </ul>

                        <h5>🔧 geração de nome de arquivo:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    const destino = (postId === 'outros') 
                        ? `${diretorios}/privado/documento.pdf` 
                        : `${diretorios}/privado/${permalink}.pdf`;
                            </code>
                    </div>

                    <h3>🔍 sistema de indexação de PDFs</h3>
                    <div class="card">
                        <h4>📚 extração de texto</h4>
                        <code>indexarpdf command</code>
                        <p>Indexa conteúdo de PDFs para busca futura</p>

                        <h5>🎯 processo de indexação:</h5>
                        <ol style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>seleção:</strong> PDFs escolhidos pelo usuário</li>
                            <li><strong>extração:</strong> OCR/texto via PDF Parser</li>
                            <li><strong>armazenamento:</strong> Banco de dados MySQL</li>
                            <li><strong>metadados:</strong> Tipo, ano, post_id, caminho</li>
                            <li><strong>busca:</strong> Disponível no sistema de pesquisa</li>
                        </ol>

                        <h5>📊 feedback em tempo real:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    concluido++;
                    const progresso = Math.floor((concluido / total) * 100);
                    barra.style.width = `${progresso}%`;
                    barra.innerText = `${progresso}%`;
                            </code>
                    </div>

                    <h3>🎨 interface e modais</h3>
                    <div class="card">
                        <h4>🪟 sistema de modais</h4>
                        <code>Bootstrap Modals</code>
                        <p>Interface moderna para operações assíncronas</p>

                        <h5>🎯 modais disponíveis:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">modal</th>
                                    <th style="padding: 0.5rem; text-align: left;">id</th>
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Conversão</td>
                                    <td style="padding: 0.5rem;"><code>modalConvert</code></td>
                                    <td style="padding: 0.5rem;">Word para PDF</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Exportação</td>
                                    <td style="padding: 0.5rem;"><code>modalExport</code></td>
                                    <td style="padding: 0.5rem;">Junção de PDFs</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Indexação</td>
                                    <td style="padding: 0.5rem;"><code>modalIndex</code></td>
                                    <td style="padding: 0.5rem;">OCR e indexação</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🎨 estilos personalizados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    .modal-header {
                        background: #116CE5;
                        color: #fff;
                    }

                    .btn-close {
                        background: #222;
                        color: #fff;
                        padding: 10px 12px 17px 12px !important;
                        opacity: 1;
                    }
                            </code>
                    </div>

                    <h3>⚡ integração com backend</h3>
                    <div class="card">
                        <h4>🔗 chamadas AJAX</h4>
                        <code>admin-ajax.php</code>
                        <p>Comunicação assíncrona com o WordPress</p>

                        <h5>🎯 ações disponíveis:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">ação</th>
                                    <th style="padding: 0.5rem; text-align: left;">endpoint</th>
                                    <th style="padding: 0.5rem; text-align: left;">função</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">novoicode_converter_pdf</td>
                                    <td style="padding: 0.5rem;">Word → PDF</td>
                                    <td style="padding: 0.5rem;">Conversão de documentos</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">novoicode_exportar_pdf</td>
                                    <td style="padding: 0.5rem;">Merge PDFs</td>
                                    <td style="padding: 0.5rem;">Junção de documentos</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">novoicode_indexar_pdf</td>
                                    <td style="padding: 0.5rem;">OCR PDF</td>
                                    <td style="padding: 0.5rem;">Indexação de conteúdo</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>📤 estrutura de dados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({
                            action: 'novoicode_converter_pdf',
                            paths: JSON.stringify(paths),
                            destino: destino
                        })
                    })
                            </code>
                    </div>

                    <h3>🔧 comandos personalizados elFinder</h3>
                    <div class="card">
                        <h4>🎮 extensibilidade</h4>
                        <code>elFinder.prototype.commands</code>
                        <p>Sistema de comandos customizados para funcionalidades específicas</p>

                        <h5>🎯 estrutura de comando:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    elFinder.prototype.commands.novoComando = function() {
                        this.title = 'Título do Comando';
                        this.alwaysEnabled = false;
                        this.updateOnSelect = true;
                
                        this.getstate = function() {
                            // Lógica de habilitação/desabilitação
                            return condicao ? 0 : -1;
                        };
                
                        this.exec = function() {
                            // Ação executada ao clicar
                            return $.Deferred().resolve();
                        };
                    };
                            </code>

                        <h5>🌐 internacionalização:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    elFinder.prototype.i18.pt_BR.messages['cmdnovoComando'] = 'Texto em Português';
                            </code>
                    </div>

                    <h3>🎯 tecnologias e integrações</h3>
                    <div class="tech-stack">
                        <span class="tech-item">elFinder</span>
                        <span class="tech-item">Bootstrap 5</span>
                        <span class="tech-item">jQuery</span>
                        <span class="tech-item">jQuery UI</span>
                        <span class="tech-item">PHP</span>
                        <span class="tech-item">AJAX</span>
                        <span class="tech-item">PDF Parser</span>
                        <span class="tech-item">LibreOffice</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>interface familiar:</strong> Experiência similar ao Windows Explorer</li>
                            <strong>processamento em lote:</strong> Múltiplas operações simultâneas</li>
                            <li><strong>feedback visual:</strong> Barras de progresso em tempo real</li>
                            <li><strong>segurança:</strong> Controle de acesso baseado em papéis</li>
                            <li><strong>performance:</strong> Operações assíncronas não-bloqueantes</li>
                            <li><strong>usabilidade:</strong> Comandos contextuais inteligentes</li>
                        </ul>
                    </div>
                </div>

                <!-- ===== tab content - tema page chatgemini ===== -->
                <div class="tab-pane fade" id="theme-page-chatgemini" role="tabpanel"
                    aria-labelledby="theme-page-chatgemini-tab">
                    <h2>🤖 Page ChatGemini do Tema<span>/wp-content/themes/novoicode/page-chatgemini.php</span></h2>
                    <p>Sistema de inteligência artificial integrado com Google Gemini para consultas contextuais sobre
                        documentos e posts institucionais.</p>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🧠 IA contextual</h4>
                            <p>Gemini com dados institucionais</p>
                            <code>Google Gemini API</code>
                        </div>
                        <div class="card">
                            <h4>📚 busca integrada</h4>
                            <p>Posts WordPress + PDFs indexados</p>
                            <code>Hybrid Search</code>
                        </div>
                        <div class="card">
                            <h4>🔐 controle de acesso</h4>
                            <p>Baseado em permissões de usuário</p>
                            <code>Role-Based Data</code>
                        </div>
                        <div class="card">
                            <h4>📎 rastreabilidade</h4>
                            <p>Fontes identificadas nas respostas</p>
                            <code>Source Attribution</code>
                        </div>
                    </div>

                    <h3>🔐 segurança e validação</h3>
                    <div class="card">
                        <h4>🛡️ validação de entrada</h4>
                        <code>Input Validation</code>
                        <p>Sistema robusto de validação e sanitização de dados de entrada</p>

                        <h5>🎯 verificações iniciais:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    header('Content-Type: application/json');

                    // Verificação do método HTTP
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        echo json_encode(['error' => 'Método não permitido']);
                        exit;
                    }

                    // Validação da estrutura JSON
                    $input = json_decode(file_get_contents('php://input'), true);
                    if (!isset($input['messages']) || !is_array($input['messages']) || empty($input['messages'])) {
                        echo json_encode(['error' => 'Parâmetro "messages" ausente, inválido ou vazio']);
                        exit;
                    }

                    // Validação da última mensagem
                    $last_message = end($input['messages']);
                    if (!isset($last_message['content'])) {
                        echo json_encode(['error' => 'A última mensagem não possui o campo "content"']);
                        exit;
                    }
                            </code>

                        <h5>🔧 sanitização de dados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $pergunta = sanitize_text_field($last_message['content']);
                            </code>

                        <h5>🎯 tipos de erro tratados:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>método HTTP:</strong> Apenas POST permitido</li>
                            <li><strong>estrutura JSON:</strong> Validação de campos obrigatórios</li>
                            <li><strong>array messages:</strong> Verificação de existência e conteúdo</li>
                            <li><strong>campo content:</strong> Presença na última mensagem</li>
                        </ul>
                    </div>

                    <h3>🔍 sistema de busca</h3>
                    <div class="card">
                        <h4>📊 busca híbrida</h4>
                        <code>Hybrid Search System</code>
                        <p>Busca simultânea em posts WordPress e PDFs indexados com controle de acesso</p>

                        <h5>🎯 configuração de busca:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $array_membros = get_user_meta(wp_get_current_user()->ID, 'membro', true);
                    $max_content_length = 4000;
                            </code>

                        <h5>🔍 busca em posts WordPress:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $post_results = get_posts([
                        'post_type' => $array_membros,
                        'posts_per_page' => 50,
                        's' => $pergunta
                    ]);

                    $post_content = '';
                    $post_fontes = [];
                    foreach ($post_results as $post) {
                        $post_content .= "\nTítulo: {$post->post_title}\n";
                        $post_content .= strip_tags($post->post_content) . "\n";
                        $post_fontes[] = [
                            'tipo' => 'post',
                            'titulo' => $post->post_title,
                            'url' => get_permalink($post->ID)
                        ];
                        if (strlen($post_content) > $max_content_length / 2)
                            break;
                    }
                            </code>

                        <h5>📄 busca em PDFs indexados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (!empty($array_membros)) {
                        $placeholders = implode(',', array_fill(0, count($array_membros), '%s'));
                        $query = "
                            SELECT id, arquivo, url, texto 
                            FROM {$wpdb->prefix}pdf_index 
                            WHERE texto LIKE %s AND tipo IN ($placeholders)
                            LIMIT 10
                        ";
                        $params = array_merge(['%' . $wpdb->esc_like($pergunta) . '%'], $array_membros);
                        $pdf_rows = $wpdb->get_results($wpdb->prepare($query, ...$params));
                    }
                            </code>
                    </div>

                    <h3>🧠 integração com Gemini</h3>
                    <div class="card">
                        <h4>🔗 API Google Gemini</h4>
                        <code>Gemini AI Integration</code>
                        <p>Integração completa com Google Gemini 2.0 Flash para processamento de linguagem natural</p>

                        <h5>🎯 configuração do contexto:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $contexto = "Você é um assistente virtual do ICODE, com acesso a conteúdos internos...";
                    $out_of_context_response = "ICODE - IC.";

                    $contexto_completo = $contexto . "\n\nConteúdo relevante encontrado no sistema:\n\n" . 
                                        $post_content . $pdf_content;
                            </code>

                        <h5>🔧 payload da API:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $payload = [
                        'contents' => [
                            [
                                'role' => 'user',
                                'parts' => [
                                    [
                                        'text' => $contexto_completo .
                                            "\n\nCom base nesse conteúdo, responda a seguinte pergunta: " . $pergunta .
                                            "\nSe a pergunta não estiver relacionada à empresa IC ou aos dados acima, diga: \"$out_of_context_response\""
                                    ]
                                ]
                            ]
                        ]
                    ];
                            </code>

                        <h5>🌐 requisição cURL:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $api_url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
                    $api_key = 'AIzaSyBXhVigywfKp2J9u-B26cYJ7QPDNzmI1Ew';

                    $ch = curl_init("$api_url?key=$api_key");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

                    $response = curl_exec($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                            </code>
                    </div>

                    <h3>📊 gestão de fontes</h3>
                    <div class="card">
                        <h4>🔗 rastreabilidade</h4>
                        <code>Source Management</code>
                        <p>Sistema completo de identificação e atribuição de fontes para transparência</p>

                        <h5>🎯 estrutura de fontes:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    // Fontes de posts
                    $post_fontes[] = [
                        'tipo' => 'post',
                        'titulo' => $post->post_title,
                        'url' => get_permalink($post->ID)
                    ];

                    // Fontes de PDFs
                    $pdf_fontes[] = [
                        'tipo' => 'pdf',
                        'nome' => $nome_arquivo,
                        'url' => $row->url
                    ];
                            </code>

                        <h5>📤 resposta com fontes:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    echo json_encode([
                        'candidates' => [
                            [
                                'content' => [
                                    'parts' => [
                                        [
                                            'text' => $data['candidates'][0]['content']['parts'][0]['text'],
                                            'fontes' => [
                                                'posts' => $post_fontes,
                                                'pdfs' => $pdf_fontes
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]);
                            </code>

                        <h5>🎯 tipos de fonte suportados:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">tipo</th>
                                    <th style="padding: 0.5rem; text-align: left;">dados</th>
                                    <th style="padding: 0.5rem; text-align: left;">uso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">post</td>
                                    <td style="padding: 0.5rem;">título, URL</td>
                                    <td style="padding: 0.5rem;">Posts WordPress</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">pdf</td>
                                    <td style="padding: 0.5rem;">nome, URL</td>
                                    <td style="padding: 0.5rem;">Documentos indexados</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>⚙️ otimização de performance</h3>
                    <div class="card">
                        <h4>🚀 controle de conteúdo</h4>
                        <code>Performance Optimization</code>
                        <p>Mecanismos para garantir eficiência e evitar sobrecarga da API</p>

                        <h5>🎯 limites de conteúdo:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $max_content_length = 4000;

                    // Limitação de posts
                    if (strlen($post_content) > $max_content_length / 2)
                        break;

                    // Limitação de PDFs  
                    if (strlen($pdf_content) > $max_content_length / 2)
                        break;

                    // Limitação final do contexto
                    if (strlen($contexto_completo) > $max_content_length) {
                        $contexto_completo = mb_substr($contexto_completo, 0, $max_content_length) . "...";
                    }
                            </code>

                        <h5>🔧 parâmetros de busca:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">recurso</th>
                                    <th style="padding: 0.5rem; text-align: left;">limite</th>
                                    <th style="padding: 0.5rem; text-align: left;">propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Posts</td>
                                    <td style="padding: 0.5rem;">50 resultados</td>
                                    <td style="padding: 0.5rem;">Evitar sobrecarga do DB</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">PDFs</td>
                                    <td style="padding: 0.5rem;">10 resultados</td>
                                    <td style="padding: 0.5rem;">Otimização de busca</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Contexto</td>
                                    <td style="padding: 0.5rem;">4000 caracteres</td>
                                    <td style="padding: 0.5rem;">Limite da API Gemini</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>🚨 tratamento de erros</h3>
                    <div class="card">
                        <h4>⚠️ sistema robusto</h4>
                        <code>Error Handling</code>
                        <p>Tratamento completo de exceções em todos os estágios do processo</p>

                        <h5>🎯 validação de resposta da API:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if ($http_code >= 400) {
                        echo json_encode([
                            'error' => 'Erro na API Gemini', 
                            'http_code' => $http_code, 
                            'api_response' => json_decode($response, true)
                        ]);
                    } else {
                        $data = json_decode($response, true);
                        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                            // Resposta bem-sucedida com fontes
                        } else {
                            echo json_encode([
                                'error' => 'Resposta inesperada da API Gemini', 
                                'api_response' => $data
                            ]);
                        }
                    }
                            </code>

                        <h5>🔧 tipos de erro tratados:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>erros HTTP:</strong> Códigos de status >= 400</li>
                            <li><strong>resposta inesperada:</strong> Estrutura JSON inválida</li>
                            <li><strong>campos faltantes:</strong> Texto de resposta não encontrado</li>
                            <li><strong>timeout:</strong> Configuração de timeout no cURL</li>
                        </ul>
                    </div>

                    <h3>🔐 controle de acesso</h3>
                    <div class="card">
                        <h4>🎯 permissões baseadas em usuário</h4>
                        <code>Access Control</code>
                        <p>Sistema que limita o acesso aos dados baseado nas permissões do usuário</p>

                        <h5>🎯 metadados do usuário:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    $array_membros = get_user_meta(wp_get_current_user()->ID, 'membro', true);
                            </code>

                        <h5>🔧 filtro por tipo de post:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    'post_type' => $array_membros
                            </code>

                        <h5>🔧 filtro de PDFs:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    WHERE texto LIKE %s AND tipo IN ($placeholders)
                            </code>

                        <h5>🎯 benefícios do sistema:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>segurança:</strong> Usuários só acessam dados permitidos</li>
                            <li><strong>relevância:</strong> Busca limitada aos contextos apropriados</li>
                            <li><strong>performance:</strong> Redução do escopo de busca</li>
                            <li><strong>privacidade:</strong> Proteção de informações sensíveis</li>
                        </ul>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">Google Gemini API</span>
                        <span class="tech-item">PHP cURL</span>
                        <span class="tech-item">WordPress Hooks</span>
                        <span class="tech-item">MySQL</span>
                        <span class="tech-item">JSON</span>
                        <span class="tech-item">REST API</span>
                        <span class="tech-item">Natural Language Processing</span>
                        <span class="tech-item">Search Algorithms</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>IA contextual:</strong> Gemini treinado com dados institucionais</li>
                            <li><strong>busca híbrida:</strong> Posts + PDFs em uma única consulta</li>
                            <li><strong>controle de acesso:</strong> Dados filtrados por permissões</li>
                            <li><strong>rastreabilidade:</strong> Fontes identificadas para transparência</li>
                            <li><strong>performance:</strong> Otimização de limites e conteúdo</li>
                            <li><strong>segurança:</strong> Validação rigorosa em todas as etapas</li>
                            <li><strong>tratamento de erros:</strong> Sistema robusto com feedback detalhado</li>
                            <li><strong>escalabilidade:</strong> Preparado para grandes volumes de dados</li>
                        </ul>
                    </div>
                </div>

                <!-- ===== tab content - tema component chats ===== -->
                <div class="tab-pane fade" id="theme-component-chats" role="tabpanel"
                    aria-labelledby="theme-component-chats-tab">
                    <h2>💬 Component Chats do Tema<span>/wp-content/themes/novoicode/assets/js/componentChats.js</span></h2>
                    <p>Componente React para interface de chat com múltiplos provedores de IA (Gemini e IC), renderização
                        Markdown e sistema de fontes.</p>
                    <small>Obs.: Chat IC está temporariamente desativado.</small>

                    <h3>🎯 funcionalidades principais</h3>
                    <div class="grid">
                        <div class="card">
                            <h4>🤖 múltiplas IAs</h4>
                            <p>Gemini e Chat-IC integrados</p>
                            <code>AI Provider Switch</code>
                        </div>
                        <div class="card">
                            <h4>📝 markdown</h4>
                            <p>Renderização de conteúdo rico</p>
                            <code>ReactMarkdown</code>
                        </div>
                        <div class="card">
                            <h4>📚 sistema de fontes</h4>
                            <p>Rastreabilidade de informações</p>
                            <code>Source Attribution</code>
                        </div>
                        <div class="card">
                            <h4>⌨️ atalhos</h4>
                            <p>Teclado otimizado</p>
                            <code>Keyboard Shortcuts</code>
                        </div>
                    </div>

                    <h3>⚛️ arquitetura react</h3>
                    <div class="card">
                        <h4>🏗️ estrutura de componentes</h4>
                        <code>React Component Architecture</code>
                        <p>Sistema modular com componentes funcionais e hooks modernos</p>

                        <h5>🎯 hooks utilizados:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    const { useState, useEffect, useRef } = React;
                            </code>

                        <h5>🔧 componentes principais:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    // Componente de renderização Markdown
                    function MarkdownRenderer({ content }) { ... }

                    // Componente principal do chat
                    function ChatGPTSearch() { ... }
                            </code>

                        <h5>🎯 estados gerenciados:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">estado</th>
                                    <th style="padding: 0.5rem; text-align: left;">tipo</th>
                                    <th style="padding: 0.5rem; text-align: left;">propósito</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">query</td>
                                    <td style="padding: 0.5rem;">string</td>
                                    <td style="padding: 0.5rem;">Texto da pergunta atual</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">messages</td>
                                    <td style="padding: 0.5rem;">array</td>
                                    <td style="padding: 0.5rem;">Histórico de mensagens</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">conversationHistory</td>
                                    <td style="padding: 0.5rem;">array</td>
                                    <td style="padding: 0.5rem;">Histórico completo (Chat-IC)</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">isLoading</td>
                                    <td style="padding: 0.5rem;">boolean</td>
                                    <td style="padding: 0.5rem;">Estado de carregamento</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">selectedAI</td>
                                    <td style="padding: 0.5rem;">string</td>
                                    <td style="padding: 0.5rem;">Provedor de IA selecionado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>📝 sistema de renderização</h3>
                    <div class="card">
                        <h4>🎨 markdown renderer</h4>
                        <code>Markdown Rendering</code>
                        <p>Componente especializado para renderização de conteúdo Markdown com suporte a links</p>

                        <h5>🎯 implementação do renderizador:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    function MarkdownRenderer({ content }) {
                        const ReactMarkdown = window.ReactMarkdown;
                        if (ReactMarkdown) {
                            return React.createElement(ReactMarkdown, {
                                components: {
                                    a: (props) => {
                                        return React.createElement('a', {
                                            ...props,
                                            target: '_blank',
                                            rel: 'noopener noreferrer'
                                        });
                                    }
                                }
                            }, content);
                        }
                        return React.createElement('div', null, content);
                    }
                            </code>

                        <h5>🔧 características do renderizador:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>fallback seguro:</strong> Renderização plain text se ReactMarkdown não disponível
                            </li>
                            <li><strong>links externos:</strong> Todos os links abrem em nova aba</li>
                            <li><strong>segurança:</strong> <code>rel="noopener noreferrer"</code> para prevenção de ataques
                            </li>
                            <li><strong>compatibilidade:</strong> Funciona com qualquer conteúdo Markdown</li>
                        </ul>

                        <h5>🎯 elementos suportados:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>**negrito**</strong> - Texto em negrito</li>
                            <li><strong>*itálico*</strong> - Texto em itálico</li>
                            <li><strong>[links](url)</strong> - Links com target _blank</li>
                            <li><strong># cabeçalhos</strong> - Cabeçalhos diversos</li>
                            <li><strong>- listas</strong> - Listas não ordenadas</li>
                        </ul>
                    </div>

                    <h3>🤖 sistema de múltiplas IAs</h3>
                    <div class="card">
                        <h4>🔄 seletor de provedores</h4>
                        <code>AI Provider System</code>
                        <p>Sistema que permite alternar entre diferentes provedores de IA com configurações específicas</p>

                        <h5>🎯 configuração de provedores:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    const [selectedAI, setSelectedAI] = useState("/chatgemini");
                    const [spinnerSrc, setSpinnerSrc] = useState("/wp-content/themes/novoicode/assets/img/google.png");

                    const handleSelectChange = (event) => {
                        const selectedValue = event.target.value;
                        setSelectedAI(selectedValue);

                        const spinnerMap = {
                            "/chatic": "/wp-content/themes/novoicode/assets/img/logo2.png",
                            "/chatgemini": "/wp-content/themes/novoicode/assets/img/google.png"
                        };
                        setSpinnerSrc(spinnerMap[selectedValue] || "/wp-content/themes/novoicode/assets/img/default-spinner.png");
                    };
                            </code>

                        <h5>🔧 diferenças entre provedores:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">provedor</th>
                                    <th style="padding: 0.5rem; text-align: left;">endpoint</th>
                                    <th style="padding: 0.5rem; text-align: left;">modelo</th>
                                    <th style="padding: 0.5rem; text-align: left;">histórico</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Chat-Gemini</td>
                                    <td style="padding: 0.5rem;"><code>/chatgemini</code></td>
                                    <td style="padding: 0.5rem;">Gemini 2.0 Flash</td>
                                    <td style="padding: 0.5rem;">Stateless</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">Chat-IC</td>
                                    <td style="padding: 0.5rem;"><code>/chatic</code></td>
                                    <td style="padding: 0.5rem;">ICODE-IC:phi4</td>
                                    <td style="padding: 0.5rem;">Com histórico</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🎯 spinners visuais:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Google:</strong> Ícone do Google para Gemini</li>
                            <li><strong>Logo2:</strong> Logo personalizado para Chat-IC</li>
                            <li><strong>Dinâmico:</strong> Muda conforme provedor selecionado</li>
                        </ul>
                    </div>

                    <h3>📤 sistema de requisições</h3>
                    <div class="card">
                        <h4>🌐 integração com APIs</h4>
                        <code>API Integration</code>
                        <p>Sistema de comunicação com diferentes APIs de IA com tratamento específico para cada provedor</p>

                        <h5>🎯 fluxo de requisição Gemini:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (selectedAI === '/chatgemini') {
                        response = await fetch(selectedAI, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ messages: [{ content: query }] })
                        });
                
                        // Processamento da resposta Gemini
                        if (data.candidates && data.candidates[0].content.parts[0].text) {
                            const mainText = data.candidates[0].content.parts[0].text.trim();
                            const fontes = data.candidates[0].content.parts[0].fontes || { posts: [], pdfs: [] };
                        }
                    }
                            </code>

                        <h5>🎯 fluxo de requisição Chat-IC:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    if (selectedAI === '/chatic') {
                        const updatedHistory = [...conversationHistory, userMessage];
                        setConversationHistory(updatedHistory);

                        response = await fetch(selectedAI, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                model: "ICODE-IC:phi4",
                                messages: updatedHistory
                            })
                        });
                    }
                            </code>

                        <h5>🔧 diferenças de implementação:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>Gemini:</strong> Stateless - cada requisição é independente</li>
                            <li><strong>Chat-IC:</strong> Stateful - mantém histórico de conversa</li>
                            <li><strong>Estrutura:</strong> Payloads diferentes para cada API</li>
                            <li><strong>Resposta:</strong> Parsing específico para cada formato</li>
                        </ul>
                    </div>

                    <h3>📚 sistema de fontes</h3>
                    <div class="card">
                        <h4>🔗 rastreabilidade visual</h4>
                        <code>Source Attribution System</code>
                        <p>Exibição organizada das fontes consultadas com ícones e links apropriados</p>

                        <h5>🎯 componente de fontes:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    msg.role === 'assistant' && msg.fontes && (msg.fontes.posts.length > 0 || msg.fontes.pdfs.length > 0) &&
                    React.createElement('div', { className: 'fontes-container' },
                        React.createElement('h5', null, 'Fontes Consultadas:'),
                        React.createElement('ul', null,
                            [
                                ...msg.fontes.posts.map((fonte, idx) =>
                                    React.createElement('li', { key: `post-${idx}` },
                                        React.createElement('a', {
                                            href: fonte.url,
                                            rel: 'noopener noreferrer'
                                        }, `📌 ${fonte.titulo}`)
                                    )
                                ),
                                ...msg.fontes.pdfs.map((fonte, idx) =>
                                    React.createElement('li', { key: `pdf-${idx}` },
                                        React.createElement('a', {
                                            href: fonte.url,
                                            target: '_blank',
                                            rel: 'noopener noreferrer'
                                        }, `📄 ${fonte.nome}`)
                                    )
                                )
                            ]
                        )
                    )
                            </code>

                        <h5>🎯 tipos de fonte:</h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                            <thead>
                                <tr style="background: #3498db; color: white;">
                                    <th style="padding: 0.5rem; text-align: left;">tipo</th>
                                    <th style="padding: 0.5rem; text-align: left;">ícone</th>
                                    <th style="padding: 0.5rem; text-align: left;">target</th>
                                    <th style="padding: 0.5rem; text-align: left;">descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 0.5rem;">Posts</td>
                                    <td style="padding: 0.5rem;">📌</td>
                                    <td style="padding: 0.5rem;">Mesma aba</td>
                                    <td style="padding: 0.5rem;">Posts do WordPress</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem;">PDFs</td>
                                    <td style="padding: 0.5rem;">📄</td>
                                    <td style="padding: 0.5rem;">Nova aba</td>
                                    <td style="padding: 0.5rem;">Documentos PDF</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>🔧 características do sistema:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>condicional:</strong> Só exibe se houver fontes</li>
                            <li><strong>organizado:</strong> Lista separada por tipo</li>
                            <li><strong>interativo:</strong> Links clicáveis com ícones</li>
                            <li><strong>seguro:</strong> Atributos de segurança em links externos</li>
                        </ul>
                    </div>

                    <h3>⌨️ sistema de entrada</h3>
                    <div class="card">
                        <h4>💡 interface otimizada</h4>
                        <code>Input System</code>
                        <p>Sistema de entrada de texto com foco automático e atalhos de teclado</p>

                        <h5>🎯 configuração do textarea:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    const textareaRef = useRef(null);

                    useEffect(() => {
                        if (textareaRef.current) {
                            textareaRef.current.focus();
                        }
                    }, []);

                    React.createElement('textarea', {
                        ref: textareaRef,
                        className: 'chat-textarea',
                        value: query,
                        onChange: handleChange,
                        onKeyDown: handleKeyDown,
                        placeholder: 'Faça uma pergunta no contexto ICODE ...'
                    })
                            </code>

                        <h5>🎯 tratamento de teclas:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    const handleKeyDown = (event) => {
                        if (event.key === "Enter" && !event.shiftKey) {
                            event.preventDefault();
                            handleSubmit(event);
                        }
                    };
                            </code>

                        <h5>🔧 características da entrada:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>foco automático:</strong> Cursor posicionado automaticamente</li>
                            <li><strong>Enter para enviar:</strong> Atalho rápido sem Shift</li>
                            <li><strong>Shift+Enter:</strong> Quebra de linha normal</li>
                            <li><strong>placeholder contextual:</strong> Texto de ajuda específico</li>
                            <li><strong>textarea expansível:</strong> Ajusta conforme conteúdo</li>
                        </ul>
                    </div>

                    <h3>🚨 tratamento de erros</h3>
                    <div class="card">
                        <h4>⚠️ sistema robusto</h4>
                        <code>Error Handling</code>
                        <p>Tratamento completo de erros com feedback amigável ao usuário</p>

                        <h5>🎯 bloco try-catch:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    try {
                        // Requisições para diferentes APIs
                    } catch (error) {
                        console.error("Erro ao chamar a API:", error);
                        setMessages(prev => [{ 
                            role: "assistant", 
                            content: "Ocorreu um erro ao processar a solicitação." 
                        }, ...prev]);
                    } finally {
                        setIsLoading(false);
                    }
                            </code>

                        <h5>🔧 validações de resposta:</h5>
                        <code
                            style="display: block; background: #2c3e50; color: white; padding: 0.5rem; border-radius: 3px; font-size: 0.9rem; margin: 0.5rem 0;">
                    // Validação Gemini
                    if (data.candidates && data.candidates[0].content.parts[0].text) {
                        // Processa resposta válida
                    } else {
                        setMessages(prev => [{ 
                            role: "assistant", 
                            content: "Desculpe, não consegui entender." 
                        }, ...prev]);
                    }

                    // Validação Chat-IC
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                            </code>

                        <h5>🎯 tipos de erro tratados:</h5>
                        <ul style="list-style-position: inside; margin-top: 0.5rem;">
                            <li><strong>erros de rede:</strong> Fetch failures</li>
                            <li><strong>respostas HTTP:</strong> Status codes não-200</li>
                            <li><strong>estrutura inválida:</strong> JSON malformado</li>
                            <li><strong>campos faltantes:</strong> Dados esperados não presentes</li>
                            <li><strong>timeout:</strong> Requisições que excedem o tempo</li>
                        </ul>
                    </div>

                    <h3>🎯 tecnologias utilizadas</h3>
                    <div class="tech-stack">
                        <span class="tech-item">React</span>
                        <span class="tech-item">ReactMarkdown</span>
                        <span class="tech-item">JavaScript ES6+</span>
                        <span class="tech-item">Fetch API</span>
                        <span class="tech-item">React Hooks</span>
                        <span class="tech-item">CSS Modules</span>
                        <span class="tech-item">REST API</span>
                        <span class="tech-item">Error Handling</span>
                    </div>

                    <div style="background: #e8f4fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <h4>💡 características especiais</h4>
                        <ul style="list-style-position: inside;">
                            <li><strong>múltiplas IAs:</strong> Switch entre Gemini e Chat-IC</li>
                            <li><strong>renderização rica:</strong> Markdown com links e formatação</li>
                            <li><strong>rastreabilidade:</strong> Sistema completo de fontes</li>
                            <li><strong>interface otimizada:</strong> Atalhos de teclado e foco automático</li>
                            <li><strong>feedback visual:</strong> Spinners dinâmicos por provedor</li>
                            <li><strong>tratamento robusto:</strong> Error handling completo</li>
                            <li><strong>histórico inteligente:</strong> Gerenciamento diferente por provedor</li>
                            <li><strong>performance:</strong> Componentes funcionais com hooks</li>
                        </ul>
                    </div>
                </div>

            </div>


        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


        <script>
            // Função para mostrar uma tab específica
            function showTab(tabId) {
                // Encontra o botão da tab correspondente
                const tabButton = document.querySelector(`[data-bs-target="#${tabId}"]`);
                if (tabButton) {
                    // Usa Bootstrap para ativar a tab
                    const tab = new bootstrap.Tab(tabButton);
                    tab.show();

                    // Atualiza o indicador de seção atual
                    updateCurrentSection(tabButton.textContent.trim());
                }
            }

            // Função para atualizar o indicador de seção atual
            function updateCurrentSection(sectionName) {
                const indicator = document.getElementById('currentSection');
                if (indicator) {
                    indicator.textContent = `Visualizando: ${sectionName}`;
                }
            }

            // Inicializa o indicador com a tab atual
            document.addEventListener('DOMContentLoaded', function () {
                const activeTab = document.querySelector('.nav-link.active');
                if (activeTab) {
                    updateCurrentSection(activeTab.textContent.trim());
                }

                // Fecha dropdowns após seleção
                const dropdownItems = document.querySelectorAll('.dropdown-item');
                dropdownItems.forEach(item => {
                    item.addEventListener('click', function () {
                        // Pequeno delay para dar tempo da tab mudar antes de fechar o dropdown
                        setTimeout(() => {
                            const dropdown = this.closest('.dropdown');
                            const dropdownInstance = bootstrap.Dropdown.getInstance(dropdown.querySelector('.dropdown-toggle'));
                            if (dropdownInstance) {
                                dropdownInstance.hide();
                            }
                        }, 100);
                    });
                });

                // Atualiza o indicador quando as tabs mudam via Bootstrap
                const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
                tabEls.forEach(tabEl => {
                    tabEl.addEventListener('shown.bs.tab', function (event) {
                        updateCurrentSection(event.target.textContent.trim());
                    });
                });
            });

            // Inicializa as tabs do Bootstrap (mantido para compatibilidade)
            var tabEl = document.querySelector('button[data-bs-toggle="tab"]');
            if (tabEl) {
                tabEl.addEventListener('shown.bs.tab', function (event) {
                    event.target; // newly activated tab
                    event.relatedTarget; // previous active tab
                });
            }

            // Botão Scroll Up
            const scrollTopBtn = document.getElementById('scrollTopBtn');

            // Mostrar/ocultar botão baseado no scroll
            window.addEventListener('scroll', function () {
                if (window.pageYOffset > 300) {
                    scrollTopBtn.classList.add('show');
                } else {
                    scrollTopBtn.classList.remove('show');
                }
            });

            // Scroll instantâneo com transição suave
            scrollTopBtn.addEventListener('click', function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

        </script>


    </body>

    </html>

<?php } else {
    get_header();
    ?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-body p-4">
                            <h4 style="text-align:center;">Você não tem permissão para acessar essa página, consulte o
                                Administrador.</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
    get_footer();
} ?>