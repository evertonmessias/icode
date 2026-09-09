<?php
// Arquivo: /wp-content/themes/novoicode/page-modoia.php
get_header();
?>

<?php if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
    echo '<script>window.location.href = "/perfil";</script>'; ?>

<main id="main" class="main">

    <!-- React  -->
    <script src="<?php echo SITEPATH; ?>assets/js/react.js"></script>
    <script src="<?php echo SITEPATH; ?>assets/js/react-dom.js"></script>
    <script src="<?php echo SITEPATH; ?>assets/js/react-markdown.js"></script>

    <section class="section modoia">
        <div class="card">
            <div class="card-body">
                <div class="card-chat">
                    <div class="row">
                        <div class="col-12">                     
                            <h4 class="text-center">Fale com a <span class="text-primary">IA do ICODE</span></h4>
                            <div class="chat-container" id="app"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Front BOXs Section -->

    <!-- React  -->
    <script src="<?php echo SITEPATH; ?>assets/js/componentMD.js"></script>
    <script src="<?php echo SITEPATH; ?>assets/js/componentChats.js"></script>

</main><!-- End #main -->

<?php get_footer(); ?>