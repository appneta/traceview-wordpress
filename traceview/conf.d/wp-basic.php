<?php
/* Wordpress basic hooks */

# add_action('wp_before_admin_bar_render','traceview_start_section',1);
# add_action('wp_after_admin_bar_render','traceview_end_section',254);

add_action('comment_form_before','traceview_start_section',1);
add_action('comment_form_after','traceview_end_section',254);

# add_action('comment_form_before_fields','traceview_start_section',1);
# add_action('comment_form_after_fields','traceview_end_section',254);

add_action('dynamic_sidebar_before','traceview_start_section',1);
add_action('dynamic_sidebar_after','traceview_end_section',254);

# add_action('before_signup_form','traceview_start_section',1);
# add_action('after_signup_form','traceview_end_section',254);

add_action('before_delete_post','traceview_start_section',1);
add_action('after_delete_post','traceview_end_section',254);

add_action('loop_start','traceview_start_section',1);
add_action('loop_end','traceview_end_section',254);

# add_action('comment_form_logged_in','traceview_start_section',1);
# add_action('comment_form_Logged_in_after','traceview_end_section',254);

# add_action('before_wp_tiny_mce','traceview_start_section',1);
# add_action('after_wp_tiny_mce','traceview_end_section',254);

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
# tv_filter_watch('the_comments');

tv_action_watch('wp_head');
tv_action_watch('wp_meta');
tv_action_watch('wp_footer');

tv_action_watch('publish_post');
tv_action_watch('plugins_loaded');
tv_action_watch('muplugins_loaded');
tv_action_watch('wp_loaded');
tv_action_watch('admin_menu');
tv_action_watch('admin_head');
tv_action_watch('admin_footer');
tv_action_watch('admin_init');
tv_action_watch('admin_body_class');
# tv_action_watch('pre_get_posts');
# tv_action_watch('pre_get_comments');

# --------------------------------
# Do not trace this hook - doing so will break the Plugin
# search screen
# tv_action_watch('pre_http_request');
# --------------------------------

tv_action_watch('generate_rewrite_rules');
tv_action_watch('comment_loop_start');

# add_action('get_header','traceview_log_hook');
# add_action('get_footer','traceview_log_hook');
?>
