"use strict";

var wrapper         = $(".input_fields_wrap"); 
var add_button      = $(".add_field_button"); 

$(add_button).click(function(e){
  e.preventDefault();
   $(wrapper).append('<span class="col-md-12 remove_field_wrap"><span class="row"><div class="form-group col-md-3">'+
                        '<input type="text" name="icon[]" value="" class="form-control">'+
                      '</div>'+
                      '<div class="form-group col-md-4">'+
                        '<input type="text" name="text[]" value="" class="form-control">'+
                      '</div>'+
                      '<div class="form-group col-md-4">'+
                        '<input type="text" name="url[]" value="" class="form-control">'+
                      '</div>'+
                      '<div class="form-group col-md-1">'+
                        '<a href="#" class="btn btn-icon btn-danger remove_field"><i class="fas fa-times"></i></a>'+
                      '</div></span></span>');
});

$(wrapper).on("click",".remove_field", function(e){ 
    e.preventDefault(); $(this).closest('.remove_field_wrap').remove(); x--;
})