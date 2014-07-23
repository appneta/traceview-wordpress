<?php
/* Wordpress basic hooks */
add_action('wp_before_admin_bar_render','traceview_start_section',1);
add_action('wp_after_admin_bar_render','traceview_end_section',254);

add_action('comment_form_before','traceview_start_section',1);
add_action('comment_form_after','traceview_end_section',254);

add_action('comment_form_before_fields','traceview_start_section',1);
add_action('comment_form_after_fields','traceview_end_section',254);

add_action('dynamic_sidebar_before','traceview_start_section',1);
add_action('dynamic_sidebar_after','traceview_end_section',254);

add_action('before_signup_form','traceview_start_section',1);
add_action('after_signup_form','traceview_end_section',254);

add_action('before_delete_post','traceview_start_section',1);
add_action('after_delete_post','traceview_end_section',254);

add_action('loop_start','traceview_start_section',1);
add_action('loop_end','traceview_end_section',254);

add_action('comment_form_before','traceview_start_section',1);
add_action('comment_form_after','traceview_end_section',254);

add_action('comment_form_logged_in','traceview_start_section',1);
add_action('comment_form_Logged_in_after','traceview_end_section',254);

add_action('before_wp_tiny_mce','traceview_start_section',1);
add_action('after_wp_tiny_mce','traceview_end_section',254);

add_action('setup_theme','traceview_start_section',1);
add_action('after_setup_theme','traceview_end_section',254);

add_action('upgrader_pre_install','traceview_start_section',1);
add_action('upgrader_post_install','traceview_end_section',254);

add_action('foundation_social_pre_output','traceview_start_section',1);
add_action('foundation_social_post_output','traceview_end_section',254);

/* Point in time hooks are available */
tv_action_watch('the_post');

tv_filter_watch('the_posts');
tv_filter_watch('the_content');
tv_filter_watch('the_comments');

tv_action_watch('wp_head');
tv_action_watch('wp_meta');
tv_action_watch('wp_footer');

add_action('publish_post','traceview_log_hook');
add_action('plugins_loaded','traceview_log_hook');
add_action('muplugins_loaded','traceview_log_hook');
add_action('wp_loaded','traceview_log_hook');
add_action('admin_menu','traceview_log_hook');
add_action('admin_head','traceview_log_hook');
add_action('admin_footer','traceview_log_hook');
add_action('admin_init','traceview_log_hook');
add_action('admin_body_class','traceview_log_hook');
add_action('pre_get_posts','traceview_log_hook');
add_action('pre_get_comments','traceview_log_hook');
add_action('pre_http_request','traceview_log_hook');
add_action('generate_rewrite_rules','traceview_log_hook');
add_action('comment_loop_start','traceview_log_hook');


add_action('get_header','traceview_log_hook');
add_action('get_footer','traceview_log_hook');
?>
