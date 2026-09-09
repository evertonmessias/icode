<!--Arquivo: wp-content/themes/novoicode/page-arquivos.php -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Arquivos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="/wp-content/plugins/novoicode/includes/elFinder/css/elfinder.min.css">
    <script src="/wp-content/plugins/novoicode/includes/elFinder/js/elfinder.min.js"></script>
    <script src="/wp-content/plugins/novoicode/includes/elFinder/js/i18n/elfinder.pt_BR.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        #elfinder {
            height: 100%;
        }

        body.modo-oculto .elfinder-toolbar,
        .elfinder-button-icon-mkdir {
            display: none !important;
        }


        .elfinder-button-icon-exportarpdf {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="18px" height="18px"><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg>') !important;
            background-position: center;
            background-repeat: no-repeat;
        }

        .elfinder-button-icon-indexarpdf {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'black\' width=\'18px\' height=\'18px\'><path d=\'M12 2C7.58 2 4 3.79 4 6v12c0 2.21 3.58 4 8 4s8-1.79 8-4V6c0-2.21-3.58-4-8-4zm0 2c3.87 0 7 1.12 7 2.5S15.87 9 12 9 5 7.88 5 6.5 8.13 4 12 4zm0 16c-3.87 0-7-1.12-7-2.5V15c1.73 1.07 4.34 1.5 7 1.5s5.27-.43 7-1.5v2.5c0 1.38-3.13 2.5-7 2.5zm0-4c-3.87 0-7-1.12-7-2.5V11c1.73 1.07 4.34 1.5 7 1.5s5.27-.43 7-1.5v2.5c0 1.38-3.13 2.5-7 2.5zm0-4c-3.87 0-7-1.12-7-2.5V7c1.73 1.07 4.34 1.5 7 1.5s5.27-.43 7-1.5v2.5c0 1.38-3.13 2.5-7 2.5z\'/></svg>') !important;
            background-position: center;
            background-repeat: no-repeat;
        }

        .elfinder-button-icon-doc2pdf {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="black" viewBox="0 0 24 24" width="18px" height="18px"><path d="M4 4v16h16V8.83L15.17 4H4zm9 1.5L18.5 11H13V5.5zM6 6h6v6h6v10H6V6zm2 4v2h4v-2H8zm0 4v2h8v-2H8z"/></svg>') !important;
            background-position: center;
            background-repeat: no-repeat;
        }


        #modalConvert .modal-header,
        #modalExport .modal-header,
        #modalIndex .modal-header {
            background: #116CE5;
            color: #fff;
        }

        #modalConvert .btn-close,
        #modalExport .btn-close,
        #modalIndex .btn-close {
            background: #222;
            color: #fff;
            padding: 10px 12px 17px 12px !important;
            opacity: 1;
        }

        #modalConvert .btn-close:hover,
        #modalExport .btn-close:hover,
        #modalIndex .btn-close:hover {
            transform: scale(1.1);
            color: #fff;
            font-weight: bold;
        }

        #elfinder>div.ui-front.ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable.std42-dialog.touch-punch.elfinder-dialog.elfinder-dialog-upload.elfinder-dialog-modal.elfinder-frontmost.elfinder-dialog-active>div.ui-dialog-titlebar.ui-widget-header.ui-corner-top.ui-helper-clearfix {
            background: #116CE5;
            margin-bottom: 5px;
            color: #fff;
        }

        #elfinder>div.ui-front.ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable.std42-dialog.touch-punch.elfinder-dialog.elfinder-dialog-upload.elfinder-dialog-modal.elfinder-frontmost.elfinder-dialog-active>div.ui-dialog-content.ui-widget-content>div>div.ui-corner-all.elfinder-upload-dropbox.elfinder-tabstop,
        #elfinder>div.ui-front.ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable.std42-dialog.touch-punch.elfinder-dialog.elfinder-dialog-upload.elfinder-dialog-modal.elfinder-frontmost.elfinder-dialog-active>div.ui-dialog-content.ui-widget-content>div>div.elfinder-upload-dialog-or,
        #elfinder>div.ui-front.ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable.std42-dialog.touch-punch.elfinder-dialog.elfinder-dialog-upload.elfinder-dialog-modal.elfinder-frontmost.elfinder-dialog-active>div.ui-dialog-content.ui-widget-content>div>div:nth-child(4) {
            display: none;
        }
    </style>

