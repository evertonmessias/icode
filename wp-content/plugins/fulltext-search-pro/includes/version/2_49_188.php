<?php

return array(
	'callback' => function()
	{
		global $wpfts_core, $wpdb;

		// Upgrade wpftsi_tw table (add PRIMARY key)
		// To let some db analyzer and migration tools works better
		$index = $wpfts_core->GetIndex();

		$q = 'ALTER TABLE `'.$index->dbprefix().'tw` ADD COLUMN `id` int NOT NULL DEFAULT 0 FIRST, ADD PRIMARY KEY (`id`)';

		$success = false;

		$wpdb->query($q);
		if ($wpdb->last_error) {
			
			$index->log('Can\'t upgrade DB: "'.$q.'": '.$wpdb->last_error);
			$success = false;
		}

		return $success;
	},
);
