<?php
// Arquivo: wp-content/plugins/novoicode/includes/src/frontend.php
// Theme ********************************************************************************************

// ************ styles_and_scripts_theme ************************************************************
function styles_theme()
{
  wp_enqueue_style('bootstrap', SITEPATH . 'assets/vendor/bootstrap/css/bootstrap.min.css');
  wp_enqueue_style('bootstrap-icons', SITEPATH . 'assets/vendor/bootstrap-icons/bootstrap-icons.css');
  wp_enqueue_style('boxicons', SITEPATH . 'assets/vendor/boxicons/css/boxicons.min.css');
  wp_enqueue_style('quill-snow', SITEPATH . 'assets/vendor/quill/quill.snow.css');
  wp_enqueue_style('quill-bubble', SITEPATH . 'assets/vendor/quill/quill.bubble.css');
  wp_enqueue_style('remixicon', SITEPATH . 'assets/vendor/remixicon/remixicon.css');
  wp_enqueue_style('simple-datatables', SITEPATH . 'assets/vendor/simple-datatables/style.css');
  wp_enqueue_style('font-awesome', SITEPATH . 'assets/vendor/font-awesome/css/font-awesome.min.css');

  // DataTables CSS CDN
  wp_enqueue_style('datatable-css', 'https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css', array(), '1.13.6');
  wp_enqueue_style('datatable-buttons-css', 'https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css', array(), '2.4.1');

  wp_enqueue_style('nicecss', SITEPATH . 'assets/css/style.css');
  wp_enqueue_style('novoicode', SITEPATH . 'assets/css/novoicode.css');

}
add_action('wp_enqueue_scripts', 'styles_theme');

function scripts_theme()
{
  wp_enqueue_script('apexcharts', SITEPATH . 'assets/vendor/apexcharts/apexcharts.min.js', array(), null, true);
  wp_enqueue_script('bundle', SITEPATH . 'assets/vendor/bootstrap/js/bootstrap.bundle.min.js', array('jquery'), null, true);
  wp_enqueue_script('chart', SITEPATH . 'assets/vendor/chart.js/chart.umd.js', array(), null, true);
  wp_enqueue_script('echarts', SITEPATH . 'assets/vendor/echarts/echarts.min.js', array(), null, true);
  wp_enqueue_script('quill', SITEPATH . 'assets/vendor/quill/quill.js', array(), null, true);
  wp_enqueue_script('datatables', SITEPATH . 'assets/vendor/simple-datatables/simple-datatables.js', array(), null, true);
  wp_enqueue_script('mail', SITEPATH . 'assets/vendor/php-email-form/validate.js', array(), null, true);

  // JSZip (requisito para exportar Excel)
  wp_enqueue_script('jszip', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js', array(), '3.10.1', true);

  // DataTables JS CDN com dependências e ordem correta
  wp_enqueue_script('datatable-js', 'https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js', array('jquery'), '1.13.6', true);
  wp_enqueue_script('datatable-buttons-js', 'https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js', array('datatable-js'), '2.4.1', true);
  wp_enqueue_script('datatable-buttons-html5-js', 'https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js', array('datatable-buttons-js', 'jszip'), '2.4.1', true);

}
add_action('wp_enqueue_scripts', 'scripts_theme');



// ***************** Add Media **************************************************************************
function load_media_files()
{
  wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'load_media_files');



// Criar/Editar post **************************************************************************
function handle_editar_post()
{
  if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    error_log('ID do post não foi passado ou não é válido.');
    wp_die('Erro: ID do post inválido.');
  }

  sleep(3);

  $post_id = intval($_POST['id']);
  $cat_slug = $_POST['cat'];
  $tipo = $_POST['tipo'];

  // Verifica se o post existe
  $post = get_post($post_id);

  // Se o post não existir, cria novo
  if ($post === null) {
    if (!isset($_POST['tipo'])) {
      error_log('Tipo de post não foi passado na criação.');
      wp_die('Erro: Tipo de post não especificado.');
    }

    $post_data = [
      'post_title' => sanitize_text_field($_POST['titulo']),
      'post_content' => wp_kses_post($_POST['conteudo']),
      'post_name' => sanitize_title($_POST['slug']),
      'post_type' => $tipo,
      'post_status' => 'publish',
      'post_author' => get_current_user_id(),
    ];

    $post_id = wp_insert_post($post_data);
    if (is_wp_error($post_id)) {
      error_log('Erro ao criar novo post: ' . $post_id->get_error_message());
      wp_redirect('/novo-post?erro=1');
      exit;
    }

    // Define a categoria do post
    if ($cat_slug) {
      $term = get_term_by('slug', $cat_slug, 'category');
      if ($term && !is_wp_error($term)) {
        wp_set_post_terms($post_id, array($term->term_id), 'category', false);
      }
    }

  } else {
    $tipo = get_post_type($post_id);
  }

  // Verifica campos obrigatórios
  if (!isset($_POST['titulo']) || !isset($_POST['conteudo']) || !isset($_POST['slug'])) {
    wp_die('Erro: Campos obrigatórios ausentes.');
  }

  // Atualiza o post existente
  $updated_post = [
    'ID' => $post_id,
    'post_title' => sanitize_text_field($_POST['titulo']),
    'post_content' => wp_kses_post($_POST['conteudo']),
    'post_name' => sanitize_title($_POST['slug']),
    'post_type' => $tipo,
  ];

  $updated = wp_update_post($updated_post, true);
  if (is_wp_error($updated)) {
    error_log('Erro ao atualizar o post: ' . $updated->get_error_message());
    wp_redirect('/editar?id=' . $post_id . '&erro=1');
    exit;
  }


  // Atualiza post_meta privado
  $privado = $_POST[$tipo . '_privado'] ?? '';
  update_post_meta($post_id, $tipo . '_privado', $privado);

  // Atualiza post_meta data
  $data = $_POST[$tipo . '_date'] ?? '';
  update_post_meta($post_id, $tipo . '_date', $data);

  // Atualiza post_meta membros
  $membros = $_POST[$tipo . '_member'] ?? '';
  update_post_meta($post_id, $tipo . '_member', $membros);


  // Cria os Diretórios: /uploads/{tipo}/{cat}/{id}/... se não existir
  $upload_dir = wp_upload_dir();
  $base_dir = $upload_dir['basedir'];
  $relative_path = "/$tipo/$cat_slug/$post_id";
  $DIR = $base_dir . $relative_path;

  $diretorios = ["$DIR/pautas", "$DIR/deliberacoes", "$DIR/ata", "$DIR/privado"];
  foreach ($diretorios as $diretorio) {
    if (!is_dir($diretorio)) {
      mkdir($diretorio, 0755, true);
    }
  }

  // Redireciona
  wp_redirect(get_permalink($post_id));
  exit;
}
add_action('admin_post_editar_post', 'handle_editar_post');



