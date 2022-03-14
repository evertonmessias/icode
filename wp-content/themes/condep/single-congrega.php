<?php get_header(); ?>

<main id="main" class="page congrega" data-aos="fade-up">
   <!-- ======= Breadcrumbs ======= -->
   <section class="breadcrumbs">
      <div class="container">
         <div class="d-flex justify-content-between align-items-center">
            <h2><b><?php the_title() ?></b></h2>
            <ol>
               <li><a href="/">home</a></li>
               <li><a href="/congrega">congregacao</a></li>
            </ol>
         </div>
      </div>
   </section><!-- Breadcrumbs Section -->
   <!-- ======= Portfolio Details Section ======= -->
   <section class="portfolio-details">
      <div class="container">
         <h5>Data:</h5>
         <?php echo get_post_meta($post->ID, 'congrega_date', true); ?>
         <br><br><br>         
         <?php echo get_the_content(); ?>
         <br><br><br>  
         </ul>
      </div>
   </section><!-- End Portfolio Details Section -->

</main><!-- End #main -->
<?php get_footer(); ?>