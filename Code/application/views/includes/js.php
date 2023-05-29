<script>
company_name = '<?=company_name()?>';
saas_id = '<?=$this->session->userdata('saas_id')?>';
base_url = "<?=base_url();?>";
date_format_js = "<?=system_date_format_js();?>";
time_format_js = "<?=system_time_format_js();?>";
currency_code = "<?=get_saas_currency('currency_code');?>";
currency_symbol = "<?=get_saas_currency('currency_symbol');?>";
theme_color = "<?=htmlspecialchars(theme_color())?>";
subscribers = "<?=$this->lang->line('subscribers')?htmlspecialchars($this->lang->line('subscribers')):'Subscribers'?>";
wait = "<?=$this->lang->line('wait')?$this->lang->line('wait'):"Wait..."?>";
default_language_can_not_be_deleted = "<?=$this->lang->line('default_language_can_not_be_deleted')?$this->lang->line('default_language_can_not_be_deleted'):"Default language can not be deleted."?>";
are_you_sure = "<?=$this->lang->line('are_you_sure')?$this->lang->line('are_you_sure'):"Are you sure?"?>";
you_want_to_delete_this_notification = "<?=$this->lang->line('you_want_to_delete_this_notification')?$this->lang->line('you_want_to_delete_this_notification'):"You want to delete this Notification?"?>";
you_want_to_delete_this_feature = "<?=$this->lang->line('you_want_to_delete_this_feature')?$this->lang->line('you_want_to_delete_this_feature'):"You want to delete this Feature?"?>";
you_want_reject_this_offline_request_this_can_not_be_undo = "<?=$this->lang->line('you_want_reject_this_offline_request_this_can_not_be_undo')?$this->lang->line('you_want_reject_this_offline_request_this_can_not_be_undo'):"You want reject this offline request? This can not be undo."?>";
you_want_accept_this_offline_request_this_can_not_be_undo = "<?=$this->lang->line('you_want_accept_this_offline_request_this_can_not_be_undo')?$this->lang->line('you_want_accept_this_offline_request_this_can_not_be_undo'):"You want accept this offline request? This can not be undo."?>";
default_plan_can_not_be_deleted = "<?=$this->lang->line('default_plan_can_not_be_deleted')?$this->lang->line('default_plan_can_not_be_deleted'):"Default plan can not be deleted."?>";
you_want_to_delete_this_plan_all_users_under_this_plan_will_be_added_to_the_default_plan = "<?=$this->lang->line('you_want_to_delete_this_plan_all_users_under_this_plan_will_be_added_to_the_default_plan')?$this->lang->line('you_want_to_delete_this_plan_all_users_under_this_plan_will_be_added_to_the_default_plan'):"You want to delete this Plan? All users under this plan will be added to the Default Plan."?>";
you_want_to_delete_this_user_all_related_data_with_this_user_also_will_be_deleted = "<?=$this->lang->line('you_want_to_delete_this_user_all_related_data_with_this_user_also_will_be_deleted')?$this->lang->line('you_want_to_delete_this_user_all_related_data_with_this_user_also_will_be_deleted'):"You want to delete this user? All related data with this user also will be deleted."?>";
you_want_to_upgrade_the_system_please_take_a_backup_before_going_further = "<?=$this->lang->line('you_want_to_upgrade_the_system_please_take_a_backup_before_going_further')?$this->lang->line('you_want_to_upgrade_the_system_please_take_a_backup_before_going_further'):"You want to upgrade the system? Please take a backup before going further."?>";
you_want_to_activate_this_user = "<?=$this->lang->line('you_want_to_activate_this_user')?$this->lang->line('you_want_to_activate_this_user'):"You want to activate this user?"?>";
you_want_to_deactivate_this_user_this_user_will_be_not_able_to_login_after_deactivation = "<?=$this->lang->line('you_want_to_deactivate_this_user_this_user_will_be_not_able_to_login_after_deactivation')?$this->lang->line('you_want_to_deactivate_this_user_this_user_will_be_not_able_to_login_after_deactivation'):"You want to deactivate this user? This user will be not able to login after deactivation."?>";
something_wrong_try_again = "<?=$this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again."?>";
we_will_contact_you_for_further_process_of_payment_as_soon_as_possible_click_ok_to_confirm = "<?=$this->lang->line('we_will_contact_you_for_further_process_of_payment_as_soon_as_possible_click_ok_to_confirm')?$this->lang->line('we_will_contact_you_for_further_process_of_payment_as_soon_as_possible_click_ok_to_confirm'):"We will contact you for further process of payment as soon as possible. Click OK to confirm."?>";
you_want_to_delete_this_language = "<?=$this->lang->line('you_want_to_delete_this_language')?$this->lang->line('you_want_to_delete_this_language'):"You want to delete this Language?"?>";
copied_to_clipboard = "<?=$this->lang->line('copied_to_clipboard')?htmlspecialchars($this->lang->line('copied_to_clipboard')):'Copied to clipboard'?>";
</script>

<!-- General JS Scripts -->
<script src="<?=base_url('assets/modules/jquery.min.js')?>"></script>
<script src="<?=base_url('assets/modules/popper.js')?>"></script>
<script src="<?=base_url('assets/modules/tooltip.js')?>"></script>
<script src="<?=base_url('assets/modules/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('assets/modules/nicescroll/jquery.nicescroll.min.js')?>"></script>
<script src="<?=base_url('assets/modules/moment.min.js')?>"></script>
<script src="<?=base_url('assets/js/stisla.js')?>"></script>
 
<!-- JS Libraies -->
<script src="<?=base_url('assets/modules/bootstrap-daterangepicker/daterangepicker.js')?>"></script>

<script src="<?=base_url('assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')?>"></script>
<script src="<?=base_url('assets/modules/chart.min.js')?>"></script>
<script src="<?=base_url('assets/modules/select2/dist/js/select2.full.min.js')?>"></script>

<script src="<?=base_url('assets/modules/bootstrap-table/tableExport.min.js');?>"></script>
<script src="<?=base_url('assets/modules/bootstrap-table/bootstrap-table.min.js');?>"></script>
<script src="<?=base_url('assets/modules/bootstrap-table/bootstrap-table-mobile.js');?>"></script>
<script src="<?=base_url('assets/modules/bootstrap-table/bootstrap-table-export.min.js');?>"></script>

<script src="<?=base_url('assets/modules/izitoast/js/iziToast.min.js');?>"></script>
<script src="<?=base_url('assets/modules/sweetalert/sweetalert.min.js');?>"></script>
<script src="<?=base_url('assets/modules/codemirror/lib/codemirror.js');?>"></script>

<!-- Template JS File -->
<script src="<?=base_url('assets/js/scripts.js')?>"></script>
<script src="<?=base_url('assets/js/custom.js')?>"></script>

<?php if($this->session->flashdata('message') && $this->session->flashdata('message_type') == 'success'){ ?>
  <script>
  iziToast.success({
    title: "<?=$this->session->flashdata('message');?>",
    message: "",
    position: 'topRight'
  });
  </script>
<?php } ?>

<?=get_footer_code()?>