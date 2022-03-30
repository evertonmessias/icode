/* 
 * FG Drupal to WordPress
 */
var $ = jQuery.noConflict();

class fgd2wp {

	/**
	 * Constructor
	 */
	constructor() {
		this.plugin_id = 'fgd2wp';
		this.fatal_error = '';
		this.is_logging = false;
		this.all_nodes_selected = false;
	}

	/**
	 * Manage the behaviour of the Driver radio box
	 */
	hide_unhide_driver_fields() {
		$(".mysql_field").toggle($("#driver_mysql").is(':checked') || $("#driver_postgresql").is(':checked'));
		$(".sqlite_field").toggle($("#driver_sqlite").is(':checked'));
	}

	/**
	 * Manage the behaviour of the Skip Media checkbox
	 */
	hide_unhide_media() {
		$("#media_import_box").toggle(!$("#skip_media").is(':checked'));
	}

	/**
	 * Hide or unhide the partial import nodes box
	 */
	hide_unhide_partial_import_nodes_box() {
		$("#skip_nodes_box").toggle(!$("#skip_nodes").is(':checked'));
	}

	/**
	 * Enable or disable the file public path text box
	 */
	enable_disable_file_public_path_textbox() {
		$("#file_public_path").prop('readonly', !$("#file_public_path_source_changed").is(':checked'));
	}

	/**
	 * Enable or disable the file private path text box
	 */
	enable_disable_file_private_path_textbox() {
		$("#file_private_path").prop('readonly', !$("#file_private_path_source_changed").is(':checked'));
	}

	/**
	 * Security question before deleting WordPress content
	 */
	check_empty_content_option() {
		var confirm_message;
		var action = $('input:radio[name=empty_action]:checked').val();
		switch (action) {
			case 'imported':
				confirm_message = objectL10n.delete_imported_data_confirmation_message;
				break;
			case 'all':
				confirm_message = objectL10n.delete_all_confirmation_message;
				break;
			default:
				alert(objectL10n.delete_no_answer_message);
				return false;
				break;
		}
		return confirm(confirm_message);
	}

	/**
	 * Start the logger
	 */
	start_logger() {
		this.is_logging = true;
		clearTimeout(this.display_logs_timeout);
		clearTimeout(this.update_progressbar_timeout);
		clearTimeout(this.update_wordpress_info_timeout);
		this.update_display();
	}

	/**
	 * Stop the logger
	 */
	stop_logger() {
		this.is_logging = false;
	}

	/**
	 * Update the display
	 */
	update_display() {
		this.display_logs();
		this.update_progressbar();
		this.update_wordpress_info();
	}

	/**
	 * Display the logs
	 */
	display_logs() {
		if ($("#logger_autorefresh").is(":checked")) {
			$.ajax({
				url: objectPlugin.log_file_url,
				cache: false
			}).done((result) => {
				$('#action_message').html(''); // Clear the action message
				$("#logger").html('');
				result.split("\n").forEach(function (row) {
					if (row.substr(0, 7) === '[ERROR]' || row.substr(0, 9) === '[WARNING]' || row === 'IMPORT STOPPED BY USER') {
						row = '<span class="error_msg">' + row + '</span>'; // Mark the errors in red
					}
					// Test if the import is completed
					else if (row === 'IMPORT COMPLETED') {
						row = '<span class="completed_msg">' + row + '</span>'; // Mark the completed message in green
						$('#action_message').html(objectL10n.import_completed)
							.removeClass('failure').addClass('success');
					}
					$("#logger").append(row + "<br />\n");
				});
				$("#logger").append('<span class="error_msg">' + this.fatal_error + '</span>' + "<br />\n");
			}).always(() => {
				if (this.is_logging) {
					this.display_logs_timeout = setTimeout(() => { this.display_logs(); }, 1000);
				}
			});
		} else {
			if (this.is_logging) {
				this.display_logs_timeout = setTimeout(() => { this.display_logs(); }, 1000);
			}
		}
	}

	/**
	 * Update the progressbar
	 */
	update_progressbar() {
		$.ajax({
			url: objectPlugin.progress_url,
			cache: false,
			dataType: 'json'
		}).always((result) => {
			// Move the progress bar
			var progress = 0;
			if ((result.total !== undefined) && (Number(result.total) !== 0)) {
				progress = Math.round(Number(result.current) / Number(result.total) * 100);
			}
			jQuery('#progressbar').progressbar('option', 'value', progress);
			jQuery('#progresslabel').html(progress + '%');
			if (this.is_logging) {
				this.update_progressbar_timeout = setTimeout(() => { this.update_progressbar(); }, 1000);
			}
		});
	}

