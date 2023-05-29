<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cards_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
    }
    
    function delete_card($id = '', $user_id = ''){

        if(!$this->ion_auth->in_group(3)){
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
        }

        if($id != ''){
            $this->db->where('id', $id);
        }
        if($user_id != ''){
            $this->db->where('user_id', $user_id);
        }

        if($this->db->delete('cards'))
            return true;
        else
            return false;
    }

    function get_cards(){
 
        $offset = 0;$limit = 10;
        $sort = 'id'; $order = 'ASC';
        $where = " WHERE u.id != '' ";
        if(!$this->ion_auth->in_group(3)){
            $where .= " AND c.user_id=".$this->session->userdata('user_id');
        }
        $get = $this->input->get();
        if(isset($get['sort']))
            $sort = strip_tags($get['sort']);
        if(isset($get['offset']))
            $offset = strip_tags($get['offset']);
        if(isset($get['limit']))
            $limit = strip_tags($get['limit']);
        if(isset($get['order']))
            $order = strip_tags($get['order']);
        if(isset($get['search']) &&  !empty($get['search'])){
            $search = strip_tags($get['search']);
            $where .= " AND (u.id like '%".$search."%' OR u.first_name like '%".$search."%' OR u.last_name like '%".$search."%' OR u.email like '%".$search."%' OR c.title like '%".$search."%'  OR c.slug like '%".$search."%' OR c.theme_name like '%".$search."%' OR c.sub_title like '%".$search."%' OR c.description like '%".$search."%')";
        }
    
        $LEFT_JOIN = " LEFT JOIN cards c ON u.id=c.user_id ";
        $query = $this->db->query("SELECT COUNT('u.id') as total FROM users u $LEFT_JOIN $where");
    
        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }
        
        $query = $this->db->query("SELECT u.*,c.slug,c.title,c.sub_title,c.description,c.profile as card_profile,c.id as card_id FROM users u $LEFT_JOIN $where ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);
    
        $system_users = $query->result();   
    
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();

        foreach ($system_users as $system_user) {
            $action = '';

            $profile = '<figure class="avatar avatar-md mr-2" data-initial="'.mb_substr($system_user->first_name, 0, 1, "utf-8").''.mb_substr($system_user->last_name, 0, 1, "utf-8").'"></figure>';

            if($system_user->profile){
                if(file_exists('assets/uploads/profiles/'.$system_user->profile)){
                    $file_upload_path = 'assets/uploads/profiles/'.$system_user->profile;
                }else{
                    $file_upload_path = 'assets/uploads/f'.$system_user->saas_id.'/profiles/'.$system_user->profile;
                }
                $profile = '<img alt="image" src="'.base_url($file_upload_path).'" class="avatar avatar-md mr-2">';
            }

            $tempRow['first_name'] = '<li class="media">
            '.$profile.'
            <div>
            <div class="media-title">'.$system_user->first_name.' '.$system_user->last_name.'</div>
            <span class="text-small text-muted">'.$system_user->email.'</span>
            </div>
            </li>';

            $tempRow['title'] = '<li class="media">
                <img alt="image" src="'.(($system_user->card_profile != "" && file_exists('assets/uploads/card-profile/'.$system_user->card_profile))?base_url('assets/uploads/card-profile/'.$system_user->card_profile):base_url('assets/uploads/logos/'.half_logo())).'" class="avatar avatar-lg mr-2">
                <div>
                <div class="media-title mb-0">'.$system_user->title.'</div>
                <span class="text-small text-muted"><strong>'.$system_user->sub_title.'</strong></span><br>
                <span class="text-small text-muted">'.$system_user->description.'</span>
                </div>
            </li>';

            if(!$this->ion_auth->in_group(3)){ 
                $action = '<a href="'.base_url('cards/theme/'.$system_user->card_id).'" class="btn btn-icon btn-sm btn-success ml-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pen"></i></a><a href="#" class="btn btn-icon btn-sm btn-danger ml-1 delete-card" data-id="'.$system_user->card_id.'" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>';
            }

            $tempRow['action'] = '<span class="d-flex"><a href="'.base_url($system_user->slug).'" target="_blank" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>'.$action.'</span>';
            
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
    
    function save($id,$user_id,$data){
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('cards');
        if($query->num_rows() > 0){
            $this->db->where('id', $id);
            $this->db->where('user_id', $user_id);
            $this->db->update('cards', $data);
            return true;
        }else{
            if($this->db->insert('cards', $data)){
                return true;
            }else{
                return false;
            }
        }
    }

    function get_my_all_cards(){
        $where = " WHERE user_id=".$this->session->userdata('user_id');
        $query = $this->db->query("SELECT * FROM cards $where");
        $data = $query->result_array();
        if($data){
            return $data;
        }else{
            return false;
        }
    }

    function get_card_by_ids($id = '', $user_id = ''){
        $where = " WHERE id != '' ";
        $where .= (!empty($id) && is_numeric($id))?" AND id=$id ":"";
        $where .= (!empty($user_id) && is_numeric($user_id))?" AND user_id=$user_id ":"";
        $query = $this->db->query("SELECT * FROM cards $where");
        $data = $query->row_array();
        if($data){
            return $data;
        }else{
            return false;
        }
    }

    function get_card_by_slug($slug){
        $where = " WHERE id != '' ";
        $where .= (!empty($slug))?" AND slug='$slug' ":"";
        $query = $this->db->query("SELECT * FROM cards $where");
        $data = $query->row_array();
        if($data){
            return $data;
        }else{
            return false;
        }
    }


    function create_product($data){
        if($this->db->insert('products', $data))
            return $this->db->insert_id();
        else
            return false; 
    }

    function edit_product($id, $data){        
        if(!$this->ion_auth->in_group(3)){
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
        }
        $this->db->where('id', $id);
        if($this->db->update('products', $data))
            return true;
        else
            return false;
    }

    function delete_product($id = '', $card_id = '', $user_id = ''){        
        if(!$this->ion_auth->in_group(3)){
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
        }
        if($id != ''){
            $this->db->where('id', $id);
        }
        if($card_id != ''){
            $this->db->where('card_id', $card_id);
        }
        if($user_id != ''){
            $this->db->where('user_id', $user_id);
        }
        if($this->db->delete('products'))
            return true;
        else
            return false;
    }

    function get_products($id = '', $user_id = '', $card_id = ''){
            
        $where = " WHERE id != '' ";
        
        if($user_id != ''){
            $where .= " AND user_id=".$user_id;
        }else{
            $where .= " AND user_id=".$this->session->userdata('user_id');
        }

        if($card_id != ''){
            $where .= " AND card_id=".$card_id;
        }

        $where .= (!empty($id) && is_numeric($id))?" AND id=$id ":"";
        $get = $this->input->get();

        if(isset($get['card_id']) && !empty($get['card_id']) && is_numeric($get['card_id'])){
            $where .= " AND card_id=".$get['card_id'];
        }elseif($this->session->userdata('current_card_id') && $this->session->userdata('current_card_id') != '' && $card_id == '' && !$this->ion_auth->in_group(3)){
            $where .= " AND card_id=".$this->session->userdata('current_card_id');
        }

        if(isset($get['search']) &&  !empty($get['search'])){
            $search = strip_tags($get['search']);
            $where .= " AND (id like '%".$search."%' OR title like '%".$search."%' OR description like '%".$search."%') ";
        }

        $query = $this->db->query("SELECT * FROM products $where ORDER BY id DESC");
        $data = $query->result_array();
        if($data){
            return $data;
        }else{
            return false;
        }
    }


    function create_gallery($data){
        if($this->db->insert('gallery', $data))
            return $this->db->insert_id();
        else
            return false; 
    }

    function edit_gallery($id, $data){
        $this->db->where('id', $id);
        if($this->db->update('gallery', $data))
            return true;
        else
            return false;
    }

    function delete_gallery($id = '', $card_id = '', $user_id = ''){        
        if(!$this->ion_auth->in_group(3)){
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
        }
        if($id != ''){
            $this->db->where('id', $id);
        }
        if($card_id != ''){
            $this->db->where('card_id', $card_id);
        }
        if($user_id != ''){
            $this->db->where('user_id', $user_id);
        }
        if($this->db->delete('gallery'))
            return true;
        else
            return false;
    }

    function get_gallery($id = '', $user_id = '', $card_id = ''){
        $where = " WHERE id != '' ";
        
        if($user_id != ''){
            $where .= " AND user_id=".$user_id;
        }else{
            $where .= " AND user_id=".$this->session->userdata('user_id');
        }

        if($card_id != ''){
            $where .= " AND card_id=".$card_id;
        }

        $where .= (!empty($id) && is_numeric($id))?" AND id=$id ":"";
        $get = $this->input->get();

        if(isset($get['card_id']) && !empty($get['card_id']) && is_numeric($get['card_id'])){
            $where .= " AND card_id=".$get['card_id'];
        }elseif($this->session->userdata('current_card_id') && $this->session->userdata('current_card_id') != '' && $card_id == '' && !$this->ion_auth->in_group(3)){
            $where .= " AND card_id=".$this->session->userdata('current_card_id');
        }

        if(isset($get['search']) &&  !empty($get['search'])){
            $search = strip_tags($get['search']);
            $where .= " AND (id like '%".$search."%' OR title like '%".$search."%' OR content_type like '%".$search."%' OR url like '%".$search."%') ";
        }

        $query = $this->db->query("SELECT * FROM gallery $where ORDER BY id DESC");
        $data = $query->result_array();
        if($data){
            return $data;
        }else{
            return false;
        }
    }


    
    function create_portfolio($data){
        if($this->db->insert('portfolio', $data))
            return $this->db->insert_id();
        else
            return false; 
    }

    function edit_portfolio($id, $data){        
        if(!$this->ion_auth->in_group(3)){
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
        }
        $this->db->where('id', $id);
        if($this->db->update('portfolio', $data))
            return true;
        else
            return false;
    }

    function delete_portfolio($id = '', $card_id = '', $user_id = ''){        
        if(!$this->ion_auth->in_group(3)){
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
        }
        if($id != ''){
            $this->db->where('id', $id);
        }
        if($card_id != ''){
            $this->db->where('card_id', $card_id);
        }
        if($user_id != ''){
            $this->db->where('user_id', $user_id);
        }
        if($this->db->delete('portfolio'))
            return true;
        else
            return false;
    }

    function get_portfolio($id = '', $user_id = '', $card_id = ''){
        
        $where = " WHERE id != '' ";
        
        if($user_id != ''){
            $where .= " AND user_id=".$user_id;
        }else{
            $where .= " AND user_id=".$this->session->userdata('user_id');
        }

        if($card_id != ''){
            $where .= " AND card_id=".$card_id;
        }

        $where .= (!empty($id) && is_numeric($id))?" AND id=$id ":"";
        $get = $this->input->get();

        if(isset($get['card_id']) && !empty($get['card_id']) && is_numeric($get['card_id'])){
            $where .= " AND card_id=".$get['card_id'];
        }elseif($this->session->userdata('current_card_id') && $this->session->userdata('current_card_id') != '' && $card_id == '' && !$this->ion_auth->in_group(3)){
            $where .= " AND card_id=".$this->session->userdata('current_card_id');
        }

        if(isset($get['search']) &&  !empty($get['search'])){
            $search = strip_tags($get['search']);
            $where .= " AND (id like '%".$search."%' OR title like '%".$search."%' OR description like '%".$search."%') ";
        }

        $query = $this->db->query("SELECT * FROM portfolio $where ORDER BY id DESC");
        $data = $query->result_array();
        if($data){
            return $data;
        }else{
            return false;
        }
    }

    
    function create_testimonials($data){
        if($this->db->insert('testimonials', $data))
            return $this->db->insert_id();
        else
            return false; 
    }

    function edit_testimonials($id, $data){        
        if(!$this->ion_auth->in_group(3)){
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
        }
        $this->db->where('id', $id);
        if($this->db->update('testimonials', $data))
            return true;
        else
            return false;
    }

    function delete_testimonials($id = '', $card_id = '', $user_id = ''){        
        if(!$this->ion_auth->in_group(3)){
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
        }
        if($id != ''){
            $this->db->where('id', $id);
        }
        if($card_id != ''){
            $this->db->where('card_id', $card_id);
        }
        if($user_id != ''){
            $this->db->where('user_id', $user_id);
        }
        if($this->db->delete('testimonials'))
            return true;
        else
            return false;
    }

    function get_testimonials($id = '', $user_id = '', $card_id = ''){
        
        $where = " WHERE id != '' ";
        
        if($user_id != ''){
            $where .= " AND user_id=".$user_id;
        }else{
            $where .= " AND user_id=".$this->session->userdata('user_id');
        }

        if($card_id != ''){
            $where .= " AND card_id=".$card_id;
        }

        $where .= (!empty($id) && is_numeric($id))?" AND id=$id ":"";
        $get = $this->input->get();

        if(isset($get['card_id']) && !empty($get['card_id']) && is_numeric($get['card_id'])){
            $where .= " AND card_id=".$get['card_id'];
        }elseif($this->session->userdata('current_card_id') && $this->session->userdata('current_card_id') != '' && $card_id == '' && !$this->ion_auth->in_group(3)){
            $where .= " AND card_id=".$this->session->userdata('current_card_id');
        }

        if(isset($get['search']) &&  !empty($get['search'])){
            $search = strip_tags($get['search']);
            $where .= " AND (id like '%".$search."%' OR title like '%".$search."%' OR description like '%".$search."%' OR rating like '%".$search."%') ";
        }

        $query = $this->db->query("SELECT * FROM testimonials $where ORDER BY id DESC");
        $data = $query->result_array();
        if($data){
            return $data;
        }else{
            return false;
        }
    }

}