<?php
//create the homepage on activation
if (isset($_GET['activated']) && is_admin()){

	$frontpage_title = 'Front Page'; //front page title
	$postspage_title = 'News'; //news page title

	//don't change the code bellow, unless you know what you're doing

	$frontpage_check = get_page_by_title($frontpage_title);
	$postspage_check = get_page_by_title($postspage_title);
	$new_frontpage = array(
		'post_type' => 'page', 
		'post_title' => $frontpage_title,
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
	$new_postspage = array(
		'post_type' => 'page', 
		'post_title' => $postspage_title,
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($frontpage_check->ID)){
		wp_insert_post($new_frontpage);
		$homepage = get_page_by_title($frontpage_title);
		if ( $homepage ) {
			update_option( 'page_on_front', $homepage->ID );
			update_option( 'show_on_front', 'page' );
		}
	}
	if(!isset($postspage_check->ID)){
		wp_insert_post($new_postspage);
		$blog = get_page_by_title($postspage_title);	
		if ( $blog ) {
			update_option( 'page_for_posts', $blog->ID );
		}
	}
}