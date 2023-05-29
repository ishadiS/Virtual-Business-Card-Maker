<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=(isset($page_title) && !empty($page_title))?htmlspecialchars($page_title):'Home'?></title>

	<style>
      :root{--theme-color: <?=theme_color()?>;}
  	</style>

    <link rel="shortcut icon" href="<?=base_url('assets/uploads/logos/'.favicon())?>">
    <link rel="stylesheet" href="<?=base_url('assets/front/one/css/animate.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/front/one/css/bootstrap.min.css')?>">
  	<link rel="stylesheet" href="<?=base_url('assets/modules/fontawesome/css/all.min.css')?>">
    
    <link rel="stylesheet" href="<?=base_url('assets/front/one/css/custom.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/front/comman.css')?>">
	<?php $google_analytics = google_analytics(); if($google_analytics){ ?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?=htmlspecialchars($google_analytics)?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?=htmlspecialchars($google_analytics)?>');
	</script>
	<?php } ?>

	</head>
	<body>
		<!-- start preloader -->
		<div class="preloader">
				<div class="sk-spinner sk-spinner-rotating-plane"></div>
		</div>
		<!-- end preloader -->

		<!-- start navigation -->
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
					</button>
					<a href="<?=base_url()?>" class="navbar-brand">
						<img class="navbar-logo" alt="<?=company_name()?>" src="<?=base_url('assets/uploads/logos/'.full_logo())?>">
					</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right text-uppercase">

						<li><a href="#home" class="home-menu"><?=$this->lang->line('home')?$this->lang->line('home'):'Home'?></a></li>

						<?php if(frontend_permissions('subscription_plans')){ ?>
						<li><a href="#pricing" class="home-menu"><?=$this->lang->line('pricing')?htmlspecialchars($this->lang->line('pricing')):'Pricing'?></a></li>
						<?php } ?>

						<?php if(frontend_permissions('features') && $features){ ?>
						<li><a href="#divider" class="home-menu"><?=$this->lang->line('features')?htmlspecialchars($this->lang->line('features')):'Features'?></a></li>
						<?php } ?>

						<?php if(frontend_permissions('contact')){ ?>
						<li><a href="#contact" class="home-menu"><?=$this->lang->line('contact')?htmlspecialchars($this->lang->line('contact')):'Contact'?></a></li>
						<?php } ?>

						<li><a  href="<?=base_url('auth')?>" class="home-menu" target="_blank"><button type="button" class="text-uppercase btn"><?=$this->lang->line('login')?htmlspecialchars($this->lang->line('login')):'Login'?></button></a></li>

						<li><a  href="<?=base_url('auth/register')?>" class="home-menu" target="_blank"><button type="button" class="text-uppercase btn btn-primary"><?=$this->lang->line('get_start')?htmlspecialchars($this->lang->line('get_start')):'Get Start'?></button></a></li>

						

					</ul>
				</div>
			</div>
		</nav>
		<!-- end navigation -->

		<!-- start home -->
		<section id="home">
			<div class="overlay">
				<div class="container">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10 wow fadeIn" data-wow-delay="0.3s">
							<h1 class="text-upper"><?=$this->lang->line('frontend_home_title')?htmlspecialchars($this->lang->line('frontend_home_title')):'The Smart Digital Business Card. Inspire your clients. Digitally.'?></h1>
							<p class="tm-white"><?=$this->lang->line('frontend_home_description')?htmlspecialchars($this->lang->line('frontend_home_description')):'Create and customize stylish digital business cards and share them with anyone, near or far. Smart, elegant & affordable.'?></p>
							<a href="#demo" class="btn btn-primary  mt-25"><i class="fa fa-eye"></i> <?=$this->lang->line('try_demo')?htmlspecialchars($this->lang->line('try_demo')):'Try Demo'?></a>
							<a href="<?=base_url('auth/register')?>" class="btn btn-primary  mt-25"><?=$this->lang->line('create_my_vcard')?htmlspecialchars($this->lang->line('create_my_vcard')):'Create My vCard'?></a>
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
			</div>
		</section>
    	<!-- end home -->
    
		<section id="demo">
			<div class="container">
				<div class="row">
					<div class="col-md-3 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<img src="<?=base_url('assets/uploads/themes/one.png')?>" class="img-responsive front-theme" alt="<?=$this->lang->line('theme_one')?htmlspecialchars($this->lang->line('theme_one')):'Theme One'?>">
						<a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_one'):base_url()?>" target="_blank" class="btn btn-primary  front-theme-btn"><?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?> <?=$this->lang->line('theme_one')?htmlspecialchars($this->lang->line('theme_one')):'Theme One'?></a>
					</div>
					<div class="col-md-3 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<img src="<?=base_url('assets/uploads/themes/two.png')?>" class="img-responsive front-theme" alt="<?=$this->lang->line('theme_two')?htmlspecialchars($this->lang->line('theme_two')):'Theme Two'?>">
						<a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_two'):base_url()?>" target="_blank" class="btn btn-primary  front-theme-btn"><?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?> <?=$this->lang->line('theme_two')?htmlspecialchars($this->lang->line('theme_two')):'Theme Two'?></a>
					</div>
					<div class="col-md-3 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<img src="<?=base_url('assets/uploads/themes/three.png')?>" class="img-responsive front-theme" alt="<?=$this->lang->line('theme_three')?htmlspecialchars($this->lang->line('theme_three')):'Theme Three'?>">
						<a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_three'):base_url()?>" target="_blank" class="btn btn-primary  front-theme-btn"><?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?> <?=$this->lang->line('theme_three')?htmlspecialchars($this->lang->line('theme_three')):'Theme Three'?></a>
					</div>
					<div class="col-md-3 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<img src="<?=base_url('assets/uploads/themes/four.png')?>" class="img-responsive front-theme" alt="<?=$this->lang->line('theme_four')?htmlspecialchars($this->lang->line('theme_four')):'Theme Four'?>">
						<a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_four'):base_url()?>" target="_blank" class="btn btn-primary  front-theme-btn"><?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?> <?=$this->lang->line('theme_four')?htmlspecialchars($this->lang->line('theme_four')):'Theme Four'?></a>
					</div>
				</div>
			</div>
		</section>

    	<?php if(frontend_permissions('features') && $features){  ?>
		<!-- start divider -->
		<section id="divider">
			<div class="container">
				<div class="row">
          			<div class="col-md-12 wow bounceIn features">
						<h2 class="text-uppercase"><?=$this->lang->line('features')?$this->lang->line('features'):'Features'?></h2>
          			</div>
					<?php foreach($features as $feature){ ?>
					<div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<i class="front-feature-icon <?=isset($feature['icon'])?htmlspecialchars($feature['icon']):'fa fa-fire'?>"></i>
						<h3 class=""><?=htmlspecialchars($feature['title'])?></h3>
						<p><?=htmlspecialchars($feature['description'])?></p>
					</div>
					<?php } ?>
				</div>
			</div>
		</section>
		<!-- end divider -->
    	<?php } ?>

    	<?php if(frontend_permissions('subscription_plans')){ ?>
		<!-- start pricing -->
		<section id="pricing">
			<div class="container">
				<div class="row">
					<div class="col-md-12 wow bounceIn">
						<h2 class="text-uppercase"><?=$this->lang->line('pricing')?htmlspecialchars($this->lang->line('pricing')):'Pricing'?></h2>
          			</div>
          
					<?php foreach($plans as $plan){ ?>
						<div class="col-md-4 wow fadeIn" data-wow-delay="0.6s">
						<div class="pricing text-uppercase">
							<div class="pricing-title">
							<h4><?=htmlspecialchars($plan['title'])?></h4>
							<p><?=get_saas_currency('currency_symbol')?><?=htmlspecialchars($plan['price'])?></p>
							<small class="text-lowercase">
								<?php
                                    if($plan['billing_type'] == 'One Time'){
                                        echo $this->lang->line('one_time')?htmlspecialchars($this->lang->line('one_time')):'One Time';
                                    }elseif($plan['billing_type'] == 'Monthly'){
                                        echo $this->lang->line('monthly')?htmlspecialchars($this->lang->line('monthly')):'Monthly';
                                    }elseif($plan["billing_type"] == 'three_days_trial_plan'){
                                        echo $this->lang->line('three_days_trial_plan')?htmlspecialchars($this->lang->line('three_days_trial_plan')):'3 days trial plan';
                                    }elseif($plan["billing_type"] == 'seven_days_trial_plan'){
                                        echo $this->lang->line('seven_days_trial_plan')?htmlspecialchars($this->lang->line('seven_days_trial_plan')):'7 days trial plan';
                                    }elseif($plan["billing_type"] == 'fifteen_days_trial_plan'){
                                        echo $this->lang->line('fifteen_days_trial_plan')?htmlspecialchars($this->lang->line('fifteen_days_trial_plan')):'15 days trial plan';
                                    }elseif($plan["billing_type"] == 'thirty_days_trial_plan'){
                                        echo $this->lang->line('thirty_days_trial_plan')?htmlspecialchars($this->lang->line('thirty_days_trial_plan')):'30 days trial plan';
                                    }else{
                                        echo $this->lang->line('yearly')?htmlspecialchars($this->lang->line('yearly')):'Yearly';
                                    }

									if($plan["cards"] > 0){
										$cards_count = $plan["cards"];
									}else{
										$cards_count = $this->lang->line('unlimited')?htmlspecialchars($this->lang->line('unlimited')):'Unlimited';
									}
                                ?>
							</small>
							</div>
							<ul>

								<?php
									if($plan["modules"] != ''){
									echo '<li>'.($this->lang->line('features')?htmlspecialchars($this->lang->line('features')):'Features').'</li>';

									echo '<li class="modules"><i class="fas fa-check text-success"></i> '.$cards_count.' '.($this->lang->line('vcard')?htmlspecialchars($this->lang->line('vcard')):'vCard').'</li>';
										
									foreach(json_decode($plan["modules"]) as $mod_key => $mod){
										$mod_name = '';

										if($mod_key == 'multiple_themes'){
										$mod_name = $this->lang->line('multiple_themes')?$this->lang->line('multiple_themes'):'Multiple Themes';
										}elseif($mod_key == 'custom_fields'){
										$mod_name = $this->lang->line('custom_fields')?$this->lang->line('custom_fields'):'Custom Fields';
										}elseif($mod_key == 'products_services'){
										$mod_name = $this->lang->line('products_services')?$this->lang->line('products_services'):'Products/Services';
										}elseif($mod_key == 'portfolio'){
										$mod_name = $this->lang->line('portfolio')?$this->lang->line('portfolio'):'Portfolio';
										}elseif($mod_key == 'testimonials'){
										$mod_name = $this->lang->line('testimonials')?$this->lang->line('testimonials'):'Testimonials';
										}elseif($mod_key == 'qr_code'){
										$mod_name = $this->lang->line('qr_code')?$this->lang->line('qr_code'):'QR Code';
										}elseif($mod_key == 'hide_branding'){
										$mod_name = $this->lang->line('hide_branding')?$this->lang->line('hide_branding'):'Hide Branding';
										}elseif($mod_key == 'gallery'){
											$mod_name = $this->lang->line('gallery')?htmlspecialchars($this->lang->line('gallery')):'Gallery';
										}elseif($mod_key == 'enquiry_form'){
											$mod_name = $this->lang->line('enquiry_form')?htmlspecialchars($this->lang->line('enquiry_form')):'Enquiry Form';
										}

										if($mod_name && $mod == 1){
											echo '<li class="modules"><i class="fas fa-check text-success"></i> '.htmlspecialchars($mod_name).'</li>';
										}elseif($mod_name){
											echo '<li class="modules"><i class="fas fa-times text-danger"></i> '.htmlspecialchars($mod_name).'</li>';
										}
									}
									}
								?>

							</ul>
							<a href="<?=base_url('auth/register')?>" class="btn btn-primary text-uppercase"><?=$this->lang->line('get_start')?$this->lang->line('get_start'):'Get Start'?></a>
						</div>
						</div>
					<?php } ?>
          
				</div>
			</div>
		</section>
		<!-- end pricing -->
    	<?php } ?>

    	<?php if(frontend_permissions('contact')){ ?>
		<!-- start contact -->
		<section id="contact">
			<div class="overlay">
				<div class="container">
					<div class="row">
						<div class="col-md-12 wow fadeInUp card" data-wow-delay="0.6s" id="front_contact_form_card">
              				<h2 class="text-uppercase"><?=$this->lang->line('contact')?htmlspecialchars($this->lang->line('contact')):'Contact'?></h2>
							<div class="contact-form">
								<form action="<?=base_url('front/send-mail')?>" id="front_contact_form" method="POST">
									<div class="col-md-6">
										<input type="text" class="form-control" name="name" placeholder="<?=$this->lang->line('name')?htmlspecialchars($this->lang->line('name')):'Name'?>">
									</div>
									<div class="col-md-6">
										<input type="email" class="form-control" name="email" placeholder="<?=$this->lang->line('email')?htmlspecialchars($this->lang->line('email')):'Email'?>">
									</div>
									<div class="col-md-12">
										<textarea class="form-control" placeholder="<?=$this->lang->line('type_your_message')?htmlspecialchars($this->lang->line('type_your_message')):'Type your message'?>" name="msg" rows="4"></textarea>
									</div>
									<div class="col-md-12 result">
									</div>
									<div class="col-md-4">
										<button type="submit" class="form-control text-uppercase btn btn-primary savebtn">
										<?=$this->lang->line('send_message')?htmlspecialchars($this->lang->line('send_message')):'Send Message'?>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- end contact -->
    	<?php } ?>

		<!-- start footer -->
		<footer>

			<div class="btn-group dropup">
				<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-language"></i>
				</button>
				<div class="dropdown-menu">
					<?php $languages = get_languages();
					if($languages){
					foreach($languages as $language){  ?>
						<a href="<?=base_url('languages/change/'.$language['language'])?>" class="dropdown-item <?=$language['language']==$this->session->userdata('lang') || ($language['language'] == default_language() && !$this->session->userdata('lang'))?'active':''?>">
						<?=ucfirst(htmlspecialchars($language['language']))?>
						</a><br>
					<?php } } ?>
				</div>
			</div>
			

			<div class="container">
				<div class="row">
					<p><a href="<?=base_url()?>" target="_blank"><?=htmlspecialchars(footer_text())?></a></p>
					<p>
						<?php if(frontend_permissions('about')){ ?>
							<a href="<?=base_url('front/about-us')?>"><?=$this->lang->line('about')?htmlspecialchars($this->lang->line('about')):'About Us'?></a>
						<?php } ?>
						<?php if(frontend_permissions('privacy')){ ?>
							 - <a href="<?=base_url('front/privacy-policy')?>"><?=$this->lang->line('privacy_policy')?htmlspecialchars($this->lang->line('privacy_policy')):'Privacy Policy'?></a>
						<?php } ?>
						<?php if(frontend_permissions('terms')){ ?>
							 - <a href="<?=base_url('front/terms-and-conditions')?>"><?=$this->lang->line('terms_and_conditions')?htmlspecialchars($this->lang->line('terms_and_conditions')):'Terms and Conditions'?></a>
						<?php } ?>
					</p>
				</div>
			</div>
		</footer>
		<!-- end footer -->
    
    <script src="<?=base_url('assets/front/one/js/jquery.js')?>"></script>
    <script src="<?=base_url('assets/front/one/js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('assets/front/one/js/wow.min.js')?>"></script>
    <script src="<?=base_url('assets/front/one/js/custom.js')?>"></script>
	<script>
    site_key = '<?php echo get_google_recaptcha_site_key(); ?>';
    </script>

    <?php $recaptcha_site_key = get_google_recaptcha_site_key(); if($recaptcha_site_key){ ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?=htmlspecialchars($recaptcha_site_key)?>"></script>
    <?php } ?>

    
    <div id="cookie-bar">
        <div class="cookie-bar-body">
            <p><?=$this->lang->line('frontend_cookie_message')?htmlspecialchars($this->lang->line('frontend_cookie_message')):'We use cookies to ensure that we give you the best experience on our website.'?></p>
            <div class="cookie-bar-action">
                <button type="button" class="text-uppercase btn btn-primary cookie-bar-btn"><?=$this->lang->line('i_agree')?$this->lang->line('i_agree'):'I Agree!'?></button>
            </div>
        </div>
    </div>

    <script src="<?=base_url('assets/front/comman.js')?>"></script>
	
	</body>
</html>