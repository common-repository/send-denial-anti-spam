<?php
namespace SEDE\Core\Validations;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

use \Jet_Form_Builder\Exceptions\Action_Exception;

class Jetformbuilder
{
    public function __construct() {

        add_filter( 'jet-form-builder/request-handler/request', array( $this, 'validation' ), 20, 1 );

    }

    public function validation( $request ) {

        if ( \SEDE\Core\Helper::validate_form( $_POST ) ) {

            do_action( 'sede/logging/insert', $_POST, 'Jetformbuilder' );

            throw new Action_Exception( $GLOBALS['sede_error_message'] );

        }

        return $request;
        
    }

}