</head>

<?php
$user = wp_get_current_user();
$roles = $user->roles;
$is_admin = in_array('administrator', $roles);
$is_editor = in_array('editor', $roles);
$is_subscriber = in_array('subscriber', $roles);
$modo = $_GET['modo'] ?? '';
?>

<body class="<?php if ($modo == 'selecionar') {
    echo 'modo-oculto';
} ?>">

    <div class="modal fade" id="modalConvert" tabindex="-1" aria-labelledby="modalConvertLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Converter para PDF</h5>
                    <button type="button" title="Fechar" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Fechar"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalExport" tabindex="-1" aria-labelledby="modalExportLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Juntar e Exportar Documentos</h5>
                    <button type="button" title="Fechar" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Fechar"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalIndex" tabindex="-1" aria-labelledby="indexingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content mindex">
                <div class="modal-header">
                    <br>
                    <h5 class="modal-title" id="indexingModalLabel">Indexando Documentos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="bi bi-x-lg"></i></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div id="elfinder"></div>


    <script>
        // Configurações principais
        const tipo = '<?php echo $_GET['tipo'] ?? ''; ?>';
        const ano = '<?php echo $_GET['ano'] ?? ''; ?>';
        const postId = '<?php echo $_GET['post_id'] ?? ''; ?>';
        const modo = '<?php echo $modo ?>';

        const userIsAdmin = <?php echo $is_admin ? 'true' : 'false'; ?>;
        const userIsEditor = <?php echo $is_editor ? 'true' : 'false'; ?>;
        const userIsSubscriber = <?php echo $is_subscriber ? 'true' : 'false'; ?>;

        if (modo === 'selecionar') {
            jQuery(function ($) {
                const options = {
                    lang: 'pt_BR',
                    url: `/wp-content/plugins/novoicode/includes/elfinder.php?tipo=${tipo}&ano=${ano}&post_id=${postId}`,
                    resizable: false,
                    height: '100%',
                    commands: [],
                    contextmenu: {
                        navbar: [],
                        cwd: [],
                        files: [],
                    },
                    commandsOptions: {
                        mkdir: {
                            ui: 'hidden'
                        }
                    }
                };
                // Modo de seleção (restrito)
                options.getFileCallback = function (file) {
                    if (file && file.mime === 'application/pdf') {
                        window.parent.postMessage({
                            name: file.name,
                            url: file.url
                        }, '*');
                    } else {
                        alert('Por favor, selecione apenas arquivos PDF.');
                    }
                };

                $('#elfinder').elfinder(options).elfinder('instance').bind('ready', function () {
                    this.exec('fullscreen');
                });
            });

        } else {

            var elfInstance;

            const permalink = (postId === 'outros') ? '' : '<?php
            $post_id_raw = $_GET['post_id'] ?? '';
            $post_id_int = intval($post_id_raw);
            if ($post_id_int > 0) {
                $post = get_post($post_id_int);
                echo $post ? $post->post_name : '';
            } else {
                echo '';
            }
            ?>';

        const diretorios = `<?php echo ABSPATH; ?>wp-content/uploads/${tipo}/${ano}/${postId}`;
        const destino = (postId === 'outros') ? `${diretorios}/privado/documento.pdf` : `${diretorios}/privado/${permalink}.pdf`;


        if (tipo === "" && ano === "" && postId === "") {

            const userRole = '<?php echo implode(',', wp_get_current_user()->roles); ?>';
            const userIsAdmin = userRole.includes('administrator');
            const userIsEditor = userRole.includes('editor');
            const userIsSubscriber = userRole.includes('subscriber');

            if (userIsAdmin) {
                // Admin: acesso total
                var BTNtoolbar = [['back', 'forward'], ['reload'], ['upload', 'download'], ['view'], ['sort']];
                var BTNcommands = ['open', 'reload', 'up', 'back', 'forward', 'getfile', 'quicklook', 'download', 'rm', 'rename', 'upload', 'copy', 'cut', 'paste', 'mkdir', 'view', 'sort'];
                var BTNcontextmenu = {
                    navbar: ['open', '|', 'copy', 'cut', 'paste', 'rm', 'info'],
                    cwd: ['reload', 'back', '|', 'upload', '|', 'mkdir', '|', 'info'],
                    files: ['open', 'download', 'copy', 'cut', 'paste', '|', 'rm', '|', 'rename', '|', 'info'],
                };
            } else if (userIsEditor) {
                // Editor: pode alterar somente arquivos (dir não)
                var BTNtoolbar = [['back', 'forward'], ['reload'], ['download'], ['view'], ['sort']];
                var BTNcommands = ['open', 'reload', 'up', 'back', 'forward', 'getfile', 'quicklook', 'download', 'upload', 'view', 'sort'];
                var BTNcontextmenu = {
                    navbar: ['open', '|', 'info'],
                    cwd: ['reload', 'back', '|', 'info'],
                    files: ['open', '|', 'download', '|', 'info'],
                };
            } else {
                // Assinante: somente leitura (dir e files)
                var BTNtoolbar = [['back', 'forward'], ['reload'], ['view'], ['sort']];
                var BTNcommands = ['open', 'reload', 'up', 'back', 'forward', 'getfile', 'quicklook', 'view', 'sort'];
                var BTNcontextmenu = {
                    navbar: ['open', '|', 'info'],
                    cwd: ['reload', 'back', '|', 'info'],
                    files: ['open', '|', 'info'],
                };
            }

        } else {


            //botões personalizados


            // ********************************** CONVERTER **********************************************
            function converterPDF(dirName, selectedFiles) { // função para converter PDF

                const modal = new bootstrap.Modal(document.getElementById('modalConvert'));

                if (!selectedFiles || selectedFiles.length === 0) {
                    modal.show();
                    document.querySelector('#modalConvert .modal-body').innerHTML = `<div class="text-center"><div class="alert alert-danger" role="alert">
                    Por favor, selecione pelo menos um arquivo para <b>Convertar</b>.</div></div>`; return;
                }

                const validFiles = selectedFiles.filter(file =>
                    file.name.toLowerCase().endsWith('.doc') || file.name.toLowerCase().endsWith('.docx')
                );

                if (validFiles.length === 0) {
                    modal.show();
                    document.querySelector('#modalConvert .modal-body').innerHTML = `<div class="text-center"><div class="alert alert-warning" role="alert">
                    Nenhum arquivo .pdf selecionado.</div></div>`;
                    return;
                }

                modal.show();
                document.querySelector('#modalConvert .modal-body').innerHTML = `<div class="text-center">
                    <h5><i class="bi bi-hourglass-split"></i> Convertendo ${selectedFiles.length} documento(s) do diretório /${dirName} ...</h5>
                    <div class="progress mt-3" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                            style="width: 0%;" id="barraProgressoConverter">0%</div>
                    </div>
                </div>`;
                const barra = document.getElementById('barraProgressoConverter');

                // Simulação de progresso
                let progresso = 0;
                const intervalo = setInterval(() => {
                    progresso += 5;
                    if (progresso >= 90) progresso = 90;
                    barra.style.width = progresso + '%';
                    barra.innerText = progresso + '%';
                }, 500);

                // Obter paths reais - agora usando JSON.stringify para enviar corretamente
                const paths = selectedFiles.map(file => {
                    const f = elfInstance.file(file.hash);
                    return f ? f.path || `${diretorios}/${dirName}/${f.name}` : null;
                }).filter(path => path !== null);

                console.log('Paths dos arquivos selecionados:', paths);
                console.log('Nome do arquivo de destino:', destino);

                fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'novoicode_converter_pdf',
                        paths: JSON.stringify(paths), // Envia como JSON string
                        destino: destino
                    })
                })
                    .then(res => res.json())
                    .then(res => {
                        clearInterval(intervalo);
                        barra.style.width = '100%';
                        barra.innerText = '100%';

                        if (res.sucesso) {
                            document.querySelector('#modalConvert .modal-body').innerHTML = `<h5 class="text-success"><i class="bi bi-check-circle-fill"></i> Documento convertido com sucesso!</h5>
                <p>${res.arquivos} arquivo(s) convertido(s) para o diretório <b>/privado</b>.</p>`;
                        } else {
                            document.querySelector('#modalConvert .modal-body').innerHTML = `<h5 class="text-danger"><i class="bi bi-x-circle-fill"></i> Erro ao Converter: ${res.mensagem}</h5>`;
                        }
                    })
                    .catch(error => {
                        clearInterval(intervalo);
                        document.querySelector('#modalConvert .modal-body').innerHTML = `<h5 class="text-danger"><i class="bi bi-x-circle-fill"></i> Erro na requisição: ${error.message}</h5>`;
                    });
            }

            elFinder.prototype.commands.doc2pdf = function () {
                this.title = 'Converter Word para PDF';
                this.alwaysEnabled = false;
                this.updateOnSelect = true;

                this.getstate = function () {
                    try {
                        if (!this.fm || !this.fm.cwd()) return -1;

                        const cwd = this.fm.cwd();
                        if (cwd && cwd.name && cwd.name.toLowerCase() === 'privado') return -1;

                        const selected = this.fm.selectedFiles();
                        const temWord = selected.some(file =>
                            file.name.toLowerCase().endsWith('.doc') || file.name.toLowerCase().endsWith('.docx')
                        );

                        return temWord ? 0 : -1;
                    } catch (e) {
                        return -1;
                    }
                };

                this.exec = function () {
                    const selectedFiles = this.fm.selectedFiles().filter(file => file.mime !== 'directory');
                    const currentDir = this.fm.cwd().name;
                    converterPDF(currentDir, selectedFiles);
                    return $.Deferred().resolve();
                };
            };

            elFinder.prototype.i18.pt_BR.messages['cmddoc2pdf'] = 'Converter Word para PDF';



            // ********************************** JUNTAR **********************************************
            function exportarPDF(dirName, selectedFiles) { // função para juntar/exportar PDF

                const modal = new bootstrap.Modal(document.getElementById('modalExport'));

                if (!selectedFiles || selectedFiles.length === 0) {
                    modal.show();
                    document.querySelector('#modalExport .modal-body').innerHTML = `<div class="text-center"><div class="alert alert-danger" role="alert">
                    Por favor, selecione pelo menos um arquivo para <b>Exportar</b>.</div></div>`; return;
                }

                const validFiles = selectedFiles.filter(file =>
                    file.name.toLowerCase().endsWith('.pdf') || file.name.toLowerCase().endsWith('.pdf')
                );

                if (validFiles.length === 0) {
                    modal.show();
                    document.querySelector('#modalExport .modal-body').innerHTML = `<div class="text-center"><div class="alert alert-warning" role="alert">
                    Nenhum arquivo .pdf selecionado.</div></div>`;
                    return;
                }

                modal.show();
                document.querySelector('#modalExport .modal-body').innerHTML = `<div class="text-center">
                    <h5><i class="bi bi-hourglass-split"></i> Exportando ${selectedFiles.length} documento(s) do diretório /${dirName} ...</h5>
                    <div class="progress mt-3" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                            style="width: 0%;" id="barraProgressoExportar">0%</div>
                    </div>
                </div>`;
                const barra = document.getElementById('barraProgressoExportar');

                // Simulação de progresso
                let progresso = 0;
                const intervalo = setInterval(() => {
                    progresso += 5;
                    if (progresso >= 90) progresso = 90;
                    barra.style.width = progresso + '%';
                    barra.innerText = progresso + '%';
                }, 500);

                // Obter paths reais - agora usando JSON.stringify para enviar corretamente
                const paths = selectedFiles.map(file => {
                    const f = elfInstance.file(file.hash);
                    return f ? f.path || `${diretorios}/${dirName}/${f.name}` : null;
                }).filter(path => path !== null);

                console.log('Paths dos arquivos selecionados:', paths);
                console.log('Nome do arquivo de destino:', destino);

                fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'novoicode_exportar_pdf',
                        paths: JSON.stringify(paths), // Envia como JSON string
                        destino: destino
                    })
                })
                    .then(res => res.json())
                    .then(res => {
                        clearInterval(intervalo);
                        barra.style.width = '100%';
                        barra.innerText = '100%';

                        if (res.sucesso) {
                            document.querySelector('#modalExport .modal-body').innerHTML = `<h5 class="text-success"><i class="bi bi-check-circle-fill"></i> PDF exportado com sucesso!</h5>
                <p>${res.arquivos} arquivo(s) foram incluídos no PDF para o diretório <b>/privado</b></p>
                <a class="btn btn-primary mt-3" href="${res.url}" download>📄 Baixar PDF</a>`;
                        } else {
                            document.querySelector('#modalExport .modal-body').innerHTML = `<h5 class="text-danger"><i class="bi bi-x-circle-fill"></i> Erro ao exportar: ${res.mensagem}</h5>`;
                        }
                    })
                    .catch(error => {
                        clearInterval(intervalo);
                        document.querySelector('#modalExport .modal-body').innerHTML = `<h5 class="text-danger"><i class="bi bi-x-circle-fill"></i> Erro na requisição: ${error.message}</h5>`;
                    });
            }

            elFinder.prototype.commands.exportarpdf = function () {
                this.title = 'Juntar PDFs';
                this.alwaysEnabled = false;
                this.updateOnSelect = true;

                this.getstate = function () {
                    try {
                        if (!this.fm || !this.fm.cwd()) return -1;

                        const cwd = this.fm.cwd();
                        if (cwd && cwd.name && cwd.name.toLowerCase() === 'privado') return -1;

                        const selected = this.fm.selectedFiles();
                        const temPDF = selected.some(file =>
                            file.mime === 'application/pdf' ||
                            file.name.toLowerCase().endsWith('.pdf')
                        );

                        return temPDF ? 0 : -1;
                    } catch (e) {
                        return -1;
                    }
                };

                this.exec = function () {
                    const selectedFiles = this.fm.selectedFiles().filter(file =>
                        file.mime !== 'directory' &&
                        (file.name.toLowerCase().endsWith('.pdf') || file.mime === 'application/pdf')
                    );

                    const currentDir = this.fm.cwd().name;
                    exportarPDF(currentDir, selectedFiles);
                    return $.Deferred().resolve();
                };
            };

            elFinder.prototype.i18.pt_BR.messages['cmdexportarpdf'] = 'Juntar PDFs';


            // ********************************** INDEXAR **********************************************
            function indexarPDF(dirName, selectedFiles) {

                const modal = new bootstrap.Modal(document.getElementById('modalIndex'));

                if (!selectedFiles || selectedFiles.length === 0) {
                    modal.show();
                    document.querySelector('#modalIndex .modal-body').innerHTML = `<div class="text-center"><div class="alert alert-danger" role="alert">
                    Por favor, selecione pelo menos um arquivo para <b>Indexar</b>.</div></div>`; return;
                }


                const validFiles = selectedFiles.filter(file =>
                    file.name.toLowerCase().endsWith('.pdf') || file.name.toLowerCase().endsWith('.pdf')
                );

                if (validFiles.length === 0) {
                    modal.show();
                    document.querySelector('#modalExport .modal-body').innerHTML = `<div class="text-center"><div class="alert alert-warning" role="alert">
                    Nenhum arquivo .pdf selecionado.</div></div>`;
                    return;
                }

                modal.show();
                document.querySelector('#modalIndex .modal-body').innerHTML = `<div class="text-center">
                    <h5><i class="bi bi-hourglass-split"></i> Indexando ${selectedFiles.length} documento(s) do diretório /${dirName} ...</h5>
                    <div class="progress mt-3" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                            style="width: 0%;" id="barraProgressoIndexar">0%</div>                
                    </div>
                    <br>
                    <p id="statusindexacao" style="margin-top:10px;"></p>
                </div>`;
                const barra = document.getElementById('barraProgressoIndexar');
                const status = document.getElementById('statusindexacao');

                let concluido = 0;
                const total = selectedFiles.length;

                selectedFiles.forEach((file, index) => {
                    const f = elfInstance.file(file.hash);
                    if (!f) return;

                    const path = `${diretorios}/${dirName}/${f.name}`;
                    const url = `/wp-content/uploads/${tipo}/${ano}/${postId}/${dirName}/${f.name}`;

                    const formData = new URLSearchParams({
                        action: 'novoicode_indexar_pdf',
                        arquivo: path,
                        url: url,
                        tipo: tipo,
                        ano: ano,
                        id: postId
                    });

                    fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: formData
                    })
                        .then(res => res.json())
                        .then(res => {
                            concluido++;
                            const progresso = Math.floor((concluido / total) * 100);
                            barra.style.width = `${progresso}%`;
                            barra.innerText = `${progresso}%`;

                            if (res.success) {
                                status.innerHTML += `<div class="text-success"> ${f.name}: <b>${res.data.msg}</b></div>`;
                            } else {
                                status.innerHTML += `<div class="text-danger"> ${f.name}: <b>${res.data.msg}</b></div>`;
                            }

                            if (concluido === total) {
                                barra.classList.remove('progress-bar-animated');
                                barra.classList.remove('bg-success');
                                barra.classList.add('bg-primary');
                            }
                        })
                        .catch(error => {
                            concluido++;
                            status.innerHTML += `<div class="text-danger"> ${f.name}: Erro - ${error.message}</div>`;
                        });
                });
            }

            elFinder.prototype.commands.indexarpdf = function () {
                this.title = 'Indexar PDFs';
                this.alwaysEnabled = false;
                this.updateOnSelect = true;

                this.getstate = function () {
                    try {
                        if (!this.fm || !this.fm.cwd()) return -1;

                        const cwd = this.fm.cwd();
                        if (cwd && cwd.name && cwd.name.toLowerCase() === 'privado') return -1;

                        const selected = this.fm.selectedFiles();
                        const temPDF = selected.some(file =>
                            file.mime === 'application/pdf' ||
                            file.name.toLowerCase().endsWith('.pdf')
                        );

                        return temPDF ? 0 : -1;
                    } catch (e) {
                        return -1;
                    }
                };

                this.exec = function () {
                    const selectedFiles = this.fm.selectedFiles().filter(file =>
                        file.mime !== 'directory' &&
                        (file.mime === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf'))
                    );

                    const currentDir = this.fm.cwd().name;
                    indexarPDF(currentDir, selectedFiles);
                    return $.Deferred().resolve();
                };
            };

            elFinder.prototype.i18.pt_BR.messages['cmdindexarpdf'] = 'Indexar PDFs';



            //fim botões personalizados


            var BTNtoolbar = [
                ['back', 'forward'],
                ['reload'],
                ['upload'],
                ['download'],
                ['view'],
                ['sort'],
                ['exportarpdf'],
                ['indexarpdf'],
                ['doc2pdf']
            ];

            var BTNcommands = [
                'open', 'reload', 'up', 'back', 'forward', 'getfile', 'quicklook',
                'download', 'rm', 'rename', 'upload', 'copy',
                'cut', 'paste', 'edit', 'extract', 'search', 'view', 'resize', 'sort', 'exportarpdf', 'indexarpdf', 'doc2pdf'
            ];
            var BTNcontextmenu = {
                navbar: [],
                cwd: [],
                files: ['open', 'download', 'copy', 'cut', 'paste', '|', 'rm', '|', 'rename', '|', 'info', '|', 'exportarpdf', '|', 'indexarpdf', '|', 'doc2pdf'],
            };

        }

        $().ready(function () {
            elfInstance = $('#elfinder').elfinder({
                lang: 'pt_BR',
                url: `/wp-content/plugins/novoicode/includes/elfinder.php?tipo=${tipo}&ano=${ano}&post_id=${postId}`,
                resizable: false,
                height: '100%',
                uiOptions: {
                    toolbar: BTNtoolbar,
                },
                commands: BTNcommands,
                contextmenu: BTNcontextmenu,
                commandsOptions: {
                    mkdir: {
                        ui: 'hidden'
                    },
                    open: {
                        dblclick: false
                    }
                }
            }).elfinder('instance');
        });

    }
    </script>

</body>

</html>