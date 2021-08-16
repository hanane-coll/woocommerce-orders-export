<?php
if(!defined('ABSPATH')){
    exit;
}

if(!class_exists('fetch_order', false)){

    class fetch_order {

        use trait_getvalue;

        /*
         * Order ID
         */
        public $order_id, $order, $order_number;
        
        static $instance = array();

        //Constructor
        function __construct($order_id) {

            $this->order_id = $order_id;
            $this->order = wc_get_order($order_id);
            $this->order_number = $this->order->get_order_number();
            $this->order_status = $this->order->get_status();
            $this->items = $this->order->get_items('line_item');
        }
    }
}