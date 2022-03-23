<?php
if (!is_front_page() && !is_user_logged_in())wp_redirect(WP_HOME . "/wp-admin");
?>


<?php
  // ********************** Montar header para o portal
  $nav_menu_portal = true;
  $url_menu = "/";
  $title = get_option('portal_input_0');
  $post_color = get_option('portal_input_3');
  $logo = get_option('portal_input_2');
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $title; ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo $logo; ?>" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Arial:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo SITEPATH; ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo SITEPATH; ?>assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="<?php echo SITEPATH; ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo SITEPATH; ?>assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="<?php echo SITEPATH; ?>assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="<?php echo SITEPATH; ?>assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo SITEPATH; ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo SITEPATH; ?>assets/css/condep.css" rel="stylesheet">
  <style>
    .back-to-top i:hover,
    #topbar,
    #hero .btn-get-started,
    .featured-services .icon-box:hover::before,
    .counts .count-box i,
    .nav-menu>ul>li>a:before,
    .skills .progress-bar,
    .portfolio-details .portfolio-details-carousel .owl-dot.active,
    #footer .footer-newsletter form input[type="submit"],
    #footer .footer-top .social-links a,
    .php-email-form .button-send {
      background-color: <?php echo $post_color; ?>;
    }

    .contact .php-email-form button[type="submit"] {
      background-color: <?php echo $post_color; ?> !important;
    }

    .contact .php-email-form button[type="submit"]:hover {
      background-color: #ccc !important;
    }

    .services .icon-box:hover,
    .portfolio .portfolio-item:hover,
    .counts .box-registration:hover {
      box-shadow: 0px 0 5px 0 <?php echo $post_color; ?>;
    }

    #preloader:before {
      border-color: 6px solid <?php echo $post_color; ?>;
    }

    .contact .php-email-form input:focus,
    .contact .php-email-form textarea:focus,
    .services .icon-box:hover .icon {
      border-color: <?php echo $post_color; ?>;
    }

    a,
    #header .logo a span,
    .nav-menu a:hover,
    .nav-menu .active>a,
    .nav-menu li:hover>a,
    .nav-menu .drop-down ul a:hover,
    .nav-menu .drop-down ul .active>a,
    .nav-menu .drop-down ul li:hover>a,
    .mobile-nav a:hover,
    .mobile-nav .active>a,
    .mobile-nav li:hover>a,
    .section-title h2,
    .section-title h3 span,
    .featured-services .icon i,
    .about .content ul i,
    .services .icon-box:hover h4 a,
    .services .icon-box:hover .icon i,
    .portfolio #portfolio-flters li:hover,
    .portfolio #portfolio-flters li.filter-active,
    .portfolio .portfolio-item .portfolio-info .preview-link:hover,
    .portfolio .portfolio-item .portfolio-info .details-link:hover,
    .contact .info-box i,
    #footer .footer-top .footer-contact h3 span,
    #footer .footer-top .footer-links ul i,
    #footer .footer-top .footer-links ul a:hover,
    #topbar .search form input[type=submit] {
      color: <?php echo $post_color; ?>;
    }
  </style>
  <?php wp_head(); ?>
</head>

<body>
  <!-- ======= Top Bar ======= -->
  <div id="topbar" <?php if(is_user_logged_in())echo "style='margin-top:30px;'"; ?> class="d-none d-lg-flex align-items-center fixed-top">
    <div class="container d-flex">

      <div class="contact-info mr-auto">
        <?php if (get_option('portal_input_5') != "") { ?>
          <i class="icofont-envelope"></i>&ensp;<a href="mailto:<?php echo get_option('portal_input_5'); ?>"><?php echo get_option('portal_input_5'); ?></a>
        <?php } ?>
        &emsp;
        <?php if (get_option('portal_input_4') != "") { ?>
          <i class="bx bxl-whatsapp"></i>&ensp;<a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo get_option('portal_input_4'); ?>&text=CONDEP"><?php echo get_option('portal_input_4'); ?></a>
        <?php } ?>
      </div>

      <div class="search">
        <?php get_search_form() ?>
      </div>

      <div class="social-links">

        <a title="Login" href="/wp-admin"><i class="bx bxs-user"></i></a>
      </div>

    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" <?php if(is_user_logged_in())echo "style='margin-top:30px;'"; ?> class="fixed-top">
    <div class="container d-flex align-items-center">
      <h1 class="logo mr-auto"> 
        <a href="<?php echo $url_menu; ?>">
          <?php if ($logo != "") { ?>
            <img src="<?php echo $logo; ?>" title="<?php echo $title; ?>">
          <?php } ?>
          <span><?php echo $title; ?></span>
        </a> 
      </h1>
      <!-- Nav-Menu -->
      <nav class="nav-menu d-none d-lg-block">
        <div class="search">
          <?php echo get_search_form() ?>
        </div>
        <ul>         
          <li id="about"><a href="/#About">Sobre</a></li>
          <li id="congrega"><a href="/congrega">Congrega</a></li>
          <li id="ci"><a href="/ci">CI</a></li>
          <li id="dsc"><a href="/dsc">DSC</a></li>
          <li id="dsi"><a href="/dsi">DSI</a></li>
          <li id="dtc"><a href="/dtc">DTC</a></li>
        </ul>
      </nav>
      <!-- .nav-menu -->
    </div>
  </header><!-- End Header -->