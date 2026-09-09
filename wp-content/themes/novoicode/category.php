<?php
// Arquivo: wp-content/themes/novoicode/category.php
get_header();
?>
<?php if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
	echo '<script>window.location.href = "/perfil";</script>'; ?>

<main id="main" class="main">

	<?php
	$membro = get_user_meta(wp_get_current_user()->ID, 'membro', true);
	$is_admin = current_user_can('administrator');
	$current_type = url_active()[1];

	if (!$is_admin && (!is_array($membro) || !in_array($current_type, $membro))) {
		error_log("Permissão Negada para " . wp_get_current_user()->user_login);
		?>
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card mb-3">
						<div class="card-body p-4">
							<h4 style="text-align:center;">Você não está no <b><u>Membros
										<?php echo print_type($current_type, 'nome') ?></u></b>, consulte o Administrador.
							</h4>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php } else { ?>


		<div class="pagetitle d-flex justify-content-between align-items-center">
			<div>
				<h1><i
						class="<?php echo print_type(url_active()[1], 'icone'); ?>"></i>&ensp;<?php echo print_type(url_active()[1], 'texto'); ?>
					- <?php echo url_active()[2]; ?></h1>
				<nav>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/">Home</a></li>
						<li class="breadcrumb-item active">
							<a href="/<?php echo url_active()[1]; ?>"><?php echo print_type(url_active()[1], 'nome'); ?></a>
						<li class="breadcrumb-item active">
							<a
								href="/<?php echo url_active()[1] . '/' . url_active()[2]; ?>"><?php echo url_active()[2]; ?></a>
						</li>
					</ol>
				</nav>
			</div>
			<div class="btn-editors">

				<a class="btn btn-light" href="/<?php echo url_active()[1]; ?>">
					<i class="bi bi-house"></i>&ensp;Inicio</a>

				<?php if (is_user_logged_in() && !current_user_can('subscriber')) { ?>

					<?php if (url_active()[2] == date('Y')) { ?>
						&emsp;<button id="createPostBtn" class="btn btn-success"><i class="bi bi-file-earmark-plus"></i>&ensp;Novo
							Post</button>
					<?php } ?>

					<!--	&emsp;<button data-bs-toggle="modal" data-bs-target="#modalIndex" class="btn btn-warning"><i
							class="bi bi-database"></i>&ensp;Indexar PDFs</button> -->

				<?php } ?>

			</div>
		</div>

		<section class="section">
			<style>
				.link-privado .bi-file-earmark-lock2 {
					color: #f00 !important;
					font-size: 16px;
				}

				/* Estilos para o DataTable */
				.dataTables_wrapper .dataTables_filter {
					float: left;
				}

				.dataTables_info {
					display: none;
				}

				.tcategory th {
					background-color: #f8f9fa;
					font-weight: bold;
				}
			</style>

			<script>
				// Configuração do DataTable similar ao single.php
				var dataConfig = {
					order: [[2, 'desc']], // Ordenar pela coluna de Data (índice 2)
					columnDefs: [
						{
							targets: 2, // Coluna de data (índice 2)
							type: 'date', // Tipo de ordenação para datas
							render: function (data, type, row) {
								// Para exibição, mostra o conteúdo normal
								if (type === 'display') {
									return data;
								}
								// Para ordenação, usa o data-order
								return jQuery(data).data('order') || data;
							}
						}
					],
					dom: 'Brit',
					buttons: [],
					aLengthMenu: [[25, 50, 75, -1], [25, 50, 75, "All"]],
					iDisplayLength: 50,
					language: {
						emptyTable: "Nenhum conteúdo disponível",
						sSearch: "",
						sInfo: "",
						sShow: "",
						searchPlaceholder: 'Pesquisar',
						lengthMenu: "Mostrar _MENU_ registros por página",
						zeroRecords: "Nenhum registro encontrado",
						info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
						infoEmpty: "Mostrando 0 a 0 de 0 registros",
						infoFiltered: "(filtrado de _MAX_ registros no total)",
						paginate: {
							first: "Primeiro",
							last: "Último",
							next: "Próximo",
							previous: "Anterior"
						}
					}
				};

				jQuery(document).ready(function ($) {
					// Aplicar DataTable à tabela com classe .tcategory
					$('.tcategory').DataTable(dataConfig);
				});

			</script>

			<div class="row">
				<div class="col-lg-12">
					<div class="card p-4">
						<div class="card-body">
							<?php
							$args = array(
								'post_type' => url_active()[1],
								'orderby' => 'date',
								'order' => 'DESC',
								'posts_per_page' => -1, // Mostrar todos os posts para o DataTable paginar
								'category_name' => url_active()[2]
							);
							$loop = new WP_Query($args);
							if ($loop->have_posts()):
								?>
								<table class="table table-striped table-hover tcategory">
									<thead>
										<tr>
											<th>Reunião</th>
											<th>Anexos</th>
											<th>Data</th>
										</tr>
									</thead>
									<tbody>
										<?php

										$membro_post_privado = get_user_meta(wp_get_current_user()->ID, 'membro_post_privado', true);
										if (is_array($membro_post_privado) && in_array(url_active()[1], $membro_post_privado)) {
											$user_membro_post_privado = true;
										} else {
											$user_membro_post_privado = false;
										}

										while ($loop->have_posts()):
											$loop->the_post();

											$post_id = get_the_ID();
											$post_privado = get_post_meta($post_id, url_active()[1] . '_privado', true);

											// Se o post for privado e o usuário não tiver acesso, pula
											if (!empty($post_privado) && $post_privado != $user_membro_post_privado) {
												continue;
											}

											// Post é privado e usuário tem permissão
											$is_privado = !empty($post_privado) && $post_privado == $user_membro_post_privado;

											$upload_dir = wp_upload_dir();
											$dir_file_abs = $upload_dir['basedir'] . '/' . url_active()[1] . '/' . url_active()[2] . '/' . $post_id;
											?>
											<tr <?php echo $is_privado ? "class='link-privado'" : ''; ?>>
												<td class="td1">
													<a href="<?php the_permalink(); ?>">
														<?php echo $is_privado ? "<i title='Post Privado' class='bi bi-file-earmark-lock2'></i>" : "<i class='bi bi-file-earmark-text'></i>"; ?>&ensp;
														<?php the_title(); ?>
													</a>
												</td>
												<td class="td2">
													<?php if (is_dir($dir_file_abs)) { ?>
														<a class="btn btn-sm btn-outline-primary" title="Gerenciador de Arquivos"
															href="/arquivos?tipo=<?php echo url_active()[1]; ?>&ano=<?php echo url_active()[2]; ?>&post_id=<?php echo $post_id; ?>"
															data-elfinder data-post-id="<?php echo $post_id; ?>"
															data-post-title="<?php echo esc_attr(get_the_title()); ?>">
															<i class="bi bi-folder2-open"></i>&ensp;<?php echo $post_id; ?>
														</a>
													<?php } else {
														echo '-';
													} ?>
												</td>

												<?php
												$data_iso = get_post_meta($post_id, url_active()[1] . '_date', true);
												$data = DateTime::createFromFormat('Y-m-d\TH:i', $data_iso);
												?>
												<td class="td3" data-order="<?php echo esc_attr($data_iso); ?>">
													<?php
													if ($data) {
														echo '<i class="bi bi-calendar-event"></i>&emsp;' . $data->format('d/m/Y, H:i') . ' h';
													}
													?>
												</td>


											</tr>
										<?php endwhile; ?>

										<?php
										// Diretório "outros"
										$upload_dir = wp_upload_dir();
										$dir_outros_abs = $upload_dir['basedir'] . '/' . url_active()[1] . '/' . url_active()[2] . '/outros';

										if (is_dir($dir_outros_abs)): ?>
											<tr>
												<td class="td1"></td>
												<td class="td2">
													<a class="btn btn-sm btn-outline-primary"
														href="/arquivos?tipo=<?php echo url_active()[1]; ?>&ano=<?php echo url_active()[2]; ?>&post_id=outros"
														data-elfinder data-post-id="outros"
														data-post-title="Outros - <?php echo url_active()[2]; ?>">
														<i class="bi bi-folder2-open"></i>&ensp;Outros
													</a>
												</td>
												<td class="td3"><i
														class="bi bi-calendar-event"></i>&emsp;<?php echo url_active()[2]; ?></td>
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
							<?php else: ?>
								<p>Nenhum conteúdo encontrado.</p>
							<?php endif;

							wp_reset_postdata();

							global $wpdb;
							$last_post_id = $wpdb->get_var("SELECT MAX(ID) FROM $wpdb->posts WHERE post_status != 'trash'");
							$next_free_id = $last_post_id + 1;
							?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php } ?>
