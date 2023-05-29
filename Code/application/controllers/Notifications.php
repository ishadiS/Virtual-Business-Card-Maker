<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
	}
	
	public function delete_by_type($id = '', $type = '', $type_id = '')
	{
		if ($this->ion_auth->logged_in())
		{
			if($this->notifications_model->delete($id, $type, $type_id)){
				return true;
			}else{
				return false;
			}

		}else{
			return false;
		}
	}

	public function delete($id='')
	{
		if ($this->ion_auth->logged_in())
		{

			if(empty($id)){
				$id = $this->uri->segment(4)?$this->uri->segment(4):'';
			}
			
			if(!empty($id) && is_numeric($id) && $this->notifications_model->delete($id)){

				$this->session->set_flashdata('message', $this->lang->line('notification_deleted_successfully')?$this->lang->line('notification_deleted_successfully'):"Notification deleted successfully.");
				$this->session->set_flashdata('message_type', 'success');

				$this->data['error'] = false;
				$this->data['message'] = $this->lang->line('notification_deleted_successfully')?$this->lang->line('notification_deleted_successfully'):"Notification deleted successfully.";
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

	public function get_notifications()
	{
		if ($this->ion_auth->logged_in())
		{
			$notifications = $this->notifications_model->get_notifications();
			if($notifications){
				foreach($notifications as $key => $notification){
					$temp[$key] = $notification;

					$extra = '';
					$notification_url = base_url('notifications');
					$notification_txt = $notification['notification'];
					if($notification['type'] == 'offline_request' && $this->ion_auth->in_group(3)){
						
						$notification_txt = $this->lang->line('offline_bank_transfer_request_created_for_subscription_plan')?$this->lang->line('offline_bank_transfer_request_created_for_subscription_plan')." ".$notification['notification']:"Offline / Bank Transfer request created for subscription plan ".$notification['notification'];
						$notification_url = base_url('plans/offline-requests');
						$plan = $this->plans_model->get_plans($notification['type_id']);
						if($plan){
							$extra = ($this->lang->line('plan')?$this->lang->line('plan'):'Plan').': <a target="_blank" href="'.base_url('plans').'">'.$plan[0]['title'].'</a>';
						}
					}elseif($notification['type'] == 'new_plan' && $this->ion_auth->in_group(3)){
						$notification_txt = $this->lang->line('ordered_subscription_plan')?$this->lang->line('ordered_subscription_plan')." ".$notification['notification']:"Ordered subscription plan ".$notification['notification'];
						$notification_url = base_url('plans/orders');
						$plan = $this->plans_model->get_plans($notification['type_id']);
						if($plan){
							$extra = ($this->lang->line('plan')?$this->lang->line('plan'):'Plan').': <a target="_blank" href="'.base_url('plans').'">'.$plan[0]['title'].'</a> ';
							$extra .= ($this->lang->line('transaction')?$this->lang->line('transaction'):'Transaction').': <a target="_blank" href="'.base_url('plans/transactions').'">$'.$plan[0]['price'].'</a> ';

							$user = $this->ion_auth->user($notification['from_id'])->row();
							if($user){
								$extra .= ($this->lang->line('user')?$this->lang->line('user'):'User').': <a target="_blank" href="'.base_url('users/saas').'">'.$user->first_name.' '.$user->last_name.'</a>';
							}

						}
					}elseif($notification['type'] == 'new_user' && $this->ion_auth->in_group(3)){
						$notification_txt = $this->lang->line('new_user_registered')?$this->lang->line('new_user_registered'):"New user registered.";
						$notification_url = base_url('users/saas');
						$user = $this->ion_auth->user($notification['type_id'])->row();
						if($user){
							$extra = ($this->lang->line('user')?$this->lang->line('user'):'User').': <a target="_blank" href="'.base_url('users/saas').'">'.$user->first_name.' '.$user->last_name.'</a>';
						}
					}elseif($notification['type'] == 'offline_request' && $this->ion_auth->is_admin()){
						$notification_txt = $this->lang->line('your_offline_bank_transfer_request_accepted_for_subscription_plan')?$this->lang->line('your_offline_bank_transfer_request_accepted_for_subscription_plan')." ".$notification['notification']:"Your Offline / Bank Transfer request accepted for subscription plan ".$notification['notification'];
						
						$notification_url = base_url('plans');
						$plan = $this->plans_model->get_plans($notification['type_id']);
						if($plan){
							$extra = ($this->lang->line('plan')?$this->lang->line('plan'):'Plan').': <a target="_blank" href="'.base_url('plans').'">'.$plan[0]['title'].'</a>';
						}
					}
					
					$temp[$key]['notification'] = '<a target="_blank" href="'.$notification_url.'"><b>'.$notification_txt.'</b></a><br>'.$extra;
					
					$temp[$key]['first_name'] = $notification['first_name']." ".$notification['last_name'];
					$temp[$key]['is_read'] = $notification['is_read']==1?'<div class="badge badge-success">Yes</div>':'<div class="badge badge-danger">No</div>';

					$temp[$key]['action'] = '<span class="d-flex"><a href="'.$notification_url.'" class="btn btn-icon btn-sm btn-primary mr-1" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a><a href="#" class="btn btn-icon btn-sm btn-danger delete_notification" data-id="'.$notification["id"].'" data-toggle="tooltip" title="Delete Notification"><i class="fas fa-trash"></i></a></span>';

					$temp[$key]['created'] = format_date($notification['created'],system_date_format());
				}

				return print_r(json_encode($temp));
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	public function index()
	{
		if ($this->ion_auth->logged_in() && is_module_allowed('notifications'))
		{
			$this->notifications_model->edit('', '', '', '', '');
			$this->data['page_title'] = 'Notifications - '.company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->load->view('notifications',$this->data);
		}else{
			redirect('auth', 'refresh');
		}
	}

}
