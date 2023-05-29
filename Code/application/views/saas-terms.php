<?php $this->load->view('includes/head'); ?>
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
              <h1><?=$this->lang->line('terms_and_conditions')?$this->lang->line('terms_and_conditions'):'Terms and Conditions'?></h1>
              <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?=base_url()?>"><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></a></div>
                <div class="breadcrumb-item"><?=$this->lang->line('terms_and_conditions')?$this->lang->line('terms_and_conditions'):'Terms and Conditions'?></div>
              </div>
            </div>

            <div class="section-body">
              <div class="row">
                <div class="col-md-12" id="home-card">
                  <div class="card card-primary">
                    <div class="card-body">
                      <form action="<?=base_url('front/edit-pages')?>" method="POST" id="home-form">
                        <input type="hidden" name="update_id" id="update_id" value="<?=htmlspecialchars($data[0]['id'])?>">
                        <textarea name="content"><?=htmlspecialchars($data[0]['content'])?></textarea>
                        
                        <div class="card-footer bg-whitesmoke text-md-right">
                            <button class="btn btn-primary savebtn"><?=$this->lang->line('save_changes')?$this->lang->line('save_changes'):'Save Changes'?></button>
                        </div>
                        <div class="result"></div>
                      </form>
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
<script src="<?=base_url('assets/modules/tinymce/js/tinymce/tinymce.min.js')?>"></script>
<script>

tinymce.init({
  selector: 'textarea',
  height: 240,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic backcolor | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat | help',
  setup: function (editor) {
    editor.on("change keyup", function (e) {
        tinyMCE.triggerSave(); 
    });
  },
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});

</script>
</body>
</html>
