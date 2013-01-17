<?php
/*
Plugin Name: iProject Web
Plugin URI: http://wp-pal.com/?page_id=7 
Version: 1.0.8.11
Author: wppal
Author URI: http://wp-pal.com
Description: iProject Web an easy to use and feature rich project management and task management software. It has a set of features required for organizing effective project team work. It simplifies collaboration between team members and is designed for people online.	
*/

if (!class_exists('iProjectWeb')) {
	class iProjectWeb {
		static function install() {
			$plugin_prefix_root = plugin_dir_path( __FILE__ );
			$plugin_prefix_filename = "{$plugin_prefix_root}/iprojectweb.install.php";
			include_once $plugin_prefix_filename;	
			iprojectweb_install();
			iprojectweb_install_data();
		}	
		static function uninstall() {
			$plugin_prefix_root = plugin_dir_path( __FILE__ );
			$plugin_prefix_filename = "{$plugin_prefix_root}/iprojectweb.install.php";
			include_once $plugin_prefix_filename;	
			iprojectweb_uninstall();
		}	
	}
	$iproject = new iProjectWeb(); 	
} 	

if ( isset($iproject) && function_exists('register_activation_hook') ){

	register_activation_hook( __FILE__, array('iProjectWeb', 'install') );
	register_deactivation_hook( __FILE__, array('iProjectWeb', 'uninstall') );
	add_action( 'admin_menu', 'iprojectweb_main_page', 1 );
	add_action( 'wp_ajax_nopriv_iprojectweb-submit', 'iprojectweb_entrypoint' );
	add_action( 'wp_ajax_iprojectweb-submit', 'iprojectweb_entrypoint' );	
	add_shortcode( 'iprojectweb_frontend', 'iprojectweb_entrypoint' );	

} 

function iprojectweb_main_page() {
	if ( function_exists('add_submenu_page') )
		add_submenu_page('plugins.php', __('iProject Web'), __('iProject Web'), 'manage_options', 'iprojectweb-main-page', 'iprojectweb_entrypoint');
}

function iprojectweb_tag() {
	iprojectweb_entrypoint();
}
/**
 * 	iprojectweb entrypoint
 *
 */

