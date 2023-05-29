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
            <?=$this->lang->line('qr_code')?htmlspecialchars($this->lang->line('qr_code')):'QR Code'?>
            </h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url()?>"><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></a></div>
              <div class="breadcrumb-item"><?=$this->lang->line('qr_code')?htmlspecialchars($this->lang->line('qr_code')):'QR Code'?></div>
            </div>
          </div>
          <div class="section-body">

            <?php if(!$this->ion_auth->in_group(3)){ ?> 
              <div class="row">
                <div class="col-md-12 form-group">
                  <select class="form-control select2 filter_change">
                    <?php foreach($my_all_cards as $my_all_card){ ?>
                    <option value="<?=base_url('cards/qr/'.$my_all_card['id'])?>" <?=($card['id'] == $my_all_card['id'])?"selected":""?>><?=htmlspecialchars($my_all_card['title'])?> - <?=htmlspecialchars($my_all_card['sub_title'])?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            <?php } ?> 

            <div class="card card-primary">
              <div class="card-body">
                <div class="row text-center">
                <div class="col-md-12" id="code">
                </div>
                <div class="col-md-12 mt-3">
                  <button onclick="xiazai()" class="btn btn-icon icon-left btn-outline-dark"><?=$this->lang->line('download_my_qr_code')?htmlspecialchars($this->lang->line('download_my_qr_code')):'Download My QR Code'?></button>
                </div>
                </div>
              </div>
              <div class="card-footer bg-whitesmoke text-md-right">
                <?php if(isset($card['slug']) && $card['slug'] != ''){ ?>
                  <a href="<?=base_url($card['slug'])?>" class="btn btn-icon icon-left btn-success copy_href"><i class="fas fa-copy"></i> <?=$this->lang->line('copy')?htmlspecialchars($this->lang->line('copy')):'Copy Card URL'?></a>
                  <a href="<?=base_url($card['slug'])?>" target="_blank" class="btn btn-icon icon-left btn-danger"><i class="fas fa-eye"></i> <?=$this->lang->line('preview')?htmlspecialchars($this->lang->line('preview')):'Preview'?></a>
                <?php } ?>
              </div>
            </div>
          </div>
        </section>
      </div>
    
    <?php $this->load->view('includes/footer'); ?>
    </div>
  </div>


<?php $this->load->view('includes/js'); ?>

<script src="<?=base_url('assets/modules/jquery.qrcode.min.js')?>"></script>

<script>
var card_url = '<?=isset($card['slug'])?base_url($card['slug']):base_url()?>';
</script>

<script src="<?=base_url('assets/js/page/qr.js')?>"></script>

</body>
</html>