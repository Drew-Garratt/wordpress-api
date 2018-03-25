<?php
/**
 * By default, in Add/Edit Post, WordPress moves checked categories to the top of the list, and unchecked to the bottom.
 * When you have subcategories that you want to keep below their parents at all times, this makes no sense.
 * This function removes that automatic reordering so the categories widget retains its order regardless of checked state.
 * Thanks to https://stackoverflow.com/a/12586404
 */
function taxonomy_checklist_checked_ontop_filter ( $args ) {
	$args['checked_ontop'] = false;
	return $args;
}

add_filter( 'wp_terms_checklist_args', 'taxonomy_checklist_checked_ontop_filter' );

/**
 * Customize the preview button in the WordPress admin to point to the headless client.
 *
 * @param  str $link The WordPress preview link.
 * @return str The headless WordPress preview link.
 */
function set_headless_preview_link( $link ) {
	return get_frontend_origin() . '/'
		. '_preview/'
		. get_the_ID() . '/'
		. wp_create_nonce( 'wp_rest' );
}

add_filter( 'preview_post_link', 'set_headless_preview_link' );

/**
 * Customize the link button in the WordPress admin to point to the headless client.
 */
function changePermalinks($permalink, $post) {
	return str_replace(env('WP_HOME'), env('FE_ORIGIN'), $permalink);
}

add_filter( 'post_link', 'changePermalinks', 10, 3);
add_filter( 'page_link', 'changePermalinks', 10, 3);
add_filter( 'post_type_link', 'changePermalinks', 10, 3);
add_filter( 'category_link', 'changePermalinks', 11, 3);
add_filter( 'tag_link', 'changePermalinks', 10, 3);
add_filter( 'author_link', 'changePermalinks', 11, 3);
add_filter( 'day_link', 'changePermalinks', 11, 3);
add_filter( 'month_link', 'changePermalinks', 11, 3);
add_filter( 'year_link', 'changePermalinks', 11, 3);