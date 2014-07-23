<?php
/* TwentyFourteen theme specific hooks */
add_action('twentyfourteen_featured_posts_before','traceview_start_section',1);
add_action('twentyfourteen_featured_posts_after','traceview_end_section',254);
add_action('twentyfourteen_credits','traceview_log_hook');
?>
