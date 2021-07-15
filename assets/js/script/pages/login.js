
$(document).ready(function(){

    let login_ajax_active = 0;

    $('.login-form').on('submit', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        if (login_ajax_active == 0) {
            login_ajax_active = 1;
            let form  = new ajax_form($(this));
            form.form_validation();

            form.error = function(data){
                location.reload();
            }

            if(form.form_valid){
                form.success = function(data){
                    login_ajax_active = 0;  
                    if(data['status'] == 'success'){
                        $('.login-form').trigger('reset');
                        location.assign(data['url']);
                    }
                }
                form.form_submit();
            }else{
                login_ajax_active = 0;
            }

        }
        
    })
})
