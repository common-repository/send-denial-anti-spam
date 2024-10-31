<?php
namespace SEDE\Core\Validations;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Mc4wp
{
    public function __construct() {

        add_filter( 'mc4wp_form_errors', array( $this, 'validation' ), 10, 2 );

    }

    public function validation( $errors, $form ) {

        if ( array_key_exists( $GLOBALS['sede_field_name'], $form->raw_data ) ) {
            
            if ( \SEDE\Core\Helper::validate_value( rtrim(ltrim($form->raw_data[$GLOBALS['sede_field_name']])) ) ) {

                return $errors;
            
            }

        }

        do_action( 'sede/logging/insert', $form->raw_data, 'Mc4wp' );

        $errors[] = $GLOBALS['sede_error_message'];
        
        return $errors;
        
    }

}