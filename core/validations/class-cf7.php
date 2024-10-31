<?php
namespace SEDE\Core\Validations;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Cf7
{
    public function __construct() {

        add_filter( 'wpcf7_validate', array( $this, 'validation' ), 10, 2 );

    }

    public function validation( $result, $tags ){

        if ( \SEDE\Core\Helper::validate_form( $_POST ) ) {

            do_action( 'sede/logging/insert', $_POST, 'Cf7' );
            
            $result->invalidate( '', $GLOBALS['sede_error_message'] );

        }

        return $result;
    }
}