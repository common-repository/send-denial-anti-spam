<?php
namespace SEDE\Core\Validations;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Ninjaforms
{
    public function __construct() {

        add_filter( 'ninja_forms_submit_data', array( $this, 'validation' ) );
        add_filter( 'ninja_forms_display_fields', array( $this, 'inject_field'), 10, 2 );

    }

    public function validation( $form_data ) {

        $fields = $form_data['fields'];

        if ( !empty( $fields['sede-token'] ) ) {

            if ( \SEDE\Core\Helper::validate_value( $fields['sede-token']['value'] ) ) {
                
                return $form_data;
    
            }  

        }

        $log_fields = array();

        foreach ( $fields as $field ) {
            $log_fields[ $field['key'] ] = $field['value'];
        }

        do_action( 'sede/logging/insert', $log_fields, 'Ninjaforms' );

        $form_data['errors']['fields']['1'] = $GLOBALS['sede_error_message'];

        return $form_data;

    }


    
    public function inject_field( $fields, $form_id ) {

		$field_id = substr( base_convert( md5( $form_id ), 16, 10 ), - 5 );

		$field = array(
			'objectType'        => 'Field',
			'objectDomain'      => 'fields',
			'editActive'        => false,
			'order'             => number_format( count( $fields ) - 1, 1 ),
			'type'              => 'text',
            'label'             => '',
			'key'               => '',
			'default'           => '',
			'admin_label'       => '',
			'drawerDisabled'    => false,
			'id'                => 'sede-token',
			'beforeField'       => '',
			'afterField'        => '',
			'value'             => '',
			'label_pos'         => 'above',
			'parentType'        => 'hidden',
			'element_templates' => array(
				'hidden',
				'input',
			),
			'old_classname'     => 'sede--hide',
			'wrap_template'     => 'wrap-no-label',
		);

		$fields[] = $field;

		return $fields;
    }
}