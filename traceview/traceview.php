<?php
/**
 * Plugin Name: TraceView by AppNeta
 * Plugin URI: https://github.com/appneta/traceview-wordpress
 * Description: A simple plug-in for intrsumenting TraceView under WordPress.
 * Version: 0.5b beta
 * Author: Greg Bromage <gbromage@appneta.com
 * Author URI: http://www.appneta.com
 * License: MIT Licence ( http://opensource.org/licenses/MIT )
 */

/* Check to see that we're being called properly */
defined('ABSPATH') or die("No script kiddies please!");
require 'tv-api-stub.php';

function traceview_start_section($args) { 
       $hookname = current_filter();
       $strip_list = array('_before','_after','before_','after_','pre_','post_','_start','_end');
       $hookname = str_replace($strip_list, '',$hookname);
       $hookname = str_replace('__', '_',$hookname); /* check for double underscores */
       $hookname = filter_var($hookname, FILTER_SANITIZE_STRING);
       $LayerPrefix = is_multisite() ? get_site_option('traceview_layer_prefix') : get_option('traceview_layer_prefix');

       $hookname = "$LayerPrefix$hookname";
       oboe_log_entry($hookname);
}

function traceview_end_section($args) {
       $hookname = (string)current_filter();
       $strip_list = array('_before','_after','before_','after_','pre_','post_','_start','_end');
       $hookname = str_replace($strip_list, '',$hookname);
       $hookname = str_replace('__', '_',$hookname);  /* check for double underscores */
       $hookname = filter_var($hookname, FILTER_SANITIZE_STRING);
       $LayerPrefix = is_multisite() ? get_site_option('traceview_layer_prefix') : get_option('traceview_layer_prefix');

       $hookname = "$LayerPrefix$hookname";
       oboe_log_exit($hookname);
}

function traceview_log_hook() {
        $hookname = current_filter();
        $hookname = filter_var($hookname, FILTER_SANITIZE_STRING);
        $LayerPrefix = is_multisite() ? get_site_option('traceview_layer_prefix') : get_option('traceview_layer_prefix');

        $hookname = "$LayerPrefix$hookname";
        oboe_log(null,'info', array('hook'=>$hookname, 'hook-type'=>'action'));
}

function traceview_log_filter_start($content) {
       $hookname = current_filter();
       $hookname = filter_var($hookname, FILTER_SANITIZE_STRING);
       $LayerPrefix = is_multisite() ? get_site_option('traceview_layer_prefix') : get_option('traceview_layer_prefix');
       $hookname = "$LayerPrefix$hookname";
       oboe_log_entry($hookname);
       return $content;
}
function traceview_log_filter_end($content) {
       $hookname = (string)current_filter();
       $hookname = filter_var($hookname, FILTER_SANITIZE_STRING);
       $LayerPrefix = is_multisite() ? get_site_option('traceview_layer_prefix') : get_option('traceview_layer_prefix');
       $hookname = "$LayerPrefix$hookname";
       oboe_log_exit($hookname);
       return $content;
}

function traceview_log_action_start() {
       $hookname = (string)current_filter();
       $hookname = filter_var($hookname, FILTER_SANITIZE_STRING);
       $LayerPrefix = is_multisite() ? get_site_option('traceview_layer_prefix') : get_option('traceview_layer_prefix');
       $hookname = "$LayerPrefix$hookname";
       oboe_log_entry($hookname);
}
function traceview_log_action_end() {
       $hookname = (string)current_filter();
       $hookname = filter_var($hookname, FILTER_SANITIZE_STRING);
       $LayerPrefix = is_multisite() ? get_site_option('traceview_layer_prefix') : get_option('traceview_layer_prefix');
       $hookname = "$LayerPrefix$hookname";
       oboe_log_exit($hookname);
}

function tv_action_watch($actionname) {
    add_action($actionname,'traceview_log_action_start',1);
    add_action($actionname,'traceview_log_action_end',255);

}