// Delete posts *****************************************************************************************
function handle_post_deletion()
{
  if (isset($_GET['delete_post']) && is_user_logged_in()) {

    $post_id = intval($_GET['delete_post']);

    $path = $_GET['path'];

    if (current_user_can('delete_post', $post_id)) {
      wp_delete_post($post_id, true);

      // Deleta a estrutura de diretórios
      delete_directory_recursively($path);

      wp_redirect(home_url('/?deleted=true'));
      exit;
    } else {
      wp_die('Você não tem permissão para deletar este post.');
    }
  }
}
add_action('init', 'handle_post_deletion');

// Função auxiliar para deletar diretórios recursivamente
function delete_directory_recursively($dir)
{
  if (!file_exists($dir))
    return;

  if (!is_dir($dir)) {
    unlink($dir); // se for um arquivo, deleta
    return;
  }

  $items = scandir($dir);
  foreach ($items as $item) {
    if ($item == '.' || $item == '..')
      continue;
    $path = $dir . DIRECTORY_SEPARATOR . $item;
    delete_directory_recursively($path);
  }

  rmdir($dir); // finalmente, remove o diretório vazio
}



// Perfil do Usuário **************************************************************************************
function handle_atualizar_perfil_usuario()
{
  if (!is_user_logged_in()) {
    wp_send_json_error(['message' => 'Usuário não autenticado']);
  }

  $current_user = wp_get_current_user();
  $response = ['success' => false];
  $erro = '';
  $sucesso = '';

  $novo_nome = isset($_POST['novo_nome']) ? sanitize_text_field($_POST['novo_nome']) : '';
  $novo_sobrenome = isset($_POST['novo_sobrenome']) ? sanitize_text_field($_POST['novo_sobrenome']) : '';

  $userdata = ['ID' => $current_user->ID];
  if ($novo_nome)
    $userdata['first_name'] = $novo_nome;
  if ($novo_sobrenome)
    $userdata['last_name'] = $novo_sobrenome;

  if (!empty($userdata['first_name']) || !empty($userdata['last_name'])) {
    wp_update_user($userdata);
    $sucesso .= 'Nome atualizado. ';
  }

  if (!empty($_FILES['novo_avatar']['name'])) {
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $file_type = wp_check_filetype($_FILES['novo_avatar']['name']);
    $allowed_types = ['jpg', 'jpeg', 'png'];

    if (in_array($file_type['ext'], $allowed_types)) {
      $attachment_id = media_handle_upload('novo_avatar', 0);
      if (!is_wp_error($attachment_id)) {
        update_user_meta($current_user->ID, 'wp_user_avatar', $attachment_id);
        $sucesso .= 'Avatar atualizado.';
        $avatar_url = wp_get_attachment_url($attachment_id);
        wp_send_json_success(['message' => $sucesso, 'avatar_url' => $avatar_url]);
      } else {
        $erro = 'Erro ao enviar avatar.';
        wp_send_json_error(['message' => $erro]);
      }
    } else {
      $erro = 'Formato de imagem inválido.';
      wp_send_json_error(['message' => $erro]);
    }
  }

  if ($sucesso) {
    wp_send_json_success(['message' => $sucesso]);
  } else {
    wp_send_json_error(['message' => 'Nada foi alterado.']);
  }
}
add_action('wp_ajax_atualizar_perfil_usuario', 'handle_atualizar_perfil_usuario');



