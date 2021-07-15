var ajax_form  = function(form){
                   
                    this.form             = form;
                    this.url              = form.attr("data-action");
                    this.form_valid       = false;
                    this.success          = function(data){};
                    this.error            = function(data){location.reload();};
                    this.form_send        = false;
                    this.form_valid_add   = false;
                    this.form_scroll_to   = false;

                    this.form_validation  = function(){
                
                        this.form.find('.error-message').removeClass('show');
                        this.form.find('.an-form-submit-message').addClass('hide').removeClass('error').removeClass('success');
                        let form_valid    = formValidation(this.form);

                        if(form_valid.valid){
                            this.form_valid = true;
                            if(this.form_valid_add){
                                this.form_valid_add();
                            }  
                        }else{
                            this.form_scroll_to  = form_valid.errorElement;
                        }

                        if(!form_valid.valid){  
                            scrollToPos(this.form_scroll_to, -100);
                        }
                    }

                    this.form_submit      = function(){  
                        this.form.find('.btn-ajax-form-btn').addClass("active");
                        let c_form        = this;
                        $.ajax({
                            url: this.url,
                            type: "POST",
                            data: new FormData(this.form[0]),
                            dataType: "json",
                            mimeType: "multipart/form-data",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                c_form.form_send   = true;
                                ANSetSecurityToken(data['csrf_token']);
                                c_form.form.find('.btn-ajax-form-btn').removeClass("active");
                                if (data['status'] == 'error') {
                                    formError(c_form.form, data['error_display']);
                                    if(data['message']){
                                        c_form.form.find('.an-form-submit-message').html(data['message']).removeClass('hide').addClass('error'); 
                                    }
                                }else{
                                    if(data['message']){
                                        c_form.form.find('.an-form-submit-message').html(data['message']).removeClass('hide').addClass('success'); 
                                    }
                                }   
                                c_form.success(data);
                            },
                            error: function(data) {
                                c_form.form.find('.btn-ajax-form-btn').removeClass("active");
                                setTimeout(function(){c_form.error(data);},1000);    
                            }
                        });

                    }
    
                    
                 };


function formError(form, data){
    
    let firstError = '';

    for (var key in data) { 
        if (data.hasOwnProperty(key)) { 
            if(data[key]){
                if(!firstError){
                    firstError = form.find('.'+key);
                }
                form.find('.'+key).parent().append("<p class='error_display'>" + data[key] + "</p>");
                form.find('.'+key).addClass('error-input');
            }
        } 
    }  
   
   if(firstError) scrollToPos(firstError, -100); 
}

