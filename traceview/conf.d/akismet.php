<?php
// Akismet and spam management
tv_action_watch('akismet_comment_check_response');
tv_action_watch('akismet_spam_caught');
tv_action_watch('akismet_submit_nospam_comment');
tv_action_watch('akismet_submit_spam_comment');
tv_action_watch('check_comment_flood');
?>
