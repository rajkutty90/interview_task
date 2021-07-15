function scrollToPos(element, top = 0){
      
    let wst = $(window).scrollTop();
    let wh  = $(window).height();

    if(element.offset()){
       
        if(element.offset().top > (wst + wh) || element.offset().top < wst ){  
            $('html, body').animate({
                scrollTop: element.offset().top + top
                }, 1000);
        }
    }

}



function ANSetSecurityToken(token){
    $('input[name="csrf_token"]').val(token);  
    an_csrf_token =  token;
}