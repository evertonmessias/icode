<?php
get_header();
?>
<?php if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
   echo '<script>window.location.href = "/perfil";</script>'; ?>

<main id="main" class="main">

   <!-- ======= Page Title & Breadcrumbs ======= -->
   <div class="pagetitle d-flex justify-content-between align-items-center">
      <div>
         <h1><i class="bi bi-code-square"></i>&ensp;Sobre o ICODE</h1>
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

   <section class="section sobre">

      <div class="row">
         <div class="col-lg-12">
            <div class="card mb-3">
               <div class="card-body">
                  <h5 class="card-title"><u>Sobre o ICODE:</u></h5>
                  <ul>
                     <li>&ensp;<a href="/tutorial/" target="_blank"><i
                              class="bi bi-box-arrow-up-right"></i>&ensp;Tutorial para Editores</a></li>
                     <li>&ensp;<a href="/documentacao/" target="_blank"><i
                              class="bi bi-box-arrow-up-right"></i>&ensp;Documentação para Administradores</a></li>
                     <li>&ensp;<a href="https://gitlab.ic.unicamp.br/everton/novoicode" target="_blank"><i
                              class="bi bi-box-arrow-up-right"></i>&ensp;Projeto no GitLab</a></li>
                     <li>&ensp;<a href="https://ic.unicamp.br/~everton" target="_blank"><i
                              class="bi bi-box-arrow-up-right"></i>&ensp;Site do Desenvolvedor</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-lg-12">
            <div class="card mb-3">
               <div class="card-body">
                  <h5 class="card-title"><u>Páginas mais acessadas:</u></h5>
                  <br>
                  <div id="barChart"></div>
                  <script>
                     document.addEventListener("DOMContentLoaded", () => {
                        new ApexCharts(document.querySelector("#barChart"), {
                           series: [{
                              data: [<?php echo chart_data('count') ?>]
                           }],
                           chart: {
                              type: 'bar',
                              height: 350
                           },
                           plotOptions: {
                              bar: {
                                 borderRadius: 4,
                                 horizontal: true,
                              }
                           },
                           dataLabels: {
                              enabled: true
                           },
                           xaxis: {
                              categories: [<?php echo chart_data('url') ?>]
                           }
                        }).render();
                     });
                  </script>
                  <!-- End Bar Chart -->

               </div>
            </div>
         </div>
      </div>

      <?php if (current_user_can('administrator') || current_user_can('editor')) { ?>
         <div class="row">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body">
                     <h5 class="card-title"><u>Registro de Acessos:</u></h5>
                     <script>
                        jQuery(document).ready(function ($) {
                           $('#ptacessos').DataTable({
                              order: [[3, 'desc']],
                              dom: 'lBfrtip',
                              buttons: [],
                              aLengthMenu: [[25, 50, 75, -1], [25, 50, 75, "All"]],
                              iDisplayLength: 25,
                              language: {
                                 emptyTable: "Não há dados disponíveis para a consulta",
                                 oPaginate: {
                                    sNext: "Próximo",
                                    sPrevious: "Anterior",
                                    sFirst: "Primeiro",
                                    sLast: "Último",
                                 },
                                 sSearch: "",
                                 sInfo: "",
                                 sShow: "",
                                 searchPlaceholder: 'Pesquisar'
                              }
                           });
                        });
                     </script>
                     <table id="ptacessos" class="table table-striped table-bordered display" style="width:100%">
                        <thead>
                           <tr>
                              <th>Usuário</th>
                              <th>IP</th>
                              <th>URL</th>
                              <th>Data/Hora</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           global $wpdb;
                           $table_name = $wpdb->prefix . 'acessos';
                           $sql = "SELECT * FROM $table_name ORDER BY id DESC LIMIT 500;";
                           $results = $wpdb->get_results($sql);
                           foreach ($results as $item) {
                              $data = explode("-", explode(" ", $item->time)[0]);
                              $datahora = $data[2] . "/" . $data[1] . "/" . $data[0] . " , " . explode(" ", $item->time)[1];
                              echo "<tr><td>" . $item->user . "</td><td>" . $item->ipadress . "</td><td>" . $item->url . "</td><td>" . $datahora . "</td></tr>";
                           }
                           ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      <?php } ?>

   </section>

</main><!-- End #main -->
<?php get_footer(); ?>