<?php $this->load->view('includes/head'); ?>
<link href="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.css" rel="stylesheet">
</head>
<body>
  <div id="app">
    <div class="main-wrapper">
      <?php $this->load->view('includes/navbar'); ?>
        <div class="main-content">
          <section class="section">
            <div class="section-header">
              <div class="section-header-back">
                <a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
              </div>
              <h1><?=$this->lang->line('features')?$this->lang->line('features'):'Features'?></h1>
              <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?=base_url()?>"><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></a></div>
                <div class="breadcrumb-item"><?=$this->lang->line('features')?$this->lang->line('features'):'Features'?></div>
              </div>
            </div>

            <div class="section-body">
              <div class="row">


                <div class="col-md-12" id="feature_div">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h4 class="card-title"><?=$this->lang->line('features')?$this->lang->line('features'):'Features'?> </h4>

                      <div class="card-header-action dropdown">
                        <a href="<?=base_url('front/create-feature')?>" class="btn btn-primary"><?=$this->lang->line('create')?$this->lang->line('create'):'Create'?></a>
                        
                      </div>
                    </div>
                    <div class="card-body">
                      <table class='table-striped' id='features_list'
                          data-toggle="table"
                          data-url="<?=base_url('front/get_feature')?>"
                          data-click-to-select="true"
                          data-use-row-attr-func="true"
                          data-reorderable-rows="true"
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
                            "fileName": "features-list",
                            "ignoreColumn": ["state"] 
                          }'
                          data-query-params="queryParams">
                          <thead>
                            <tr>
                              <th data-field="title" data-sortable="true"><?=$this->lang->line('title')?$this->lang->line('title'):'Title'?></th>
                              <th data-field="description" data-sortable="true"><?=$this->lang->line('description')?$this->lang->line('description'):'Description'?></th>
                              <th data-field="icon" data-sortable="true"><?=$this->lang->line('icon')?$this->lang->line('icon'):'Icon'?></th>
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

  <form action="<?=base_url('front/edit-pages')?>" method="POST" class="modal-part" id="modal-edit-pages-part" data-title="<?=$this->lang->line('edit')?$this->lang->line('edit'):'Edit'?>" data-btn_update="<?=$this->lang->line('update')?$this->lang->line('update'):'Update'?>">
  <input type="hidden" name="update_id" id="update_id" value="">
  <div class="row">
    <div class="form-group col-md-12">
      <label><?=$this->lang->line('pages_content')?$this->lang->line('pages_content'):'Page Content'?> (HTML)<span class="text-danger">*</span></label>
      <textarea type="text" name="content" id="content" class="form-control"></textarea>
    </div>
  </div>
</form>
<div id="modal-edit-pages"></div>

<?php $this->load->view('includes/js'); ?><script src="https://cdn.jsdelivr.net/npm/tablednd@1.0.5/dist/jquery.tablednd.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.min.js"></script>
<script>
  $('#features_list').bootstrapTable({
    onReorderRow: function (data) {
        console.log(data);
        $.ajax({
				type: "POST",
				url: base_url+'front/order_feature/', 
				data: "data="+JSON.stringify(data),
				dataType: "json",
				success: function(result) 
				{	
				  if(result['error'] == false){
            
				  }else{
					iziToast.error({
					  title: result['message'],
					  message: "",
					  position: 'topRight'
					});
				  }
				}        
			});
    }
  })
</script>
</body>
</html>
