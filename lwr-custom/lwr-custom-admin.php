<?php


	/******************************************************
			Fix Admin Menu in Chrome
	*******************************************************/
	function chromefix_inline_css() { wp_add_inline_style( 'wp-admin', '#adminmenu { transform: translateZ(0); }' ); }
		add_action('admin_enqueue_scripts', 'chromefix_inline_css');


	/******************************************************
			Admin Favicon
	 ******************************************************/
	function lwr_admin_favicon() {
		$uploads = wp_upload_dir();
		?>
		<link rel="icon" href="<?php echo esc_url( $uploads['baseurl'] . '/FAVICON.ico'); ?>" />
		<?php
	}
	add_action( 'admin_enqueue_scripts', 'lwr_admin_favicon' );
	 
	/******************************************************
			DEPRECATED: Edit actual homepage instead
			Homepage Admin Option
	 ********************************* *********************/
	/* function lwr_register_homepage_menu_option() {

		add_menu_page( 'Homepage Settings', 'Homepage', 'edit_others_posts', 'lwr_homepage', 'lwr_homepage_menu_page', 'dashicons-admin-home', 27 );

		add_action( 'admin_init', 'lwr_register_homepage_menu_settings' );
	}
	add_action( 'admin_menu', 'lwr_register_homepage_menu_option' );

	function lwr_register_homepage_menu_settings() {
		register_setting( 'lwr_homepage_menu_settings_donate', 'homepage_donate_image' );
		register_setting( 'lwr_homepage_menu_settings_donate', 'homepage_donate_item' );
		register_setting( 'lwr_homepage_menu_settings_donate', 'homepage_donate_heading' );
		register_setting( 'lwr_homepage_menu_settings_donate', 'homepage_donate_excerpt' );

		register_setting( 'lwr_homepage_menu_settings_video', 'homepage_video_image' );
		register_setting( 'lwr_homepage_menu_settings_video', 'homepage_video_link' );
		register_setting( 'lwr_homepage_menu_settings_video', 'homepage_video_excerpt' );
		register_setting( 'lwr_homepage_menu_settings_video', 'homepage_video_instruction' );

		register_setting( 'lwr_homepage_menu_settings_support', 'homepage_support_year' );
		register_setting( 'lwr_homepage_menu_settings_support', 'homepage_support_people' );
		register_setting( 'lwr_homepage_menu_settings_support', 'homepage_support_countries' );
		register_setting( 'lwr_homepage_menu_settings_support', 'homepage_support_projects' );
	}

	function lwr_homepage_menu_page_tabs( $current = 'donate' ) {
		$tabs = array( 
			'donate' => 'Quick Donate',
			'video' => 'Video Banner',
			'stats' => 'LWR By the Numbers'
			);
		echo '<div id="icon-themes" class="icon32"><br /></div>';
		echo '<h2 class="nav-tab-wrapper">';
		foreach( $tabs as $tab=>$name){
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			echo '<a class="nav-tab' . $class . '" href="?page=lwr_homepage&tab=' .$tab.'">'.$name.'</a>';
		}
		echo '</h2>';
	}

	function lwr_homepage_menu_page() {
		if ( !current_user_can( 'edit_others_posts' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		} ?>

		<div class="wrap custom-admin-menu">
			<h2>Homepage Settings</h2>

			<?php if ( isset ( $_GET['tab'] ) ) { 
			lwr_homepage_menu_page_tabs($_GET['tab']); 
		} else {
			lwr_homepage_menu_page_tabs('donate');
		} 
		
		if( isset ( $_GET['tab'])) {
			$tab = $_GET['tab'];
		} else{
			$tab = 'donate';
		}
		switch ( $tab ){
			case 'donate' :	
			
		?>
		<form id="posts-filter" method="post" action="options.php">
				<?php settings_fields( 'lwr_homepage_menu_settings_donate' ); ?>
				<?php do_settings_sections( 'lwr_homepage_menu_settings_donate' ); ?>
			<h3>Quick Donate Option</h3>

			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="homepage_donate_item">WooCommerce Product </label></th>
						<td><select name="homepage_donate_item"><?php 
									$args = array(
										'post_type' => array( 'product', 'product_variation'),
										'posts_per_page' => -1,
										'orderby' => 'date'
										);
				
									$woo_query = new WP_Query ( $args );
									while( $woo_query->have_posts() ) :
									$woo_query->the_post();
									
									$product_id = get_the_ID();
									?>
									<option value="<?php echo $product_id; ?>" <?php 
										if( $product_id == get_option('homepage_donate_item' ) ) {
											echo 'selected="selected"';
										} ?> ><?php the_title(); ?></option>
									<?php
									wp_reset_postdata();
									endwhile;
									?>
									
								</select>
							</td>
					</tr>
					<tr>
						<th scope="row"><label for="homepage_donate_heading">Heading</label></th>
						<td><input type="text" name="homepage_donate_heading" value="<?php echo esc_attr( get_option('homepage_donate_heading') ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="homepage_donate_excerpt">Description</label></th>
						<td><textarea class="text-field" name="homepage_donate_excerpt" ><?php echo esc_attr( get_option('homepage_donate_excerpt') ); ?></textarea></td>
					</tr>
				</tbody>
			</table>
				
				<p>
					<a class="button" id="upload_button" href="javascript:;" >Upload Background Image</a>
				</p>
				<div id="lwr-image-container" class="hidden">
					<img src="<?php echo esc_url( get_option('homepage_donate_image') ); ?>" alt="" title="" />
				</div>
				<p class="hide-if-no-js hidden">
					<a title="Remove Image" href="javascript:;" id="remove-image">Remove Background Image</a>
				</p>
				<p id="lwr-image-meta">
					<input type="hidden" id="ad-thumbnail-src" name="homepage_donate_image" value="<?php echo esc_url( get_option('homepage_donate_image') ); ?>" />
				</p>
				<style>
					#lwr-image-container { width: 600px; } 
					#lwr-image-container img { max-width: 100%; }
					.text-field { height: 8em; width: 600px; }
				</style>

		<?php		submit_button(); ?>
			</form><?php 

			break;
			case 'video' :
		?>
		<form id="posts-filter" method="post" action="options.php">
				<?php settings_fields( 'lwr_homepage_menu_settings_video' ); ?>
				<?php do_settings_sections( 'lwr_homepage_menu_settings_video' ); ?>

			<h3>Video Banner</h3>


			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="homepage_video_image">Banner Image</label></th>
						<td><input type="text" name="homepage_video_image" value="<?php echo esc_attr( get_option('homepage_video_image') ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="homepage_video_link">Video Link</label></th>
						<td><input type="text" name="homepage_video_link" value="<?php echo esc_attr( get_option('homepage_video_link') ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="homepage_video_excerpt">Video Excerpt</label></th>
						<td><textarea name="homepage_video_excerpt" /><?php echo esc_attr( get_option('homepage_video_excerpt') ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="homepage_video_instruction">Video Instruction</label></th>
						<td><input class="text-field" type="text" name="homepage_video_instruction" value="<?php echo esc_attr( get_option('homepage_video_instruction') ); ?>" /></td>
					</tr>
				</tbody>
			</table>

			<?php submit_button(); ?>
			</form><?php

				break;
				case 'stats' :
			?>
			<form id="posts-filter" method="post" action="options.php">
				<?php settings_fields( 'lwr_homepage_menu_settings_support' ); ?>
				<?php do_settings_sections( 'lwr_homepage_menu_settings_support' ); ?>

				<h3>Reach of Support Stats</h3>

				<p>
					<label for="homepage_support_year">Year</label>
					<input type="number" name="homepage_support_year" value="<?php echo esc_attr( get_option('homepage_support_year') ); ?>" />
				</p>
				
				<p>
					<label for="homepage_support_people">People Helped</label>
					<input type="number" name="homepage_support_people" value="<?php echo esc_attr( get_option('homepage_support_people') ); ?>" />
				</p>

				<p>
					<label for="homepage_support_countries">Countries Worked In</label>
					<input type="number" name="homepage_support_countries" value="<?php echo esc_attr( get_option('homepage_support_countries') ); ?>" />
				</p>

				<p>
					<label for="homepage_support_projects">Projects Worked On</label>
					<input type="number" name="homepage_support_projects" value="<?php echo esc_attr( get_option('homepage_support_projects') ); ?>" />
				</p>

			<style>
				div.custom-admin-menu form label { margin-right: 10px; vertical-align: top; }
				div.custom-admin-menu form input[type="text"] { vertical-align: top; width: 45%; }
				div.custom-admin-menu form textarea { height: 100px; resize: none; width: 55%; }
			</style>
		</div>
		
	<?php
			submit_button(); ?>
			</form><?php

		break;
		}
		
	}
	
	
	function homepage_menu_scripts() {
		wp_register_script('lwr-admin', plugin_dir_url( __FILE__ ) . 'js/admin.js', array('media-views', 'media-editor', 'jquery' ) );

		if( 'toplevel_page_lwr_homepage' == get_current_screen()->id ) {
			wp_enqueue_media();			
			wp_enqueue_script('lwr-admin');
		}
	}
	add_action('admin_enqueue_scripts', 'homepage_menu_scripts' );
	
	function homepage_setup() {
		global $pagenow;
		
		if( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
			add_filter( 'gettext', 'replace_thickbox_text', 1, 3 );
		}
	}
	add_action( 'admin_init', 'homepage_setup' );
	
	function replace_homepage_thickbox_text($text) {
		if('Insert into Post' == $text) {
			$referer = strpos( wp_get_referer(), 'lwr_homepage' );
			if ($referer != '' ) {
				return 'Set Background Image';
			}
		}
		return $text;
	}
	*/


	/******************************************************
			DEPRECATED: Use Advanced Custom Fields "Alert Settings Instead"
			Emergency Admin Option
	 ******************************************************/
	/* 
	function lwr_register_emergency_menu_option() {
		
		add_menu_page( 'Emergency Settings', 'Alerts', 'edit_others_posts', 'lwr_emergency', 'lwr_emergency_menu_page', 'dashicons-megaphone', 28 );

		add_action( 'admin_init', 'lwr_register_emergency_menu_settings' );
	}
	add_action( 'admin_menu', 'lwr_register_emergency_menu_option' );

	function lwr_register_emergency_menu_settings() {
		register_setting( 'lwr_emergency_menu_settings_group', 'is_current_emergency' );
		register_setting( 'lwr_emergency_menu_settings_group', 'emergency_name' );
		register_setting( 'lwr_emergency_menu_settings_group', 'emergency_excerpt' );
		register_setting( 'lwr_emergency_menu_settings_group', 'emergency_calltoaction' );
		register_setting( 'lwr_emergency_menu_settings_group', 'emergency_url' );
		register_setting( 'lwr_emergency_menu_settings_group', 'modal_toggle' );
		register_setting( 'lwr_emergency_menu_settings_group', 'modal_title' );
		register_setting( 'lwr_emergency_menu_settings_group', 'modal_background' );
		register_setting( 'lwr_emergency_menu_settings_group', 'modal_text' );
	}
	
	function lwr_emergency_menu_page_tabs( $current = 'bar' ) {
		$tabs = array( 
			'bar' => 'Red Bar Settings',
			'modal' => 'Modal Window Settings'
			);
		echo '<div id="icon-themes" class="icon32"><br /></div>';
		echo '<h2 class="nav-tab-wrapper">';
		foreach( $tabs as $tab=>$name){
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			echo '<a class="nav-tab' . $class . '" href="?page=lwr_emergency&tab=' .$tab.'">'.$name.'</a>';
		}
		echo '</h2>';
	}

	function lwr_emergency_menu_page() {
		if ( !current_user_can( 'edit_others_posts' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		} 


		?>
		<div class="wrap custom-admin-menu">
		<?php if ( isset ( $_GET['tab'] ) ) { 
			lwr_emergency_menu_page_tabs($_GET['tab']); 
		} else {
			lwr_emergency_menu_page_tabs('bar');
		} 
		
		if( isset ( $_GET['tab'])) {
			$tab = $_GET['tab'];
		} else{
			$tab = 'bar';
		}
		switch ( $tab ){
			case 'bar' :			
		?>
			<h2>Emergency Alert Settings</h2>

			<form id="posts-filter" method="post" action="options.php">
				<?php settings_fields( 'lwr_emergency_menu_settings_group' ); ?>
				<?php do_settings_sections( 'lwr_emergency_menu_settings_group' ); ?>

				<p>
					<label for="is_current_emergency">Show Current Emergency</label>
					<input type="checkbox" name="is_current_emergency" value="on" <?php
						if (get_option( 'is_current_emergency' ) == 'on') { echo 'checked'; }
					?>/>
				</p>

				<p>
					<label for="emergency_name">Emergency Name</label>
					<input type="text" name="emergency_name" value="<?php echo esc_attr( get_option('emergency_name') ); ?>" />
				</p>

				<p>
					<label for="emergency_excerpt">Emergency Excerpt</label>
					<textarea name="emergency_excerpt" /><?php echo esc_attr( get_option('emergency_excerpt') ); ?></textarea>
				</p>
				<p>
					<label for="emergency_calltoaction">Call to Action</label>
					<input type="text" name="emergency_calltoaction" value="<?php echo esc_attr( get_option('emergency_calltoaction') ); ?>" />
				</p>
				<p>
					<label for="emergency_url">URL Link</label>
					<input type="url" name="emergency_url" value="<?php echo esc_url( get_option('emergency_url') ); ?>" />
				</p>
				<?php submit_button(); ?>
			</form>
			<?php 
			break; 
			
			case 'modal':
			?>
			
			<h2>Modal Window (Pop-Up) Alert</h2>
			<form id="posts-filter" method="post" action="options.php">
				<?php settings_fields( 'lwr_emergency_menu_settings_group' ); ?>
				<?php do_settings_sections( 'lwr_emergency_menu_settings_group' ); ?>

				<p>
					<label for="modal_toggle">Show Modal Window</label>
					<input type="checkbox" name="modal_toggle" value="on" <?php
						if (get_option( 'modal_toggle' ) == 'on') { echo 'checked'; }
						?> />
				</p>
				<p>
					<label for="modal_title">Window Heading</label>
					<input type="text" name="modal_title" value="<?php echo esc_attr( get_option( 'modal_title') ); ?>" />
				</p>
				<p>
					<label for="modal_background">Background Image (URL)</label>
					<input type="url" name="modal_background" value="<?php echo esc_url( get_option( 'modal_background') ); ?>" />
				</p>
					<?php wp_editor( get_option('modal_text'), 'modal_text', array( 'media_buttons' => false ) ); ?>

			<h3>Preview:</h3>
					<div class="ui-dialog" >
						<div class="ui-dialog-titlebar">
							&nbsp;
						</div>
						<div id="dialog-text">
								<?php echo '<h2>' . esc_attr( get_option('modal_title') ) . '</h2>'; 
											echo '<p>' . get_option('modal_text') . '</p>'; ?>
						<input type="email" placeholder="Enter your email address&hellip;" style="background-color:#f2f2f2; color: #43454b; border-radius:2px; font-weight: 400; box-shadow:inset 0 1px 1px rgba(0,0,0,.125);width:60%;margin-left:10%;">
						<input type="submit" value="SIGN UP" style="background-color:#74c3e4; color:#fff;width:20%;">
						</div>
					</div>
				
		<style>
			.ui-dialog {
				position: relative;
				width:600px;
				max-width: 100%;
				display:block;
				min-height: 400px;
				border-radius: 3px;
				background: #fff url('<?php echo esc_url(get_option('modal_background') ); ?>') no-repeat;
				background-size: contain;
				padding: 10px;
				text-align:center;
				font-family: gesta, 'Century Gothic', arial, sans;
			}
			.ui-dialog-titlebar {
				background: none;
				border: none;
			}
			#dialog-text {
				padding-top:195px;
			}
			#dialog-text h2 {
				font-size: 1.93333333em;
				color:#74c3e4;
			}
			#dialog-text p {
				padding: 1em 10px;
				margin: 1em 0;
				color: #333;
				width:100%;
				float:none;
				position: relative;
			}
			#dialog-text input[type=email] {
				width: 60%;
			}
			
		</style>
				
				<?php submit_button(); ?>
			</form>
			
			<?php
			break;
		}
		?>
			<style>
				div.custom-admin-menu form label { margin-right: 10px; vertical-align: top; }
				div.custom-admin-menu form input[type="text"] { vertical-align: top; width: 45%; }
				div.custom-admin-menu form textarea { height: 100px; resize: none; width: 55%; }
			</style>
		</div>
	<?php } */
	
?>