  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3 class="logo mr-auto">
              <a href="/">
                <img src="<?php echo get_option('portal_input_2'); ?>" title="CONDEP"><br><br>
                <span>CONDEP</span>
              </a>
            </h3>
            <p>
              <?php if (get_option('portal_input_5') != "") { ?>
                <i class="icofont-envelope"></i>&ensp;<a href="mailto:<?php echo get_option('portal_input_5'); ?>"><?php echo get_option('portal_input_5'); ?></a>
              <?php } ?>
            </p>
            <p>
              <?php if (get_option('portal_input_4') != "") { ?>
                <i class="bx bxl-whatsapp"></i>&ensp;<a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo get_option('portal_input_4'); ?>&text=CONDEP"><?php echo get_option('portal_input_4'); ?></a>
              <?php } ?>
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <ul>
              <li id=""><i class="bx bx-chevron-right"></i><a href="/#">Link 1</a></li>
              <li id=""><i class="bx bx-chevron-right"></i><a href="/#">Link 2</a></li>
              <li id=""><i class="bx bx-chevron-right"></i><a href="/#">Link 3</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <ul>
              <li id=""><i class="bx bx-chevron-right"></i><a href="/#">Link 1</a></li>
              <li id=""><i class="bx bx-chevron-right"></i><a href="/#">Link 2</a></li>
              <li id=""><i class="bx bx-chevron-right"></i><a href="/#">Link 3</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <ul>
              <li id=""><i class="bx bx-chevron-right"></i><a href="/#">Link 1</a></li>
              <li id=""><i class="bx bx-chevron-right"></i><a href="/#">Link 2</a></li>
              <li id=""><i class="bx bx-chevron-right"></i><a href="/#">Link 3</a></li>
            </ul>
          </div>

        </div>
      </div>
    </div>

    <div class="container py-4">
      <div class="copyright">
        <strong><span>CONDEP</span></strong>. All rights reserved
      </div>
      <div class="credits">
        Designed by <a href="https://ic.unicamp.br/~everton/" target="_blank">EvM</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo SITEPATH; ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/counterup/counterup.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/venobox/venobox.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo SITEPATH; ?>assets/js/quicksearch.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/js/main.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/js/condep.js"></script>

  <?php wp_footer(); ?>
  </body>

  </html>