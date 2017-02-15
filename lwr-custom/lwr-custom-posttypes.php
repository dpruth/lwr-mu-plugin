<?php

	/***********************************************
			CUSTOM POST TYPES
	************************************************/
	// ADD EXCERPTS TO PAGES
	add_action( 'init', 'my_add_excerpts_to_pages' );
		function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
		}

	
	// PRESS RELEASE POST-TYPE

		function lwr_pressrelease_post_type() {
			$pr_labels = array(
				'name'						=> 'Press Releases',
				'singular_name'				=> 'Press Release',
				'menu_name'					=> 'Press Releases',
				'name_admin_bar'			=> 'Press Releases',
				'add_new_item'				=> 'Add New Press Release',
				'edit_item'					=> 'Edit Release',
				'view_item'					=> 'Read Press Release',
				'all_items'					=> 'All Press Releases',
				'not_found'					=> 'No Releases found.'
			);

			$args = array(
				'public'					=> true,
				'labels'                    => $pr_labels,
				'hierarchical'              => false,
				'taxonomies'				=> array('country', 'sector', 'theme'),
				'show_ui'                   => true,
				'show_admin_column'         => true,
				'show_in_nav_menus'         => true,
				'show_in_quick_edit'        => false,
				'has_archive'				=> true,
				'supports'		=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks' ),
				'menu_icon'					=> 'dashicons-media-text',
				'rewrite'					=> array( 'slug'	=> 'pressrelease' ),
				'menu_position'				=> 20,
			);

			register_post_type( 'pressRelease', $args );
		}
		add_action( 'init', 'lwr_pressrelease_post_type' );

	// PROJECT POST-TYPE

		function lwr_project_post_type() {
			$proj_labels = array(
				'name'						=> 'Projects',
				'singular_name'				=> 'Project',
				'menu_name'					=> 'Projects',
				'name_admin_bar'			=> 'Projects',
				'add_new_item'				=> 'Add New Project',
				'edit_item'					=> 'Edit Project',
				'view_item'					=> 'Read About The Project',
				'all_items'					=> 'All Projects',
				'not_found'					=> 'No Projects found.'
			);

			$args = array(
				'public'					=> true,
				'labels'                    => $proj_labels,
				'hierarchical'              => true,
				'taxonomies'				=> array( 'lwr_partners', 'country', 'sector', 'themes' ),
				'show_ui'                   => true,
				'show_admin_column'         => true,
				'show_in_nav_menus'         => true,
				'show_in_quick_edit'        => false,
				'has_archive'				=> true,
				'menu_icon'					=> 'dashicons-location-alt',
				'rewrite'					=> array( 'slug' => 'project' ),
				'menu_position'				=> 21,
				'supports'          		=> array( 'title', 'editor', 'thumbnail', 'page-attributes', 'custom_fields' )
			);

			register_post_type( 'project', $args );
		}
		add_action( 'init', 'lwr_project_post_type' );

	// INGATHERING POST-TYPE

		function lwr_ingathering_post_type() {
			$proj_labels = array(
				'name'						=> 'Ingatherings',
				'singular_name'		=> 'Ingathering',
				'menu_name'				=> 'Ingatherings',
				'name_admin_bar'	=> 'Ingatherings',
				'add_new_item'		=> 'Add New Ingathering',
				'edit_item'				=> 'Edit Ingathering',
				'view_item'				=> 'View the Ingathering',
				'all_items'				=> 'All Ingatherings',
				'not_found'				=> 'No Ingatherings found.'
			);

			$args = array(
				'public'						=> true,
				'labels'            => $proj_labels,
				'hierarchical'      => false,
				'taxonomies'				=> array( 'lwr_seasons' ),
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_in_quick_edit'=> false,
				'has_archive'				=> true,
				'menu_icon'					=> 'dashicons-admin-multisite',
				'rewrite'						=> array( 'slug' => 'ingatherings' ),
				'menu_position'			=> 21,
				'supports'          => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'custom_fields' ),
			);

			register_post_type( 'ingathering', $args );
		}
		add_action( 'init', 'lwr_ingathering_post_type' );

	// STAFF MEMBER POST-TYPE

		function lwr_staffmember_post_type() {
			$staff_labels = array(
				'name'						=> 'Staff Members',
				'singular_name'				=> 'Staff Member',
				'menu_name'					=> 'Staff Members',
				'name_admin_bar'			=> 'Staff Members',
				'add_new_item'				=> 'Add New Staff Member',
				'edit_item'					=> 'Edit Staff Member',
				'view_item'					=> 'Read About This Colleague',
				'all_items'					=> 'All Staff',
				'not_found'					=> 'No Staff Members found.'
			);

			$args = array(
				'public'					=> true,
				'labels'                    => $staff_labels,
				'hierarchical'              => false,
				'taxonomies'				=> array('departments', 'offices'),
				'show_ui'                   => true,
				'show_admin_column'         => true,
				'show_in_nav_menus'         => true,
				'show_in_quick_edit'        => false,
				'has_archive'				=> true,
				'menu_icon'					=> 'dashicons-nametag',
				'rewrite'					=> array( 'slug' => 'staff', ),
				'menu_position'				=> 22,
				'supports'          		=> array( 'title', 'editor', 'thumbnail', 'page-attributes' )
			);

			register_post_type( 'staffmember', $args );
		}
		add_action( 'init', 'lwr_staffmember_post_type' );

		
// VIDEO POST-TYPE

		function lwr_videos_post_type() {
			$vid_labels = array(
				'name'						=> 'Videos',
				'singular_name'		=> 'Video',
				'menu_name'				=> 'Videos',
				'name_admin_bar'	=> 'Videos',
				'add_new_item'		=> 'Add New Video',
				'edit_item'				=> 'Edit Video',
				'view_item'				=> 'View Video',
				'all_items'				=> 'All Videos',
				'not_found'				=> 'No Videos found.'
			);

			$args = array(
				'public'							=> true,
				'labels'          		=> $vid_labels,
				'hierarchical'    		=> false,
				'taxonomies'					=> array('country', 'sector', 'lwr_partners'),
				'show_ui'             => true,
				'show_admin_column'   => true,
				'show_in_nav_menus'   => true,
				'show_in_quick_edit'  => false,
				'has_archive'					=> true,
				'menu_icon'						=> 'dashicons-video-alt3',
				'rewrite'							=> array( 'slug'	=> 'videos' ),
				'menu_position'				=> 45,
				'supports'          => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
			);

			register_post_type( 'lwr_videos', $args );
		}
		add_action( 'init', 'lwr_videos_post_type' );


		

?>