<form action="<?=base_url('settings/save-email-templates-setting')?>" method="POST" id="language-form">
    <div class="card-body row">
      <div class="form-group col-md-12">
        <label><?=$this->lang->line('select_template')?$this->lang->line('select_template'):'Select Email Template'?></label>
        <select name="select_template" id="select_template" class="form-control select2 filter_change">

          <option value="<?=base_url('settings/email-templates/new_user_registration')?>" <?=($this->uri->segment(3) == 'new_user_registration')?"selected":""?>> <?=$this->lang->line('new_user_registration')?htmlspecialchars($this->lang->line('new_user_registration')):'New user registration'?> </option>

          <option value="<?=base_url('settings/email-templates/forgot_password')?>" <?=($this->uri->segment(3) == 'forgot_password')?"selected":""?>> <?=$this->lang->line('forgot_password')?htmlspecialchars($this->lang->line('forgot_password')):'Forgot password'?> </option>

          <option value="<?=base_url('settings/email-templates/email_verification')?>" <?=($this->uri->segment(3) == 'email_verification')?"selected":""?>> <?=$this->lang->line('email_verification')?htmlspecialchars($this->lang->line('email_verification')):'Email verification'?> </option>

        </select>
      </div>
      <div class="form-group col-md-12">
        <label><?=$this->lang->line('email_subject')?$this->lang->line('email_subject'):'Email Subject'?></label>
        <input type="hidden" name="name" value="<?=$template?htmlspecialchars($template[0]['name']):''?>">
        <input type="text" name="subject" value="<?=$template?htmlspecialchars($template[0]['subject']):''?>" class="form-control" required="">
      </div>
      <div class="form-group col-md-12">
        <label><?=$this->lang->line('email_message')?$this->lang->line('email_message'):'Email Message'?></label>
        <textarea type="text" name="message" class="form-control"><?=$template?htmlspecialchars($template[0]['message']):''?></textarea>
      </div>
      
      <div class="form-group col-md-12">
        <div class="section-title">VARIABLES:</div>
        <?=$template?htmlspecialchars($template[0]['variables']):''?>
      </div>

    </div>
    <?php if ($this->ion_auth->in_group(3)){ ?>
      <div class="card-footer bg-whitesmoke text-md-right">
        <button class="btn btn-primary savebtn"><?=$this->lang->line('save_changes')?$this->lang->line('save_changes'):'Save Changes'?></button>
      </div>
    <?php } ?>
    <div class="result"></div>
  </form>

<script src="<?=base_url('assets/modules/tinymce/js/tinymce/tinymce.min.js')?>"></script>
<script>
tinymce.init({
  selector: 'textarea',
  height: 720,
  plugins: 'print preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons code',
  menubar: 'edit view insert format tools table tc help',
  toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor permanentpen removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment code',
  setup: function (editor) {
    editor.on("change keyup", function (e) {
        tinyMCE.triggerSave(); 
    });
  },
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});
</script>