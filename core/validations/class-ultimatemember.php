<?php
namespace SEDE\Core\Validations;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Ultimatemember
{
    public function __construct() {

        add_action( 'um_after_form_fields', array( $this, 'inject_field' ), 10, 1 );
        add_filter( 'um_submit_post_form', array( $this, 'validation' ), 10, 1 );

    }

    public static function validation( $data ) {

        if ( \SEDE\Core\Helper::validate_form( $data ) ) {

            do_action( 'sede/logging/insert', $data, 'UM' );
            
            return array();

        }

        return $data;
    }

    public function inject_field() {

        $html = '<div class="sede--hide"><input type="hidden" name="'.esc_attr( $GLOBALS['sede_field_name'] ).'" autocomplete="off" value="" /></div>';
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