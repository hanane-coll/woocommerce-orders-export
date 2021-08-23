<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://Custplace.com
 * @since      1.0.0
 *
 * @package    Custplace
 * @subpackage Custplace/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Custplace
 * @subpackage Custplace/admin
 * @author     Custplace.com < yadounis@synergie-media.com>
 */


class Custplace_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The options name to be used in this plugin
     *
     * @since  	1.0.0
     * @access 	private
     * @var  	string 		$option_name 	Option name of this plugin
    */
    private $option_name = 'custplace_setting';

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Custplace_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Custplace_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/custplace-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Custplace_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Custplace_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/custplace-admin.js', array( 'jquery' ), $this->version, false);
    }

    /**
     * Register the setting parameters
     *
     * @since  	1.0.0
     * @access 	public
    */
    public function register_custplace_plugin_settings()
    {

        // Add a Settings section
        //add_settings_section( $id, $title, $callback, $page )
        add_settings_section(
            $this->option_name. '_settings',
            __('Custplace: Avis client', 'custplace'),
            array( $this, $this->option_name . '_settings_cb' ),
            $this->plugin_name
        );
        
        // Add a numeric field
        //add_settings_field( $id, $title, $callback, $page, $section = 'default', $args = array() )
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


    /**
     * Render the text for the general section
     *
     * @since  	1.0.0
     * @access 	public
    */
    public function custplace_setting_settings_cb()
    {
        echo '<p>' . __('Automatiser la collecte d’avis de votre boutique Woocommerce avec Custplace et améliorer votre réputation et votre conversion.', 'custplace') . '</p>';
    }

    /**
     * Render the number input for this plugin
     *
     * @since  1.0.0
     * @access public
     */
    public function custplace_setting_id_client_cb()
    {
        $val = get_option($this->option_name . '_id_client');
        echo '<input type="number" style="width:250px" name="' . $this->option_name . '_id_client' . '" id="' . $this->option_name . '_id_client' . '" value="' . $val . '"> ' ;
    }

    /**
     * Render the text input for this plugin
     *
     * @since  1.0.0
     * @access public
     */
    public function custplace_setting_api_token_cb()
    {
        $val = get_option($this->option_name . '_api_token');
        echo '<input type="password" style="width:250px" name="' . $this->option_name . '_api_token' . '" id="' . $this->option_name . '_api_token' . '" value="' . $val . '"> ';
    }


    /**
     * Render the text input for this plugin
     *
     * @since  1.0.0
     * @access public
     */
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
        
        

    /**
     * Include the setting page
     *
     * @since  1.0.0
     * @access public
    */
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
        //add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
        //add_submenu_page( $this->plugin_name, 'Settings Page Settings', 'Settings', 'administrator', $this->plugin_name.'-settings', array( $this, 'displayPluginAdminSettings' ));
    }
}



   add_action( 'add_meta_boxes', 'custplace_order_meta_boxes' );

	function custplace_order_meta_boxes() {

		//add_meta_box( $id, $title, $callback, $screen = null, $context = 'advanced', $priority = 'default', $callback_args = null )
		add_meta_box(
			'woocommerce-order-invitation-status',
			__( 'Collecte d\'avis' ),
			'order_meta_box_content',
			'shop_order',
			'side',
			'default'
		);
		
	}
	
    function order_meta_box_content()
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
  
