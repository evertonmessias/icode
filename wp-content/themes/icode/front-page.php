<?php get_header(); ?>
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
				<?php if (get_option('portal_input_111') != "") { ?>
					<div class="carousel-item active" style="background-image: url('<?php echo get_option('portal_input_111'); ?>');">
						<div class="carousel-container">
							<div class="carousel-content container">
								<h2 class="animate__animated animate__fadeInDown"><?php echo get_option('portal_input_112') ?></h2>
								<p class="animate__animated animate__fadeInUp"><?php echo get_option('portal_input_113'); ?></p>
								<a href="<?php echo explode(",", get_option('portal_input_114'))[1]; ?>" class="btn-get-started animate__animated animate__fadeInUp scrollto"><?php echo explode(",", get_option('portal_input_114'))[0]; ?></a>
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
					<?php
					echo get_option('portal_input_7');
					?>
				</div>
			</div>
		</div>
		</div>
	</section><!-- End About Section -->

</main><!-- End #main -->
<?php get_footer(); ?>