function tv_filter_watch($filtername) {
    add_filter($filtername,'traceview_log_filter_start',1);
    add_filter($filtername,'traceview_log_filter_end',255);
}

/*     Now add the actual hook connections */
foreach (glob( plugin_dir_path( __FILE__ ) . "conf.d/*.php") as $filename)
{
    require_once $filename;
    oboe_log(null,'info', array('includes'=>$filename));
}

//** **//

// Now add controller / actions

function traceview_add_to_content( $content ) {
     $controller = 'wordpress';
     if(is_multisite()) {
        global $blog_id;
        $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
        $controller = filter_var($current_blog_details->blogname, FILTER_SANITIZE_STRING);
     }

        if( is_front_page() || is_home() ) {
	    oboe_log("info", array("Controller" => $controller, "Action" => "home"));
        } elseif( is_single() ) {
	    oboe_log("info", array("Controller" => $controller, "Action" => "blog-post"));
        } elseif( is_page() ) {
	    oboe_log("info", array("Controller" => $controller, "Action" => "page"));
        } elseif( is_category() ) {
	    oboe_log("info", array("Controller" => $controller, "Action" => "category"));
        } elseif( is_tag() ) {
	    oboe_log("info", array("Controller" => $controller, "Action" => "tag"));
        } elseif( is_author() ) {
	    oboe_log("info", array("Controller" => $controller, "Action" => "author"));
        } elseif( is_date() ) {
	    oboe_log("info", array("Controller" => $controller, "Action" => "date"));
        } elseif( is_search() ) {
	    oboe_log("info", array("Controller" => $controller, "Action" => "search"));
        } elseif( is_feed() ) {
	    oboe_log("info", array("Controller" => $controller, "Action" => "feed"));
	    } elseif( is_admin() ) {
	    oboe_log("info", array("Controller" => $controller, "Action" => "admin"));
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
    add_site_option('traceview_layer_prefix', 'wp_', "This string will be pre-pended to the hook name to create the layer name.");
    add_site_option('traceview_add_annotations', 1, "When ticked, TraceView will report annotations for certain system events");
    add_site_option('traceview_add_autoconfig_button', 0, "When ticked, the Auto-generate button will be displayed");
  } else {
    add_option('traceview_client_key', 'Not set', "Your TraceView Client Key (obtain this from the TraceView console Get Started page");
    add_option('traceview_application_name', 'Default', "The application name in your TraceView console for this web application");
    add_option('traceview_layer_prefix', 'wp_', "This string will be pre-pended to the hook name to create the layer name.");
    add_option('traceview_add_annotations', 1, "When ticked, TraceView will report annotations for certain system events");
    add_option('traceview_add_autoconfig_button', 0, "When ticked, the Auto-generate button will be displayed");
  }
}
traceview_add_options();

