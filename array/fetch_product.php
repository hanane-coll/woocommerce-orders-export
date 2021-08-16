<?php
if(!defined('ABSPATH')){
    exit;
}

if(!class_exists('WOOOE_Fetch_Product', false)){

    class fetch_product extends fetch_order{

        use trait_getvalue;

        /*
         * Holds instance of class
         */
        static $instance = array();

        /*
         * Properties array.
         */
        public $properties;


        function __construct($order_id) {

            parent::__construct($order_id);
            $this->properties = apply_filters('woooe_product_properties', array('product_name', 'product_categories', 'product_sku'));
            $this->set_value();
        }

        /*
         * Gets product names for an order.
         */
        function product_name(){

            $product_names = array();

            $line_items = $this->items;

            foreach($line_items as $item){
                array_push($product_names, $item->get_name());
            }

            return $product_names;
        }

    }
}