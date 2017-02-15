<?php 
/**********************************
		TAXONOMIES
***********************************/

	// COUNTRY TAXONOMY

		function lwr_country_taxonomy() {
			$ctry_labels = array(
				'name'                       => _x( 'Countries', 'Taxonomy General Name', 'text_domain' ),
				'singular_name'              => _x( 'Country', 'Taxonomy Singular Name', 'text_domain' ),
				'menu_name'                  => __( 'Countries', 'text_domain' ),
				'all_items'                  => __( 'All Countries', 'text_domain' ),
				'separate_items_with_commas' => __( 'Separate countries with commas', 'text_domain' ),
				'new_item_name'              => __( 'New Country Name', 'text_domain' ),
				'add_new_item'               => __( 'Add New Country', 'text_domain' ),
				'edit_item'                  => __( 'Edit Country', 'text_domain' ),
				'update_item'                => __( 'Update Country', 'text_domain' ),
				'view_item'                  => __( 'View Item', 'text_domain' ),
				'add_or_remove_items'        => __( 'Add or remove countries', 'text_domain' ),
				'choose_from_most_used'      => __( 'Choose from the most used countries', 'text_domain' ),
				'popular_items'              => __( 'Popular countries', 'text_domain' ),
				'search_items'               => __( 'Search countries', 'text_domain' ),
				'not_found'                  => __( 'Not Found', 'text_domain' ),
			);

			$args = array(
				'labels'                     => $ctry_labels,
				'hierarchical'               => false,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => false,
				'show_in_quick_edit'         => true,
			);

			register_taxonomy( 'country', array( 'post', 'page', 'pressrelease', 'project', 'attachment' ), $args );
		}
		add_action( 'init', 'lwr_country_taxonomy', 0 );

	// SECTOR TAXONOMY

		function lwr_sector_taxonomy() {
			$sctr_labels = array(
				'name'                       => _x( 'Sectors', 'Taxonomy General Name', 'text_domain' ),
				'singular_name'              => _x( 'Sector', 'Taxonomy Singular Name', 'text_domain' ),
				'menu_name'                  => __( 'Sectors', 'text_domain' ),
				'all_items'                  => __( 'All Sectors', 'text_domain' ),
				'separate_items_with_commas' => __( 'Separate multiple sectors with commas', 'text_domain' ),
				'new_item_name'              => __( 'New Sector Name', 'text_domain' ),
				'add_new_item'               => __( 'Add New Sector', 'text_domain' ),
				'edit_item'                  => __( 'Edit Sector', 'text_domain' ),
				'update_item'                => __( 'Update Sector', 'text_domain' ),
				'view_item'                  => __( 'View Item', 'text_domain' ),
				'add_or_remove_items'        => __( 'Add or remove sectors', 'text_domain' ),
				'choose_from_most_used'      => __( 'Choose from the most used sectors', 'text_domain' ),
				'popular_items'              => __( 'Popular Items', 'text_domain' ),
				'search_items'               => __( 'Search sectors', 'text_domain' ),
				'not_found'                  => __( 'Not Found', 'text_domain' ),
			);

			$args = array(
				'labels'                     => $sctr_labels,
				'hierarchical'               => false,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => false,
				'show_in_quick_edit'         => true,
			);

			register_taxonomy( 'sector', array( 'post', 'page', 'pressrelease', 'project' ), $args );
		}
		add_action( 'init', 'lwr_sector_taxonomy', 0 );
		
	/////// Allow Sort by Countries and Sectors in Admin
	///////
	
		add_action( 'restrict_manage_posts', 'taxonomy_restrict_manage_posts' );
		function taxonomy_restrict_manage_posts() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'project' ) {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        $filters = array('country','sector');

        foreach ($filters as $tax_slug) {
            // retrieve the taxonomy object
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            // retrieve array of term objects per taxonomy
            $terms = get_terms($tax_slug);

            // output html for taxonomy dropdown filter
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>All $tax_name</option>";
            foreach ($terms as $term) {
                // output each select option line, check against the last $_GET to show the current option selected
                echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
            }
            echo "</select>";
        }
    }
	}

	// CROSS-CUTTING THEMES TAXONOMY

		function lwr_ccthemes_taxonomy() {
			$ccthemes_labels = array(
				'name'                       => _x( 'Cross-Cutting Themes', 'Taxonomy General Name', 'text_domain' ),
				'singular_name'              => _x( 'Theme', 'Taxonomy Singular Name', 'text_domain' ),
				'menu_name'                  => __( 'Cross-Cutting Themes', 'text_domain' ),
				'all_items'                  => __( 'All Themes', 'text_domain' ),
				'separate_items_with_commas' => __( 'Separate themes with commas', 'text_domain' ),	'new_item_name'              => __( 'New Theme Name', 'text_domain' ),
				'add_new_item'               => __( 'Add New Theme', 'text_domain' ),
				'edit_item'                  => __( 'Edit Theme', 'text_domain' ),
				'update_item'                => __( 'Update Theme', 'text_domain' ),
				'view_item'                  => __( 'View Item', 'text_domain' ),
				'add_or_remove_items'        => __( 'Add or remove themes', 'text_domain' ),
				'choose_from_most_used'      => __( 'Choose from the most used themes', 'text_domain' ),
				'popular_items'              => __( 'Popular Items', 'text_domain' ),
				'search_items'               => __( 'Search themes', 'text_domain' ),
				'not_found'                  => __( 'Not Found', 'text_domain' ),
			);

			$args = array(
				'labels'                     => $ccthemes_labels,
				'hierarchical'               => false,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => false,
				'show_in_nav_menus'          => false,
				'show_in_quick_edit'         => true,
			);

			register_taxonomy( 'themes', array( 'post', 'page', 'pressrelease', 'project' ), $args );
		}
		add_action( 'init', 'lwr_ccthemes_taxonomy', 0 );

	
	// PARTNERS TAXONOMY

		function lwr_partners_taxonomy() {
			$partner_labels = array(
				'name'                       => _x( 'Partners', 'Taxonomy General Name', 'text_domain' ),
				'singular_name'              => _x( 'Partner', 'Taxonomy Singular Name', 'text_domain' ),
				'menu_name'                  => __( 'Partners', 'text_domain' ),
				'all_items'                  => __( 'All Partners', 'text_domain' ),
				'new_item_name'              => __( 'New Partner', 'text_domain' ),
				'add_new_item'               => __( 'Add New Organization', 'text_domain' ),
				'edit_item'                  => __( 'Edit Partner', 'text_domain' ),
				'update_item'                => __( 'Update Partner', 'text_domain' ),
				'view_item'                  => __( 'View Partner', 'text_domain' ),
				'add_or_remove_items'        => __( 'Add or remove partners', 'text_domain' ),
				'choose_from_most_used'      => __( 'Choose from the most common partners', 'text_domain' ),
				'popular_items'              => __( 'Common Partners', 'text_domain' ),
				'search_items'               => __( 'Search Partners', 'text_domain' ),
				'separate_items_with_commas' => __( 'Separate multiple partners with commas', 'text_domain' ),
				'not_found'                  => __( 'Not Found', 'text_domain' ),
			);

			$args = array(
				'labels'                     => $partner_labels,
				'hierarchical'               => false,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => false,
				'show_in_quick_edit'         => true,
				'rewrite'					 => array( 'slug' => 'partner' )
			);

			register_taxonomy( 'lwr_partners', array( 'project' ), $args );
		}
		add_action( 'init', 'lwr_partners_taxonomy', 0 );
	
	// DEPARTMENT TAXONOMY

		function lwr_department_taxonomy() {
			$department_labels = array(
				'name'                       => _x( 'Departments', 'Taxonomy General Name', 'text_domain' ),
				'singular_name'              => _x( 'Department', 'Taxonomy Singular Name', 'text_domain' ),
				'menu_name'                  => __( 'Departments', 'text_domain' ),
				'all_items'                  => __( 'All Departments', 'text_domain' ),
				'parent_item'                => __( 'LWR Staff', 'text_domain' ),
				'parent_item_colon'          => __( 'LWR Staff:', 'text_domain' ),
				'new_item_name'              => __( 'New Department', 'text_domain' ),
				'add_new_item'               => __( 'Add New Department', 'text_domain' ),
				'edit_item'                  => __( 'Edit Department', 'text_domain' ),
				'update_item'                => __( 'Update Department', 'text_domain' ),
				'view_item'                  => __( 'View Item', 'text_domain' ),
				'add_or_remove_items'        => __( 'Add or remove departments', 'text_domain' ),
				'choose_from_most_used'      => __( 'Choose from the most used departments', 'text_domain' ),
				'popular_items'              => __( 'Popular Items', 'text_domain' ),
				'search_items'               => __( 'Search departments', 'text_domain' ),
				'not_found'                  => __( 'Not Found', 'text_domain' ),
			);

			$args = array(
				'labels'                     => $department_labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => false,
				'show_in_quick_edit'         => true,
				'query_var'									 => true
			);

			register_taxonomy( 'departments', array( 'staffmember' ), $args );
		}
		add_action( 'init', 'lwr_department_taxonomy', 0 );

	// OFFICE TAXONOMY

		function lwr_office_taxonomy() {
			$office_labels = array(
				'name'                       => _x( 'Office Location', 'Taxonomy General Name', 'text_domain' ),
				'singular_name'              => _x( 'Offices', 'Taxonomy Singular Name', 'text_domain' ),
				'menu_name'                  => __( 'Office Location', 'text_domain' ),
				'all_items'                  => __( 'All Offices', 'text_domain' ),
				'parent_item'                => __( 'Offices', 'text_domain' ),
				'parent_item_colon'          => __( 'LWR Offices:', 'text_domain' ),
				'new_item_name'              => __( 'New Office Location', 'text_domain' ),
				'add_new_item'               => __( 'Add New Office', 'text_domain' ),
				'edit_item'                  => __( 'Edit Office', 'text_domain' ),
				'update_item'                => __( 'Update Office', 'text_domain' ),
				'view_item'                  => __( 'View Item', 'text_domain' ),
				'add_or_remove_items'        => __( 'Add or remove offices', 'text_domain' ),
				'choose_from_most_used'      => __( 'Choose from the most used offices', 'text_domain' ),
				'popular_items'              => __( 'Popular Items', 'text_domain' ),
				'search_items'               => __( 'Search offices', 'text_domain' ),
				'not_found'                  => __( 'Not Found', 'text_domain' ),
			);

			$args = array(
				'labels'                     => $office_labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => false,
				'show_in_quick_edit'         => true,
			);

			register_taxonomy( 'offices', array( 'staffmember' ), $args );
		}
		add_action( 'init', 'lwr_office_taxonomy', 0 );
		

	// SEASONS TAXONOMY FOR INGATHERINGS

		function lwr_seasons_taxonomy() {
			$season_labels = array(
				'name'                       => _x( 'Seasons', 'Taxonomy General Name', 'text_domain' ),
				'singular_name'              => _x( 'Season', 'Taxonomy Singular Name', 'text_domain' ),
				'menu_name'                  => __( 'Seasons', 'text_domain' ),
				'all_items'                  => __( 'All Seasons', 'text_domain' ),
				'new_item_name'              => __( 'New Season', 'text_domain' ),
				'add_new_item'               => __( 'Add New Season', 'text_domain' ),
				'edit_item'                  => __( 'Edit Season', 'text_domain' ),
				'update_item'                => __( 'Update Season', 'text_domain' ),
				'view_item'                  => __( 'View Season', 'text_domain' ),
				'add_or_remove_items'        => __( 'Add or remove seasons', 'text_domain' ),
				'choose_from_most_used'      => __( 'Choose a season', 'text_domain' ),
				'popular_items'              => __( 'Popular seasons', 'text_domain' ),
				'search_items'               => __( 'Search seasons', 'text_domain' ),
				'not_found'                  => __( 'Not Found', 'text_domain' ),
			);

			$args = array(
				'labels'                     => $season_labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_in_quick_edit'         => true,
				'rewrite'					 => array( 'slug' => 'season', 'ep_mask' => 'season')
			);

			register_taxonomy( 'lwr_seasons', array('ingathering') , $args );
		}
		add_action( 'init', 'lwr_seasons_taxonomy', 0 );			
		
?>