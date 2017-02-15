<?php

/******
	Plugin Name: LWR Custom Plugin
	Description: Custom code and functionality not associated with our theme file
	Author: MCS
	Version: 1.0
*******/

	include dirname( __FILE__ ) .'/lwr-custom/lwr-custom-meta.php';
	include dirname( __FILE__ ) .'/lwr-custom/lwr-custom-posttypes.php';
	include dirname( __FILE__ ) .'/lwr-custom/lwr-custom-taxonomies.php';
	include dirname( __FILE__ ) .'/lwr-custom/lwr-custom-admin.php';
	include dirname( __FILE__ ) .'/lwr-custom/lwr-custom-csv.php';
	include dirname( __FILE__ ) .'/lwr-custom/lwr-custom-staff.php';
	include dirname( __FILE__ ) .'/lwr-custom/lwr-custom-projectlocation.php';
	include dirname( __FILE__ ) .'/lwr-custom/lwr-custom-ingatherings.php';
	// include dirname( __FILE__ ) .'/lwr-custom/lwr-custom-postads.php';
	include dirname( __FILE__ ) .'/lwr-custom/lwr-custom-feed.php';

?>