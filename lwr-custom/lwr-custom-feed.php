<?php
/*
 * Add Featured Images to RSS Feed
 */
 
 add_filter( 'rss2_ns', 'lwr_media_ns' );
 function lwr_media_ns() {
	 echo 'xmlns:media="http://search.yahoo.com/mrss/"';
 }
 
 
 add_filter( 'rss2_item', 'lwr_rss_featured_image');
 function lwr_rss_featured_image() {
		if(get_the_post_thumbnail() ) { ?>
			<media:content url="<?php 
				$image_id = get_post_thumbnail_id($post->ID);
				$image = wp_get_attachment_image_src( $image_id, 'full' ); 
				
				echo $image[0]; ?>" medium="image"> 
				<media:description type="plain"><![CDATA[<?php the_post_thumbnail_caption( $post->ID ); ?>]]></media:description>
			</media:content>
			<?php
		}
 }

?>