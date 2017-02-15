<?php

/****** CONSTITUENT ENGAGEMENT STAFF ********/

	function add_ce_role() {
		$result = remove_role('CE Staff', 'CE Staff');
		/* $result = add_role(
			'CE Staff', 	// role
			'CE Staff', 	// display name
			array (
				'read'					=> true,
				'edit_posts'		=> true,
				'publish_posts' => true,
				'edit_pages'		=> true,
				'publish_pages'	=> true,
				'edit_ingathering' => true,
				'edit_others_ingatherings' => true,
				'edit_published_ingatherings' => true,
				'delete_ingathering' => true,
				'delete_published_ingatherings' => true,
				'delete_others_ingatherings' => true,
				'publish_ingatherings' => true,
				'edit_product'	=> true,
				'publish_product'	=> true,
				'upload_files'		=> true,
				)
			); */
	}
	add_action( 'init', 'add_ce_role');
	
?>