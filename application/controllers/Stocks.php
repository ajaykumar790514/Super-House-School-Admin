<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stocks extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $data['user']  = $user         = $this->checkShopLogin();
        $this->check_role_menu();
    }

    public function isLoggedIn(){
        $is_logged_in = $this->session->userdata('shop_logged_in');
        if(!isset($is_logged_in) || $is_logged_in!==TRUE)
        {
            redirect(base_url());
            exit;
        }
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
    public function check_role_menu(){
        $data['user']  = $user         = $this->checkShopLogin();
        $shop_role_id = $user->role_id;
        $uri = $this->uri->segment(1);
        $role_menus = $this->admin_model->all_role_menu_data($shop_role_id);
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
    public function getStockData(){
        $array_cond_like=array();
        $array_cond['cat_id'] = $_GET['cat_id'];
        // $array_cond['active'] = '1';
        if(isset($_GET['filter']['product_id']) && $_GET['filter']['product_id']!=='0'){
            $array_cond['product_id'] = $_GET['filter']['product_id'];
        }
        if(isset($_GET['filter']['purchase_rate']) && $_GET['filter']['purchase_rate']!==''){
            $array_cond_like['purchase_rate'] = $_GET['filter']['purchase_rate'];
        }
        if(isset($_GET['filter']['mrp']) && $_GET['filter']['mrp']!== ''){
            $array_cond_like['mrp'] = $_GET['filter']['mrp'];
        }
        if(isset($_GET['filter']['qty']) && $_GET['filter']['qty']!==''){
            $array_cond_like['qty'] = $_GET['filter']['qty'];
        }
        if(isset($_GET['filter']['selling_rate']) && $_GET['filter']['selling_rate']!==''){
            $array_cond_like['selling_rate'] = $_GET['filter']['selling_rate'];
        } 
        if(isset($_GET['filter']['status']) && $_GET['filter']['status']!==''){
            $array_cond_like['status'] = $_GET['filter']['status'];
        }        
        $getData = $this->shops_inventory_model->getInventoryData(array('conditions'=>$array_cond,'conditions_like'=>$array_cond_like,'limit'=>$_GET['filter']['pageSize'],'offset'=>$_GET['filter']['pageSize']*($_GET['filter']['pageIndex']-1)));
        $array =array();
        $item_count=0;
        if($getData!==FALSE){
            foreach($getData as $data){
                $array[] = array(
                                    'id' => $data['id'],
                                    'img' => $data['img'],
                                    'product_id' => $data['product_id'],
                                    'vendor_id' => $data['vendor_id'],
                                    'is_igst' => $data['is_igst'],
                                    'qty' => $data['qty'],
                                    'purchase_rate' => $data['purchase_rate'],
                                    'mrp' => $data['mrp'],
                                    'selling_rate' => $data['selling_rate'],
                                    'status' => $data['status'],
                                    'mfg_date' => $data['mfg_date'],
                                    'expiry_date' => $data['expiry_date'],
                                    'total_value' => $data['total_value'],
                                    'total_tax' => $data['total_tax'],
                                    'invoice_no' => $data['invoice_no'],
                                    'invoice_date' => $data['invoice_date'],
                                    'vendor_name' => $data['vendor_name'],
                                    'tax_value' => $data['tax_value']
                );
            }
            $item_count = count($this->shops_inventory_model->getInventoryData(array('conditions'=>$array_cond)));
        }
       
        echo json_encode(array('data'=>$array,'itemsCount'=>$item_count));
    }
    public function product_list(){
//        $getData = $this->products_subcategory_model->getRows(array('conditions'=>$_POST));
//        // $getData = $this->products_subcategory_model->getRows(array('conditions'=>array('is_deleted'=>'NOT_DELETED')));
//        $array = array(array('id'=>"0",'name'=>"Select any one product"));
//        // $array = array();
//        foreach($getData as $data){
//            $temp_array = array(
//                                'id' => $data['id'],
//                                'name' => str_pad($data['product_code'], 6, '0', STR_PAD_LEFT).' - '.$data['name'],
//                                'gst' => $data['tax_value']
//            );
//            array_push($array,$temp_array);
//        }
//        echo json_encode($array);
//        //return TRUE;
        
        $getData = $this->products_subcategory_model->getRowsWithInventory(array('conditions'=>$_POST));
        // $getData = $this->products_subcategory_model->getRows(array('conditions'=>array('is_deleted'=>'NOT_DELETED')));
        $array = array(array('id'=>"0",'name'=>"Select any one product"));
        // $array = array();
        foreach($getData as $data){
            $temp_array = array(
                                'id' => $data['id'],
                                'name' => str_pad($data['product_code'], 6, '0', STR_PAD_LEFT).' - '.$data['name'].' -  ('.$data['qty'].')',
                                'gst' => $data['tax_value']
            );
            array_push($array,$temp_array);
        }
        echo json_encode($array);
    }
    public function vendor_list(){
        $getData = $this->products_subcategory_model->get_vendors(array('conditions'=>$_POST));
        // $getData = $this->products_subcategory_model->getRows(array('conditions'=>array('is_deleted'=>'NOT_DELETED')));
        $array = array();
        // $array = array(array('id'=>"0",'name'=>"Select any one vendor"));
        foreach($getData as $data){
            $temp_array = array(
                                'id' => $data['id'],
                                'name' => str_pad($data['vendor_code'], 6, '0', STR_PAD_LEFT).' - '.$data['name'],
            );
            array_push($array,$temp_array);
        }
        echo json_encode($array);
        //return TRUE;
    }
    public function insertStockData(){
        $product_id = explode(",",$_POST['item']['product_id']);

        $insertArray = array(
            'product_id' => $product_id[0],            
            'tax_value' => $product_id[1],            
            'purchase_rate' => is_null($_POST['item']['purchase_rate'])?0.00:$_POST['item']['purchase_rate'] ,
            'selling_rate' => $_POST['item']['selling_rate'],
            'mrp' => $_POST['item']['mrp'],
            'mfg_date' => $_POST['item']['mfg_date'],
            'expiry_date' => $_POST['item']['expiry_date'],
            'shop_id' => $_POST['shop_id'],
            'vendor_id' => $_POST['item']['vendor_id'],
            'is_igst' => $_POST['item']['is_igst'],
            'total_value' => $_POST['item']['total_value'],
            'invoice_no' => $_POST['item']['invoice_no'],
            'invoice_date' => $_POST['item']['invoice_date'],
            'total_tax' => $_POST['item']['total_tax'],
        );
        // $checkinsertArray = array(
        //     'product_id' => $product_id[0],            
        //     'tax_value' => $product_id[1],            
        //     'purchase_rate' => is_null($_POST['item']['purchase_rate'])?0.00:$_POST['item']['purchase_rate'] ,
        //     'selling_rate' => $_POST['item']['selling_rate'],
        //     'mrp' => $_POST['item']['mrp'],                  
        //     'shop_id' => $_POST['shop_id'],
        // );
        // print_r($insertArray);
        // die();

        // $checkExistingData=$this->shops_inventory_model->getRows(array('conditions'=>$checkinsertArray));
        // $insertArray1['get_shop_inventory_id']=$this->shops_inventory_model->get_row_data1('shops_inventory','purchase_rate',$purchase_rate,'selling_rate',$selling_rate,'mrp',$mrp);
        // if($checkExistingData===FALSE){
            $insertArray['qty'] = $_POST['item']['qty'];
            // $this->shops_inventory_model->insertRow($insertArray);
            $insert_stock = $this->shops_inventory_model->insertRow1($insertArray);
            //log generated
            $insertArray['action']="LATEST_UPDATE";
            $insertArray['shops_inventory_id']=$insert_stock;
            $this->shop_inventory_logs_model->insertRow($insertArray);
        // }else{
        //     $this->shops_inventory_model->updateRow($checkExistingData[0]['id'],array('qty'=>($_POST['item']['qty']+$checkExistingData[0]['qty'])));
        //     $insertArray['qty'] = $_POST['item']['qty'];
        //     $insertArray['action']="UPDATE";
        //     $insertArray['shops_inventory_id']=$checkExistingData[0]['id'];
        //     $this->shop_inventory_logs_model->insertRow($insertArray);
        // }
    }
    public function updateStockData(){
        $checkExistingData = $this->shops_inventory_model->getRows(array('conditions'=>array('id'=>$_POST['item']['id'])));
        $total_val = $_POST['item']['qty'] * $_POST['item']['purchase_rate'];

        // $total_tax = $_POST['item']['purchase_rate'] - ($_POST['item']['purchase_rate'] * (100 / (100 + $_POST['item']['tax_value'] ) ) );
        $total_tax = $total_val - ($total_val * (100 / (100 + $_POST['item']['tax_value'] ) ) );

        if($checkExistingData!==FALSE){
            $updateData = array(
                // 'product_id'=>$_POST['item']['product_id'],
                //                     'qty'=>$_POST['item']['qty'],
                //                     'purchase_rate' => $_POST['item']['purchase_rate'],
                //                     'selling_rate' => $_POST['item']['selling_rate'],
                //                     'shop_id' => $_POST['item']['shop_id'],
                //                     'mfg_date' => $_POST['item']['mfg_date'],
                //                     'expiry_date' => $_POST['item']['expiry_date'],
                //                     'vendor_id' => $_POST['item']['vendor_id'],
                //                     'is_igst' => $_POST['item']['is_igst'],
                //                     'invoice_no' => $_POST['item']['invoice_no'],
                //                     'tax_value' => $_POST['item']['tax_value'],
                //                     'status' => $_POST['item']['status'],
                //                     'total_value' => $total_val,
                //                     'total_tax' => $total_tax,

                                    'qty'=>$_POST['item']['qty'],
                                    'purchase_rate' => $_POST['item']['purchase_rate'],
                                    'selling_rate' => $_POST['item']['selling_rate'],
                                    'mrp' => $_POST['item']['mrp'],
                                    'status' => $_POST['item']['status'],
                                    'total_value' => $total_val,
                                    'total_tax' => $total_tax,
                                );
            $this->shops_inventory_model->updateRow($_POST['item']['id'],$updateData);

            //log generated
            $insertArray = array(
                'product_id' => $checkExistingData[0]['product_id'],
                'qty' => $_POST['item']['qty'],
                'purchase_rate' => $_POST['item']['purchase_rate'],
                'selling_rate' => $_POST['item']['selling_rate'],
                'mrp' => $_POST['item']['mrp'],
                'shop_id' => $checkExistingData[0]['shop_id'],
                'mfg_date' => $_POST['item']['mfg_date'],
                'expiry_date' => $_POST['item']['expiry_date'],
                'vendor_id' => $_POST['item']['vendor_id'],
                'is_igst' => $_POST['item']['is_igst'],
                'invoice_no' => $_POST['item']['invoice_no'],
                'invoice_date' => $_POST['item']['invoice_date'],
                'tax_value' => $_POST['item']['tax_value'],
                'total_value' => $total_val,
                'total_tax' => $total_tax,
            );
            // if($checkExistingData[0]['status'] !== $_POST['item']['status']){
            //     if($_POST['item']['status']==='0'){
            //         $insertArray['action']='DISABLED';
            //         $insertArray['shops_inventory_id']=$checkExistingData[0]['id'];
            //     }else{
            //         $insertArray['action']='ENABLED';
            //         $insertArray['shops_inventory_id']=$checkExistingData[0]['id'];
            //     }
            // }else{
                $insertArray['action']='LATEST_UPDATE';
                $insertArray['shops_inventory_id']=$checkExistingData[0]['id'];
            // }
            $shop_inventory_id = $_POST['item']['id'];

            $data['get_inventory_log']    = $this->shop_inventory_logs_model->getMaxRow($shop_inventory_id);
            
            $inventory_log_id = $data['get_inventory_log']->id;

            $updateaction['action']='UPDATE';
            if(!empty($data['get_inventory_log']))
            {
                $this->shop_inventory_logs_model->updateRow($inventory_log_id,$updateaction);
            }
            $this->shop_inventory_logs_model->insertRow($insertArray);
        }
    }
    public function updateCustomStockData(){
        $data['user']  = $user         = $this->checkShopLogin();
        $checkExistingData = $this->shops_inventory_model->getRows(array('conditions'=>array('id'=>$_POST['item']['id'])));
        if($checkExistingData!==FALSE){
            $shop_id     = $user->id;
            $product_id = explode(",",$_POST['item']['product_id']);
      
            $updateData = array(
                                    'product_id' => $product_id[0],            
                                    'tax_value' => $product_id[1],
                                    'vendor_id' => $_POST['item']['vendor_id'],
                                    'purchase_rate' => $_POST['item']['purchase_rate'],
                                    'selling_rate' => $_POST['item']['selling_rate'],
                                    'qty' => $_POST['item']['qty'],
                                    'mrp' => $_POST['item']['mrp'],
                                    'mfg_date' => $_POST['item']['mfg_date'],
                                    'expiry_date' => $_POST['item']['expiry_date'],
                                    'total_value' => $_POST['item']['total_value'],
                                    'total_tax' => $_POST['item']['total_tax'],
                                    'invoice_no' => $_POST['item']['invoice_no'],
                                    'invoice_date' => $_POST['item']['invoice_date'],
                                    'is_igst' => $_POST['item']['is_igst'],
                                    'shop_id' => $shop_id,
                                );
                            }
            
            $this->shops_inventory_model->updateRow($_POST['item']['id'],$updateData);

            // log generated
            $insertArray = array(
                'product_id' => $product_id[0],            
                'tax_value' => $product_id[1],
                'vendor_id' => $_POST['item']['vendor_id'],
                'purchase_rate' => $_POST['item']['purchase_rate'],
                'selling_rate' => $_POST['item']['selling_rate'],
                'qty' => $_POST['item']['qty'],
                'mrp' => $_POST['item']['mrp'],
                'mfg_date' => $_POST['item']['mfg_date'],
                'expiry_date' => $_POST['item']['expiry_date'],
                'total_value' => $_POST['item']['total_value'],
                'total_tax' => $_POST['item']['total_tax'],
                'invoice_no' => $_POST['item']['invoice_no'],
                'invoice_date' => $_POST['item']['invoice_date'],
                'is_igst' => $_POST['item']['is_igst'],
                'shop_id' => $shop_id,
                'action' => 'LATEST_UPDATE',
                'shops_inventory_id'=>$_POST['item']['id'],
            );
            $shop_inventory_id = $_POST['item']['id'];

            $data['get_inventory_log']    = $this->shop_inventory_logs_model->getMaxRow($shop_inventory_id);
            
            $inventory_log_id = $data['get_inventory_log']->id;

            $updateaction['action']='UPDATE';
            if(!empty($data['get_inventory_log']))
            {
                $this->shop_inventory_logs_model->updateRow($inventory_log_id,$updateaction);
            }
            $this->shop_inventory_logs_model->insertRow($insertArray);
  
    }
    public function deleteStockData(){
        // $this->shops_inventory_model->updateRow($_POST['item']['id'],array('status'=>'0'));
        $data['user']  = $user         = $this->checkShopLogin();
        $shop_inventory_id = $_POST['item']['id'];
        //log generated
        if($this->shops_inventory_model->delete_data('shops_inventory',$shop_inventory_id))
        {
            $insertArray = array(
                'product_id'=>$_POST['item']['product_id'],
                'qty'=>$_POST['item']['qty'],
                'purchase_rate' => $_POST['item']['purchase_rate'],
                'selling_rate' => $_POST['item']['selling_rate'],
                'mrp' => $_POST['item']['mrp'],
                'shop_id' => $user->id,
                'action'=>'DELETED',
                'shops_inventory_id'=>$_POST['item']['id'],
                'mfg_date' => $_POST['item']['mfg_date'],
                'expiry_date' => $_POST['item']['expiry_date'],
                'total_value' => $_POST['item']['total_value'],
                'vendor_id' => $_POST['item']['vendor_id'],
                'is_igst' => $_POST['item']['is_igst'],
                'invoice_no' => $_POST['item']['invoice_no'],
                'invoice_date' => $_POST['item']['invoice_date'],
                'total_tax' => $_POST['item']['total_tax'],
                'tax_value' => $_POST['item']['tax_value'],
            );
            
            $data['get_inventory_log']    = $this->shop_inventory_logs_model->getMaxRow($shop_inventory_id);
                
            $inventory_log_id = $data['get_inventory_log']->id;

            $updateaction['action']='DELETED';
            if(!empty($data['get_inventory_log']))
            {
                $this->shop_inventory_logs_model->updateRow($inventory_log_id,$updateaction);
            }
            $this->shop_inventory_logs_model->insertRow($insertArray);
        }
        // $insertArray = array(
        //     'product_id' => $checkExistingData[0]['product_id'],
        //     'qty' => $_POST['item']['qty'],
        //     'purchase_rate' => $checkExistingData[0]['purchase_rate'],
        //     'selling_rate' => $checkExistingData[0]['selling_rate'],
        //     'mrp' => $checkExistingData[0]['mrp'],
        //     'shop_id' => $checkExistingData[0]['shop_id'],
        //     'action'=>'DELETED'
        // );
        // $this->shop_inventory_logs_model->insertRow($insertArray);


    }
    public function stock_category(){
        $data['user']  = $user         = $this->checkShopLogin();
        // if($this->session->has_userdata('logged_in') && $this->session->logged_in === TRUE){
            if(!empty($user)){
            $shop_id     = $user->id;
            $shop_role_id     = $user->role_id;
            $data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
            $data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu','status','1');
		    $shop_details = $this->shops_model->get_shop_data($shop_id);
            $viewData['product_category'] = $this->products_category_model->getRows(array('conditions'=>array('active'=>'1','is_parent'=>'0','is_deleted'=>'NOT_DELETED')));
            $viewData['cat_or_pro_flg'] =true;
			$template_data = array(
									'menu'=> $this->load->view('template/menu',$data,TRUE),
									'main_body_data'=> $this->load->view('shop/stocks-category',$viewData,TRUE),
                                    'shop_photo'=>$shop_details->logo
								);
			$this->load->view('template/main_template',$template_data);
		}else{
			redirect(base_url());
		}
    }
    
    
    public function stock_sub_category($category_id){
        $data['user']  = $user         = $this->checkShopLogin();
        $shop_id     = $user->id;
        $shop_role_id     = $user->role_id;
        $data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
        $data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu','status','1');
        $shop_details = $this->shops_model->get_shop_data($shop_id);
        // if($this->session->has_userdata('logged_in') && $this->session->logged_in === TRUE){
            if(!empty($user)){
            $viewData['product_category'] = $this->products_category_model->getRows(array('conditions'=>array('active'=>'1','is_parent'=>$category_id,'is_deleted'=>'NOT_DELETED')));
            $viewData['cat_or_pro_flg'] =false;
            if($viewData['product_category']!==FALSE){
                
                if(count($viewData['product_category'])===1){
                    
                    redirect(base_url('stocks/category/'.$viewData['product_category'][0]['id']));
                }else{
                     
                }
            }
            else
            {
                redirect(base_url('stocks/category/'.$category_id));
            }
            $shop_id     = $user->id;
		    $shop_details = $this->shops_model->get_shop_data($shop_id);
			$template_data = array(
									'menu'=> $this->load->view('template/menu',$data,TRUE),
									'main_body_data'=> $this->load->view('shop/stocks-category',$viewData,TRUE),
                                    'shop_photo'=>$shop_details->logo
								);
			$this->load->view('template/main_template',$template_data);
		}else{
			redirect(base_url());
		}
    }
    public function show_stocks($sub_cat_id){
        $data['user']  = $user         = $this->checkShopLogin();
        $shop_id     = $user->id;
        $shop_role_id     = $user->role_id;
        $data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
        $data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu','status','1');
        $shop_details = $this->shops_model->get_shop_data($shop_id);
        // if($this->session->has_userdata('logged_in') && $this->session->logged_in === TRUE){
            if(!empty($user)){
            $sub_cat_data = $this->products_category_model->getRows(array('conditions'=>array('id'=>$sub_cat_id)));
            $cat_data = $this->products_category_model->getRows(array('conditions'=>array('id'=>$sub_cat_data[0]['is_parent'])));
            $shop_id     = $user->id;
		    $shop_details = $this->shops_model->get_shop_data($shop_id);
            $viewData= array(
                                'parent_cat_id'=>$sub_cat_id,
                                'sub_cat_data' => $sub_cat_data[0],
                                'cat_data' => $cat_data[0],
                                'shop_id' => $shop_id,
                            );
			$template_data = array(
									'menu'=>$this->load->view('template/menu',$data,TRUE),
									'main_body_data'=>$this->load->view('shop/jsgrid_test',$viewData,TRUE),
                                    'shop_photo'=>$shop_details->logo
								);
			$this->load->view('template/main_template',$template_data);
		}else{
			redirect(base_url());
		}
    }
}
