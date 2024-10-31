<?php
/*
Order Message Notification ( Plugin functions  )
©2020 Daniel Esparza, inspirado por #openliveit #dannydshore | Consultoría en servicios y soluciones de entorno web - https://danielesparza.studio/
*/

include ( 'twilio-php-master/src/Twilio/autoload.php' );
use Twilio\Rest\Client;

if ( !function_exists( 'dewp_omn_pluging_code' ) && isset($dewp_options['enable']) == true ) {
    
    add_action('wp_enqueue_scripts', 'dewp_register_pluginfiles');
    function dewp_register_pluginfiles() {
        
        wp_register_style( 'dewp_register_pluginstyle', plugin_dir_url( __FILE__ ) . '../css/dewp_style_plugin.css', array(), '1.0' );
        wp_enqueue_style( 'dewp_register_pluginstyle' );
        wp_register_script('dewp_register_pluginscript', plugin_dir_url( __FILE__ ) . '../js/dewp_jquery_plugin.js', array('jquery'), '1.0', true);
        wp_enqueue_script('dewp_register_pluginscript');
        
    }
    
    
    add_filter( 'woocommerce_checkout_fields' , 'dewp_omn_checbox_confirm' );
    function dewp_omn_checbox_confirm( $fields ) {

        $fields['billing']['wa_checkbox'] = array(
            'type' => 'checkbox',
            'label' => __('Enviar detalles del pedido por WhatsApp', 'woocommerce'),
            'class' => array('form-row-wide input-checkbox'),
            'clear' => true
        );   

        $fields['billing']['wa_number'] = array(
            'label' => __('', 'woocommerce'),
            'placeholder' => _x('+00 000 000 000', 'placeholder', 'woocommerce'),
            'class' => array('form-row-wide'),
            'clear' => true
        );

        return $fields;
    }

    
    add_action('woocommerce_checkout_process', 'dewp_omn_checbox_process');
    function dewp_omn_checbox_process() {
        
        if ( !empty( $_POST['wa_checkbox'] ) && empty( $_POST['wa_number'] ) ) {
            wc_add_notice( __( 'El campo enviar detalles del pedido por WhatsApp esta vacio.' ), 'error' );
        } elseif ( !empty( $_POST['wa_number'] ) ) {
            add_action( 'woocommerce_new_order' , 'dewp_omn_pluging_code' );
        }
    
    }
    
    
    function dewp_omn_pluging_code($order_id) {
        
        global $dewp_options;
        $twilio = new Client( $dewp_options['sid'], $dewp_options['token'] );
	
        $order = wc_get_order( $order_id );
            if ( $order ) {
                $orderID = $order->get_id();
                $orderCU = $order->get_currency();
                $orderTOTAL = $order->get_total();
                $orderURL = $order->get_checkout_order_received_url();
            }
    
        $message = $twilio->messages
            ->create("whatsapp:{$_POST['wa_number']}", // to
                [
                    "from" => "whatsapp:{$dewp_options['shop_wa']}",
                    "body" => "*{$dewp_options['shop_name']}*\nGracias. Tu pedido ha sido recibido:\n*#* {$orderID}, *Total:* {$orderTOTAL}({$orderCU}). \n*Detalles del pedido:* \n{$orderURL}"
                ]
            ); 
        
        //print($message->sid); 
        
    }
    
}