	/**
	 * Update WordPress database info
	 */
	update_wordpress_info() {
		var data = 'action=' + this.plugin_id + '_import&plugin_action=update_wordpress_info';
		$.ajax({
			method: "POST",
			url: ajaxurl,
			data: data
		}).done((result) => {
			$('#fgd2wp_database_info_content').html(result);
			if (this.is_logging) {
				this.update_wordpress_info_timeout = setTimeout(() => { this.update_wordpress_info(); }, 1000);
			}
		});
	}

	/**
	 * Empty WordPress content
	 * 
	 * @returns {Boolean}
	 */
	empty_wp_content() {
		if (this.check_empty_content_option()) {
			// Start displaying the logs
			this.start_logger();
			$('#empty').attr('disabled', 'disabled'); // Disable the button
			$('#empty_spinner').addClass("is-active");
			$('#empty_message').html('');

			var data = $('#form_empty_wordpress_content').serialize() + '&action=' + this.plugin_id + '_import&plugin_action=empty';
			$.ajax({
				method: "POST",
				url: ajaxurl,
				data: data
			}).done((result) => {
				if (result) {
					this.fatal_error = result;
				}
				$('#empty_message').html(objectL10n.content_removed_from_wordpress).addClass('success');
			}).fail((result) => {
				this.fatal_error = result.responseText;
			}).always(() => {
				this.stop_logger();
				$('#empty').removeAttr('disabled'); // Enable the button
				$('#empty_spinner').removeClass("is-active");
			});
		}
		return false;
	}

	/**
	 * Test the database connection
	 * 
	 * @returns {Boolean}
	 */
	test_database() {
		// Start displaying the logs
		this.start_logger();
		$('#test_database').attr('disabled', 'disabled'); // Disable the button
		$('#database_test_message').html('');

		var data = $('#form_import').serialize() + '&action=' + this.plugin_id + '_import&plugin_action=test_database';
		$.ajax({
			method: 'POST',
			url: ajaxurl,
			data: data,
			dataType: 'json'
		}).done((result) => {
			if (typeof result.message !== 'undefined') {
				$('#database_test_message').toggleClass('success', result.status === 'OK')
					.toggleClass('failure', result.status !== 'OK')
					.html(result.message);
			}

			// Display partial import nodes
			if (typeof result.partial_import_nodes !== 'undefined') {
				$('#partial_import_nodes').html(result.partial_import_nodes);
			}

			// Display domains
			if (typeof result.domains !== 'undefined') {
				$('#domain').html(result.domains);
			}

		}).fail((result) => {
			this.fatal_error = result.responseText;
		}).always(() => {
			this.stop_logger();
			$('#test_database').removeAttr('disabled'); // Enable the button
		});
		return false;
	}

	/**
	 * Change the Download protocol
	 * 
	 */
	change_protocol() {
		var protocol = $('input:radio[name=download_protocol]:checked').val();
		switch (protocol) {
			case 'ftp':
				$('.ftp_parameters').show();
				$('.file_system_parameters').hide();
				$('.test_media').hide();
				break;
			case 'file_system':
				$('.ftp_parameters').hide();
				$('.file_system_parameters').show();
				$('.test_media').show();
				break;
			default:
				if (objectPlugin.enable_ftp) { // Show the FTP parameters for the add-ons which need it
					$('.ftp_parameters').show();
				} else {
					$('.ftp_parameters').hide();
				}
				$('.file_system_parameters').hide();
				$('.test_media').show();
		}
	}

	/**
	 * Test the Media connection
	 * 
	 * @returns {Boolean}
	 */
	test_download() {
		// Start displaying the logs
		this.start_logger();
		$('#test_download').attr('disabled', 'disabled'); // Disable the button
		$('#download_test_message').html('');

		var data = $('#form_import').serialize() + '&action=' + this.plugin_id + '_import&plugin_action=test_download';
		$.ajax({
			method: 'POST',
			url: ajaxurl,
			data: data,
			dataType: 'json'
		}).done((result) => {
			if (typeof result.message !== 'undefined') {
				$('#download_test_message').toggleClass('success', result.status === 'OK')
					.toggleClass('failure', result.status !== 'OK')
					.html(result.message);
			}
		}).fail((result) => {
			this.fatal_error = result.responseText;
		}).always(() => {
			this.stop_logger();
			$('#test_download').removeAttr('disabled'); // Enable the button
		});
		return false;
	}

