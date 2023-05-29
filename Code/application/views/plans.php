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
            <div class="section-header-back">
              <a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>
            <?php
              echo $this->lang->line('subscription_plans')?htmlspecialchars($this->lang->line('subscription_plans')):'Plans';
              if($this->ion_auth->in_group(3)){
                echo ' <a href="#" id="modal-add-plan" class="btn btn-sm btn-icon icon-left btn-primary"><i class="fas fa-plus"></i>'.($this->lang->line('create')?$this->lang->line('create'):'Create').'</a>';
              }
            ?>
            </h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>"><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></a></div>
              <div class="breadcrumb-item">
              <?=$this->lang->line('subscription_plans')?$this->lang->line('subscription_plans'):'Plans'?>
              </div>
            </div>
          </div>
          <div class="section-body">
            
            <div class="row align-items-center justify-content-center">

              <?php if($this->ion_auth->in_group(3)){ ?>
                
                  <div class="col-md-12">
                    <div class="card card-primary">
                      <div class="card-body"> 
                        <table class='table-striped' id='plans_list'
                          data-toggle="table"
                          data-url="<?=base_url('plans/get_plans')?>"
                          data-click-to-select="true"
                          data-side-pagination="server"
                          data-pagination="false"
                          data-page-list="[5, 10, 20, 50, 100, 200]"
                          data-search="false" data-show-columns="false"
                          data-show-refresh="false" data-trim-on-search="false"
                          data-sort-name="id" data-sort-order="asc"
                          data-mobile-responsive="true"
                          data-toolbar="" data-show-export="false"
                          data-maintain-selected="true"
                          data-export-types='["txt","excel"]'
                          data-export-options='{
                            "fileName": "plans-list",
                            "ignoreColumn": ["state"] 
                          }'
                          data-query-params="queryParams">
                          <thead>
                            <tr>
                              <th data-field="title" data-sortable="true" data-valign="top"><?=$this->lang->line('title')?$this->lang->line('title'):'Title'?></th>
                              <th data-field="price" data-sortable="true" data-valign="top"><?=$this->lang->line('price_usd')?$this->lang->line('price_usd').' - '.get_saas_currency('currency_code'):'Price - '.get_saas_currency('currency_code')?></th>
                              <th data-field="billing_type" data-sortable="true" data-valign="top"><?=$this->lang->line('billing_type')?$this->lang->line('billing_type'):'Billing Type'?></th>
                              <th data-field="modules" data-sortable="true" data-valign="top"><?=$this->lang->line('features')?$this->lang->line('features'):'Features'?></th>
                              <th data-field="action" data-sortable="false" data-valign="top"><?=$this->lang->line('action')?$this->lang->line('action'):'Action'?></th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  </div>
              <?php }else{ 
                $my_plan= get_current_plan();
                if($this->ion_auth->is_admin()){ 
                  if($my_plan &&  !is_null($my_plan['end_date']) && (($my_plan['expired'] == 0 || $my_plan['end_date'] <= date('Y-m-d',date(strtotime("+".alert_days()." day", strtotime(date('Y-m-d')))))) || ($my_plan['billing_type'] == 'three_days_trial_plan' || $my_plan['billing_type'] == 'seven_days_trial_plan' || $my_plan['billing_type'] == 'fifteen_days_trial_plan' || $my_plan['billing_type'] == 'thirty_days_trial_plan'))){ 
              ?>
                  <div class="col-md-12 mb-4">
                    <div class="hero text-white bg-danger">
                      <div class="hero-inner">
                        <h2><?=$this->lang->line('alert')?$this->lang->line('alert'):'Alert...'?></h2>
                        <?php 
                        $plan_ending_date = '<br>'.($this->lang->line('ending_date')?htmlspecialchars($this->lang->line('ending_date')):'Ending Date').': '.format_date($my_plan["end_date"],system_date_format());
                        if($my_plan['expired'] == 0){ ?>
                          <p class="lead"><?=$this->lang->line('your_subscription_plan_has_been_expired_on_date')?$this->lang->line('your_subscription_plan_has_been_expired_on_date'):'Your subscription plan has been expired on date'?> <?=htmlspecialchars(format_date($my_plan["end_date"],system_date_format()))?> <?=$this->lang->line('renew_it_now')?$this->lang->line('renew_it_now'):'Renew it now.'?></p>
                        <?php }elseif($my_plan["billing_type"] == 'three_days_trial_plan'){
                                echo $this->lang->line('three_days_trial_plan')?htmlspecialchars($this->lang->line('three_days_trial_plan')):'3 days trial plan';
                                echo $plan_ending_date;
                              }elseif($my_plan["billing_type"] == 'seven_days_trial_plan'){
                                echo $this->lang->line('seven_days_trial_plan')?htmlspecialchars($this->lang->line('seven_days_trial_plan')):'7 days trial plan';
                                echo $plan_ending_date;
                              }elseif($my_plan["billing_type"] == 'fifteen_days_trial_plan'){
                                echo $this->lang->line('fifteen_days_trial_plan')?htmlspecialchars($this->lang->line('fifteen_days_trial_plan')):'15 days trial plan';
                                echo $plan_ending_date;
                              }elseif($my_plan["billing_type"] == 'thirty_days_trial_plan'){
                                echo $this->lang->line('thirty_days_trial_plan')?htmlspecialchars($this->lang->line('thirty_days_trial_plan')):'30 days trial plan';
                                echo $plan_ending_date;
                            }elseif($my_plan['end_date'] <= date('Y-m-d',date(strtotime("+".alert_days()." day", strtotime(date('Y-m-d')))))){ ?>
                          <p class="lead"><?=$this->lang->line('your_current_subscription_plan_is_expiring_on_date')?$this->lang->line('your_current_subscription_plan_is_expiring_on_date'):'Your current subscription plan is expiring on date'?> <?=htmlspecialchars(format_date($my_plan["end_date"],system_date_format()))?>.</p>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
              <?php } } 
                foreach($plans as $plan){
                  if($plan['billing_type'] != 'three_days_trial_plan' && $plan['billing_type'] != 'seven_days_trial_plan' && $plan['billing_type'] != 'fifteen_days_trial_plan' && $plan['billing_type'] != 'thirty_days_trial_plan'){
              ?>
                  <div class="col-md-4">
                    <div class="pricing card <?=$my_plan['plan_id'] == $plan['id']?'pricing-highlight':''?>">
                      <div class="pricing-title">
                        <?=htmlspecialchars($plan['title'])?> 

                        <?php if($my_plan['plan_id'] == $plan['id'] && !is_null($my_plan['end_date'])){ ?>
                          <i class="fas fa-question-circle text-success" data-toggle="tooltip" data-placement="right" title="<?=$this->lang->line('this_is_your_current_active_plan_and_expiring_on_date')?$this->lang->line('this_is_your_current_active_plan_and_expiring_on_date'):'This is your current active plan and expiring on date'?> <?=htmlspecialchars(format_date($my_plan["end_date"],system_date_format()))?>."></i>
                        <?php }elseif($my_plan['plan_id'] == $plan['id']){ ?>
                          <i class="fas fa-question-circle text-success" data-toggle="tooltip" data-placement="right" title="<?=$this->lang->line('this_is_your_current_active_plan')?$this->lang->line('this_is_your_current_active_plan'):'This is your current active plan, No Expiry Date.'?>"></i>
                        <?php } ?>

                      </div>
                      <div class="pricing-padding">
                        <div class="pricing-price">
                          <div><?=htmlspecialchars(get_saas_currency('currency_symbol'))?> <?=htmlspecialchars($plan['price'])?></div>
                          <div>
                            <?php
                              if($plan["billing_type"] == 'One Time'){
                                echo $this->lang->line('one_time')?htmlspecialchars($this->lang->line('one_time')):'One Time';
                              }elseif($plan["billing_type"] == 'Monthly'){
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
                                echo $this->lang->line('yearly')?$this->lang->line('yearly'):'Yearly';
                              } 

                              if($plan["cards"] > 0){
                                $cards_count = $plan["cards"];
                              }else{
                                $cards_count = $this->lang->line('unlimited')?htmlspecialchars($this->lang->line('unlimited')):'Unlimited';
                              }

                            ?>
                          </div>
                        </div>
                        <div class="pricing-details">
                          <?php
                            $modules = '';
                            if($plan["modules"] != ''){
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
                                  $modules .= '<div class="pricing-item mb-1">
                                          <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                          <div class="pricing-item-label">'.$mod_name.'</div>
                                        </div>';
                                }elseif($mod_name){
                                  $modules .= '<div class="pricing-item mb-1">
                                          <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                          <div class="pricing-item-label">'.$mod_name.'</div>
                                        </div>';
                                }
                              }
                            }

                            echo '<div class="pricing-item mb-1">
                                          <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                          <div class="pricing-item-label">'.$cards_count.' '.($this->lang->line('vcard')?htmlspecialchars($this->lang->line('vcard')):'vCard').'</div>
                                        </div>'.$modules;
                          ?>


                        </div>
                      </div>
                      <div class="pricing-cta">
                        <a href="#" class="payment-button" data-amount="<?=htmlspecialchars($plan['price'])?>" data-id="<?=htmlspecialchars($plan['id'])?>"><?=$my_plan['plan_id'] == $plan['id']?($this->lang->line('renew_plan')?$this->lang->line('renew_plan'):'Renew Plan.'):($this->lang->line('subscribe')?$this->lang->line('subscribe'):'Upgrade')?> <i class="fas fa-arrow-right"></i></a>
                      </div>
                    </div>
                  </div>
              <?php } } } ?>
            </div>
          </div>
          <div class="row d-none" id="payment-div">
            <div id="paypal-button" class="col-md-8 mx-auto paymet-box"></div>
            
            <?php if(get_stripe_secret_key() && get_stripe_publishable_key()){ ?>
              <button id="stripe-button" class="col-md-8 btn mx-auto paymet-box">
                <img src="<?=base_url('assets/img/stripe.png')?>" width="14%" alt="Stripe">
              </button>
            <?php } ?>
            <?php if(get_razorpay_key_id()){ ?>
              <button id="razorpay-button" class="col-md-8 btn mx-auto paymet-box">
                  <img src="<?=base_url('assets/img/razorpay.png')?>" width="27%" alt="Stripe">
              </button>
            <?php } ?>
            <?php if(get_paystack_public_key()){ ?>
              <button id="paystack-button" class="col-md-8 btn mx-auto paymet-box">
                <img src="<?=base_url('assets/img/paystack.png')?>" width="24%" alt="Paystack">
              </button>
            <?php } ?>
            <?php if(get_offline_bank_transfer()){ ?>
              <button id="offline-button" class="col-md-8 btn btn-danger mx-auto">
              <?=$this->lang->line('offline_bank_transfer')?$this->lang->line('offline_bank_transfer'):'Offline / Bank Transfer'?>
              </button>
            <?php } ?>
          </div>
        </section>
      </div>
      <?php $this->load->view('includes/footer'); ?>
    </div>
  </div>