// Salva a hora da última atividade do usuário logado *******************************************************
add_action('init', function () {
  if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    update_user_meta($user_id, 'last_active', current_time('timestamp'));
  }
});


// Função que retorna os usuários considerados "online" *******************************************************
function get_users_online($minutes = 5)
{
  $online_users = [];
  $users = get_users([
    'meta_key' => 'last_active',
    'meta_compare' => 'EXISTS'
  ]);

  $now = current_time('timestamp');
  $threshold = $now - ($minutes * 60); // últimos X minutos

  foreach ($users as $user) {
    $last_active = (int) get_user_meta($user->ID, 'last_active', true);
    if ($last_active >= $threshold) {
      $online_users[] = $user;
    }
  }

  return $online_users;
}


//************* URL from breadcrumbs  *****************************************************************
function url_active()
{
  return explode("/", $_SERVER['REQUEST_URI']);
}
add_action('url_active', 'url_active');




//************* Remove tags support from posts  *****************************************************************
function myprefix_unregister_tags()
{
  unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'myprefix_unregister_tags');




//************* Add thumbnails *******************************************************************************
add_theme_support('post-thumbnails', array('post'));



//************* Pagina Pessoas  **********************************************************************
function table_docentes()
{
  $site_docentes = json_decode(lista_docentes_intranet());
  $tab = "";
  foreach ($site_docentes as $site_docente) {
    if (isset($site_docente->email) && $site_docente->cargo != "") {
      $tab .= "<tr>"
        . "<td><img class='avatar' src='" . $site_docente->photo_url . "'/></td>"
        . "<td>" . $site_docente->nome . "</td>"
        . "<td>" . $site_docente->departamento . "</td>"
        . "<td><a href='mailto:" . $site_docente->email . "'>" . $site_docente->email . "</a></td>"
        . "</tr>";
    }
  }
  return $tab;
}
add_action("table_docentes", "table_docentes");

function table_funcionarios()
{
  $site_funcionarios = json_decode(lista_funcionarios_intranet());
  $tab = "";
  foreach ($site_funcionarios as $site_funcionario) {
    $tab .= "<tr>"
      . "<td><img class='avatar' src='" . $site_funcionario->photo_url . "'/></td>"
      . "<td>" . $site_funcionario->nome . "</td>"
      . "<td>" . traduz_papel(papel_usuario($site_funcionario->email)) . "</td>"
      . "<td><a href='mailto:" . $site_funcionario->email . "'>" . $site_funcionario->email . "</a></td>"
      . "</tr>";
  }
  return $tab;
}
add_action("table_funcionarios", "table_funcionarios");



