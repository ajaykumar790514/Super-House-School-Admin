<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offers_coupons_admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $data['user']  = $user         = checkLogin();
        $this->check_role_menu();
    }

    public function isLoggedIn(){
        $is_logged_in = $this->session->userdata('admin_logged_in');
        if(!isset($is_logged_in) || $is_logged_in!==TRUE)
        {
            redirect(base_url());
            exit;
        }
    } 
    public function check_role_menu(){
        $data['user']  = $user         = checkLogin();
        $admin_role_id = $user->role_id;
        $uri = $this->uri->segment(1);
        $role_menus = $this->admin_model->all_role_menu_data($admin_role_id);
        $url_array = array();
        if(!empty($role_menus))
        {
            foreach($role_menus as $menus)
            {
                array_push($url_array,$menus->url);
            }
            if(!in_array($uri,$url_array))
            {
                redirect(base_url());
            }
        }
        else
        {
            redirect(base_url());
            exit;
        }      
    } 

    public function header_and_footer($page, $data)
    {
        $data['user']  = $user         = checkLogin();
        $admin_role_id = $user->role_id;
        $user_id = $user->id;
        $data['dashboard'] = $this->admin_model->get_row_data('admin','id',$user_id);
        $data['admin_menus'] = $this->admin_model->get_role_menu_data($admin_role_id);
        $this->load->view('admin/includes/header',$data);
        $this->load->view($page);
        $this->load->view('admin/includes/footer');
    }

    public function index()
    {
        $data['user']  = $user         = checkLogin();
        $menu_id = $this->uri->segment(2);
        $data['menu_id'] = $menu_id;
        $role_id = $user->role_id;
        $data['sub_menus'] = $this->admin_model->get_submenu_data($menu_id,$role_id);
        $data['title'] = 'Offers';
        $page = 'admin/offers_coupons/offers_coupons_data';
        $this->header_and_footer($page, $data);
    }
    public function offers_coupons_remote($type,$id=null,$column='name')
    {
        if ($type=='offers') {
            $tb = 'coupons_and_offers';
        }
        elseif ($type=='coupons') {
            $tb ='coupons_and_offers';
        }
        
        else{

        }
        $this->db->where($column,$_GET[$column]);
        if($id!=NULL){
            $this->db->where('id != ',$id)->where('is_deleted','NOT_DELETED');
        }
        $count=$this->db->count_all_results($tb);
        if($count>0)
        {
            echo "false";
        }
        else
        {
            echo "true";
        }        
    }
    public function offers($action=null,$p1=null,$p2=null,$p3=null)
    {
        $data['user']  = $user         = checkLogin();
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Offers';
                $data['tb_url']         = base_url().'offers/tb';
                $data['new_url']        = base_url().'offers/create';
                $page                   = 'admin/offers_coupons/offers/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                $shop_id = '6';
                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }
                    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."offers/tb/";
                    $config["total_rows"]       = $this->offers_model->offers();
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 10;
                    $config["uri_segment"]      = 3;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p1!=null) ? $p1 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['offers']           = $this->offers_model->offers($config["per_page"],$page);
                    $data['update_url']         = base_url().'offers/create/';
                    $data['shop_detail'] = $this->shops_model->get_shop_detail($shop_id);
                    $page                       = 'admin/offers_coupons/offers/tb';
                    $this->load->view($page, $data);
                    break;
                
                    case 'create':
                        $data['remote']             = base_url().'offers-coupons/offers_coupons_remote/offers/';
                        $data['action_url']         = base_url().'offers/save';
                        $data['business']  = $this->offers_model->view_data('business');
                        $data['shops']  = $this->offers_model->view_data('shops');
                        $page                       = 'admin/offers_coupons/offers/create';
                        if ($p1!=null) {
                            $data['action_url']     = base_url().'offers/save/'.$p1;
                            $data['business']  = $this->offers_model->view_data('business');
                            $data['shops']  = $this->offers_model->view_data('shops');
                            $data['value']          = $this->offers_model->offer($p1);
                            $data['remote']         = base_url().'offers-coupons/offers_coupons_remote/offers/'.$p1;
                            $page                   = 'admin/offers_coupons/offers/update';
                        }
                        $this->load->view($page, $data);
                        break;

                        case 'save':
                            $id = $p1;
                            $return['res'] = 'error';
                            $return['msg'] = 'Not Saved!';
                            if ($this->input->server('REQUEST_METHOD')=='POST') {
                                if ($id!=null) {
                                    $data = array(
                                            'title'     => $this->input->post('title'),
                                            'description'              => $this->input->post('description'),
                                            'discount_type'      => $this->input->post('discount_type'),
                                            'value'        => $this->input->post('value'),
                                            'expiry_date'       => $this->input->post('expiry_date'),
                                            'start_date'       => $this->input->post('start_date'),
                                            'offer_created_by'       => $this->input->post('offer_created_by'),
                                        );
                                    if($this->offers_model->edit_offer_coupon($data,$id)){
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                        $data1 =array(
                                            'discount_type'      => $this->input->post('discount_type'),
                                            'offer_associated'        => $this->input->post('value'),
                                            'offer_upto'  =>$this->input->post('value'),
                                        );
                                        $this->offers_model->edit_shop_offers_cat($data1,$id);
                                    }
                                }
                                else{
                                    $data = array(
                                            'title'     => $this->input->post('title'),
                                            'description'              => $this->input->post('description'),
                                            'discount_type'      => $this->input->post('discount_type'),
                                            'value'        => $this->input->post('value'),
                                            'expiry_date'       => $this->input->post('expiry_date'),
                                            'start_date'       => $this->input->post('start_date'),
                                            //'offer_upto'  =>$this->input->post('value'),
                                            'offer_created_by'       => $this->input->post('offer_created_by'),
                                            'coupan_or_offer'       => '1',
                                        );
                                    if ($this->offers_model->add_offer_coupon($data)) {
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                            }
                            echo json_encode($return);
                            break;
                            case 'delete_offer':
                                $id = $p1;
                                if($this->offers_model->delete_data('coupons_and_offers',$id))
                                {
                                    $data1['coupon_offer'] = $this->master_model->get_row_data1('coupons_and_offers','id',$id);
                                    $coupon_offer_image = ltrim($data1['coupon_offer']->photo, '/');
                                    if(is_file(DELETE_PATH.$coupon_offer_image))
                                    {
                                        unlink(DELETE_PATH.$coupon_offer_image);
                                    }
                                    $data['search'] = '';
                                    if (@$_POST['search']) {
                                        $data['search'] = $_POST['search'];
                                    }
                                    
                                    $this->load->library('pagination');
                                    $config = array();
                                    $config["base_url"]         = base_url()."offers/tb/";
                                    $config["total_rows"]       = $this->offers_model->offers();
                                    $data['total_rows']         = $config["total_rows"];
                                    $config["per_page"]         = 20;
                                    $config["uri_segment"]      = 3;
                                    $config['attributes']       = array('class' => 'pag-link');
                                    $config['full_tag_open']    = "<div class='pag'>";
                                    $config['full_tag_close']   = "</div>";
                                    $config['first_link']       = '&lt;&lt;';
                                    $config['last_link']        = '&gt;&gt;';
                                    $this->pagination->initialize($config);
                                    $data["links"]              = $this->pagination->create_links();
                                    $data['page']               = $page = ($p2!=null) ? $p2 : 0;
                                    $data['per_page']           = $config["per_page"];
                                    $data['offers']           = $this->offers_model->offers($config["per_page"],$page);
                                    $data['update_url']         = base_url().'offers/create/';
                                    $data['shop_detail'] = $this->shops_model->get_shop_detail($shop_id);
                                    $page                       = 'admin/offers_coupons/offers/tb';
                                    $this->load->view($page, $data);
                                }
                              
                                break;
            default:
                # code...
                break;
        }
    }

    //Fetch Shops
    public function fetch_shop()
    {
        if($this->input->post('business_id'))
        {
            $bid= $this->input->post('business_id');
            $this->master_model->fetch_shop($bid);
        }
    }

    //COUPONS
    public function coupons($action=null,$p1=null,$p2=null,$p3=null)
    {
        $data['user']  = $user         = checkLogin();
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Coupons';
                $data['tb_url']         = base_url().'coupons/tb';
                $data['new_url']        = base_url().'coupons/create';
                $page                   = 'admin/offers_coupons/coupons/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }
                    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."coupons/tb/";
                    $config["total_rows"]       = $this->coupons_model->coupons();
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 10;
                    $config["uri_segment"]      = 3;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p1!=null) ? $p1 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['coupons']           = $this->coupons_model->coupons($config["per_page"],$page);
                    $data['update_url']         = base_url().'coupons/create/';
                    $page                       = 'admin/offers_coupons/coupons/tb';
                    $this->load->view($page, $data);
                    break;
                
                    case 'create':
                        $data['remote']             = base_url().'offers-coupons/offers_coupons_remote/coupons/';
                        $data['action_url']         = base_url().'coupons/save';
                        $data['business']  = $this->coupons_model->view_data('business');
                        $data['shops']  = $this->coupons_model->view_data('shops');
                        $page                       = 'admin/offers_coupons/coupons/create';
                        if ($p1!=null) {
                            $data['action_url']     = base_url().'coupons/save/'.$p1;
                            $data['business']  = $this->coupons_model->view_data('business');
                            $data['shops']  = $this->coupons_model->view_data('shops');
                            $data['value']          = $this->coupons_model->coupon($p1);
                            $data['remote']         = base_url().'offers-coupons/offers_coupons_remote/coupons/'.$p1;
                            $page                   = 'admin/offers_coupons/coupons/update';
                        }
                        $data['form_id']            = uniqid();
                        
                       
                        $this->load->view($page, $data);
                        break;

                        case 'save':
                            $id = $p1;
                            $return['res'] = 'error';
                            $return['msg'] = 'Not Saved!';
                            if ($this->input->server('REQUEST_METHOD')=='POST') {
                                if ($id!=null) {
                                    $data = array(
                                            'title'     => $this->input->post('title'),
                                            'description'              => $this->input->post('description'),
                                            'discount_type'      => $this->input->post('discount_type'),
                                            'value'        => $this->input->post('value'),
                                            'expiry_date'       => $this->input->post('expiry_date'),
                                            'start_date'       => $this->input->post('start_date'),
                                            'offer_created_by'       => $this->input->post('offer_created_by'),
                                            'code'       => $this->input->post('code'),
                                            'minimum_coupan_amount'       => $this->input->post('minimum_coupan_amount'),
                                            'maximum_coupan_discount_value'       => $this->input->post('maximum_coupan_discount_value'),
                                        );
                                    if($this->offers_model->edit_offer_coupon($data,$id)){
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                                else{
                                    $data = array(
                                            'title'     => $this->input->post('title'),
                                            'description'              => $this->input->post('description'),
                                            'discount_type'      => $this->input->post('discount_type'),
                                            'value'        => $this->input->post('value'),
                                            'expiry_date'       => $this->input->post('expiry_date'),
                                            'start_date'       => $this->input->post('start_date'),
                                            'offer_created_by'       => $this->input->post('offer_created_by'),'coupan_or_offer'       => '0',
                                            'code'       => $this->input->post('code'),
                                            'minimum_coupan_amount'       => $this->input->post('minimum_coupan_amount'),
                                            'maximum_coupan_discount_value'       => $this->input->post('maximum_coupan_discount_value'),
                                        );
                                    if ($this->offers_model->add_offer_coupon($data)) {
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                            }
                            echo json_encode($return);
                            break;
                            case 'delete_coupon':
                                $id = $p1;
                                if($this->coupons_model->delete_data('coupons_and_offers',$id))
                                {
                                    $data1['coupon_offer'] = $this->master_model->get_row_data1('coupons_and_offers','id',$id);
                                    $coupon_offer_image = ltrim($data1['coupon_offer']->photo, '/');
                                    if(is_file(DELETE_PATH.$coupon_offer_image))
                                    {
                                        unlink(DELETE_PATH.$coupon_offer_image);
                                    }
                                    $data['search'] = '';
                                    if (@$_POST['search']) {
                                        $data['search'] = $_POST['search'];
                                    }
                                    
                                    $this->load->library('pagination');
                                    $config = array();
                                    $config["base_url"]         = base_url()."coupons/tb/";
                                    $config["total_rows"]       = $this->coupons_model->coupons();
                                    $data['total_rows']         = $config["total_rows"];
                                    $config["per_page"]         = 20;
                                    $config["uri_segment"]      = 3;
                                    $config['attributes']       = array('class' => 'pag-link');
                                    $config['full_tag_open']    = "<div class='pag'>";
                                    $config['full_tag_close']   = "</div>";
                                    $config['first_link']       = '&lt;&lt;';
                                    $config['last_link']        = '&gt;&gt;';
                                    $this->pagination->initialize($config);
                                    $data["links"]              = $this->pagination->create_links();
                                    $data['page']               = $page = ($p2!=null) ? $p2 : 0;
                                    $data['per_page']           = $config["per_page"];
                                    $data['coupons']           = $this->coupons_model->coupons($config["per_page"],$page);
                                    $data['update_url']         = base_url().'coupons/create/';
                                    $page                       = 'admin/offers_coupons/coupons/tb';
                                    $this->load->view($page, $data);
                                }
                              
                                break;
            default:
                # code...
                break;
        }
    }

    //Status change
    public function change_offer_coupon_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->coupons_model->get_row_data('coupons_and_offers','id',$id);


        if($data['status_data']->active == 1)
        {
            $data1 = array(
                'active' => 0
            );
        }
        else if($data['status_data']->active == 0)
        {
            $data1 = array(
                'active' => 1
            );
        }
        $this->coupons_model->edit_data('coupons_and_offers',$id,$data1);
        $this->load->view('admin/statusview',$data);
        
    }

    //Apply Offer

    public function apply_offer()
    {
        $data['user']  = $user         = checkLogin();
        $data['menu_id'] = $this->uri->segment(2);
        $data['title'] = 'Apply Offer';
        $data['business']  = $this->offers_model->view_data('business');
        $data['shops']  = $this->offers_model->view_data('shops');
        $data['parent_cat'] = $this->master_model->get_data('products_category','is_parent','0');
        $data['categories'] = $this->master_model->get_data('products_category','is_parent !=','0');
        $data['group'] = $this->master_model->getData('group_master',['is_deleted'=>'NOT_DELETED','active'=>'1']);
        $page = 'admin/offers_coupons/offers/apply_offer';
        $this->header_and_footer($page, $data);
    }
    //Fetch Product category
    public function fetch_category()
    {
        if($this->input->post('parent_id'))
        {
            $pid= $this->input->post('parent_id');
            $shopid= $this->input->post('shop_id');
            $data['offer_categories'] = $this->offers_model->fetch_offer_categories($pid,$shopid);
            $this->master_model->fetch_category($pid);
        }
    }
    public function fetch_sub_category()
    {
        if($this->input->post('parent_id'))
        {
            $pid= $this->input->post('parent_id');
            $shopid= $this->input->post('shop_id');
           // $data['offer_categories'] = $this->offers_model->fetch_offer_categories($pid,$shopid);
            $this->master_model->fetch_sub_category($pid);
        }
    }
    //Fetch Products
  
    public function fetch_products_search()
    {
        if($this->input->post('psearch'))
        {
            $psearch= $this->input->post('psearch');
            $shopid= $this->input->post('shop_id');
            $data['shop_id']= $shopid;
            $data['available_products'] = $this->master_model->fetch_products_search($psearch);
            $data['catflag'] = '1';
            $this->load->view('admin/offers_coupons/offers_varient/available_search_products',$data);
        }
    }
   
    
    public function available_offers()
    {
        $pid = $this->input->post('pid');
        $data['pid'] = $this->input->post('pid');
        $data['shop_id'] = $this->input->post('shop_id');
        $data['offers'] = $this->offers_model->get_data('coupons_and_offers','coupan_or_offer','1');
        $data['offer_list'] = $this->offers_model->view_data('shops_coupons_offers');
        // print_r($data['offers']);
        $this->load->view('admin/offers_coupons/offers/available_offers',$data);
       
    }
    public function add_offer()
    {
        $oid= $this->input->post('oid');
        $pid= $this->input->post('pid');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $data = array(
            'offer_assosiated_id'     => $oid,
            'product_id'     => $pid,
            'shop_id'     =>$shop_id,
            'offer_associated'     => $value,
            'offer_upto'     => $value,
            'discount_type'     => $discount_type,
        );
        $deletedata = array(
            'product_id'     => $pid,
            'shop_id'     =>$shop_id,
        );
        $this->offers_model->delete_offer_products($deletedata);
        // $check_offer = $this->offers_model->check_offer($oid,$pid,$shop_id);
        // if($check_offer)
        // {
            $data['add_offer'] = $this->offers_model->add_data('shops_coupons_offers',$data);
       
            $data['flg'] = '1';
            $data['oid'] = $oid;
            $data['value'] = $value;
            $data['discount_type'] = $discount_type;
            if($data['add_offer'])
            {
                // echo "success";
                $data['flg'] = '1';
                $this->load->view('admin/offers_coupons/offers/offer_action',$data);
            }

        // }
        // else
        // {
        //     echo "false";
        // }
    }

    public function remove_offer()
    {
        $oid= $this->input->post('oid');
        $pid= $this->input->post('pid');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $data['flg'] = '0';
        $data['oid'] = $oid;
        $data['value'] = $value;
        $data['discount_type'] = $discount_type;
        if ($this->offers_model->remove_offer($oid,$pid,$shop_id)) {
            $this->load->view('admin/offers_coupons/offers/offer_action',$data);
        } 
    }
    public function available_offers_cat()
    {
        $parent_cat_id = $this->input->post('parent_cat_id');
        $data['parent_cat_id'] = $this->input->post('parent_cat_id');
        $data['shop_id'] = $this->input->post('shop_id');
        $data['offers'] = $this->offers_model->get_data('coupons_and_offers','coupan_or_offer','1');
        $data['offer_list'] = $this->offers_model->view_data('shops_coupons_offers');
        $this->load->view('admin/offers_coupons/offers/available_offers_cat',$data);
       
    }
  
    
   
    public function add_offer_cat()
    {
        $oid= $this->input->post('oid');
         $parent_cat_id= $this->input->post('parent_cat_id');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $check_offer = $this->offers_model->check_offer_cat($oid,$parent_cat_id,$shop_id);
        if($check_offer)
        {
            $data['get_products_by_category'] = $this->master_model->fetch_products($parent_cat_id);
            foreach($data['get_products_by_category'] as $products)
            {
                $pro = $products->id;
                $data = array(
                    'offer_assosiated_id'     => $oid,
                    // 'category_id'     => $parent_cat_id,
                    'shop_id'     => $shop_id,
                    'offer_associated'     => $value,
                    'offer_upto'     => $value,
                    'discount_type'     => $discount_type,
                    'product_id'     => $pro,
                );
                $this->offers_model->delete_offer_products($data);
                $data['add_offer'] = $this->offers_model->add_data('shops_coupons_offers',$data);
            }
            
       
            $data['flg'] = '0';
            $data['oid'] = $oid;
            $data['value'] = $value;
            $data['discount_type'] = $discount_type;
            if($data['add_offer'])
            {
                // echo "success";
                $this->load->view('admin/offers_coupons/offers/offer_action_cat',$data);
            }

        }
        else
        {
            echo "false";
        }
    }
    public function remove_on_cat()
    {
        $parent_cat_id= $this->input->post('parent_cat_id');
        $shop_id= $this->input->post('shop_id');
        $data['get_products_by_category'] = $this->master_model->fetch_products($parent_cat_id);
        foreach($data['get_products_by_category'] as $products)
        {
            $pro = $products->id;
            $data = array(
                'shop_id'     => $shop_id,
                'product_id'     => $pro,
            );
            $data1['flg'] = '0';
            if($this->offers_model->delete_offer_products($data))
            {
                $this->load->view('admin/offers_coupons/offers/offer_action_cat',$data1);
            }
        }
    }
    public function remove_offer_cat()
    {
        $oid= $this->input->post('oid');
        $parent_cat_id= $this->input->post('parent_cat_id');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $data['flg'] = '0';
        $data['oid'] = $oid;
        $data['value'] = $value;
        $data['discount_type'] = $discount_type;
        if ($this->offers_model->remove_offer_cat($oid,$parent_cat_id,$shop_id)) {
            $this->load->view('admin/offers_coupons/offers/offer_action_cat',$data);
        } 
    }
  
   
    
    
    public function apply_offer_varient()
    {
        $data['user']  = $user         = checkLogin();
        $data['menu_id'] = $this->uri->segment(2);
        $data['title'] = 'Apply Offer All Varient';
        $data['business']  = $this->offers_model->view_data('business');
        $data['shops']  = $this->offers_model->view_data('shops');
        $data['parent_cat'] = $this->master_model->get_data('products_category','is_parent','0');
        $data['categories'] = $this->master_model->get_data('products_category','is_parent !=','0');
        $page = 'admin/offers_coupons/offers_varient/apply_offer';
        $this->header_and_footer($page, $data);
    }
    public function available_all_offers()
    {
        $pid = $this->input->post('pid');
        $data['pid'] = $this->input->post('pid');
        $data['prod_id'] = $this->input->post('prod_id');
        $data['shop_id'] = $this->input->post('shop_id');
        $data['offers'] = $this->offers_model->get_data('coupons_and_offers','coupan_or_offer','1');
        $data['offer_list'] = $this->offers_model->view_data('shops_coupons_offers');
        // print_r($data['offers']);
        $this->load->view('admin/offers_coupons/offers_varient/available_offers',$data);
       
    }
    public function available_offers_all_var()
    {
        $prod_id = $this->input->post('prod_id');
        $data['prod_id'] = $this->input->post('prod_id');
        $data['shop_id'] = $this->input->post('shop_id');
        $data['offers'] = $this->offers_model->get_data('coupons_and_offers','coupan_or_offer','1');
        $data['offer_list'] = $this->offers_model->view_data('shops_coupons_offers');
        $this->load->view('admin/offers_coupons/offers_varient/available_offers_all_var',$data);
       
    }
    public function add_offer_var()
    {
        $oid= $this->input->post('oid');
        $pid= $this->input->post('pid');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $data = array(
            'offer_assosiated_id'     => $oid,
            'product_id'     => $pid,
            'shop_id'     =>$shop_id,
            'offer_associated'     => $value,
            'offer_upto'     => $value,
            'discount_type'     => $discount_type,
        );
        $deletedata = array(
            'product_id'     => $pid,
            'shop_id'     =>$shop_id,
        );
        $this->offers_model->delete_offer_products($deletedata);
        // $check_offer = $this->offers_model->check_offer($oid,$pid,$shop_id);
        // if($check_offer)
        // {
            $data['add_offer'] = $this->offers_model->add_data('shops_coupons_offers',$data);
       
            $data['flg'] = '1';
            $data['oid'] = $oid;
            $data['value'] = $value;
            $data['discount_type'] = $discount_type;
            if($data['add_offer'])
            {
                // echo "success";
                $data['flg'] = '1';
                $this->load->view('admin/offers_coupons/offers_varient/offer_action',$data);
            }

        
        // else
        // {
        //     echo "false";
        // }
    }

    public function remove_offer_var()
    {
        $oid= $this->input->post('oid');
        $pid= $this->input->post('pid');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $data['flg'] = '0';
        $data['oid'] = $oid;
        $data['value'] = $value;
        $data['discount_type'] = $discount_type;
        if ($this->offers_model->remove_offer($oid,$pid,$shop_id)) {
            $this->load->view('admin/offers_coupons/offers_varient/offer_action',$data);
        } 
    }
    public function add_offer_all_var()
    {
        $oid= $this->input->post('oid');
         $prod_id= $this->input->post('prod_id');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        // $check_offer = $this->offers_model->check_offer_pro($oid,$prod_id,$shop_id);
        // if($check_offer)
        // {
           
            $data1 = array(
                'offer_assosiated_id'     => $oid,
                'shop_id'     => $shop_id,
                'offer_associated'     => $value,
                'offer_upto'     => $value,
                'discount_type'     => $discount_type,
                'product_id'     => $prod_id,
            );
            $deletedata = array(
                'product_id'     => $prod_id,
                'shop_id'     =>$shop_id,
            );
            $this->offers_model->delete_offer_products($deletedata);
            // $this->offers_model->delete_offer_products($data1);
            $data['add_offer'] = $this->offers_model->add_data('shops_coupons_offers',$data1);
            $data['get_products_by_pro'] = $this->master_model->fetch_products_id($prod_id);
            foreach($data['get_products_by_pro'] as $products)
            {
                $pro = $products->map_pro_id;
                $data = array(
                    'offer_assosiated_id'     => $oid,
                    'shop_id'     => $shop_id,
                    'offer_associated'     => $value,
                    'offer_upto'     => $value,
                    'discount_type'     => $discount_type,
                    'product_id'     => $pro,
                );
                $deletedata2 = array(
                    'product_id'     => $pro,
                    'shop_id'     =>$shop_id,
                );
                $this->offers_model->delete_offer_products($deletedata2);
                // $this->offers_model->delete_offer_products($data);
                $check_offer = $this->offers_model->check_offer_pro($oid,$pro,$shop_id);
                if($check_offer)
                {
                $data['add_offer'] = $this->offers_model->add_data('shops_coupons_offers',$data);
                }
            }
            
       
            $data['flg'] = '1';
            $data['oid'] = $oid;
            $data['value'] = $value;
            $data['discount_type'] = $discount_type;
            if($data['add_offer'])
            {
                // echo "success";
                $this->load->view('admin/offers_coupons/offers_varient/offer_action_all_var',$data);
            }

        // }
        // else
        // {
        //     echo "false";
        // }
    }
    public function fetch_products_load()
    {
        if($this->input->post('prod_id'))
        {
            $prod_id= $this->input->post('prod_id');
            $shopid= $this->input->post('shop_id');
            $data['shop_id']= $shopid;
            $data['available_products'] = $this->master_model->fetch_products_prod_id($prod_id);
            $data['catflag'] = '1';
            $this->load->view('admin/offers_coupons/offers_varient/available_search_products_load',$data);
        }
    }

    public function remove_offer_all_var()
    {
        $oid= $this->input->post('oid');
        $prod_id= $this->input->post('prod_id');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        if ($this->offers_model->remove_offer_pro($oid,$prod_id,$shop_id) ) {
            $data['get_products_by_pro'] = $this->master_model->fetch_products_id($prod_id);
            foreach($data['get_products_by_pro'] as $products)
            {
                $pro = $products->map_pro_id;
                $data = array(
                    'offer_assosiated_id'     => $oid,
                    'shop_id'     => $shop_id,
                    'offer_associated'     => $value,
                    'offer_upto'     => $value,
                    'discount_type'     => $discount_type,
                    'product_id'     => $pro,
                );
                $this->offers_model->delete_offer_products($data);
            }
            $data['flg'] = '0';
            $data['oid'] = $oid;
            $data['value'] = $value;
            $data['discount_type'] = $discount_type;
            $this->load->view('admin/offers_coupons/offers_varient/offer_action_all_var',$data);
        } 
    }
    public function remove_all_var()
    {
        $prod_id= $this->input->post('prod_id');
        $shop_id= $this->input->post('shop_id');
        $data2 = array(
            'shop_id'     => $shop_id,
            'product_id'     => $prod_id,
        );
            $this->offers_model->delete_offer_products($data2);
            $data['get_products_by_pro'] = $this->master_model->fetch_products_id($prod_id);
            foreach($data['get_products_by_pro'] as $products)
            {
                $pro = $products->map_pro_id;
                $data = array(
                    'shop_id'     => $shop_id,
                    'product_id'     => $pro,
                );
                $data1['flg'] = '0';
                if($this->offers_model->delete_offer_products($data))
                {
                    $this->load->view('admin/offers_coupons/offers_varient/offer_action_all_var',$data1);
                }
               
            }
        
    }
    public function fetch_products_var()
    {
        if($this->input->post('parent_cat_id'))
        {
            $id= $this->input->post('parent_cat_id');
            $shopid= $this->input->post('shop_id');
            $data['shop_id']= $this->input->post('shop_id');
            $data['available_products'] = $this->master_model->fetch_products($id);
            $data['offer_products'] = $this->offers_model->fetch_offer_products($id,$shopid);
           
            $this->load->view('admin/offers_coupons/offers_varient/available_products',$data);
        }
    }
    public function fetch_products()
    {
        if($this->input->post('parent_cat_id'))
        {
            $id= $this->input->post('parent_cat_id');
            $shopid= $this->input->post('shop_id');
            $data['shop_id']= $this->input->post('shop_id');
            $data['available_products'] = $this->master_model->fetch_products($id);
            $data['offer_products'] = $this->offers_model->fetch_offer_products($id,$shopid);
           
            $this->load->view('admin/offers_coupons/offers/available_products',$data);
        }
    }
    
}