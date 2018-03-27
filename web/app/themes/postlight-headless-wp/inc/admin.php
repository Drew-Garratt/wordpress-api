<?php
/**
 * By default, in Add/Edit Post, WordPress moves checked categories to the top of the list, and unchecked to the bottom.
 * When you have subcategories that you want to keep below their parents at all times, this makes no sense.
 * This function removes that automatic reordering so the categories widget retains its order regardless of checked state.
 * Thanks to https://stackoverflow.com/a/12586404
 */
function taxonomy_checklist_checked_ontop_filter($args)
{
    $args['checked_ontop'] = false;
    return $args;
}

add_filter('wp_terms_checklist_args', 'taxonomy_checklist_checked_ontop_filter');

/**
 * Customize the preview button in the WordPress admin to point to the headless client.
 *
 * @param  str $link The WordPress preview link.
 * @return str The headless WordPress preview link.
 */
function set_headless_preview_link($link)
{
    $post_id = get_the_ID();
    $revisions = wp_get_post_revisions($post_id);
    $latest_revision = array_shift($revisions);
    if ($latest_revision) {
        return get_frontend_origin() . '/'
            . 'news/_preview/?id='
            . $post_id . '&revision='
            . $latest_revision->ID . '&token='
            . wp_create_nonce('wp_rest');
    } else {
        return get_frontend_origin() . '/'
            . 'news/_preview/?id='
            . $post_id .'&token='
            . wp_create_nonce('wp_rest');
    }
}

add_filter('preview_post_link', 'set_headless_preview_link');

/**
 * Customize the link button in the WordPress admin to point to the headless client.
 */
function change_permalinks($permalink, $post)
{
    return str_replace(env('WP_HOME'), env('FE_ORIGIN'), $permalink);
}
function change_news_permalinks($permalink, $post)
{
    return str_replace(env('WP_HOME'), env('FE_ORIGIN') . '/news', $permalink);
}

add_filter('post_link', 'change_news_permalinks', 10, 3);
add_filter('page_link', 'change_permalinks', 10, 3);
add_filter('post_type_link', 'change_permalinks', 10, 3);
add_filter('category_link', 'change_permalinks', 11, 3);
add_filter('tag_link', 'change_permalinks', 10, 3);
add_filter('author_link', 'change_permalinks', 11, 3);
add_filter('day_link', 'change_permalinks', 11, 3);
add_filter('month_link', 'change_permalinks', 11, 3);
add_filter('year_link', 'change_permalinks', 11, 3);

function limit_page_depth($a)
{
    $a['depth'] = 1;
    return $a;
}
add_action('page_attributes_dropdown_pages_args', 'limit_page_depth');