//************* Dados do Grafico de Acessos *****************************************************************
function chart_data($saida)
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'acessos';
  $sql = "SELECT `url`,COUNT(*) as `count` FROM $table_name GROUP BY `url` ORDER BY `count` DESC;";
  $results = $wpdb->get_results($sql);
  $urls = "";
  $counts = "";
  $x = 0;
  foreach ($results as $data) {
    if ($data->url != "/" && $x < 10) {
      $urls .= "'" . substr($data->url, 0, -1) . "',";
      $counts .= $data->count . ",";
      $x++;
    }
  }
  $urls = substr($urls, 0, -1);
  $counts = substr($counts, 0, -1);

  if ($saida == "url") {
    $resposta = $urls;
  } elseif ($saida == "count") {
    $resposta = $counts;
  } else {
    $resposta = "erro";
  }

  return $resposta;
}
add_action("chart_data", "chart_data");


// Print Types *********************************************************************
function print_type($slug, $saida)
{
  $resposta = "";
  $slug_array = explode(',', get_option('portal_input_7'));
  $indice = array_search($slug, $slug_array);

  if ($saida == "nome") { //retorna o nome
    $nomes_array = explode(',', get_option('portal_input_6'));
    $resposta = $nomes_array[$indice];
  } elseif ($saida == "icone") { //retorna o icone
    $icones_array = explode(',', get_option('portal_input_8'));
    $resposta = $icones_array[$indice];
  } elseif ($saida == "texto") { //retorna o texto
    $textos_array = explode(',', get_option('portal_input_9'));
    $resposta = $textos_array[$indice];
  } else {
    $resposta = "ERRO";
  }
  return $resposta;
}


// Calendario *******************************************************************************
function mostrar_calendario($site)
{
  if ($site == 'cdi') {
    $saida = "Calendário sob demanda";
  } else {

    $conteudo_intranet = INTRANET . '/calendario/json?src=' . $site;

    // URL da fonte
    $url = file_get_contents($conteudo_intranet);

    // Decodificando o JSON em um array
    $data = json_decode($url, true);

    // Verificando se há dados para exibir
    if (!empty($data['data'])) {
      // Iniciando a tabela
      $html = '<table class="table table-bordered table-striped">';
      $html .= '<thead><tr>';
      $html .= '<th style="width:33%">Reunião</th>';
      $html .= '<th style="width:33%">Limite para inclusão de assuntos</th>';
      $html .= '<th style="width:33%">Disponibilização das Pautas</th>';
      $html .= '</tr></thead><tbody>';

      // Preenchendo a tabela com os dados
      foreach ($data['data'] as $evento) {
        $html .= '<tr>';
        $html .= '<td>' . date('d/m/Y', strtotime($evento['reu'])) . '</td>';
        $html .= '<td>' . date('d/m/Y', strtotime($evento['lim'])) . '</td>';
        $html .= '<td>' . date('d/m/Y', strtotime($evento['dis'])) . '</td>';
        $html .= '</tr>';
      }
      $html .= '</tbody></table>';
    } else {
      $html = 'Nenhum dado encontrado.';
    }
    $saida = $html . "<br><small class='fonte'><b>Fonte</b>:&ensp;<a href='" . $conteudo_intranet . "' target='_blank'>" . $conteudo_intranet . "</a></small>";
  }
  return $saida;
}
add_action('mostrar_calendario', 'mostrar_calendario');




