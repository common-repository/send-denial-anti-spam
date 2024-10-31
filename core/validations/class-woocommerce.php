<?php
namespace SEDE\Core\Validations;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Woocommerce
{
    public function __construct() {

        // honeypots
        add_action( 'woocommerce_register_form', array( $this, 'add_honeypot'), 1, 0 );
        add_action( 'woocommerce_after_checkout_billing_form', array( $this, 'add_honeypot' ) );
        add_action( 'woocommerce_login_form', array( $this, 'add_honeypot' ), 1, 0 );

        // This hook fires before customer accounts are created and passes the form data (username, email) and an array of errors.
        add_action( 'woocommerce_register_post', array( $this, 'validation_register_post' ), 10, 3 );

        // fires on checkout submit
        add_action( 'woocommerce_after_checkout_validation', array( $this, 'validation_checkout' ), 10, 2 );

    }


    public function validation_register_post( $username, $email, $errors ) {

        if ( \SEDE\Core\Helper::validate_form( $_POST ) ) {

            $errors->add( 'nojs-error', $GLOBALS['sede_error_message'] );
            return $errors;

        }

        return $errors;
        
    }


    public function validation_checkout( $fields, $errors ) {

        if ( \SEDE\Core\Helper::validate_form( $_POST ) ) {

            $errors->add( 'nojs-error', $GLOBALS['sede_error_message'] );
            return $errors;

        }

        return $errors;

    }

    public function add_honeypot() {

        $html = '<div class="sede--hide"><input type="hidden" name="'.esc_attr( $GLOBALS['sede_field_name'] ).'" autocomplete="off" id="sede-token" value=""></div>';
        echo wp_kses( 
            $html,
            array(
                'div'   =>  array(
                    'class' =>  array()
                ),
                'input' =>  array(
                    'id'    =>  array(),
                    'name'  =>  array(),
                    'type'  =>  array(),
                    'value' =>  array(),
                    'required'  =>  array(),
                    'autocomplete'  =>  array()
                )
            )  
        );

    }

}