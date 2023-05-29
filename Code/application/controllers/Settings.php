<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
	}

	public function clear_cache()
	{	
		$cache_path = 'install';
		delete_files($cache_path, true);
		rmdir($cache_path);
		redirect('auth', 'refresh');
	}

	public function index()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->data['page_title'] = 'Settings - '.company_name();
			$this->data['main_page'] = 'general';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->data['timezones'] = timezones();
			$this->data['time_formats'] = time_formats();
			$this->data['date_formats'] = date_formats();

			$this->data['company_name'] = company_name();
			$this->data['company_email'] = company_email();
			
			$this->data['currency_code'] = get_saas_currency('currency_code');
			$this->data['currency_symbol'] = get_saas_currency('currency_symbol');

			$this->data['footer_text'] = footer_text();
			$this->data['google_analytics'] = google_analytics();
			$this->data['mysql_timezone'] = mysql_timezone();
			$this->data['php_timezone'] = php_timezone();
			$this->data['date_format'] = system_date_format();
			$this->data['time_format'] = system_time_format();
			$this->data['date_format_js'] = system_date_format_js();
			$this->data['time_format_js'] = system_time_format_js();
			$this->data['full_logo'] = full_logo();
			$this->data['half_logo'] = half_logo();
			$this->data['favicon'] = favicon();
			$this->data['alert_days'] = alert_days();
			$this->data['default_language'] = default_language();
			$this->data['email_activation'] = email_activation();
			$this->data['theme_color'] = theme_color();
			$this->load->view('settings',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}
	
	public function migrate()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->load->library('migration');
			$this->migration->latest();
			redirect('settings/update', 'refresh');

		}else{
			redirect('auth', 'refresh');
		}
	}

	public function update()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->data['page_title'] = 'Settings - '.company_name();
			$this->data['main_page'] = 'update';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->load->view('settings',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function payment()
	{
		if ($this->ion_auth->logged_in() && is_module_allowed('payment_gateway') && ($this->ion_auth->in_group(1) || $this->ion_auth->in_group(3)))
		{
			$this->data['page_title'] = 'Settings - '.company_name();
			$this->data['main_page'] = 'payment';
			$this->data['current_user'] = $this->ion_auth->user()->row();

			$this->data['paypal_client_id'] = get_payment_paypal();
			$this->data['paypal_secret'] = get_paypal_secret();
			$this->data['stripe_publishable_key'] = get_stripe_publishable_key();
			$this->data['stripe_secret_key'] = get_stripe_secret_key();
			$this->data['razorpay_key_id'] = get_razorpay_key_id();
			$this->data['razorpay_key_secret'] = get_razorpay_key_secret();
			$this->data['paystack_public_key'] = get_paystack_public_key();
			$this->data['paystack_secret_key'] = get_paystack_secret_key();
			$this->data['offline_bank_transfer'] = get_offline_bank_transfer();

			$this->load->view('settings',$this->data);

		}else{
			redirect('auth', 'refresh');
		}
	}

	public function save_payment_setting()
	{
		
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3) || $this->ion_auth->in_group(1)))
		{

			$data_json = array();
			$data_json['paypal_client_id'] = $this->input->post('paypal_client_id')?$this->input->post('paypal_client_id'):'';
			$data_json['paypal_secret'] = $this->input->post('paypal_secret')?$this->input->post('paypal_secret'):'';
			$data_json['stripe_publishable_key'] = $this->input->post('stripe_publishable_key')?$this->input->post('stripe_publishable_key'):'';
			$data_json['stripe_secret_key'] = $this->input->post('stripe_secret_key')?$this->input->post('stripe_secret_key'):'';
			$data_json['razorpay_key_id'] = $this->input->post('razorpay_key_id')?$this->input->post('razorpay_key_id'):'';
			$data_json['razorpay_key_secret'] = $this->input->post('razorpay_key_secret')?$this->input->post('razorpay_key_secret'):'';
			$data_json['paystack_public_key'] = $this->input->post('paystack_public_key')?$this->input->post('paystack_public_key'):'';
			$data_json['paystack_secret_key'] = $this->input->post('paystack_secret_key')?$this->input->post('paystack_secret_key'):'';
			$data_json['offline_bank_transfer'] = $this->input->post('offline_bank_transfer') != ''?1:'';
			
			$data = array(
				'value' => json_encode($data_json)
			);

			$setting_type = 'payment';
			
			if($this->settings_model->save_settings($setting_type,$data)){
				$this->data['error'] = false;
				$this->data['data'] = $data_json;
				$this->data['message'] = $this->lang->line('payment_setting_saved')?$this->lang->line('payment_setting_saved'):"Payment Setting Saved.";
				echo json_encode($this->data); 
			}else{
				$this->data['error'] = true;
				$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
				echo json_encode($this->data);
			}
		}else{
			
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data); 
		}
	}

	public function save_home_setting()
	{
		
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{

			$data_json = array();
			$data_title = array();
			$data_desc = array();
			$langs = $this->languages_model->get_languages();
			foreach($langs as $lan){
				if($this->input->post($lan['language'].'_title') && $this->input->post($lan['language'].'_description')){
					$data_json[$lan['language']] = array('title' => $this->input->post($lan['language'].'_title'), 'description' => $this->input->post($lan['language'].'_description'));
				}else{
					$data_json[$lan['language']] = array('title' => '', 'description' => '');
				}

			}

			$data = array(
				'value' => json_encode($data_json)
			);
			$setting_type = 'home';
			
			if($this->settings_model->save_settings($setting_type,$data)){
				$this->data['error'] = false;
				$this->data['data'] = $data_json;
				$this->data['message'] = $this->lang->line('frontend_setting_saved')?$this->lang->line('frontend_setting_saved'):"Frontend Setting Saved.";
				echo json_encode($this->data); 
			}else{
				$this->data['error'] = true;
				$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
				echo json_encode($this->data);
			}
		}else{
			
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data); 
		}
	}

	public function recaptcha()
	{
		if ($this->ion_auth->logged_in() && is_module_allowed('payment_gateway') && ($this->ion_auth->in_group(1) || $this->ion_auth->in_group(3)))
		{
			$this->data['page_title'] = 'Settings - '.company_name();
			$this->data['main_page'] = 'recaptcha';
			$this->data['current_user'] = $this->ion_auth->user()->row();

			$this->data['site_key'] = get_google_recaptcha_site_key();
			$this->data['secret_key'] = get_google_recaptcha_secret_key();

			$this->load->view('settings',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}
	
	public function save_recaptcha_setting()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->form_validation->set_rules('site_key', 'site key', 'trim|required|xss_clean');
			$this->form_validation->set_rules('secret_key', 'secret key', 'trim|required|xss_clean');

			if($this->form_validation->run() == TRUE){
				$data_json = array(
					'site_key' => $this->input->post('site_key'),
					'secret_key' => $this->input->post('secret_key'),
				);

				$data = array(
					'value' => json_encode($data_json)
				);

				$setting_type = 'recaptcha';

				if($this->settings_model->save_settings($setting_type,$data)){
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('updated_successfully')?$this->lang->line('updated_successfully'):"Updated successfully.";
					echo json_encode($this->data); 
				}else{
					$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
					echo json_encode($this->data);
				}
			}else{
				$this->data['error'] = true;
				$this->data['message'] = validation_errors();
				echo json_encode($this->data); 
			}
		}else{
			
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data); 
		}
	}
	
	public function save_front_setting()
	{
		
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{

			$data_json = array();
			$data_json['theme_name'] = $this->input->post('theme_name');
			$data_json['landing_page'] = $this->input->post('landing_page') != ''?1:0;
			$data_json['features'] = $this->input->post('features') != ''?1:0;
			$data_json['subscription_plans'] = $this->input->post('subscription_plans') != ''?1:0;
			$data_json['contact'] = $this->input->post('contact') != ''?1:0;
			$data_json['about'] = $this->input->post('about') != ''?1:0;
			$data_json['privacy'] = $this->input->post('privacy') != ''?1:0;
			$data_json['terms'] = $this->input->post('terms') != ''?1:0;

			$data = array(
				'value' => json_encode($data_json)
			);
			$setting_type = 'frontend';
			
			if($this->settings_model->save_settings($setting_type,$data)){
				$this->data['error'] = false;
				$this->data['data'] = $data_json;
				$this->data['message'] = $this->lang->line('frontend_setting_saved')?$this->lang->line('frontend_setting_saved'):"Frontend Setting Saved.";
				echo json_encode($this->data); 
			}else{
				$this->data['error'] = true;
				$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
				echo json_encode($this->data);
			}
		}else{
			
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data); 
		}
	}

	public function save_update_setting()
	{
		
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{		
				$upload_path = 'update';
				if(!is_dir($upload_path)){
					mkdir($upload_path,0775,true);
				}

				$config['upload_path']          = $upload_path;
				$config['allowed_types']        = 'zip';
				$config['overwrite']             = true;

				$this->load->library('upload', $config);
				if (!empty($_FILES['update']['name']) && ($_FILES['update']['name'] == 'update.zip' || $_FILES['update']['name'] == 'additional.zip')){

					if ($this->upload->do_upload('update')){
							$update_data = $this->upload->data();

							$zip = new ZipArchive;
							if ($zip->open($update_data['full_path']) === TRUE) 
							{
								if($zip->extractTo($upload_path)){
									$zip->close();
									if(is_dir($upload_path) && is_dir($upload_path.'/files') && file_exists($upload_path."/version.txt") && file_exists($upload_path.'/validate.txt')){

										$version = file_get_contents($upload_path."/version.txt");
										$validate = file_get_contents($upload_path.'/validate.txt');
										if($version && $validate == 'hhmsbbhmrs'){

											recurse_copy($upload_path.'/files', './');
												
											if(is_numeric($version)){
												$data = array(
													'value' => $version
												);
												$this->settings_model->save_settings('system_version',$data);
											}

											delete_files($upload_path, true);
											rmdir($upload_path);

											$this->session->set_flashdata('message', $this->lang->line('system_updated_successfully')?$this->lang->line('system_updated_successfully'):"System updated successfully.");
											$this->session->set_flashdata('message_type', 'success');

											$this->data['error'] = false;
											$this->data['message'] = $this->lang->line('system_updated_successfully')?$this->lang->line('system_updated_successfully'):"System updated successfully.";
											echo json_encode($this->data); 

										}else{
											$this->data['error'] = true;
											$this->data['message'] = $this->lang->line('wrong_update_file_is_selected')?$this->lang->line('wrong_update_file_is_selected'):"Wrong update file is selected.";
											echo json_encode($this->data); 
											return false;
										}
										
									}else{
										
										$this->data['error'] = true;
										$this->data['message'] = $this->lang->line('select_valid_zip_file')?$this->lang->line('select_valid_zip_file'):"Select valid zip file.";
										echo json_encode($this->data); 
										return false;
									}
								}else{
									$this->data['error'] = true;
									$this->data['message'] = $this->lang->line('error_occured_during_file_extracting_select_valid_zip_file_or_please_try_again_later')?$this->lang->line('error_occured_during_file_extracting_select_valid_zip_file_or_please_try_again_later'):"Error occured during file extracting. Select valid zip file OR Please Try again later.";
									echo json_encode($this->data); 
									return false;
								}
							}else{
								
								$this->data['error'] = true;
								$this->data['message'] = $this->lang->line('error_occured_during_file_uploading_select_valid_zip_file_or_please_try_again_later')?$this->lang->line('error_occured_during_file_uploading_select_valid_zip_file_or_please_try_again_later'):"Error occured during file uploading. Select valid zip file OR Please Try again later.";
								echo json_encode($this->data); 
								return false;
							}
					}else{
						$this->data['error'] = true;
						$this->data['message'] = $this->upload->display_errors();
						echo json_encode($this->data); 
						return false;
					}
					
				}else{
					$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('select_valid_zip_file')?$this->lang->line('select_valid_zip_file'):"Select valid zip file.";
					echo json_encode($this->data); 
					return false;
				}
		}else{
			
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data); 
		}
	}

	public function custom_code()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->data['page_title'] = 'Custom Code - '.company_name();
			$this->data['main_page'] = 'custom-code';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->data['header_code'] = get_header_code();
			$this->data['footer_code'] = get_footer_code();
			$this->load->view('settings',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function save_custom_code_setting()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
				$data_json = array(
					'header_code' => $this->input->post('header_code'),
					'footer_code' => $this->input->post('footer_code'),
				);

				$data = array(
					'value' => json_encode($data_json)
				);

				$setting_type = 'custom_code';

				if($this->settings_model->save_settings($setting_type,$data)){
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('updated_successfully')?$this->lang->line('updated_successfully'):"Updated successfully.";
					echo json_encode($this->data); 
				}else{
					$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
					echo json_encode($this->data);
				}
		}else{
			
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data); 
		}
	}

	public function email_templates()
	{ 
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->data['page_title'] = 'Settings - '.company_name();
			$this->data['main_page'] = 'email-templates';
			$this->data['current_user'] = $this->ion_auth->user()->row();

			$this->data['email_templates'] = $this->settings_model->get_email_templates();
			if($this->uri->segment(3)){
				$this->data['template'] = $this->settings_model->get_email_templates($this->uri->segment(3));
			}else{
				$this->data['template'] = $this->settings_model->get_email_templates('new_user_registration');
			}

			$this->load->view('settings',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function save_email_templates_setting()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{

			$this->form_validation->set_rules('name', 'Name', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('subject', 'Subject', 'required');
			$this->form_validation->set_rules('message', 'Message', 'required');

			if($this->form_validation->run() == TRUE){

				$data = array(
					'subject' => $this->input->post('subject'),
					'message' => $this->input->post('message'),	
				);

				if($this->settings_model->update_email_templates($this->input->post('name'),$data)){
				    
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('email_setting_saved')?$this->lang->line('email_setting_saved'):"Email Setting Saved.";
					echo json_encode($this->data); 
				}else{
					$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
					echo json_encode($this->data);
				}
			}else{
				$this->data['error'] = true;
				$this->data['message'] = validation_errors();
				echo json_encode($this->data); 
			}
		}else{
			
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data); 
		}
	}

	public function email()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->data['page_title'] = 'Settings - '.company_name();
			$this->data['main_page'] = 'email';
			$this->data['current_user'] = $this->ion_auth->user()->row();

			$this->data['smtp_host'] = smtp_host();
			$this->data['smtp_port'] = smtp_port();
			$this->data['smtp_username'] = smtp_email();
			$this->data['smtp_password'] = smtp_password();
			$this->data['smtp_encryption'] = smtp_encryption();
			$this->data['email_library'] = get_email_library();
			$this->load->view('settings',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function save_email_setting()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{

			$setting_type = 'email';
			$this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('smtp_username', 'Username', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('smtp_password', 'Password', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('smtp_encryption', 'Encryption', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('email_library', 'email library', 'trim|required|strip_tags|xss_clean');

			if($this->form_validation->run() == TRUE){

				$template_path 	= 'assets/templates/email.php';
                    
        		$output_path 	= 'application/config/email.php';
        
        		$email_file = file_get_contents($template_path);

        		if($this->input->post('smtp_encryption') == 'none'){
				     $smtp_encryption = $this->input->post('smtp_encryption');
				}else{
				     $smtp_encryption = $this->input->post('smtp_encryption').'://'.$this->input->post('smtp_host');
				}
				
        		$new  = str_replace("%SMTP_HOST%",$smtp_encryption,$email_file);
        		$new  = str_replace("%SMTP_PORT%",$this->input->post('smtp_port'),$new);
        		$new  = str_replace("%SMTP_USER%",$this->input->post('smtp_username'),$new);
        		$new  = str_replace("%SMTP_PASS%",$this->input->post('smtp_password'),$new);
        
        		if(!write_file($output_path, $new)){
        			$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
					echo json_encode($this->data);
					return false;
        		} 

				$data_json = array(
					'smtp_host' => $this->input->post('smtp_host'),
					'smtp_port' => $this->input->post('smtp_port'),
					'smtp_username' => $this->input->post('smtp_username'),
					'smtp_password' => $this->input->post('smtp_password'),
					'smtp_encryption' => $this->input->post('smtp_encryption'),	
					'email_library' => $this->input->post('email_library'),	
				);

				$data = array(
					'value' => json_encode($data_json)
				);

				if(!$this->ion_auth->in_group(3)){
					$setting_type = 'email_'.$this->session->userdata('saas_id');
				}

				if($this->settings_model->save_settings($setting_type,$data)){
				    
				    if($this->input->post('email')){  
            			$body = "<html>
            				<body>
            					<p>SMTP is perfectly configured.</p>
            					<p>Go To your workspace <a href='".base_url()."'>Click Here</a></p>
            				</body>
            			</html>";
						send_mail($this->input->post('email'),'Testing SMTP',$body);
				    }
				    
					$this->data['error'] = false;
					$this->data['data'] = $data_json;
					$this->data['message'] = $this->lang->line('email_setting_saved')?$this->lang->line('email_setting_saved'):"Email Setting Saved.";
					echo json_encode($this->data); 
				}else{
					$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
					echo json_encode($this->data);
				}
			}else{
				$this->data['error'] = true;
				$this->data['message'] = validation_errors();
				echo json_encode($this->data); 
			}
		}else{
			
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data); 
		}
	}

	public function save_general_setting()
	{
		if ($this->ion_auth->logged_in() &&  $this->ion_auth->in_group(3))
		{

			$setting_type = 'general';
			$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('footer_text', 'Footer Text', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('google_analytics', 'Google Analytics', 'trim|strip_tags|xss_clean');
			$this->form_validation->set_rules('alert_days', 'Alert Days', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('currency_code', 'Currency Code', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('theme_color', 'Theme Color', 'trim|required|strip_tags|xss_clean');

			$this->form_validation->set_rules('default_language', 'Default Language', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('mysql_timezone', 'Timezone', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('php_timezone', 'Timezone', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('date_format', 'Date Format', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('time_format', 'Time Format', 'trim|required|strip_tags|xss_clean');
			
			if($this->form_validation->run() == TRUE){

					$upload_path = 'assets/uploads/logos/';
					if(!is_dir($upload_path)){
						mkdir($upload_path,0775,true);
					}

					$config['upload_path']          = $upload_path;
					$config['allowed_types']        = 'gif|jpg|png|ico';
					$config['overwrite']             = false;
					$config['max_size']             = 0;
					$config['max_width']            = 0;
					$config['max_height']           = 0;
					$this->load->library('upload', $config);
					if (!empty($_FILES['full_logo']['name'])){
						if ($this->upload->do_upload('full_logo')){
								$full_logo = $this->upload->data('file_name');
								if($this->input->post('full_logo_old')){
									$unlink_path = $upload_path.''.$this->input->post('full_logo_old');
									unlink($unlink_path);
								}
						}else{
							$this->data['error'] = true;
							$this->data['message'] = $this->upload->display_errors();
							echo json_encode($this->data); 
							return false;
						}
					}else{
						$full_logo = $this->input->post('full_logo_old');
					}

					if (!empty($_FILES['half_logo']['name'])){
						if ($this->upload->do_upload('half_logo')){
								$half_logo = $this->upload->data('file_name');
								if($this->input->post('half_logo_old')){
									$unlink_path = $upload_path.''.$this->input->post('half_logo_old');
									unlink($unlink_path);
								}
						}else{
							$this->data['error'] = true;
							$this->data['message'] = $this->upload->display_errors();
							echo json_encode($this->data);  
							return false;
						}
					}else{
						$half_logo = $this->input->post('half_logo_old');
					}

					if (!empty($_FILES['favicon']['name'])){
						if ($this->upload->do_upload('favicon')){
							$favicon = $this->upload->data('file_name');
							if($this->input->post('favicon_old')){
								$unlink_path = $upload_path.''.$this->input->post('favicon_old');
								unlink($unlink_path);
							}
						}else{
							$this->data['error'] = true;
							$this->data['message'] = $this->upload->display_errors();
							echo json_encode($this->data);  
							return false;
						}
					}else{
						$favicon = $this->input->post('favicon_old');
					}

					$data_json = array(
						'company_name' => $this->input->post('company_name'),
						'footer_text' => $this->input->post('footer_text'),
						'currency_code' => $this->input->post('currency_code'),
						'currency_symbol' => $this->input->post('currency_symbol'),
						'google_analytics' => $this->input->post('google_analytics'),
						'mysql_timezone' => !empty($this->input->post('mysql_timezone') && $this->input->post('mysql_timezone') == '00:00')?'+'.$this->input->post('mysql_timezone'):$this->input->post('mysql_timezone'),
						'php_timezone' => $this->input->post('php_timezone'),
						'date_format' => $this->input->post('date_format'),
						'time_format' => $this->input->post('time_format'),	
						'date_format_js' => $this->input->post('date_format_js'),
						'time_format_js' => $this->input->post('time_format_js'),			
						'alert_days' => $this->input->post('alert_days'),		
						'full_logo' => $full_logo,		
						'half_logo' => $half_logo,		
						'favicon' => $favicon,			
						'default_language' => $this->input->post('default_language'),
						'email_activation' => $this->input->post('email_activation'),
						'theme_color' => $this->input->post('theme_color'),
					);
				$data = array(
					'value' => json_encode($data_json)
				);

				if($this->settings_model->save_settings($setting_type,$data)){
					$this->data['error'] = false;
					$this->data['data'] = $data_json;
					$this->data['message'] = $this->lang->line('general_setting_saved')?$this->lang->line('general_setting_saved'):"General Setting Saved.";
					echo json_encode($this->data); 
				}else{
					$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
					echo json_encode($this->data);
				}
			}else{
				$this->data['error'] = true;
				$this->data['message'] = validation_errors();
				echo json_encode($this->data); 
			}

			}else{
				
				$this->data['error'] = true;
				$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
				echo json_encode($this->data); 
			}
		}
	}


