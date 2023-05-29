<?php $this->load->view('includes/head'); ?>
</head>
<body>
  <div id="app">
    <div class="main-wrapper">
      <?php $this->load->view('includes/navbar'); ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></h1>
          </div>

          <?php
            $my_plan = get_current_plan();
            if($my_plan && !is_null($my_plan['end_date']) && ($my_plan['expired'] == 0 || $my_plan['end_date'] <= date('Y-m-d',date(strtotime("+".alert_days()." day", strtotime(date('Y-m-d'))))))){ 
          ?>
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="hero text-white bg-danger">
                <div class="hero-inner">
                  <h2><?=$this->lang->line('alert')?$this->lang->line('alert'):'Alert...'?></h2>
                  <?php 
                    if($my_plan['expired'] == 0){ 
                  ?>
                    <p class="lead"><?=$this->lang->line('your_subscription_plan_has_been_expired_on_date')?$this->lang->line('your_subscription_plan_has_been_expired_on_date'):'Your subscription plan has been expired on date'?> <?=htmlspecialchars(format_date($my_plan["end_date"],system_date_format()))?>. <?=$this->lang->line('renew_it_now')?$this->lang->line('renew_it_now'):'Renew it now.'?></p>
                  <?php }elseif($my_plan['end_date'] <= date('Y-m-d',date(strtotime("+".alert_days()." day", strtotime(date('Y-m-d')))))){ ?>
                    <p class="lead"><?=$this->lang->line('your_current_subscription_plan_is_expiring_on_date')?$this->lang->line('your_current_subscription_plan_is_expiring_on_date'):'Your current subscription plan is expiring on date'?> <?=htmlspecialchars(format_date($my_plan["end_date"],system_date_format()))?>.</p>
                  <?php } ?>
                  <div class="mt-4">
                    <a href="<?=base_url('plans')?>" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="fas fa-arrow-right"></i> <?=$this->lang->line('renew_plan')?htmlspecialchars($this->lang->line('renew_plan')):'Renew Plan.'?></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>

          
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4><?=$this->lang->line('current_plan')?htmlspecialchars($this->lang->line('current_plan')):'Current Plan'?></h4>
                  </div>
                  <div class="card-body">
                    <?=htmlspecialchars($my_plan['title'])?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4><?=$this->lang->line('plan_expiry_date')?htmlspecialchars($this->lang->line('plan_expiry_date')):'Plan Expiry Date'?></h4>
                  </div>
                  <div class="card-body">
                    <?php
                    if($my_plan["billing_type"] == 'One Time'){
                      echo $this->lang->line('no_expiry_date')?htmlspecialchars($this->lang->line('no_expiry_date')):'No Expiry Date';
                    }else{
                      echo htmlspecialchars(format_date($my_plan["end_date"],system_date_format()));
                    } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-hand-point-left"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4><?=$this->lang->line('plan_remaining_days')?htmlspecialchars($this->lang->line('plan_remaining_days')):'Remaining Days'?></h4>
                  </div>
                  <div class="card-body">
                    <?php
                    if($my_plan["billing_type"] == 'One Time'){
                      echo $this->lang->line('unlimited')?htmlspecialchars($this->lang->line('unlimited')):'Unlimited';
                    }else{
                      $left_days = count_days_btw_two_dates(date("Y-m-d"),$my_plan['end_date']);
                      echo $left_days['days'];
                    } ?>
                  </div>
                </div>
              </div>
            </div>                  
          </div>

          <div class="row">

            <div class="col-md-6">
              <div class="card card-primary card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4><?=$this->lang->line('my_card')?$this->lang->line('my_card'):'My vCard'?> - <a class="font-weight-600" href="<?=base_url('cards')?>"><?=$this->lang->line('view')?htmlspecialchars($this->lang->line('view')):'View'?></a></h4>
                  </div>
                  <div class="card-body">
                  <?=htmlspecialchars(get_count('id','cards','user_id = '.$card['user_id']))?>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card card-primary card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4><?=$this->lang->line('products_services')?htmlspecialchars($this->lang->line('products_services')):'Products/Services'?> - <a class="font-weight-600" href="<?=base_url('cards/products')?>"><?=$this->lang->line('view')?htmlspecialchars($this->lang->line('view')):'View'?></a></h4>
                  </div>
                  <div class="card-body">
                  <?=htmlspecialchars(get_count('id','products','user_id = '.$card['user_id']))?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card card-primary card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-briefcase"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4><?=$this->lang->line('portfolio')?htmlspecialchars($this->lang->line('portfolio')):'Portfolio'?> - <a class="font-weight-600" href="<?=base_url('cards/portfolio')?>"><?=$this->lang->line('view')?htmlspecialchars($this->lang->line('view')):'View'?></a></h4>
                  </div>
                  <div class="card-body">
                  <?=htmlspecialchars(get_count('id','portfolio','user_id = '.$card['user_id']))?>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="card card-primary card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-people-carry"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4><?=$this->lang->line('testimonials')?htmlspecialchars($this->lang->line('testimonials')):'Testimonials'?> - <a class="font-weight-600" href="<?=base_url('cards/testimonials')?>"><?=$this->lang->line('view')?htmlspecialchars($this->lang->line('view')):'View'?></a></h4>
                    
                  </div>
                  <div class="card-body">
                  <?=htmlspecialchars(get_count('id','testimonials','user_id = '.$card['user_id']))?>
                  </div>
                </div>
              </div>
            </div>

          </div>
          
          
        </section>
      </div>
    
    <?php $this->load->view('includes/footer'); ?>
    </div>
  </div>

<?php $this->load->view('includes/js'); ?>

</body>
</html>
