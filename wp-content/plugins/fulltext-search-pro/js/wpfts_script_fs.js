/**  
 * Copyright 2013-2021 Epsiloncool
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  @copyright 2013-2021
 *  @license GPL v3
 *  @package Wordpress Fulltext Search Pro
 *  @author Epsiloncool <info@e-wm.org>
 */

;
jQuery(document).ready(function()
{
	jQuery('.wpfts_submit4').on('click', function(e) 
	{
		e.preventDefault();
		
		var formdata = wpftsiFormData(jQuery('#wpftsi_form4'));
		wpftsiAction('wpftsi_submit_settings4', formdata);
		
		return false;
	});
	
	jQuery('#post-body-content').on('click', '.wpfts_attachment_extracted_content_reindex', function()
	{
		var post_id = jQuery(this).attr('data-postid');

		var th = jQuery(this);

		jQuery('.wpfts_waiter_place', th.parent()).html(wpfts_test_waiter());
		
		wpftsiAction('wpftsi_reindex_attachment_post', {'post_id': post_id}, function(jx)
		{
			jQuery('.wpfts_waiter_place', th.parent()).html('');

			if (('code' in jx) && (jx['code'] === 0)) {
				if ('message' in jx) {
					alert(jx['message']);
				}
				if ('html' in jx) {
					th.closest('.wpfts_extracted_content_block').html(jx['html']);
				}
			}
		});
	});

	jQuery('.ft_limit_filetypes input').on('change', function()
	{
		// If not "Allow All" checkbox was checked on or off, remove the checkbox from "Allow All"
		if ((jQuery(this).attr('name') == 'ft_mt_all') && (jQuery(this).attr('type') == 'checkbox')) {
			// No
		} else {
			// Uncheck "Allow All"
			jQuery('.ft_limit_filetypes [name="ft_mt_all"]').prop('checked', false);
		}

		// Construct mime-types from checked boxes
		if (jQuery('.ft_limit_filetypes [name="ft_mt_all"]').is(':checked')) {
			// Clear checkboxes, clear mime-types
			jQuery('.ft_limit_filetypes input').each(function(v)
			{
				if ((jQuery(this).attr('name') != 'ft_mt_all') && (jQuery(this).attr('type') == 'checkbox')) {
					jQuery(this).prop('checked', false);
				}
			});
			jQuery('.ft_limit_filetypes input[name="wpfts_limit_mimetypes"]').val('');
		} else {
			// Check other checkboxes
			var lst = [];
			jQuery('.ft_limit_filetypes input').each(function(v)
			{
				if ((jQuery(this).attr('name') != 'ft_mt_all') && (jQuery(this).attr('type') == 'checkbox')) {
					if (jQuery(this).is(':checked')) {
						lst.push(jQuery(this).val());
					}
				}
			});
			if (lst.length < 1) {
				lst.push('none_types');
			}
			jQuery('.ft_limit_filetypes input[name="wpfts_limit_mimetypes"]').val(lst.join(','));
		}
	});


});