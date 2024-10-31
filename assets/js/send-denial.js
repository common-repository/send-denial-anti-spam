(function($) {

    let sede_fieldname = SEDEPARAMS.fieldname
    let sede_fieldvalue = SEDEPARAMS.fieldvalue
    let sede_honeypot = '<input type="hidden" name="'+sede_fieldname+'" value="'+sede_fieldvalue+'" autocomplete="off" />'
    let sede_credits = SEDEPARAMS.credits

    var SEDE = {
        secureForms: function() {

            //cf7
            $('form.wpcf7-form').append(sede_honeypot)
            //caldera forms
            $('.caldera-grid form').append(sede_honeypot)
            //wpforms
            $('form.wpforms-form').append(sede_honeypot)
            //formidable
            $('.frm_forms form').append(sede_honeypot)
            //woocommerce
            $('.woocommerce-checkout input[name="'+sede_fieldname+'"]').val(sede_fieldvalue)
            $('.woocommerce-form-login input[name="'+sede_fieldname+'"]').val(sede_fieldvalue)
            $('.woocommerce-form-register input[name="'+sede_fieldname+'"]').val(sede_fieldvalue)
            //ninjaforms
            setTimeout(function() { 
                $('.ninja-forms-form-wrap form input#nf-field-sede-token').val(sede_fieldvalue)
            }, 1000)
            //elementor
            $('.elementor-form').append(sede_honeypot)
            //mc4wp
            $('.mc4wp-form').append(sede_honeypot)
            //jetformbuilder
            $('.jet-form-builder').append(sede_honeypot)
            //ultimate member
            $('.um-register input[name="'+sede_fieldname+'"]').val(sede_fieldvalue) 
            $('.um-login input[name="'+sede_fieldname+'"]').val(sede_fieldvalue)
            //formcraft
            $('.fc-form').append(sede_honeypot)
            
        },
        creditsBadge: function() {

            let sede_credits_icon = SEDEPARAMS.badge
            let sede_credits_text = SEDEPARAMS.credits_text
            let sede_credits_badge = '<div class="sede--credits__container"><img src="'+sede_credits_icon+'" alt="Send Denial Anti Spam Plugin Badge"><p>'+sede_credits_text+'</p></div>'

            //cf7
            $('form.wpcf7-form').append(sede_credits_badge)
            //caldera forms
            $('.caldera-grid form').append(sede_credits_badge)
            //wpforms
            $('form.wpforms-form').append(sede_credits_badge)
            //formidable
            $('.frm_forms form').append(sede_credits_badge)
            //ninjaforms
            setTimeout(function() { 
                $('.ninja-forms-form-wrap form').append('<div class="nf-form-content">'+sede_credits_badge+'</div>')
            }, 1000);
            //elementor
            $('.elementor-form').append(sede_credits_badge)
            //mc4wp
            $('.mc4wp-form').append(sede_credits_badge)
            //jetformbuilder
            $('.jet-form-builder').append(sede_credits_badge)
            //ultimate member
            $('.um-register form').append(sede_credits_badge)
            $('.um-login form').append(sede_credits_badge)
            $('.fc-form').append(sede_credits_badge)

        }
    }
    SEDE.secureForms()
    if ( 1 == sede_credits ) {
        SEDE.creditsBadge()
    }
})(jQuery)