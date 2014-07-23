<?php
// Akismet and spam management
tv_action_watch('akismet_comment_check_response','traceview_log_hook');
tv_action_watch('akismet_spam_caught','traceview_log_hook');
tv_action_watch('akismet_submit_nospam_comment','traceview_log_hook');
tv_action_watch('akismet_submit_spam_comment','traceview_log_hook');
add_action('check_comment_flood','traceview_log_hook');
?>
