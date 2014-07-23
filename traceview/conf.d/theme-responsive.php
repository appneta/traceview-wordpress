<?php
/* Responsive theme specific hooks */
add_action('responsive_container','traceview_start_section' );
add_action('responsive_container_end','traceview_end_section' );
add_action('responsive_header','traceview_start_section' );
add_action('responsive_header_top','traceview_log_hook' );
add_action('responsive_in_header','traceview_log_hook' );
add_action('responsive_header_bottom','traceview_log_hook' );
add_action('responsive_header_end','traceview_end_section' );
add_action('responsive_wrapper','traceview_start_section' );
add_action('responsive_wrapper_top','traceview_log_hook' );
add_action('responsive_in_wrapper','traceview_log_hook' );
add_action('responsive_wrapper_bottom','traceview_log_hook' );
add_action('responsive_wrapper_end','traceview_end_section'  );
add_action('responsive_entry_before','traceview_start_section' );
add_action('responsive_entry_top','traceview_log_hook' );
add_action('responsive_entry_bottom','traceview_log_hook' );
add_action('responsive_entry_after','traceview_end_section'  );
add_action('responsive_comments_before','traceview_start_section' );
add_action('responsive_comments_after','traceview_end_section'  );
add_action('responsive_widgets_before','traceview_start_section' );
add_action('responsive_widgets','traceview_log_hook' );
add_action('responsive_widgets_end','traceview_log_hook' );
add_action('responsive_widgets_after','traceview_end_section'  );
add_action('responsive_footer_top','traceview_log_hook' );
add_action('responsive_footer_bottom','traceview_log_hook' );
add_action('responsive_footer_after','traceview_log_hook' );
add_action('responsive_theme_options','traceview_log_hook' );
?>
