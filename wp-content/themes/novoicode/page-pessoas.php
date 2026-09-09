<?php
get_header();
?>

<?php if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
   echo '<script>window.location.href = "/perfil";</script>'; ?>

<main id="main" class="main">

   <!-- ======= Page Title & Breadcrumbs ======= -->
   <div class="pagetitle d-flex justify-content-between align-items-center">
      <div>
         <h1><i class="bi bi-person-fill"></i>&ensp;Pessoas do ICODE</h1>
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
                  <ul class="nav nav-tabs" id="pessoasTabs" role="tablist">
                     
                     <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="docentes-tab" data-bs-toggle="tab" 
                                data-bs-target="#docentes-tab-pane" type="button" role="tab" 
                                aria-controls="docentes-tab-pane" aria-selected="true">
                           <i class="bi bi-mortarboard-fill me-2"></i>Docentes
                        </button>
                     </li>

                     <li class="nav-item" role="presentation">
                        <button class="nav-link" id="funcionarios-tab" data-bs-toggle="tab" 
                                data-bs-target="#funcionarios-tab-pane" type="button" role="tab" 
                                aria-controls="funcionarios-tab-pane" aria-selected="false">
                           <i class="bi bi-person-badge me-2"></i>Funcionários
                        </button>
                     </li>

                  </ul>
                  
                  <!-- Conteúdo das Abas -->
                  <div class="tab-content" id="pessoasTabContent">

                     <!-- Aba Docentes -->
                     <div class="tab-pane fade show active" id="docentes-tab-pane" role="tabpanel" 
                          aria-labelledby="docentes-tab" tabindex="0">
                        <div class="p-4">
                           <h5 class="card-title text-primary mb-4">Docentes do ICODE</h5>
                           <div class="table-responsive">
                              <table class="table table-striped">
                                 <thead class="thead-dark">
                                    <tr>
                                       <th scope="col"></th>
                                       <th scope="col">Nome</th>
                                       <th scope="col">Membro</th>
                                       <th scope="col">E-Mail</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php echo table_docentes(); ?>
                                 </tbody>
                              </table>
                           </div>
                           <small class="fonte"><b>Fonte</b>: <a href="<?php echo INTRANET ?>/docentes/siteic" target="_blank"><?php echo INTRANET ?>/docentes/siteic</a></small>
                        </div>
                     </div>



                     <!-- Aba Funcionários -->
                     <div class="tab-pane fade" id="funcionarios-tab-pane" role="tabpanel" 
                          aria-labelledby="funcionarios-tab" tabindex="0">
                        <div class="p-4">
                           <h5 class="card-title text-primary mb-4">Funcionários do ICODE</h5>
                           <div class="table-responsive">
                              <table class="table table-striped">
                                 <thead class="thead-dark">
                                    <tr>
                                       <th scope="col"></th>
                                       <th scope="col">Nome</th>
                                       <th scope="col">Papel</th>
                                       <th scope="col">E-Mail</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php echo table_funcionarios(); ?>
                                 </tbody>
                              </table>
                           </div>
                           <small class="fonte"><b>Fonte</b>: <a href="<?php echo INTRANET ?>/funcionarios/siteic" target="_blank"><?php echo INTRANET ?>/funcionarios/siteic</a></small>
                        </div>
                     </div>

                  </div>

               </div>
            </div>
         </div>
      </div>

   </section>

   <!-- Script para melhorar a experiência das abas -->
   <script>
      document.addEventListener('DOMContentLoaded', function() {
         // Adiciona transição suave entre abas
         const tabTriggers = [].slice.call(document.querySelectorAll('#pessoasTabs button'));
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