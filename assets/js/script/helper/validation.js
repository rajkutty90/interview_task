
function formValidation(form){

    form.find('.error_display').remove();
    form.find('.error-input').removeClass('error-input');
    
    let valid = true;
    let errorElement = '';

    form.find('.an-required').each(function() {
        if (an_isEmpty($(this).val()) || (Array.isArray($(this).val()) && $(this).val().length == 0)) {
            
            if($(this).hasClass('Richtext') || $(this).hasClass('stylish-file')){
              errorElement = valid ? $(this).parent() : errorElement;
              valid = false;
            }else{ 
              errorElement = valid ? $(this) : errorElement;
              valid = false;
            }
            if($(this).hasClass('stylish-file')){
              $(this).parent().find('.stylish-file-value').addClass('error-input');
            }
            $(this).parent().append("<p class='error_display'>Required</p>");
            $(this).addClass('error-input');
        }
    })

    
    /**
     * Email validation
     */
    form.find('.an-email').each(function() {
      if (!an_isEmpty($(this).val()) && !an_validateEmail($(this).val())) {
          if(!$(this).hasClass('error-input')){
            errorElement = valid ? $(this) : errorElement;
            valid = false;
            $(this).parent().append("<p class='error_display'>Invalid Email ID</p>");
            $(this).addClass('error-input');
          }
      }
    })

    /**
     * Phone Validation
     */
    form.find('.an-phone').each(function() {
     let maxDigit = 10;
     if($(this).attr('max-digit')) maxDigit = $(this).attr('max-digit');
     if (!an_isEmpty($(this).val()) && !an_validatePhone($(this).val(), maxDigit)) {
          if(!$(this).hasClass('error-input')){
            errorElement = valid ? $(this) : errorElement;
            valid = false;
            $(this).parent().append("<p class='error_display'>Invalid Phone Number</p>");
            $(this).addClass('error-input');
          }
      }
    })

    
    /**
     * Uk Phone Validation
     */
     form.find('.an-uk-phone').each(function() {
  
      if($(this).attr('max-digit')) maxDigit = $(this).attr('max-digit');
      if (!an_isEmpty($(this).val()) && !an_validateUKPhone($(this).val())) {
           if(!$(this).hasClass('error-input')){
             errorElement = valid ? $(this) : errorElement;
             valid = false;
             $(this).parent().append("<p class='error_display'>Invalid Phone Number</p>");
             $(this).addClass('error-input');
           }
       }
     })

    /**
     * Number Validation
     */
    form.find('.an-number').each(function() {
      let maxDigit = 100000000000000000;
      let minDigit = 1;
      if($(this).attr('max-digit')) maxDigit = $(this).attr('max-digit');
      if($(this).attr('min-digit')) minDigit = $(this).attr('min-digit');
      if (!an_isEmpty($(this).val()) && isNaN($(this).val())) {
           if(!$(this).hasClass('error-input')){
             errorElement = valid ? $(this) : errorElement;
             valid = false;
             $(this).parent().append("<p class='error_display'>Invalid Number</p>");
             $(this).addClass('error-input');
           }
       }else if(!an_isEmpty($(this).val())){
            if($(this).val().length < minDigit){
              errorElement = valid ? $(this) : errorElement;
              valid = false;
              $(this).parent().append("<p class='error_display'>"+minDigit+" digit minumun required</p>");
              $(this).addClass('error-input');
            }
            if($(this).val().length > maxDigit){
              errorElement = valid ? $(this) : errorElement;
              valid = false;
              $(this).parent().append("<p class='error_display'>"+maxDigit+" digit maximum</p>");
              $(this).addClass('error-input');
            }
       }
     })

    /**
     * Phone Validation
     */
    form.find('.an-format-phone').each(function() {
      let maxDigit = 10;
      if (!an_isEmpty($(this).val())) {
          let phoneNumber = $(this).val();
          phoneNumber     = phoneNumber.replace(' ', '');
          phoneNumber     = phoneNumber.replace('(', '');
          phoneNumber     = phoneNumber.replace(')', '');
          phoneNumber     = phoneNumber.replace('-', '');
          if(phoneNumber.length != maxDigit){
            if(!$(this).hasClass('error-input')){
              errorElement = valid ? $(this) : errorElement;
              valid = false;
              $(this).parent().append("<p class='error_display'>Invalid Phone Number</p>");
              $(this).addClass('error-input');
            }
          }
      }
     })
    

     /**
     * URL Validation
     */
    form.find('.an-url').each(function() {
      if (!an_isEmpty($(this).val()) && !an_isValidURL($(this).val())) {
          if(!$(this).hasClass('error-input')){
            errorElement = valid ? $(this) : errorElement;
            valid = false;
            $(this).parent().append("<p class='error_display'>Invalid Url</p>");
            $(this).addClass('error-input');
          }
      }
    })

     /**
     * Facebook URL Validation
     */
    form.find('.an-url-facebook').each(function() {
      if (!an_isEmpty($(this).val()) && !an_isFacebookValidURL($(this).val())) {
          if(!$(this).hasClass('error-input')){
            errorElement = valid ? $(this) : errorElement;
            valid = false;
            $(this).parent().append("<p class='error_display'>Invalid Url</p>");
            $(this).addClass('error-input');
          }
      }
    })

    /**
     * Google URL Validation
     */
    form.find('.an-url-google').each(function() {
      if (!an_isEmpty($(this).val()) && !an_isGoogleValidURL($(this).val())) {
          if(!$(this).hasClass('error-input')){
            errorElement = valid ? $(this) : errorElement;
            valid = false;
            $(this).parent().append("<p class='error_display'>Invalid Url</p>");
            $(this).addClass('error-input');
          }
      }
    })

    
    /**
     * Google URL Validation
     */
    form.find('.an-url-youtube').each(function() {
      if (!an_isEmpty($(this).val()) && !an_isYoutubeValidURL($(this).val())) {
          if(!$(this).hasClass('error-input')){
            errorElement = valid ? $(this) : errorElement;
            valid = false;
            $(this).parent().append("<p class='error_display'>Invalid Url</p>");
            $(this).addClass('error-input');
          }
      }
    })

    /**
     * Color Validation
     */
    form.find('.an-color').each(function() {
      if (!an_isEmpty($(this).val()) && !an_color($(this).val())) {
          if(!$(this).hasClass('error-input')){
            errorElement = valid ? $(this) : errorElement;
            valid = false;
            $(this).parent().append("<p class='error_display'>Invalid Color Code</p>");
            $(this).addClass('error-input');
          }
      }
    })

    /**
     * Price Validation
     */
    form.find('.an-price').each(function() {
      if (!an_isEmpty($(this).val()) && !an_price($(this).val())) {
          if(!$(this).hasClass('error-input')){
            errorElement = valid ? $(this) : errorElement;
            valid = false;
            $(this).parent().append("<p class='error_display'>Invalid Price</p>");
            $(this).addClass('error-input');
          }
      }
    })

    /**
     * Date Validation
     */
    form.find('.an-date').each(function() {
      if (!an_isEmpty($(this).val()) && !an_date($(this).val())) {
          if(!$(this).hasClass('error-input')){
            errorElement = valid ? $(this) : errorElement;
            valid = false;
            $(this).parent().append("<p class='error_display'>Invalid Date</p>");
            $(this).addClass('error-input');
          }
      }
    })

    /**
     * Validate String length
     */

    form.find('input, select, textarea').each(function(){
      let maxLen = 10000000;
      let minLen = 0;
      if($(this).attr('max-length')) maxLen = $(this).attr('max-length');
      if($(this).attr('min-length')) minLen = $(this).attr('min-length');

      if (!$(this).hasClass('error-input') && $(this).val().length < minLen && !an_isEmpty($(this).val())) {
             errorElement = valid ? $(this) : errorElement;
             valid = false;
             $(this).parent().append("<p class='error_display'>The field must be at least " + minLen +" characters in length.</p>");
             $(this).addClass('error-input');   
      }

      if (!$(this).hasClass('error-input') && $(this).val().length > maxLen && !an_isEmpty($(this).val())) {
        errorElement = valid ? $(this) : errorElement;
        valid = false;
        $(this).parent().append("<p class='error_display'>The field must be at most " + maxLen +" characters in length.</p>");
        $(this).addClass('error-input');
      }

    })
      
    

    let status = {valid : valid, errorElement : errorElement}

    return status;
} 


