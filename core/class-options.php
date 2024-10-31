<?php
namespace SEDE\Core;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Options
{

    public function __construct() {

        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'init', array( $this, 'load_options' ) );
        add_action( 'wp_ajax_sede_create_new_token', array( $this, 'ajax_generate_new_token') );

    }

    /**
     * loads settings to globals
     */
    public function load_options() {
        $sede_plugin_options = get_option( 'sede_plugin_options' );

        $GLOBALS['sede_field_name'] = $sede_plugin_options['fieldname'];
        $GLOBALS['sede_field_value'] = $sede_plugin_options['token'];

        $GLOBALS['sede_show_credits'] = 0;
        if ( array_key_exists( 'show_credits', $sede_plugin_options ) ) {
            $GLOBALS['sede_show_credits'] = $sede_plugin_options['show_credits'];
        }

        $GLOBALS['sede_anonymize_logs'] = 1;
        if ( !array_key_exists( 'anonymize_logs', $sede_plugin_options ) ) {
            $GLOBALS['sede_anonymize_logs'] = 0;
        }
        
        $GLOBALS['sede_error_message'] = __( 'An error occured, you have no javascript, this websites has a problem or you are a spammer', 'send-denial' );
    }

    /**
     * registers settings
     */
    public function register_settings() {
        register_setting( 'sede_plugin_options', 'sede_plugin_options', 'sede_plugin_options_validate' );

        add_settings_section( 
            'log_section', 
            __( 'Logs', 'send-denial' ), 
            array( $this, 'plugin_section_text_logs' ), 
            'sede_plugin' 
        );
        add_settings_section( 
            'general_section', 
            __( 'Settings', 'send-denial' ), 
            array(), 
            'sede_plugin' 
        );
        add_settings_section( 
            'credits_section', 
            __( 'Credits', 'send-denial' ), 
            array( $this, 'plugin_section_text_credits' ), 
            'sede_plugin' 
        );

        add_settings_field( 
            'sede_field_name', 
            __( 'Honeypot Field Name', 'send-denial' ), 
            array( $this, 'plugin_setting_fieldname' ), 
            'sede_plugin', 
            'general_section' 
        );

        add_settings_field( 
            'sede_field_value', 
            __( 'Honeypot Field Value', 'send-denial' ), 
            array( $this, 'plugin_setting_token' ), 
            'sede_plugin', 
            'general_section' 
        );

        add_settings_field( 
            'sede_anonymize_logs', 
            __( 'Anonymize Logs', 'send-denial' ), 
            array( $this, 'plugin_setting_anonymize_logs' ), 
            'sede_plugin', 
            'general_section' 
        );

        add_settings_field( 
            'sede_show_credits', 
            __( 'Show Badge', 'send-denial' ), 
            array( $this, 'plugin_setting_show_credits' ), 
            'sede_plugin', 
            'credits_section' 
        );
        
    }

    /**
     * registers menu item
     */
    public function add_settings_page() {
        add_options_page( 
            __( 'Send Denial Anti Spam Settings', 'send-denial' ), 
            'Send Denial', 
            'manage_options', 
            'send-denial', 
            array( $this, 'render_plugin_settings_page' ) 
        );
    }

    /**
     * redner menu item page
     */
    public function render_plugin_settings_page() {
        ?>
        <h2><?php echo __( 'Send Denial', 'send-denial' ) ?></h2>
        <form action="options.php" method="POST">
            <?php 
            settings_fields( 'sede_plugin_options' );
            do_settings_sections( 'sede_plugin' ); ?>
            <input name="submit" class="button button-primary button-hero" type="submit" value="<?php echo esc_attr( __( 'Save Changes', 'send-denial' ) ) ?>" />
        </form>
        <?php
    }

    /**
     * logs section html
     */
    public function plugin_section_text_logs() {

        $number = \SEDE\Core\Logging::get_total_spam_blocks();

        $html = '<div style="max-width:500px; margin-bottom: 50px;" class="notice notice-success">';
        $html .= '<p>'.__( 'Send Denial successfully saved you from', 'send-denial' ).' <strong>'.$number.'</strong> spam submissions so far.</p>';
        $html .= '</div>';
        echo wp_kses( 
            $html,
            array(
                'p'      => array(
                    'style'  => array()
                ),
                'br'     => array(),
                'strong' => array(),
                'div' => array( 
                    'class' => array(),
                    'style' => array(),
                )
            ) 
        );
    }

    /**
     * settings section html
     */
    public function plugin_section_text_credits() {
        $html = '<p style="max-width:500px">'.__( '<strong>Send Denial is built, maintained and extended for free.<br /> It will support as many major form plugins as possible for free.</strong><br /> Including Premium Form Builders and WooCommerce. Therefore helps your business stay safe and protect you from spam mails by your forms.<br /> It will never spam or hijack your wp-admin on trying to upsell a premium version. <br />If you like this way of thinking feel free to enable this checkbox. <strong>It will display a very decent and small badge below your forms</strong> that the form is protected by Send Denial and helps Send Denial get more recognition.', 'send-denial' ).'</p>';
        echo wp_kses( 
            $html,
            array(
                'p'      => array(
                    'style'  => array()
                ),
                'br'     => array(),
                'strong' => array()
            ) 
        );
    }

    public function plugin_setting_token() {
        $options = get_option( 'sede_plugin_options' );
        $html = "<input id='sede_setting_token' name='sede_plugin_options[token]' type='text' value='".esc_attr($options['token'])."' required />";
        $html .= '<div style="min-height: 30px"></div>';
        $html .= "<p><span id='sede_create_token_btn' class='button button-secondary'>".__( 'Create new Pair', 'send-denial' )."</span></p>";
        $html .= "<p><em>".__( 'Change the token and fieldname from time to time if you like', 'send-denial' )."</em></p>";
        echo wp_kses( 
            $html,
            array(
                'p'      => array(
                    'style'  => array(),
                    'id'    =>  array(),
                ),
                'br'     => array(),
                'strong' => array(),
                'span'  =>  array(
                    'id'    =>  array(),
                    'class' =>  array(),
                ),
                'em'    =>  array(),
                'div'   =>  array(),
                'input' =>  array(
                    'id'    =>  array(),
                    'name'  =>  array(),
                    'type'  =>  array(),
                    'value' =>  array(),
                    'required'  =>  array()
                )
            )  
        );

       
    }

    public function plugin_setting_fieldname() {
        $options = get_option( 'sede_plugin_options' );
        $html = "<input id='sede_setting_fieldname' name='sede_plugin_options[fieldname]' type='text' value='".esc_attr($options['fieldname'])."' required />";
        echo wp_kses( 
            $html,
            array(
                'input' =>  array(
                    'id'    =>  array(),
                    'name'  =>  array(),
                    'type'  =>  array(),
                    'value' =>  array(),
                    'required'  =>  array()
                )
            )  
        );
    }

    public function plugin_setting_anonymize_logs() {
        $options = get_option( 'sede_plugin_options' );
        $value = false;
        if ( isset( $options['anonymize_logs'] ) ) {
            $value = $options['anonymize_logs'];
        }
        $html = "<input id='sede_setting_anonymize_logs' name='sede_plugin_options[anonymize_logs]' type='checkbox' value='1' ".checked( 1, esc_attr($value), false )."/>";
        $html .= '<p><em>'.__( 'No submit data will be saved if checked. <br />Since it is 99% bot submissions it is probably no problem at all.<br /> But for total control you can check it if your legal department is worried (GDPR Watchdogs) :)', 'send-denial' ).'</em></p>';
        echo wp_kses( 
            $html,
            array(
                'input' =>  array(
                    'id'    =>  array(),
                    'name'  =>  array(),
                    'type'  =>  array(),
                    'value' =>  array(),
                    'required'  =>  array(),
                    'checked'   =>  array()
                ),
                'p' =>  array(),
                'br' => array(),
                'em' => array()
            )  
        );
    }

    public function plugin_setting_show_credits() {
        $options = get_option( 'sede_plugin_options' );
        $value = false;
        if ( isset( $options['show_credits'] ) ) {
            $value = $options['show_credits'];
        }
        $html = "<input id='sede_setting_show_credits' name='sede_plugin_options[show_credits]' type='checkbox' value='1' ".checked( 1, esc_attr($value), false )."/>";
        echo wp_kses( 
            $html,
            array(
                'input' =>  array(
                    'id'    =>  array(),
                    'name'  =>  array(),
                    'type'  =>  array(),
                    'value' =>  array(),
                    'required'  =>  array(),
                    'checked'   =>  array()
                )
            )  
        );
    }

    /**
     * ajax generate new token
     */
    public function ajax_generate_new_token() {

        $data = array(
            'success'   =>  false
        );

        if( wp_verify_nonce( $_POST[ 'nonce' ], 'sede_create_new_token' ) ) {
            $token = \SEDE\Core\Helper::create_token();
            $fieldname = \SEDE\Core\Helper::create_token();
            $data = array(
                'token'     =>  $token,
                'fieldname' =>  $fieldname,
                'success'   =>  true
            );
        }

        wp_send_json( $data );
        

    }
    

}