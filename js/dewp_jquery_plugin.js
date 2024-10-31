jQuery('#wa_number_field').fadeOut();
jQuery('input#wa_checkbox').change(function(){   
     if (this.checked) {
         jQuery('#wa_number_field').fadeIn();
         jQuery('#wa_number_field input').val('');         
     } else {
         jQuery('#wa_number_field').fadeOut();
         jQuery('#wa_number_field input').val(''); 
     }
});