function checkboxValidate(form, classname, errorLevel = 1){
   
   let valid = false;

   form.find('.' + classname).each(function(){
      if($(this).is(":checked")){
        valid = true;
      }
   })

   if(!valid){

     if(errorLevel == 2){
        form.find('.' + classname).parent().parent().append("<p class='error_display'>Required</p>");
     }else if(errorLevel == 3){
        form.find('.' + classname).parent().parent().parent().append("<p class='error_display'>Required</p>");
     }else if(errorLevel == 4){
      form.find('.' + classname).parent().parent().parent().parent().append("<p class='error_display'>Required</p>");
     }else{
        form.find('.' + classname).parent().append("<p class='error_display'Required</p>");
     }
     form.find('.' + classname).addClass('error-input');
   }

   return valid;

}


/*------------------------------Common Functions------------------------------------*/

/*Email Validation */

function an_validateEmail(email) {
  var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
  return re.test(email);
}

/*Empty String Validation */

function an_isEmpty(str) {
    
    if(typeof str === 'object'){
      if(!str) return true;
    }else{
      return !str.replace(/^\s+/g, '').length; // boolean (`true` if field is empty)
    }
  
}

/*Url Validation */

function an_isValidURL(url) {
  var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

  if (RegExp.test(url)) {
      return true;
  } else {
      return false;
  }
}

