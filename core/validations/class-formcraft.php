<?php
namespace SEDE\Core\Validations;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Formcraft
{
    public function __construct() {

        add_action( 'formcraft_before_save', array( $this, 'validation' ), 10, 4 );

    }

    public function validation( $content, $meta, $raw_content, $integrations ) {

        if ( \SEDE\Core\Helper::validate_form( $_POST ) ) {

            do_action( 'sede/logging/insert', $_POST, 'Formcraft' );

            global $fc_final_response;
            $fc_final_response['failed'] = $GLOBALS['sede_error_message'];
            echo json_encode($fc_final_response);
            die();
            
        }

    }
}