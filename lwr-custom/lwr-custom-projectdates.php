<?php

	/** Adds Meta Box for Project Dates **/

	add_action('do_meta_boxes', 'lwr_project_dates_meta_boxes');
	function lwr_project_dates_meta_boxes() {
		add_meta_box('project_dates', __('Project Dates', 'lwr-custom'), 'lwr_project_dates_meta_box', 'project', 'normal', 'low');
	}

	/** Display Project Meta Box **/

	function lwr_project_dates_meta_box(){
		global $post;
		$custom = get_post_custom($post->ID);
		$_project_startdate = $custom["_project_startdate"][0];
		$_project_enddate  = $custom["_project_enddate"][0];

		wp_nonce_field( 'lwr_save_project_dates_details', 'lwr_project_dates_noncename' );

		?>

		<div>
			<label for="_project_startdate"><?php _e( 'Start Date:', 'lwr-custom' ); ?> <input type="text" name="_project_startdate" id="_project_startdate" placeholder="<?php if ($_project_startdate == '') _e( '', 'lwr-custom' ); ?>" value="<?php if ($_project_startdate != '') echo $_project_startdate; ?>" /></label><br />

			<label for="_project_enddate"><?php _e( 'End Date:', 'lwr-custom' ); ?> <input type="text" name="_project_enddate" id="_project_enddate" placeholder="<?php if ($_project_enddate == '') _e( '', 'lwr-custom' ); ?>" value="<?php if ($_project_enddate != '') echo $_project_enddate; ?>" /></label>
		</div>
	<?php }

	/**  Save Custom Post Type Fields  **/

	add_action('save_post', 'lwr_save_project_dates_details');
	function lwr_save_project_dates_details( ) {

		global $post;

		if ( ! isset( $_POST['lwr_project_dates_noncename'] ) ) {
			return;
		}

		if( ! wp_verify_nonce( $_POST['lwr_project_dates_noncename'], 'lwr_save_project_dates_details' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post->ID;
		}

		update_post_meta( $post->ID, '_project_startdate', $_POST['_project_startdate'] );
		update_post_meta( $post->ID, '_project_startdate', $_POST['_project_startdate'] );
	}
	
	/** Add DatePicker to field **/
	
	add_action( 'admin_enqueue_scripts', 'register_admin_scripts' );
	
	function register_admin_scripts() {
		wp_enqueue_script( 'jquery-ui-datepicker', 'js/admin.js' );
		wp_enqueue_style( 'jquery-ui-datepicker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css' );
	}
?>