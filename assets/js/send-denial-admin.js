(function($) {
    var SEDE = {
        createTokenAjax: function() {
            $(document).on("click touch", "#sede_create_token_btn", function(e) {

                let form = $(this).closest('form')
                let generateBtn = $(this)
                let submitBtn = form.find('input[type="submit"]')

                e.preventDefault();
                var sendData = {
                    'nonce': SEDEADMIN.cnt_nonce,
                    'action': SEDEADMIN.cnt_action,
                }
                var request = $.ajax({
                    url: SEDEADMIN.url,
                    data: sendData,
                    type: 'POST'
                });

                generateBtn.html('<img src="'+SEDEADMIN.siteurl+'/wp-admin/images/spinner.gif">')
                generateBtn.addClass('disabled')

                request.done(function(response) {
                    $('#sede_setting_fieldname').text(response.fieldname)
                    $('#sede_setting_fieldname').attr('value', response.fieldname)
                    $('#sede_setting_fieldname').val(response.fieldname)
                    $('#sede_setting_token').text(response.token)
                    $('#sede_setting_token').attr('value', response.token)
                    $('#sede_setting_token').val(response.token)
                    generateBtn.removeClass('disabled')
                    generateBtn.html(SEDEADMIN.generate_token_text)
                });
            });
        }
    }
    SEDE.createTokenAjax();
})(jQuery)