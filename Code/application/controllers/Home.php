<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->ion_auth->logged_in())
		{
			$this->data['page_title'] = 'Dashboard - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->data['system_users'] = $this->ion_auth->users(array(1,2,4))->result();
			
			if($this->ion_auth->in_group(3)){
				$this->data['plans'] = $this->plans_model->get_plans();
				$this->data['transaction_chart'] = $this->plans_model->get_transaction_chart();
				$this->load->view('saas-home',$this->data);
			}else{
				
				$this->data['card'] = $this->cards_model->get_card_by_ids('', $this->session->userdata('user_id'));
				$this->data['demo'] = $this->cards_model->get_card_by_ids('', 1);
			
				$this->load->view('home',$this->data);
			}

			
		}else{
			redirect('auth', 'refresh');
		}
	}

}