/*Google URL Validation */

function an_isGoogleValidURL(url) {
  var RegExp = /^(https:\/\/www.google.com\/).*/;

  if (RegExp.test(url)) {
      return true;
  } else {
      return false;
  }
}

/*Facebook URL Validation */

function an_isFacebookValidURL(url) {
  var RegExp = /^(https:\/\/www.facebook.com\/).*/;

  if (RegExp.test(url)) {
      return true;
  } else {
      return false;
  }
}

/*Youtube URL Validation */

function an_isYoutubeValidURL(url) {
  var RegExp = /^https:\/\/www\.youtube\.com\/watch\?v=.*/;

  if (RegExp.test(url)) {
      return true;
  } else {
      return false;
  }
}

/* Phone number Validation */

function an_validatePhone(txtPhone, maxDigit = 10) {
  var a = txtPhone;
  var filter = new RegExp("^[0-9]{"+maxDigit+"}$");
  if (filter.test(a)) {
      return true;
  } else {
      return false;
  }
}

/*UK Phone number Validation */

function an_validateUKPhone(txtPhone) {
  var a = txtPhone;
  var filter = new RegExp("^0[0-9]{9,10}$");
  if (filter.test(a)) {
      return true;
  } else {
      return false;
  }
}

/* color Validation */

function an_color(color) {
  var a = color;
  var filter = /^#[0-9a-f]{3,6}$/;
  if (filter.test(a)) {
      return true;
  } else {
      return false;
  }
}

/* price Validation */

function an_price(price) {
  var a = price;
  var filter = /^\d*\.?\d*$/;
  if (filter.test(a)) {
      return true;
  } else {
      return false;
  }
}

/**Function to check valid date */

function an_date(date, seperation = '/'){
  let date_split = date.split(seperation);
  
  if(date_split.length == 3){
    let selMonth  = parseInt(date_split[0]);
    let selDate   = parseInt(date_split[1]);
    let selYear   = parseInt(date_split[2]);
    if(selMonth > 0 && selMonth < 13 && selDate > 0 && selDate < 32 && selYear > 1900 && selYear < 2100){
      
      let leapYear = false;
      if(selYear % 4 == 0)  leapYear = true; 
      if(selMonth == 4 || selMonth == 6 || selMonth == 9 || selMonth == 11){
        if(selDate ==  31) return false;
      }
      if(selMonth == 2){
        if(leapYear && selDate > 29) return false;
        if(!leapYear && selDate > 28) return false;
      }
      return true;
    }
  }

  return false;
}


/**Function to validate age range*/

function an_age_range(period_year_start, period_month_start, period_year_end, period_month_end, year_start = 0, year_end = 20){

    if(period_year_start < year_start || period_year_start > year_end) return false;
    if(period_year_end < year_start || period_year_end > year_end) return false;
    if(period_month_start < 0 || period_month_start > 12) return false;
    if(period_month_end < 0 || period_month_end > 12) return false;
    
    if(((parseInt(period_year_start) * 12) + parseInt(period_month_start)) > ((parseInt(period_year_end) * 12) + parseInt(period_month_end))) return false;

    return true;

}





// Restricts input for the given textbox to the given inputFilter function.
function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
      textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    });
  }




loadValidation();