</main>

<style>
	.modal-header {
		background: #116CE5;
		color: #fff;
	}

	.btn-close {
		background: #222;
		color: #fff;
		padding: 10px 12px 17px 12px !important;
		opacity: 1;
	}

	.btn-close:hover {
		transform: scale(1.1);
		color: #fff;
		font-weight: bold;
	}
</style>


<!-- *************************** elFinder ****************************** -->
<div class="modal fade" id="elfinderModal" tabindex="-1" aria-labelledby="elfinderModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-fullscreen">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="elfinderModalLabel"></h5>
				<button type="button" title="Fechar" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"><i
						class="bi bi-x-lg"></i></button>
			</div>
			<div class="modal-body">
				<iframe id="elfinderIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
			</div>
		</div>
	</div>
</div>
<script>
	document.querySelectorAll('a[data-elfinder]').forEach(link => {
		link.addEventListener('click', function (e) {
			e.preventDefault();
			const url = this.getAttribute('href');
			const postId = this.getAttribute('data-post-id');
			const postTitle = this.getAttribute('data-post-title');

			document.getElementById('elfinderIframe').src = url;
			document.getElementById('elfinderModalLabel').innerText = `(#${postId}) ${postTitle}`;

			const modal = new bootstrap.Modal(document.getElementById('elfinderModal'));
			modal.show();
		});
	});

	document.getElementById("createPostBtn").addEventListener("click", function () {
		window.location.href = "/painel/novo/?tipo=<?php echo url_active()[1]; ?>&cat=<?php echo url_active()[2]; ?>&novoid=<?php echo $next_free_id; ?>";
	});
