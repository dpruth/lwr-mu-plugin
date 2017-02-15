<?php

	// Change Title Text


	add_filter( 'enter_title_here', 'staff_member_change_title' );
	function staff_member_change_title( $title ) {
		$screen = get_current_screen();
		if ( $screen->post_type == 'staffmember' ) {
			$title = __( 'Staff Name', 'lwr-custom' );
		}
		return $title;
	}

	/**
	 * Change Featured Image title
	 *
	 * Removes the default featured image box and adds a new one with a new title
	 *
	 */

	add_action('do_meta_boxes', 'lwr_staff_member_featured_image_text');
	function lwr_staff_member_featured_image_text() {

		remove_meta_box( 'postimagediv', 'staffmember', 'side' );
		if (current_theme_supports('post-thumbnails')) {
			add_meta_box('postimagediv', __('Staff Photo', 'lwr-custom'), 'post_thumbnail_meta_box', 'staffmember', 'normal', 'high');
		} else {
			add_meta_box('staff-member-warning', __('Staff Photo', 'lwr-custom'), 'lwr_staff_member_warning_meta_box', 'staffmember', 'normal', 'high');
		}
	}



	/**
	 * Adds MetaBoxes for staff-member
	 *
	 */

	add_action('do_meta_boxes', 'lwr_staff_member_add_meta_boxes');
	function lwr_staff_member_add_meta_boxes() {

		add_meta_box('staff-member-info', __('Staff Member Info', 'lwr-custom'), 'lwr_staff_member_info_meta_box', 'staffmember', 'normal', 'high');

	   // add_meta_box('staff-member-bio', __('Staff Member Bio', 'lwr-custom'), 'lwr_staff_member_bio_meta_box', 'staffmember', 'normal', 'high');
	}



	/**
	 * Displays Staff Member INFO Meta Box
	 *
	 * Callback function to display meta box
	 *
	 * @param    object		$post    				Contains the global $post object
	 * @param    array		$custom    				Contains the post's custom meta
	 * @param    string		$_staff_member_title    Staff member job title
	 * @param    string		$_staff_member_email    Staff member email address
	 * @param    string		$_staff_member_phone    Staff member phone number
	 *
	 */

	function lwr_staff_member_info_meta_box(){
		global $post;
		$custom = get_post_custom($post->ID);
		$_staff_member_title = $custom["_staff_member_title"][0];
		$_staff_member_email = $custom["_staff_member_email"][0];
		$_staff_member_phone = $custom["_staff_member_phone"][0];
		$_staff_member_tw	 = $custom["_staff_member_tw"][0];

		wp_nonce_field( 'lwr_save_staff_member_details', 'lwr_add_edit_staff_member_noncename' );

		?>

		<div>
			<label for="_staff-member-title"><?php _e( 'Position:', 'lwr-custom' ); ?> <input type="text" name="_staff_member_title" id="_staff_member_title" placeholder="<?php if ($_staff_member_title == '') _e( 'Staff Member\'s Position', 'lwr-custom' ); ?>" value="<?php if ($_staff_member_title != '') echo $_staff_member_title; ?>" /></label><br />

			<label for="_staff-member-email"><?php _e( 'Email:', 'lwr-custom' ); ?> <input type="text" name="_staff_member_email" id="_staff_member_email" placeholder="<?php if ($_staff_member_email == '') _e( 'Staff Member\'s Email', 'lwr-custom' ); ?>" value="<?php if ($_staff_member_email != '') echo $_staff_member_email; ?>" /></label><br />

			<label for="_staff-member-title"><?php _e( 'Phone:', 'lwr-custom' ); ?> <input type="text" name="_staff_member_phone" id="_staff_member_phone" placeholder="<?php if ($_staff_member_phone == '') _e( 'Staff Member\'s Phone', 'lwr-custom' ); ?>" value="<?php if ($_staff_member_phone != '') echo $_staff_member_phone; ?>" /></label><br />

			<label for="_staff-member-tw"><?php _e( 'Twitter Username:', 'lwr-custom' ); ?><input type="text" name="_staff_member_tw" id="_staff_member_tw" placeholder="<?php if ($_staff_member_tw == '') _e( 'Staff Member\'s Twitter Name', 'lwr-custom' ); ?>" value="<?php if ($_staff_member_tw != '') echo $_staff_member_tw; ?>" /></label>
		</div>
	<?php
	}


	/*
	// Create Custom Columns
	//////////////////////////////*/


	/**
	 * Adds custom columns for staff-member CPT admin display
	 *
	 * @param    array    $cols    New column titles
	 * @return   array             Column titles
	 */

	add_filter( "manage_staff-member_posts_columns", "lwr_staff_member_custom_columns" );
	function lwr_staff_member_custom_columns( $cols ) {
		$cols = array(
			'cb'                  =>     '<input type="checkbox" />',
			'title'               => __( 'Name', 'lwr-custom' ),
			'photo'               => __( 'Photo', 'lwr-custom' ),
			'_staff_member_title' => __( 'Position', 'lwr-custom' ),
			'_staff_member_email' => __( 'Email', 'lwr-custom' ),
			'_staff_member_phone' => __( 'Phone', 'lwr-custom' ),
			'_staff_member_bio'   => __( 'Bio', 'lwr-custom' ),
		);
		return $cols;
	}


	/*
	// Template Tags
	//////////////////////////////*/
	/**
	 * function which is used as the backend for all other template tags
	 * @param integer $staff_id the ID of the staff member.
	 * @param $meta_field the name of the meta field
	 * @return string | boolean the value of meta field. If nothing could be found false will be returned
	 */
	function _staff_member_meta( $staff_id = null, $meta_field) {
		global $post;
		if( is_null( $staff_id)) $staff_id = $post->ID;
		if( $meta_field == '_staff_member_image') {
			return wp_get_attachment_url( get_post_thumbnail_id( $staff_id) );
		} else {
			return get_post_meta( $staff_id, $meta_field, true);
		}
	}

	/**
	 * returns or echo the postion of a staff member,
	 * @param integer $staff_id the ID of a staff member
	 * @param boolean $echo if true, result will be echoed
	 * @return string | boolean the position of a staff member or false
	 */
	function staff_member_title( $staff_id = null, $echo = false) {
		$position = _staff_member_meta( $staff_id, '_staff_member_title');
		if( $echo ) echo $position;
		return $position;
	}

	/**
	 * shortcut to echo the positon of a staff member,
	 * @param integer $staff_id the ID of a staff member
	 * @return void
	 */
	function the_staff_member_position( $staff_id = null) {
		staff_member_position( $staff_id, true);
	}

	/**
	 * returns or echo the bio of a staff member
	 * @param integer $staff_id the ID of a staff member
	 * @param boolean $echo if true, result will be echoed
	 * @return string | boolean the bio of a staff member or false
	 */
	function staff_member_bio( $staff_id = null, $echo = false) {
	   $bio = _staff_member_meta( $staff_id, '_staff_member_bio', true);
	   if( $echo ) echo $bio;
	   return $bio;
	}

	/**
	 * shortcut to echo the bio of a staff member
	 * @param integer $staff_id the ID of a staff member
	 * @return void
	 */
	function the_staff_member_bio( $staff_id = null) {
		staff_member_bio( $staff_id, true);
	}

	/**
	 * return or echo the email of a staff member
	 * @param integer $staff_id the ID of a staff member
	 * @param boolean $echo if true, result will be echoed
	 * @return string | boolean the email of a staff member of false
	 */
	function staff_member_email( $staff_id = null, $echo = false) {
		$email = _staff_member_meta( $staff_id, '_staff_member_email');

		if( $echo ) echo antispambot($email);
		return antispambot($email);
	}


	/**
	 * shortcut to echo the email of a staff member
	 * @param integer $staff_id the ID of a staff member
	 * @return void
	 */
	function the_staff_member_email( $staff_id = null) {
		staff_member_email( $staff_id, true);
	}
	/**
	 * returns or echo the facebook url of a staff member
	 * @param integer $staff_id the ID of a staff member
	 * @param boolean $echo if true, result will be echoed
	 * @return string | boolean the facebook url of a staff member or false
	 */
	function staff_member_facebook( $staff_id = null, $echo = false) {
		$fb = _staff_member_meta( $staff_id, '_staff_member_fb');
		if( $echo ) echo $fb;
		return $fb;
	}

	/**
	 * returns or echo the twitter url of a staff member
	 * @param integer $staff_id the ID of a staff member
	 * @param boolean $echo if true, result will be echoed
	 * @return string | boolean the twitter url of a staff member or false
	 */
	function staff_member_twitter( $staff_id = null, $echo = false) {
		$twitter = _staff_member_meta( $staff_id, '_staff_member_tw');
		if( $echo) echo $twitter;
		return $twitter;
	}

	/**
	 * shortcut to echo the twitter url of a staff member
	 * @param integer $staff_id the ID of a staff member
	 * @return void
	 */
	function the_staff_member_twitter( $staff_id = null) {
		staff_member_twitter( $staff_id, true);
	}


	/**
	 * returns or echo the featured image url of a staff member
	 * @param integer $staff_id the ID of a staff member
	 * @param boolean $echo if true, result will be echoed
	 * @return string | boolean the image url of a staff member or false
	 */
	function staff_member_image_url( $staff_id = null, $echo = false) {
		$photo_url = _staff_member_meta( $staff_id, '_staff_member_image');
		if ( $echo) echo $photo_url;
		return $photo_url;
	}

	/**
	 * shortcut to echo the image url of a staff member
	 * @param integer $staff_id the ID of a staff member
	 * @return void
	 */
	function the_staff_member_image_url( $staff_id = null) {
		staff_member_image_url( $staff_id, true);
	}

	//////  Register and write the AJAX callback function to actually update the posts on sort.
	/////

			add_action( 'wp_ajax_staff_member_update_post_order', 'lwr_staff_member_update_post_order' );

			function lwr_staff_member_update_post_order() {
				global $wpdb;

				$post_type     = $_POST['postType'];
				$order        = $_POST['order'];

				/**
				*    Expect: $sorted = array(
				*                menu_order => post-XX
				*            );
				*/
				foreach( $order as $menu_order => $post_id )
				{
					$post_id         = intval( str_ireplace( 'post-', '', $post_id ) );
					$menu_order     = intval($menu_order);
					wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
				}

				die( '1' );
			}


	//////  Save Custom Post Type Fields
	//////

			add_action('save_post', 'lwr_save_staff_member_details');

			function lwr_save_staff_member_details( ) {

				global $post;

				if ( ! isset( $_POST['lwr_add_edit_staff_member_noncename'] ) ) {
					return;
				}

				if( ! wp_verify_nonce( $_POST['lwr_add_edit_staff_member_noncename'], 'lwr_save_staff_member_details' ) ) {
					return;
				}

				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
					return $post->ID;
				}

				update_post_meta($post->ID, "_staff_member_bio", $_POST["_staff_member_bio"]);
				update_post_meta($post->ID, "_staff_member_title", $_POST["_staff_member_title"]);
				update_post_meta($post->ID, "_staff_member_email", $_POST["_staff_member_email"]);
				update_post_meta($post->ID, "_staff_member_phone", $_POST["_staff_member_phone"]);
				update_post_meta($post->ID, "_staff_member_tw", $_POST["_staff_member_tw"]);

			}

	/////// Allow Sort by Department in List of Staff Members
	///////
	
		add_action( 'restrict_manage_posts', 'my_restrict_manage_posts' );
		function my_restrict_manage_posts() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'staffmember') {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        $filters = array('departments','offices');

        foreach ($filters as $tax_slug) {
            // retrieve the taxonomy object
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            // retrieve array of term objects per taxonomy
            $terms = get_terms($tax_slug);

            // output html for taxonomy dropdown filter
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>Show All $tax_name</option>";
            foreach ($terms as $term) {
                // output each select option line, check against the last $_GET to show the current option selected
                echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
            }
            echo "</select>";
        }
			}
		}

?>