function loadValidation(){
    $('.AN-char').each(function(){
        let maxDigit = "*";
        if($(this).attr("max-digit")) maxDigit = '{0,'+parseInt($(this).attr("max-digit"))+'}';
        setInputFilter($(this)[0], function(value) {
        let reg = new RegExp('^[0-9a-zA-Z]'+maxDigit+'$','i');
        return reg.test(value); });
        
    })

    $('.ANS-char').each(function(){
      let maxDigit = "*";
      if($(this).attr("max-digit")) maxDigit = '{0,'+parseInt($(this).attr("max-digit"))+'}';
      setInputFilter($(this)[0], function(value) {
      let reg = new RegExp('^[0-9a-zA-Z ]'+maxDigit+'$','i');
      return reg.test(value); });
      
  })

    $('.AS-char').each(function(){
        let maxDigit = "*";
        if($(this).attr("max-digit")) maxDigit = '{0,'+parseInt($(this).attr("max-digit"))+'}';
        setInputFilter($(this)[0], function(value) {
          let reg = new RegExp('^[a-zA-Z ]'+maxDigit+'$','i');  
          return reg.test(value); });
    })

    $('.N-char').each(function(){
        let maxDigit = "*";
        if($(this).attr("max-digit")) maxDigit = '{0,'+parseInt($(this).attr("max-digit"))+'}';
        setInputFilter($(this)[0], function(value) {
            let reg = new RegExp('^[0-9]'+maxDigit+'$','i');
            return reg.test(value); });
    })

    $('.price-char').each(function(){
      setInputFilter($(this)[0], function(value) {
          return /^\d*\.?\d*$/i.test(value); });
    })

    $('.color-char').each(function(){
      setInputFilter($(this)[0], function(value) {
          return /^#[0-9a-f]{3,6}$/i.test(value); });
    })
    
}


$(document).ready(function(){


  $(document).on('focus','.error-input,.an-cb-required',function(){
      $(this).removeClass('error-input');
      $(this).parent().find('.error_display').remove();
      if($(this).hasClass('an-cb-required')){
        $(this).parent().parent().parent().find('.error_display').remove();
      }
  })

  $(document).on('change focus click', '.tox-tinymce', function(){
    $(this).parent().find('.error_display').remove();
  })

 
  /**
   * Password Strengh Check
   */

   $(document).on("input keydown keyup mousedown mouseup select contextmenu drop", '.an-password', function(){
      let strenght      = getPasswordStrong($(this).val());
      let strenghtClass = getPassStrenghClassName(strenght);
      $(this).parent().find('.an-password-metre-wrap').attr('class', 'an-password-metre-wrap');
      $(this).parent().find('.an-password-metre-wrap').addClass(strenghtClass.class);
      $(this).parent().find('.an-password-metre-wrap .status').html(strenghtClass.name);
   })
  
   /**File Select */

   $(document).on('change','.stylish-file',function(){
     fileValidate(this.files[0], $(this), $(this));
   })

})

function fileValidate(file, fileElement, element){
    var file        = file;
    var name        = file.name;
    var size        = file.size;
    var type        = file.type;
    var validation  = true;
    var message     = "Invalid File";

    
    if(fileElement.attr('data-file-type')){
        var allowFormat = fileElement.attr('data-file-type');   
        var allowFormat = allowFormat.split('|'); // split string on comma space
        var validFile   = false;
            validation  = false;

        if(allowFormat && allowFormat.length > 0){
            for(let i = 0; i < allowFormat.length; i++){
                if(type == allowFormat[i]) {validFile = true; validation = true;}
            }
        }

    }

    if(validation && (fileElement.attr('min-width') || fileElement.attr('min-height') || fileElement.attr('max-width') || fileElement.attr('max-height') )){
      
      let image      = new Image();
      let _URL       = window.URL || window.webkitURL;
      var objectUrl  = _URL.createObjectURL(file);
      let currentFile = fileElement;
      image.onload = function () {

        let imgWidth  = this.width;
        let imgHeight = this.height;

        if(currentFile.attr('min-width') && currentFile.attr('min-width') > imgWidth){
          validation = false;message ='Please upload large image';
        }
        if(currentFile.attr('min-height') && currentFile.attr('min-height') > imgHeight){
          validation = false; message ='Please upload large image';
        }
        if(currentFile.attr('max-width') && currentFile.attr('max-width') < imgWidth){
          validation = false; message ='Please upload small image';
        }
        if(currentFile.attr('max-height') && currentFile.attr('max-height') < imgHeight){
          validation = false; message ='Please upload small image';
        }

        fileStatus(element, validation, message);

        _URL.revokeObjectURL(objectUrl);
      };
      image.src = objectUrl;
    }else{
      fileStatus(element, validation, message);
    }

    return validation;
}

function fileStatus(element, validation, message){
  element.parent().find('.error_display').remove();
  element.parent().find('.stylish-file-value').removeClass('error-input'); 
  if(validation){
    element.parent().find('.stylish-file-value').val(element.val());
  }else{
    element.parent().find('.stylish-file-value').val("").addClass('error-input'); 
    element.val("");
    element.parent().append('<p class="error_display">'+message+'</p>');
  }
  
}

/**Function to get password strong*/

function getPasswordStrong(value){
  let strengh = 0;

  var patt = /[A-Z]/;
  if(patt.test(value)) strengh++;

  var patt = /[a-z]/;
  if(patt.test(value)) strengh++;

  var patt = /[0-9]/;
  if(patt.test(value)) strengh++;

  var patt = /\W/;
  if(patt.test(value)) strengh++;
  
  if(value.length > 8)  strengh++;

  return strengh;

}

/**Function to get strengh class */

function getPassStrenghClassName(strengh){

   if(strengh == 0) return {class:'very-weak', name:'Very weak'};
   if(strengh == 1) return {class:'weak', name:'Weak'};
   if(strengh == 2) return {class:'average', name:'Average'};
   if(strengh == 3) return {class:'strong', name:'Strong'};
   if(strengh == 4) return {class:'very-strong', name:'Very Strong'};

}


