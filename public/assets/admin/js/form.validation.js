$('.validate-form').on('submit', function(){

    var formId = $(this).attr('id');
    var proceed = true;
    $('#'+formId+'.validate-form input[data-required=true],#'+formId+'.validate-form textarea[data-required=true],#'+formId+'.validate-form select[data-required=true]').each(function() {
        $(this).removeClass('has-error');
        if(!$.trim($(this).val())){ //if this field is empty 
            $(this).addClass('has-error') //change border color to red   
            proceed = false; //set do not proceed flag
        }
        //check invalid email
        var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
        if($(this).attr("type")=="email" && !email_reg.test($.trim($(this).val()))){
            $(this).addClass('has-error'); //change border color to red   
            proceed = false; //set do not proceed flag              
        }

    });
    return proceed;

});