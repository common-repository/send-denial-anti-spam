<?php
namespace SEDE\Core\Validations;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Formidable
{
    public function __construct() {

        add_filter( 'frm_validate_entry', array( $this, 'validation' ), 10, 2 );

    }

    public function validation( $errors, $values ) {

        if ( \SEDE\Core\Helper::validate_form( $_POST ) ) {

            do_action( 'sede/logging/insert', $_POST, 'Formidable' );

            $errors['nojs'] = $GLOBALS['sede_error_message'];

        }

        return $errors;
        
    }

}