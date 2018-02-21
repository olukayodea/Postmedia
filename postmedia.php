<?php
/*
  Plugin Name: Postmedia Demo
  Description: Demo for postmedia interview
  Version: 1.0
  Author: Olukayode Adebiyi
  Author URI: https://www.linkedin.com/in/olukayode/
*/

global $wpdb;
define( 'demo_plugin__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

class demo_plugin {
	//constructor
	function __construct() {
		//add amin menu on initialization
		add_action( 'admin_menu', array( $this, 'post_media_add_menu' ));
		//initialize the imported CDN based script
		add_action( 'admin_enqueue_scripts', array( $this, 'demo_plugin_font_awesome' ));
		//create additional links in plugin menu 
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'pm_demo_demo_plugin_plugin_link'), 10, 5 );

		//registration hooks
        register_activation_hook( __FILE__, array( $this, 'pm_demo_install' ) );
        register_deactivation_hook( __FILE__, array( $this, 'pm_demo_deactivate' ) );
        register_uninstall_hook( __FILE__, array( $this, 'pm_demo_uninstall' ) );
		
	}
	
	//actions performed at loading of Admin Menu
	function post_media_add_menu() {
		
		//main menu
        add_menu_page(		'Main Page',
							'Main Page', 
							'manage_demo_post_media',
							'demo_post_media_dashboard', 
							array(__CLASS__,'pm_demo_dashboard'),
							"dashicons-groups",'2.2.4'
						);
		//create single sub menu			
        add_submenu_page(	'demo_post_media_dashboard',
							' Setting Page', 
							' Setting Page', 
							'manage_demo_post_media',
							'demo_post_media_dashboard', 
							array(__CLASS__,'pm_demo_dashboard')
						);
		//create multiple sub menu					
        add_submenu_page( 	'demo_post_media_dashboard', 
							' Create Multiple DSM Entry', 
							' Create Multiple',
							 'manage_demo_post_media',
							 'demo_post_media_settings', 
							 array(__CLASS__,'pm_demo_setting')
						);
    }
	
	//add settings link to the demo_plugin pluginPage
	function pm_demo_demo_plugin_plugin_link( $actions, $plugin_file ) {
		static $plugin;
		if (!isset($plugin))
		$plugin		=	plugin_basename(__FILE__);
		if ($plugin == $plugin_file) {
			$settings	=	array('settings' => '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=demo_post_media_settings') ) .'">Settings</a>');
			$actions	=	array_merge($settings, $actions);
		}
		
		return $actions;
	}
	
	//some random function
	function createRandomPassword($len = 7) { 
		$chars		=	"ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"; 
		$i 			=	0; 
		$pass		=	'' ; 
		$count		=	strlen($chars);
		while ($i <= $len) { 
			$num	=	rand() % $count; 
			$tmp	=	substr($chars, $num, 1); 
			$pass	=	$pass . $tmp; 
			$i++; 
		} 
		return $pass; 
	}
	
	/*
	* seeting page
	*/
	function pm_demo_dashboard() {
		include_once(demo_plugin__PLUGIN_DIR."dashboard.php");
	}
	
	/*
	* seeting page
	*/
	function pm_demo_setting() {
		include_once(demo_plugin__PLUGIN_DIR."settings.php");
	}
		
	/* 
	*  install plugin action
	*/
	
    function pm_demo_install() {		
		//create llog
		$array = array();
		//add log to database
		self::createLog($array);
    }
	

    /*
     * Actions perform on de-activation of plugin
     */
    function pm_demo_deactivate() {
		
		//create llog
		$array = array();
		
		//add log to database
		self::createLog($array);
    }
	
    /*
     * Actions perform on uninstall of plugin
     */
    function pm_demo_uninstall() {
		 global $wpdb;
		
    }
	
	//create log
	function createLog($array) {
		//insert to database
		//perform som database or other things
	}
	
	
	//external scripts and CSS
	function demo_plugin_font_awesome() {
		wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
		wp_enqueue_style( 'load-select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css' );
		wp_enqueue_script( 'load-select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js' );
		wp_enqueue_style( 'load-datatables-css', 'https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css' );
		wp_enqueue_script( 'load-datatables-js', 'https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js' );
		wp_enqueue_script( 'load-datepicker-js', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js' );
		wp_enqueue_style( 'load-datepicker-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
	}
	
}
new demo_plugin;
?>