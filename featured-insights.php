<?php
/**
 * Plugin name: Featured Insights
 * Description: Custom plugin to display the insight posts in the form of a carousel on any page or post of the website.
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Kanchan Agarwal
 * Text Domain: featured-insights
 */

 /*
Featured Insights is a custom WordPress plugin that allows you to showcase posts in a carousel format. Through the plugin’s settings page, you can easily choose the number of posts to display and generate a shortcode. This shortcode can then be inserted into any page or post using the WordPress shortcode widget, giving you full flexibility in presenting featured content.
*/

 if(! defined('ABSPATH')){
    die('You are not allowed');
 }
if(! class_exists('Featured_Insights')){
    class Featured_Insights{
        function __construct(){
            $this->define_constants();
            $this->load_textdomain();
            add_action('admin_menu',array($this,'add_menu'));
            require_once(FEATURED_INSIGHTS_PATH.'shortcodes/class.featured-insights-shortcode.php');
            $Featured_Insights_Shortcode = new Featured_Insights_Shortcode();
            add_action('wp_enqueue_scripts',array($this,'register_scripts'),999);
        }
        public function define_constants(){
            define('FEATURED_INSIGHTS_PATH',plugin_dir_path(__FILE__));
            define('FEATURED_INSIGHTS_URL',plugin_dir_url(__FILE__));
            define('FEATURED_INSIGHTS_VERSION','1.0.0');
        }
        public static function activate(){
            update_option('rewrite rules','');
        }
        public static function deactivate(){
            flush_rewrite_rules();
        }
        public static function uninstall(){
            delete_option('featured_insights_options');
        }
        public function load_textdomain(){
            load_plugin_textdomain(
                'featured-insights',
                false,
                dirname(plugin_basename(__FILE__)).'/languages'
            );
        }
        public function add_menu(){
            add_menu_page(
                esc_html__('Featured Insights Options','featured-insights'),
                'Featured Insights',
                'manage_options',
                'featured_insights_admin',
                array($this, 'featured_insights_settings_page'),
                'dashicons-images-alt2'
            );
        }
        public function featured_insights_settings_page(){
            if(!current_user_can('manage_options')){
                return ;
            }            
            if(isset($_GET['settings-updated'])){
                add_settings_error('featured_insights_options','featured_insights_message',esc_html__('Settings saved','featured-insights'),'success');
            }
            settings_errors('featured_insights_options');
            require(FEATURED_INSIGHTS_PATH.'views/settings-page.php');
        }
        public function register_scripts(){
            wp_register_style('featured-insights-main-css',FEATURED_INSIGHTS_URL.'vendor/owlslider/owlSlider.css',array(),FEATURED_INSIGHTS_VERSION,'all');
            wp_register_script('featured-insights-main-js',FEATURED_INSIGHTS_URL.'vendor/owlslider/owlslider.js',array('jquery'),FEATURED_INSIGHTS_VERSION,true);
        }
    }
}
if(class_exists('Featured_Insights')){
    register_activation_hook(__FILE__,array('Featured_Insights','activate'));
    register_deactivation_hook(__FILE__,array('Featured_Insights','deactivate'));
    register_uninstall_hook(__FILE__,array('Featured_Insights','uninstall'));
   $featured_insights = new Featured_Insights();
}
