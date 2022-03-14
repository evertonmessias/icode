<?php get_header(); ?>
<main id="main" class="post" data-aos="fade-up">
	<!-- ======= Breadcrumbs ======= -->
	<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2>congrega</h2>
				<ol>
					<li><a href="/">home</a></li>
					<li>
						<?php
						if (url_active()[2] == "") echo url_active()[1];
						else echo "<a href='/" . url_active()[1] . "'>" . url_active()[1] . "</a>";
						?>
					</li>
					<!--<li>
            <?php //if (url_active()[2] != "") echo url_active()[2]; 
			?>
          </li>-->
				</ol>
			</div>
		</div>
	</section><!-- Breadcrumbs Section -->

	<!-- ======= Portfolio Section ======= -->
	<section id="congrega" class="portfolio">
		<div id="grid-congrega" class="container" data-aos="fade-up">
			<?php
			$argt = array(
				'orderby' => 'title',
				'order' => 'DESC'
			);
			$categories = get_terms('congrega_categories', $argt);
			?>
			<div class="row" data-aos="fade-up" data-aos-delay="100">
				<div class="col-12">
					<input type="text" class="quicksearch" placeholder="Filtrar" />
				</div>
				<h4>&nbsp;</h4>
				<div class="col-lg-12 d-flex justify-content-center">
					<ul id="portfolio-flters" class="portfolio-ul">
						<a href="/congrega">
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
						'post_type' => 'congrega',
						'congrega_categories' => $category->slug,
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

</main><!-- End #main -->
<?php get_footer(); ?>