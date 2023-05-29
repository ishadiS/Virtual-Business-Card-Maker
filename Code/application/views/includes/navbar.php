<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <ul class="navbar-nav mr-auto">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
  <ul class="navbar-nav navbar-right">

  <?php 
    if($this->ion_auth->in_group(3)){  
    $notifications = get_notifications();
  ?>
    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg <?=$notifications?'beep':''?>"><i class="far fa-bell"></i></a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">
          <?=$this->lang->line('notifications')?$this->lang->line('notifications'):'Notifications'?>
        </div>
        <div class="dropdown-list-content dropdown-list-icons">
        <?php if($notifications){ 
          foreach($notifications as $notification){
        ?>

          <a href="<?=$notification['notification_url']?>" class="dropdown-item dropdown-item-unread">
            <?php if(isset($notification['profile']) && !empty($notification['profile'])){ 
                  if(file_exists('assets/uploads/profiles/'.$notification['profile'])){
                    $file_upload_path = 'assets/uploads/profiles/'.$notification['profile'];
                  }else{
                    $file_upload_path = 'assets/uploads/f'.$this->session->userdata('saas_id').'/profiles/'.$notification['profile'];
                  }  
            ?>
              <figure class="dropdown-item-icon avatar avatar-m bg-transparent">
                <img src="<?=base_url($file_upload_path)?>" alt="<?=htmlspecialchars($notification['first_name'])?> <?=htmlspecialchars($notification['last_name'])?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=htmlspecialchars($notification['first_name'])?> <?=htmlspecialchars($notification['last_name'])?>">
              </figure>
            <?php }else{ ?>
              <figure class="dropdown-item-icon avatar avatar-m bg-primary text-white" data-initial="<?=mb_substr(htmlspecialchars($notification['first_name']), 0, 1, "utf-8").''.mb_substr(htmlspecialchars($notification['last_name']), 0, 1, "utf-8")?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=htmlspecialchars($notification['first_name'])?> <?=htmlspecialchars($notification['last_name'])?>">
              </figure>
            <?php } ?>
            <div class="dropdown-item-desc  ml-2">
              <?=$notification['notification']?>
              <div class="time text-primary"><?=time_elapsed_string($notification['created'])?></div>
            </div>
          </a>
        <?php } }else{ ?>
          <a class="dropdown-item dropdown-item-unread">
          <div class="dropdown-item-desc  ml-2">
            <?=$this->lang->line('no_new_notifications')?$this->lang->line('no_new_notifications'):'No new notifications.'?>
          </div>
          </a>
        <?php } ?>
        </div>
        <div class="dropdown-footer text-center">
          <a href="<?=base_url('notifications')?>"><?=$this->lang->line('view_all')?$this->lang->line('view_all'):'View All'?> <i class="fas fa-chevron-right"></i></a>
        </div>
      </div>
    </li>
  <?php } ?>
    <li class="dropdown">
      <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
      <i class="fa fa-language"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <?php $languages = get_languages();
          if($languages){
          foreach($languages as $language){  ?>
            <a href="<?=base_url('languages/change/'.$language['language'])?>" class="dropdown-item <?=$language['language'] == $this->session->userdata('lang') || ($language['language'] == default_language() && !$this->session->userdata('lang'))?'active':''?>">
              <?=ucfirst($language['language'])?>
            </a>
        <?php } } ?>
      </div>
    </li>

    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <?php if(isset($current_user->profile) && !empty($current_user->profile)){ 
          if(file_exists('assets/uploads/profiles/'.$current_user->profile)){
            $file_upload_path = 'assets/uploads/profiles/'.$current_user->profile;
          }else{
            $file_upload_path = 'assets/uploads/f'.$this->session->userdata('saas_id').'/profiles/'.$current_user->profile;
          }
        ?>
        <img alt="image" src="<?=base_url($file_upload_path)?>" class="rounded-circle mr-1">
      <?php }else{ ?>
          <figure class="avatar mr-2 avatar-sm bg-danger text-white" data-initial="<?=mb_substr(htmlspecialchars($current_user->first_name), 0, 1, "utf-8").''.mb_substr(htmlspecialchars($current_user->last_name), 0, 1, "utf-8")?>"></figure>
      <?php } ?>
      <div class="d-sm-none d-lg-inline-block"><?=htmlspecialchars($current_user->first_name)?> <?=htmlspecialchars($current_user->last_name)?></div></a>
      <div class="dropdown-menu dropdown-menu-right">
        <?php
          if($this->ion_auth->is_admin()){
            $my_plan = get_current_plan(); ?>
          <div class="dropdown-title">
            <h6 class="text-danger"><?=htmlspecialchars($my_plan['title'])?></h6>
          </div>
        <?php  }
        ?>
        
        <a href="<?=base_url('users/profile')?>" class="dropdown-item has-icon <?=(current_url() == base_url('users/profile'))?'active':''?>">
          <i class="far fa-user"></i> <?=$this->lang->line('profile')?$this->lang->line('profile'):'Profile'?>
        </a>
        
        <div class="dropdown-divider"></div>
        <a href="<?=base_url('auth/logout')?>" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> <?=$this->lang->line('logout')?$this->lang->line('logout'):'Logout'?>
        </a>
      </div>
    </li>
  </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?=base_url()?>"><img class="navbar-logos" alt="Logo" src="<?=base_url('assets/uploads/logos/'.full_logo())?>"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="<?=base_url()?>"><img class="navbar-logos" alt="Logo Half" src="<?=base_url('assets/uploads/logos/'.half_logo())?>"></a>
    </div>
    <ul class="sidebar-menu">
      
      <li <?= (current_url() == base_url('/') || current_url() == base_url('home'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url()?>"><i class="fas fa-home text-primary"></i> <span><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></span></a></li>
       
     
      <?php if ($this->ion_auth->in_group(3)){ ?> 
      <li <?= (current_url() == base_url('cards') && $this->uri->segment(2) == '')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards')?>"><i class="fas fa-address-book text-warning"></i> <span><?=$this->lang->line('vcards')?htmlspecialchars($this->lang->line('vcards')):'vCards'?></span></a></li>

      <li class="dropdown <?=($this->uri->segment(1) == 'cards' && $this->uri->segment(2) != '')?'active':''; ?>">
        <a class="nav-link has-dropdown" href="#"><i class="fas fa-id-card text-success"></i> 
        <span><?=$this->lang->line('demo_card')?htmlspecialchars($this->lang->line('demo_card')):'Demo vCard'?></span></a>
        <ul class="dropdown-menu">

          <li <?=(current_url() == base_url('cards/theme'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/theme')?>"><?=$this->lang->line('theme')?$this->lang->line('theme'):'Theme'?></a></li>

          <li <?=(current_url() == base_url('cards/profile'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/profile')?>"><?=$this->lang->line('profile')?htmlspecialchars($this->lang->line('profile')):'Profile'?></a></li>
          
          <li <?=(current_url() == base_url('cards/details'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/details')?>"><?=$this->lang->line('contact_details')?htmlspecialchars($this->lang->line('contact_details')):'Contact Details'?></a></li>

          <li <?=(current_url() == base_url('cards/products'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/products')?>"><?=$this->lang->line('products_services')?htmlspecialchars($this->lang->line('products_services')):'Products/Services'?></a></li>

          <li <?=(current_url() == base_url('cards/portfolio'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/portfolio')?>"><?=$this->lang->line('portfolio')?htmlspecialchars($this->lang->line('portfolio')):'Portfolio'?></a></li>

          <li <?=($this->uri->segment(2) == 'gallery')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/gallery/'.$this->session->userdata('current_card_id'))?>"><?=$this->lang->line('gallery')?htmlspecialchars($this->lang->line('gallery')):'Gallery'?></a></li>

          <li <?=(current_url() == base_url('cards/testimonials'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/testimonials')?>"><?=$this->lang->line('testimonials')?htmlspecialchars($this->lang->line('testimonials')):'Testimonials'?></a></li>

          <li <?=(current_url() == base_url('cards/qr'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/qr')?>"><?=$this->lang->line('qr_code')?htmlspecialchars($this->lang->line('qr_code')):'QR Code'?></a></li>

        </ul>
      </li>
      <?php } ?> 

      <?php if (!$this->ion_auth->in_group(3)){ ?>  
      <li class="dropdown <?=($this->uri->segment(1) == 'cards')?'active':''; ?>">
        <a class="nav-link has-dropdown" href="#"><i class="fas fa-id-card text-success"></i> 
        <span><?=$this->lang->line('my_card')?$this->lang->line('my_card'):'My vCard'?></span></a>
        <ul class="dropdown-menu">
 
          <li <?=(current_url() == base_url('cards'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards')?>"><?=$this->lang->line('all')?htmlspecialchars($this->lang->line('all')):'All'?> <?=$this->lang->line('vcards')?htmlspecialchars($this->lang->line('vcards')):'vCards'?></a></li>
          
          <li <?=($this->uri->segment(2) == 'theme')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/theme/'.$this->session->userdata('current_card_id'))?>"><?=$this->lang->line('theme')?$this->lang->line('theme'):'Theme'?></a></li>
          
          <li <?=($this->uri->segment(2) == 'profile')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/profile/'.$this->session->userdata('current_card_id'))?>"><?=$this->lang->line('profile')?htmlspecialchars($this->lang->line('profile')):'Profile'?></a></li>

          <li <?=($this->uri->segment(2) == 'details')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/details/'.$this->session->userdata('current_card_id'))?>"><?=$this->lang->line('contact_details')?htmlspecialchars($this->lang->line('contact_details')):'Contact Details'?></a></li>


          <?php if(is_module_allowed('products_services')){ ?>
          <li <?=($this->uri->segment(2) == 'products')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/products/'.$this->session->userdata('current_card_id'))?>"><?=$this->lang->line('products_services')?htmlspecialchars($this->lang->line('products_services')):'Products/Services'?></a></li>
          <?php } ?>

          <?php if(is_module_allowed('portfolio')){ ?>
          <li <?=($this->uri->segment(2) == 'portfolio')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/portfolio/'.$this->session->userdata('current_card_id'))?>"><?=$this->lang->line('portfolio')?htmlspecialchars($this->lang->line('portfolio')):'Portfolio'?></a></li>
          <?php } ?>

          <?php if(is_module_allowed('gallery')){ ?>
          <li <?=($this->uri->segment(2) == 'gallery')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/gallery/'.$this->session->userdata('current_card_id'))?>"><?=$this->lang->line('gallery')?htmlspecialchars($this->lang->line('gallery')):'Gallery'?></a></li>
          <?php } ?>

          <?php if(is_module_allowed('testimonials')){ ?>
          <li <?=($this->uri->segment(2) == 'testimonials')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/testimonials/'.$this->session->userdata('current_card_id'))?>"><?=$this->lang->line('testimonials')?htmlspecialchars($this->lang->line('testimonials')):'Testimonials'?></a></li>
          <?php } ?>

          <?php if(is_module_allowed('qr_code')){ ?>
          <li <?=($this->uri->segment(2) == 'qr')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('cards/qr/'.$this->session->userdata('current_card_id'))?>"><?=$this->lang->line('qr_code')?htmlspecialchars($this->lang->line('qr_code')):'QR Code'?></a></li>
          <?php } ?>

        </ul>
      </li>
      <?php } ?> 

      <?php if ($this->ion_auth->in_group(3)){ ?> 
      <li class="dropdown <?=($this->uri->segment(1) == 'plans' || current_url() == base_url('users/saas'))?'active':''; ?>">
        <a class="nav-link has-dropdown" href="#"><i class="fas fa fa-dollar-sign text-dark"></i> 
        <span><?=$this->lang->line('subscription')?htmlspecialchars($this->lang->line('subscription')):'Subscription'?></span></a>
        <ul class="dropdown-menu">

          <li <?=(current_url() == base_url('plans'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('plans')?>"><?=$this->lang->line('subscription_plans')?$this->lang->line('subscription_plans'):'Plans'?></a></li>

          <li <?=(current_url() == base_url('plans/orders'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('plans/orders')?>"><?=$this->lang->line('orders')?$this->lang->line('orders'):'Orders'?></a></li>

          <li <?=(current_url() == base_url('plans/offline-requests'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('plans/offline-requests')?>"><?=$this->lang->line('offline_requests')?$this->lang->line('offline_requests'):'Offline Requests'?></a></li>

          <li <?=(current_url() == base_url('users/saas'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('users/saas')?>"><?=$this->lang->line('subscribers')?htmlspecialchars($this->lang->line('subscribers')):'Subscribers'?></a></li>

        </ul>
      </li>

      <li class="dropdown <?=($this->uri->segment(1) == 'front')?'active':''; ?>">
        <a class="nav-link has-dropdown" href="#"><i class="fas fa-puzzle-piece text-primary"></i> 
        <span><?=$this->lang->line('frontend')?$this->lang->line('frontend'):'Frontend'?></span></a>
        <ul class="dropdown-menu">

          <li <?=(current_url() == base_url('front/landing'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('front/landing')?>"><?=$this->lang->line('general')?$this->lang->line('general'):'General'?></a></li>

          <li <?=(current_url() == base_url('front/features'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('front/features')?>"><?=$this->lang->line('features')?$this->lang->line('features'):'Features'?></a></li>

          <li <?=(current_url() == base_url('front/about'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('front/about')?>"><?=$this->lang->line('about')?$this->lang->line('about'):'About Us'?></a></li>

          <li <?=(current_url() == base_url('front/saas-privacy-policy'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('front/saas-privacy-policy')?>"><?=$this->lang->line('privacy_policy')?$this->lang->line('privacy_policy'):'Privacy Policy'?></a></li>

          <li <?=(current_url() == base_url('front/saas-terms-and-conditions'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('front/saas-terms-and-conditions')?>"><?=$this->lang->line('terms_and_conditions')?$this->lang->line('terms_and_conditions'):'Terms and Conditions'?></a></li>

        </ul>
      </li>

      <li <?= (current_url() == base_url('users'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('users')?>"><i class="fas fa-user-tie text-info"></i> <span><?=$this->lang->line('saas_admins')?$this->lang->line('saas_admins'):'SaaS Admins'?></span></a></li>
      
      <?php } ?> 

      <?php if($this->ion_auth->in_group(3)){ ?>    
         
        <li class="dropdown <?=($this->uri->segment(1) == 'settings' || $this->uri->segment(1) == 'languages')?'active':''; ?>">
          <a class="nav-link has-dropdown" href="#"><i class="fas fa-cog text-dark"></i> 
          <span><?=$this->lang->line('settings')?$this->lang->line('settings'):'Settings'?></span></a>
          <ul class="dropdown-menu">

            <li <?=(current_url() == base_url('settings'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('settings')?>"><?=$this->lang->line('general')?$this->lang->line('general'):'General'?></a></li>
            
            <li <?=($this->uri->segment(2) == 'payment')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('settings/payment')?>"><?=$this->lang->line('payment_gateway')?$this->lang->line('payment_gateway'):'Payment Gateway'?></a></li>

            <li <?=($this->uri->segment(2) == 'recaptcha')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('settings/recaptcha')?>"><?=$this->lang->line('google_recaptcha')?$this->lang->line('google_recaptcha'):'Google reCAPTCHA'?></a></li> 

            <li <?=($this->uri->segment(2) == 'email')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('settings/email')?>"><?=$this->lang->line('email')?$this->lang->line('email'):'Email'?></a></li>
            
            <li <?=($this->uri->segment(2) == 'email-templates')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('settings/email-templates')?>"><?=$this->lang->line('email_templates')?$this->lang->line('email_templates'):'Email Templates'?></a></li>
            
            <li <?=($this->uri->segment(1) == 'languages')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('languages')?>"><?=$this->lang->line('languages')?$this->lang->line('languages'):'Languages'?></a></li>

            <li <?=($this->uri->segment(2) == 'update')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('settings/update')?>"><?=$this->lang->line('update')?$this->lang->line('update'):'Update'?></a></li>

            <li <?=($this->uri->segment(2) == 'custom-code')?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('settings/custom-code')?>"><?=$this->lang->line('custom_code')?$this->lang->line('custom_code'):'Custom Code'?></a></li>
                       
          </ul>
        </li>

      <?php } ?>

      
      <?php if ($this->ion_auth->is_admin()){ ?> 

        <li <?= (current_url() == base_url('plans'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('plans')?>"><i class="fas fa fa-dollar-sign text-warning"></i> <span><?=$this->lang->line('subscription_plans')?$this->lang->line('subscription_plans'):'Plans'?></span></a></li>
        <li <?= (current_url() == base_url('plans/transactions'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('plans/transactions')?>"><i class="fas fa-receipt text-info"></i> <span><?=$this->lang->line('transactions')?$this->lang->line('transactions'):'Transactions'?></span></a></li>
        <li <?= (current_url() == base_url('users/profile'))?'class="active"':''; ?>><a class="nav-link" href="<?=base_url('users/profile')?>"><i class="fas fa-users-cog"></i> <span><?=$this->lang->line('profile')?$this->lang->line('profile'):'Profile'?> <?=$this->lang->line('settings')?$this->lang->line('settings'):'Settings'?></span></a></li>

      <?php } ?>

    </ul>
  </aside>
</div>