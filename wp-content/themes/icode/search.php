<?php get_header(); ?>
<main id="main" class="page page-search" data-aos="fade-up">
   <!-- ======= Breadcrumbs ======= -->
   <?php
   $s = get_search_query();
   $t = $_GET['t'];

   if ($t == "post") {
      $args = array(
         's' => $s,
         'post_type' => 'congrega',
         'wpfts_is_force' => 1
      );
   } elseif ($t == "pdf") {
      $args = array(
         's' => $s,
         'post_type' => array('attachment'),
         'post_status' => array('inherit'),
         'wpfts_is_force' => 1,
      );
   }else{
      $args = null;
   }
   $query = new WP_Query($args);


   if ($query->have_posts()) { ?>
      <section class="breadcrumbs">
         <div class="container">
            <div class="d-flex justify-content-between align-items-center">
               <?php echo "<h2 class='page-title'>Resultado da Busca para: " . get_query_var('s') . "</h2>"; ?>
            </div>
         </div>
      </section><!-- End Breadcrumbs -->
      <section class="inner-page">
         <div class="container">
            <ul>
               <?php
               if ($t == "post") {
                  while ($query->have_posts()) {
                     $query->the_post();
               ?>
                     <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                     </li>
                  <?php
                  }
               } elseif ($t == "pdf") {
                  foreach ($query->posts as $dado) {

                  ?>
                     <li>
                        <a href="<?php echo $dado->guid; ?>"><?php echo $dado->post_title.".pdf";/*explode('/',$dado->guid)[7];*/ ?></a>
                     </li>
               <?php
                  }
               } ?>
            </ul>
         </div>
      </section>
   <?php
   } else {
   ?>
      <section class="breadcrumbs">
         <div class="container">
            <div class="d-flex justify-content-between align-items-center">
               <h2>Not found</h2>
            </div>
         </div>
      </section><!-- End Breadcrumbs -->
      <section class="inner-page">
         <div class="container">
            <p>No matches found.</p>
         </div>
      </section>
   <?php } ?>
</main><!-- End #main -->
<?php get_footer(); ?>