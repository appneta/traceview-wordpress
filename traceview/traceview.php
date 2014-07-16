<?php
/**
 * Plugin Name: TraceView by AppNeta
 * Plugin URI: https://github.com/appneta/traceview-wordpress
 * Description: A simple plug-in for intrsumenting TraceView under WordPress.
 * Version: 0.3beta
 * Author: Greg Bromage <gbromage@appneta.com
 * Author URI: http://www.appneta.com
 * License: GPL2
 */

/* Check to see that we're being called properly */
defined('ABSPATH') or die("No script kiddies please!");

function traceview_start_section($args) { 
    if (extension_loaded("oboe")) { 
       $hookname = current_filter();
       $strip_list = array('_before','_after','before_','after_','pre_','post_','_start','_end');
       $hookname = str_replace($strip_list, '',$hookname);
       $hookname = str_replace('__', '_',$hookname); /* check for double underscores */

       $hookname = "wordpress-$hookname";
       oboe_log_entry($hookname);
    }
}

function traceview_end_section($args) {
    if (extension_loaded("oboe")) { 
       $hookname = current_filter();
       $strip_list = array('_before','_after','before_','after_','pre_','post_','_start','_end');
       $hookname = str_replace($strip_list, '',$hookname);
       $hookname = str_replace('__', '_',$hookname);  /* check for double underscores */

       $hookname = "wordpress-$hookname";
       oboe_log_exit($hookname);
    }
}

function traceview_log_hook() {
    if (extension_loaded("oboe")) { 
        $hookname = current_filter();
        oboe_log(null,'info', array('hook'=>$hookname, 'hook-type'=>'action'));
    }
}

function traceview_log_filter_start($content) {
    if (extension_loaded("oboe")) { 
       $hookname = current_filter();
       $hookname = "wordpress-$hookname";
       oboe_log_entry($hookname);
    }
    return $content;
}
function traceview_log_filter_end($content) {
    if (extension_loaded("oboe")) { 
       $hookname = current_filter();
       $hookname = "wordpress-$hookname";
       oboe_log_exit($hookname);
    }
    return $content;
}

function traceview_log_action_start() {
    if (extension_loaded("oboe")) { 
       $hookname = current_filter();
       $hookname = "wordpress-$hookname";
       oboe_log_entry($hookname);
    }
}
function traceview_log_action_end() {
    if (extension_loaded("oboe")) { 
       $hookname = current_filter();
       $hookname = "wordpress-$hookname";
       oboe_log_exit($hookname);
    }
}

function tv_action_watch($actionname) {
    add_action($actionname,'traceview_log_action_start',1);
    add_action($actionname,'traceview_log_action_end',255);

}
function tv_filter_watch($filtername) {
    add_filter($filtername,'traceview_log_filter_start',1);
    add_filter($filtername,'traceview_log_filter_end',255);
}


/* Entry and exit hooks are available */
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

// add_action('grant_super_admin','traceview_start_section',1);
// add_action('granted_super_admin','traceview_end_section',254);


/* TwentyFourteen theme specific hooks */
add_action('twentyfourteen_featured_posts_before','traceview_start_section',1);
add_action('twentyfourteen_featured_posts_after','traceview_end_section',254);
add_action('twentyfourteen_credits','traceview_log_hook');

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

/* WP-Touch theme specific hooks */
add_action( 'wptouch_pre_head','traceview_start_section' );
add_action( 'wptouch_post_head','traceview_end_section' );
add_action( 'wptouch_pre_footer','traceview_start_section' );
add_action( 'wptouch_post_footer','traceview_end_section' );

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
// add_action('login_form','traceview_log_hook');
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

// Akismet and spam management
tv_action_watch('akismet_comment_check_response','traceview_log_hook');
tv_action_watch('akismet_spam_caught','traceview_log_hook');
tv_action_watch('akismet_submit_nospam_comment','traceview_log_hook');
tv_action_watch('akismet_submit_spam_comment','traceview_log_hook');
add_action('check_comment_flood','traceview_log_hook');

add_action('all_admin_notices','traceview_log_hook');
add_action('archive_blog','traceview_log_hook');

// Authentication cookies
add_action('auth_cookie_valid','traceview_log_hook');
add_action('auth_cookie_bad_hash','traceview_log_hook');
add_action('auth_cookie_bad_username','traceview_log_hook');
add_action('auth_cookie_expired','traceview_log_hook');
add_action('auth_cookie_malformed','traceview_log_hook');
add_action('clear_auth_cookie','traceview_log_hook');
add_action('set_auth_cookie','traceview_log_hook');
tv_filter_watch('check_password','traceview_log_hook');

