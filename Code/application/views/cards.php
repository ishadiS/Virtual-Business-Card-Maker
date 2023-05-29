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
              <?=$this->lang->line('vcards')?htmlspecialchars($this->lang->line('vcards')):'vCards'?>
              <?php if(!$this->ion_auth->in_group(3)){ if(my_plan_features('cards')){ ?> 
                <a href="#" id="modal-add-card" class="btn btn-sm btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> <?=$this->lang->line('create')?$this->lang->line('create'):'Create'?></a>
              <?php } } ?> 
            </h1>

            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>"><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></a></div>
              <div class="breadcrumb-item"><?=$this->lang->line('vcards')?htmlspecialchars($this->lang->line('vcards')):'vCards'?></div>
            </div>
          </div>
          <div class="section-body">
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-primary">
                      <div class="card-body"> 
                        <table class='table-striped' id='cards_list'
                          data-toggle="table"
                          data-url="<?=base_url('cards/get_cards')?>"
                          data-click-to-select="true"
                          data-side-pagination="server"
                          data-pagination="true"
                          data-page-list="[5, 10, 20, 50, 100, 200]"
                          data-search="true" data-show-columns="false"
                          data-show-refresh="false" data-trim-on-search="false"
                          data-sort-name="id" data-sort-order="DESC"
                          data-mobile-responsive="true"
                          data-toolbar="#tool" data-show-export="false"
                          data-maintain-selected="true"
                          data-export-types='["txt","excel"]'
                          data-export-options='{
                            "fileName": "cards-list",
                            "ignoreColumn": ["state"] 
                          }'
                          data-query-params="queryParams">
                          <thead>
                            <tr>
                              <th data-field="title" data-sortable="true"><?=$this->lang->line('vcards')?htmlspecialchars($this->lang->line('vcards')):'vCards'?></th>

                              <?php if ($this->ion_auth->in_group(3)){ ?> 
                              <th data-field="first_name" data-sortable="true"><?=$this->lang->line('subscribers')?htmlspecialchars($this->lang->line('subscribers')):'Subscribers'?></th>
                              <?php } ?> 

                              <th data-field="action" data-sortable="false"><?=$this->lang->line('action')?$this->lang->line('action'):'Action'?></th>
                            </tr>
                          </thead>
                        </table>
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

  <form action="<?=base_url('cards/save')?>" method="POST" class="modal-part" id="modal-add-card-part" data-title="<?=$this->lang->line('create')?$this->lang->line('create'):'Create'?>" data-btn="<?=$this->lang->line('create')?$this->lang->line('create'):'Create'?>">
  <div class="row">

    <input type="hidden" name="changes_type" value="profile">
    <input type="hidden" name="card_id" value="0">
    <input type="hidden" name="create" value="yes">

    <div class="form-group col-md-4">
      <label><?=$this->lang->line('slug')?htmlspecialchars($this->lang->line('slug')):'Slug'?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=$this->lang->line('slug_will_be_used_for_your_vcard_url')?htmlspecialchars($this->lang->line('slug_will_be_used_for_your_vcard_url')):'Slug will be used for your vcard url. Use only english alphanumeric value, no space allowed. (Hyphen(-) allowed).'?>"></i><span class="text-danger">*</span></label>
      <input type="text" name="slug" class="form-control" required>
    </div>
    <div class="form-group col-md-4">
      <label><?=$this->lang->line('title')?htmlspecialchars($this->lang->line('title')):'Title'?><span class="text-danger">*</span></label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="form-group col-md-4">
      <label><?=$this->lang->line('sub_title')?htmlspecialchars($this->lang->line('sub_title')):'Sub Title'?><span class="text-danger">*</span></label>
      <input type="text" name="sub_title" class="form-control" required>
    </div>
    <div class="form-group col-md-12">
      <label><?=$this->lang->line('short_description')?htmlspecialchars($this->lang->line('short_description')):'Short Description'?><span class="text-danger">*</span></label>
      <textarea type="text" name="short_description" class="form-control" required></textarea>
    </div>

  </div>
</form>

<?php $this->load->view('includes/js'); ?>
</body>
</html>