// Envia email convocação ************************************************************************
function ajax_enviar_email_convocacao()
{
  if (!current_user_can('read')) {
    wp_send_json_error(['mensagem' => 'Permissão negada']);
  }

  $post_id = intval($_POST['post_id']);
  $post = get_post($post_id);
  $post_type = get_post_type($post);

  $email_para = sanitize_text_field($_POST['email']);
  $email_remetente = sanitize_email($_POST['remetente']);
  $email_assunto = $_POST['title'];
  $descricao = wp_kses_post(stripslashes($_POST['descricao']));

  // Função para converter URLs relativas em absolutas
  function converter_urls_absolutas($content) {
    $site_url = site_url();
    
    // Converte URLs que começam com / (incluindo /wp-content/)
    $content = preg_replace(
      '/(href|src)=["\']\/([^"\']*)["\']/i',
      '$1="' . $site_url . '/$2"',
      $content
    );
    
    return $content;
  }

  // Aplica o filtro de conversão de URLs
  $conteudo_membros = converter_urls_absolutas(apply_filters('the_content', get_post_meta($post_id, $post_type . '_member', true)));
  $conteudo_post = converter_urls_absolutas(apply_filters('the_content', $post->post_content));
  $descricao = converter_urls_absolutas($descricao);

  $mensagem = "
        <div style='font-family: sans-serif;'>
            <div>{$descricao}</div>
            <br><hr><br>
            <div>{$conteudo_membros}</div>
            <br><hr><br>
            <div>{$conteudo_post}</div>
        </div>
    ";

  $headers = array(
    'Content-Type: text/html; charset=UTF-8',
    'From: ' . $email_remetente,
    'Reply-To: ' . $email_remetente,
  );

  $enviado = wp_mail($email_para, $email_assunto, $mensagem, $headers);

  if ($enviado) {
    echo '<div class="alert alert-success">Mensagem enviada com sucesso!</div>';
  } else {
    echo '<div class="alert alert-danger">Erro ao enviar a mensagem.</div>';
  }
  
  wp_die(); // Importante para finalizar corretamente
}
add_action('wp_ajax_enviar_email_convocacao', 'ajax_enviar_email_convocacao');




//  Corrigir links de arquivos no post html  ************************************************************


