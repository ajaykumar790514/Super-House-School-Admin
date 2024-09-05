<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class orders_model extends CI_Model
{
	function index(){
		echo 'This is model index function';
	}
	function __construct(){
		$this->tbl1 = 'orders';
		$this->load->database();
	}
	function getRows($data = array()){
		$this->db->select("*,(SELECT shop_name FROM shops where id=orders.shop_id) as \"shop_name\",
		(SELECT contact FROM shops where id=orders.shop_id) as \"shop_mobile\",
		(SELECT CONCAT(name) FROM customers where id=orders.user_id) as \"customer_name\",
		(SELECT email FROM customers where id=orders.user_id) as \"customer_email\"");
		$this->db->from($this->tbl1);
		if (array_key_exists("conditions", $data)) {
			foreach ($data['conditions'] as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}
	function getRows2($oid){
		$this->db
		 ->select('t1.*,t2.shop_name,t2.contact as shop_mobile,t3.mobile as alternate_mobile')
		 ->from('orders t1')
		 ->join('shops t2', 't2.id = t1.shop_id','left')        
		 ->join('customers t3', 't3.id = t1.user_id','left') 
		 //->join('cancellations_exchange t4', 't4.order_id = t1.id','left') 

		 ->where(['t1.id'=>$oid])  ;
	 
		 $query = $this->db->get();
		 $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		 return $result;
	 }
	function insertRow($data = array()){
		$result = $this->db->insert($this->tbl1,$data);
		return $result;
	}
	function updateRow($id,$data = array()){
		$this->db->where($this->tbl1.'.'.'id',$id);
		$result = $this->db->update($this->tbl1,$data);
		return $result;
	}
	function deleteRow($id){
		$this->db->where($this->tbl1.'.'.'id',$id);
		$result = $this->db->delete($this->tbl1);
		return $result;
	}

	public function getBundleDetails($id)
    {
        $this->db
        ->select('t2.*,t3.*,t1.qty as pro_qty,t1.price as pro_price,t4.thumbnail')
        ->from('bundle_products_mapping t1')     
         ->join('products_subcategory t2', 't2.id = t1.pro_id','left')   
         ->join('shops_inventory t3', 't2.id=t3.product_id AND t3.is_deleted="NOT_DELETED" AND t3.status="1"','left')
		 ->join('products_photo t4', 't4.item_id=t2.id AND t4.is_cover="1"','left')
        ->where(['t2.is_deleted' => 'NOT_DELETED','t1.bundle_id' =>$id]);   
      // echo $this->db->last_query();die();
        return $this->db->get()->result();
    }
    public function getBundleDetails_new($oid)
    {
        $this->db
        ->select('t2.*,a.qty as pro_qty,a.selling_rate as pro_price,t4.thumbnail')
         ->from('order_items t1') 
		 ->join('order_bundle_items a', 'a.order_item_id = t1.id','left') 
         ->join('products_subcategory t2', 't2.id = a.product_id','left')  
		 ->join('products_photo t4', 't4.item_id=t2.id AND t4.is_cover="1"','left')
        ->where(['t2.is_deleted' => 'NOT_DELETED','t1.id' =>$oid]);   
      // echo $this->db->last_query();die();
        return $this->db->get()->result();
    }
	function getOrdersData($data = array(),$mobile='',$payment_mode=''){
		// echo('<pre>');
		// print_r($payment_mode[0]);
		// die();
		$this->db->select("
							orders.id,
							orders.orderid,
							orders.invoice_no,
							orders.invoice_file,
							(SELECT shop_name FROM shops where id=orders.shop_id) as \"shop_name\",
							(SELECT CONCAT(name,' (',email,')') FROM customers where id=orders.user_id) as \"customer_name\",
							orders.datetime,
							CONCAT(datetime,' (',TIME_FORMAT(timeslot_starttime, \"%h:%i %p\"),' - ',TIME_FORMAT(timeslot_endtime, \"%h:%i %p\"),')') as \"delivery_slot\",
							orders.address_id,
							orders.random_address,
							orders.total_value,
							orders.total_savings,
							orders.payment_method,
							orders.status,
							orders.added,
							orders.delivery_charges,
							customers.mobile,
							order_status_master.name as status_name,
							CONCAT(db.full_name,' (',db.contact_number,')') as delivery_boy,
							db.id as delivery_boy_id
						");
		$this->db->from($this->tbl1);
        $this->db->join('customers', 'customers.id = orders.user_id');
        $this->db->join('order_status_master', 'order_status_master.id = orders.status');
        $this->db->join('order_assign_deliver oad', 'oad.order_id = orders.id','left');
        $this->db->join('delivery_boys db', 'db.id = oad.delivery_boy_id','left');
		if (array_key_exists("conditions", $data)) 
		{
			foreach ($data['conditions'] as $key => $value) {
				$this->db->where($this->tbl1.".".$key,$value);
			}
		}
		if ($mobile != 'null') {
				$this->db->where('customers.mobile',$mobile);
		}
		if ($payment_mode != 'null') {
			if ($payment_mode == 'cod') {
                $this->db->where('orders.payment_method' , 'cod');
            }
			else if($payment_mode == 'online')
            {
                $this->db->where('orders.payment_method!=' , 'cod');
            }
		}
		if(isset($_SESSION['order_table_filters']['from_date']) && $_SESSION['order_table_filters']['from_date']!==''){
			if (array_key_exists("order_date", $data)) {
				$from_date = DATE($data['order_date']['start_date']);
				$to_date = DATE($data['order_date']['end_date']);
				// print_r($from_date);
				$this->db->where(['DATE('.$this->tbl1.'.added) >='=>$from_date , 'DATE('.$this->tbl1.'.added) <='=>$to_date]);
				// $this->db->where(['DATE('.$this->tbl1.'.added) >='=>'2021-07-01' , 'DATE('.$this->tbl1.'.added) <='=>'2021-10-30']);
				// $this->db->last_query();
			}
		}
		if(isset($_SESSION['order_table_filters']['delivery_boy']) && $_SESSION['order_table_filters']['delivery_boy']!==''){
			$this->db->where('db.id',$_SESSION['order_table_filters']['delivery_boy']);
		}
		if (array_key_exists("conditions_join", $data)) {
			foreach ($data['conditions_join'] as $key => $value) {
				$this->db->where('customers'.".".$key,$value);
			}
		}
		if (array_key_exists("conditions_like", $data)) {
			foreach ($data['conditions_like'] as $key => $value) {
				$this->db->like($this->tbl1.".".$key,$value);
			}
		}
		if (array_key_exists("conditions_in", $data)) {
			foreach ($data['conditions_in'] as $key => $value) {
				$this->db->where_in($this->tbl1.".".$key,$value);
			}
		}
		if(isset($data['order_field']) && isset($data['order'])){
			$this->db->order_by($data['order_field'],strtoupper($data['order']));
		}else{
			$this->db->order_by('orders.added','DESC');
		}

		if(isset($data['limit']) && isset($data['offset'])){
			$this->db->limit($data['limit'],$data['offset']);
		}
		
		$query = $this->db->get();
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		
		return $result;
	}
	function getNewOrdersRows($data = array()){
		$this->db->select("*,(SELECT shop_name FROM shops where id=orders.shop_id) as \"shop_name\",
		(SELECT contact FROM shops where id=orders.shop_id) as \"shop_mobile\",
		(SELECT CONCAT(name) FROM customers where id=orders.user_id) as \"customer_name\",
		(SELECT mobile FROM customers where id=orders.user_id) as \"customer_mobile\"");
		$this->db->from($this->tbl1);
		if (array_key_exists("conditions", $data)) {
			foreach ($data['conditions'] as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		$this->db->order_by('added','DESC');
		$query = $this->db->get();
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}
	public function invoice_details($oid)
    {
        $query = $this->db
        ->select('t1.id as oid,t1.*,t1.added as order_date,t1.tax as order_tax,t2.qty as item_qty,t2.purchase_rate,t2.tax_value,t3.name as status_name,t4.id as product_id,t4.name as product_name,t4.unit_value,t4.unit_type,t5.img,t6.name,t6.mobile as cus_mobile,t6.email as cust_email,t7.address_line_1 as cust_address,t7.contact_person_name,t7.mobile as cust_contact,t8.*,t9.name as city_name,t10.name state_name,t1.address_line_2 as address2,t1.address_line_3 as address3,t1.apartment_name,t1.floor,,t1.house_no as cust_house_no,t2.mrp,t2.price_per_unit,t1.state as cust_state,t1.email as order_email,t1.city as cust_city,t1.pincode as cust_pincode,t2.total_price,t1.remark as instructions,t6.id as customer_id,t11.selling_rate,t2.discount_type,t2.offer_applied')
        ->from('orders t1')
        ->join('order_items t2', 't2.order_id = t1.id','left')        
        ->join('order_status_master t3', 't3.id = t1.status','left')        
        ->join('products_subcategory t4', 't4.id = t2.product_id','left')        
		->join('products_photo t5', 't5.item_id = t4.id','left')  
		->join('customers t6', 't6.id = t1.user_id','left')  
		->join('customers_address t7', 't7.id = t1.address_id','left')  
		->join('shops t8', 't8.id = t1.shop_id','left')  
		->join('cities t9', 't9.id = t8.city','left')  
		->join('states t10', 't10.id = t8.state','left')  
		->join('shops_inventory t11', 't11.id = t2.inventory_id','left') 
        ->where(['t4.is_deleted' => 'NOT_DELETED','t1.id'=>$oid,'t5.is_cover' =>'1'])  
		->get();   
		return $query->result_array();
    }


public function invoice_loop_details($oid)
    {
        $query = $this->db
        ->select('t1.id as oid,t1.*,t1.added as order_date,t1.tax as order_tax,t2.qty as item_qty,t2.purchase_rate,t2.price_per_unit,t2.tax_value,t3.name as status_name,t4.id as product_id,t4.name as product_name,t4.unit_value,t4.unit_type,t2.discount_type,t2.offer_applied,t2.total_price,t5.name as flavour')
        ->from('orders t1')
        ->join('order_items t2', 't2.order_id = t1.id','left')        
        ->join('order_status_master t3', 't3.id = t1.status','left')        
        ->join('products_subcategory t4', 't4.id = t2.product_id','left')  
        ->join('flavour_master t5', 't5.id = t4.flavour_id','left') 
        ->where(['t4.is_deleted' => 'NOT_DELETED','t1.id'=>$oid])  
		->get();   
		return $query->result();
    }

 function get_row_order($oid){
		$this->db
		 ->select('t1.*,t2.shop_name,t2.contact as shop_mobile,t3.mobile as alternate_mobile')
		 ->from('orders t1')
		 ->join('shops t2', 't2.id = t1.shop_id','left')        
		 ->join('customers t3', 't3.id = t1.user_id','left') 
		// ->join('cancellations_exchange t4', 't4.order_id = t1.id','left') 

		 ->where(['t1.id'=>$oid])  ;
	 
		 $query = $this->db->get()->row();
		 return $query;
	 }

}

?>