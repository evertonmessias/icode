<?php
// Arquivo: /wp-content/themes/novoicode/header.php

registerdb(wp_get_current_user()->user_login, $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI']);

// Obter nomes, slugs e ícones dinamicamente
$nomes_array = explode(',', get_option('portal_input_6'));
$nomes_array = array_map('trim', $nomes_array);

$slugs_array = explode(',', get_option('portal_input_7'));
$slugs_array = array_map('trim', $slugs_array);

$icons_array = explode(',', get_option('portal_input_8'));
$icons_array = array_map('trim', $icons_array);

// Função para gerar links dos tipos
function generate_type_links($membro, $nomes_array, $slugs_array, $icons_array, $current_year, $location = 'header')
{
  $links = '';
  $is_admin = current_user_can('administrator');

  foreach ($slugs_array as $index => $slug) {
    // Se for admin OU se for membro do tipo
    if ($is_admin || (is_array($membro) && in_array($slug, $membro))) {
      $nome = isset($nomes_array[$index]) ? $nomes_array[$index] : ucfirst($slug);
      $title = print_type($slug, 'texto');
      $icon_class = isset($icons_array[$index]) ? $icons_array[$index] : 'bi bi-person';

      if ($location === 'header') {
        $links .= '<a title="' . $title . '" href="/' . $slug . '/' . $current_year . '"><i class="' . $icon_class . '"></i><span>' . $nome . '</span></a>';
      } else { // sidebar
        $links .= '<li class="nav-item">
                    <a class="nav-link collapsed" href="/' . $slug . '/">
                        <i class="' . $icon_class . '"></i>
                        <span>' . $nome . '</span>
                    </a>
                </li>';
      }
    }
  }

  return $links;
}

// Função para obter nome e ícone pelo slug
function get_type_info_by_slug($slug, $nomes_array, $slugs_array, $icons_array)
{
  $index = array_search($slug, $slugs_array);
  if ($index !== false) {
    return [
      'nome' => isset($nomes_array[$index]) ? $nomes_array[$index] : ucfirst($slug),
      'icon' => isset($icons_array[$index]) ? $icons_array[$index] : 'bi bi-person'
    ];
  }
  return [
    'nome' => ucfirst($slug),
    'icon' => 'bi bi-person'
  ];
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $title; ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="<?php echo get_option('portal_input_1'); ?>" rel="icon">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <?php wp_head(); ?>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <img src="<?php echo get_option('portal_input_1'); ?>" alt="">
        <span class="d-none d-lg-block"><?php echo get_option('portal_input_0'); ?></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <?php
      $current_slug = url_active()[1];
      if (in_array($current_slug, $slugs_array)) {
        $type_info = get_type_info_by_slug($current_slug, $nomes_array, $slugs_array, $icons_array);
        ?>
        <form class="search-form d-flex align-items-center" method="get" action="/<?php echo $current_slug; ?>/">
          <i class="<?php echo $type_info['icon']; ?> me-2"></i>
          <input type="text" required name="s" id="search" placeholder="Pesquisar em <?php echo $type_info['nome']; ?>"
            title="Pesquisar" value="<?php the_search_query(); ?>" />
          <button type="submit" title="Pesquisar"><i class="bi bi-search"></i></button>
        </form>
      <?php } ?>
    </div><!-- End Search Bar -->

    <?php
    $current_year = (string) date('Y');
    $user = wp_get_current_user();
    $saved_aceite = get_user_meta($user->ID, 'aceite', true);
    $membro = get_user_meta(wp_get_current_user()->ID, 'membro', true);

    if (!empty($saved_aceite)) {
      ?>
      <div class="icon-bar">
        <?php echo generate_type_links($membro, $nomes_array, $slugs_array, $icons_array, $current_year, 'header'); ?>
      </div>
    <?php } ?>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <?php if (is_user_logged_in()) {
          $user_name = $user->display_name;
          $user_login = $user->user_login;
          $avatar_id = get_user_meta($user->ID, 'wp_user_avatar', true);
          if ($avatar_id) {
            $user_avatar = wp_get_attachment_url($avatar_id);
          } else {
            $user_avatar = get_avatar_url($user->ID);
          }
          ?>
          <li class="nav-item dropdown pe-3">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
              <img src="<?php echo $user_avatar ?>" alt="Profile" class="rounded-circle">
              <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $user_login ?></span>
            </a><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
                <h6><?php echo $user_name ?></h6>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>

              <li>
                <a class="dropdown-item d-flex align-items-center" href="/perfil">
                  <i class="bi bi-person"></i>
                  <span>Meu Perfil</span>
                </a>
              </li>

              <li>
                <hr class="dropdown-divider">
              </li>

              <?php if (current_user_can('administrator')) { ?>
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="/wp-admin">
                    <i class="bi bi-wordpress"></i>
                    <span>Painel WP</span>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
              <?php } ?>

              <li>
                <a class="dropdown-item d-flex align-items-center"
                  href="<?php echo esc_url(site_url('?icode_logout=1')); ?>">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sair</span>
                </a>
              </li>

            </ul><!-- End Profile Dropdown Items -->
          </li><!-- End Profile Nav -->

        <?php } ?>

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->

  <?php if (!empty($saved_aceite)) { ?>

    <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
          <a class="nav-link collapsed" href="/">
            <i class="bi bi-search"></i>
            <span>Busca Avançada</span>
          </a>
        </li>
        
        <?php if (current_user_can('administrator')) { ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="/modoia">
            <i class="bi bi-robot"></i>
            <span>Modo IA</span>
          </a>
        </li>  
        <?php } ?>       

        <li class="nav-heading">
          <hr>
        </li>

        <?php echo generate_type_links($membro, $nomes_array, $slugs_array, $icons_array, $current_year, 'sidebar'); ?>

        <li class="nav-heading">
          <hr>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="/calendarios">
            <i class="bi bi-calendar"></i>
            <span>Calendários</span>
          </a>
        </li><!-- End Calendários -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="/perfil">
            <i class="bi bi-person"></i>
            <span>Perfil</span>
          </a>
        </li><!-- End Perfil -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="/pessoas">
            <i class="bi bi-person-fill"></i>
            <span>Pessoas</span>
          </a>
        </li><!-- End Pessoas -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="/relatoriofinanceiro">
            <i class="bi bi-wallet2"></i>
            <span>Financeiro</span>
          </a>
        </li><!-- End Financeiro -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="/sobre">
            <i class="bi bi-code-square"></i>
            <span>Sobre</span>
          </a>
        </li><!-- End Sobre -->

        <li class="nav-item">
          <a class="nav-link collapsed" target="_blank" href="/arquivos">
            <i class="bi bi-filetype-pdf"></i>
            <span>Arquivos</span>
          </a>
        </li><!-- End Arquivos -->

      </ul>

      <?php if (current_user_can('administrator') || current_user_can('editor')) { ?>
        <ul class="sidebar-nav">
          <li class="nav-heading">
            <hr>Usuários Online:
          </li>
          <?php
          $usuarios_online = get_users_online();
          foreach ($usuarios_online as $usuario) {
            $username = esc_html($usuario->user_login);
            $online_avatar_id = get_user_meta($usuario->ID, 'wp_user_avatar', true);
            if ($online_avatar_id) {
              $online_user_avatar = wp_get_attachment_url($online_avatar_id);
            } else {
              $online_user_avatar = get_avatar_url($usuario->ID);
            }
            ?>
            <li class="nav-item">
              <div class="nav-link collapsed d-flex align-items-center">
                <img src="<?php echo $online_user_avatar; ?>" class="user-avatar-online" alt="">
                <span><?php echo $username; ?></span>
              </div>
            </li>
          <?php } ?>
        </ul>
      <?php } ?>

    </aside><!-- End Sidebar-->

  <?php } ?>