	/**
	 * Test the FTP connection
	 * 
	 * @returns {Boolean}
	 */
	test_ftp() {
		// Start displaying the logs
		this.start_logger();
		$('#test_ftp').attr('disabled', 'disabled'); // Disable the button
		$('#ftp_test_message').html('');

		var data = $('#form_import').serialize() + '&action=' + this.plugin_id + '_import&plugin_action=test_ftp';
		$.ajax({
			method: 'POST',
			url: ajaxurl,
			data: data,
			dataType: 'json'
		}).done((result) => {
			if (typeof result.message !== 'undefined') {
				$('#ftp_test_message').toggleClass('success', result.status === 'OK')
					.toggleClass('failure', result.status !== 'OK')
					.html(result.message);
			}
		}).fail((result) => {
			this.fatal_error = result.responseText;
		}).always(() => {
			this.stop_logger();
			$('#test_ftp').removeAttr('disabled'); // Enable the button
		});
		return false;
	}

	/**
	 * Select / deselect all the node types
	 * 
	 * @returns {Boolean}
	 */
	toggle_node_types() {
		this.all_nodes_selected = !this.all_nodes_selected;
		$('#partial_import_nodes input').prop("checked", this.all_nodes_selected);
		return false;
	}

	/**
	 * Save the settings
	 * 
	 * @returns {Boolean}
	 */
	save() {
		// Start displaying the logs
		this.start_logger();
		$('#save').attr('disabled', 'disabled'); // Disable the button
		$('#save_spinner').addClass("is-active");
		$('#save_message').html('');

		var data = $('#form_import').serialize() + '&action=' + this.plugin_id + '_import&plugin_action=save';
		$.ajax({
			method: "POST",
			url: ajaxurl,
			data: data
		}).done(() => {
			$('#save_message').html(objectL10n.settings_saved).addClass('success');
		}).fail((result) => {
			this.fatal_error = result.responseText;
		}).always(() => {
			this.stop_logger();
			$('#save').removeAttr('disabled'); // Enable the button
			$('#save_spinner').removeClass("is-active");
		});
		return false;
	}

	/**
	 * Start the import
	 * 
	 * @returns {Boolean}
	 */
	start_import() {
		this.fatal_error = '';
		// Start displaying the logs
		this.start_logger();

		// Disable the import button
		this.import_button_label = $('#import').val();
		$('#import').val(objectL10n.importing).attr('disabled', 'disabled');
		// Show the stop button
		$('#stop-import').show();
		$('#import_spinner').addClass("is-active");
		// Clear the action message
		$('#action_message').html('');

		// Run the import
		var data = $('#form_import').serialize() + '&action=' + this.plugin_id + '_import&plugin_action=import';
		$.ajax({
			method: "POST",
			url: ajaxurl,
			data: data
		}).done((result) => {
			if (result) {
				this.fatal_error = result;
			}
		}).fail((result) => {
			this.fatal_error = result.responseText;
		}).always(() => {
			this.stop_logger();
			this.update_display(); // Get the latest information after the import was stopped
			this.reactivate_import_button();
		});
		return false;
	}

	/**
	 * Reactivate the import button
	 * 
	 */
	reactivate_import_button() {
		$('#import').val(this.import_button_label).removeAttr('disabled');
		$('#stop-import').hide();
		$('#import_spinner').removeClass("is-active");
	}

	/**
	 * Stop import
	 * 
	 * @returns {Boolean}
	 */
	stop_import() {
		$('#stop-import').attr('disabled', 'disabled');
		$('#action_message').html(objectL10n.import_stopped_by_user)
			.removeClass('success').addClass('failure');
		// Stop the import
		var data = $('#form_import').serialize() + '&action=' + this.plugin_id + '_import&plugin_action=stop_import';
		$.ajax({
			method: "POST",
			url: ajaxurl,
			data: data
		}).fail((result) => {
			this.fatal_error = result.responseText;
		}).always(() => {
			this.stop_logger();
			$('#stop-import').removeAttr('disabled'); // Enable the button
			this.reactivate_import_button();
		});
		return false;
	}

