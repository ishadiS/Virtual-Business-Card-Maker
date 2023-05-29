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
            <?=$this->lang->line('profile')?htmlspecialchars($this->lang->line('profile')):'Profile'?>
            </h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>"><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></a></div>
              <div class="breadcrumb-item"><?=$this->lang->line('profile')?htmlspecialchars($this->lang->line('profile')):'Profile'?></div>
            </div>
          </div>

          <div class="section-body">

              <?php if($card){  if(!$this->ion_auth->in_group(3)){ ?> 
                <div class="row">
                  <div class="col-md-12 form-group">
                    <select class="form-control select2 filter_change">
                      <?php foreach($my_all_cards as $my_all_card){ ?>
                      <option value="<?=base_url('cards/profile/'.$my_all_card['id'])?>" <?=($card['id'] == $my_all_card['id'])?"selected":""?>><?=htmlspecialchars($my_all_card['title'])?> - <?=htmlspecialchars($my_all_card['sub_title'])?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              <?php } ?> 

              <form action="<?=base_url('cards/save')?>" method="POST" id="save_card" enctype="multipart/form-data">
                <input type="hidden" name="changes_type" value="profile">
                <input type="hidden" name="card_id" value="<?=$card['id']?>">

                <div class="card card-primary" id="save_card_card">
                  <div class="card-body">

                    <div class="row">


                      <span class="col-md-6 mb-4">
                        <span class="row">
                          <div class="form-group col-md-6">
                            <label class="form-label"><?=$this->lang->line('profile_image')?htmlspecialchars($this->lang->line('profile_image')):'Profile Image'?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=$this->lang->line('best_size_for_profile_image')?htmlspecialchars($this->lang->line('best_size_for_profile_image')):"Best size 400x400px or Square Image."?>"></i></label>
                            <input type="file" name="profile" class="form-control">
                            <input type="hidden" name="old_profile" value="<?=($card['profile'] != '')?$card['profile']:''?>">
                          </div>
                          <div class="form-group col-md-6 my-auto <?=($card['profile'] != '' && file_exists('assets/uploads/card-profile/'.htmlspecialchars($card['profile'])))?'':'d-none'?>">
                            <img alt="Profile Image" src="<?=base_url('assets/uploads/card-profile/'.htmlspecialchars($card['profile']))?>" class="system-logos" style="width: 45%;">
                          </div>
                        </span>
                      </span>

                      <span class="col-md-6 mb-4">
                        <span class="row">
                          <div class="form-group col-md-6">
                            <label class="form-label"><?=$this->lang->line('banner_image')?htmlspecialchars($this->lang->line('banner_image')):'Banner Image'?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=$this->lang->line('not_applicable_to_all_themes')?htmlspecialchars($this->lang->line('not_applicable_to_all_themes')):'Not applicable to all themes.'?>"></i></label>
                            <input type="file" name="banner" class="form-control">
                            <input type="hidden" name="old_banner" value="<?=($card['banner'] != '')?$card['banner']:''?>">
                          </div>
                          <div class="form-group col-md-6 my-auto <?=($card['banner'] != '' && file_exists('assets/uploads/card-banner/'.htmlspecialchars($card['banner'])))?'':'d-none'?>">
                            <img alt="Banner" src="<?=base_url('assets/uploads/card-banner/'.htmlspecialchars($card['banner']))?>" class="system-logos" style="width: 45%;">
                          </div>
                        </span>
                      </span>
                      
                      <div class="form-group col-md-6">
                        <label><?=$this->lang->line('slug')?htmlspecialchars($this->lang->line('slug')):'Slug'?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=$this->lang->line('slug_will_be_used_for_your_vcard_url')?htmlspecialchars($this->lang->line('slug_will_be_used_for_your_vcard_url')):'Slug will be used for your vcard url. Use only english alphanumeric value, no space allowed. (Hyphen(-) allowed).'?>"></i><span class="text-danger">*</span></label>
                        <input type="text" name="slug" value="<?=htmlspecialchars($card['slug'])?>" class="form-control" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label><?=$this->lang->line('title')?htmlspecialchars($this->lang->line('title')):'Title'?><span class="text-danger">*</span></label>
                        <input type="text" name="title" value="<?=htmlspecialchars($card['title'])?>" class="form-control" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label><?=$this->lang->line('sub_title')?htmlspecialchars($this->lang->line('sub_title')):'Sub Title'?><span class="text-danger">*</span></label>
                        <input type="text" name="sub_title" value="<?=htmlspecialchars($card['sub_title'])?>" class="form-control" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label><?=$this->lang->line('google_analytics')?htmlspecialchars($this->lang->line('google_analytics')):'Google Analytics'?></label>
                        <input type="text" name="google_analytics" value="<?=htmlspecialchars($card['google_analytics'])?>" class="form-control" placeholder="UA-146619163-9">
                      </div>
                      <div class="form-group col-md-12">
                        <label><?=$this->lang->line('short_description')?htmlspecialchars($this->lang->line('short_description')):'Short Description'?><span class="text-danger">*</span></label>
                        <textarea type="text" name="short_description" class="form-control" required><?=htmlspecialchars($card['description'])?></textarea>
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