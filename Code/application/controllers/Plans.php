<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plans extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
	}

	public function create_session($plan_id = '')
	{	
		$stripeSecret = get_stripe_secret_key();
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin() && $stripeSecret)
		{
			if(empty($plan_id)){
				$plan_id = $this->uri->segment(3)?$this->uri->segment(3):'';
			}
			if(!empty($plan_id) || is_numeric($plan_id)){
				$plan = $this->plans_model->get_plans($plan_id);
				if($plan){
					require_once('vendor/stripe/stripe-php/init.php');
					
					\Stripe\Stripe::setApiKey($stripeSecret);
					$session = \Stripe\Checkout\Session::create([
						'payment_method_types' => ['card'],
						'line_items' => [[
						'price_data' => [
							'currency' => get_saas_currency('currency_code'),
							'product_data' => [
							'name' => $plan[0]['title'],
							],
							'unit_amount' => $plan[0]['price']*100,
						],
						'quantity' => 1,
						]],
						'metadata' => [
							'plan_id' => $plan_id,
						],
						'mode' => 'payment',
						'success_url' => base_url().'plans/stripe-order-completed?session_id={CHECKOUT_SESSION_ID}',
						'cancel_url' => base_url().'plans/stripe-order-completed?session_id={CHECKOUT_SESSION_ID}',
					]);
					$data = array('id' => $session->id, 'data' => $session);
					echo json_encode($data);
				}else{
					$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
					echo json_encode($this->data);
				}
			}else{
				$this->data['error'] = true;
				$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
				echo json_encode($this->data);
			}
		}else{
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
			echo json_encode($this->data);
		}
	}

	public function index()
	{	
		if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || $this->ion_auth->in_group(3)))
		{
			if ($this->ion_auth->is_admin()){
				$this->notifications_model->edit('', 'offline_request', '', '', '');
			}
			$this->data['page_title'] = 'Subscription Plans - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->data['plans'] = $this->plans_model->get_plans();
			$this->load->view('plans',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function stripe_order_completed()
	{	
		$stripeSecret = get_stripe_secret_key();
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin() && $stripeSecret)
		{
			if(isset($_GET['session_id']) && $_GET['session_id'] != ''){
				require_once('vendor/stripe/stripe-php/init.php');
				$stripe = new \Stripe\StripeClient($stripeSecret);
				try{
					$payment_details = $stripe->checkout->sessions->retrieve($_GET['session_id']);
					if($payment_details->payment_status == 'paid'){
						$plan = $this->plans_model->get_plans($payment_details->metadata->plan_id);
						if($plan){
							if($plan[0]['price'] > 0){
								$transaction_data = array(
									'saas_id' => $this->session->userdata('saas_id'),			
									'amount' => $plan[0]['price'],		
									'status' => 1,		
								);

								$transaction_id = $this->plans_model->create_transaction($transaction_data);

								$order_data = array(
									'saas_id' => $this->session->userdata('saas_id'),		
									'plan_id' => $payment_details->metadata->plan_id,		
									'transaction_id' => $transaction_id,			
								);
								$order_id = $this->plans_model->create_order($order_data);
							}
							
							$dt = strtotime(date("Y-m-d"));
							if($plan[0]['billing_type'] == "One Time"){
								$date = NULL;
							}elseif($plan[0]['billing_type'] == "Monthly"){
								$date = date("Y-m-d", strtotime("+1 month", $dt));
							}elseif($plan[0]['billing_type'] == "Yearly"){
								$date = date("Y-m-d", strtotime("+1 year", $dt));
							}elseif($plan[0]['billing_type'] == "three_days_trial_plan"){
								$date = date("Y-m-d", strtotime("+3 days", $dt));
							}elseif($plan[0]['billing_type'] == "seven_days_trial_plan"){
								$date = date("Y-m-d", strtotime("+7 days", $dt));
							}elseif($plan[0]['billing_type'] == "fifteen_days_trial_plan"){
								$date = date("Y-m-d", strtotime("+15 days", $dt));
							}elseif($plan[0]['billing_type'] == "thirty_days_trial_plan"){
								$date = date("Y-m-d", strtotime("+1 month", $dt));
							}else{
								$date = date("Y-m-d", strtotime("+3 days", $dt));
							}

							$my_plan = get_current_plan();
							if($my_plan){
								if($my_plan['expired'] == 1){
									if($my_plan['plan_id'] == 1 && $my_plan['plan_id'] == $payment_details->metadata->plan_id){
										$date = date("Y-m-d", strtotime("+3 days", $dt));
										if($plan[0]['billing_type'] == "One Time"){
											$date = NULL;
										}
									}else{

										if(empty($my_plan['end_date'])){
											$dt = strtotime(date("Y-m-d"));
										}else{
											$dt = strtotime($my_plan['end_date']);
										}

										if($plan[0]['billing_type'] == "One Time"){
											$date = NULL;
										}elseif($plan[0]['billing_type'] == "Monthly"){
											$date = date("Y-m-d", strtotime("+1 month", $dt));
										}elseif($plan[0]['billing_type'] == "Yearly"){
											$date = date("Y-m-d", strtotime("+1 year", $dt));
										}elseif($plan[0]['billing_type'] == "three_days_trial_plan"){
											$date = date("Y-m-d", strtotime("+3 days", $dt));
										}elseif($plan[0]['billing_type'] == "seven_days_trial_plan"){
											$date = date("Y-m-d", strtotime("+7 days", $dt));
										}elseif($plan[0]['billing_type'] == "fifteen_days_trial_plan"){
											$date = date("Y-m-d", strtotime("+15 days", $dt));
										}elseif($plan[0]['billing_type'] == "thirty_days_trial_plan"){
											$date = date("Y-m-d", strtotime("+1 month", $dt));
										}else{
											$date = date("Y-m-d", strtotime("+3 days", $dt));
										}
									}
								}
								$users_plans_data = array(
									'plan_id' => $payment_details->metadata->plan_id,		
									'expired' => 1,		
									'start_date' => date("Y-m-d"),			
									'end_date' => $date,			
								);
								$users_plans_id = $this->plans_model->update_users_plans($this->session->userdata('saas_id'), $users_plans_data);
							}else{
								$users_plans_data = array(	
									'expired' => 1,				
									'plan_id' => $payment_details->metadata->plan_id,		
									'start_date' => date("Y-m-d"),			
									'end_date' => $date,			
								);
								$users_plans_id = $this->plans_model->update_users_plans($this->session->userdata('saas_id'), $users_plans_data);
							}
							
							if($users_plans_id){

								// notification to the saas admins
								$saas_admins = $this->ion_auth->users(array(3))->result();
								foreach($saas_admins as $saas_admin){
									$data = array(
										'notification' => '<span class="text-info">'.$plan[0]['title'].'</span>',
										'type' => 'new_plan',	
										'type_id' => $payment_details->metadata->plan_id,	
										'from_id' => $this->session->userdata('saas_id'),
										'to_id' => $saas_admin->user_id,	
									);
									$notification_id = $this->notifications_model->create($data);
								}

								$this->session->set_flashdata('message', $this->lang->line('plan_subscribed_successfully')?$this->lang->line('plan_subscribed_successfully'):"Plan subscribed successfully.");
								$this->session->set_flashdata('message_type', 'success');
							}else{
								$this->session->set_flashdata('message', $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.");
								$this->session->set_flashdata('message_type', 'success');
							}
						}else{
							$this->session->set_flashdata('message', $this->lang->line('choose_valid_subscription_plan')?$this->lang->line('choose_valid_subscription_plan'):"Choose valid subscription plan.");
							$this->session->set_flashdata('message_type', 'success');
						}
					}else{
						$this->session->set_flashdata('message', $this->lang->line('payment_unsuccessful_please_try_again_later')?$this->lang->line('payment_unsuccessful_please_try_again_later'):"Payment unsuccessful. Please Try again later.");
						$this->session->set_flashdata('message_type', 'success');
					}
				}catch(Exception $e){
					$this->session->set_flashdata('message', $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.");
					$this->session->set_flashdata('message_type', 'success');
				}
			}else{
				$this->session->set_flashdata('message', $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.");
				$this->session->set_flashdata('message_type', 'success');
			}
			redirect('plans', 'refresh');
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function orders()
	{	
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->notifications_model->edit('', 'new_plan', '', '', '');
			$this->data['page_title'] = 'Subscription Orders - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->load->view('orders',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

	public function transactions()
	{	
		if ($this->ion_auth->logged_in())
		{
			$this->data['page_title'] = 'Transactions - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->load->view('transactions',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}
	public function get_transactions($transaction_id = '')
	{
		if ($this->ion_auth->logged_in())
		{
			$transactions = $this->plans_model->get_transactions($transaction_id);
			if($transactions){
				foreach($transactions as $key => $transaction){
					$temp[$key] = $transaction;
					$temp[$key]['user'] = $transaction['first_name']." ".$transaction['last_name'];
					$temp[$key]['created'] = format_date($transaction['created'],system_date_format());

					if($transaction['status']==1){
						$temp[$key]['status'] = '<div class="badge badge-success">'.($this->lang->line('completed')?$this->lang->line('completed'):'Completed').'</div>';
					}else{
						$temp[$key]['status'] = '<div class="badge badge-danger">'.($this->lang->line('rejected')?$this->lang->line('rejected'):'Rejected').'</div>';
					}
				}

				return print_r(json_encode($temp));
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	public function get_orders($order_id = '')
	{
		if ($this->ion_auth->logged_in())
		{
			$orders = $this->plans_model->get_orders($order_id);
			if($orders){
				foreach($orders as $key => $order){
					$temp[$key] = $order;
					$temp[$key]['user'] = $order['first_name']." ".$order['last_name'];

					if($order["billing_type"] == 'One Time'){
						$temp[$key]['billing_type'] = $this->lang->line('one_time')?$this->lang->line('one_time'):'One Time';
					}elseif($order["billing_type"] == 'Monthly'){
						$temp[$key]['billing_type'] = $this->lang->line('monthly')?$this->lang->line('monthly'):'Monthly';
					}elseif($order["billing_type"] == 'three_days_trial_plan'){
						$temp[$key]['billing_type'] = $this->lang->line('three_days_trial_plan')?htmlspecialchars($this->lang->line('three_days_trial_plan')):'3 days trial plan';
					}elseif($order["billing_type"] == 'seven_days_trial_plan'){
						$temp[$key]['billing_type'] = $this->lang->line('seven_days_trial_plan')?htmlspecialchars($this->lang->line('seven_days_trial_plan')):'7 days trial plan';
					}elseif($order["billing_type"] == 'fifteen_days_trial_plan'){
						$temp[$key]['billing_type'] = $this->lang->line('fifteen_days_trial_plan')?htmlspecialchars($this->lang->line('fifteen_days_trial_plan')):'15 days trial plan';
					}elseif($order["billing_type"] == 'thirty_days_trial_plan'){
						$temp[$key]['billing_type'] = $this->lang->line('thirty_days_trial_plan')?htmlspecialchars($this->lang->line('thirty_days_trial_plan')):'30 days trial plan';
					}else{
						$temp[$key]['billing_type'] = $this->lang->line('yearly')?$this->lang->line('yearly'):'Yearly';
					}

					if($order['status']==1){
						$temp[$key]['status'] = '<div class="badge badge-success">'.($this->lang->line('completed')?$this->lang->line('completed'):'Completed').'</div>';
					}else{
						$temp[$key]['status'] = '<div class="badge badge-danger">'.($this->lang->line('rejected')?$this->lang->line('rejected'):'Rejected').'</div>';
					}

					$temp[$key]['created'] = format_date($order['created'],system_date_format());
				}

				return print_r(json_encode($temp));
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	public function get_offline_requests($id = '')
	{
		if ($this->ion_auth->logged_in())
		{
			$offline_requests = $this->plans_model->get_offline_requests($id);
			if($offline_requests){
				foreach($offline_requests as $key => $offline_request){
					$temp[$key] = $offline_request;
					$temp[$key]['user'] = $offline_request['first_name']." ".$offline_request['last_name'];
					$temp[$key]['created'] = format_date($offline_request['created'],system_date_format());
					
					if($offline_request['status']==0){
						$temp[$key]['status'] = '<div class="badge badge-info">'.($this->lang->line('pending')?$this->lang->line('pending'):'Pending').'</div>';
						$temp[$key]['action'] = '<span class="d-flex"><a href="#" class="btn btn-icon btn-sm btn-success mr-1 accept_request" data-id="'.$offline_request["id"].'" data-plan_id="'.$offline_request["plan_id"].'" data-saas_id="'.$offline_request["saas_id"].'" data-toggle="tooltip" title="Accept Request"><i class="fas fa-check"></i></a><a href="#" class="btn btn-icon btn-sm btn-danger reject_request" data-id="'.$offline_request["id"].'" data-plan_id="'.$offline_request["plan_id"].'" data-toggle="tooltip" title="Reject Request"><i class="fas fa-times"></i></a></span>';
					}elseif($offline_request['status']==1){
						$temp[$key]['status'] = '<div class="badge badge-success">'.($this->lang->line('accepted')?$this->lang->line('accepted'):'Accepted').'</div>';
						$temp[$key]['action'] = '<span class="d-flex"><a href="#" class="disabled btn btn-icon btn-sm btn-success mr-1" data-toggle="tooltip" title="Accept Request"><i class="fas fa-check"></i></a><a href="#" class="disabled btn btn-icon btn-sm btn-danger" data-toggle="tooltip" title="Reject Request"><i class="fas fa-times"></i></a></span>';
					}else{
						$temp[$key]['status'] = '<div class="badge badge-danger">'.($this->lang->line('rejected')?$this->lang->line('rejected'):'Rejected').'</div>';
						$temp[$key]['action'] = '<span class="d-flex"><a href="#" class="disabled btn btn-icon btn-sm btn-success mr-1" data-toggle="tooltip" title="Accept Request"><i class="fas fa-check"></i></a><a href="#" class="disabled btn btn-icon btn-sm btn-danger" data-toggle="tooltip" title="Reject Request"><i class="fas fa-times"></i></a></span>';
					}
				}
				return print_r(json_encode($temp));
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	public function offline_requests()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->notifications_model->edit('', 'offline_request', '', '', '');
			$this->data['page_title'] = 'Offline Requests - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->load->view('offline_requests',$this->data);

		}else{
			redirect('auth', 'refresh'); 
		}
		
	}

	public function reject_request()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->form_validation->set_rules('id', 'Request ID', 'trim|required|strip_tags|xss_clean|is_numeric');
			if($this->form_validation->run() == TRUE){
				$data = array(
					'status' => 2,			
				);
				if($this->plans_model->accept_reject_request($this->input->post('id'), $data)){
					$this->session->set_flashdata('message', $this->lang->line('offline_request_rejected_successfully')?$this->lang->line('offline_request_rejected_successfully'):"Offline request rejected successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('offline_request_rejected_successfully')?$this->lang->line('offline_request_rejected_successfully'):"Offline request rejected successfully.";
					echo json_encode($this->data); 
				}else{
					$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
					echo json_encode($this->data);
				}
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

	public function accept_request()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->form_validation->set_rules('id', 'Request ID', 'trim|required|strip_tags|xss_clean|is_numeric');
			$this->form_validation->set_rules('saas_id', 'SaaS ID', 'trim|required|strip_tags|xss_clean|is_numeric');
			$this->form_validation->set_rules('plan_id', 'Plan ID', 'trim|required|strip_tags|xss_clean|is_numeric');
			if($this->form_validation->run() == TRUE){
				$data = array(
					'status' => 1,			
				);
				if($this->plans_model->accept_reject_request($this->input->post('id'), $data)){

					$plan = $this->plans_model->get_plans($this->input->post('plan_id'));
					if($plan[0]['price'] > 0){
						$transaction_data = array(
							'saas_id' => $this->input->post('saas_id'),			
							'amount' => $plan[0]['price'],		
							'status' => 1,		
						);
	
						$transaction_id = $this->plans_model->create_transaction($transaction_data);
	
						$order_data = array(
							'saas_id' => $this->input->post('saas_id'),			
							'plan_id' => $this->input->post('plan_id'),		
							'transaction_id' => $transaction_id,			
						);
						$order_id = $this->plans_model->create_order($order_data);
					}
					
					$dt = strtotime(date("Y-m-d"));
					if($plan[0]['billing_type'] == "One Time"){
						$date = NULL;
					}elseif($plan[0]['billing_type'] == "Monthly"){
						$date = date("Y-m-d", strtotime("+1 month", $dt));
					}elseif($plan[0]['billing_type'] == "Yearly"){
						$date = date("Y-m-d", strtotime("+1 year", $dt));
					}elseif($plan[0]['billing_type'] == "three_days_trial_plan"){
						$date = date("Y-m-d", strtotime("+3 days", $dt));
					}elseif($plan[0]['billing_type'] == "seven_days_trial_plan"){
						$date = date("Y-m-d", strtotime("+7 days", $dt));
					}elseif($plan[0]['billing_type'] == "fifteen_days_trial_plan"){
						$date = date("Y-m-d", strtotime("+15 days", $dt));
					}elseif($plan[0]['billing_type'] == "thirty_days_trial_plan"){
						$date = date("Y-m-d", strtotime("+1 month", $dt));
					}else{
						$date = date("Y-m-d", strtotime("+3 days", $dt));
					}
	
					$my_plan = get_current_plan();
					if($my_plan){
						if($my_plan['expired'] == 1 && $my_plan['plan_id'] == $this->input->post('plan_id')){
							if($my_plan['plan_id'] == 1){
								$date = date("Y-m-d", strtotime("+3 days", $dt));
								if($plan[0]['billing_type'] == "One Time"){
									$date = NULL;
								}
							}else{

								if(empty($my_plan['end_date'])){
									$dt = strtotime(date("Y-m-d"));
								}else{
									$dt = strtotime($my_plan['end_date']);
								}

								if($plan[0]['billing_type'] == "One Time"){
									$date = NULL;
								}elseif($plan[0]['billing_type'] == "Monthly"){
									$date = date("Y-m-d", strtotime("+1 month", $dt));
								}elseif($plan[0]['billing_type'] == "Yearly"){
									$date = date("Y-m-d", strtotime("+1 year", $dt));
								}elseif($plan[0]['billing_type'] == "three_days_trial_plan"){
									$date = date("Y-m-d", strtotime("+3 days", $dt));
								}elseif($plan[0]['billing_type'] == "seven_days_trial_plan"){
									$date = date("Y-m-d", strtotime("+7 days", $dt));
								}elseif($plan[0]['billing_type'] == "fifteen_days_trial_plan"){
									$date = date("Y-m-d", strtotime("+15 days", $dt));
								}elseif($plan[0]['billing_type'] == "thirty_days_trial_plan"){
									$date = date("Y-m-d", strtotime("+1 month", $dt));
								}else{
									$date = date("Y-m-d", strtotime("+3 days", $dt));
								}
							}
						}
						$users_plans_data = array(
							'plan_id' => $this->input->post('plan_id'),		
							'expired' => 1,		
							'start_date' => date("Y-m-d"),			
							'end_date' => $date,			
						);
						$users_plans_id = $this->plans_model->update_users_plans($this->input->post('saas_id'), $users_plans_data);
					}else{
						$users_plans_data = array(		
							'expired' => 1,				
							'plan_id' => $this->input->post('plan_id'),		
							'start_date' => date("Y-m-d"),			
							'end_date' => $date,			
						);

						$users_plans_id = $this->plans_model->update_users_plans($this->input->post('saas_id'), $users_plans_data);
					}

					if($users_plans_id){

						// notification to the creator admin

						$plan = $this->plans_model->get_plans($this->input->post('plan_id'));
						$plan_name = '';
						if($plan){
							$plan_name = $plan[0]['title'];
						}
						$notification_data = array(
							'notification' => '<span class="text-info">'.$plan_name.'</span>',
							'type' => 'offline_request',	
							'type_id' => $this->input->post('plan_id'),	
							'from_id' => $this->session->userdata('user_id'),
							'to_id' => $this->input->post('saas_id'),	
						);
						$this->notifications_model->create($notification_data);

						$this->session->set_flashdata('message', $this->lang->line('offline_request_accepted_successfully')?$this->lang->line('offline_request_accepted_successfully'):"Offline request accepted successfully.");
						$this->session->set_flashdata('message_type', 'success');
						$this->data['error'] = false;
						$this->data['message'] = $this->lang->line('offline_request_accepted_successfully')?$this->lang->line('offline_request_accepted_successfully'):"Offline request accepted successfully.";
						echo json_encode($this->data); 
					}else{
						$this->data['error'] = true;
						$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
						echo json_encode($this->data);
					}
				}else{
					$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
					echo json_encode($this->data);
				}
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

	public function create_offline_request()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$this->form_validation->set_rules('plan_id', 'Plan ID', 'trim|required|strip_tags|xss_clean|is_numeric');
			if($this->form_validation->run() == TRUE){
				$data = array(
					'saas_id' => $this->session->userdata('saas_id'),			
					'plan_id' => $this->input->post('plan_id'),			
				);
				$offline_request_id = $this->plans_model->create_offline_request($data);
				if($offline_request_id){

					// notification to the saas admins
					$saas_admins = $this->ion_auth->users(array(3))->result();
					$plan = $this->plans_model->get_plans($this->input->post('plan_id'));
					$plan_name = '';
					if($plan){
						$plan_name = $plan[0]['title'];
					}
					foreach($saas_admins as $saas_admin){
						$notification_data = array(
							'notification' => '<span class="text-info">'.$plan_name.'</span>',
							'type' => 'offline_request',	
							'type_id' => $this->input->post('plan_id'),	
							'from_id' => $this->session->userdata('saas_id'),
							'to_id' => $saas_admin->user_id,	
						);
						$this->notifications_model->create($notification_data);
					}

					$this->session->set_flashdata('message', $this->lang->line('offline_bank_transfer_request_sent_successfully')?$this->lang->line('offline_bank_transfer_request_sent_successfully'):"Offline / Bank Transfer request sent successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('offline_bank_transfer_request_sent_successfully')?$this->lang->line('offline_bank_transfer_request_sent_successfully'):"Offline / Bank Transfer request sent successfully.";
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


	public function order_completed()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || $this->ion_auth->in_group(3)))
		{
			$this->form_validation->set_rules('status', 'Status', 'trim|strip_tags|xss_clean|is_numeric');
			$this->form_validation->set_rules('plan_id', 'Plan ID', 'trim|required|strip_tags|xss_clean|is_numeric');

			$plan = $this->plans_model->get_plans($this->input->post('plan_id'));
			if($this->form_validation->run() == TRUE && $plan){
				if($plan[0]['price'] > 0){
					$transaction_data = array(
						'saas_id' => $this->session->userdata('saas_id'),			
						'amount' => $plan[0]['price'],		
						'status' => $this->input->post('status')?$this->input->post('status'):0,		
					);

					$transaction_id = $this->plans_model->create_transaction($transaction_data);

					$order_data = array(
						'saas_id' => $this->session->userdata('saas_id'),		
						'plan_id' => $this->input->post('plan_id'),		
						'transaction_id' => $transaction_id,			
					);
					$order_id = $this->plans_model->create_order($order_data);
				}
				
				$dt = strtotime(date("Y-m-d"));
				if($plan[0]['billing_type'] == "One Time"){
					$date = NULL;
				}elseif($plan[0]['billing_type'] == "Monthly"){
					$date = date("Y-m-d", strtotime("+1 month", $dt));
				}elseif($plan[0]['billing_type'] == "Yearly"){
					$date = date("Y-m-d", strtotime("+1 year", $dt));
				}elseif($plan[0]['billing_type'] == "three_days_trial_plan"){
					$date = date("Y-m-d", strtotime("+3 days", $dt));
				}elseif($plan[0]['billing_type'] == "seven_days_trial_plan"){
					$date = date("Y-m-d", strtotime("+7 days", $dt));
				}elseif($plan[0]['billing_type'] == "fifteen_days_trial_plan"){
					$date = date("Y-m-d", strtotime("+15 days", $dt));
				}elseif($plan[0]['billing_type'] == "thirty_days_trial_plan"){
					$date = date("Y-m-d", strtotime("+1 month", $dt));
				}else{
					$date = date("Y-m-d", strtotime("+3 days", $dt));
				}

				$my_plan = get_current_plan();
				if($my_plan){
					if($my_plan['expired'] == 1 && $my_plan['plan_id'] == $this->input->post('plan_id')){
						if($my_plan['plan_id'] == 1){
							$date = date("Y-m-d", strtotime("+3 days", $dt));
							if($plan[0]['billing_type'] == "One Time"){
								$date = NULL;
							}
						}else{
							
							if(empty($my_plan['end_date'])){
								$dt = strtotime(date("Y-m-d"));
							}else{
								$dt = strtotime($my_plan['end_date']);
							}

							if($plan[0]['billing_type'] == "One Time"){
								$date = NULL;
							}elseif($plan[0]['billing_type'] == "Monthly"){
								$date = date("Y-m-d", strtotime("+1 month", $dt));
							}elseif($plan[0]['billing_type'] == "Yearly"){
								$date = date("Y-m-d", strtotime("+1 year", $dt));
							}elseif($plan[0]['billing_type'] == "three_days_trial_plan"){
								$date = date("Y-m-d", strtotime("+3 days", $dt));
							}elseif($plan[0]['billing_type'] == "seven_days_trial_plan"){
								$date = date("Y-m-d", strtotime("+7 days", $dt));
							}elseif($plan[0]['billing_type'] == "fifteen_days_trial_plan"){
								$date = date("Y-m-d", strtotime("+15 days", $dt));
							}elseif($plan[0]['billing_type'] == "thirty_days_trial_plan"){
								$date = date("Y-m-d", strtotime("+1 month", $dt));
							}else{
								$date = date("Y-m-d", strtotime("+3 days", $dt));
							}
						}
					}
					$users_plans_data = array(
						'plan_id' => $this->input->post('plan_id'),		
						'expired' => 1,		
						'start_date' => date("Y-m-d"),			
						'end_date' => $date,			
					);
					$users_plans_id = $this->plans_model->update_users_plans($this->session->userdata('saas_id'), $users_plans_data);
				}else{
					$users_plans_data = array(	
						'expired' => 1,				
						'plan_id' => $this->input->post('plan_id'),		
						'start_date' => date("Y-m-d"),			
						'end_date' => $date,			
					);

					$users_plans_id = $this->plans_model->update_users_plans($this->session->userdata('saas_id'), $users_plans_data);
				}
				
				if($users_plans_id){
					
					// notification to the saas admins
					$saas_admins = $this->ion_auth->users(array(3))->result();
					foreach($saas_admins as $saas_admin){
						$data = array(
							'notification' => '<span class="text-info">'.$plan[0]['title'].'</span>',
							'type' => 'new_plan',	
							'type_id' => $this->input->post('plan_id'),	
							'from_id' => $this->session->userdata('saas_id'),
							'to_id' => $saas_admin->user_id,	
						);
						$notification_id = $this->notifications_model->create($data);
					}

					$this->session->set_flashdata('message', $this->lang->line('plan_subscribed_successfully')?$this->lang->line('plan_subscribed_successfully'):"Plan subscribed successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('plan_subscribed_successfully')?$this->lang->line('plan_subscribed_successfully'):"Plan subscribed successfully.";
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

	public function delete($id='')
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{

			if(empty($id)){
				$id = $this->uri->segment(4)?$this->uri->segment(4):'';
			}
			
			if(!empty($id) && is_numeric($id) && $this->plans_model->delete($id)){
				$this->plans_model->delete_plan_update_users_plan($id);
				$this->notifications_model->delete('', 'new_plan', $id);
				$this->notifications_model->delete('', 'offline_request', $id);
				$this->session->set_flashdata('message', $this->lang->line('plan_deleted_successfully')?$this->lang->line('plan_deleted_successfully'):"Plan deleted successfully.");
				$this->session->set_flashdata('message_type', 'success');

				$this->data['error'] = false;
				$this->data['message'] = $this->lang->line('plan_deleted_successfully')?$this->lang->line('plan_deleted_successfully'):"Plan deleted successfully.";
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

	public function validate($plan_id = '')
	{	
		if(empty($plan_id)){
			$plan_id = $this->uri->segment(3)?$this->uri->segment(3):'';
		}
		
		$plan = $this->plans_model->get_plans($plan_id);

		if(!empty($plan_id) && is_numeric($plan_id) && $plan){
			$this->data['validationError'] = false;
			$this->data['plan'] = $plan;
			$this->data['message'] = "Successfully.";
			echo json_encode($this->data);
		}else{
			$this->data['validationError'] = true;
			$this->data['message'] = "Unsuccessfully.";
			echo json_encode($this->data);
		}
		
	}

	public function edit()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->form_validation->set_rules('update_id', 'Plan ID', 'trim|required|strip_tags|xss_clean|is_numeric');
			$this->form_validation->set_rules('title', 'Title', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('price', 'Price', 'trim|required|strip_tags|xss_clean|is_numeric');
			$this->form_validation->set_rules('cards', 'vCards', 'trim|required|strip_tags|xss_clean|is_numeric');
			$this->form_validation->set_rules('billing_type', 'Billing Type', 'trim|required|strip_tags|xss_clean');
			
			if($this->form_validation->run() == TRUE){

				$modules['select_all'] = $this->input->post('select_all')?1:0;
				$modules['multiple_themes'] = $this->input->post('multiple_themes')?1:0;
				$modules['custom_fields'] = $this->input->post('custom_fields')?1:0;
				$modules['products_services'] = $this->input->post('products_services')?1:0;
				$modules['portfolio'] = $this->input->post('portfolio')?1:0;
				$modules['testimonials'] = $this->input->post('testimonials')?1:0;
				$modules['qr_code'] = $this->input->post('qr_code')?1:0;
				$modules['hide_branding'] = $this->input->post('hide_branding')?1:0;
				$modules['gallery'] = $this->input->post('gallery')?1:0;
				$modules['enquiry_form'] = $this->input->post('enquiry_form')?1:0;

				$data = array(
					'title' => $this->input->post('title'),		
					'price' => $this->input->post('price')<0?0:$this->input->post('price'),		
					'billing_type' => $this->input->post('billing_type'),	
					'cards' => $this->input->post('cards'),	
					'modules' => json_encode($modules),		
				);

				if($this->plans_model->edit($this->input->post('update_id'), $data)){
					$this->session->set_flashdata('message', $this->lang->line('plan_updated_successfully')?$this->lang->line('plan_updated_successfully'):"Plan updated successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('plan_updated_successfully')?$this->lang->line('plan_updated_successfully'):"Plan updated successfully.";
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

	public function create()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3))
		{
			$this->form_validation->set_rules('title', 'Title', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('price', 'Price', 'trim|required|strip_tags|xss_clean|is_numeric');
			$this->form_validation->set_rules('cards', 'vCards', 'trim|required|strip_tags|xss_clean|is_numeric');
			$this->form_validation->set_rules('billing_type', 'Billing Type', 'trim|required|strip_tags|xss_clean');

			if($this->form_validation->run() == TRUE){
				
				
				$modules['select_all'] = $this->input->post('select_all')?1:0;
				$modules['multiple_themes'] = $this->input->post('multiple_themes')?1:0;
				$modules['custom_fields'] = $this->input->post('custom_fields')?1:0;
				$modules['products_services'] = $this->input->post('products_services')?1:0;
				$modules['portfolio'] = $this->input->post('portfolio')?1:0;
				$modules['testimonials'] = $this->input->post('testimonials')?1:0;
				$modules['qr_code'] = $this->input->post('qr_code')?1:0;
				$modules['hide_branding'] = $this->input->post('hide_branding')?1:0;
				$modules['gallery'] = $this->input->post('gallery')?1:0;
				$modules['enquiry_form'] = $this->input->post('enquiry_form')?1:0;

				$data = array(
					'title' => $this->input->post('title'),		
					'price' => $this->input->post('price')<0?0:$this->input->post('price'),		
					'billing_type' => $this->input->post('billing_type'),		
					'cards' => $this->input->post('cards'),		
					'modules' => json_encode($modules),		
				);

				$plan_id = $this->plans_model->create($data);
				
				if($plan_id){
					$this->session->set_flashdata('message', $this->lang->line('plan_created_successfully')?$this->lang->line('plan_created_successfully'):"Plan created successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('plan_created_successfully')?$this->lang->line('plan_created_successfully'):"Plan created successfully.";
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

	public function get_plans($plan_id = '')
	{
		if ($this->ion_auth->logged_in())
		{
			$plans = $this->plans_model->get_plans($plan_id);
			if($plans){
				foreach($plans as $key => $plan){
					$temp[$key] = $plan;

					if($plan["billing_type"] == 'One Time'){
						$temp[$key]['billing_type'] = $this->lang->line('one_time')?$this->lang->line('one_time'):'One Time';
					}elseif($plan["billing_type"] == 'Monthly'){
						$temp[$key]['billing_type'] = $this->lang->line('monthly')?$this->lang->line('monthly'):'Monthly';
					}elseif($plan["billing_type"] == 'three_days_trial_plan'){
						$temp[$key]['billing_type'] = $this->lang->line('three_days_trial_plan')?htmlspecialchars($this->lang->line('three_days_trial_plan')):'3 days trial plan';
					}elseif($plan["billing_type"] == 'seven_days_trial_plan'){
						$temp[$key]['billing_type'] = $this->lang->line('seven_days_trial_plan')?htmlspecialchars($this->lang->line('seven_days_trial_plan')):'7 days trial plan';
					}elseif($plan["billing_type"] == 'fifteen_days_trial_plan'){
						$temp[$key]['billing_type'] = $this->lang->line('fifteen_days_trial_plan')?htmlspecialchars($this->lang->line('fifteen_days_trial_plan')):'15 days trial plan';
					}elseif($plan["billing_type"] == 'thirty_days_trial_plan'){
						$temp[$key]['billing_type'] = $this->lang->line('thirty_days_trial_plan')?htmlspecialchars($this->lang->line('thirty_days_trial_plan')):'30 days trial plan';
					}else{
						$temp[$key]['billing_type'] = $this->lang->line('yearly')?$this->lang->line('yearly'):'Yearly';
					}

					if($plan["cards"] > 0){
						$cards_count = $plan["cards"];
					}else{
						$cards_count = $this->lang->line('unlimited')?htmlspecialchars($this->lang->line('unlimited')):'Unlimited';
					}

					$modules = '';
					if($plan["modules"] != ''){
						foreach(json_decode($plan["modules"]) as $mod_key => $mod){
							$mod_name = '';

							if($mod_key == 'multiple_themes'){
								$mod_name = $this->lang->line('multiple_themes')?$this->lang->line('multiple_themes'):'Multiple Themes';
							}elseif($mod_key == 'custom_fields'){
								$mod_name = $this->lang->line('custom_fields')?$this->lang->line('custom_fields'):'Custom Fields';
							}elseif($mod_key == 'products_services'){
								$mod_name = $this->lang->line('products_services')?$this->lang->line('products_services'):'Products/Services';
							}elseif($mod_key == 'portfolio'){
								$mod_name = $this->lang->line('portfolio')?$this->lang->line('portfolio'):'Portfolio';
							}elseif($mod_key == 'testimonials'){
								$mod_name = $this->lang->line('testimonials')?$this->lang->line('testimonials'):'Testimonials';
							}elseif($mod_key == 'qr_code'){
								$mod_name = $this->lang->line('qr_code')?$this->lang->line('qr_code'):'QR Code';
							}elseif($mod_key == 'hide_branding'){
								$mod_name = $this->lang->line('hide_branding')?$this->lang->line('hide_branding'):'Hide Branding';
							}elseif($mod_key == 'gallery'){
								$mod_name = $this->lang->line('gallery')?htmlspecialchars($this->lang->line('gallery')):'Gallery';
							}elseif($mod_key == 'enquiry_form'){
								$mod_name = $this->lang->line('enquiry_form')?htmlspecialchars($this->lang->line('enquiry_form')):'Enquiry Form';
							}


							if($mod_name && $mod == 1){
								$modules .= '<div class="pricing-item d-inline-flex mb-1 mr-2">
												<div class="pricing-item-icon mr-1"><i class="fas fa-check"></i></div>
												<div class="pricing-item-label">'.$mod_name.'</div>
											</div>';
							}elseif($mod_name){
								$modules .= '<div class="pricing-item d-inline-flex mb-1 mr-2">
												<div class="pricing-item-icon bg-danger text-white mr-1"><i class="fas fa-times"></i></div>
												<div class="pricing-item-label">'.$mod_name.'</div>
											</div>';
							}
						}
					}
					$temp[$key]['modules'] = '<div class="pricing bg-transparent shadow-none m-1">
						<div class="pricing-details">
						<div class="pricing-item d-inline-flex mb-1 mr-2">
							<div class="pricing-item-icon mr-1"><i class="fas fa-check"></i></div>
							<div class="pricing-item-label">'.$cards_count.' '.($this->lang->line('vcard')?htmlspecialchars($this->lang->line('vcard')):'vCard').'</div>
						</div>
						'.$modules.'
						</div>
					</div>';

					$temp[$key]['action'] = '<span class="d-flex"><a href="#" class="btn btn-icon btn-sm btn-success modal-edit-plan mr-1" data-id="'.$plan["id"].'" data-toggle="tooltip" title="Edit Plan"><i class="fas fa-pen"></i></a><a href="#" class="btn btn-icon btn-sm btn-danger delete_plan" data-id="'.$plan["id"].'" data-toggle="tooltip" title="Delete Plan"><i class="fas fa-trash"></i></a></span>';
				}

				return print_r(json_encode($temp));
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	public function ajax_get_plan_by_id($id='')
	{	
		$id = !empty($id)?$id:$this->input->post('id');
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id))
		{
			$plans = $this->plans_model->get_plans($id);
			if(!empty($plans)){
				$this->data['error'] = false;
				$this->data['data'] = $plans;
				$this->data['message'] = 'Successful';
				echo json_encode($this->data);
			}else{
				$this->data['error'] = true;
				$this->data['message'] = 'No user found.';
				echo json_encode($this->data);
			}
		}else{
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data);
		}
	}

}