// Cache management
add_action('clear_post_cache','traceview_log_hook');
add_action('clear_page_cache','traceview_log_hook');
add_action('clear_term_cache','traceview_log_hook');
add_action('clear_attachment_cache','traceview_log_hook');

// Comment management
add_action('comment_add_author_url','traceview_log_hook');
add_action('comment_comment_closed','traceview_log_hook');
add_action('comment_flood_trigger','traceview_log_hook');
add_action('comment_form','traceview_log_hook');
add_action('comment_form_comments_closed','traceview_log_hook');
add_action('comment_form_must_log_in_after','traceview_log_hook');
add_action('comment_on_draft','traceview_log_hook');
add_action('comment_on_password_protected','traceview_log_hook');
add_action('comment_on_trash','traceview_log_hook');
add_action('comment_post','traceview_log_hook');
add_action('comment_remove_author_url','traceview_log_hook');

// add_action('','traceview_log_hook');
// add_action('','traceview_log_hook');
// add_action('','traceview_log_hook');
// add_action('','traceview_log_hook');


// Now add controller / actions

function traceview_add_to_content( $content ) {

    if (extension_loaded("oboe")) { 
        if( is_front_page() || is_home() ) {
	    oboe_log("info", array("Controller" => "wordpress", "Action" => "home"));
        } elseif( is_single() ) {
	    oboe_log("info", array("Controller" => "wordpress", "Action" => "post"));
        } elseif( is_page() ) {
	    oboe_log("info", array("Controller" => "wordpress", "Action" => "page"));
        } elseif( is_category() ) {
	    oboe_log("info", array("Controller" => "wordpress", "Action" => "category"));
        } elseif( is_tag() ) {
	    oboe_log("info", array("Controller" => "wordpress", "Action" => "tag"));
        } elseif( is_author() ) {
	    oboe_log("info", array("Controller" => "wordpress", "Action" => "author"));
        } elseif( is_date() ) {
	    oboe_log("info", array("Controller" => "wordpress", "Action" => "date"));
        } elseif( is_search() ) {
	    oboe_log("info", array("Controller" => "wordpress", "Action" => "search"));
        } elseif( is_feed() ) {
	    oboe_log("info", array("Controller" => "wordpress", "Action" => "feed"));
	} elseif( is_admin() ) {
	    oboe_log("info", array("Controller" => "wordpress", "Action" => "admin"));
        }
    }

    return $content;
}

add_filter('the_content', 'traceview_add_to_content');

/**
  ----------------------------
  Options menu

**/

function traceview_add_options()
{
  if(is_multisite()) {
    add_site_option('traceview_client_key', 'Not set', "Your TraceView Client Key (obtain this from the TraceView console Get Started page");
    add_site_option('traceview_application_name', 'Default', "The application name in your TraceView console for this web application");
    add_site_option('traceview_add_annotations', 1, "When ticked, TraceView will report annotations for certain system events");
  } else {
    add_option('traceview_client_key', 'Not set', "Your TraceView Client Key (obtain this from the TraceView console Get Started page");
    add_option('traceview_application_name', 'Default', "The application name in your TraceView console for this web application");
    add_option('traceview_add_annotations', 1, "When ticked, TraceView will report annotations for certain system events");
  }
}

traceview_add_options();

