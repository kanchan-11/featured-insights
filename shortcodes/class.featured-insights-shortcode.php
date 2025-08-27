<?php
if(!class_exists('Featured_Insights_Shortcode')){
    class Featured_Insights_Shortcode{
        public function __construct(){
            add_shortcode('featured_insights',array($this,'add_shortcode'));
        }
        public function add_shortcode($atts = array(),$content=null,$tag='') {
            $atts = array_change_key_case((array) $atts,CASE_LOWER);

            extract(shortcode_atts(
                array(
                    'category'=>'',
                    'orderby'=>'date',
                ),
                $atts,
                $tag
            ));

            $args = array(
                'orderby' => $orderby,
                'category' => $category
            );
            ob_start();
            require(FEATURED_INSIGHTS_PATH.'views/featured-insights_shortcode.php');
            wp_enqueue_style('featured-insights-main-css');
            wp_enqueue_script('featured-insights-main-js');
            return ob_get_clean();
        }
    }
}