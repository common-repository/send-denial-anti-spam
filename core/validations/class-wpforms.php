<?php
namespace SEDE\Core\Validations;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Wpforms
{
    public function __construct() {

        add_filter( 'wpforms_process_before', array( $this, 'validation' ), 10, 2 );

    }

    public function validation( $entry, $form_data ) {

        if ( \SEDE\Core\Helper::validate_form( $_POST ) ) {

            do_action( 'sede/logging/insert', $_POST, 'Wpforms' );

            $fieldcount = count( $form_data['fields'] ) - 1;
            wpforms()->process->errors[$form_data['id']][$fieldcount] = $GLOBALS['sede_error_message'];

        }
        
    }

}