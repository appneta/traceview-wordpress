<?php
/* Responsive theme specific hooks */
add_action('responsive_comments_after','traceview_end_section',254);
add_action('responsive_comments_before','traceview_start_section',1 );
add_action('responsive_container_end','traceview_end_section',254 );
add_action('responsive_container','traceview_start_section',1 );
add_action('responsive_entry_after','traceview_end_section',254  );
add_action('responsive_entry_before','traceview_start_section',1 );
add_action('responsive_header_end','traceview_end_section',254 );
add_action('responsive_header','traceview_start_section',1 );
add_action('responsive_widgets_after','traceview_end_section',254  );
add_action('responsive_widgets_before','traceview_start_section',1 );
add_action('responsive_wrapper_end','traceview_end_section',254  );
add_action('responsive_wrapper','traceview_start_section',1 );
tv_action_watch('responsive_entry_bottom');
tv_action_watch('responsive_entry_top');
tv_action_watch('responsive_footer_after');
tv_action_watch('responsive_footer_bottom');
tv_action_watch('responsive_footer_top');
tv_action_watch('responsive_header_bottom');
tv_action_watch('responsive_header_top');
tv_action_watch('responsive_in_header');
tv_action_watch('responsive_in_wrapper');
tv_action_watch('responsive_theme_options');
tv_action_watch('responsive_widgets_end');
tv_action_watch('responsive_widgets');
tv_action_watch('responsive_wrapper_bottom');
tv_action_watch('responsive_wrapper_top');
?>
