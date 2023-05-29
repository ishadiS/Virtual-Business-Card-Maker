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
              <h1><?=$this->lang->line('settings')?$this->lang->line('settings'):'Settings'?></h1>
              <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?=base_url()?>"><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></a></div>
                <div class="breadcrumb-item"><?=$this->lang->line('settings')?$this->lang->line('settings'):'Settings'?></div>
              </div>
            </div>

            <div class="section-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="card card-primary">
                    <div class="card-body">
                      <ul class="nav nav-pills flex-column">
                        
                        <li class="nav-item"><a href="<?=base_url('settings')?>" class="nav-link <?=($main_page == 'general')?'active':''?>"><i class="fas fa-cogs"></i> <?=$this->lang->line('general')?$this->lang->line('general'):'General'?></a></li>

                        <li class="nav-item"><a href="<?=base_url('settings/payment')?>" class="nav-link <?=($main_page == 'payment')?'active':''?>"><i class="fab fa-paypal"></i> <?=$this->lang->line('payment_gateway')?$this->lang->line('payment_gateway'):'Payment Gateway'?></a></li>
                       
                        <li class="nav-item"><a href="<?=base_url('settings/recaptcha')?>" class="nav-link <?=($main_page == 'recaptcha')?'active':''?>"><i class="fas fa-certificate"></i> <?=$this->lang->line('google_recaptcha')?$this->lang->line('google_recaptcha'):'Google reCAPTCHA'?></a></li>

                        <li class="nav-item"><a href="<?=base_url('settings/email')?>" class="nav-link <?=($main_page == 'email')?'active':''?>"><i class="fas fa-at"></i> <?=$this->lang->line('email')?$this->lang->line('email'):'Email'?></a></li>
                        <li class="nav-item"><a href="<?=base_url('settings/email-templates')?>" class="nav-link <?=($main_page == 'email-templates')?'active':''?>"><i class="fas fa-mail-bulk"></i> <?=$this->lang->line('email_templates')?$this->lang->line('email_templates'):'Email Templates'?></a></li>
                        <li class="nav-item"><a href="<?=base_url('languages')?>" class="nav-link <?=($main_page == 'languages')?'active':''?>"><i class="fa fa-language"></i> <?=$this->lang->line('languages')?$this->lang->line('languages'):'Languages'?></a></li>
                        <li class="nav-item"><a href="<?=base_url('settings/update')?>" class="nav-link <?=($main_page == 'update')?'active':''?>"><i class="fas fa-hand-holding-heart"></i> <?=$this->lang->line('update')?$this->lang->line('update'):'Update'?></a></li>
                        <li class="nav-item"><a href="<?=base_url('settings/custom-code')?>" class="nav-link <?=($main_page == 'custom-code')?'active':''?>"><i class="fas fa-code"></i> <?=$this->lang->line('custom_code')?$this->lang->line('custom_code'):'Custom Code'?></a></li>
                       
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="card card-primary" id="settings-card">
                    <?php $this->load->view('setting-forms/'.htmlspecialchars($main_page)); ?>
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

<?php if($this->uri->segment(2) == 'custom-code'){ ?>
  <script>
    CodeMirror.fromTextArea(document.getElementById('header_code'), { 
      lineNumbers: true,
      theme: 'duotone-dark',
    }).on('change', editor => {
      $("#header_code").val(editor.getValue());
    });

    CodeMirror.fromTextArea(document.getElementById('footer_code'), { 
      lineNumbers: true,
      theme: 'duotone-dark',
    }).on('change', editor => {
      $("#footer_code").val(editor.getValue());
    });
  </script>
<?php } ?>

</body>
</html>
