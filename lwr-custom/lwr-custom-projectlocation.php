<?php

	/** Adds Meta Box for Project Location **/

	add_action('do_meta_boxes', 'lwr_project_location_meta_boxes');
	function lwr_project_location_meta_boxes() {
		add_meta_box('project_location', __('Project Location', 'lwr-custom'), 'lwr_project_location_meta_box', array('project', 'ingathering'), 'normal', 'high');
	}

	/** Display Project Meta Box **/

	function lwr_project_location_meta_box(){
		global $post;
		$custom = get_post_custom($post->ID);
		$_project_longitude = $custom["_project_longitude"][0];
		$_project_latitude  = $custom["_project_latitude"][0];

		wp_nonce_field( 'lwr_save_project_location_details', 'lwr_project_location_noncename' );

		?>

		<div>
			<p><a href="http://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Calculate Latitude and Longitude from an address</a></p>

			<label for="_project_latitude"><?php _e( 'Latitude:', 'lwr-custom' ); ?> <input type="text" name="_project_latitude" id="_project_latitude" placeholder="<?php if ($_project_latitude == '') _e( '', 'lwr-custom' ); ?>" value="<?php if ($_project_latitude != '') echo esc_attr($_project_latitude); ?>" /></label>
			
			<label for="_project_longitude"><?php _e( 'Longitude:', 'lwr-custom' ); ?> <input type="text" name="_project_longitude" id="_project_longitude" placeholder="<?php if ($_project_longitude == '') _e( '', 'lwr-custom' ); ?>" value="<?php if ($_project_longitude != '') echo esc_attr($_project_longitude); ?>" /></label><br />
		</div>
	<?php }

	/**  Save Custom Post Type Fields  **/

	add_action('save_post', 'lwr_save_project_location_details');
	function lwr_save_project_location_details( ) {

		global $post;

		if ( ! is_numeric( $_POST['_project_longitude'] ) ) {
			add_settings_error( 'invalid_longitude', '', 'Longitude must be a number', 'error' );
			return;
		}
		
		if ( ! is_numeric( $_POST['_project_latitude'] ) ) {
			add_settings_error( 'invalid_latitude', '', 'Latitude must be a number', 'error' );
			return;
		}
		
		if ( ! isset( $_POST['lwr_project_location_noncename'] ) ) {
			return;
		}

		if( ! wp_verify_nonce( $_POST['lwr_project_location_noncename'], 'lwr_save_project_location_details' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post->ID;
		}

		update_post_meta( $post->ID, '_project_longitude', $_POST['_project_longitude'] );
		update_post_meta( $post->ID, '_project_latitude', $_POST['_project_latitude'] );
		
	}

?>