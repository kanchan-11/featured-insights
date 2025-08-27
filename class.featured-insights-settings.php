<?php
if(!class_exists('Featured_Insights_Settings')){
    class Featured_Insights_Settings{
        public static $options;
        public function __construct(){
            self::$options = get_option('featured_insights_options');
        }
    }
}
?>