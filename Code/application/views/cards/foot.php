
<?php
    $social_options = (isset($card['social_options']) && $card['social_options'] != '')?json_decode($card['social_options'],true):'';
    $vcard_url_share = (isset($card['slug']) && $card['slug'] != '')?base_url(htmlspecialchars($card['slug'])):base_url();
?>

<?php
   if(isset($card['hide_branding']) && $card['hide_branding'] != 1){
?>
<div class="row p-3 justify-content-center">
    <a href="<?=base_url()?>" class="text-decoration-none text-white" target="_blank"><?=htmlspecialchars(footer_text())?></a>
</div>
<?php }elseif(isset($card['hide_branding']) && $card['hide_branding'] == 1 && $card_plan_modules && !$card_plan_modules['hide_branding']){ ?>
  <div class="row p-3 justify-content-center">
    <a href="<?=base_url()?>" class="text-decoration-none text-white" target="_blank"><?=htmlspecialchars(footer_text())?> HERE</a>
  </div>
<?php } ?>

<div class="modal fade" id="socialShare" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?=$this->lang->line('share_my_vcard')?htmlspecialchars($this->lang->line('share_my_vcard')):'Share My vCard'?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row justify-content-center contact-details">
                <a href="https://wa.me/?text=<?=$vcard_url_share?>" target="_blank"><span class="m-1 icon-circle"><i class="fab fa-whatsapp m-0"></i></span></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$vcard_url_share?>" target="_blank"><span class="m-1 icon-circle"><i class="fab fa-facebook m-0"></i></span></a>
                <a href="https://twitter.com/intent/tweet?text=<?=$vcard_url_share?>" target="_blank"><span class="m-1 icon-circle"><i class="fab fa-twitter m-0"></i></span></a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?=$vcard_url_share?>" target="_blank"><span class="m-1 icon-circle"><i class="fab fa-linkedin m-0"></i></span></a>
                <a href="mailto:?subject=&body=<?=$vcard_url_share?>" target="_blank"><span class="m-1 icon-circle"><i class="fa fa-at"></i></span></a>
                <a href="sms:?body=<?=$vcard_url_share?>" target="_blank"><span class="m-1 icon-circle"><i class="fa fa-comments"></i></span></a>
            </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('includes/js'); ?>

<script src="<?=base_url('assets/modules/owlcarousel2/dist/owl.carousel.min.js')?>"></script>

<script>
  var all = [{
    "version": "3.0",
    "n": "<?=isset($card['title'])?htmlspecialchars($card['title']):''?>",
    "fn": "<?=isset($card['title'])?htmlspecialchars($card['title']):''?>",
    "org": "<?=isset($card['title'])?htmlspecialchars($card['title']):''?>",
    "title": "<?=isset($card['sub_title'])?htmlspecialchars($card['sub_title']):''?>",
    "note": "<?=isset($card['description'])?str_replace(["\r\n", "\r", "\n"], " ", htmlspecialchars($card['description'])):''?>",
    "url": "<?=isset($social_options['mandatory']) && isset($social_options['mandatory']['website']) && $social_options['mandatory']['website'] != ''?htmlspecialchars($social_options['mandatory']['website']):''?>",
    "url;TYPE=WHATSAPP": "<?=isset($social_options['mandatory']) && isset($social_options['mandatory']['whatsapp']) && $social_options['mandatory']['whatsapp'] != ''?'https://wa.me/'.htmlspecialchars($social_options['mandatory']['whatsapp']):''?>",
    "tel": [
      {"value": "<?=isset($social_options['mandatory']) && isset($social_options['mandatory']['mobile']) && $social_options['mandatory']['mobile'] != ''?htmlspecialchars($social_options['mandatory']['mobile']):''?>", "type": "cell"}
    ],
    "email": [
      { "value": "<?=isset($social_options['mandatory']) && isset($social_options['mandatory']['email']) && $social_options['mandatory']['email'] != ''?htmlspecialchars($social_options['mandatory']['email']):''?>", "type": "work" }
    ],
    "adr": [
      {"value": "<?=isset($social_options['mandatory']) && isset($social_options['mandatory']['address']) && $social_options['mandatory']['address'] != ''?';'.str_replace(",",";",htmlspecialchars($social_options['mandatory']['address'])):''?>", "type": "work"}
    ]
  }];
</script>

<script src="<?=base_url('assets/js/page/vcard.js')?>"></script>

<script src="<?=base_url('assets/modules/jquery.qrcode.min.js')?>"></script>

<script>
var card_url = '<?=isset($card['slug'])?base_url($card['slug']):base_url()?>';
</script>

<script src="<?=base_url('assets/js/page/qr.js')?>"></script>

<script src="<?=base_url('assets/modules/bootstrap-lightbox/lightbox.js')?>"></script>

<script>
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});

$("#enquiryform").submit(function(e) {
	e.preventDefault();
  	let save_button = $(this).find('.savebtn'),
    output_status = $(this).find('.result'),
    card = $('#enquiryform');

  	let card_progress = $.cardProgress(card, {
    	spinner: true
  	});
  	save_button.addClass('btn-progress');
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
	    	card_progress.dismiss(function() {
			    if(result['error'] == false){
              output_status.prepend('<div class="alert alert-success">'+result['message']+'</div>');
			    }else{
			        output_status.prepend('<div class="alert alert-danger">'+result['message']+'</div>');
			    }
			    output_status.find('.alert').delay(4000).fadeOut();
			    save_button.removeClass('btn-progress');      
			    $('html, body').animate({
			        scrollTop: output_status.offset().top
			    }, 1000);
		    });
		},
    error:function(){
	    card_progress.dismiss(function() {
        output_status.prepend('<div class="alert alert-danger">'+something_wrong_try_again+'</div>');
        output_status.find('.alert').delay(4000).fadeOut();
        save_button.removeClass('btn-progress');      
        $('html, body').animate({
            scrollTop: output_status.offset().top
        }, 1000);
		  });
    }
    });
  	return false;
});
</script>