	/**
	 * Modify the internal links
	 * 
	 * @returns {Boolean}
	 */
	modify_links() {
		// Start displaying the logs
		this.start_logger();
		$('#modify_links').attr('disabled', 'disabled'); // Disable the button
		$('#modify_links_spinner').addClass("is-active");
		$('#modify_links_message').html('');

		var data = $('#form_modify_links').serialize() + '&action=' + this.plugin_id + '_import&plugin_action=modify_links';
		$.ajax({
			method: "POST",
			url: ajaxurl,
			data: data
		}).done((result) => {
			if (result) {
				this.fatal_error = result;
			}
			$('#modify_links_message').html(objectL10n.internal_links_modified).addClass('success');
		}).fail((result) => {
			this.fatal_error = result.responseText;
		}).always(() => {
			this.stop_logger();
			$('#modify_links').removeAttr('disabled'); // Enable the button
			$('#modify_links_spinner').removeClass("is-active");
		});
		return false;
	}

	/**
	 * Copy a field value to the clipboard
	 * 
	 */
	copy_to_clipboard() {
		var containerid = $(this).data("field");
		if (document.selection) {
			var range = document.body.createTextRange();
			range.moveToElementText(document.getElementById(containerid));
			range.select().createTextRange();

		} else if (window.getSelection) {
			window.getSelection().removeAllRanges();
			var range = document.createRange();
			range.selectNode(document.getElementById(containerid));
			window.getSelection().addRange(range);
		}
		document.execCommand("copy");
		return false;
	}

}

/*
 * Load at startup
 */
window.addEventListener('load', () => {
	fgd2wp = new fgd2wp();

	$('#progressbar').progressbar({value: 0});

	// Driver radio box
	$("#driver_mysql").bind('click', () => {
		fgd2wp.hide_unhide_driver_fields();
	});
	$("#driver_sqlite").bind('click', () => {
		fgd2wp.hide_unhide_driver_fields();
	});
	$("#driver_postgresql").bind('click', () => {
		fgd2wp.hide_unhide_driver_fields();
	});
	fgd2wp.hide_unhide_driver_fields();

	// Skip media checkbox
	$("#skip_media").bind('click', () => {
		fgd2wp.hide_unhide_media();
	});
	fgd2wp.hide_unhide_media();

	// Default public file path
	$("#file_public_path_source_default").click(() => {
		fgd2wp.enable_disable_file_public_path_textbox();
	});
	$("#file_public_path_source_changed").click(() => {
		fgd2wp.enable_disable_file_public_path_textbox();
	});
	fgd2wp.enable_disable_file_public_path_textbox();

	// Default private file path
	$("#file_private_path_source_default").click(() => {
		fgd2wp.enable_disable_file_private_path_textbox();
	});
	$("#file_private_path_source_changed").click(() => {
		fgd2wp.enable_disable_file_private_path_textbox();
	});
	fgd2wp.enable_disable_file_private_path_textbox();

	// Skip nodes checkbox
	$("#skip_nodes").bind('click', () => {
		fgd2wp.hide_unhide_partial_import_nodes_box();
	});
	fgd2wp.hide_unhide_partial_import_nodes_box();

	// Empty WordPress content confirmation
	$("#form_empty_wordpress_content").bind('submit', () => {
		fgd2wp.check_empty_content_option();
	});

	// Partial import checkbox
	$("#partial_import").hide();
	$("#partial_import_toggle").click(() => {
		$("#partial_import").slideToggle("slow");
	});

	// Empty button
	$('#empty').click(() => {
		fgd2wp.empty_wp_content();
		return false;
	});

	// Test database button
	$('#test_database').click(() => {
		fgd2wp.test_database();
		return false;
	});

	// Change the Download protocol
	$('input[name="download_protocol"]').bind('click', () => {
		fgd2wp.change_protocol();
	});
	fgd2wp.change_protocol();

	// Test Media button
	$('#test_download').click(() => {
		fgd2wp.test_download();
		return false;
	});

	// Test FTP button
	$('#test_ftp').click(() => {
		fgd2wp.test_ftp();
		return false;
	});

	// Select / deselect all node types
	$('#toggle_node_types').click(() => {
		fgd2wp.toggle_node_types();
		return false;
	});

	// Save settings button
	$('#save').click(() => {
		fgd2wp.save();
		return false;
	});

	// Import button
	$('#import').click(() => {
		fgd2wp.start_import();
		return false;
	});

	// Stop import button
	$('#stop-import').click(() => {
		fgd2wp.stop_import();
		return false;
	});

	// Modify links button
	$('#modify_links').click(() => {
		fgd2wp.modify_links();
		return false;
	});

	// Display the logs
	$('#logger_autorefresh').click(() => {
		fgd2wp.display_logs();
	});

	$('.copy_to_clipboard').click(fgd2wp.copy_to_clipboard);

	fgd2wp.update_display();
});