function iprojectweb_entrypoint() {

	global $current_user;

	$l_locale = get_locale();

	$map = $_REQUEST;

	$base = get_bloginfo('wpurl');
	$base = rtrim($base, '/');

	// Http root
	DEFINE('_IPROJECTWEB_APPLICATION_ROOT', $base);
	// DIRECTORY_SEPARATOR
	DEFINE('WP_DS', DIRECTORY_SEPARATOR);
	// Plugin directory
	DEFINE('_IPROJECTWEB_DIR', 'wp-content/plugins/iprojectweb');
	// Plugin url
	DEFINE('IPROJECTWEB__engineWebAppDirectory', rtrim(_IPROJECTWEB_APPLICATION_ROOT, '/') . '/' . _IPROJECTWEB_DIR);
	// An absolute plugin path
	DEFINE('_IPROJECTWEB_PLUGIN_PATH', ABSPATH . _IPROJECTWEB_DIR);

	$tag = strtolower(str_replace('_', '-', l_locale));
	$map['l'] = $tag;

	if (!(@include_once _IPROJECTWEB_PLUGIN_PATH . WP_DS . 'iprojectweb_resources_' . $tag . '.php')) {
		require_once _IPROJECTWEB_PLUGIN_PATH . WP_DS . 'iprojectweb_resources_en-gb.php';
		$map['l'] = 'en-gb';
	}

	require_once _IPROJECTWEB_PLUGIN_PATH . WP_DS . 'iprojectweb_utils.php';
	require_once _IPROJECTWEB_PLUGIN_PATH . WP_DS . 'iprojectweb_database.php';
	require_once _IPROJECTWEB_PLUGIN_PATH . WP_DS . 'iprojectweb_root.php';
	require_once _IPROJECTWEB_PLUGIN_PATH . WP_DS . 'iprojectweb_applicationsettings.php';
	require_once _IPROJECTWEB_PLUGIN_PATH . WP_DS . 'iprojectweb_appconfigdata.php';
	require_once _IPROJECTWEB_PLUGIN_PATH . WP_DS . 'iprojectweb_securitymanager.php';

	$userid = $current_user->ID;

	$map['fid'] = $userid;

	if (isset($map['ac']) && ($map['ac'] == '1')) {
		iProjectWebRoot::ajaxCall($map);
		die();
	}

	$map = iProjectWebSecurityManager::getRights($map);

	if (isset($map['m']) && ($map['m'] == 'download')) {
		iProjectWebRoot::download($map);
		die();
	}

	if (!isset($map['m'])) {
		$map['m'] = 'view';
	}
	if (!isset($map['t'])) {
		$map['t'] = 'Projects';
	}

	wp_enqueue_script('jquery');

	wp_enqueue_script('iprojectwebhtml', '/' . _IPROJECTWEB_DIR . '/iprojectwebhtml.js');
	wp_enqueue_script('as', '/' . _IPROJECTWEB_DIR . '/js/as.js');
	wp_enqueue_script('ajaxupload', '/' . _IPROJECTWEB_DIR . '/js/ajaxupload.js');
	wp_enqueue_script('calendar_stripped', '/' . _IPROJECTWEB_DIR . '/js/calendar/calendar_stripped.js');
	wp_enqueue_script('calendar-setup_stripped', '/' . _IPROJECTWEB_DIR . '/js/calendar/calendar-setup_stripped.js');
	wp_enqueue_script('calendar-en', '/' . _IPROJECTWEB_DIR . '/js/calendar/lang/calendar-en.js');

	if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) {
		wp_enqueue_script('tiny_mce', '/' . _IPROJECTWEB_DIR . '/js/tinymce/tiny_mce.js');
	}

	$js = "config = {};";
	$js .= "config.url='" . admin_url( 'admin-ajax.php' ) . "';";
	$js .= "config.initial = {t:'" . $map['t'] . "', m:'" . $map['m'] . "'};";
	$js .= "config.bodyid = 'diviProjectWeb';";
	$js .= "config.resources = {};";

	$js .= "config.resources['ItwillDeleteRecordsAreYouSure'] = " . json_encode(IPROJECTWEB_ItwillDeleteRecordsAreYouSure) . ";";

	$js .= "config.resources['NoRecordsSelected'] = " . json_encode(IPROJECTWEB_NoRecordsSelected) . ";";
	$js .= "config.resources['CloseFilter'] = " . json_encode(IPROJECTWEB_CloseFilter) . ";";
	$js .= "config.resources['Search'] = " . json_encode(IPROJECTWEB_Search) . ";";
	$js .= "config.resources['NoResults'] = " . json_encode(IPROJECTWEB_NoResults) . ";";
	$js .= "config.resources['Uploading'] = " . json_encode(IPROJECTWEB_Uploading) . ";";
	$js .= "config.resources['Upload'] = " . json_encode(IPROJECTWEB_Upload) . ";";
	$js .= "var appManConfig = config;";

	echo "<link href='" . IPROJECTWEB__engineWebAppDirectory . '/js/calendar/css/calendar-system.css' . "' rel='stylesheet' type='text/css'/>";

	if (function_exists('is_admin')) {

		$paramName = is_admin() ? 'DefaultStyle2' : 'DefaultStyle';
		$styleName = iProjectWebApplicationSettings::getInstance()->get($paramName);

		$paramName = is_admin() ? 'ApplicationWidth2' : 'ApplicationWidth';
		$appWidth = iProjectWebApplicationSettings::getInstance()->get($paramName);

	}
	else {

		$styleName = IPROJECTWEB_DEFAULT_STYLE;
		$appWidth = iProjectWebApplicationSettings::getInstance()->get('ApplicationWidth');

	}

		$wrStyle = 'style=\'width:' . $appWidth . 'px\'';
	require_once _IPROJECTWEB_PLUGIN_PATH . WP_DS . 'styles' . WP_DS . $styleName . WP_DS . 'iprojectweb_getstyle.php';
	require_once _IPROJECTWEB_PLUGIN_PATH . WP_DS . 'iprojectweb_menu.php';
	echo "<div id='ufo-app-wrapper' $wrStyle>";
	iProjectWebMenu::getMenu($map);
	echo "<div id='diviProjectWeb'>";
	echo "<script>$js</script>";
	echo iProjectWebRoot::processRequest($map);
	echo "</div>";
	echo "</div>";

}
