<?php
get_header();
?>

<?php if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
	echo '<script>window.location.href = "/perfil";</script>'; ?>

<main id="main" class="main">

	<?php
	$membro = get_user_meta(wp_get_current_user()->ID, 'membro', true);
	$is_admin = current_user_can('administrator');
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
										<?php echo print_type($current_type,'nome') ?></u></b>, consulte o Administrador.</h4>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php } else { ?>

		<!-- ======= Page Title & Breadcrumbs ======= -->
		<div class="pagetitle d-flex justify-content-between align-items-center">
			<div>
				<h1><i class="<?php echo print_type(url_active()[1],'icone'); ?>"></i>&ensp;<?php echo print_type(url_active()[1],'texto'); ?></h1>
				<nav>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/">Home</a></li>
						<li class="breadcrumb-item active">
							<a href="/<?php echo url_active()[1]; ?>"><?php echo print_type(url_active()[1],'nome'); ?></a>
						</li>
					</ol>
				</nav>
			</div>

		</div><!-- End Page Title & Breadcrumbs -->
		<!-- ======= Portfolio Section ======= -->
		<section class="section archive">
			<div class="row">
				<div class="col-lg-12">
					<div class="card border-0 shadow-lg">
						<div class="card-body p-4">
							<div class="card-title">Documentos <?php echo print_type(url_active()[1],'texto'); ?></div>
							<div class="row g-2" id="years-grid">
								<?php
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

								$year_init = intval($categorias[0]->name);
								$current_year = (int) date('Y');

								for ($year = $current_year; $year >= $year_init; $year--):
									$is_current = $year == $current_year;
									$badge_class = $is_current ? 'bg-danger' : 'bg-secondary';
									?>
									<div class="col-xl-1 col-lg-1 col-md-2 col-sm-3 col-4">
										<a href="/<?php echo url_active()[1] . '/' . $year; ?>"
											class="year-card text-decoration-none">
											<div class="card year-card border-0 shadow">
												<div class="card-body text-center p-2">
													<div class="year-icon mb-1">
														<i class="bi bi-archive-fill text-primary"></i>
													</div>
													<h6 class="card-title mb-0 <?php echo $is_current ? 'ano-atual' : 'ano-passado'; ?>" style="font-size: 0.85rem;">
														<?php echo $year; ?>
													</h6>											
												</div>
											</div>
										</a>
									</div>
								<?php endfor; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-12 membros">
					<div class="card p-4">
						<div class="card-body">
							<div class="card-title">Membros <?php echo print_type(url_active()[1],'texto'); ?> -
								<?php echo $current_year ?>
							</div>
							<div style="text-align: justify;">
								<?php
								echo apply_filters('the_content', do_shortcode('[icapi tipo="composicao_' . url_active()[1] . '" saida="html"]'));
								?>
							</div>
						</div>
					</div>
				</div>

			</div>

		</section><!-- End Portfolio Section -->

	<?php } ?>

</main><!-- End #main>

<?php get_footer();