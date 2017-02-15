<?php

	/******************************************************
			Advertisement Admin Option
	 ******************************************************/
	function lwr_ad_default_options() {
		$options = array(
			'img' => ''
		);
		return $options;
	}
	
	function lwr_ad_init() {
		$lwr_ad_options = get_option( 'lwr_ad_options' );
		
		if ( false === $lwr_ad_options ) {
			$lwr_ad_options = lwr_ad_default_options();
			add_option( 'lwr_ad_options', $lwr_ad_options );
		}
	}
	add_action( 'admin_init', 'lwr_ad_init' );
	 
	function lwr_register_ad_menu_option() {
		add_posts_page( 'Advertisements', 'Advertisements', 'edit_others_posts', 'lwr_ads', 'post_ad_menu_page', 'dashicons-awards', 29 );

		add_action( 'admin_init', 'lwr_register_ad_menu_settings' );
	}
	add_action( 'admin_menu', 'lwr_register_ad_menu_option' );
	
	function lwr_register_ad_menu_settings() {
				register_setting( 'lwr_ad_menu_settings_group', 'is_ad_enabled' );
				register_setting( 'lwr_ad_menu_settings_group', 'ad_url' );
				register_setting( 'lwr_ad_menu_settings_group', 'lwr_ad_options' );
				register_setting( 'lwr_ad_menu_settings_group', 'ad-thumbnail-src' );
				register_setting( 'lwr_ad_menu_settings_group', 'ad-thumbnail-title' );
				register_setting( 'lwr_ad_menu_settings_group', 'ad-thumbnail-alt' );
				add_settings_field('lwr_ad_img', 'Ad Image', 'lwr_ad_img', 'lwr_ads', 'lwr_ad_menu_settings_group' );
	}


	function post_ad_menu_page() {
		if ( !current_user_can( 'edit_others_posts' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		?>
		
		<div class="wrap custom-admin-menu">
			<h2>Post Advertisements</h2>

			<form id="posts-filter" method="post" action="options.php">

			<?php 
						settings_fields( 'lwr_ad_menu_settings_group' ); 
						do_settings_sections( 'lwr_ad_menu_settings_group' );
				?>

				<p>
					<label for="is_ad_enabled">Enable Ad on Posts</label>
					<input type="checkbox" name="is_ad_enabled" value="on" <?php
						if (get_option( 'is_ad_enabled' ) == 'on') { echo 'checked'; }
					?>/><br />
					<small>When checked, advertisement will display after third paragraph of all blog posts.</small>
				</p>
				<p>
					<label for="ad_url">Where ad links (URL)</label>
					<input type="url" name="ad_url" value="<?php echo esc_url( get_option('ad_url') ); ?>" />
				</p>
		<?php $lwr_ad_options = get_option( 'lwr_ad_options' );	?>
				<p>
					<a class="button" id="upload_ad_button" href="javascript:;" >Upload Ad Image</a>
				</p>
				<div id="lwr-ad-image-container" class="hidden">
					<img src="<?php echo esc_url( get_option('ad-thumbnail-src') ); ?>" alt="" title="" />
				</div>
				<p class="hide-if-no-js hidden">
					<a title="Remove Image" href="javascript:;" id="remove-ad-image">Remove Ad Image</a>
				</p>
				<p id="lwr-ad-image-meta">
					<input type="hidden" id="ad-thumbnail-src" name="ad-thumbnail-src" value="<?php echo esc_url( get_option('ad-thumbnail-src') ); ?>" />
					<input type="hidden" id="ad-thumbnail-title" name="ad-thumbnail-title" value="<?php echo esc_attr( get_option('ad-thumbnail-title') ); ?>" />
					<input type="hidden" id="ad-thumbnail-alt" name="ad-thumbnail-alt" value="<?php echo esc_attr( get_option('ad-thumbnail-alt') ); ?>" />
				</p>

			<?php submit_button(); ?>
			</form>
		</div>
<?php
	}

	
	
	function lwr_ad_validate( $input ) {

	}
	
	function post_ad_menu_scripts() {
		wp_register_script('lwr-admin', plugin_dir_url( __FILE__ ) . 'js/admin.js', array('media-views', 'media-editor', 'jquery' ) );
		
		if( 'posts_page_lwr_ads' == get_current_screen()->id ) {
			wp_enqueue_media();			
			wp_enqueue_script('lwr-admin');
		}
	}
	add_action('admin_enqueue_scripts', 'post_ad_menu_scripts' );
	
	function post_ad_setup() {
		global $pagenow;
		
		if( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
			add_filter( 'gettext', 'replace_thickbox_text', 1, 3 );
		}
	}
	add_action( 'admin_init', 'post_ad_setup' );
	
	function replace_thickbox_text($text) {
		if('Insert into Post' == $text) {
			$referer = strpos( wp_get_referer(), 'lwr_ads' );
			if ($referer != '' ) {
				return 'Set Ad Image';
			}
		}
		return $text;
	}


	//Insert ads after second paragraph of single post content.
	
	add_filter( 'the_content', 'prefix_insert_post_ads' );

	function prefix_insert_post_ads( $content ) {
		$is_ad_enabled = get_option('is_ad_enabled');
		$ad_url = get_option('ad_url');
		$ad_img = get_option('ad-thumbnail-src');
		$ad_alt = get_option('ad-thumbnail-alt');
		$ad_title = get_option('ad-thumbnail-title');

		
    $ad_code = '<aside class="advertisement" itemscope itemtype="http://schema.org/WPAdBlock"><a href="' . esc_url($ad_url) . '" itemprop="url" ><img src="' . esc_url($ad_img) . '" alt="' . esc_attr($ad_alt) . '" title="' . esc_attr($ad_title) .  '" itemprop="image" /></a></aside>';
		
    if ( 'post' == get_post_type() && $is_ad_enabled == 'on' ) {
       return prefix_insert_after_paragraph( $ad_code, 3, $content );
    }
    return $content;
	}

  // Parent Function that makes the magic happen
	function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
    $closing_p = '</p>';

    $paragraphs = explode( $closing_p, $content );

    foreach ($paragraphs as $index => $paragraph) {
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }
        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }
    return implode( '', $paragraphs );
	}

?>