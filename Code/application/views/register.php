<?php $this->load->view('includes/head'); ?>
</head>
<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <a href="<?=base_url()?>">
                <img src="<?=base_url('assets/uploads/logos/'.full_logo());?>" alt="logo" width="100%">
              </a>
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4><?=$this->lang->line('register')?$this->lang->line('register'):'Register'?></h4></div>

              <div class="card-body">
                <form id="register" method="POST" action="<?=base_url('auth/create_user')?>" class="needs-validation" novalidate="">
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="frist_name"><?=$this->lang->line('first_name')?$this->lang->line('first_name'):'First Name'?></label>
                      <input type="hidden" name="groups" value="1">
                      <input type="hidden" name="new_register" value="1">
                      <input id="frist_name" type="text" class="form-control" name="first_name" autofocus>
                    </div>
                    <div class="form-group col-6">
                      <label for="last_name"><?=$this->lang->line('last_name')?$this->lang->line('last_name'):'Last Name'?></label>
                      <input id="last_name" type="text" class="form-control" name="last_name">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email"><?=$this->lang->line('email')?$this->lang->line('email'):'Email'?></label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required>
                    
                  </div>
                  
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block"><?=$this->lang->line('password')?$this->lang->line('password'):'Password'?></label>
                      <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password">
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block"><?=$this->lang->line('password_confirmation')?$this->lang->line('password_confirmation'):'Password Confirmation'?></label>
                      <input id="password2" type="password" class="form-control" name="password_confirm">
                    </div>
                  </div>

                  <?php if(email_activation()){ ?>
                    <div class="form-group text-center text-danger">
                      <?=$this->lang->line('please_check_your_inbox_and_confirm_your_eamil_address_to_activate_your_account')?$this->lang->line('please_check_your_inbox_and_confirm_your_eamil_address_to_activate_your_account'):'Please check your inbox and confirm your email address to activate your account.'?>
                    </div>
                  <?php } ?>

                  <div class="form-group">
                    <button type="submit" class="savebtn btn btn-primary btn-lg btn-block" tabindex="4">
                    <?=$this->lang->line('register')?$this->lang->line('register'):'Register'?>
                    </button>
                  </div>
                  
                  <div class="form-group">
                    <div class="result"><?=isset($message)?htmlspecialchars($message):'';?></div>
                  </div>
                  <div class="text-muted text-center">
                  <?=$this->lang->line('already_have_an_account')?$this->lang->line('already_have_an_account'):'Already have an account?'?> <a href="<?=base_url('auth');?>"><?=$this->lang->line('login_here')?$this->lang->line('login_here'):'Login Here'?></a>
                  </div>

                </form>
              </div>
            </div>
            <div class="simple-footer">
              <?=htmlspecialchars(footer_text())?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('includes/js'); ?>

<script>
  site_key = '<?php echo get_google_recaptcha_site_key(); ?>';
</script>

<?php $recaptcha_site_key = get_google_recaptcha_site_key(); if($recaptcha_site_key){ ?>
  <script src="https://www.google.com/recaptcha/api.js?render=<?=htmlspecialchars($recaptcha_site_key)?>"></script>
<?php } ?>

</body>
</html>
