<?php
get_header();
$current_year = (int) date('Y');
?>
<?php if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
   echo '<script>window.location.href = "/perfil";</script>'; ?>

<main id="main" class="main">

   <!-- ======= Page Title & Breadcrumbs ======= -->
   <div class="pagetitle d-flex justify-content-between align-items-center">
      <div>
         <h1><i class="bi bi-calendar"></i>&ensp;Calendários <?php echo $current_year ?></h1>
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

   <section class="section">

      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  
                  <!-- Navegação por Abas -->
                  <ul class="nav nav-tabs" id="calendarioTabs" role="tablist">
                     
                     <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="congrega-tab" data-bs-toggle="tab" 
                                data-bs-target="#congrega-tab-pane" type="button" role="tab" 
                                aria-controls="congrega-tab-pane" aria-selected="true">
                           <i class="bi bi-people-fill me-2"></i>Congregação
                        </button>
                     </li>

                     <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ci-tab" data-bs-toggle="tab" 
                                data-bs-target="#ci-tab-pane" type="button" role="tab" 
                                aria-controls="ci-tab-pane" aria-selected="false">
                           <i class="bi bi-person-lines-fill me-2"></i>CI - Conselho Interdepartamental
                        </button>
                     </li>

                     <li class="nav-item" role="presentation">
                        <button class="nav-link" id="depto-tab" data-bs-toggle="tab" 
                                data-bs-target="#depto-tab-pane" type="button" role="tab" 
                                aria-controls="depto-tab-pane" aria-selected="false">
                           <i class="bi bi-person-vcard me-2"></i>Departamentos
                        </button>
                     </li>

                  </ul>
                  
                  <!-- Conteúdo das Abas -->
                  <div class="tab-content" id="calendarioTabContent">

                     <!-- Aba Congregação -->
                     <div class="tab-pane fade show active" id="congrega-tab-pane" role="tabpanel" 
                          aria-labelledby="congrega-tab" tabindex="0">
                        <div class="p-4">
                           <h5 class="card-title text-primary mb-4">Calendário da Congregação</h5>
                           <?php echo mostrar_calendario('congrega') ?>
                        </div>
                     </div>

                     <!-- Aba CI -->
                     <div class="tab-pane fade" id="ci-tab-pane" role="tabpanel" 
                          aria-labelledby="ci-tab" tabindex="0">
                        <div class="p-4">
                           <h5 class="card-title text-primary mb-4">Calendário do CI - Conselho Interdepartamental</h5>
                           <?php echo mostrar_calendario('ci') ?>
                        </div>
                     </div>

                     <!-- Aba Departamentos -->
                     <div class="tab-pane fade" id="depto-tab-pane" role="tabpanel" 
                          aria-labelledby="depto-tab" tabindex="0">
                        <div class="p-4">
                           <h5 class="card-title text-primary mb-4">Calendário dos Departamentos</h5>
                           <?php echo mostrar_calendario('depto') ?>
                        </div>
                     </div>

                  </div>

               </div>
            </div>
         </div>
      </div>

   </section><!-- End Front BOXs Section -->

   <!-- Script para melhorar a experiência das abas -->
   <script>
      document.addEventListener('DOMContentLoaded', function() {
         // Adiciona transição suave entre abas
         const tabTriggers = [].slice.call(document.querySelectorAll('#calendarioTabs button'));
         tabTriggers.forEach(function(tabTrigger) {
            tabTrigger.addEventListener('click', function() {
               // Remove classe ativa de todas as abas
               tabTriggers.forEach(function(trigger) {
                  trigger.classList.remove('active');
               });
               // Adiciona classe ativa na aba clicada
               this.classList.add('active');
            });
         });
      });
   </script>

</main><!-- End #main -->
<?php get_footer(); ?>