<form action="<?=base_url('plans/create')?>" method="POST" class="modal-part" id="modal-add-plan-part" data-title="<?=$this->lang->line('create')?$this->lang->line('create'):'Create'?>" data-btn="<?=$this->lang->line('create')?$this->lang->line('create'):'Create'?>">
  <div class="row">
    <div class="form-group col-md-12">
      <label><?=$this->lang->line('title')?$this->lang->line('title'):'Title'?><span class="text-danger">*</span></label>
      <input type="text" name="title" class="form-control" required="">
    </div>
    <div class="form-group col-md-4">
      <label><?=$this->lang->line('price_usd')?$this->lang->line('price_usd').' - '.get_saas_currency('currency_code'):'Price - '.get_saas_currency('currency_code')?><span class="text-danger">*</span></label>
      <input type="number" name="price" class="form-control">
    </div>
    
    <div class="form-group col-md-4">
      <label><?=$this->lang->line('billing_type')?$this->lang->line('billing_type'):'Billing Type'?><span class="text-danger">*</span></label>
      <select name="billing_type" class="form-control select2">
        <option value="Monthly"><?=$this->lang->line('monthly')?$this->lang->line('monthly'):'Monthly'?></option>
        <option value="Yearly"><?=$this->lang->line('yearly')?$this->lang->line('yearly'):'Yearly'?></option>
        <option value="One Time"><?=$this->lang->line('one_time')?$this->lang->line('one_time'):'One Time'?></option>
        <option value="three_days_trial_plan"><?=$this->lang->line('three_days_trial_plan')?htmlspecialchars($this->lang->line('three_days_trial_plan')):'3 days trial plan'?></option>
        <option value="seven_days_trial_plan"><?=$this->lang->line('seven_days_trial_plan')?htmlspecialchars($this->lang->line('seven_days_trial_plan')):'7 days trial plan'?></option>
        <option value="fifteen_days_trial_plan"><?=$this->lang->line('fifteen_days_trial_plan')?htmlspecialchars($this->lang->line('fifteen_days_trial_plan')):'15 days trial plan'?></option>
        <option value="thirty_days_trial_plan"><?=$this->lang->line('thirty_days_trial_plan')?htmlspecialchars($this->lang->line('thirty_days_trial_plan')):'30 days trial plan'?></option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label><?=$this->lang->line('vcards')?htmlspecialchars($this->lang->line('vcards')):'vCards'?><span class="text-danger">*</span> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?=$this->lang->line('set_value_in_minus_to_make_it_unlimited')?$this->lang->line('set_value_in_minus_to_make_it_unlimited'):'Set value in minus (-1) to make it Unlimited.'?>"></i></label>
      <input type="number" name="cards" class="form-control">
    </div>

    <div class="form-group col-md-12">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="select_all" name="select_all" >
        <label class="form-check-label" for="select_all"><?=$this->lang->line('select_all')?$this->lang->line('select_all'):'Select All'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="multiple_themes" name="multiple_themes" >
        <label class="form-check-label" for="multiple_themes"><?=$this->lang->line('multiple_themes')?htmlspecialchars($this->lang->line('multiple_themes')):'Multiple Themes'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="custom_fields" name="custom_fields" >
        <label class="form-check-label" for="custom_fields"><?=$this->lang->line('custom_fields')?htmlspecialchars($this->lang->line('custom_fields')):'Custom Fields'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="products_services" name="products_services" >
        <label class="form-check-label" for="products_services"><?=$this->lang->line('products_services')?htmlspecialchars($this->lang->line('products_services')):'Products/Services'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="portfolio" name="portfolio" >
        <label class="form-check-label" for="portfolio"><?=$this->lang->line('portfolio')?htmlspecialchars($this->lang->line('portfolio')):'Portfolio'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="testimonials" name="testimonials" >
        <label class="form-check-label" for="testimonials"><?=$this->lang->line('testimonials')?htmlspecialchars($this->lang->line('testimonials')):'Testimonials'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="qr_code" name="qr_code" >
        <label class="form-check-label" for="qr_code"><?=$this->lang->line('qr_code')?htmlspecialchars($this->lang->line('qr_code')):'QR Code'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="hide_branding" name="hide_branding" >
        <label class="form-check-label" for="hide_branding"><?=$this->lang->line('hide_branding')?htmlspecialchars($this->lang->line('hide_branding')):'Hide Branding'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="gallery" name="gallery" >
        <label class="form-check-label" for="gallery"><?=$this->lang->line('gallery')?htmlspecialchars($this->lang->line('gallery')):'Gallery'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="enquiry_form" name="enquiry_form" >
        <label class="form-check-label" for="enquiry_form"><?=$this->lang->line('enquiry_form')?htmlspecialchars($this->lang->line('enquiry_form')):'Enquiry Form'?></label>
      </div>
    </div>


  </div>
