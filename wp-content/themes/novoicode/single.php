<?php
// Arquivo: wp-content/themes/novoicode/single.php
get_header();
$post_id = get_the_ID();
?>

<?php if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
   echo '<script>window.location.href = "/perfil";</script>'; ?>

<main id="main" class="main">

   <?php
   $membro = get_user_meta(wp_get_current_user()->ID, 'membro', true);
   $is_admin = current_user_can('administrator');
   $is_editor = current_user_can('editor');
   $current_type = url_active()[1];

   if (!$is_admin && (!is_array($membro) || !in_array($current_type, $membro))) {
      error_log("Permissão Negada para " . wp_get_current_user()->user_login);
      ?>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body p-4">
                     <h4 style="text-align:center;">Você não está no <b><u>Membros
                              <?php echo print_type($current_type, 'nome') ?></u></b>, consulte o Administrador.</h4>
                  </div>
               </div>
            </div>
         </div>
      </section>
   <?php } else { ?>

      <?php

      $membro_post_privado = get_user_meta(wp_get_current_user()->ID, 'membro_post_privado', true);
      // CORREÇÃO: Admin sempre tem acesso a posts privados
      if ($is_admin || (is_array($membro_post_privado) && in_array(url_active()[1], $membro_post_privado))) {
         $user_membro_post_privado = true;
      } else {
         $user_membro_post_privado = false;
      }

      $membro_arquivo_privado = get_user_meta(wp_get_current_user()->ID, 'membro_arquivo_privado', true);
      // CORREÇÃO: Admin sempre tem acesso a arquivos privados
      if ($is_admin || (is_array($membro_arquivo_privado) && in_array(url_active()[1], $membro_arquivo_privado))) {
         $user_membro_arquivo_privado = true;
      } else {
         $user_membro_arquivo_privado = false;
      }

      $post_privado = get_post_meta($post_id, url_active()[1] . '_privado', true);

      // CORREÇÃO: Admin sempre pode ver posts privados
      if ($post_privado && !$user_membro_post_privado && !$is_admin)
         echo '<script>window.location.href = "/404";</script>'; ?>

      <div class="pagetitle d-flex justify-content-between align-items-center">
         <div>
            <h1><i
                  class="<?php echo print_type(url_active()[1], 'icone'); ?>"></i>&ensp;<?php echo print_type(url_active()[1], 'texto'); ?>
               - <?php echo url_active()[2]; ?></h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/">Home</a></li>
                  <li class="breadcrumb-item active">
                     <a href="/<?php echo url_active()[1]; ?>"><?php echo print_type(url_active()[1], 'nome'); ?></a>
                  <li class="breadcrumb-item active">
                     <a href="/<?php echo url_active()[1] . '/' . url_active()[2]; ?>"><?php echo url_active()[2]; ?></a>
                  </li>
               </ol>
            </nav>
         </div>

         <div class="btn-editors">
            <a class="btn btn-light" href="/<?php echo url_active()[1] . '/' . url_active()[2]; ?>"><i
                  class="bi bi-skip-backward-fill"></i>&ensp;Voltar</a>
            &emsp;<button class="btn btn-dark" onclick="imprimirConteudo()"><i
                  class="bi bi-printer"></i>&ensp;Imprimir</button>
            <?php if (is_user_logged_in() && !current_user_can('subscriber')) { ?>
               &emsp;<button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#shareModal">
                  <i class="bi bi-share"></i>&ensp;Compartilhar</button>
               &emsp;<a href="/painel/editar/?id=<?php echo $post_id; ?>" class="btn btn-success">
                  <i class="bi bi-pencil-square"></i>&ensp;Editar</a>
               &emsp;<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                  <i class="bi bi-trash"></i>&ensp;Apagar</button>
            <?php } ?>
         </div>

      </div>

      <section class="section single">

         <style>
            .link-privado .bi-file-earmark-lock2 {
               color: #f00 !important;
            }

            .dataTables_wrapper .dataTables_filter {
               float: left;
            }

            .dataTables_info {
               display: none;
            }

            .table th:nth-child(1) {
               width: 90%;
            }

            .table th:nth-child(2) {
               width: 10%;
            }

            /* Estilos para ordenação por arraste */
            .table-sortable tbody tr {
               cursor: move;
               cursor: grab;
               cursor: -webkit-grab;
            }

            .table-sortable tbody tr:active {
               cursor: grabbing;
               cursor: -webkit-grabbing;
            }

            .table-sortable tbody tr.sortable-ghost {
               opacity: 0.4;
            }

            .table-sortable tbody tr.sortable-chosen {
               background-color: #f8f9fa;
               box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            /* Indicador visual para usuários editores */
            .editor-sortable .table-sortable tbody tr:hover {
               background-color: #e9ecef;
            }

            .table-empty {
               opacity: 0.6;
            }

            .table-empty-container {
               pointer-events: none;
            }

            .editor-sortable {
               cursor: move;
               /* ou cursor: grab; */
            }

            /* Estilos para impressão */
            @media print {
               body * {
                  visibility: hidden;
               }

               .printable-content,
               .printable-content * {
                  visibility: visible;
               }

               .printable-content {
                  position: absolute;
                  left: 0;
                  top: 0;
                  width: 100%;
               }

               .no-print {
                  display: none !important;
               }

               .card {
                  border: 1px solid #000 !important;
                  margin-bottom: 20px !important;
                  page-break-inside: avoid;
               }

               .card-title {
                  font-weight: bold;
                  font-size: 18px;
                  margin-bottom: 10px;
               }
            }
         </style>

         <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>


         <script>

            function removerHiperlinks(html) {
               // Criar um elemento temporário para manipular o HTML
               var tempDiv = document.createElement('div');
               tempDiv.innerHTML = html;

               // Remover todos os links, mantendo apenas o texto
               var links = tempDiv.getElementsByTagName('a');
               for (var i = links.length - 1; i >= 0; i--) {
                  var link = links[i];
                  var texto = link.textContent || link.innerText;
                  var span = document.createElement('span');
                  span.textContent = texto;
                  link.parentNode.replaceChild(span, link);
               }

               return tempDiv.innerHTML;
            }



            function imprimirConteudo() {
               // Obter o conteúdo dos elementos
               var titulo = document.querySelector('.print-title').innerHTML;
               var data = document.querySelector('.print-date').innerHTML;
               var membrosElement = document.querySelector('.print-membros');
               var conteudoElement = document.querySelector('.print-conteudo');

               // Processar membros (se existir)
               var membrosHTML = '';
               if (membrosElement) {
                  membrosHTML = removerHiperlinks(membrosElement.innerHTML);
               }

               // Processar conteúdo
               var conteudoHTML = removerHiperlinks(conteudoElement.innerHTML);

               // Criar uma nova janela para impressão
               var janelaImpressao = window.open('', '_blank');
               janelaImpressao.document.write(`
                  <html>
                     <head>
                        <title>Imprimir - <?php echo get_the_title(); ?></title>
                        <style>
                           body { 
                              font-family: Arial, sans-serif; 
                              margin: 20px; 
                              line-height: 1.6;
                              color: #000;
                           }
                           .print-header { 
                              border-bottom: 2px solid #000; 
                              padding-bottom: 10px; 
                              margin-bottom: 20px;
                           }
                           .print-title { 
                              font-size: 24px; 
                              font-weight: bold; 
                              margin-bottom: 5px;
                           }
                           .print-date { 
                              font-size: 16px; 
                              color: #666;
                              margin-bottom: 20px;
                           }
                           .print-section { 
                              margin-bottom: 30px;
                           }
                           .print-section-title { 
                              font-size: 18px; 
                              font-weight: bold; 
                              margin-bottom: 10px;
                              border-bottom: 1px solid #ccc;
                              padding-bottom: 5px;
                           }
                           .print-content { 
                              line-height: 1.6;
                           }
                           .print-membros-content {
                              padding: 10px;
                              background: #f9f9f9;
                              border-left: 3px solid #ccc;
                           }
                           a, a:link, a:visited, a:hover, a:active {
                              color: #000 !important;
                              text-decoration: none !important;
                              pointer-events: none !important;
                              cursor: default !important;
                           }
                           @media print {
                              body { margin: 15mm; }
                              .print-header { border-bottom: 2px solid #000; }
                              .print-section-title { border-bottom: 1px solid #ccc; }
                           }
                        </style>
                     </head>
                     <body>
                        <div class="print-header">
                           <div class="print-title">${titulo}</div>
                           <div class="print-date">Data da Reunião: ${data}</div>
                        </div>
                        
                        ${membrosHTML ? `
                        <div class="print-section">
                           <div class="print-section-title">Membros</div>
                           <div class="print-membros-content">${membrosHTML}</div>
                        </div>
                        ` : ''}
                        
                        <div class="print-section">
                           <div class="print-section-title">Conteúdo</div>
                           <div class="print-content">${conteudoHTML}</div>
                        </div>
                     </body>
                  </html>
               `);

            janelaImpressao.document.close();
            janelaImpressao.focus();

            // Aguardar o carregamento do conteúdo antes de imprimir
            setTimeout(function () {
               janelaImpressao.print();
               janelaImpressao.close();
            }, 500);
         }



         // Função para inicializar a ordenação nas tabelas
         function inicializarOrdenacao() {
            // Verificar se o usuário é editor ou administrador
            const isEditor = <?php echo (is_user_logged_in() && !current_user_can('subscriber')) ? 'true' : 'false'; ?>;

            if (isEditor) {
               // Adicionar classe para indicar que é ordenável apenas se a tabela não estiver vazia
               document.querySelectorAll('table[id^="t"]').forEach(table => {
                  const tbody = table.querySelector('tbody');
                  const rows = tbody.querySelectorAll('tr');

                  // Verificar se a tabela não está vazia (não contém "Diretório Vazio")
                  let isEmpty = true;
                  rows.forEach(row => {
                     const firstCell = row.querySelector('td');
                     if (firstCell && firstCell.textContent !== 'Diretório Vazio') {
                        isEmpty = false;
                     }
                  });

                  if (!isEmpty) {
                     table.classList.add('table-sortable');
                     table.closest('.card').classList.add('editor-sortable');

                     // Inicializar SortableJS apenas para tabelas não vazias
                     new Sortable(tbody, {
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        chosenClass: 'sortable-chosen',
                        onEnd: function (evt) {
                           salvarOrdenacao(evt.from, evt.item.closest('.card').querySelector('.card-title').textContent);
                        }
                     });
                  } else {
                     // Adicionar classe para tabelas vazias (opcional)
                     table.classList.add('table-empty');
                     table.closest('.card').classList.add('table-empty-container');
                  }
               });
            }
         }



         // Função para salvar a ordenação
         function salvarOrdenacao(tbody, categoria) {
            const files = Array.from(tbody.querySelectorAll('tr[data-file]')).map(tr => tr.getAttribute('data-file'));

            // Obter a subpasta do atributo data-tab da tabela
            const table = tbody.closest('table');
            const subpasta = table.getAttribute('data-tab');

            console.log('=== DEBUG ORDENAÇÃO ===');
            console.log('Categoria recebida:', categoria);
            console.log('Subpasta do data-tab:', subpasta);
            console.log('Files:', files);
            console.log('Post ID:', <?php echo $post_id; ?>);

            // Enviar via AJAX para salvar a ordenação
            const data = new FormData();
            data.append('action', 'salvar_ordenacao_arquivos');
            data.append('subpasta', subpasta);
            data.append('post_id', <?php echo $post_id; ?>);
            data.append('ordenacao', JSON.stringify(files));
            data.append('nonce', '<?php echo wp_create_nonce("salvar_ordenacao_nonce"); ?>');

            fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
               method: 'POST',
               body: data
            })
               .then(response => response.json())
               .then(data => {
                  console.log('Resposta do servidor:', data);
                  if (data.success) {
                     console.log('✅ Ordenação salva com sucesso!');
                     // Feedback visual
                     const card = tbody.closest('.card');
                     const originalBg = card.style.backgroundColor;
                     card.style.backgroundColor = '#d4edda';
                     setTimeout(() => {
                        card.style.backgroundColor = originalBg;
                     }, 1000);
                  } else {
                     console.error('❌ Erro ao salvar ordenação:', data.data);
                     alert('Erro ao salvar ordenação: ' + data.data);
                  }
               })
               .catch(error => {
                  console.error('❌ Erro na requisição:', error);
                  alert('Erro de conexão ao salvar ordenação');
               });
         }

         // Inicializar a ordenação quando o documento carregar
         document.addEventListener('DOMContentLoaded', function () {
            inicializarOrdenacao();
         });



      </script>


      <?php
      // Verifica se um post foi apagado e redireciona
      if (isset($_GET['deleted']) && $_GET['deleted'] == 'true') {
         echo "<script>window.location.href='/';</script>";
         exit;
      }

      $upload_dir = wp_upload_dir();
      $base_dir = $upload_dir['basedir']; // Caminho físico até /wp-content/uploads
      $base_url = $upload_dir['baseurl']; // URL até /wp-content/uploads
   
      $post_type = get_post_type($post);
      $category = get_the_category($post_id)[0]->name;
      $post_id = get_the_ID();

      $relative_path = "/$post_type/$category/$post_id";
      $URL = "$base_url$relative_path/";
      $DIR = "$base_dir$relative_path";



      // Função para listar arquivos de uma subpasta com ordenação personalizada
      function listarArquivos($subpasta, $DIR, $URL)
      {
         $lista = '';
         $caminho = "$DIR/$subpasta";
         $url = "$URL$subpasta";

         if (is_dir($caminho)) {
            // Verificar se existe arquivo de ordenação
            $arquivo_ordenacao = "$caminho/.order.ini";
            $ordenacao = array();

            if (file_exists($arquivo_ordenacao)) {
               $conteudo = file_get_contents($arquivo_ordenacao);
               $ordenacao = unserialize($conteudo);
               if (!is_array($ordenacao)) {
                  $ordenacao = array();
               }
            }

            $arquivos = scandir($caminho);
            $arquivos_validos = array();

            foreach ($arquivos as $arquivo) {
               if ($arquivo !== '.' && $arquivo !== '..' && $arquivo != '.tmb' && $arquivo != '.order.ini') {
                  $arquivos_validos[] = $arquivo;
               }
            }

            // Verificar se o diretório está vazio
            if (empty($arquivos_validos)) {
               $lista .= "<tr>
                     <td>Diretório Vazio</td>
                     <td>0 KB</td>
                   </tr>";
            } else {
               // Aplicar ordenação personalizada se existir
               if (!empty($ordenacao)) {
                  // Ordenar mantendo a ordem personalizada e adicionando novos arquivos no final
                  $arquivos_ordenados = array();
                  $arquivos_restantes = $arquivos_validos;

                  foreach ($ordenacao as $arquivo_ordenado) {
                     if (in_array($arquivo_ordenado, $arquivos_restantes)) {
                        $arquivos_ordenados[] = $arquivo_ordenado;
                        $arquivos_restantes = array_diff($arquivos_restantes, array($arquivo_ordenado));
                     }
                  }

                  // Adicionar arquivos novos no final
                  $arquivos_validos = array_merge($arquivos_ordenados, $arquivos_restantes);
               } else {
                  // Ordem alfabética padrão
                  sort($arquivos_validos);
               }

               // Gerar a lista HTML
               foreach ($arquivos_validos as $arquivo) {
                  $caminho_completo = "$caminho/$arquivo";
                  $tamanho_bytes = filesize($caminho_completo);

                  // Converter e formatar conforme o tamanho
                  if ($tamanho_bytes >= 1024 * 1024) {
                     $tamanho_formatado = round($tamanho_bytes / (1024 * 1024), 2) . ' MB';
                  } else {
                     $tamanho_formatado = round($tamanho_bytes / 1024, 2) . ' KB';
                  }

                  $lista .= "<tr data-file='$arquivo'>
                        <td><a href='$url/$arquivo' target='_blank'>$arquivo</a></td>
                        <td>$tamanho_formatado</td>
                      </tr>";
               }
            }
         }
         return $lista;
      }



      // Obter dados para impressão ANTES de exibir o conteúdo
      $data_iso = get_post_meta(get_the_ID(), $post_type . '_date', true);
      $data = DateTime::createFromFormat('Y-m-d\TH:i', $data_iso);
      $formatada = $data->format('d/m/Y, H:i');
      $membros = apply_filters('the_content', get_post_meta(get_the_ID(), $post_type . '_member', true));
      ?>

      <!-- Conteúdo para impressão (oculto na visualização normal) -->
      <div id="conteudo-impressao" style="display: none;">
         <div class="print-title"><?php echo get_the_title(); ?></div>
         <div class="print-date"><?php echo $formatada; ?></div>
         <?php if ($membros != "") { ?>
         <div class="print-membros"><?php echo $membros; ?></div>
         <?php } ?>
         <div class="print-conteudo"><?php the_content(); ?></div>
      </div>

      <div class="card mb-3">
         <div class="card-body">
            <div class="row <?php if ($post_privado)
               echo 'link-privado' ?>">
               <div class="col-lg-10">
                  <br>
                  <h4>
                     <b><?php if ($post_privado) {
               echo "<i title='Post Privado' class='bi bi-file-earmark-lock2'></i>&ensp;";
            } ?><?php echo get_the_title(); ?></b>
                  </h4>
               </div>
               <div class="col-lg-2">
                  <br>
                  <h5><b><?php echo $formatada; ?></b></h5>
               </div>
            </div>
         </div>
      </div>

      <?php if ($membros != "") { ?>
      <div class="row">
         <div class="col-lg-12">
            <div class="card mb-3">
               <div class="card-body">
                  <div class="card-title">Membros</div>
                  <?php echo $membros; ?>
                  <br>
               </div>
            </div>
         </div>
      </div>
      <?php } ?>

      <div class="row">
         <div class="col-lg-12">
            <div class="card mb-3">
               <div class="card-body">
                  <div class="card-title">Conteúdo</div>
                  <br>
                  <?php the_content(); ?>
                  <br>
                  <br>
                  <p style="float: right;"><i style="color: #f00;font-weight: bold;">(para membros)</i> - Somente para
                     membros <b>titular</b> e <b>suplente</b> do colegiado.&emsp;</p>
               </div>
            </div>
         </div>
      </div>

      <?php
      $path = ABSPATH . 'wp-content/uploads' . $relative_path;
      if (is_dir($path)) { ?>

      <!-- Anexos ************************************************************************** -->

      <div class="row">
         <div class="col-lg-12">
            <div class="card" style="background:#666;padding:15px 10px 0px 10px;margin-bottom:15px">
               <div class="card-body">
                  <strong style="color:#fff;">Anexos</strong>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <div class="card-title">Pautas (público):
                     <?php if (is_user_logged_in() && !current_user_can('subscriber')) { ?>
                     <small style="font-size: 13px;float:right;">(Arraste <i class="bi bi-arrows-vertical"></i> para
                        ordenar)</small>
                     <?php } ?>
                  </div>
                  <!-- Tabela de Pautas -->
                  <table id="tpautas" data-tab="pautas" class="table table-striped table-hover">
                     <thead>
                        <tr>
                           <th>Arquivo</th>
                           <th>Tamanho</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php echo listarArquivos('pautas', $DIR, $URL); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <div class="card-title">Deliberações (público):
                     <?php if (is_user_logged_in() && !current_user_can('subscriber')) { ?>
                     <small style="font-size: 13px;float:right;">(Arraste <i class="bi bi-arrows-vertical"></i> para
                        ordenar)</small>
                     <?php } ?>
                  </div>
                  <!-- Tabela de Deliberações -->
                  <table id="tdeliberacoes" data-tab="deliberacoes" class="table table-striped table-hover">
                     <thead>
                        <tr>
                           <th>Arquivo</th>
                           <th>Tamanho</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php echo listarArquivos('deliberacoes', $DIR, $URL); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <div class="card-title">Ata (público):
                     <?php if (is_user_logged_in() && !current_user_can('subscriber')) { ?>
                     <small style="font-size: 13px;float:right;">(Arraste <i class="bi bi-arrows-vertical"></i> para
                        ordenar)</small>
                     <?php } ?>
                  </div>
                  <!-- Tabela de Ata -->
                  <table id="tata" data-tab="ata" class="table table-striped table-hover">
                     <thead>
                        <tr>
                           <th>Arquivo</th>
                           <th>Tamanho</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php echo listarArquivos('ata', $DIR, $URL); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>

      <?php
      // CORREÇÃO: Admin sempre pode ver arquivos privados
      if ($user_membro_arquivo_privado || $is_admin) { ?>
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <div class="card-title">Itens (privado):
                     <?php if (is_user_logged_in() && !current_user_can('subscriber')) { ?>
                     <small style="font-size: 13px;float:right;">(Arraste <i class="bi bi-arrows-vertical"></i> para
                        ordenar)</small>
                     <?php } ?>
                  </div>
                  <!-- Tabela de Privado -->
                  <table id="tprivado" data-tab="privado" class="table table-striped table-hover">
                     <thead>
                        <tr>
                           <th>Arquivo</th>
                           <th>Tamanho</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php echo listarArquivos('privado', $DIR, $URL); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>

      <?php } ?>

      <?php } ?>

      <!-- Modal de Compartilhamento -->
      <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Compartilhar Reunião</h5>
                  <button type="button" title="Fechar" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"><i
                        class="bi bi-x-lg"></i></button>
               </div>
               <div class="modal-body">
                  <iframe src="/share?post_id=<?php echo $post_id; ?>"
                     style="width: 100%; height: 600px; border: none;"></iframe>
               </div>
            </div>
         </div>
      </div>


      <!-- Modal de Confirmação de Exclusão -->
      <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                  <button type="button" title="Fechar" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"><i
                        class="bi bi-x-lg"></i></button>
               </div>
               <div class="modal-body">
                  Tem certeza que deseja apagar este post ?
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <a href="<?php echo home_url('/?delete_post=' . $post_id . '&path=' . $path); ?>"
                     class="btn btn-danger">Apagar</a>
               </div>
            </div>
         </div>
      </div>

   </section>

   <?php } ?>

</main>

<?php get_footer(); ?>