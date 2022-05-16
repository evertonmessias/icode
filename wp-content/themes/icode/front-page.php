<?php get_header(); ?>

<?php
if ($_SERVER['REMOTE_ADDR'] != "143.106.16.179") {
	registerdb($_SERVER['REMOTE_ADDR']);
}
?>

<?php if(get_current_blog_id() == 1){ ?>

<!-- ======= Hero Section ======= -->
<section id="hero">
	<div class="hero-container">
		<div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">

			<ol class="carousel-indicators" id="hero-carousel-indicators">
				<li data-target="#heroCarousel" data-slide-to="0" class=""></li>
				<li data-target="#heroCarousel" data-slide-to="1" class=""></li>
				<li data-target="#heroCarousel" data-slide-to="2" class=""></li>
			</ol>

			<div class="carousel-inner" role="listbox">
				
				<!-- Slide -->
				<?php if (get_option('portal_input_3') != "") { ?>
					<div class="carousel-item active" style="background-image: url('<?php echo get_option('portal_input_3'); ?>');">
						<div class="carousel-container">
							<div class="carousel-content container">
								<h2 class="animate__animated animate__fadeInDown"><?php echo get_option('portal_input_4') ?></h2>
								<p class="animate__animated animate__fadeInUp"><?php echo get_option('portal_input_5'); ?></p>
								<a href="<?php echo explode(",", get_option('portal_input_6'))[1]; ?>" class="btn-get-started animate__animated animate__fadeInUp scrollto"><?php echo explode(",", get_option('portal_input_6'))[0]; ?></a>
							</div>
						</div>
					</div>
				<?php } ?>

			</div>

			<a class="carousel-control-prev" title="Previous" href="#heroCarousel" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon icofont-rounded-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" title="Next" href="#heroCarousel" role="button" data-slide="next">
				<span class="carousel-control-next-icon icofont-rounded-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>

		</div>
	</div>
</section><!-- End Hero -->

<main id="main">

	<!-- ======= About Sibgrapi ======= -->
	<section id="About" class="about">
		<div class="container" data-aos="fade-up">
			<div class="section-title">
				<h2>Sobre</h2>
			</div>
			<div class="row">
				<div class="col-lg-12 pt-4 pt-lg-0" data-aos="fade-up" data-aos-delay="100">
					<?php echo get_option('portal_input_7'); ?>
					<br>
					<hr>
					<br>
					<h3>Departamentos:</h3>					
					<?php //echo do_shortcode('[icapi1]'); ?>
					<br><br>
					<?php echo do_shortcode('[icapi2]'); ?>
					<br><br>
					<?php echo do_shortcode('[icapi3]'); ?>
					<br><br>
					<?php echo do_shortcode('[icapi4]'); ?>
					<br>
					<small>Fonte:&ensp;<a href="https://intranet.ic.unicamp.br" target="_blank">intranet.ic.unicamp.br</a></small>
				</div>
			</div>
		</div>
		</div>
	</section><!-- End About Section -->

</main><!-- End #main -->

<?php }else{ ?>

	<!-- ======= Portfolio Section ======= -->
	<h1>&nbsp;</h1><h1>&nbsp;</h1><h1>&nbsp;</h1>
	<section id="congrega" class="portfolio">
		<div id="grid-congrega" class="container" data-aos="fade-up">
			<?php
			$argt = array(
				'orderby' => 'title',
				'order' => 'DESC'
			);
			$categories = get_terms('category', $argt);
			?>
			<div class="row" data-aos="fade-up" data-aos-delay="100">
				<div class="col-12">
					<input type="text" class="quicksearch" placeholder="Filtrar" />
				</div>
				<h4>&nbsp;</h4>
				<div class="col-lg-12 d-flex justify-content-center">
					<ul id="portfolio-flters" class="portfolio-ul">
						<a href="/<?php echo url_active()[1]; ?>">
							<li class="filter-active">Todos</li>
						</a>
						<?php
						foreach ($categories as $category) {
						?>
							<li onclick="filtro(<?php echo $category->slug; ?>);" data-filter=".filter-<?php echo $category->slug; ?>"><?php echo $category->name; ?></li>
						<?php
						} ?>
					</ul>
				</div>
			</div>
			<br>
			<?php foreach ($categories as $category) { ?>
				<div id="<?php echo $category->slug; ?>" class="row grid-congrega portfolio-container">
					<strong class="title-cat"><?php echo $category->name; ?></strong>
					<?php
					$args = array(
						'post_type' => 'post',
						'category_name' => $category->slug,
						'posts_per_page' => 500
					);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) {
						$loop->the_post();
						if(get_post_meta($post->ID, 'congrega_date', true) != ""){
						$cdata = explode('T',get_post_meta($post->ID, 'congrega_date', true));
						$hora = $cdata[1];
						$data = explode('-',$cdata[0]);
					}						
					?>
						<div class="congrega-item col-lg-12 portfolio-item filter-<?php echo $category->slug; ?>">
							<div class="col-lg-2 col-congrega col-congrega1">
								<?php 
								if(get_post_meta($post->ID, 'congrega_date', true) != ""){
												echo $data[2]."/".$data[1]."/".$data[0]." ".$hora."H";
								}
								?>
							</div>
							<div class="col-lg-10 col-congrega col-congrega2">
								<a href="<?php the_permalink() ?>" class="details-link" title="Link">
									<strong><?php the_title() ?></strong>
								</a>
							</div>
						</div>
					<?php }
					wp_reset_postdata(); ?>
				</div>
			<?php } ?>
		</div>
	</section><!-- End Portfolio Section -->


<?php } ?>

<?php get_footer(); ?>