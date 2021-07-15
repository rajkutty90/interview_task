
$(document).ready(function(){

    let user_ajax_active = 0;

    $('.update-user-form').on('submit', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        if (user_ajax_active == 0) {
            user_ajax_active = 1;
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
                    user_ajax_active = 0;  
                }
                form.form_submit();
            }else{
                user_ajax_active = 0;
            }

        }
        
    })

    $('.btn-remove-user').on('click', function(){

        let user_id = $(this).attr('data-id');

        let button  = $(this);

        if(user_ajax_active == 0){
            user_ajax_active = 1;
            button.addClass('active');
            let data = { csrf_token: an_csrf_token, user_id : user_id };
            let ajax_url = an_site_url + 'users/delete-user';
            $.ajax({
                type: "POST",
                dataType: "json",
                url: ajax_url,
                data: data,
                success: function(result) {
                    button.removeClass('active');
                    user_ajax_active = 0;
                    location.assign(an_site_url + 'dashboard');
                },
                error: function(data) {
                    button.removeClass('active');
                    user_ajax_active = 0;
                }
            });
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


