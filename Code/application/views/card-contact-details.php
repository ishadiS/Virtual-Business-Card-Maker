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
            <?=$this->lang->line('contact_details')?htmlspecialchars($this->lang->line('contact_details')):'Contact Details'?>
            </h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>"><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></a></div>
              <div class="breadcrumb-item"><?=$this->lang->line('contact_details')?htmlspecialchars($this->lang->line('contact_details')):'Contact Details'?></div>
            </div>
          </div>

          <div class="section-body">
            <?php if($card){  if(!$this->ion_auth->in_group(3)){ ?> 
              <div class="row">
                <div class="col-md-12 form-group">
                  <select class="form-control select2 filter_change">
                    <?php foreach($my_all_cards as $my_all_card){ ?>
                    <option value="<?=base_url('cards/details/'.$my_all_card['id'])?>" <?=($card['id'] == $my_all_card['id'])?"selected":""?>><?=htmlspecialchars($my_all_card['title'])?> - <?=htmlspecialchars($my_all_card['sub_title'])?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } ?> 

              <form action="<?=base_url('cards/save')?>" method="POST" id="save_card" enctype="multipart/form-data">
                <input type="hidden" name="changes_type" value="details">
                <input type="hidden" name="card_id" value="<?=$card['id']?>">

                <div class="card card-primary" id="save_card_card">
                  <div class="card-body">
                    <?php
                      $social_options = (isset($card['social_options']) && $card['social_options'] != '')?json_decode($card['social_options'],true):'';
                    ?>
                    <div class="row">

                      <div class="form-group col-md-6">
                        <label><?=$this->lang->line('mobile')?htmlspecialchars($this->lang->line('mobile')):'Mobile'?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=$this->lang->line('country_code_with_sing')?htmlspecialchars($this->lang->line('country_code_with_sing')):"Country code with (+) sing."?>"></i></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                            </div>
                          </div>
                          <input type="text" name="mobile" value="<?=isset($social_options['mandatory']) && isset($social_options['mandatory']['mobile'])?htmlspecialchars($social_options['mandatory']['mobile']):''?>" placeholder="+1234567890" class="form-control" >
                        </div>
                      </div>
                      
                      <div class="form-group col-md-6">
                        <label><?=$this->lang->line('email')?htmlspecialchars($this->lang->line('email')):'Email'?></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                            <i class="fas fa-envelope"></i>
                            </div>
                          </div>
                          <input type="text" name="email" value="<?=isset($social_options['mandatory']) && isset($social_options['mandatory']['email'])?htmlspecialchars($social_options['mandatory']['email']):''?>" placeholder="xyzabc@domain.com" class="form-control" >
                        </div>
                      </div>
                      
                      <div class="form-group col-md-6">
                        <label><?=$this->lang->line('whatsapp')?htmlspecialchars($this->lang->line('whatsapp')):'WhatsApp'?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=$this->lang->line('country_code_without_sing')?htmlspecialchars($this->lang->line('country_code_without_sing')):"Country code without (+) sing."?>"></i></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                            <i class="fab fa-whatsapp"></i>
                            </div>
                          </div>
                          <input type="text" name="whatsapp" value="<?=isset($social_options['mandatory']) && isset($social_options['mandatory']['whatsapp'])?htmlspecialchars($social_options['mandatory']['whatsapp']):''?>" placeholder="1234567890" class="form-control" >
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label><?=$this->lang->line('website')?htmlspecialchars($this->lang->line('website')):'Website'?></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                            <i class="fas fa-globe"></i>
                            </div>
                          </div>
                          <input type="text" name="website" value="<?=isset($social_options['mandatory']) && isset($social_options['mandatory']['website'])?htmlspecialchars($social_options['mandatory']['website']):''?>" placeholder="https://www.facebook.com/" class="form-control" >
                        </div>
                      </div>
                      
                      <div class="form-group col-md-6">
                        <label><?=$this->lang->line('address')?htmlspecialchars($this->lang->line('address')):'Address'?></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                            <i class="fas fa-map-marker"></i>
                            </div>
                          </div>
                          <input type="text" name="address" value="<?=isset($social_options['mandatory']) && isset($social_options['mandatory']['address'])?htmlspecialchars($social_options['mandatory']['address']):''?>" placeholder="Silicon Valley, USA" class="form-control" >
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label><?=$this->lang->line('address')?htmlspecialchars($this->lang->line('address')):'Address'?> <?=$this->lang->line('url')?$this->lang->line('url'):'URL'?></label>
                        <input type="text" name="address_url" value="<?=isset($social_options['mandatory']) && isset($social_options['mandatory']['address_url'])?htmlspecialchars($social_options['mandatory']['address_url']):''?>" placeholder="https://www.google.com/maps/search/?api=1&query=usa" class="form-control">
                      </div>
                      

                      <span class="col-md-12 <?=is_module_allowed('custom_fields')?'':'d-none'?>">
                        <div class="section-title"><?=$this->lang->line('custom_field')?htmlspecialchars($this->lang->line('custom_field')):'Custom Field'?></div>
                          <?php
                          if(isset($social_options['optional']) && $social_options['optional'] != ''){ ?>
                            <span class="row input_fields_wrap">
                              <?php
                                foreach($social_options['optional']['icon'] as $key_icon => $icon){ ?>
                                  <?php
                                    if($key_icon == 0){ ?>
                                  <?php }else{ ?>
                                      <span class="col-md-12 remove_field_wrap"><span class="row">
                                  <?php } ?>

                                  <div class="form-group col-md-3">
                                    <?php if($key_icon == 0){ ?>
                                    <label><?=$this->lang->line('icon')?htmlspecialchars($this->lang->line('icon')):'Icon'?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=$this->lang->line('use_fontawesome_icons_from_fontawesome')?htmlspecialchars($this->lang->line('use_fontawesome_icons_from_fontawesome')):"Use fontawesome icons from fontawesome.com"?>"></i></label>
                                    <?php } ?>
                                    <input type="text" name="icon[]" value="<?=htmlspecialchars($icon)?>" placeholder="fab fa-facebook" class="form-control">
                                  </div>
                                  
                                  <?php
                                    foreach($social_options['optional']['text'] as $key_text => $text){ if($key_icon == $key_text){ ?>
                                      <div class="form-group col-md-4">
                                        <?php if($key_icon == 0){ ?>
                                        <label><?=$this->lang->line('text')?htmlspecialchars($this->lang->line('text')):'Text'?></label>
                                        <?php } ?>
                                        <input type="text" name="text[]" value="<?=htmlspecialchars($text)?>" placeholder="Facebook" class="form-control">
                                      </div>
                                      
                                      <?php
                                        foreach($social_options['optional']['url'] as $key_url => $url){  if($key_icon == $key_url){ ?>
                                          <div class="form-group col-md-4">
                                            <?php if($key_icon == 0){ ?>
                                            <label><?=$this->lang->line('url')?htmlspecialchars($this->lang->line('url')):'URL'?></label>
                                            <?php } ?>
                                            <input type="text" name="url[]" value="<?=htmlspecialchars($url)?>" placeholder="https://www.facebook.com/" class="form-control">
                                          </div>
                                      <?php } } ?>
                                  <?php } } ?>
                                <?php if($key_icon == 0){ ?>
                                  <div class="form-group col-md-1 mx-auto my-auto">
                                    <a href="#" class="btn btn-icon btn-success add_field_button"><i class="fas fa-plus"></i></a>
                                  </div>
                              <?php }else{ ?>
                                <div class="form-group col-md-1">
                                  <a href="#" class="btn btn-icon btn-danger remove_field"><i class="fas fa-times"></i></a>
                                </div>
                                </span>
                                </span>
                              <?php } } ?>
                            </span>
                          <?php }else{ ?>
                            <span class="row input_fields_wrap">
                              <div class="form-group col-md-3">
                                <label><?=$this->lang->line('icon')?htmlspecialchars($this->lang->line('icon')):'Icon'?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=$this->lang->line('use_fontawesome_icons_from_fontawesome')?htmlspecialchars($this->lang->line('use_fontawesome_icons_from_fontawesome')):"Use fontawesome icons from fontawesome.com"?>"></i></label>
                                <input type="text" name="icon[]" value="" placeholder="fab fa-facebook" class="form-control">
                              </div>
                              <div class="form-group col-md-4">
                                <label><?=$this->lang->line('text')?htmlspecialchars($this->lang->line('text')):'Text'?></label>
                                <input type="text" name="text[]" value="" placeholder="Facebook" class="form-control">
                              </div>
                              <div class="form-group col-md-4">
                                <label><?=$this->lang->line('url')?htmlspecialchars($this->lang->line('url')):'URL'?></label>
                                <input type="text" name="url[]" value="" placeholder="https://www.facebook.com/" class="form-control">
                              </div>
                              <div class="form-group col-md-1 mx-auto my-auto">
                                <a href="#" class="btn btn-icon btn-success add_field_button"><i class="fas fa-plus"></i></a>
                              </div>
                            </span>
                          <?php } ?>
                        </span>

                    </div>


                  </div>
                  <div class="card-footer bg-whitesmoke text-md-right">
                    <?php if(isset($card['slug']) && $card['slug'] != ''){ ?>
                      <a href="<?=base_url($card['slug'])?>" class="btn btn-icon icon-left btn-success copy_href"><i class="fas fa-copy"></i> <?=$this->lang->line('copy')?htmlspecialchars($this->lang->line('copy')):'Copy Card URL'?></a>
                    <?php } ?>
                    <?php if(isset($card['slug']) && $card['slug'] != ''){ ?>
                      <a href="<?=base_url($card['slug'])?>" target="_blank" class="btn btn-icon icon-left btn-danger"><i class="fas fa-eye"></i> <?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?></a>
                    <?php } ?>

                    <button class="btn btn-primary savebtn"><?=$this->lang->line('save_changes')?$this->lang->line('save_changes'):'Save Changes'?></button>
                  </div>
                  <div class="result"></div>
                </div>
              </form>

              <?php }else{ ?> 
                <div class="row">
                  <div class="col-12 col-md-12 col-sm-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="empty-state" data-height="400" style="height: 400px;">
                          <h2><?=$this->lang->line('no_card_found')?$this->lang->line('no_card_found'):'No card found'?></h2>
                          <p class="lead">
                          <?=$this->lang->line('create_a_card_and_come_back_here')?$this->lang->line('create_a_card_and_come_back_here'):'Create a card and come back here.'?>
                          </p>
                          <a href="<?=base_url('cards');?>" class="btn btn-primary mt-4"><?=$this->lang->line('create')?htmlspecialchars($this->lang->line('create')):'Create'?></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?> 

          </div>
        </section>
      </div>
    
    <?php $this->load->view('includes/footer'); ?>
    </div>
  </div>


<?php $this->load->view('includes/js'); ?>

<script src="<?=base_url('assets/js/page/card-details.js')?>"></script>

</body>
</html>