</form>

<div id="modal-edit-plan"></div>
<form action="<?=base_url('plans/edit')?>" method="POST" class="modal-part" id="modal-edit-plan-part" data-title="<?=$this->lang->line('edit')?$this->lang->line('edit'):'Edit'?>" data-btn="<?=$this->lang->line('update')?$this->lang->line('update'):'Update'?>">
  <div class="row">
    <div class="form-group col-md-12">
      <label><?=$this->lang->line('title')?$this->lang->line('title'):'Title'?><span class="text-danger">*</span></label>
      <input type="hidden" name="update_id" id="update_id">
      <input type="text" name="title" id="title" class="form-control" required="">
    </div>
    <div class="form-group col-md-4">
      <label><?=$this->lang->line('price_usd')?$this->lang->line('price_usd').' - '.get_saas_currency('currency_code'):'Price - '.get_saas_currency('currency_code')?><span class="text-danger">*</span></label>
      <input type="number" name="price" id="price" class="form-control">
    </div>
    
    <div class="form-group col-md-4">
      <label><?=$this->lang->line('billing_type')?$this->lang->line('billing_type'):'Billing Type'?>v<span class="text-danger">*</span></label>
      <select name="billing_type" id="billing_type" class="form-control select2">
        <option value="Monthly"><?=$this->lang->line('monthly')?$this->lang->line('monthly'):'Monthly'?></option>
        <option value="Yearly"><?=$this->lang->line('yearly')?$this->lang->line('yearly'):'Yearly'?></option>
        <option value="One Time"><?=$this->lang->line('one_time')?$this->lang->line('one_time'):'One Time'?></option>
        <option value="three_days_trial_plan"><?=$this->lang->line('three_days_trial_plan')?htmlspecialchars($this->lang->line('three_days_trial_plan')):'3 days trial plan'?></option>
        <option value="seven_days_trial_plan"><?=$this->lang->line('seven_days_trial_plan')?htmlspecialchars($this->lang->line('seven_days_trial_plan')):'7 days trial plan'?></option>
        <option value="fifteen_days_trial_plan"><?=$this->lang->line('fifteen_days_trial_plan')?htmlspecialchars($this->lang->line('fifteen_days_trial_plan')):'15 days trial plan'?></option>
        <option value="thirty_days_trial_plan"><?=$this->lang->line('thirty_days_trial_plan')?htmlspecialchars($this->lang->line('thirty_days_trial_plan')):'30 days trial plan'?></option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label><?=$this->lang->line('vcards')?htmlspecialchars($this->lang->line('vcards')):'vCards'?><span class="text-danger">*</span> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?=$this->lang->line('set_value_in_minus_to_make_it_unlimited')?$this->lang->line('set_value_in_minus_to_make_it_unlimited'):'Set value in minus (-1) to make it Unlimited.'?>"></i></label>
      <input type="number" name="cards" id="cards" class="form-control">
    </div>

    <div class="form-group col-md-12">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="select_all_update" name="select_all" >
        <label class="form-check-label" for="select_all_update"><?=$this->lang->line('select_all')?$this->lang->line('select_all'):'Select All'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="multiple_themes_update" name="multiple_themes" >
        <label class="form-check-label" for="multiple_themes_update"><?=$this->lang->line('multiple_themes')?htmlspecialchars($this->lang->line('multiple_themes')):'Multiple Themes'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="custom_fields_update" name="custom_fields" >
        <label class="form-check-label" for="custom_fields_update"><?=$this->lang->line('custom_fields')?htmlspecialchars($this->lang->line('custom_fields')):'Custom Fields'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="products_services_update" name="products_services" >
        <label class="form-check-label" for="products_services_update"><?=$this->lang->line('products_services')?htmlspecialchars($this->lang->line('products_services')):'Products/Services'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="portfolio_update" name="portfolio" >
        <label class="form-check-label" for="portfolio_update"><?=$this->lang->line('portfolio')?htmlspecialchars($this->lang->line('portfolio')):'Portfolio'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="testimonials_update" name="testimonials" >
        <label class="form-check-label" for="testimonials_update"><?=$this->lang->line('testimonials')?htmlspecialchars($this->lang->line('testimonials')):'Testimonials'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="qr_code_update" name="qr_code" >
        <label class="form-check-label" for="qr_code_update"><?=$this->lang->line('qr_code')?htmlspecialchars($this->lang->line('qr_code')):'QR Code'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="hide_branding_update" name="hide_branding" >
        <label class="form-check-label" for="hide_branding_update"><?=$this->lang->line('hide_branding')?htmlspecialchars($this->lang->line('hide_branding')):'Hide Branding'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="gallery_update" name="gallery" >
        <label class="form-check-label" for="gallery_update"><?=$this->lang->line('gallery')?htmlspecialchars($this->lang->line('gallery')):'Gallery'?></label>
      </div>
    </div>
    <div class="form-group col-md-3">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="enquiry_form_update" name="enquiry_form" >
        <label class="form-check-label" for="enquiry_form_update"><?=$this->lang->line('enquiry_form')?htmlspecialchars($this->lang->line('enquiry_form')):'Enquiry Form'?></label>
      </div>
    </div>

    
  </div>
</form>

<?php $this->load->view('includes/js'); ?>

<script>
paypal_client_id = "<?=get_payment_paypal()?>";
get_stripe_publishable_key = "<?=get_stripe_publishable_key()?>";
razorpay_key_id = "<?=get_razorpay_key_id()?>";
offline_bank_transfer = "<?=get_offline_bank_transfer()?>";
paystack_user_email_id = "<?=$this->session->userdata('email')?>";
paystack_public_key = "<?=get_paystack_public_key()?>";
</script>

<?php if(get_payment_paypal()){ ?>
<script src="https://www.paypal.com/sdk/js?client-id=<?=get_payment_paypal()?>&currency=<?=get_saas_currency('currency_code')?>"></script>
<?php } ?>

<?php if(get_stripe_publishable_key()){ ?>
<script src="https://js.stripe.com/v3/"></script>
<?php } ?>

<?php if(get_paystack_public_key()){ ?>
<script src="https://js.paystack.co/v1/inline.js"></script>
<?php } ?>

<?php if(get_razorpay_key_id()){ ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<?php } ?>

<script src="<?=base_url('assets/js/page/payment.js');?>"></script>

</body>
</html>
