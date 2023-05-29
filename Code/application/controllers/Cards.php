<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cards extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
	}

	public function info($slug = NULL)
	{
		$this->data['current_user'] = $this->ion_auth->user()->row();
		$card = $this->cards_model->get_card_by_slug($slug);
		
		if($card){

			$this->data['card_plan_details'] = $my_plan = get_current_plan($card['saas_id']);

			if($my_plan){
				$this->data['card_plan_modules'] = json_decode($my_plan['modules'], true);
			}else{
				$this->data['card_plan_modules'] = false;
			}

			if ($my_plan && !is_null($my_plan['end_date']) && $my_plan['end_date'] < date('Y-m-d') && $my_plan['expired'] == 1)
			{
			  $users_plans_data = array(
				'expired' => 0,			
			  );
			  $users_plans_id = $this->plans_model->update_users_plans($card['user_id'], $users_plans_data);
			  show_404();
			}
			if($my_plan && !is_null($my_plan['end_date']) && $my_plan['expired'] == 0){ 
				show_404();
			}

			$this->data['card'] = $card;
			$this->data['page_title'] = $card['title'];
			$this->data['meta_image'] = ($card['profile'] != '' && file_exists('assets/uploads/card-profile/'.$card['profile']))?base_url('assets/uploads/card-profile/'.$card['profile']):base_url('assets/uploads/logos/'.half_logo());
			$this->data['banner'] = ($card['banner'] != '' && file_exists('assets/uploads/card-banner/'.$card['banner']))?base_url('assets/uploads/card-banner/'.$card['banner']):'';
			$this->data['meta_description'] = $card['description'];
			$this->data['google_analytics'] = $card['google_analytics'];

			$this->data['products'] = $this->cards_model->get_products('', $card['user_id'], $card['id']);

			$this->data['portfolio'] = $this->cards_model->get_portfolio('', $card['user_id'], $card['id']);

			$this->data['gallery'] = $this->cards_model->get_gallery('', $card['user_id'], $card['id']);

			$this->data['testimonials'] = $this->cards_model->get_testimonials('', $card['user_id'], $card['id']);
			
			if($this->session->userdata('visited') == '' || $this->session->userdata('visited') != $card['id']){
				$this->session->set_userdata('visited', $card['id']);
				$data['views'] = 1 + $card['views'];
				$this->cards_model->save($card['id'], $card['user_id'], $data);
			}

			if($this->uri->segment(2) && ($this->uri->segment(2) == 'theme_one' || $this->uri->segment(2) == 'theme_two' || $this->uri->segment(2) == 'theme_three' || $this->uri->segment(2) == 'theme_four')){
				$this->load->view('cards/'.$this->uri->segment(2),$this->data);
			}else{
				if(isset($card['theme_name']) && $card['theme_name'] != ''){
					$this->load->view('cards/'.$card['theme_name'],$this->data);
				}else{
					$this->load->view('cards/theme_one',$this->data);
				}
			}
			
		}else{
			show_404();
		}
	}

	public function index()
	{
		if ($this->ion_auth->logged_in())
		{
			$this->data['page_title'] = 'Cards - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
            $this->load->view('cards',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function delete_card($id='')
	{
		

		if ($this->ion_auth->logged_in())
		{
			if(empty($id)){
				$id = $this->uri->segment(4)?$this->uri->segment(4):'';
			}

			$this->session->set_userdata('current_card_id', '');

			if(!empty($id) && is_numeric($id) && $this->cards_model->delete_card($id)){

				$this->cards_model->delete_product('', $id);
				$this->cards_model->delete_portfolio('', $id);
				$this->cards_model->delete_gallery('', $id);
				$this->cards_model->delete_testimonials('', $id);

				$this->session->set_flashdata('message', $this->lang->line('deleted_successfully')?$this->lang->line('deleted_successfully'):"Deleted successfully.");
				$this->session->set_flashdata('message_type', 'success');

				$this->data['error'] = false;
				$this->data['message'] = $this->lang->line('deleted_successfully')?$this->lang->line('deleted_successfully'):"Deleted successfully.";
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

	public function get_cards()
	{	
		if ($this->ion_auth->logged_in())
		{
			return $this->cards_model->get_cards();
		}else{
			return '';
		}
	}

	public function qr()
	{
		if ($this->ion_auth->logged_in() && is_module_allowed('qr_code'))
		{
			$this->data['page_title'] = 'QR Code - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();

			if($this->uri->segment(3) && is_numeric($this->uri->segment(3)) && !$this->ion_auth->in_group(3)){
				$this->session->set_userdata('current_card_id', $this->uri->segment(3));
			}

			$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			if(!$card_data){
				$this->session->set_userdata('current_card_id', '');
				$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			}

			$this->data['my_all_cards'] = $this->cards_model->get_my_all_cards();

            $this->load->view('card-qr',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

    public function theme()
	{
		if ($this->ion_auth->logged_in())
		{
			$this->data['page_title'] = 'Theme - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();	

			if($this->uri->segment(3) && is_numeric($this->uri->segment(3)) && !$this->ion_auth->in_group(3)){
				$this->session->set_userdata('current_card_id', $this->uri->segment(3));
			}

			$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			if(!$card_data){
				$this->session->set_userdata('current_card_id', '');
				$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			}

			$this->data['my_all_cards'] = $this->cards_model->get_my_all_cards();
			
			$this->data['demo'] = $this->cards_model->get_card_by_ids('', 1);
			
            $this->load->view('card-theme',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function profile()
	{
		if ($this->ion_auth->logged_in())
		{
			$this->data['page_title'] = 'Profile - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();

			if($this->uri->segment(3) && is_numeric($this->uri->segment(3)) && !$this->ion_auth->in_group(3)){
				$this->session->set_userdata('current_card_id', $this->uri->segment(3));
			}

			$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			if(!$card_data){
				$this->session->set_userdata('current_card_id', '');
				$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			}
			
			$this->data['my_all_cards'] = $this->cards_model->get_my_all_cards();
			
            $this->load->view('card-profile',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

    public function details()
	{
		if ($this->ion_auth->logged_in())
		{
			$this->data['page_title'] = 'Contact Details - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();

			if($this->uri->segment(3) && is_numeric($this->uri->segment(3)) && !$this->ion_auth->in_group(3)){
				$this->session->set_userdata('current_card_id', $this->uri->segment(3));
			}

			$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			if(!$card_data){
				$this->session->set_userdata('current_card_id', '');
				$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			}
			
			$this->data['my_all_cards'] = $this->cards_model->get_my_all_cards();
			
            $this->load->view('card-contact-details',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}


	
	public function save()
	{
		if ($this->ion_auth->logged_in())
		{
			$this->form_validation->set_rules('card_id', 'card ID', 'trim|required|is_numeric|strip_tags|xss_clean');

			$this->form_validation->set_rules('changes_type', 'changes type', 'trim|required|strip_tags|xss_clean');
			
			if($this->input->post('changes_type') == 'theme'){
				$this->form_validation->set_rules('theme_name', 'Theme', 'trim|required|strip_tags|xss_clean');
				$this->form_validation->set_rules('card_bg_type', 'Theme Backgoud Type', 'trim|required|strip_tags|xss_clean');
	
				if($this->input->post('card_bg_type') == 'Color'){
					$this->form_validation->set_rules('theme_color', 'Theme Color', 'trim|required|strip_tags|xss_clean');
				}
			}

			if($this->input->post('changes_type') == 'profile'){
				$this->form_validation->set_rules('slug', 'slug', 'trim|required|strip_tags|xss_clean|create_slug');
				$this->form_validation->set_rules('title', 'title', 'trim|required|strip_tags|xss_clean');
				$this->form_validation->set_rules('sub_title', 'sub title', 'trim|required|strip_tags|xss_clean');
				$this->form_validation->set_rules('short_description', 'short description', 'trim|required|strip_tags|xss_clean');
				$this->form_validation->set_rules('google_analytics', 'google analytics', 'xss_clean');
			}

			if($this->input->post('changes_type') == 'details'){
				$this->form_validation->set_rules('mobile', 'mobile', 'trim|xss_clean');
				$this->form_validation->set_rules('email', 'email', 'trim|xss_clean');
				$this->form_validation->set_rules('whatsapp', 'whatsapp', 'trim|xss_clean');
				$this->form_validation->set_rules('website', 'website', 'trim|xss_clean');
				$this->form_validation->set_rules('address_url', 'address url', 'trim|xss_clean');
				$this->form_validation->set_rules('address', 'address', 'trim|xss_clean');
				$this->form_validation->set_rules('icon[]', 'icon', 'trim|xss_clean');
				$this->form_validation->set_rules('text[]', 'text', 'trim|xss_clean');
				$this->form_validation->set_rules('url[]', 'url', 'trim|xss_clean');
			}

			if($this->form_validation->run() == TRUE){
				$data = array();
				if($this->input->post('changes_type') == 'theme'){
					$data['user_id'] = $this->session->userdata('user_id');
					$data['theme_name'] = $this->input->post('theme_name');
					$data['card_bg_type'] = $this->input->post('card_bg_type');
					$data['card_bg'] = $this->input->post('theme_color');
					$data['hide_branding'] = $this->input->post('hide_branding');

					$upload_path = 'assets/uploads/card-bg/';
					if(!is_dir($upload_path)){
						mkdir($upload_path,0775,true);
					}

					if($this->input->post('card_bg_type') == 'Image'){
						if (!empty($_FILES['theme_image']['name'])){

							$image = time().'-'.str_replace(' ', '-', $_FILES["theme_image"]['name']);
							$config['upload_path']          = $upload_path;
							$config['allowed_types']        = "gif|jpg|png|jpeg";
							$config['overwrite']             = false;
							$config['max_size']             = 0;
							$config['max_width']            = 0;
							$config['max_height']           = 0;
							$config['file_name']           = $image;
							$this->load->library('upload', $config);
							if($this->upload->do_upload('theme_image')){
								$data['card_bg'] = $image;
								if($this->input->post('old_theme_image') != ''){
									$unlink_path = $upload_path.''.$this->input->post('old_theme_image');
									if(file_exists($unlink_path)){
										unlink($unlink_path);
									}
								}
							}else{
								$this->data['error'] = true;
								$this->data['message'] = $this->upload->display_errors();
								echo json_encode($this->data); 
								return false;
							}
						}else{
							$data['card_bg'] = $this->input->post('old_theme_image') != ""?$this->input->post('old_theme_image'):$this->input->post('theme_color');
						}
					}else{
						if($this->input->post('old_theme_image') != ''){
							$unlink_path = $upload_path.''.$this->input->post('old_theme_image');
							if(file_exists($unlink_path)){
								unlink($unlink_path);
							}
						}
					}
				}
				
				if($this->input->post('changes_type') == 'profile'){
					
					if(slug_unique($this->input->post('slug'), $this->input->post('card_id'))){
						$this->data['error'] = true;
						$this->data['message'] = $this->lang->line('slug_already_exists')?htmlspecialchars($this->lang->line('slug_already_exists')):'Slug already exists. Try another one.';
						echo json_encode($this->data); 
						return false;
					}

					if (!empty($_FILES['profile']['name'])){
						$upload_path = 'assets/uploads/card-profile/';
						if(!is_dir($upload_path)){
							mkdir($upload_path,0775,true);
						}
						$image = time().'-'.str_replace(' ', '-', $_FILES["profile"]['name']);
						$config['upload_path']          = $upload_path;
						$config['allowed_types']        = "gif|jpg|png|jpeg";
						$config['overwrite']             = false;
						$config['max_size']             = 0;
						$config['max_width']            = 0;
						$config['max_height']           = 0;
						$config['file_name']           = $image;
						$this->load->library('upload', $config);
						if($this->upload->do_upload('profile')){
							$data['profile'] = $image;
							if($this->input->post('old_profile') != ''){
								$unlink_path = $upload_path.''.$this->input->post('old_profile');
								if(file_exists($unlink_path)){
									unlink($unlink_path);
								}
							}
						}else{
							$this->data['error'] = true;
							$this->data['message'] = $this->upload->display_errors();
							echo json_encode($this->data); 
							return false;
						}
					}else{
						$data['profile'] = $this->input->post('old_profile') != ""?$this->input->post('old_profile'):'';
					}

					if (!empty($_FILES['banner']['name'])){
						$upload_path = 'assets/uploads/card-banner/';
						if(!is_dir($upload_path)){
							mkdir($upload_path,0775,true);
						}
						$image = time().'-'.str_replace(' ', '-', $_FILES["banner"]['name']);
						$config['upload_path']          = $upload_path;
						$config['allowed_types']        = "gif|jpg|png|jpeg";
						$config['overwrite']             = false;
						$config['max_size']             = 0;
						$config['max_width']            = 0;
						$config['max_height']           = 0;
						$config['file_name']           = $image;
						$this->load->library('upload', $config);
						if($this->upload->do_upload('banner')){
							$data['banner'] = $image;
							if($this->input->post('old_banner') != ''){
								$unlink_path = $upload_path.''.$this->input->post('old_banner');
								if(file_exists($unlink_path)){
									unlink($unlink_path);
								}
							}
						}else{
							$this->data['error'] = true;
							$this->data['message'] = $this->upload->display_errors();
							echo json_encode($this->data); 
							return false;
						}
					}else{
						$data['banner'] = $this->input->post('old_banner') != ""?$this->input->post('old_banner'):'';
					}

					if($this->input->post('create') == 'yes'){
						$data['user_id'] = $this->session->userdata('user_id');
						$data['saas_id'] = $this->session->userdata('saas_id');
					}

					$data['slug'] = $this->input->post('slug');
					$data['title'] = $this->input->post('title');
					$data['sub_title'] = $this->input->post('sub_title');
					$data['description'] = $this->input->post('short_description');
					$data['google_analytics'] = $this->input->post('google_analytics') != ''?$this->input->post('google_analytics'):'';
				}

				if($this->input->post('changes_type') == 'details'){
					$data_optional = array();
					$data_optional['icon'] = $this->input->post('icon');
					$data_optional['text'] = $this->input->post('text');
					$data_optional['url'] = $this->input->post('url');
					$data_mandatory['mobile'] = $this->input->post('mobile');
					$data_mandatory['email'] = $this->input->post('email');
					$data_mandatory['whatsapp'] = $this->input->post('whatsapp');
					$data_mandatory['website'] = $this->input->post('website');
					$data_mandatory['address'] = $this->input->post('address');
					$data_mandatory['address_url'] = $this->input->post('address_url');
					$data_json['optional'] = $data_optional;
					$data_json['mandatory'] = $data_mandatory;
					$data['social_options'] = json_encode($data_json);
				}
				
				if($this->cards_model->save($this->input->post('card_id'), $this->session->userdata('user_id'), $data)){
					$this->session->set_flashdata('message', $this->lang->line('changes_successfully_saved')?$this->lang->line('changes_successfully_saved'):"Changes successfully saved.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('changes_successfully_saved')?$this->lang->line('changes_successfully_saved'):"Changes successfully saved.";
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

	public function products()
	{
		if ($this->ion_auth->logged_in() && is_module_allowed('products_services'))
		{
			$this->data['page_title'] = 'Products and Services - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();

			if($this->uri->segment(3) && is_numeric($this->uri->segment(3)) && !$this->ion_auth->in_group(3)){
				$this->session->set_userdata('current_card_id', $this->uri->segment(3));
			}

			$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			if(!$card_data){
				$this->session->set_userdata('current_card_id', '');
				$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			}

			$this->data['my_all_cards'] = $this->cards_model->get_my_all_cards();
			
            $this->load->view('card-products',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function create_product()
	{
		if ($this->ion_auth->logged_in())
		{
			
			$this->form_validation->set_rules('card_id', 'card ID', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('title', 'title', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('price', 'price', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('description', 'description', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('url', 'url', 'trim|xss_clean');

			if($this->form_validation->run() == TRUE){
				$data = array();
				
				if (!empty($_FILES['image']['name'])){
					$upload_path = 'assets/uploads/product-image/';
					if(!is_dir($upload_path)){
						mkdir($upload_path,0775,true);
					}
					$image = time().'-'.str_replace(' ', '-', $_FILES["image"]['name']);
					$config['upload_path']          = $upload_path;
					$config['allowed_types']        = "gif|jpg|png|jpeg";
					$config['overwrite']             = false;
					$config['max_size']             = 0;
					$config['max_width']            = 0;
					$config['max_height']           = 0;
					$config['file_name']           = $image;
					$this->load->library('upload', $config);
					if($this->upload->do_upload('image')){
						$data['image'] = $image;
					}else{
						$this->data['error'] = true;
						$this->data['message'] = $this->upload->display_errors();
						echo json_encode($this->data); 
						return false;
					}
				}

				$data['saas_id'] = $this->session->userdata('saas_id');
				$data['user_id'] = $this->session->userdata('user_id');
				$data['card_id'] = $this->input->post('card_id');
				$data['title'] = $this->input->post('title');
				$data['price'] = $this->input->post('price');
				$data['description'] = $this->input->post('description');
				
				if($this->input->post('url') == 'custom'){
					$data['url'] = $this->input->post('custom_url');
				}else{
					$data['url'] = $this->input->post('url');
				}
				
				if($this->cards_model->create_product($data)){
					$this->session->set_flashdata('message', $this->lang->line('created_successfully')?$this->lang->line('created_successfully'):"Created successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('created_successfully')?$this->lang->line('created_successfully'):"Created successfully.";
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


	public function edit_product()
	{
		if ($this->ion_auth->logged_in())
		{
			
			$this->form_validation->set_rules('update_id', 'id', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('card_id', 'card ID', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('title', 'title', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('price', 'price', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('description', 'description', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('url', 'url', 'trim|xss_clean');

			if($this->form_validation->run() == TRUE){
				$data = array();
				
				if (!empty($_FILES['image']['name'])){
					$upload_path = 'assets/uploads/product-image/';
					if(!is_dir($upload_path)){
						mkdir($upload_path,0775,true);
					}
					$image = time().'-'.str_replace(' ', '-', $_FILES["image"]['name']);
					$config['upload_path']          = $upload_path;
					$config['allowed_types']        = "gif|jpg|png|jpeg";
					$config['overwrite']             = false;
					$config['max_size']             = 0;
					$config['max_width']            = 0;
					$config['max_height']           = 0;
					$config['file_name']           = $image;
					$this->load->library('upload', $config);
					if($this->upload->do_upload('image')){
						$data['image'] = $image;
						if($this->input->post('old_image') != ''){
							$unlink_path = $upload_path.''.$this->input->post('old_image');
							if(file_exists($unlink_path)){
								unlink($unlink_path);
							}
						}
					}else{
						$this->data['error'] = true;
						$this->data['message'] = $this->upload->display_errors();
						echo json_encode($this->data); 
						return false;
					}
				}else{
					$data['image'] = $this->input->post('old_image') != ""?$this->input->post('old_image'):'';
				}

				$data['saas_id'] = $this->session->userdata('saas_id');
				$data['user_id'] = $this->session->userdata('user_id');
				$data['card_id'] = $this->input->post('card_id');
				$data['title'] = $this->input->post('title');
				$data['price'] = $this->input->post('price');
				$data['description'] = $this->input->post('description');

				if($this->input->post('url') == 'custom'){
					$data['url'] = $this->input->post('custom_url');
				}else{
					$data['url'] = $this->input->post('url');
				}
				
				if($this->cards_model->edit_product($this->input->post('update_id'), $data)){
					$this->session->set_flashdata('message', $this->lang->line('changes_successfully_saved')?$this->lang->line('changes_successfully_saved'):"Changes successfully saved.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('changes_successfully_saved')?$this->lang->line('changes_successfully_saved'):"Changes successfully saved.";
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

	
	public function get_products($id = '')
	{
		if ($this->ion_auth->logged_in())
		{
            $products = $this->cards_model->get_products($id);
			$temp = array();
			if($products){
				foreach($products as $key => $product){
					$temp[$key] = $product;

					if($product['url'] != ''){
						$temp[$key]['url'] = '<a href="'.$product['url'].'" target="_blank">'.$product['url'].'</a>';
					}

					if($product['image'] != ''){
						$temp[$key]['image'] = '<a href="'.base_url('assets/uploads/product-image/'.$product['image']).'" target="_blank"><img style="width: 49px;" alt="image" src="'.base_url('assets/uploads/product-image/'.$product['image']).'"></a>';
					}

					$temp[$key]['action'] = '<span class="d-flex">
						<a href="#" class="btn btn-icon btn-sm btn-success modal-edit-product mr-1" data-id="'.$product["id"].'" data-toggle="tooltip" title="Edit"><i class="fas fa-pen"></i></a>
						
						<a href="#" class="btn btn-icon btn-sm btn-danger delete_product" data-id="'.$product["id"].'" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a></span>';	
				}
				return print_r(json_encode($temp));
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	public function delete_product($id='')
	{
		if ($this->ion_auth->logged_in())
		{
			if(empty($id)){
				$id = $this->uri->segment(4)?$this->uri->segment(4):'';
			}

			if(!empty($id) && is_numeric($id) && $this->cards_model->delete_product($id)){

				$this->session->set_flashdata('message', $this->lang->line('deleted_successfully')?$this->lang->line('deleted_successfully'):"Deleted successfully.");
				$this->session->set_flashdata('message_type', 'success');

				$this->data['error'] = false;
				$this->data['message'] = $this->lang->line('deleted_successfully')?$this->lang->line('deleted_successfully'):"Deleted successfully.";
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

	public function ajax_get_product_by_id($id='')
	{	
		$id = !empty($id)?$id:$this->input->post('id');
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id))
		{
			$products = $this->cards_model->get_products($id);
			if(!empty($products)){
				$this->data['error'] = false;
				$this->data['data'] = $products;
				$this->data['message'] = 'Successful';
				echo json_encode($this->data);
			}else{
				$this->data['error'] = true;
				$this->data['message'] = 'Nothing found.';
				echo json_encode($this->data);
			}
		}else{
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data);
		}
	}

	public function gallery()
	{
		if ($this->ion_auth->logged_in() && is_module_allowed('products_services'))
		{
			$this->data['page_title'] = 'Gallery - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();

			if($this->uri->segment(3) && is_numeric($this->uri->segment(3)) && !$this->ion_auth->in_group(3)){
				$this->session->set_userdata('current_card_id', $this->uri->segment(3));
			}

			$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			if(!$card_data){
				$this->session->set_userdata('current_card_id', '');
				$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			}

			$this->data['my_all_cards'] = $this->cards_model->get_my_all_cards();
			
            $this->load->view('card-gallery',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}
	
	
	public function create_gallery()
	{
		if ($this->ion_auth->logged_in())
		{
			
			$this->form_validation->set_rules('card_id', 'card ID', 'trim|required|strip_tags|xss_clean');
			// $this->form_validation->set_rules('title', 'title', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('content_type', 'content type', 'trim|required|strip_tags|xss_clean');

			if($this->input->post('content_type') != 'upload'){
				$this->form_validation->set_rules('url', 'url', 'trim|required|strip_tags|xss_clean');
			}

			if($this->input->post('content_type') == 'upload' && empty($_FILES['image']['name'])){
				$this->form_validation->set_rules('image', 'image', 'trim|required|strip_tags|xss_clean');
			}
			
			if($this->form_validation->run() == TRUE){
				$data = array();
				
				if ($this->input->post('content_type') == 'upload' && !empty($_FILES['image']['name'])){
					$upload_path = 'assets/uploads/product-image/';
					if(!is_dir($upload_path)){
						mkdir($upload_path,0775,true);
					}
					$image = time().'-'.str_replace(' ', '-', $_FILES["image"]['name']);
					$config['upload_path']          = $upload_path;
					$config['allowed_types']        = "gif|jpg|png|jpeg";
					$config['overwrite']             = false;
					$config['max_size']             = 0;
					$config['max_width']            = 0;
					$config['max_height']           = 0;
					$config['file_name']           = $image;
					$this->load->library('upload', $config);
					if($this->upload->do_upload('image')){
						$data['url'] = $image;
					}else{
						$this->data['error'] = true;
						$this->data['message'] = $this->upload->display_errors();
						echo json_encode($this->data); 
						return false;
					}
				}

				$data['saas_id'] = $this->session->userdata('saas_id');
				$data['user_id'] = $this->session->userdata('user_id');
				$data['card_id'] = $this->input->post('card_id');
				$data['title'] = 'gallery';
				$data['content_type'] = $this->input->post('content_type');
				
				if(!isset($data['url'])){
					$data['url'] = $this->input->post('url');
				}
				
				if($this->input->post('content_type') == 'vimeo' && $data['url'] != ''){
					if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $this->input->post('url'), $output_array)) {
						$data['url'] = 'http://player.vimeo.com/video/'.$output_array[5];
					}
				}

				if($this->cards_model->create_gallery($data)){
					$this->session->set_flashdata('message', $this->lang->line('created_successfully')?$this->lang->line('created_successfully'):"Created successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('created_successfully')?$this->lang->line('created_successfully'):"Created successfully.";
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

	public function edit_gallery()
	{
		if ($this->ion_auth->logged_in())
		{
			
			$this->form_validation->set_rules('update_id', 'id', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('card_id', 'card ID', 'trim|required|strip_tags|xss_clean');
			// $this->form_validation->set_rules('title', 'title', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('content_type', 'content type', 'trim|required|strip_tags|xss_clean');

			if($this->input->post('content_type') != 'upload'){
				$this->form_validation->set_rules('url', 'url', 'trim|required|strip_tags|xss_clean');
			}

			if($this->input->post('content_type') == 'upload' && $this->input->post('old_image') == "" && empty($_FILES['image']['name'])){
				$this->form_validation->set_rules('image', 'image', 'trim|required|strip_tags|xss_clean');
			}

			if($this->form_validation->run() == TRUE){
				$data = array();
				
				if ($this->input->post('content_type') == 'upload' && !empty($_FILES['image']['name'])){
					$upload_path = 'assets/uploads/product-image/';
					if(!is_dir($upload_path)){
						mkdir($upload_path,0775,true);
					}
					$image = time().'-'.str_replace(' ', '-', $_FILES["image"]['name']);
					$config['upload_path']          = $upload_path;
					$config['allowed_types']        = "gif|jpg|png|jpeg";
					$config['overwrite']             = false;
					$config['max_size']             = 0;
					$config['max_width']            = 0;
					$config['max_height']           = 0;
					$config['file_name']           = $image;
					$this->load->library('upload', $config);
					if($this->upload->do_upload('image')){
						$data['url'] = $image;
						if($this->input->post('old_image') != ''){
							$unlink_path = $upload_path.''.$this->input->post('old_image');
							if(file_exists($unlink_path)){
								unlink($unlink_path);
							}
						}
					}else{
						$this->data['error'] = true;
						$this->data['message'] = $this->upload->display_errors();
						echo json_encode($this->data); 
						return false;
					}
				}else{
					$data['url'] = $this->input->post('old_image') != ""?$this->input->post('old_image'):'';
				}

				$data['saas_id'] = $this->session->userdata('saas_id');
				$data['user_id'] = $this->session->userdata('user_id');
				$data['card_id'] = $this->input->post('card_id');
				$data['title'] = 'gallery';
				$data['content_type'] = $this->input->post('content_type');
				
				if(isset($data['url']) && $data['url'] == ''){
					$data['url'] = $this->input->post('url');
				}
				
				if($this->input->post('content_type') == 'vimeo' && $data['url'] != ''){
					if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $this->input->post('url'), $output_array)) {
						$data['url'] = 'http://player.vimeo.com/video/'.$output_array[5];
					}
				}

				if($this->cards_model->edit_gallery($this->input->post('update_id'), $data)){
					$this->session->set_flashdata('message', $this->lang->line('changes_successfully_saved')?$this->lang->line('changes_successfully_saved'):"Changes successfully saved.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('changes_successfully_saved')?$this->lang->line('changes_successfully_saved'):"Changes successfully saved.";
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

	public function get_gallery($id = '')
	{
		if ($this->ion_auth->logged_in())
		{
            $products = $this->cards_model->get_gallery($id);
			$temp = array();
			if($products){
				foreach($products as $key => $product){
					$temp[$key] = $product;

					$temp[$key]['url'] = '<a href="'.$product['url'].'" target="_blank">'.$product['url'].'</a>';

					if($product['url'] != '' && $product['content_type'] == 'upload'){

						$temp[$key]['preview'] = '<a href="'.base_url('assets/uploads/product-image/'.$product['url']).'" target="_blank"><img style="width: 49px;" alt="image" src="'.base_url('assets/uploads/product-image/'.$product['url']).'"></a>';

						$temp[$key]['content_type'] = $this->lang->line('upload_image')?htmlspecialchars($this->lang->line('upload_image')):'Upload Image';

						$temp[$key]['url'] = '<a href="'.base_url('assets/uploads/product-image/'.$product['url']).'" target="_blank">'.base_url('assets/uploads/product-image/'.$product['url']).'</a>';

					}elseif($product['content_type'] == 'youtube'){
						$temp[$key]['preview'] = '<a href="'.$product['url'].'" target="_blank"><img style="width: 49px;" alt="image" src="'.base_url('assets/img/video-thumbnail.png').'"></a>';
						$temp[$key]['content_type'] = $this->lang->line('youtube')?htmlspecialchars($this->lang->line('youtube')):'YouTube';
					}elseif($product['content_type'] == 'vimeo'){
						$temp[$key]['preview'] = '<a href="'.$product['url'].'" target="_blank"><img style="width: 49px;" alt="image" src="'.base_url('assets/img/video-thumbnail.png').'"></a>';
						$temp[$key]['content_type'] = $this->lang->line('vimeo')?htmlspecialchars($this->lang->line('vimeo')):'Vimeo';
					}else{
						$temp[$key]['preview'] = '<a href="'.$product['url'].'" target="_blank"><img style="width: 49px;" alt="image" src="'.$product['url'].'"></a>';
						$temp[$key]['content_type'] = $this->lang->line('custom_image_url')?htmlspecialchars($this->lang->line('custom_image_url')):'Custom Image URL';
					}

					$temp[$key]['action'] = '<span class="d-flex">
						<a href="#" class="btn btn-icon btn-sm btn-success modal-edit-gallery mr-1" data-id="'.$product["id"].'" data-toggle="tooltip" title="Edit"><i class="fas fa-pen"></i></a>
						
						<a href="#" class="btn btn-icon btn-sm btn-danger delete_gallery" data-id="'.$product["id"].'" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a></span>';	
				}
				return print_r(json_encode($temp));
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	public function delete_gallery($id='')
	{
		if ($this->ion_auth->logged_in())
		{
			if(empty($id)){
				$id = $this->uri->segment(4)?$this->uri->segment(4):'';
			}

			if(!empty($id) && is_numeric($id) && $this->cards_model->delete_gallery($id)){

				$this->session->set_flashdata('message', $this->lang->line('deleted_successfully')?$this->lang->line('deleted_successfully'):"Deleted successfully.");
				$this->session->set_flashdata('message_type', 'success');

				$this->data['error'] = false;
				$this->data['message'] = $this->lang->line('deleted_successfully')?$this->lang->line('deleted_successfully'):"Deleted successfully.";
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
	
	public function ajax_get_gallery_by_id($id='')
	{	
		$id = !empty($id)?$id:$this->input->post('id');
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id))
		{
			$gallery = $this->cards_model->get_gallery($id);
			if(!empty($gallery)){
				$this->data['error'] = false;
				$this->data['data'] = $gallery;
				$this->data['message'] = 'Successful';
				echo json_encode($this->data);
			}else{
				$this->data['error'] = true;
				$this->data['message'] = 'Nothing found.';
				echo json_encode($this->data);
			}
		}else{
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data);
		}
	}



	public function portfolio()
	{
		if ($this->ion_auth->logged_in() && is_module_allowed('portfolio'))
		{
			$this->data['page_title'] = 'Portfolio - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();			
						
			if($this->uri->segment(3) && is_numeric($this->uri->segment(3)) && !$this->ion_auth->in_group(3)){
				$this->session->set_userdata('current_card_id', $this->uri->segment(3));
			}

			$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			if(!$card_data){
				$this->session->set_userdata('current_card_id', '');
				$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			}

			$this->data['my_all_cards'] = $this->cards_model->get_my_all_cards();
			
            $this->load->view('card-portfolio',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function create_portfolio()
	{
		if ($this->ion_auth->logged_in())
		{
			
			$this->form_validation->set_rules('card_id', 'card ID', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('title', 'title', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('description', 'description', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('url', 'url', 'trim|xss_clean');

			if($this->form_validation->run() == TRUE){
				$data = array();
				
				if (!empty($_FILES['image']['name'])){
					$upload_path = 'assets/uploads/product-image/';
					if(!is_dir($upload_path)){
						mkdir($upload_path,0775,true);
					}
					$image = time().'-'.str_replace(' ', '-', $_FILES["image"]['name']);
					$config['upload_path']          = $upload_path;
					$config['allowed_types']        = "gif|jpg|png|jpeg";
					$config['overwrite']             = false;
					$config['max_size']             = 0;
					$config['max_width']            = 0;
					$config['max_height']           = 0;
					$config['file_name']           = $image;
					$this->load->library('upload', $config);
					if($this->upload->do_upload('image')){
						$data['image'] = $image;
					}else{
						$this->data['error'] = true;
						$this->data['message'] = $this->upload->display_errors();
						echo json_encode($this->data); 
						return false;
					}
				}

				$data['saas_id'] = $this->session->userdata('saas_id');
				$data['user_id'] = $this->session->userdata('user_id');
				$data['card_id'] = $this->input->post('card_id');
				$data['title'] = $this->input->post('title');
				$data['description'] = $this->input->post('description');
				
				if($this->input->post('url') == 'custom'){
					$data['url'] = $this->input->post('custom_url');
				}else{
					$data['url'] = $this->input->post('url');
				}
				
				if($this->cards_model->create_portfolio($data)){
					$this->session->set_flashdata('message', $this->lang->line('created_successfully')?$this->lang->line('created_successfully'):"Created successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('created_successfully')?$this->lang->line('created_successfully'):"Created successfully.";
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


	public function edit_portfolio()
	{
		if ($this->ion_auth->logged_in())
		{
			
			$this->form_validation->set_rules('update_id', 'id', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('card_id', 'card ID', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('title', 'title', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('description', 'description', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('url', 'url', 'trim|xss_clean');

			if($this->form_validation->run() == TRUE){
				$data = array();
				
				if (!empty($_FILES['image']['name'])){
					$upload_path = 'assets/uploads/product-image/';
					if(!is_dir($upload_path)){
						mkdir($upload_path,0775,true);
					}
					$image = time().'-'.str_replace(' ', '-', $_FILES["image"]['name']);
					$config['upload_path']          = $upload_path;
					$config['allowed_types']        = "gif|jpg|png|jpeg";
					$config['overwrite']             = false;
					$config['max_size']             = 0;
					$config['max_width']            = 0;
					$config['max_height']           = 0;
					$config['file_name']           = $image;
					$this->load->library('upload', $config);
					if($this->upload->do_upload('image')){
						$data['image'] = $image;
						if($this->input->post('old_image') != ''){
							$unlink_path = $upload_path.''.$this->input->post('old_image');
							if(file_exists($unlink_path)){
								unlink($unlink_path);
							}
						}
					}else{
						$this->data['error'] = true;
						$this->data['message'] = $this->upload->display_errors();
						echo json_encode($this->data); 
						return false;
					}
				}else{
					$data['image'] = $this->input->post('old_image') != ""?$this->input->post('old_image'):'';
				}

				$data['saas_id'] = $this->session->userdata('saas_id');
				$data['user_id'] = $this->session->userdata('user_id');
				$data['card_id'] = $this->input->post('card_id');
				$data['title'] = $this->input->post('title');
				$data['description'] = $this->input->post('description');

				if($this->input->post('url') == 'custom'){
					$data['url'] = $this->input->post('custom_url');
				}else{
					$data['url'] = $this->input->post('url');
				}
				
				if($this->cards_model->edit_portfolio($this->input->post('update_id'), $data)){
					$this->session->set_flashdata('message', $this->lang->line('changes_successfully_saved')?$this->lang->line('changes_successfully_saved'):"Changes successfully saved.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('changes_successfully_saved')?$this->lang->line('changes_successfully_saved'):"Changes successfully saved.";
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

	
	public function get_portfolio($id = '')
	{
		if ($this->ion_auth->logged_in())
		{
            $products = $this->cards_model->get_portfolio($id);
			$temp = array();
			if($products){
				foreach($products as $key => $product){
					$temp[$key] = $product;

					if($product['url'] != ''){
						$temp[$key]['url'] = '<a href="'.$product['url'].'" target="_blank">'.$product['url'].'</a>';
					}

					if($product['image'] != ''){
						$temp[$key]['image'] = '<a href="'.base_url('assets/uploads/product-image/'.$product['image']).'" target="_blank"><img style="width: 49px;" alt="image" src="'.base_url('assets/uploads/product-image/'.$product['image']).'"></a>';
					}

					$temp[$key]['action'] = '<span class="d-flex">
						<a href="#" class="btn btn-icon btn-sm btn-success modal-edit-portfolio mr-1" data-id="'.$product["id"].'" data-toggle="tooltip" title="Edit"><i class="fas fa-pen"></i></a>
						
						<a href="#" class="btn btn-icon btn-sm btn-danger delete_portfolio" data-id="'.$product["id"].'" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a></span>';	
				}
				return print_r(json_encode($temp));
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	public function delete_portfolio($id='')
	{
		if ($this->ion_auth->logged_in())
		{
			if(empty($id)){
				$id = $this->uri->segment(4)?$this->uri->segment(4):'';
			}

			if(!empty($id) && is_numeric($id) && $this->cards_model->delete_portfolio($id)){

				$this->session->set_flashdata('message', $this->lang->line('deleted_successfully')?$this->lang->line('deleted_successfully'):"Deleted successfully.");
				$this->session->set_flashdata('message_type', 'success');

				$this->data['error'] = false;
				$this->data['message'] = $this->lang->line('deleted_successfully')?$this->lang->line('deleted_successfully'):"Deleted successfully.";
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

	public function ajax_get_portfolio_by_id($id='')
	{	
		$id = !empty($id)?$id:$this->input->post('id');
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id))
		{
			$portfolio = $this->cards_model->get_portfolio($id);
			if(!empty($portfolio)){
				$this->data['error'] = false;
				$this->data['data'] = $portfolio;
				$this->data['message'] = 'Successful';
				echo json_encode($this->data);
			}else{
				$this->data['error'] = true;
				$this->data['message'] = 'Nothing found.';
				echo json_encode($this->data);
			}
		}else{
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data);
		}
	}

	
	public function testimonials()
	{
		if ($this->ion_auth->logged_in() && is_module_allowed('testimonials'))
		{
			$this->data['page_title'] = 'Testimonials - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();			
			
			if($this->uri->segment(3) && is_numeric($this->uri->segment(3)) && !$this->ion_auth->in_group(3)){
				$this->session->set_userdata('current_card_id', $this->uri->segment(3));
			}

			$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			if(!$card_data){
				$this->session->set_userdata('current_card_id', '');
				$this->data['card'] = $card_data = $this->cards_model->get_card_by_ids($this->session->userdata('current_card_id'), $this->session->userdata('user_id'));

			}

			$this->data['my_all_cards'] = $this->cards_model->get_my_all_cards();
			
            $this->load->view('card-testimonials',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function create_testimonials()
	{
		if ($this->ion_auth->logged_in())
		{
			
			$this->form_validation->set_rules('card_id', 'card ID', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('title', 'title', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('description', 'description', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('rating', 'rating', 'trim|required|strip_tags|xss_clean');

			if($this->form_validation->run() == TRUE){
				$data = array();
				
				if (!empty($_FILES['image']['name'])){
					$upload_path = 'assets/uploads/product-image/';
					if(!is_dir($upload_path)){
						mkdir($upload_path,0775,true);
					}
					$image = time().'-'.str_replace(' ', '-', $_FILES["image"]['name']);
					$config['upload_path']          = $upload_path;
					$config['allowed_types']        = "gif|jpg|png|jpeg";
					$config['overwrite']             = false;
					$config['max_size']             = 0;
					$config['max_width']            = 0;
					$config['max_height']           = 0;
					$config['file_name']           = $image;
					$this->load->library('upload', $config);
					if($this->upload->do_upload('image')){
						$data['image'] = $image;
					}else{
						$this->data['error'] = true;
						$this->data['message'] = $this->upload->display_errors();
						echo json_encode($this->data); 
						return false;
					}
				}

				$data['saas_id'] = $this->session->userdata('saas_id');
				$data['user_id'] = $this->session->userdata('user_id');
				$data['card_id'] = $this->input->post('card_id');
				$data['title'] = $this->input->post('title');
				$data['description'] = $this->input->post('description');
				$data['rating'] = $this->input->post('rating');
				
				
				if($this->cards_model->create_testimonials($data)){
					$this->session->set_flashdata('message', $this->lang->line('created_successfully')?$this->lang->line('created_successfully'):"Created successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('created_successfully')?$this->lang->line('created_successfully'):"Created successfully.";
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


	public function edit_testimonials()
	{
		if ($this->ion_auth->logged_in())
		{
			
			$this->form_validation->set_rules('update_id', 'id', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('card_id', 'card ID', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('title', 'title', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('description', 'description', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('rating', 'rating', 'trim|required|strip_tags|xss_clean');

			if($this->form_validation->run() == TRUE){
				$data = array();
				
				if (!empty($_FILES['image']['name'])){
					$upload_path = 'assets/uploads/product-image/';
					if(!is_dir($upload_path)){
						mkdir($upload_path,0775,true);
					}
					$image = time().'-'.str_replace(' ', '-', $_FILES["image"]['name']);
					$config['upload_path']          = $upload_path;
					$config['allowed_types']        = "gif|jpg|png|jpeg";
					$config['overwrite']             = false;
					$config['max_size']             = 0;
					$config['max_width']            = 0;
					$config['max_height']           = 0;
					$config['file_name']           = $image;
					$this->load->library('upload', $config);
					if($this->upload->do_upload('image')){
						$data['image'] = $image;
						if($this->input->post('old_image') != ''){
							$unlink_path = $upload_path.''.$this->input->post('old_image');
							if(file_exists($unlink_path)){
								unlink($unlink_path);
							}
						}
					}else{
						$this->data['error'] = true;
						$this->data['message'] = $this->upload->display_errors();
						echo json_encode($this->data); 
						return false;
					}
				}else{
					$data['image'] = $this->input->post('old_image') != ""?$this->input->post('old_image'):'';
				}

				$data['saas_id'] = $this->session->userdata('saas_id');
				$data['user_id'] = $this->session->userdata('user_id');
				$data['card_id'] = $this->input->post('card_id');
				$data['title'] = $this->input->post('title');
				$data['description'] = $this->input->post('description');
				$data['rating'] = $this->input->post('rating');

				if($this->cards_model->edit_testimonials($this->input->post('update_id'), $data)){
					$this->session->set_flashdata('message', $this->lang->line('changes_successfully_saved')?$this->lang->line('changes_successfully_saved'):"Changes successfully saved.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('changes_successfully_saved')?$this->lang->line('changes_successfully_saved'):"Changes successfully saved.";
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

	public function get_testimonials($id = '')
	{
		if ($this->ion_auth->logged_in())
		{
            $products = $this->cards_model->get_testimonials($id);
			$temp = array();
			if($products){
				foreach($products as $key => $product){
					$temp[$key] = $product;

					if($product['image'] != ''){
						$temp[$key]['image'] = '<a href="'.base_url('assets/uploads/product-image/'.$product['image']).'" target="_blank"><img style="width: 49px;" alt="image" src="'.base_url('assets/uploads/product-image/'.$product['image']).'"></a>';
					}

					$temp[$key]['rating'] = '<i class="'.($product['rating']>=1?'fas':'far').' fa-star"></i>
					<i class="'.($product['rating']>=2?'fas':'far').' fa-star"></i>
					<i class="'.($product['rating']>=3?'fas':'far').' fa-star"></i>
					<i class="'.($product['rating']>=4?'fas':'far').' fa-star"></i>
					<i class="'.($product['rating']>=5?'fas':'far').' fa-star"></i>';

					$temp[$key]['action'] = '<span class="d-flex">
						<a href="#" class="btn btn-icon btn-sm btn-success modal-edit-testimonials mr-1" data-id="'.$product["id"].'" data-toggle="tooltip" title="Edit"><i class="fas fa-pen"></i></a>
						
						<a href="#" class="btn btn-icon btn-sm btn-danger delete_testimonials" data-id="'.$product["id"].'" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a></span>';	
				}
				return print_r(json_encode($temp));
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	public function ajax_get_testimonials_by_id($id='')
	{	
		$id = !empty($id)?$id:$this->input->post('id');
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id))
		{
			$testimonials = $this->cards_model->get_testimonials($id);
			if(!empty($testimonials)){
				$this->data['error'] = false;
				$this->data['data'] = $testimonials;
				$this->data['message'] = 'Successful';
				echo json_encode($this->data);
			}else{
				$this->data['error'] = true;
				$this->data['message'] = 'Nothing found.';
				echo json_encode($this->data);
			}
		}else{
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data);
		}
	}

	public function delete_testimonials($id='')
	{
		if ($this->ion_auth->logged_in())
		{
			if(empty($id)){
				$id = $this->uri->segment(4)?$this->uri->segment(4):'';
			}

			if(!empty($id) && is_numeric($id) && $this->cards_model->delete_testimonials($id)){
				$this->session->set_flashdata('message', $this->lang->line('deleted_successfully')?$this->lang->line('deleted_successfully'):"Deleted successfully.");
				$this->session->set_flashdata('message_type', 'success');

				$this->data['error'] = false;
				$this->data['message'] = $this->lang->line('deleted_successfully')?$this->lang->line('deleted_successfully'):"Deleted successfully.";
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

	public function send_mail()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|strip_tags|xss_clean|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('msg', 'Message', 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('user_email', 'card email', 'trim|required|strip_tags|xss_clean');
		if($this->form_validation->run() == TRUE){
			try{
				$body = "Name: ".$this->input->post('name')." <br> Email: ".$this->input->post('email')." <br> Mobile: ".$this->input->post('mobile')." <br> ".$this->input->post('msg');

				send_mail($this->input->post('user_email'), 'Enquiry form submited from your vCard', $body);

			}catch(Exception $e){

			}
			
			$this->data['error'] = false;
			$this->data['message'] = $this->lang->line('we_will_get_back_to_you_soon')?$this->lang->line('we_will_get_back_to_you_soon'):"We will get back to you soon.";
			echo json_encode($this->data); 
			return false;
		}else{
			$this->data['error'] = true;
			$this->data['message'] = validation_errors();
			echo json_encode($this->data); 
			return false;
		}
	}

}