</script>


<!-- *************************** Index ****************************** -->
<div class="modal fade" id="modalIndex" tabindex="-1" aria-labelledby="indexingModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content mindex">
			<div class="modal-header">
				<h5 class="modal-title" id="indexingModalLabel">Indexar todos os documentos de
					<?php echo ucfirst(url_active()[1]) . " " . url_active()[2] ?> e limpar registros órfãos do Banco de
					Dados.
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
						class="bi bi-x-lg"></i></button>
			</div>

			<div class="modal-body">
				<?php
				$tipo = url_active()[1];
				$ano = url_active()[2];
				$base_dir = ABSPATH . "wp-content/uploads/$tipo/$ano";

				if (!file_exists($base_dir)) {
					echo '<div class="alert alert-danger"><p>Diretório não encontrado: ' . esc_html($base_dir) . '</p></div>';
				} else {
					echo '<div id="progresso-box">';
					echo '<p><b>Diretório a ser indexado</b>: ' . esc_html($base_dir) . '</p>';
					echo '<p>Total de PDFs: <span id="total-pdfs">0</span></p>';
					echo '<div class="progress" style="height: 20px;">';
					echo '<div id="progresso" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%;"></div>';
					echo '</div>';
					echo '<div id="status" class="mt-2"></div>';
					echo '</div>';
				}
				?>
			</div>

			<div class="modal-footer">
				<button type="button" id="start-indexing" class="btn btn-primary">Iniciar Indexação</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
<script>

	jQuery(document).ready(function ($) {

		let arquivos = [];
		let urls = [];
		let ids = [];

		$('#modalIndex').on('show.bs.modal', function () {
			const tipo = '<?php echo url_active()[1]; ?>';
			const ano = '<?php echo url_active()[2]; ?>';

			$('#progresso').css('width', '0%');
			$('#status').html('');
			$('#total-pdfs').text('Carregando...');

			// AJAX para buscar a lista de PDFs automaticamente
			$.post('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
				action: 'novoicode_listar_pdfs',
				tipo: tipo,
				ano: ano
			}, function (res) {
				if (res.success) {
					arquivos = res.data.arquivos;
					urls = res.data.urls;
					ids = res.data.ids;
					$('#total-pdfs').text(res.data.total);
				} else {
					$('#total-pdfs').text('Erro');
					$('#status').html('<div class="alert alert-danger">' + res.data.msg + '</div>');
				}
			});
		});

		$('#start-indexing').click(function () {
			const tipo = '<?php echo url_active()[1]; ?>';
			const ano = '<?php echo url_active()[2]; ?>';
			const $btn = $(this);

			$btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processando...');

			const total = arquivos.length;
			let index = 0;

			async function indexarProximo() {
				if (index >= total) {
					$('#status').html("<strong>Indexação concluída!</strong>");
					$btn.prop('disabled', false).text('Reindexar');
					return;
				}

				const arquivoAtual = arquivos[index];
				const urlAtual = urls[index];
				const idAtual = ids[index];

				const porc = Math.round(((index + 1) / total) * 100);
				$('#progresso').css('width', porc + "%");
				$('#status').html("Indexando: " + arquivoAtual + " (" + (index + 1) + "/" + total + ")");

				try {
					const formData = new URLSearchParams({
						action: "novoicode_indexar_pdf",
						arquivo: arquivoAtual,
						url: urlAtual,
						tipo: tipo,
						ano: ano,
						id: idAtual
					});

					const response = await fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
						method: "POST",
						body: formData
					});

					if (!response.ok) throw new Error("Erro na requisição");
					await response.json();
				} catch (error) {
					console.error("Erro ao indexar:", error);
					$('#status').append(" <strong>(Erro ao indexar)</strong><br>");
				} finally {
					index++;
					setTimeout(indexarProximo, 100);
				}
			}

			indexarProximo();
		});

	});
</script>

<?php get_footer(); ?>