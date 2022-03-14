<?php get_header(); ?>
<main id="main" class="page page-portfolio" data-aos="fade-up">
   <!-- ======= Breadcrumbs ======= -->
   <section class="breadcrumbs">
      <div class="container">
         <div class="d-flex justify-content-between align-items-center">
            <h2><strong>All Portfolio</strong></h2>
            <ol>
               <li><a href="/">home</a></li>
               <li>
                  <?php
                  if (url_active()[2] == "") echo url_active()[1];
                  else echo "<a href='/" . url_active()[1] . "'>" . url_active()[1] . "</a>";
                  ?>
               </li>
               <li>
                  <?php
                  if (url_active()[2] != "") echo url_active()[2];
                  ?>
               </li>
            </ol>
         </div>
      </div>
   </section><!-- End Breadcrumbs -->

   <section class="portfolio">
      <div class="container">
         <?php
         $categories = get_terms('category', array('order' => 'DESC'));
			foreach ($categories as $category) {
            if ($category->name != "Portfolio") { ?>
               <div class='section-title'>
                  <hr><h2><?php echo $category->name; ?></h2>
               </div>
               <div class='row'>
                  <?php
                  $args = array(
                     'category_name' => $category->name,
                     'posts_per_page' => 1000,
                     'order' => 'DESC'
                  );
                  $loop = new WP_Query($args);
                  while ($loop->have_posts()) {
                     $loop->the_post();
                  ?>
                     <div class="col-lg-4 col-md-6 portfolio-item page-portfolio category-<?php echo $category->name; ?>">
                        <img src="<?php if (has_post_thumbnail()) the_post_thumbnail_url('full');
                                    else echo SITEPATH . "assets/img/semimagem.png"; ?>" class="img-fluid" title="<?php the_title() ?>">
                        <div class="portfolio-info">
                           <h4><?php the_title() ?></h4>
                           <a href="<?php if (has_post_thumbnail()) the_post_thumbnail_url('full');
                                    else echo SITEPATH . "assets/img/semimagem.png"; ?>" data-gall="portfolioGallery" class="venobox preview-link" title="<?php the_title() ?> (<?php echo $category->name; ?>)"><i class="bx bx-plus"></i></a>
                           <a href="<?php the_permalink() ?>" class="details-link" title="Link"><i class="bx bx-link"></i></a>
                        </div>
                     </div><?php }wp_reset_postdata() ?>
               </div><?php }} ?>
      </div>
   </section>
</main><!-- End #main -->
<?php get_footer(); ?>