function traceview_options_page()
{
    global $ClientKey, $AppName, $Annotate;
    $updated = false;

    if( isset($_POST['Submit']) )
    {
        $ClientKey = $_POST['traceview_client_key'];
        $AppName = $_POST['traceview_application_name'];
        $Annotate = ($_POST['traceview_add_annotations'] == 1);
        if($Annotate) { $ann = 1; } else { $ann = 0; }

        if(is_multisite()) {
            update_site_option('traceview_client_key', $ClientKey);
            update_site_option('traceview_application_name', $AppName);
            update_site_option('traceview_add_annotations', $ann);
        } else {
            update_option('traceview_client_key', $ClientKey);
            update_option('traceview_application_name', $AppName);
            update_option('traceview_add_annotations', $ann);
	}
        traceview_annotate('TraceView plugin settings updated');
        $updated = true;
    };

    $ClientKey = is_multisite() ? get_site_option('traceview_client_key') : get_option('traceview_client_key');
    $AppName = is_multisite() ? get_site_option('traceview_application_name') : get_option('traceview_application_name');
    $Annotate = is_multisite() ? get_site_option('traceview_add_annotations') : get_option('traceview_add_annotations');

if($updated)
{
echo <<<EOHTML
<div class="updated">
<p>Options saved.</p>
</div>
EOHTML;
}

$AnnotateFlag = '';
if($Annotate == 1) {$AnnotateFlag = 'checked '; }

echo <<<EOHTML
<div class="wrap">
<h2>TraceView by AppNeta Settings</h2>
<form method="post" action="{$_SERVER['REQUEST_URI']}">
<fieldset class="options">       
<legend>Add TraceView options</legend>       
<label for="">Client Key:</label>     
<input type="text" size="45" name="traceview_client_key" value="{$ClientKey}" title="The client key of your TraceView account." /><br />
<label for="">Application name:</label>
<input type="text" size="45" name="traceview_application_name" value="{$AppName}" title="The application name, as defined in your TraceView dashboard." /><br />

<label for="">Add annotations</label>

<input type="checkbox" name="traceview_add_annotations" value="1" title="When checked, TraceView will add annotations for certain system events." {$AnnotateFlag} /><br />

</fieldset>
<input type="submit" name="Submit" value="Update Options" />
</form>
</div>
EOHTML;

}


function traceview_admin_menu()
{
   // We use the "update_core" permission, on the premise that only server admins should be doing this
   add_submenu_page('settings.php', 'TraceView', 'TraceView by AppNeta', 'update_core', 'traceview.php', 'traceview_options_page');
}

//Hook for admin menu (multi-site safe)
$hook = is_multisite() ? 'network_' : '';
add_action( "{$hook}admin_menu", 'traceview_admin_menu');


function traceview_annotate($message) {
    $ClientKey = is_multisite() ? get_site_option('traceview_client_key') : get_option('traceview_client_key');
    $ShouldAnnotate = is_multisite() ? get_site_option('traceview_add_annotations') : get_option('traceview_add_annotations');


    // Only do this if Curl is installed and we know the client key, and annotations box was checked
    if($ClientKey != 'Not set' && function_exists('curl_version') && $ShouldAnnotate==1) {
        oboe_log_entry('wordpress-traceview-annotate');
        $AppName = is_multisite() ? get_site_option('traceview_application_name') : get_option('traceview_application_name');

	$current_user = wp_get_current_user();

    
        $url = 'https://api.tv.appneta.com/api-v2/log_message';
        $fields = array(
    		'message' => urlencode($message),
		'appname' => urlencode($AppName),
		'key' => urlencode($ClientKey),
		'username' => urlencode($current_user->user_login)
		);

	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');

	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	//execute post
	$curl_result = curl_exec($ch);

	//close connection
	curl_close($ch);
        oboe_log_exit('wordpress-traceview-annotate');
    }

}

function tv_annotate_upgrade($wp_db_version, $wp_current_db_version) {
    traceview_annotate("WordPress version was upgraded from $wp_current_db_version to $wp_db_version");
}
add_action('wp_upgrade','tv_annotate_upgrade');


function tv_annotate_theme_switch($oldtheme) {
    global $blog_id;
    $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
    $thetheme = wp_get_theme();
    $Annotation = $current_blog_details->blogname . " has changed theme; new theme is " . $thetheme->get('Name') . " version " . $thetheme->get('Version');
    traceview_annotate($Annotation);
}
add_action('after_switch_theme','tv_annotate_theme_switch');

function tv_annotate_plugin_activate($plugin, $networkwide=null) {
    if($networkwide) {
        $Annotation = "Network-wide plugin activated: $plugin";
        traceview_annotate($Annotation);
    } else {
        global $blog_id;
        $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
        $Annotation = $current_blog_details->blogname . " has activated new plugin: $plugin ";
        traceview_annotate($Annotation);
    }
}
add_action('activated_plugin','tv_annotate_plugin_activate');

function tv_annotate_plugin_deactivate($plugin, $networkwide=null) {
    if($networkwide) {
        $Annotation = "Network-wide plugin deactivated: $plugin";
        traceview_annotate($Annotation);
    } else {
        global $blog_id;
        $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
        $Annotation = $current_blog_details->blogname . " has deactivated a plugin: $plugin ";
        traceview_annotate($Annotation);
    }
}
add_action('deactivated_plugin','tv_annotate_plugin_deactivate');



?>
