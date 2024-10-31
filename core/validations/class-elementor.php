<?php
namespace SEDE\Core\Validations;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor
{
    public function __construct() {

        add_action( 'elementor_pro/forms/validation', array( $this, 'validation' ), 10, 2 );

    }

    public function validation( $record, $ajax_handler ) {

        if ( \SEDE\Core\Helper::validate_form( $_POST ) ) {

            do_action( 'sede/logging/insert', $_POST, 'Elementor' );

            $ajax_handler->add_error( 'field_id', '<div class="sede-hide" style="display:none">'.$GLOBALS['sede_error_message'].'</div>' );
            $ajax_handler->add_error_message( $GLOBALS['sede_error_message'] );
            $ajax_handler->is_success = false;
            
        }

    }
}