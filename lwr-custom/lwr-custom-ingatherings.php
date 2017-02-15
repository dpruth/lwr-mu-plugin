<?php

	/** Adds Meta Box for Ingathering Location **/

	add_action('do_meta_boxes', 'lwr_ingathering_location_meta_boxes');
	function lwr_ingathering_location_meta_boxes() {
		add_meta_box('ingathering_location', __('Ingathering Location', 'lwr-custom'), 'lwr_ingathering_location_meta_box', 'ingathering', 'normal', 'high');
	}

	/** Display Meta Box **/

	function lwr_ingathering_location_meta_box(){
		global $post;
		$custom = get_post_custom($post->ID);
		$_ingathering_address = $custom["_ingathering_address"][0];
		$_ingathering_city  = $custom["_ingathering_city"][0];
		$_ingathering_state = $custom["_ingathering_state"][0];
		$_ingathering_zip = $custom["_ingathering_zip"][0];

		wp_nonce_field( 'lwr_save_ingathering_location_details', 'lwr_ingathering_location_noncename' );

		?>

		<div>
			<label for="_ingathering_address"><?php _e( 'Address:', 'lwr-custom' ); ?> <input type="text" name="_ingathering_address" id="_ingathering_address" placeholder="<?php if ($_ingathering_address == '') _e( '', 'lwr-custom' ); ?>" value="<?php if ($_ingathering_address != '') echo $_ingathering_address; ?>" /></label><br />

			<label for="_ingathering_city"><?php _e( 'City:', 'lwr-custom' ); ?> <input type="text" name="_ingathering_city" id="_ingathering_city" placeholder="<?php if ($_ingathering_city == '') _e( '', 'lwr-custom' ); ?>" value="<?php if ($_ingathering_city != '') echo $_ingathering_city; ?>" /></label><br />
						
			<label for="_ingathering_state"><?php _e( 'State:', 'lwr-custom' ); ?> <input type="text" name="_ingathering_state" id="_ingathering_state" placeholder="<?php if ($_ingathering_state == '') _e( '', 'lwr-custom' ); ?>" value="<?php if ($_ingathering_state != '') echo $_ingathering_state; ?>" /></label><br />
			
			<label for="_ingathering_zip"><?php _e( 'ZIP:', 'lwr-custom' ); ?> <input type="number" name="_ingathering_zip" id="_ingathering_zip" placeholder="<?php if ($_ingathering_zip == '') _e( '', 'lwr-custom' ); ?>" value="<?php if ($_ingathering_zip != '') echo $_ingathering_zip; ?>" /></label>
		</div>
	<?php }

	/**  Save Custom Post Type Fields  **/

	add_action('save_post', 'lwr_save_ingathering_location_details');
	function lwr_save_ingathering_location_details( ) {

		global $post;

		if ( ! isset( $_POST['lwr_ingathering_location_noncename'] ) ) {
			return;
		}

		if( ! wp_verify_nonce( $_POST['lwr_ingathering_location_noncename'], 'lwr_save_ingathering_location_details' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post->ID;
		}

		update_post_meta( $post->ID, '_ingathering_address', $_POST['_ingathering_address'] );
		update_post_meta( $post->ID, '_ingathering_city', $_POST['_ingathering_city'] );
		update_post_meta( $post->ID, '_ingathering_state', $_POST['_ingathering_state'] );
		update_post_meta( $post->ID, '_ingathering_zip', $_POST['_ingathering_zip'] );
	}
	

	/* Add custom columns to Admin View */

	add_action( 'manage_posts_custom_column', 'ingathering_columns' );
	function ingathering_columns( $column ) {
		global $post;
		$custom = get_post_custom($post->ID);
		$_ingathering_state = $custom["_ingathering_state"][0];
		$_ingathering_city = $custom["_ingathering_city"][0];
				
		switch( $column ) {
			case 'ingathering_state':		
				echo esc_attr($_ingathering_state);
				break;			
				
			case 'ingathering_city':
				echo esc_attr($_ingathering_city);
				break;
		}
	}

	add_filter('manage_ingathering_posts_columns', 'set_ingatherings_columns');
	function set_ingatherings_columns($columns) {
		$new = array();
		
		foreach( $columns as $key=>$title) {
			if ($key == 'taxonomy-lwr_seasons') {
				$new['ingathering_city'] = __('City');
				$new['ingathering_state'] = __('State');
			}
			$new[$key] = $title;
		}
		return $new;
	}
	
	add_filter('manage_edit-ingathering_sortable_columns', 'make_ingathering_columns_sortable' );
	function make_ingathering_columns_sortable( $columns ) {
			$columns[ 'ingathering_state' ] = 'ingathering_state';
			return $columns;
	}

	add_action( 'pre_get_posts', 'manage_ingathering_columns_sort');
	function manage_ingathering_columns_sort( $query ) {
		if($query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ){
			
			if( $orderby == 'ingathering_state') {
					$query->set('meta_key', '_ingathering_state' );
					$query->set( 'orderby', 'meta_value' );		
			}
		}
	}
	
?>