<?php
namespace SEDE\Core;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Logging
{

    public function __construct() {

        add_action( 'init', array( $this, 'setup_database' ) );
        add_action( 'sede/logging/insert', array( $this, 'insert' ), 10, 3 );

    }

    public static $table_name = 'sede_logs';

    public static function setup_database() {

        global $wpdb;

        $table_name = $wpdb->prefix . self::$table_name;

        $queries = array();

        $charset_collate = $wpdb->get_charset_collate();

        $queries[] = "
        CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT NOW(),
        source varchar(255) DEFAULT NULL,
        email varchar(255) DEFAULT NULL,
        phone varchar(255) DEFAULT NULL,
        name varchar(255) DEFAULT NULL,
        website varchar(255) DEFAULT NULL,
        message longtext DEFAULT NULL,
        company varchar(255) DEFAULT NULL,
        callback_fields longtext DEFAULT NULL,
        wp_referrer varchar(255) DEFAULT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;
        ";

        include_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $queries );

    }

    /**
     * Add Log into Table
     */
    public static function insert_log( array $args = array() ) {
    
        $defaults = array(
            'time' => gmdate( 'Y-m-d H:i:s' )
        );

        $values = wp_parse_args( $args, $defaults );

        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        $wpdb->insert( $table_name, $values );

        return $wpdb->insert_id;
    }

    /**
     * Add Log
     * do_action( 'sede/logging/insert', array(), false );
     */
    public static function insert( array $fields = array(), $source = '' ) {

        $filtered_args = self::filter_field_values( $fields );
        
        if ( 1 === (int) $GLOBALS['sede_anonymize_logs'] ) {

            $args = array(
                'source'            =>  sanitize_text_field($source),
                'email'             => __( 'anonymized', 'send-denial' ),
                'phone'             => __( 'anonymized', 'send-denial' ),
                'name'              => __( 'anonymized', 'send-denial' ),
                'message'           => __( 'anonymized', 'send-denial' ),
                'website'           => __( 'anonymized', 'send-denial' ),
                'company'           => __( 'anonymized', 'send-denial' ),
                'callback_fields'   => __( 'anonymized', 'send-denial' ),
                'wp_referrer'       => $filtered_args['wp_referrer']
            );

        } else {

            $args = array(
                'source'            => sanitize_text_field($source),
                'email'             => $filtered_args['email'],
                'phone'             => $filtered_args['phone'],
                'name'              => $filtered_args['name'],
                'message'           => $filtered_args['message'],
                'website'           => $filtered_args['website'],
                'company'           => $filtered_args['company'],
                'callback_fields'   => maybe_serialize($fields),
                'wp_referrer'       => $filtered_args['wp_referrer']
            );

        }
        $insert_id = self::insert_log( $args );

    }

    /**
     * Filters out Fields of $_POST array
     */
    public static function filter_field_values( $fields ) {

        $args = array(
            'email'             => '',
            'phone'             => '',
            'name'              => '',
            'message'           => '',
            'website'           => '',
            'company'           => '',
            'wp_referrer'       => ''
        );

        if ( !empty( $fields ) && is_array( $fields ) ) {

            foreach ( $fields as $key => $value ) {

                $key = ltrim(rtrim($key));
                $value = ltrim(rtrim($value));

                // get email
                if ( filter_var( $value, FILTER_VALIDATE_EMAIL ) || str_contains( $key, 'mail' ) ) {

                    $args['email'] = sanitize_email( $value );

                }

                // get phone
                if ( str_contains( $key, 'phone' ) || str_contains( $key, 'mobile' ) ) {

                    $args['phone'] = sanitize_text_field( $value );

                }

                // get name
                if ( str_contains( $key, 'name' ) ) {

                    $args['name'] = sanitize_text_field( $value );

                }

                // get message
                if ( str_contains( $key, 'message' ) ) {

                    $args['message'] = sanitize_textarea_field( $value );

                }

                // get website
                if ( filter_var( $value, FILTER_VALIDATE_URL ) || str_contains( $key, 'website' ) || str_contains( $key, 'url' ) || str_contains( $key, 'homepage' ) ) {

                    if ( !str_contains( $key, 'referer' ) && !str_contains( $value, get_site_url() ) && !str_contains( $key, 'request' ) ) {

                        $args['website'] = sanitize_url( $value );

                    }
                    

                }

                // get company
                if ( str_contains( $key, 'company' ) ) {

                    $args['company'] = sanitize_text_field( $value );

                }

                // referrer
                if ( str_contains( $key, 'referer' ) || str_contains( $key, 'page_url' ) ) {

                    $args['wp_referrer'] = sanitize_text_field( $value );

                }

            }

            // DEBUG
            //$args['message'] = maybe_serialize($fields);

            return $args;

        }

    }

    public static function get_total_spam_blocks() {

        $total_spam_blocks = 0;

        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;
        $sql = "SELECT * FROM $table_name";
        $dataset = $wpdb->get_results($wpdb->prepare($sql));
        if ( !empty( $dataset ) ) {
            $total_spam_blocks = count($dataset);
        }
        
        return $total_spam_blocks;

    }

}