add_action('wp_ajax_corrigir_links_arquivos', 'corrigir_links_arquivos');
function corrigir_links_arquivos()
{
  if (!isset($_POST['post_id'], $_POST['tipo'], $_POST['ano'], $_POST['conteudo'])) {
    wp_die('Parâmetros insuficientes');
  }

  $post_id = intval($_POST['post_id']);
  $tipo = sanitize_text_field($_POST['tipo']);
  $ano = sanitize_text_field($_POST['ano']);
  $conteudo = stripslashes($_POST['conteudo']);

  if (!current_user_can('edit_post', $post_id)) {
    wp_die('Sem permissão');
  }

  // Configuração de diretórios
  $base_dir = ABSPATH . "wp-content/uploads/$tipo/$ano/$post_id";
  $subdiretorios = ['pautas', 'deliberacoes', 'ata', 'privado'];
  $alteracoes = 0;
  $remocoes = 0;

  // Usar DOMDocument para manipulação segura do HTML
  $dom = new DOMDocument();
  libxml_use_internal_errors(true);

  $conteudo = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $conteudo . '</body></html>';

  $dom->loadHTML(mb_convert_encoding($conteudo, 'HTML-ENTITIES', 'UTF-8'));
  libxml_clear_errors();

  $links = $dom->getElementsByTagName('a');
  $links_para_processar = [];

  // Primeiro coletamos todos os links para processar
  foreach ($links as $link) {
    $links_para_processar[] = $link;
  }

  // Processamos cada link
  foreach ($links_para_processar as $link) {
    $href = $link->getAttribute('href');
    $parent = $link->parentNode;

    // Verificar se é um link para um arquivo (PDF ou dentro de uploads)
    $is_pdf = preg_match('/\.pdf$/i', $href);
    $is_in_uploads = strpos($href, '/wp-content/uploads/') !== false;

    if ($is_pdf || $is_in_uploads) {
      // Extrair o nome do arquivo
      $path = parse_url($href, PHP_URL_PATH);
      $nome_arquivo = basename($path);

      // Remover query strings e fragmentos
      $nome_arquivo = preg_replace('/[?#].*/', '', $nome_arquivo);

      // Decodificar URL (remover %20 etc)
      $nome_arquivo_decodificado = urldecode($nome_arquivo);

      // Se não terminar com .pdf, adicionar
      if (!preg_match('/\.pdf$/i', $nome_arquivo_decodificado)) {
        $nome_arquivo_decodificado .= '.pdf';
      }

      // Criar versões para busca aproximada (remover caracteres especiais e espaços)
      $nome_limpo = preg_replace('/[^a-zA-Z0-9]/', '', $nome_arquivo_decodificado);
      $nome_limpo = strtolower($nome_limpo);

      $arquivo_encontrado = null;
      $subdir_encontrado = null;

      // Verificar se o arquivo existe em algum subdiretório
      foreach ($subdiretorios as $subdir) {
        $dir_path = "$base_dir/$subdir";

        if (!file_exists($dir_path))
          continue;

        // Ler diretório e buscar arquivos com nome similar
        $files = scandir($dir_path);

        foreach ($files as $file) {
          if ($file === '.' || $file === '..')
            continue;

          // Criar versão limpa do nome do arquivo para comparação
          $file_limpo = preg_replace('/[^a-zA-Z0-9]/', '', $file);
          $file_limpo = strtolower($file_limpo);

          // Verificar similaridade (90% ou mais)
          similar_text($nome_limpo, $file_limpo, $percent);

          if ($percent >= 90) {
            $arquivo_encontrado = $file;
            $subdir_encontrado = $subdir;
            break 2; // Sair dos dois loops
          }
        }
      }

      if ($subdir_encontrado) {
        // Arquivo encontrado - atualizar link
        $novo_href = "/wp-content/uploads/$tipo/$ano/$post_id/$subdir_encontrado/" . rawurlencode($arquivo_encontrado);

        $link->setAttribute('href', $novo_href);
        $link->setAttribute('target', '_blank');

        // --- VERIFICAR SE O ARQUIVO ESTÁ EM "PRIVADO" ANTES DE ADICIONAR MARCAÇÃO ---
        if ($subdir_encontrado === 'privado') {
          // Verificar se já não existe "(para membros)" antes do link
          $ja_tem_small = false;
          $previous = $link->previousSibling;

          while ($previous) {
            if ($previous->nodeName === 'small' && strpos($previous->getAttribute('class'), 'itemprivado') !== false) {
              $ja_tem_small = true;
              break;
            }
            $previous = $previous->previousSibling;
          }

          if (!$ja_tem_small) {
            // Criar o small
            $small = $dom->createElement('small', '(para membros)');
            $small->setAttribute('class', 'itemprivado');

            // Criar espaço
            $espaco = $dom->createTextNode(' ');

            // Inserir o small e o espaço antes do link
            $parent->insertBefore($espaco, $link);
            $parent->insertBefore($small, $espaco);
          }
        } else {
          // --- REMOVER MARCAÇÃO "(para membros)" SE O ARQUIVO NÃO ESTIVER MAIS EM "PRIVADO" ---
          $previous = $link->previousSibling;
          while ($previous) {
            $temp = $previous->previousSibling;
            if ($previous->nodeName === 'small' && strpos($previous->getAttribute('class'), 'itemprivado') !== false) {
              $parent->removeChild($previous);
            }
            $previous = $temp;
          }
        }

        $alteracoes++;
      } else {
        // Arquivo não encontrado - remover o nó do link
        if ($parent) {
          // Se o link é o único conteúdo do pai, remover o pai inteiro
          $has_other_content = false;
          foreach ($parent->childNodes as $child) {
            if ($child->nodeName !== '#text' || trim($child->nodeValue) !== '') {
              if ($child !== $link) {
                $has_other_content = true;
                break;
              }
            }
          }

          if (!$has_other_content) {
            $parent->parentNode->removeChild($parent);
            $remocoes++;
          } else {
            // Se há outros conteúdos, apenas remover o link
            $parent->removeChild($link);
            $remocoes++;
          }
        }
      }
    }
  }

  $body = $dom->getElementsByTagName('body')->item(0);
  $html_corrigido = '';
  foreach ($body->childNodes as $node) {
    $html_corrigido .= $dom->saveHTML($node);
  }

  echo json_encode([
    'content' => $html_corrigido,
    'changes' => $alteracoes,
    'removals' => $remocoes,
    'debug' => "Processado com sucesso. Links modificados: $alteracoes, Elementos removidos: $remocoes"
  ]);

  wp_die();
}



// Google reCAPTCHA **********************************************************************************

/*

function adicionar_recaptcha_login()
{
  ?>
  <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_V3_SITE_KEY ?>"></script>
  <script>
    grecaptcha.ready(function () {
      grecaptcha.execute('<?php echo RECAPTCHA_V3_SITE_KEY ?>', { action: 'login' }).then(function (token) {
        var recaptchaResponse = document.getElementById('recaptchaResponse');
        recaptchaResponse.value = token;
      });
    });
  </script>
  <?php
}
add_action('login_form', 'adicionar_recaptcha_login');

/**
 * Verifica o token do reCAPTCHA v3 no login.
 */

