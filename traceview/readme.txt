=== TraceView ===
Contributors: enigma-it
Donate link: http://www.appneta.com/
Tags: traceview, appneta, performance, monitor, monitoring, apm
Requires at least: 3.0.1
Tested up to: 3.9
Stable tag: 0.4
License: MIT
License URI: http://opensource.org/licenses/MIT

This plug-in integrates WordPress with AppNeta's TraceView APM system.
== Description ==

AppNeta's TraceView provides the easiest, smoothest way to monitor the performance of your
web application.  This plug-in exposes the most common WordPress actions and filters to
the TraceView console, helping you provide the best experience to your users.

To use this plug-in, you must an AppNeta account, and have installed the host and PHP 
agents on each web host.

== Installation ==

1. Ensure your web host has the TraceView host and PHP instrumentation installed
2. Upload `traceview.php` to the `/wp-content/plugins/traceview/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure your Client Key and Application name in the Settings menu 
5. Profit!!

(6. Suggest any additional hooks/filters/annotations you would like monitored via
    the GitHub repository or email support@appneta.com)


== Screenshots ==

1. The Settings page, where you add your Client Key and Application name
2. In the TraceView, you will see "wordpress-" layers created for each hook
3. Annotations will be automatically added when themes or active plugins change

== Changelog ==
= 0.4 =
* Added modular config files
* Changed to MIT licence
* Added support for custom layer prefix

= 0.3 =
* Made safe for single and multi-site installs

= 0.2 =
* Added support for Annotations

= 0.1 =
* Initial testing release

== Upgrade Notice == 
 
= 0.3 =
* None

== Frequently Asked Questions ==
= You're not monitoring the action *xxxx*! How do I add it? =
There are three ways to monitor an Action hook:

1. If all you want is a "point-in-time" not of when the action fired, add the line:

    `add_action('**hook_name**','traceview_log_hook');`

to the traceview.php file

2. If you want to know how long WordPress took to process everything which is using a
    specific hook, add the line:
    
        `tv_action_watch('**hook_name**');`
    
    This will add an action at the start (a priority 1 hook) and at the end (a priority 
    254 hook), and create a layer in TraceView representing the hook name.  This layer
    will be the duration Wordpress took to run that entire hook sequence, and any database
    queries made by plug-ins using that hook should fall beneath this new layer.
    
3. If there is a pair of hook names that form the start and end of a process (e.g. 
    names like 'pre_**hook_name**' and 'post_**hook_name**' add the lines:
    
    `add_action('**pre_hook_name**','traceview_start_section',1);`
    
    `add_action('**post_hook_name**','traceview_end_section',254);`
    
    to create a custom layer called "hook_name" - the function will automatically strip 
    out prefixes or suffixes such as "pre", "post", "before", "after, etc
    
Naturally, please let us know if there's any actions of filters we're not tracing, but 
should be.

= I found a bug! = 
That's not a questions.  But, we'll forgive you this time...

Please let us know at support@appneta.com and we'll try and sort it out for you.
