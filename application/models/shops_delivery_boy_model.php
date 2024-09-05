<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class shops_delivery_boy_model extends CI_Model
{
    public function delivery_boys($limit=null,$start=null)
    {
        $data['user'] = $user =  $this->checkShopLogin();
        $shop_id     = $user->id;
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*')
        ->from('delivery_boys t1')      
        ->where('t1.is_deleted','NOT_DELETED')
        ->where('t1.shop_id',$shop_id)
        ->order_by('t1.added','desc');
        if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->like('t1.name', $_POST['search']);
			$this->db->or_like('t1.contact_number', $_POST['search']);
		}
        if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();
		return $this->db->get()->result();
    }
    public function delivery_boy($id)
    {
        $query = $this->db
        ->select('t1.*')
        ->from('delivery_boys t1')       
		->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])    
        ->get();
		return $query->row();
    }

    function checkCookie(){
        $loggedin = false;
        if (get_cookie('63a490ed05b42') && get_cookie('63a490ed05b43') && get_cookie('63a490ed05b44')) {
            $user_id = value_encryption(get_cookie('63a490ed05b42'),'decrypt');
            $user_nm = value_encryption(get_cookie('63a490ed05b43'),'decrypt');
            if (is_numeric($user_id) && !is_numeric($user_nm)) {
                $loggedin = true;
            }
        }

        if ($loggedin) {
            return true;
        }
        else{
            delete_cookie('63a490ed05b42');	
            delete_cookie('63a490ed05b43');	
            delete_cookie('63a490ed05b44');	
            delete_cookie('63a490ed05b45');	
            redirect(base_url().'');
        }
    }
    
        function checkShopLogin(){
            $loggedin = false;
            if (get_cookie('63a490ed05b42') && get_cookie('63a490ed05b43') && get_cookie('63a490ed05b44')) {
                $user_id = value_encryption(get_cookie('63a490ed05b42'),'decrypt');
                $user_nm = value_encryption(get_cookie('63a490ed05b43'),'decrypt');
                $type    = value_encryption(get_cookie('63a490ed05b44'),'decrypt');
                if (is_numeric($user_id) && !empty($user_nm)) {
                    $check['id'] 	   = $user_id;
                    $check['contact'] = $user_nm;
                    if ($type=='shop') {
                        // $user = $this->admin_model->getRow('admin',$check);
                        $CI =& get_instance();
                       $user = $CI->db->get_where('shops',$check)->row();
                      
                    }
                    else{
                        $user = false;
                    }
                    
                    if ($user) {
                        if ($user->isActive==1) {
                            $user->type = $type;
                            $loggedin = true;
                        }
                    }
                    
                }
                
            }
            if ($loggedin) {
                return $user;
            }
            else{
                
                delete_cookie('63a490ed05b42');	
                delete_cookie('63a490ed05b43');	
                delete_cookie('63a490ed05b44');	
                delete_cookie('63a490ed05b45');	
                redirect(base_url().'');
            }
        }

}
?>