/*
function verificar_recaptcha_login($user, $password)
{
  // Verifica se houve uma tentativa de login (dados POST foram enviados)
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
    $recaptcha_secret = RECAPTCHA_V3_SECRET_KEY;
    $recaptcha_response = $_POST['recaptcha_response'];
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = array(
      'secret' => $recaptcha_secret,
      'response' => $recaptcha_response
    );
    $recaptcha_options = array(
      'http' => array(
        'method' => 'POST',
        'content' => http_build_query($recaptcha_data)
      )
    );
    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = json_decode(file_get_contents($recaptcha_url, false, $recaptcha_context));

    if (!$recaptcha_result->success || $recaptcha_result->score < 0.5) {
      return new WP_Error('recaptcha_error', __('<strong>ERRO</strong>: A verificação do reCAPTCHA falhou. Por favor, tente novamente.'));
    }
  }
  // Se não houver erro ou não for uma requisição POST com recaptcha_response, retorne o $user original.
  return $user;
}
add_filter('authenticate', 'verificar_recaptcha_login', 30, 2);

*/

// ORDER **********************************************************************************

// Função para salvar ordenação de arquivos via AJAX
add_action('wp_ajax_salvar_ordenacao_arquivos', 'salvar_ordenacao_arquivos');
function salvar_ordenacao_arquivos()
{
    // Log para debug
    error_log('=== INICIANDO SALVAR_ORDENACAO_ARQUIVOS ===');
    error_log('POST data: ' . print_r($_POST, true));

    // Verificar nonce para segurança
    if (!wp_verify_nonce($_POST['nonce'], 'salvar_ordenacao_nonce')) {
        error_log('Nonce verification failed');
        wp_die('Não autorizado');
    }

    // Verificar se o usuário tem permissão (editor ou administrador)
    if (!current_user_can('edit_posts')) {
        error_log('User does not have permission');
        wp_die('Sem permissão');
    }

    $post_id = intval($_POST['post_id']);
    $subpasta = sanitize_text_field($_POST['subpasta']);
    $ordenacao = json_decode(stripslashes($_POST['ordenacao']), true);

    error_log("Post ID: $post_id, Subpasta: $subpasta");
    error_log("Ordenação: " . print_r($ordenacao, true));

    if (!$post_id || !$subpasta || !is_array($ordenacao)) {
        error_log('Dados inválidos');
        wp_send_json_error('Dados inválidos');
    }

    // Obter informações do post
    $post = get_post($post_id);
    if (!$post) {
        error_log('Post não encontrado');
        wp_send_json_error('Post não encontrado');
    }

    $post_type = $post->post_type;
    $categories = get_the_category($post_id);
    
    if (empty($categories)) {
        error_log('Categoria não encontrada');
        wp_send_json_error('Categoria não encontrada');
    }
    
    $category = $categories[0]->slug; // Usar slug que é mais confiável

    $upload_dir = wp_upload_dir();
    $base_dir = $upload_dir['basedir'];
    $relative_path = "/$post_type/$category/$post_id";
    $caminho = "$base_dir$relative_path/$subpasta";

    error_log("Caminho completo: $caminho");

    // Verificar se o diretório existe
    if (!is_dir($caminho)) {
        error_log('Diretório não encontrado: ' . $caminho);
        wp_send_json_error('Diretório não encontrado: ' . $caminho);
    }

    // Verificar permissões de escrita
    if (!is_writable($caminho)) {
        error_log('Diretório não tem permissão de escrita: ' . $caminho);
        wp_send_json_error('Diretório não tem permissão de escrita');
    }

    // Salvar a ordenação no arquivo .order.ini
    $arquivo_ordenacao = "$caminho/.order.ini";
    
    // Tentar criar o arquivo
    $resultado = file_put_contents($arquivo_ordenacao, serialize($ordenacao));

    if ($resultado !== false) {
        error_log('Arquivo .order.ini criado com sucesso: ' . $arquivo_ordenacao);
        error_log('Conteúdo salvo: ' . print_r($ordenacao, true));
        wp_send_json_success('Ordenação salva com sucesso');
    } else {
        error_log('Erro ao salvar arquivo .order.ini');
        $error = error_get_last();
        error_log('Último erro: ' . print_r($error, true));
        wp_send_json_error('Erro ao salvar ordenação: ' . $error['message']);
    }
}