<!-- Arquivo: wp-content/themes/novoicode/page-share.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Arquivos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/wp-content/themes/novoicode/assets/css/style.css">
    <link rel="stylesheet" href="/wp-content/themes/novoicode/assets/css/novoicode.css">
</head>

<body>
    <?php
    $post = get_post($_GET['post_id']);
    $post_type = get_post_type($post);
    $category = get_the_category($post->ID)[0]->name ?? '';
    $data_iso = get_post_meta($post->ID, $post_type . '_date', true);
    $data = DateTime::createFromFormat('Y-m-d\TH:i', $data_iso);
    $formatada = $data ? $data->format('d/m/Y, H:i') : '';
    $current_user = wp_get_current_user();
    $email = $current_user->user_email;
    ?>


    <div class="card p-4 form-contact">
        <form id="form-envio-email">
            <input type="hidden" name="action" value="enviar_email_convocacao">
            <input type="hidden" name="post_id" value="<?php echo esc_attr($post->ID); ?>">

            <div class="mb-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-enviar">Enviar</button>
            </div>

            <div id="resposta" class="mt-3"></div>

            <div class="mb-3">
                <label for="remetente" class="form-label"><b>De:</b></label>
                <input type="text" class="form-control" value="<?php echo esc_attr($email); ?>" id="remetente"
                    name="remetente" readonly style="background:#eee">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label"><b>Para:</b></label>
                <input type="text" class="form-control" id="email" name="email" required
                    value="staff@ic.unicamp.br,admic@ic.unicamp.br">
            </div>

            <div class="mb-3">
                <label for="title" class="form-label"><b>Assunto:</b></label>
                <input type="text" class="form-control" id="title" name="title" required
                    value="<?php echo esc_attr($post->post_title); ?>">
            </div>

            <div class="mb-3">
                <label for="link" class="form-label"><b>Link da Reunião:</b></label>
                <input type="text" class="form-control" id="link" name="link" required placeholder="https://..." />
                <div class="form-text">A URL deve começar com http:// ou https://</div>
                <div id="link-validacao" class="form-text"></div>
            </div>

            <br><hr><br>

            <br><b><i class="bi bi-eye"></i>&ensp;Preview do E-Mail:</b><br><br>
            <div class="card mb-3">
                <div class="card-body">
                    <div id="preview-descricao" style="min-height: 200px; border: 1px solid #ddd; padding: 15px; background: #f9f9f9;">
                        <!-- O conteúdo será atualizado dinamicamente via JavaScript -->
                    </div>
                    <textarea id="descricao" name="descricao" style="display: none;"></textarea>
                </div>
            </div>

            <div class="card mb-3"><br>
                <div class="card-body">
                    <?php echo apply_filters('the_content', get_post_meta($post->ID, $post_type . '_member', true)); ?>
                </div>
            </div>

            <div class="card mb-3"><br>
                <div class="card-body">
                    <?php echo apply_filters('the_content', $post->post_content); ?>
                </div>
            </div>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const linkInput = document.getElementById('link');
            const previewDescricao = document.getElementById('preview-descricao');
            const descricaoTextarea = document.getElementById('descricao');
            const form = document.getElementById('form-envio-email');
            const linkValidacao = document.getElementById('link-validacao');
            
            // Função para validar URL de forma rigorosa
            function validarURL(url) {
                // Remove espaços em branco
                url = url.trim();
                
                // Se estiver vazia, retorna vazio
                if (!url) return { url: url, valida: false };
                
                // Verifica se começa com http:// ou https://
                if (!url.startsWith('http://') && !url.startsWith('https://')) {
                    return { url: url, valida: false };
                }
                
                // Validação rigorosa usando expressão regular
                const padraoURL = /^(https?:\/\/)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(:\d+)?(\/[^\s]*)?$/;
                
                // Validação adicional para evitar IPs inválidos e números
                if (!padraoURL.test(url)) {
                    return { url: url, valida: false };
                }
                
                // Verifica se não é apenas números e pontos
                const semProtocolo = url.replace(/^https?:\/\//, '');
                if (/^\d+\.\d+\.\d+\.\d+$/.test(semProtocolo.split('/')[0])) {
                    // É um IP, validar formato de IP
                    const partesIP = semProtocolo.split('/')[0].split('.');
                    if (partesIP.length !== 4) return { url: url, valida: false };
                    for (let parte of partesIP) {
                        const num = parseInt(parte);
                        if (isNaN(num) || num < 0 || num > 255) {
                            return { url: url, valida: false };
                        }
                    }
                } else {
                    // É um domínio, verificar se tem pelo menos um ponto após o protocolo
                    const dominio = semProtocolo.split('/')[0];
                    if (!dominio.includes('.') || dominio.split('.').pop().length < 2) {
                        return { url: url, valida: false };
                    }
                }
                
                return { url: url, valida: true };
            }
            
            // Função para atualizar o preview
            function atualizarPreview() {
                const link = linkInput.value.trim();
                const urlValidada = validarURL(link);
                
                let linkHtml, mensagemValidacao, classeValidacao;
                
                if (!link) {
                    linkHtml = '[Link não informado]';
                    mensagemValidacao = 'Digite o link da reunião';
                    classeValidacao = 'text-warning';
                } else if (urlValidada.valida) {
                    linkHtml = `<a href="${urlValidada.url}" target="_blank">${urlValidada.url}</a>`;
                    mensagemValidacao = '✓ URL válida';
                    classeValidacao = 'text-success';
                } else {
                    // Mostra o texto em vermelho sem criar link
                    linkHtml = `<span style="color: red; font-weight: bold;">${link}</span>`;
                    mensagemValidacao = '❌ URL inválida - deve começar com http:// ou https:// e ter formato correto';
                    classeValidacao = 'text-danger';
                }
                
                // Atualiza mensagem de validação
                linkValidacao.innerHTML = mensagemValidacao;
                linkValidacao.className = `form-text ${classeValidacao}`;
                
                const conteudoPreview = `
                    <h3>De ordem, convocamos os Membros do Instituto de Computação para a <?php echo esc_html($post->post_title); ?></h3>
                    <ul>
                        <li>Link para a Reunião: ${linkHtml}</li>
                        <li>Data: <?php echo esc_html($formatada); ?></li>
                        <li>URL da Reunião: <a href="<?php echo get_permalink($post->ID); ?>" target="_blank"><?php echo get_permalink($post->ID); ?></a></li>
                    </ul>
                `;
                
                previewDescricao.innerHTML = conteudoPreview;
                
                // Para o textarea hidden, usamos a URL como está (mesmo se inválida)
                const conteudoParaEnvio = `
                    <h3>De ordem, convocamos os Membros do Instituto de Computação para a <?php echo esc_html($post->post_title); ?></h3>
                    <ul>
                        <li>Link para a Reunião: <a href="${link}">${link}</a></li>
                        <li>Data: <?php echo esc_html($formatada); ?></li>
                        <li>URL da Reunião: <a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_permalink($post->ID); ?></a></li>
                    </ul>
                `;
                descricaoTextarea.value = conteudoParaEnvio;
            }
            
            // Atualizar preview quando o link for digitado
            linkInput.addEventListener('input', atualizarPreview);
            
            // Atualizar preview inicial
            atualizarPreview();

            // Envio do formulário
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                const link = linkInput.value.trim();
                const urlValidada = validarURL(link);
                
                // Validação final antes do envio
                if (!link) {
                    alert('Por favor, digite o link da reunião');
                    linkInput.focus();
                    return;
                }
                
                if (!urlValidada.valida) {
                    const confirmar = confirm('A URL está inválida. Ela deve começar com http:// ou https:// e ter um formato correto.\n\nDeseja enviar mesmo assim?');
                    if (!confirmar) {
                        linkInput.focus();
                        return;
                    }
                }

                const btn = this.querySelector('.btn-enviar');
                btn.disabled = true;
                btn.innerText = 'Enviando...';
                
                // Garantir que o textarea tenha o conteúdo mais recente
                atualizarPreview();

                const formData = new FormData(this);

                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData
                })
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById('resposta').innerHTML = data;
                        btn.disabled = false;
                        btn.innerText = 'Enviar';
                    })
                    .catch(err => {
                        document.getElementById('resposta').innerHTML = '<div class="alert alert-danger">Erro inesperado.</div>';
                        btn.disabled = false;
                        btn.innerText = 'Enviar';
                    });
            });
        });
    </script>
</body>
</html>