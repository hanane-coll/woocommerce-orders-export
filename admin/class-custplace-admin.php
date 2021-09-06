<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


class Custplace_Admin
{
    private $plugin_name;

    private $version;

    private $option_name = 'custplace_setting';

    
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action( 'admin_init', array($this ,'custplace_configuration_page' ));
        add_action( 'admin_menu', array($this ,'custplace_plugin_setup_menu')) ; 
        add_action('add_meta_boxes', array( $this, 'custplace_order_meta_boxes' ));
        add_action('woocommerce_order_status_completed', array($this ,'mysite_completed'), 10, 1);
    }

    
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/custplace-admin.css', array(), $this->version, 'all');
    }

  
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/custplace-admin.js', array( 'jquery' ), $this->version, false);
    }


    public function custplace_configuration_page()
    {

        // Add a Settings section
        
        add_settings_section(
            $this->option_name. '_settings',
            __('Custplace: Avis client', 'custplace'),
            array( $this, $this->option_name . '_settings_cb' ),
            $this->plugin_name
        );
        
        // Add a numeric field
        
        add_settings_field(
            $this->option_name . '_id_client',
            __('ID Client', 'custplace'),
            array( $this, $this->option_name . '_id_client_cb' ),
            $this->plugin_name,
            $this->option_name . '_settings',
            array( 'label_for' => $this->option_name . '_id_client' )
        );

        // Add a text field

        add_settings_field(
            $this->option_name . '_api_token',
            __('API Token', 'custplace'),
            array( $this, $this->option_name . '_api_token_cb' ),
            $this->plugin_name,
            $this->option_name . '_settings',
            array( 'label_for' => $this->option_name . '_api_token' )
        );

        // Add a select field

        add_settings_field(
            $this->option_name . '_date_of_invitation',
            __('Date d\'envoi d\'invitation', 'custplace'),
            array( $this, $this->option_name . '_date_of_invitation_cb' ),
            $this->plugin_name,
            $this->option_name . '_settings',
            array( 'label_for' => $this->option_name . '_date_of_invitation' )
        );
        
        // Register the numeric field

        register_setting($this->plugin_name, $this->option_name . '_id_client', 'integer');

        // Register the text field

        register_setting($this->plugin_name, $this->option_name . '_api_token', 'string');

        // Register the select field

        register_setting($this->plugin_name, $this->option_name . '_date_of_invitation', 'string');
    }



    public function custplace_setting_settings_cb()
    {
        echo '<p>' . __('Automatiser la collecte d’avis de votre boutique Woocommerce avec Custplace et améliorer votre réputation et votre conversion.', 'custplace') . '</p>';
    }



    public function custplace_setting_id_client_cb()
    {
        $val = get_option($this->option_name . '_id_client');
        echo '<input type="number" style="width:250px" name="' . $this->option_name . '_id_client' . '" id="' . $this->option_name . '_id_client' . '" value="' . $val . '"> ' ;
    }



    public function custplace_setting_api_token_cb()
    {
        $val = get_option($this->option_name . '_api_token');
        echo '<input type="password" style="width:250px" name="' . $this->option_name . '_api_token' . '" id="' . $this->option_name . '_api_token' . '" value="' . $val . '"> ';
    }



    public function custplace_setting_date_of_invitation_cb()
    {
        $val = get_option($this->option_name . '_date_of_invitation');

        echo '<select name="' . $this->option_name . '_date_of_invitation' . '" style="width:250px" class="regular-text" >
			<option value="immediately" '.selected('immediately', $val, false).'>immédiatement</option>
			<option value="after1hour" '.selected('after1hour', $val, false).'>après 1 heure</option>
			<option value="after1day" '.selected('after1day', $val, false).'>après 1 jour</option>
			<option value="after2days" '.selected('after2days', $val, false).'>après 1 jours</option>
			<option value="after1week" '.selected('after1week', $val, false).'>après 1 semaine</option>
			<option value="after10days" '.selected('after10days', $val, false).'>après 10 jours</option>
			</select>';
    }
      
    

    public function custplace_init()
    {
        if (! current_user_can('manage_options')) {
            return;
        }
        include CUSTPLACE_PATH . 'admin/partials/custplace-admin-display.php' ;
    }



    public function custplace_plugin_setup_menu()
    {
        add_menu_page('Paramètres', 'Custplace', 'manage_options', 'custplace', array($this, 'custplace_init'), 'dashicons-testimonial');
    }



    public function custplace_order_meta_boxes()
    {

        
        add_meta_box(
            'woocommerce-order-invitation-status',
            __('Collecte d\'avis'),
            array($this,'order_meta_box_content'),
            'shop_order',
            'side',
            'default'
        );
    }



    public function order_meta_box_content()
    {
        ?>
        <div class="misc-pub-section misc-pub-post-status">
            Status:			
            <span id="post-status-display">Draft</span>
        </div>


        <div class="misc-pub-section curtime misc-pub-curtime">
            <span id="timestamp">Date d'envoi: <b>immédiatement</b></span>            
        </div>
                                
        <div class="clear"></div>
        
        <div id="publishing-action">
            <button type="submit" name="publish" id="publish" class="button button-primary button-large"   >Envoyer une invitation</button>		
        </div>

        <div class="clear"></div>

        <script type="text/javascript">
            (function($) {
                $('#post-status-display').html( 'Invitation non envoyée' );
                
                
            })(jQuery);
            
            var dateButton =document.getElementById ("publish");
            var d = new Date();

            dateButton.onclick = function(){
                $('b').html( d );
                $('#post-status-display').html( 'Invitation envoyée' );
                dateButton.innerHTML = "Envoyer une nouvelle invitation";
            };

        </script>  
        
        <?php
    }



    public function mysite_completed($id)
    {
        $bdd = new PDO('mysql:host=localhost;dbname=worldpress', 'root', '');
        
        $sql = $bdd->prepare("SELECT option_value FROM wp_options WHERE option_name = ? ");

        if ($option_name = 'custplace_setting_api_token') {
            $sql -> execute([$option_name]);
            $api_token = $sql -> fetch();
        }
        
        if ($option_name = 'custplace_setting_id_client') {
            $sql -> execute([$option_name]);
            $client_id = $sql -> fetch();
        }
        
        $order = new WC_Order($id);

        $order_data = array(
            
            'api_token' => $api_token['option_value'],
            'client_id' => $client_id['option_value'],
            'type' => 'post_review',
            'order_date' => $order->order_date,
            'email' => $order->get_billing_email(),
            'order_ref' => $order->get_id(),
            'firstname' => $order->get_billing_first_name(),
            'lastname' => $order->get_billing_last_name(),
            
            'products' => array()
        );
        $items = $order->get_items();

        foreach ($items as $item) {
            $product_variation_id = $item['variation_id'];
            
            
            if ($product_variation_id) {
                $product = new WC_Product($item['variation_id']);
            } else {
                $product = new WC_Product($item['product_id']);
            }

            $image_id  = $product->get_image_id();
            $product_id = $product->get_id();
    
            $order_data['products'][] = array(
                
                'sku' => $product->get_sku(),
                'name'=> $item->get_name(),
                'image' => wp_get_attachment_image_url($image_id, 'full'),
                'website' => get_the_permalink($product_id)
            );
        }
        
        //var_dump(json_encode($order_data)); die();
        $this->sendToApi($order_data);
    }

    
  
    public function sendToApi($data = [])
    {
        
        $url = 'https://api.custplace.com/v2/invitations';
        
        $curl = curl_init($url);
       
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($curl, CURLOPT_POST, true);
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
          'X-RapidAPI-Host: kvstore.p.rapidapi.com',
          'X-RapidAPI-Key: 7xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
          'Content-Type: application/json'
        ]);
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        
        echo $response . PHP_EOL;
    }
}



?>
  
