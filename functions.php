// include this code in your functions.php file in your theme or child theme

add_action( 'pre_get_posts', function ( $q )
{
    if (    !is_admin()
         && $q->is_main_query()
         && $q->is_single()
    ) {
        $q->set( 'post_status', ['publish', 'future'] );
    }
});

function wpb_upcoming_posts() { 
    // The query to fetch future posts
    $the_query = new WP_Query(array( 
        'post_status' => 'future',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'ASC'
    ));
 
// The loop to display posts
if ( $the_query->have_posts() ) {
  while ( $the_query->have_posts() ) {
    $the_query->the_post();
    $output .= '<div class="slide">'.get_the_post_thumbnail() .'<div class="event-desc"><span class="event-title">'. get_the_title().'</span><span class="av-vertical-delimiter"></span>'
     .'<span class="event-content">'.get_the_content().'</span><span class="event-date">'.  get_the_time('Y-D-dM').'</span>'.'<span class="event-author">'.get_the_author().'</span></div>' . '</div>';
}

 
} else {
    // Show this when no future posts are found
    $output .= '<p>No posts planned yet.</p>';
}
 
// Reset post data
wp_reset_postdata();
 
// Return output
 
return $output; 
} 
// Add shortcode
add_shortcode('upcoming_posts', 'wpb_upcoming_posts'); 
// Enable shortcode execution inside text widgets
add_filter('widget_text', 'do_shortcode');
