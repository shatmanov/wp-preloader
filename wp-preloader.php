<?php
/*
	@package   wp-preloader
	@author    zhan.shatmanov zhan@shatmanov.com
	@license   GPL-2.0+
	@link      https://github.com/shatmanov/wp-preloader
	@copyright 2014-2018 zhan.shatmanov
	@wordpress-plugin
	Plugin Name:       WP preLoader
	Plugin URI:        https://github.com/shatmanov/wp-preloader
	Description:       WP preLoader is a preloader plugin for wordpress. This plugin will enable preloader when loading your site. Visitor will see a loader.
	Version:           1.0
	Author:            zhan.shatmanov
	Author URI:        https://shatmanov.com
	Text Domain:       WPpreloader
	License:           GPL-2.0+
	License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	GitHub Plugin URI: https://github.com/shatmanov/wp-preloader
	GitHub Branch:    master
*/

 // define( 'WP_DEBUG', true );
 // ini_set('display_errors', '1');
 // ini_set('error_reporting', E_ALL);
// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain('WPpreloader', false, "$plugin_dir/lang");
	require_once( 'BFIGitHubPluginUploader.php' );

	// Если мы в адм. интерфейсе
	if ( is_admin() ) {
		add_action('admin_menu', 'WPpreloader_admin_menu');
		add_action('admin_init', 'register_WPpreloaderSettings');
		add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );

		//обновление
		new BFIGitHubPluginUpdater( __FILE__, 'shatmanov', "wp-preloader" );
	} else {
		// Добавляем стили и скрипты
		if (get_option('wppl_enable')=='on'){
			add_action('wp_print_scripts', 'WPpreloader_scripts');
			add_action('wp_print_styles', 'WPpreloader_styles');
			add_action('wp_head', 'WPpreloader_head');
			add_action('wp_footer', 'WPpreloader_footer');
		}
	}

	define( 'WP_PRELOADER_THEMES_URL', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)) ); //Путь до папки с темой
	define( 'WP_PRELOADER_INC_URL', plugin_dir_path( __FILE__ ) ); //Путь до папки с темой

	function WPpreloader_admin_menu(){
		$page = add_menu_page(__('WP preLoader', 'WPpreloader'), __('WP preLoader', 'WPpreloader'), '9', 'WPpreloader', 'WPpreloader_config', 'dashicons-clock');
    }

	function register_WPpreloaderSettings() {
		register_setting( 'WPpreloader-settings-group', 'wppl_enable' );
		register_setting( 'WPpreloader-settings-group', 'wppl_text' );
		register_setting( 'WPpreloader-settings-group', 'wppl_spin' );
		register_setting( 'WPpreloader-settings-group', 'wppl_background' );
		register_setting( 'WPpreloader-settings-group', 'wppl_color' );
	}

	//Plugin Menu Link
	function WPpreloader_action_links( $links ) {
		$links[] = '<a href="'. admin_url( 'admin.php?page=WPpreloader' ) .'">'.__( 'Settings', 'WPpreloader' ).'</a>';
		$links[] = '<a href="'. admin_url( 'admin.php?page=WPpreloader&amp;tab=help' ) .'">'.__( 'Help', 'WPpreloader' ).'</a>';
		return $links;
	}
	#plugin page links
	add_filter('plugin_action_links_'.plugin_basename( __FILE__ ), 'WPpreloader_action_links' );

	add_filter('body_class','WPpreloader_class');
	function WPpreloader_class($classes) {
		$classes[] = 'WPpre-loader';
		return $classes;
	}

	function mw_enqueue_color_picker( $hook_suffix ) {
    	// first check that $hook_suffix is appropriate for your admin page
    	wp_enqueue_style( 'wp-color-picker' );
    	wp_enqueue_script( 'my-script-handle', plugins_url('admin/wp-preloader.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	}

	function WPpreloader_config(){
		echo '<h1>'.__( 'WP preLoader', 'WPpreloader' ).'</h1>';
		if(isset($_GET['tab'])&&!empty($_GET['tab'])) {
			$tab_var = $_GET['tab'];
		}else{
			$tab_var = '';
		}
?>
		<div class="admin-page-framework-in-page-tab">
		  <h2 class="nav-tab-wrapper in-page-tab">
		  	<a class="nav-tab<?php if (empty($tab_var)){echo ' nav-tab-active';} ?>" href="admin.php?page=WPpreloader"><?php echo __( 'General settings', 'WPpreloader' ); ?></a>
		    <a class="nav-tab<?php if ($tab_var=='help'){echo ' nav-tab-active';} ?>" href="admin.php?page=WPpreloader&amp;tab=help"><?php echo __( 'Help', 'WPpreloader' ); ?></a>
		  </h2>
		</div>
<?php

		$tab = isset($_GET['tab']) ? $_GET['tab'] : null ;
		switch ($tab) {

			case 'help':
				include_once('admin/help.php');
			break;

			default:
				include_once('admin/main.php');
		}

	}

	function WPpreloader_spinner_classExample($wppl_spin, $wppl_color){
		switch ($wppl_spin) {

			case 'chasing-dots.css':
				return '.wppl-chasing-dots .wppl-child {background-color: '.$wppl_color.';}';
			break;

			case 'circle.css':
				return '.wppl-circle .wppl-child:before {background-color: '.$wppl_color.';}';
			break;

			case 'cube-grid.css':
				return '.wppl-cube-grid .wppl-cube {background-color: '.$wppl_color.';}';
			break;

			case 'double-bounce.css':
				return '.wppl-double-bounce .wppl-child {background-color: '.$wppl_color.';}';
			break;

			case 'fading-circle.css':
				return '.wppl-fading-circle .wppl-circle:before {background-color: '.$wppl_color.';}';
			break;

			case 'folding-cube.css':
				return '.wppl-folding-cube .wppl-cube:before {background-color: '.$wppl_color.';}';
			break;

			case 'pulse.css':
				return '.wppl-spinner-pulse {background-color: '.$wppl_color.';}';
			break;

			case 'rotating-plane.css':
				return '.wppl-rotating-plane {background-color: '.$wppl_color.';}';
			break;

			case 'three-bounce.css':
				return '.wppl-three-bounce .wppl-child {background-color: '.$wppl_color.';}';
			break;

			case 'wandering-cubes.css':
				return '.wppl-wandering-cubes .wppl-cube {background-color: '.$wppl_color.';}';
			break;

			case 'wave.css':
				return '.wppl-wave .wppl-rect {background-color: '.$wppl_color.';}';
			break;

			case 'ball-pulse.css':
				return '.wppl-ballpulse > div {background-color: '.$wppl_color.';}';
			break;

			default:
				return '.wppl-rotating-plane {background-color: '.$wppl_color.';}';
		}
	}

	function WPpreloader_spinner_class($wppl_spin, $wppl_color){
		switch ($wppl_spin) {

			case 'chasing-dots.css':
				return '#WPpreloader_container .wppl-chasing-dots .wppl-child {background-color: '.$wppl_color.';}';
			break;

			case 'circle.css':
				return '#WPpreloader_container .wppl-circle .wppl-child:before {background-color: '.$wppl_color.';}';
			break;

			case 'cube-grid.css':
				return '#WPpreloader_container .wppl-cube-grid .wppl-cube {background-color: '.$wppl_color.';}';
			break;

			case 'double-bounce.css':
				return '#WPpreloader_container .wppl-double-bounce .wppl-child {background-color: '.$wppl_color.';}';
			break;

			case 'fading-circle.css':
				return '#WPpreloader_container .wppl-fading-circle .wppl-circle:before {background-color: '.$wppl_color.';}';
			break;

			case 'folding-cube.css':
				return '#WPpreloader_container .wppl-folding-cube .wppl-cube:before {background-color: '.$wppl_color.';}';
			break;

			case 'pulse.css':
				return '#WPpreloader_container .wppl-spinner-pulse {background-color: '.$wppl_color.';}';
			break;

			case 'rotating-plane.css':
				return '#WPpreloader_container .wppl-rotating-plane {background-color: '.$wppl_color.';}';
			break;

			case 'three-bounce.css':
				return '#WPpreloader_container .wppl-three-bounce .wppl-child {background-color: '.$wppl_color.';}';
			break;

			case 'wandering-cubes.css':
				return '#WPpreloader_container .wppl-wandering-cubes .wppl-cube {background-color: '.$wppl_color.';}';
			break;

			case 'wave.css':
				return '#WPpreloader_container .wppl-wave .wppl-rect {background-color: '.$wppl_color.';}';
			break;

			case 'ball-pulse.css':
				return '#WPpreloader_container .wppl-ballpulse > div {background-color: '.$wppl_color.';}';
			break;

			default:
				return '#WPpreloader_container .wppl-rotating-plane {background-color: '.$wppl_color.';}';
		}
	}

	function WPpreloader_spinner($wppl_spin){
		switch ($wppl_spin) {

			case 'chasing-dots.css':
				return '<div class="wppl-chasing-dots"><div class="wppl-child wppl-dot1"></div><div class="wppl-child wppl-dot2"></div></div>';
			break;

			case 'circle.css':
				return '<div class="wppl-circle"><div class="wppl-circle1 wppl-child"></div><div class="wppl-circle2 wppl-child"></div><div class="wppl-circle3 wppl-child"></div><div class="wppl-circle4 wppl-child"></div><div class="wppl-circle5 wppl-child"></div><div class="wppl-circle6 wppl-child"></div><div class="wppl-circle7 wppl-child"></div><div class="wppl-circle8 wppl-child"></div><div class="wppl-circle9 wppl-child"></div><div class="wppl-circle10 wppl-child"></div><div class="wppl-circle11 wppl-child"></div><div class="wppl-circle12 wppl-child"></div></div>';
			break;

			case 'cube-grid.css':
				return '<div class="wppl-cube-grid"><div class="wppl-cube wppl-cube1"></div><div class="wppl-cube wppl-cube2"></div><div class="wppl-cube wppl-cube3"></div><div class="wppl-cube wppl-cube4"></div><div class="wppl-cube wppl-cube5"></div><div class="wppl-cube wppl-cube6"></div><div class="wppl-cube wppl-cube7"></div><div class="wppl-cube wppl-cube8"></div><div class="wppl-cube wppl-cube9"></div></div>';
			break;

			case 'double-bounce.css':
				return '<div class="wppl-double-bounce"><div class="wppl-child wppl-double-bounce1"></div><div class="wppl-child wppl-double-bounce2"></div></div>';
			break;

			case 'fading-circle.css':
				return '<div class="wppl-fading-circle"><div class="wppl-circle1 wppl-circle"></div><div class="wppl-circle2 wppl-circle"></div><div class="wppl-circle3 wppl-circle"></div><div class="wppl-circle4 wppl-circle"></div><div class="wppl-circle5 wppl-circle"></div><div class="wppl-circle6 wppl-circle"></div><div class="wppl-circle7 wppl-circle"></div><div class="wppl-circle8 wppl-circle"></div><div class="wppl-circle9 wppl-circle"></div><div class="wppl-circle10 wppl-circle"></div><div class="wppl-circle11 wppl-circle"></div><div class="wppl-circle12 wppl-circle"></div></div>';
			break;

			case 'folding-cube.css':
				return '<div class="wppl-folding-cube"><div class="wppl-cube1 wppl-cube"></div><div class="wppl-cube2 wppl-cube"></div><div class="wppl-cube4 wppl-cube"></div><div class="wppl-cube3 wppl-cube"></div></div>';
			break;

			case 'pulse.css':
				return '<div class="wppl-spinner wppl-spinner-pulse"></div>';
			break;

			case 'rotating-plane.css':
				return '<div class="wppl-rotating-plane"></div>';
			break;

			case 'three-bounce.css':
				return '<div class="wppl-three-bounce"><div class="wppl-child wppl-bounce1"></div><div class="wppl-child wppl-bounce2"></div><div class="wppl-child wppl-bounce3"></div></div>';
			break;

			case 'wandering-cubes.css':
				return '<div class="wppl-wandering-cubes"><div class="wppl-cube wppl-cube1"></div><div class="wppl-cube wppl-cube2"></div></div>';
			break;

			case 'wave.css':
				return '<div class="wppl-wave"><div class="wppl-rect wppl-rect1"></div><div class="wppl-rect wppl-rect2"></div><div class="wppl-rect wppl-rect3"></div><div class="wppl-rect wppl-rect4"></div><div class="wppl-rect wppl-rect5"></div></div>';
			break;

			case 'ball-pulse.css':
				return '<div class="wppl-ballpulse"><div></div><div></div><div></div></div>';
			break;

			default:
				return '<div class="wppl-rotating-plane"></div>';
		}
	}

	function WPpreloader_scripts(){
		wp_register_script('WPpreloaderJS', WP_PRELOADER_THEMES_URL.'/wp-preloader.js');
		wp_enqueue_script('WPpreloaderJS');
    }

	function WPpreloader_styles(){
		wp_register_style('WPpreloader', WP_PRELOADER_THEMES_URL.'/wp-preloader.css');
		wp_register_style('WPpreloader-theme', WP_PRELOADER_THEMES_URL.'/css/'.get_option('wppl_spin'));
		wp_enqueue_style('WPpreloader');
		wp_enqueue_style('WPpreloader-theme');
    }

	function WPpreloader_head(){
?>
<style type="text/css">
#WPpreloader_container {
	background-color: <?php echo get_option('wppl_background'); ?>;
	color: <?php echo get_option('wppl_color'); ?>;
}
<?php echo WPpreloader_spinner_class(get_option('wppl_spin'), get_option('wppl_color')); ?>
</style>
<?php
	}

	function WPpreloader_footer(){
?>
    <div id="WPpreloader_container">
    	<div class="WPpreloader_wrap">
        	<?php echo WPpreloader_spinner(get_option('wppl_spin')); ?>
            <div id="WPpreloader_text"><?php echo get_option('wppl_text'); ?></div>
    	</div>
    </div>
<?php
	}


/**
* Активация плагина
*/
	function WPpreloader_activate(){
		include_once('functions/activate.php');
	}
	register_activation_hook( __FILE__, 'WPpreloader_activate' );

/**
* Деактивация плагина
*/
	function WPpreloader_deactivate(){
		return true;
	}
	register_deactivation_hook( __FILE__, 'WPpreloader_deactivate' );

/**
* Удаление плагина
*/
	function WPpreloader_uninstall(){
		include_once('functions/uninstall.php');
	}
	register_uninstall_hook( __FILE__, 'WPpreloader_uninstall' );

?>
