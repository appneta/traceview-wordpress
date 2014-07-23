<?php
/* WP-Touch theme specific hooks */
add_action( 'wptouch_pre_head','traceview_start_section' );
add_action( 'wptouch_post_head','traceview_end_section' );
add_action( 'wptouch_pre_footer','traceview_start_section' );
add_action( 'wptouch_post_footer','traceview_end_section' );
?>
