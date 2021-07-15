
$(document).ready(function(){

    let reg_ajax_active = 0;

    $('.registration-form').on('submit', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        if (reg_ajax_active == 0) {
            reg_ajax_active = 1;
            let form  = new ajax_form($(this));
            form.form_validation();

            if(!an_isEmpty($('.an-password').val()) && !an_isEmpty($('.an-confirm-password').val()) && $('.an-password').val() != $('.an-confirm-password').val()){
                $('.an-confirm-password').parent().append("<p class='error_display'>Incorrect confirm password</p>");
                if(form.form_valid){
                    scrollToPos('.an-confirm-password', -100);
                }
                form.form_valid = false;
            }

            if(!is_subscription_selected()){
                $('.subscription-group').append("<p class='error_display'>Required</p>");
                if(form.form_valid){
                    scrollToPos('.subscription-group', -100);
                }
                form.form_valid = false;
            }

            form.error = function(data){
                location.reload();
            }

            if(form.form_valid){
                form.success = function(data){
                    reg_ajax_active = 0;  
                    $('.captcha-image-wrap').html(data['captcha']);
                    if(data['status'] == 'success'){
                        $('.registration-form').trigger('reset');
                    }
                }
                form.form_submit();
            }else{
                reg_ajax_active = 0;
            }

        }
        
    })
})



function is_subscription_selected(){

    let selected = false;

    $('.subscription').each(function(){
        if($(this).prop("checked") == true) selected = true;
        
    })

    return selected;

}



function call_dob_datapicker(){
    $( ".dob-datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        maxDate: "0"
    });
}


