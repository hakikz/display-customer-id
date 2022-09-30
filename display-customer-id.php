<?php 
/**
 * Plugin Name:       Display Customer ID
 * Plugin URI:        https://github.com/hakikz
 * Description:       Display customer id for logged in users, using <code>[dci_customer_id]</code> shortcode. Attributes can be passed as <code>title</code>. For example: <code>[dci_customer_id title="User ID: "]</code>
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Hakik Zaman
 * Author URI:        https://github.com/hakikz
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/hakikz
 * Text Domain:       display-customer-id
 * Domain Path:       /languages
 */

// Display condition
if( !function_exists( 'dci_display_customer_id' ) ){

    function dci_display_customer_id( $atts ){

        $atts = shortcode_atts(
            array(
                'title' => __('Your Customer ID: ', 'display-customer-id')
            ), $atts
        );

        // @note: return with message if not logged in user
        if ( !is_user_logged_in() ){ 

            return;

        }
        else{

            $current_user = wp_get_current_user();

            if( in_array( 'customer', $current_user->roles ) ){
                ob_start();
                echo apply_filters( 'dci_display_id', sprintf( '<p>%s%s</p>', _x( $atts['title'], 'Before ID Title', 'display-customer-id' ) , $current_user->ID ), $current_user );
                return ob_get_clean();
            }

            // print_r($current_user->roles);
        }

    }

}


// Initialization Display Customer ID
add_action( 'init', 'dci_display_customer_id_init' );

function dci_display_customer_id_init(){

    add_shortcode( 'dci_customer_id', 'dci_display_customer_id' );

}