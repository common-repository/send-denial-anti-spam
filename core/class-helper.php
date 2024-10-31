<?php
namespace SEDE\Core;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Helper
{
    /**
     * basic validation if hidden field is present
     */
    public static function validate_form( $fields ) {

        if ( array_key_exists( $GLOBALS['sede_field_name'], $fields ) ) { // hidden field is present

            $fieldname = $GLOBALS['sede_field_name'];
            if ( $fields[$fieldname] === $GLOBALS['sede_field_value'] ) { // hidden field value is same as globals

                return false; // is not spam and not manipulated

            }

            return true; // is spam

        } else {

            return true; // is spam

        }

    }

    /**
     * basic validation if token value is valid
     */
    public static function validate_value( $value ) {

        if ( $value === $GLOBALS['sede_field_value'] ) { // hidden field value is same as globals

            return true; // is not spam and not manipulated

        }

        return false; // is spam

    }

    /**
     * creates random token
     */
    public static function create_token() {

        $string = substr( str_shuffle( md5( microtime() ) ), 0, 10 );
        return $string;

    }
}