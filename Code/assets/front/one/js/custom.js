"use strict";

$(function() {
	$('.home-menu').click(function() {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top
				}, 700);
				return false;
			}
		}
	});
});


// preloader
$(window).load(function(){
    $('.preloader').fadeOut(1000); // set duration in brackets    
});

$(function() {
    new WOW().init();
    /* Hide mobile menu after clicking on a link
    -----------------------------------------------*/
    $('.navbar-collapse a').click(function(){
        $(".navbar-collapse").collapse('hide');
    });
})

$("#front_contact_form").submit(function(e) {
	e.preventDefault();
	let save_button = $(this).find('.savebtn'),
	output_status = $(this).find('.result');
	save_button.addClass('disabled');
	output_status.html('');
	
	var formData = new FormData(this);
	$.ajax({
		type:'POST',
		url: $(this).attr('action'),
		data:formData,
		cache:false,
		contentType: false,
		processData: false,
		dataType: "json",
		success:function(result){
			if(result['error'] == false){
				output_status.prepend('<div class="alert alert-success">'+result['message']+'</div>');
			}else{
				output_status.prepend('<div class="alert alert-danger">'+result['message']+'</div>');
			}
			output_status.find('.alert').delay(4000).fadeOut();    
			save_button.removeClass('disabled'); 
		}
	});
});