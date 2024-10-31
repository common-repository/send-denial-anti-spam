<?php
namespace SEDE\Core;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Controller
{
    public function __construct() {

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'login_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

    }

    public static function enqueue_scripts() {
        
        $sede_css = '
        .sede--hide {
            display: none!important;
        }
        .ninja-forms-form-wrap form #nf-field-sede-token-container {
            display: none!important;
        }';

        $sede_script_params = array(
            'fieldname'     =>  $GLOBALS['sede_field_name'],
            'fieldvalue'    =>  $GLOBALS['sede_field_value'],
            'credits'       =>  $GLOBALS['sede_show_credits'],
        );

        if ( 1 === (int) $GLOBALS['sede_show_credits'] ) {
            $sede_css .= '
            .sede--credits__container {
                display: inline-flex!important;
                align-items: center!important;
                padding: 15px!important;
                border-radius: 3px!important;
                background: #F4F7F9!important;
                margin: 10px 0!important;
            }
            .sede--credits__container img {
                max-width: 30px!important;
                width: 100%!important;
            }
            .sede--credits__container p {
                font-family: Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif!important;
                color: #192F43!important;
                font-size: 12px!important;
                line-height: 18px!important;
                font-weight: normal!important;
                letter-spacing: unset!important;
                text-transform: none!important;
                margin: 0 0 0 10px!important;
                max-width: 155px!important;
            }
            .sede--credits__container p a {
                color: #87BBEA!important;
                font-weight: bolder!important;
            }
            .sede--credits__container p span {
                opacity: .7!important;
            }
            ';


            $sede_script_params['badge'] = SEDE_CORE_URL . 'assets/img/Send-Denial-Badge.svg';
            $sede_script_params['credits_text'] = __( 'protected by <a rel="sponsored follow" target="_blank" href="https://senddenial.com">Send Denial</a><br/> <span>Spam Sentinel</span>', 'send-denial' );
        }

        wp_register_style( 'send-denial', false );
        wp_enqueue_style( 'send-denial' );
        wp_add_inline_style( 'send-denial', $sede_css );

        wp_enqueue_script( 'send-denial', SEDE_CORE_URL . 'assets/js/send-denial.js', array('jquery'), SEDE_PLUGIN_VERSION, true );
        wp_localize_script( 'send-denial', 'SEDEPARAMS', $sede_script_params );

    }

    public static function enqueue_admin_scripts( $hook ) {

        if ( 'settings_page_send-denial' != $hook ) {
            return;
        }

        wp_enqueue_script( 'send-denial-admin', SEDE_CORE_URL . 'assets/js/send-denial-admin.js', array('jquery'), SEDE_PLUGIN_VERSION, true );
        wp_localize_script('send-denial-admin', 'SEDEADMIN', [
            'url'                       =>  admin_url( 'admin-ajax.php' ),
            'siteurl'                   =>  site_url(),
            'generate_token_text'       =>  __( 'Generate new Token', 'send-denial' ),
            'cnt_action'                =>  'sede_create_new_token',
            'cnt_nonce'                 =>  wp_create_nonce( 'sede_create_new_token' )
        ]);

    }

    
}