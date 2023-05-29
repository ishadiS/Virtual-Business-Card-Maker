<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?=(isset($page_title) && !empty($page_title))?htmlspecialchars($page_title):'Home'?></title>
  <link href="<?=base_url('assets/uploads/logos/'.htmlspecialchars(favicon()))?>" rel="icon" type="image/png">
  <link rel="stylesheet" href="<?=base_url('assets/modules/fontawesome/css/all.min.css')?>">
  <style>
      :root{--theme-color: <?=theme_color()?>;}
  </style>
  <link type="text/css" href="<?=base_url('assets/front-two/css/custom.css')?>" rel="stylesheet">
</head>

<body>
  <?php $my_lang = $this->session->userdata('lang')?$this->session->userdata('lang'):default_language(); ?>

  <header class="header-global">
    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light">
      <div class="container">
        <a class="navbar-brand mr-lg-5" href="<?=base_url()?>">
          <img src="<?=base_url('assets/uploads/logos/'.htmlspecialchars(full_logo()))?>">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbar_global">
          <div class="navbar-collapse-header">
            <div class="row">
              <div class="col-6 collapse-brand">
                <a href="<?=base_url()?>">
                  <img src="<?=base_url('assets/uploads/logos/'.htmlspecialchars(full_logo()))?>">
                </a>
              </div>
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>

          <ul class="navbar-nav navbar-nav-hover align-items-lg-center">

            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="scroll" href="#HOWITWORKS"><?=$this->lang->line('how_it_works')?htmlspecialchars($this->lang->line('how_it_works')):'How it works?'?></a>
            </li>

            <?php if(frontend_permissions('subscription_plans')){ ?>
              <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="scroll" href="#PLANS"><?=$this->lang->line('subscription_plans')?htmlspecialchars($this->lang->line('subscription_plans')):'Plans'?></a>
              </li>
            <?php } ?>

						<?php if(frontend_permissions('features') && $features){ ?>
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="scroll" href="#FEATURES"><?=$this->lang->line('features')?htmlspecialchars($this->lang->line('features')):'Features'?></a>
            </li>
            <?php } ?>

            <?php if(frontend_permissions('contact')){ ?>
              <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="scroll" href="#CONTACT"><?=$this->lang->line('contact')?htmlspecialchars($this->lang->line('contact')):'Contact'?></a>
              </li>
            <?php } ?>

          </ul>

          <ul class="navbar-nav align-items-lg-center ml-lg-auto">
            <li class="nav-item ml-lg-4">
              <a href="<?=base_url('auth')?>" target="_blank" class="btn btn-white">
                <span class="nav-link-inner"><?=$this->lang->line('login')?htmlspecialchars($this->lang->line('login')):'Login'?></span>
              </a>
              <a href="<?=base_url('auth/register')?>" target="_blank" class="btn btn-primary">
                <span class="nav-link-inner"><?=$this->lang->line('get_start')?htmlspecialchars($this->lang->line('get_start')):'Get Start'?></span>
              </a>
            </li>
          </ul>


        </div>
      </div>
    </nav>
  </header>
  <main>

    <?php if(frontend_permissions('home') && $home){  
			if($home->{$my_lang}->title || $home->{$my_lang}->description){
		?>
    <div class="position-relative">
      <!-- shape Hero -->
      <section class="section-shaped my-0" id="HOME">
        <div class="shape shape-style-1 shape-default shape-skew">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div class="container shape-container d-flex">
          <div class="col px-0">
            <div class="row">
              <div class="col-lg-6">
                <h1 class="display-3 text-white"><?=isset($home->{$my_lang}->title)?htmlspecialchars($home->{$my_lang}->title):''?></h1>
                <p class="lead  text-white"><?=isset($home->{$my_lang}->description)?htmlspecialchars($home->{$my_lang}->description):''?></p>
                <div class="btn-wrapper">
                  <a href="#DEMO" class="btn btn-primary btn-icon mb-3 mb-sm-0" data-toggle="scroll">
                    <span class="btn-inner--icon"><i class="fa fa-eye"></i></span>
                    <span class="btn-inner--text"><?=$this->lang->line('try_demo')?htmlspecialchars($this->lang->line('try_demo')):'Try Demo'?></span>
                  </a>
                  <a href="<?=base_url('auth/register')?>" class="btn btn-primary btn-icon mb-3 mb-sm-0" >
                    <?=$this->lang->line('create_my_vcard')?htmlspecialchars($this->lang->line('create_my_vcard')):'Create My vCard'?>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- 1st Hero Variation -->
    </div>
    <?php } } ?>
    
    <section class="section pt-lg-0 <?=(frontend_permissions('home') && ($home->{$my_lang}->title || $home->{$my_lang}->description))?'mt--200 mt-minus-300':'mt-5'?>" id="DEMO">
      <div class="container <?=(frontend_permissions('home') && ($home->{$my_lang}->title || $home->{$my_lang}->description))?'':'pt-5'?>">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="row row-grid">

                <div class="col-md-3 mb-2">
                  <div class="card shadow border-0">
                    <div class="card-body text-center p-1">
                    <img src="<?=base_url('assets/uploads/themes/one.png')?>" class="img-fluid img-themes row mx-auto d-block" alt="<?=$this->lang->line('theme_one')?htmlspecialchars($this->lang->line('theme_one')):'Theme One'?>">
                    <a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_one'):base_url()?>" target="_blank" class="btn btn-sm btn-outline-primary mt-1 row"><?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?> <?=$this->lang->line('theme_one')?htmlspecialchars($this->lang->line('theme_one')):'Theme One'?></a>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-2">
                  <div class="card shadow border-0">
                    <div class="card-body text-center p-1">
                    <img src="<?=base_url('assets/uploads/themes/two.png')?>" class="img-fluid img-themes row mx-auto d-block" alt="<?=$this->lang->line('theme_two')?htmlspecialchars($this->lang->line('theme_two')):'Theme Two'?>">
                    <a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_two'):base_url()?>" target="_blank" class="btn btn-sm btn-outline-primary mt-1 row"><?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?> <?=$this->lang->line('theme_two')?htmlspecialchars($this->lang->line('theme_two')):'Theme Two'?></a>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-2">
                  <div class="card shadow border-0">
                    <div class="card-body text-center p-1">
                    <img src="<?=base_url('assets/uploads/themes/three.png')?>" class="img-fluid img-themes row mx-auto d-block" alt="<?=$this->lang->line('theme_three')?htmlspecialchars($this->lang->line('theme_three')):'Theme Three'?>">
                    <a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_three'):base_url()?>" target="_blank" class="btn btn-sm btn-outline-primary mt-1 row"><?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?> <?=$this->lang->line('theme_three')?htmlspecialchars($this->lang->line('theme_three')):'Theme Three'?></a>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-2">
                  <div class="card shadow border-0">
                    <div class="card-body text-center p-1">
                    <img src="<?=base_url('assets/uploads/themes/four.png')?>" class="img-fluid img-themes row mx-auto d-block" alt="<?=$this->lang->line('theme_four')?htmlspecialchars($this->lang->line('theme_four')):'Theme Four'?>">
                    <a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_four'):base_url()?>" target="_blank" class="btn btn-sm btn-outline-primary mt-1 row"><?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?> <?=$this->lang->line('theme_four')?htmlspecialchars($this->lang->line('theme_four')):'Theme Four'?></a>
                    </div>
                  </div>
                </div>

            </div>
          </div>
        </div>
      </div>
    </section>



    <section class="section section-lg bg-secondary" id="HOWITWORKS">
      <div class="container">
        <div class="row row-grid align-items-center">
          <div class="col-md-6 order-md-2">
            <img src="<?=base_url('assets/img/how-it-work.png')?>" class="img-fluid floating">
          </div>
          <div class="col-md-6 order-md-1">
            <div class="pr-md-5">
              <div class="icon icon-lg icon-shape icon-shape-success shadow rounded-circle mb-5">
                <i class="fa fa-question"></i>
              </div>
              <h3><?=$this->lang->line('how_it_works')?htmlspecialchars($this->lang->line('how_it_works')):'How it works?'?></h3>
              <p><?=$this->lang->line('anyone_can_create_their_digital_card_just_by_following_these_simple_steps')?htmlspecialchars($this->lang->line('anyone_can_create_their_digital_card_just_by_following_these_simple_steps')):'Anyone can create their Digital card just by following these simple steps.'?></p>
              <ul class="list-unstyled mt-5">
                <li class="py-2">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="badge badge-circle badge-success mr-3">
                        <i class="fa fa-check"></i>
                      </div>
                    </div>
                    <div>
                      <h6 class="mb-0"><strong><?=$this->lang->line('one_register')?htmlspecialchars($this->lang->line('one_register')):'1. Register'?></strong></h6>
                    </div>
                  </div>
                </li>
                <li class="py-2">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="badge badge-circle badge-success mr-3">
                        <i class="fa fa-check"></i>
                      </div>
                    </div>
                    <div>
                      <h6 class="mb-0"><strong><?=$this->lang->line('two_create_your_vcard')?htmlspecialchars($this->lang->line('two_create_your_vcard')):'2. Create your vCard'?></strong></h6>
                    </div>
                  </div>
                </li>
                <li class="py-2">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="badge badge-circle badge-success mr-3">
                        <i class="fa fa-check"></i>
                      </div>
                    </div>
                    <div>
                      <h6 class="mb-0"><strong><?=$this->lang->line('three_get_your_vcard_vcard_link_and_qr_code')?htmlspecialchars($this->lang->line('three_get_your_vcard_vcard_link_and_qr_code')):'3. Get your vCard, vCard link, and QR code'?></strong></h6>
                    </div>
                  </div>
                </li>
                <li class="py-2">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="badge badge-circle badge-success mr-3">
                        <i class="fa fa-check"></i>
                      </div>
                    </div>
                    <div>
                      <h6 class="mb-0"><strong><?=$this->lang->line('four_share_your_vcard_with_everyone')?htmlspecialchars($this->lang->line('four_share_your_vcard_with_everyone')):'4. Share your vCard with everyone'?></strong></h6>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php if(frontend_permissions('subscription_plans')){ ?>
    <section class="section section-lg" id="PLANS">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 text-center mb-4">
            <h2 class="display-3"><?=$this->lang->line('subscription_plans')?$this->lang->line('subscription_plans'):'Plans'?></h2>
          </div>
          <div class="col-lg-12">
            <div class="row row-grid">
              <?php foreach($plans as $plan){ ?>
                <div class="col-lg-4 mb-2">
                  <div class="card shadow border-0">
                    <div class="card-body text-center">
                      <h4 class="text-success text-uppercase mb-0"><?=htmlspecialchars($plan['title'])?></h4>
                      <p class="description"><span class="font-weight-bold"><?=htmlspecialchars(get_saas_currency('currency_symbol'))?><?=htmlspecialchars($plan['price'])?></span> / <?php
                        if($plan['billing_type'] == 'One Time'){
                          $billing_type = $this->lang->line('one_time')?htmlspecialchars($this->lang->line('one_time')):'One Time';
                        }elseif($plan['billing_type'] == 'Monthly'){
                          $billing_type = $this->lang->line('monthly')?htmlspecialchars($this->lang->line('monthly')):'Monthly';
                        }else{
                          $billing_type = $this->lang->line('yearly')?htmlspecialchars($this->lang->line('yearly')):'Yearly';
                        }
                        echo htmlspecialchars($billing_type);
                        ?>
                      </p>
                      <hr class="m-0 mb-3">
                      <div>
                        <?php
                          if($plan["modules"] != ''){
                            foreach(json_decode($plan["modules"]) as $mod_key => $mod){
                              $mod_name = '';
                              if($mod_key == 'multiple_themes'){
                              $mod_name = $this->lang->line('multiple_themes')?htmlspecialchars($this->lang->line('multiple_themes')):'Multiple Themes';
                              }elseif($mod_key == 'custom_fields'){
                              $mod_name = $this->lang->line('custom_fields')?htmlspecialchars($this->lang->line('custom_fields')):'Custom Fields';
                              }elseif($mod_key == 'products_services'){
                              $mod_name = $this->lang->line('products_services')?htmlspecialchars($this->lang->line('products_services')):'Products/Services';
                              }elseif($mod_key == 'portfolio'){
                              $mod_name = $this->lang->line('portfolio')?htmlspecialchars($this->lang->line('portfolio')):'Portfolio';
                              }elseif($mod_key == 'testimonials'){
                              $mod_name = $this->lang->line('testimonials')?htmlspecialchars($this->lang->line('testimonials')):'Testimonials';
                              }elseif($mod_key == 'qr_code'){
                              $mod_name = $this->lang->line('qr_code')?htmlspecialchars($this->lang->line('qr_code')):'QR Code';
                              }elseif($mod_key == 'hide_branding'){
                              $mod_name = $this->lang->line('hide_branding')?htmlspecialchars($this->lang->line('hide_branding')):'Hide Branding';
                              }
                              
                              if($mod_name && $mod == 1){
                                echo '<span class="badge badge-pill badge-success mb-2"><i class="fa fa-check text-success"></i> '.htmlspecialchars($mod_name).'</span><br>';
                              }elseif($mod_name){
                                echo '<span class="badge badge-pill badge-warning mb-2"><i class="fa fa-times text-danger"></i> '.htmlspecialchars($mod_name).'</span><br>';
                              }
                            }
                          }
                        ?>
                      </div>

                      <hr class="m-3">

                      <a href="<?=base_url('auth/register')?>" class="btn btn-primary text-uppercase"><?=$this->lang->line('get_start')?$this->lang->line('get_start'):'Get Start'?></a>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php } ?>

    <?php if(frontend_permissions('features') && $features){  ?>
    <section class="section section-shaped my-0 overflow-hidden" id="FEATURES">
      <div class="shape shape-style-3 bg-gradient-default shape-skew">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="container pb-300">
        <div class="row text-center justify-content-center">
          <div class="col-lg-10">
            <h2 class="display-3 text-white"><?=$this->lang->line('features')?$this->lang->line('features'):'Features'?></h2>
          </div>
        </div>
        <div class="row row-grid mt-5">
          <?php if($features){ foreach($features as $feature){ ?>
            <div class="col-lg-4">
              <div class="icon icon-lg icon-shape bg-gradient-white shadow rounded-circle text-primary">
                <i class="<?=isset($feature['icon'])?htmlspecialchars($feature['icon']):'fa fa-fire'?> text-primary"></i>
              </div>
              <h5 class="text-white mt-3"><?=isset($feature['title'])?htmlspecialchars($feature['title']):''?></h5>
              <p class="text-white mt-3"><?=isset($feature['description'])?htmlspecialchars($feature['description']):''?></p>
            </div>
          <?php } } ?>
        </div>
      </div>
    </section>
    <?php } ?>

    <?php if(frontend_permissions('contact')){ ?>
    <section class="section section-lg pt-lg-0 section-contact-us pb-0 mt-5" id="CONTACT">
      <div class="container">
        <div class="row justify-content-center mt--300">
          <div class="col-lg-8">
            <div class="card bg-gradient-secondary shadow">
              <div class="card-body p-lg-5">
                <h4 class="mb-1"><?=$this->lang->line('contact')?htmlspecialchars($this->lang->line('contact')):'Contact'?></h4>
                <form id="front_contact_form" method="POST" action="<?=base_url('front/send-mail')?>">
                  <div class="form-group mt-5">
                    <div class="input-group input-group-alternative">
                      <input class="form-control" placeholder="<?=$this->lang->line('name')?htmlspecialchars($this->lang->line('name')):'Name'?>" type="text" name="name" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <input class="form-control" placeholder="<?=$this->lang->line('email')?htmlspecialchars($this->lang->line('email')):'Email'?>" type="email" name="email" required>
                    </div>
                  </div>
                  <div class="form-group mb-4">
                    <textarea class="form-control form-control-alternative" name="msg" rows="4" cols="80" placeholder="<?=$this->lang->line('type_your_message')?htmlspecialchars($this->lang->line('type_your_message')):'Type your message'?>" required></textarea>
                  </div>
                  <div>
                    <button type="submit" class="btn btn-primary btn-round btn-block btn-lg savebtn"><?=$this->lang->line('send_message')?htmlspecialchars($this->lang->line('send_message')):'Send Message'?></button>
                  </div>
                  <div class="result mt-1">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php } ?>
  </main>
  <footer class="footer has-cards pb-4">
    <div class="container">
      <hr>
      <div class="row align-items-center justify-content-md-between">
        <div class="col-md-6">
          <div class="copyright">
            <a href="<?=base_url()?>" target="_blank"><?=htmlspecialchars(footer_text())?></a>
          </div>
        </div>
        <div class="col-md-6">
          <ul class="nav nav-footer justify-content-end">
            <?php if(frontend_permissions('about')){ ?>
              <li class="nav-item">
                <a href="<?=base_url('front/about-us')?>" class="nav-link"><?=$this->lang->line('about')?htmlspecialchars($this->lang->line('about')):'About Us'?></a>
              </li>
						<?php } ?>
						<?php if(frontend_permissions('privacy')){ ?>
              <li class="nav-item">
                <a href="<?=base_url('front/privacy-policy')?>" class="nav-link"><?=$this->lang->line('privacy_policy')?htmlspecialchars($this->lang->line('privacy_policy')):'Privacy Policy'?></a>
              </li>
						<?php } ?>
						<?php if(frontend_permissions('terms')){ ?>
              <li class="nav-item">
                <a href="<?=base_url('front/terms-and-conditions')?>" class="nav-link"><?=$this->lang->line('terms_and_conditions')?htmlspecialchars($this->lang->line('terms_and_conditions')):'Terms and Conditions'?></a>
              </li>
						<?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <script src="<?=base_url('assets/modules/jquery.min.js')?>"></script>
  <script src="<?=base_url('assets/modules/popper.js')?>"></script>
  <script src="<?=base_url('assets/modules/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?=base_url('assets/front-two/js/custom.js')?>"></script>
</body>

</html>