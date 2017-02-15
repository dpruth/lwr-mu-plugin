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
		?>
		<link rel="icon" href="//lwr.org/wp-content/uploads/FAVICON.ico" />
		<?php
	}
	add_action( 'admin_enqueue_scripts', 'lwr_admin_favicon' );
	 
	/******************************************************
			Homepage Admin Option
	 ******************************************************/
	function lwr_register_homepage_menu_option() {
		add_menu_page( 'Homepage Settings', 'Homepage', 'edit_others_posts', 'lwr_homepage', 'lwr_homepage_menu_page', 'dashicons-admin-home', 27 );

		add_action( 'admin_init', 'lwr_register_homepage_menu_settings' );
	}
	add_action( 'admin_menu', 'lwr_register_homepage_menu_option' );

	function lwr_register_homepage_menu_settings() {
		register_setting( 'lwr_homepage_menu_settings_group', 'homepage_video_image' );
		register_setting( 'lwr_homepage_menu_settings_group', 'homepage_video_link' );
		register_setting( 'lwr_homepage_menu_settings_group', 'homepage_video_excerpt' );
		register_setting( 'lwr_homepage_menu_settings_group', 'homepage_video_instruction' );

		register_setting( 'lwr_homepage_menu_settings_group', 'homepage_support_year' );
		register_setting( 'lwr_homepage_menu_settings_group', 'homepage_support_people' );
		register_setting( 'lwr_homepage_menu_settings_group', 'homepage_support_countries' );
		register_setting( 'lwr_homepage_menu_settings_group', 'homepage_support_projects' );
	}

	function lwr_homepage_menu_page() {
		if ( !current_user_can( 'edit_others_posts' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		} ?>

		<div class="wrap custom-admin-menu">
			<h2>Homepage Settings</h2>

			<form id="posts-filter" method="post" action="options.php">
				<?php settings_fields( 'lwr_homepage_menu_settings_group' ); ?>
				<?php do_settings_sections( 'lwr_homepage_menu_settings_group' ); ?>

				<h3>Video Banner</h3>

				<p>
					<label for="homepage_video_image">Banner Image</label>
					<input type="text" name="homepage_video_image" value="<?php echo esc_attr( get_option('homepage_video_image') ); ?>" />
				</p>

				<p>
					<label for="homepage_video_link">Video Link</label>
					<input type="text" name="homepage_video_link" value="<?php echo esc_attr( get_option('homepage_video_link') ); ?>" />
				</p>

				<p>
					<label for="homepage_video_excerpt">Video Excerpt</label>
					<textarea name="homepage_video_excerpt" /><?php echo esc_attr( get_option('homepage_video_excerpt') ); ?></textarea>
				</p>

				<p>
					<label for="homepage_video_instruction">Video Instruction</label>
					<input class="text-field" type="text" name="homepage_video_instruction" value="<?php echo esc_attr( get_option('homepage_video_instruction') ); ?>" />
				</p>

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

				<?php submit_button(); ?>
			</form>

			<style>
				div.custom-admin-menu form label { margin-right: 10px; vertical-align: top; }
				div.custom-admin-menu form input[type="text"] { vertical-align: top; width: 45%; }
				div.custom-admin-menu form textarea { height: 100px; resize: none; width: 55%; }
			</style>
		</div>
	<?php }

	/******************************************************
			Emergency Admin Option
	 ******************************************************/
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

	function lwr_emergency_menu_page() {
		if ( !current_user_can( 'edit_others_posts' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		} ?>

		<div class="wrap custom-admin-menu">
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
				
			<h2>Modal Window (Pop-Up) Alert</h2>
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
					<div style="width: 600px; display:block; height: auto; border-radius:3px;">
						<div style="position:relative; z-index: 995; text-align: center;">
							<span style="font-size: 1.933333em; color: #fff; font-weight:800; text-transform:uppercase"><?php echo esc_attr( get_option('modal_title') ); ?><span>
						</div>
						<div style="display:block; position: relative; width:auto; min-height: 146px; max-height:none; height:auto; margin-top:-30px;">
							<img src="<?php echo esc_url(get_option('modal_background') ); ?>" style="position:relative; width:100%;" />
							<div style="width:60%; float:right; padding:18px; position: absolute; top:26px; right:0; color: #fff;">
								<?php echo get_option('modal_text'); ?>
							</div>
					</div>


				<?php submit_button(); ?>
			</form>

			<style>
				div.custom-admin-menu form label { margin-right: 10px; vertical-align: top; }
				div.custom-admin-menu form input[type="text"] { vertical-align: top; width: 45%; }
				div.custom-admin-menu form textarea { height: 100px; resize: none; width: 55%; }
			</style>
		</div>
	<?php }
	
?>