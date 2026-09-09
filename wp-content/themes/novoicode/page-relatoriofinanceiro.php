<?php
get_header();
?>

<?php if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
    echo '<script>window.location.href = "/perfil";</script>'; ?>

<main id="main" class="main">
    <!-- ======= Page Title & Breadcrumbs ======= -->
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Relatório Financeiro do IC</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">
                        <?php
                        echo "<a href='/" . url_active()[1] . "'>" . url_active()[1] . "</a>";
                        ?>
                    </li>
                    <li class="breadcrumb-item active">
                        <?php
                        echo "<a href='/" . url_active()[1] . "/" . url_active()[2] . "'>" . url_active()[2] . "</a>";
                        ?>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="btn-editors">
            <a class="btn btn-light" href="/"><i class="bi bi-skip-backward-fill"></i>&ensp;Voltar</a>&emsp;
        </div>
    </div><!-- End Page Title & Breadcrumbs -->

    <section class="section">
        <style>
            #aceite {
                transform: scale(1.5);
            }
        </style>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <iframe src="https://app.powerbi.com/view?r=eyJrIjoiYzA2YmU0ODAtODY3YS00YWRiLTliMmYtYmMyOGNjYWI1YTg4IiwidCI6ImI0NzQxYTgyLTZiNmUtNDNhNS1hZDZlLTEwNDQ1MTFhYWVkNiJ9" style="border:none;height:1000px;width:100%;" title="Relatório Financeiro do IC"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->
<?php get_footer(); ?>