function traceview_options_page()
{
    global $ClientKey, $AppName, $Annotate;
    $updated = false;

    if( isset($_POST['Submit']) )
    {
        $ClientKey = (string)trim($_POST['traceview_client_key']);
        $ClientKey = filter_var($ClientKey, FILTER_SANITIZE_STRING);
        
	$AppName = (string)trim($_POST['traceview_application_name']);
        $AppName = filter_var($AppName, FILTER_SANITIZE_STRING);
	
	$LayerPrefix = (string)trim($_POST['traceview_layer_prefix']);
	$LayerPrefix = filter_var($LayerPrefix, FILTER_SANITIZE_STRING);

		$ann = ($_POST['traceview_add_annotations'] == 1) ? 1 : 0;
        $autoconfig = ($_POST['traceview_add_autoconfig_button'] == 1) ? 1 : 0;
        
        if(is_multisite()) {
            update_site_option('traceview_client_key', $ClientKey);
            update_site_option('traceview_application_name', $AppName);
            update_site_option('traceview_layer_prefix', $LayerPrefix);
            update_site_option('traceview_add_annotations', $ann);
            update_site_option('traceview_add_autoconfig_button', $autoconfig);
        } else {
            update_option('traceview_client_key', $ClientKey);
            update_option('traceview_application_name', $AppName);
            update_option('traceview_layer_prefix', $LayerPrefix);
            update_option('traceview_add_annotations', $ann);
            update_option('traceview_add_autoconfig_button', $autoconfig);
	}
        traceview_annotate('TraceView plugin settings updated');
        $updated = true;
    };

    $ClientKey = is_multisite() ? get_site_option('traceview_client_key') : get_option('traceview_client_key');
    $AppName = is_multisite() ? get_site_option('traceview_application_name') : get_option('traceview_application_name');
    $Annotate = is_multisite() ? get_site_option('traceview_add_annotations') : get_option('traceview_add_annotations');
    $autoconfig = is_multisite() ? get_site_option('traceview_add_autoconfig_button') : get_option('traceview_add_autoconfig_button');
    $LayerPrefix = is_multisite() ? get_site_option('traceview_layer_prefix') : get_option('traceview_layer_prefix');

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
$AutoConfigFlag = '';
if($autoconfig == 1) {$AutoConfigFlag = 'checked '; }

echo <<<EOHTML
<div class="wrap">
<img src='http://www.appneta.com/images/graphics/logo.png' alt='AppNeta logo' /><h1>TraceView by AppNeta Settings</h1>
<form method="post" action="{$_SERVER['REQUEST_URI']}">
<fieldset class="options">       
<h2>Add TraceView options</h2>
<table>
    <tr>       
        <td><label for="traceview_client_key">Client Key:</label></td>
        <td><input type="text" size="45" name="traceview_client_key" id="traceview_client_key" value="{$ClientKey}" title="The client key of your TraceView account." /></td>
    </tr>       
    <tr>       
        <td><label for="traceview_layer_prefix">Layer prefix:</label></td>
        <td><input type="text" size="45" name="traceview_layer_prefix" id="traceview_layer_prefix" value="{$LayerPrefix}" title="This string will be pre-pended to the hook name when layers are created." /></td>
    </tr>       
    <tr>       
        <td><label for="traceview_application_name">Application name:</label></td>
        <td><input type="text" size="45" name="traceview_application_name" id="traceview_application_name" value="{$AppName}" title="The application name, as defined in your TraceView dashboard." /></td>
    </tr>       
    <tr>       
        <td><label for="traceview_add_annotations">Add annotations</label></td>
        <td><input type="checkbox" name="traceview_add_annotations" id="traceview_add_annotations" value="1" title="When checked, TraceView will add annotations for certain system events." {$AnnotateFlag} /></td>
    </tr>       
    <tr>       
        <td><label for="traceview_add_autoconfig_button">Add auto-config button to bottom of page</label></td>
        <td><input type="checkbox" name="traceview_add_autoconfig_button" id="traceview_add_autoconfig_button" value="1" title="When ticked, the Auto-generate button will be displayed" {$AutoConfigFlag} /></td>
    </tr>       
</table>

</fieldset>
<br />
<input type="submit" name="Submit" value="Update Options" />
</form>
<hr width="50%" />
<h2>Currently enabled modules</h2>
<ul>
EOHTML;

foreach (glob( plugin_dir_path( __FILE__ ) . "conf.d/*.php") as $filename) 
    {
        echo "<li>$filename</li>";
    }

echo <<<EOHTML
</ul>
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

/**
  ----------------------------
  Annotations section

**/

function traceview_annotate($message) {
    $ClientKey = is_multisite() ? get_site_option('traceview_client_key') : get_option('traceview_client_key');
    $ShouldAnnotate = is_multisite() ? get_site_option('traceview_add_annotations') : get_option('traceview_add_annotations');


    // Only do this if Curl is installed and we know the client key, and annotations box was checked
    if($ClientKey != 'Not set' && function_exists('curl_version') && $ShouldAnnotate==1) {
       $message = filter_var($message, FILTER_SANITIZE_STRING);
       $LayerPrefix = is_multisite() ? get_site_option('traceview_layer_prefix') : get_option('traceview_layer_prefix');
        oboe_log_entry("$($LayerPrefix)traceview-annotate");
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
        oboe_log_exit("$($LayerPrefix)traceview-annotate");
    }

}

function traceview_annotate_upgrade($wp_db_version, $wp_current_db_version) {
    traceview_annotate("WordPress version was upgraded from " . filter_var($wp_current_db_version, FILTER_SANITIZE_STRING) . " to " . filter_var($wp_db_version, FILTER_SANITIZE_STRING));
}
add_action('wp_upgrade','traceview_annotate_upgrade');

function traceview_annotate_theme_switch($oldtheme) {
    global $blog_id;
    $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
    $thetheme = wp_get_theme();
    $Annotation = filter_var($current_blog_details->blogname, FILTER_SANITIZE_STRING) . " has changed theme; new theme is " . filter_var($thetheme->get('Name'), FILTER_SANITIZE_STRING) . " version " . filter_var($thetheme->get('Version'), FILTER_SANITIZE_STRING);
    traceview_annotate($Annotation);
}
add_action('after_switch_theme','traceview_annotate_theme_switch');

function traceview_annotate_plugin_activate($plugin, $networkwide=null) {
    $plugin = filter_var($plugin, FILTER_SANITIZE_STRING);
    if($networkwide) {
        $Annotation = "Network-wide plugin activated: $plugin";
        traceview_annotate($Annotation);
    } else {
        global $blog_id;
        $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
        $Annotation = filter_var($current_blog_details->blogname, FILTER_SANITIZE_STRING) . " has activated new plugin: $plugin ";
        traceview_annotate($Annotation);
    }
}
add_action('activated_plugin','traceview_annotate_plugin_activate');

function traceview_annotate_plugin_deactivate($plugin, $networkwide=null) {
    $plugin = filter_var($plugin, FILTER_SANITIZE_STRING);
    if($networkwide) {
        $Annotation = "Network-wide plugin deactivated: $plugin";
        traceview_annotate($Annotation);
    } else {
        global $blog_id;
        $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
        $Annotation = filter_var($current_blog_details->blogname, FILTER_SANITIZE_STRING) . " has deactivated a plugin: $plugin ";
        traceview_annotate($Annotation);
    }
}
add_action('deactivated_plugin','traceview_annotate_plugin_deactivate');

function traceview_generate_config_from_current_page()
{
    if ( current_user_can('manage_options') && (is_multisite() ? get_site_option('traceview_add_autoconfig_button') : get_option('traceview_add_autoconfig_button')) ) {
       print "<script language='javascript' type='text/javascript'>\n";
       print '    function showConfig() {';
                global $wp_actions;
                $myactions = array_keys($wp_actions);
                sort($myactions);
                $configtext = '//Auto-generated monitoring script - some editing may be required<br />';
                foreach ( $myactions as $key ) {
                        if ( strpos( $key, 'traceview' ) == FALSE ) {
                          $configtext .= "tv_action_watch('$key');<br/>";
                        }
                }
       // print '      alert("' . $configtext . '");';
       
       print '  var popupWindow = null; ';
       print '  popupWindow = window.open("","_blank","scrollbars=yes,toolbar=no,menubar=no,status=no"); ';
       print '  popupWindow.document.write("<p><b>Copy the following text into a file and place it in the /wp-content/plugins/traceview/conf.d folder</b></p><p>&lt;?php <br />' . $configtext . '?&gt;</p>"); ';

       print '    }';
       print "</script>\n";

      print '<button type="button" name="traceview_autoconfig" id="traceview_autoconfig" onclick="showConfig();">TraceView Config</button>'; 
    }
}
add_action('wp_footer','traceview_generate_config_from_current_page',254);

?>