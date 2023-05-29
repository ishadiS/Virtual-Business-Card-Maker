<!DOCTYPE html>
<html lang="en">

<head> 
  
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

<?php if(isset($meta_image) && !empty($meta_image)){ ?>
<meta property="og:image" itemprop="image" content="<?=htmlspecialchars($meta_image)?>" />
<?php }else{ ?>
<meta property="og:image" itemprop="image" content="<?=base_url('assets/uploads/logos/'.full_logo())?>" />
<?php } ?>

<meta property="og:type" content="website" />
<meta property="og:description" content="<?=(isset($meta_description) && !empty($meta_description))?htmlspecialchars($meta_description):htmlspecialchars($page_title)?>" />
<title><?=htmlspecialchars($page_title)?></title>

<link rel="shortcut icon" href="<?=base_url('assets/uploads/logos/'.favicon())?>">

<!-- General CSS Files -->  

<link rel="stylesheet" href="<?=base_url('assets/modules/bootstrap/css/bootstrap.min.css')?>">

<link rel="stylesheet" href="<?=base_url('assets/modules/fontawesome/css/all.min.css')?>">

<!-- CSS Libraries -->
<link rel="stylesheet" href="<?=base_url('assets/modules/bootstrap-daterangepicker/daterangepicker.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/modules/select2/dist/css/select2.min.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/modules/bootstrap-table/bootstrap-table.min.css');?>">
<link rel="stylesheet" href="<?=base_url('assets/modules/izitoast/css/iziToast.min.css');?>">
<link rel="stylesheet" href="<?=base_url('assets/modules/codemirror/lib/codemirror.css');?>">
<link rel="stylesheet" href="<?=base_url('assets/modules/codemirror/theme/duotone-dark.css');?>">

<style>
    :root{--theme-color: <?=theme_color()?>;}
    <?php if(isset($card['card_bg_type']) && $card['card_bg_type'] != '' && $card['card_bg_type'] == 'Image'){ 
        if($card['card_bg'] != '' && file_exists('assets/uploads/card-bg/'.$card['card_bg'])){ 
            $card_bg_image = "url('".base_url('assets/uploads/card-bg/'.$card['card_bg'])."')"
    ?>
        :root{--card-bg-image: <?=isset($card_bg_image)?$card_bg_image:''?> ;}
        :root{--card-bg-color: #212529;}
    <?php }else{?>
        :root{--card-bg-color: <?=theme_color()?>;}
    <?php } }else{ ?>
        :root{--card-bg-color: <?=(isset($card['card_bg']) && $card['card_bg'] != '')?$card['card_bg']:theme_color()?>;}
    <?php } ?>
</style>

<link rel="stylesheet" href="<?=base_url('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css')?>">

<link rel="stylesheet" href="<?=base_url('assets/modules/bootstrap-lightbox/lightbox.css')?>">

<link rel="stylesheet" href="<?=base_url('assets/css/style.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/css/components.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/css/custom.css')?>">

<link rel="stylesheet" href="<?=base_url('assets/css/cards/custom.css')?>">

<?php if($google_analytics){ ?>
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?=htmlspecialchars($google_analytics)?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?=htmlspecialchars($google_analytics)?>');
  </script>
<?php } ?>
        