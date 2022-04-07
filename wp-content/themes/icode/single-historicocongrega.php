<?php get_header(); ?>
<main id="main" class="page congrega" data-aos="fade-up">
   <!-- ======= Breadcrumbs ======= -->
   <section class="breadcrumbs">
      <div class="container">
         <div class="d-flex justify-content-between align-items-center">
            <h2><?php the_title() ?></h2>
            <ol>
               <li><a href="/">home</a></li>
               <li><a href="/historicocongrega">historicocongregacao</a></li>               
            </ol>
         </div>
      </div>
   </section><!-- Breadcrumbs Section -->
   <!-- ======= Portfolio Details Section ======= -->
   <section class="portfolio-details">
      <div class="container">                  
         <?php the_content() ?>         
      </div>
   </section><!-- End Portfolio Details Section -->

</main><!-- End #main -->
<?php get_footer(); ?>