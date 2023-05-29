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
            <?=$this->lang->line('theme')?$this->lang->line('theme'):'Theme'?> 
            </h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>"><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></a></div>
              <div class="breadcrumb-item"><?=$this->lang->line('theme')?$this->lang->line('theme'):'Theme'?></div>
            </div>
          </div>
          <div class="section-body">  

              <?php if($card){ if(!$this->ion_auth->in_group(3)){ ?> 
                <div class="row">
                  <div class="col-md-12 form-group">
                    <select class="form-control select2 filter_change">
                      <?php foreach($my_all_cards as $my_all_card){ ?>
                      <option value="<?=base_url('cards/theme/'.$my_all_card['id'])?>" <?=($card['id'] == $my_all_card['id'])?"selected":""?>><?=htmlspecialchars($my_all_card['title'])?> - <?=htmlspecialchars($my_all_card['sub_title'])?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              <?php } ?> 

              <form action="<?=base_url('cards/save')?>" method="POST" id="save_card" enctype="multipart/form-data">
                <input type="hidden" name="changes_type" value="theme">
                <input type="hidden" name="card_id" value="<?=$card['id']?>">
                <input type="hidden" name="old_theme_image" value="<?=($card['card_bg_type'] == 'Image' && $card['card_bg'] != '')?htmlspecialchars($card['card_bg']):''?>">
                <div class="card card-primary" id="save_card_card">
                  <div class="card-body">

                    <div class="form-group">
                      <div class="row gutters-sm">
                        <div class="col-12 col-sm-3 text-center <?=(isset($card['theme_name']) && $card['theme_name'] == 'theme_one')?'':(is_module_allowed('multiple_themes')?'':'d-none')?>">
                          <label class="imagecheck">
                            <input name="theme_name" type="radio" value="theme_one" class="imagecheck-input" <?=(isset($card['theme_name']) && ($card['theme_name'] == 'theme_one' || $card['theme_name'] == ''))?'checked':(is_module_allowed('multiple_themes')?'':' disabled')?> />
                            <figure class="imagecheck-figure">
                              <img src="<?=base_url("assets/uploads/themes/one.png")?>" alt="<?=$this->lang->line('theme_one')?htmlspecialchars($this->lang->line('theme_one')):'Theme One'?>" class="imagecheck-image">
                              <?=$this->lang->line('theme_one')?htmlspecialchars($this->lang->line('theme_one')):'Theme One'?>
                            </figure>
                          </label>
                          <a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_one'):base_url()?>" target="_blank" class="btn btn-sm btn-icon icon-left btn-primary mt-1 mb-1"><i class="fas fa-eye"></i> <?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?></a>
                        </div>
                        <div class="col-12 col-sm-3 text-center <?=(isset($card['theme_name']) && $card['theme_name'] == 'theme_two')?'':(is_module_allowed('multiple_themes')?'':'d-none')?>">
                          <label class="imagecheck">
                            <input name="theme_name" type="radio" value="theme_two" class="imagecheck-input" <?=(isset($card['theme_name']) && $card['theme_name'] == 'theme_two')?'checked':(is_module_allowed('multiple_themes')?'':' disabled')?> />
                            <figure class="imagecheck-figure">
                              <img src="<?=base_url("assets/uploads/themes/two.png")?>" alt="<?=$this->lang->line('theme_two')?htmlspecialchars($this->lang->line('theme_two')):'Theme Two'?>" class="imagecheck-image">
                              <?=$this->lang->line('theme_two')?htmlspecialchars($this->lang->line('theme_two')):'Theme Two'?>
                            </figure>
                          </label>
                          <a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_two'):base_url()?>" target="_blank" class="btn btn-sm btn-icon icon-left btn-primary mt-1 mb-1"><i class="fas fa-eye"></i> <?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?></a>
                        </div>
                        <div class="col-12 col-sm-3 text-center <?=(isset($card['theme_name']) && $card['theme_name'] == 'theme_three')?'':(is_module_allowed('multiple_themes')?'':'d-none')?>">
                          <label class="imagecheck">
                            <input name="theme_name" type="radio" value="theme_three" class="imagecheck-input" <?=(isset($card['theme_name']) && $card['theme_name'] == 'theme_three')?'checked':(is_module_allowed('multiple_themes')?'':' disabled')?> />
                            <figure class="imagecheck-figure">
                              <img src="<?=base_url("assets/uploads/themes/three.png")?>" alt="<?=$this->lang->line('theme_three')?htmlspecialchars($this->lang->line('theme_three')):'Theme Three'?>" class="imagecheck-image">
                              <?=$this->lang->line('theme_three')?htmlspecialchars($this->lang->line('theme_three')):'Theme Three'?> 
                            </figure>
                          </label>
                          <a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_three'):base_url()?>" target="_blank" class="btn btn-sm btn-icon icon-left btn-primary mt-1 mb-1"><i class="fas fa-eye"></i> <?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?></a>
                        </div>
                        <div class="col-12 col-sm-3 text-center <?=(isset($card['theme_name']) && $card['theme_name'] == 'theme_four')?'':(is_module_allowed('multiple_themes')?'':'d-none')?>">
                          <label class="imagecheck">
                            <input name="theme_name" type="radio" value="theme_four" class="imagecheck-input" <?=(isset($card['theme_name']) && $card['theme_name'] == 'theme_four')?'checked':(is_module_allowed('multiple_themes')?'':' disabled')?> />
                            <figure class="imagecheck-figure">
                              <img src="<?=base_url("assets/uploads/themes/four.png")?>" alt="<?=$this->lang->line('theme_four')?htmlspecialchars($this->lang->line('theme_four')):'Theme Four'?>" class="imagecheck-image">
                              <?=$this->lang->line('theme_four')?htmlspecialchars($this->lang->line('theme_four')):'Theme Four'?>
                            </figure>
                          </label>
                          <a href="<?=(isset($demo['slug']) && $demo['slug'] != '')?base_url($demo['slug'].'/theme_four'):base_url()?>" target="_blank" class="btn btn-sm btn-icon icon-left btn-primary mt-1 mb-1"><i class="fas fa-eye"></i> <?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?></a>
                        </div>

                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-md-4">
                        <label class="form-label"><?=$this->lang->line('theme_backgoud_type')?htmlspecialchars($this->lang->line('theme_backgoud_type')):'Theme Backgoud Type'?><span class="text-danger">*</span></label>
                        <div class="selectgroup w-100">
                          <label class="selectgroup-item">
                            <input type="radio" name="card_bg_type" value="Color" class="selectgroup-input" <?=(isset($card['card_bg_type']) && ($card['card_bg_type'] == 'Color' || $card['card_bg_type'] == ''))?'checked=""':''?> >
                            <span class="selectgroup-button"><?=$this->lang->line('theme_color')?htmlspecialchars($this->lang->line('theme_color')):'Theme Color'?></span>
                          </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="card_bg_type" value="Image" class="selectgroup-input" <?=(isset($card['card_bg_type']) && $card['card_bg_type'] == 'Image')?'checked=""':''?> >
                            <span class="selectgroup-button"><?=$this->lang->line('theme_image')?htmlspecialchars($this->lang->line('theme_image')):'Theme Image'?></span>
                          </label>
                        </div>
                      </div>
                      <div id="theme_by_type_color" class="form-group col-md-6 <?=(isset($card['card_bg_type']) && ($card['card_bg_type'] == 'Color' || $card['card_bg_type'] == ''))?'':'d-none'?>">
                        <label><?=$this->lang->line('theme_color')?$this->lang->line('theme_color'):'Theme Color'?><span class="text-danger">*</span></label>
                        <input type="color" name="theme_color" value="<?=($card['card_bg_type'] == 'Color' && $card['card_bg'] != '')?htmlspecialchars($card['card_bg']):theme_color()?>" class="form-control">
                      </div>
                      <span id="theme_by_type_image" class="col-md-6 <?=(isset($card['card_bg_type']) && $card['card_bg_type'] == 'Image')?'':'d-none'?>">
                        <span class="row">
                          <div class="form-group col-md-6">
                            <label class="form-label"><?=$this->lang->line('theme_image')?htmlspecialchars($this->lang->line('theme_image')):'Theme Image'?><span class="text-danger">*</span></label>
                            <input type="file" name="theme_image" class="form-control">
                          </div>
                          <div class="form-group col-md-6 my-auto <?=($card['card_bg'] != '' && file_exists('assets/uploads/card-bg/'.htmlspecialchars($card['card_bg'])))?'':'d-none'?>">
                            <img alt="Theme Image" src="<?=base_url('assets/uploads/card-bg/'.htmlspecialchars($card['card_bg']))?>" class="system-logos" style="width: 45%;">
                          </div>
                        </span>
                      </span>

                      <div class="form-group col-md-2 <?=is_module_allowed('hide_branding')?'':'d-none'?>">
                        <label class="form-label"><?=$this->lang->line('hide_branding')?htmlspecialchars($this->lang->line('hide_branding')):'Hide Branding'?></label>
                        <select name="hide_branding" class="form-control" <?=is_module_allowed('hide_branding')?'':'disabled'?>>
                          <option value="0" <?=(isset($card['hide_branding']) && $card['hide_branding'] == 0)?'selected':''?>><?=$this->lang->line('no')?htmlspecialchars($this->lang->line('no')):'No'?></option>
                          <option value="1" <?=(isset($card['hide_branding']) && $card['hide_branding'] == 1)?'selected':''?>><?=$this->lang->line('yes')?htmlspecialchars($this->lang->line('yes')):'Yes'?></option>
                      </select>
                      </div>


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
</body>
</html>