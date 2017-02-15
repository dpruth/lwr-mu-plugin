<?php

	/**************************************************
					SOCIAL MEDIA METADATA
	***************************************************/
	// Catch that Image
		function catch_that_image() {
			global $post, $posts;
			$first_img = '';
			ob_start();
			ob_end_clean();
			
			$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
			
			if ( !empty($output) ) {
				$first_img = $matches [1] [0];
			} else { $first_img = '/wp-content/themes/lwr/img/blankproject.png'; }
			return $first_img;
		}

	
	// TWITTER & FACEBOOK

		function lwr_add_social($post) {
			global $post;
			?>
			
				<meta property="twitter:account_id" content="18810634" />
				<meta name="twitter:card" content="summary_large_image" />
				<meta name="twitter:site" content="@LuthWorldRelief" />
				<meta name="twitter:creator" content="@LuthWorldRelief" />
				<meta property="fb:app_id" content="1424877374508042" />
				<meta property="og:site_name" content="<?php bloginfo('name'); ?>" /><?php
				if ( is_front_page() || is_home() || is_archive() ) { 
				?>
				
				<meta name="twitter:url" content="<?php echo site_url(); ?>" />
				<meta property="og:url" content="<?php echo site_url(); ?>" />
				<meta property="og:description" content="<?php bloginfo('description'); ?>" />
				<meta property="og:type" content="website" />
				<meta property="og:image" content="<?php echo site_url() . '/wp-content/uploads/RS11705_140722_006-lpr.jpg'; ?>" />
				<?php
				} else { 
				
				$excerpt = apply_filters('get_the_excerpt', get_post_field('post_excerpt', $post->ID));
				if ( $excerpt == '' ) {
					$excerpt = wp_trim_words( $post->post_content, 55 );
				}
				?>
				
				<meta property="og:url" content="<?php the_permalink() ?>"/>
				<meta property="og:title" content="<?php echo get_the_title(); ?> | <?php bloginfo('name'); ?>" />
				<meta property="og:description" content="<?php echo esc_html( $excerpt ); ?>" />
				<meta property="og:type" content="article" />
				<?php 
					if ( has_post_thumbnail() ) {
					$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
					$att_meta = wp_get_attachment_metadata( get_post_thumbnail_id($post->ID) );
					$width = $att_meta['width'];
					$height = $att_meta['height'];
					
				?><meta property="og:image" content="<?php echo esc_url($url); ?>"/>
				<meta property="og:image:width" content="<?php echo esc_attr($width); ?>"/>
				<meta property="og:image:height" content="<?php echo esc_attr($height); ?>"/>
				
					<?php
					} else {
					?><meta property="og:image" content="<?php echo esc_url( catch_that_image() ); ?>" />
					<?php	
					}
				}
			}
		add_action( 'wp_head' , 'lwr_add_social' );
		
	 /*
		** i-Perceptions 4-Q Survey
		*/
		
		function lwr_add_4q() {
			
			if( strpos( $_SERVER['HTTP_HOST'], 'lwr.org') !== false) { ?>
				<script> window.iperceptionskey = '88cb9afc-3cca-4058-962e-d7c6d842ca2a';(function () { var a = document.createElement('script'),b = document.getElementsByTagName('body')[0]; a.type = 'text/javascript'; a.async = true;a.src = '//universal.iperceptions.com/wrapper.js';b.appendChild(a);})();</script>
			<?php
			}
		}
		
		add_action( 'wp_footer', 'lwr_add_4q' );
		
		/*
		 ** Facebook Pixel
		 */
		 
		function lwr_add_fb_pixel() {
			if( strpos( $_SERVER['HTTP_HOST'], 'lwr.org') !== false) {  
			?>
			
			<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js'); fbq('init', '814091628702882'); fbq('track', 'PageView'); <?php
			if( is_page() ) {
				global $post;
				switch ( $post->post_name ) { 
				case 'cart' :
							echo "fbq('track', 'AddToCart');";
							break;
				case 'checkout' :
							echo "fbq('track', 'InitiateCheckout');";
							break;
				case 'order-received' :
							echo "fbq('track', 'Purchase', {currency: 'USD'});";
							break;
				}
			}	
			?> </script><noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=814091628702882&ev=PageView&noscript=1" /></noscript>
		<?php	
			}
		}
		add_action( 'wp_footer', 'lwr_add_fb_pixel' );
		
		
		/*
		 * MailChimp Goal Tracking
		 */
		 
		function lwr_add_mailchimp() { ?>
			<script type="text/javascript">
				var $mcGoal = {'settings':{'uuid':'9ede5b497f32f90e55971b4c3','dc':'us11'}};
				(function() { var sp = document.createElement('script'); sp.type = 'text/javascript'; sp.async = true; sp.defer = true; sp.src = ('https:' == document.location.protocol ? 'https://s3.amazonaws.com/downloads.mailchimp.com' : 'http://downloads.mailchimp.com') + '/js/goal.min.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sp, s); })(); 
			</script>
		<?php 
		}
		add_action( 'wp_footer', 'lwr_add_mailchimp' );
		

		/*
		 * Twitter Goal Tracking
		 */
		function lwr_add_twitter() { ?>
			<script>
			!function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);
			},s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='//static.ads-twitter.com/uwt.js',
			a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');
			// Insert Twitter Pixel ID and Standard Event data below
			twq('init','nvy8a');
			twq('track','PageView');
			</script>
		<?php
		}
		add_action( 'wp_footer', 'lwr_add_twitter' );
?>