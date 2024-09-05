<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class shops_inventory_model extends CI_Model
{
	function index(){
		echo 'This is model index function';
	}
	function __construct(){
		$this->tbl1 = 'shops_inventory';
		$this->tbl2 = 'cat_pro_maps';
		$this->load->database();
	}
	function getRows($data = array()){
		$this->db->select("*");
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
	function insertRow($data = array()){
		$result = $this->db->insert($this->tbl1,$data);
		return $result;
	}
	function insertRow1($data = array()){
		$this->db->insert($this->tbl1,$data);
		$result = $this->db->insert_id();
		
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
	function getInventoryData($data = array()){
		$this->db->select('
							t1.id as "id",
							CONCAT("'.IMGS_URL.'",(SELECT img FROM products_photo where item_id = products_subcategory.id and is_cover=1)) as "img",
							products_subcategory.id as "product_id",
							t1.qty as "qty",
							t1.purchase_rate as "purchase_rate",
							t1.mrp as "mrp",
							t1.selling_rate as "selling_rate",						
							t1.status as "status"	,					
							t1.mfg_date as "mfg_date",						
							t1.expiry_date as "expiry_date",
							t1.total_value as "total_value",
							t1.total_tax as "total_tax",
							t1.invoice_no as "invoice_no",
							t1.invoice_date as "invoice_date",
							t1.vendor_id as "vendor_id",
							t1.is_igst as "is_igst",
							t1.tax_value as "tax_value",
							vendors.name as "vendor_name",			
							vendors.active as "vendor_active",			
							vendors.id as "vendor_id",			
						');
		$this->db->from($this->tbl1.' as t1');
        $this->db->join($this->tbl2.' as t2','t2.pro_id = t1.product_id','INNER');
		$this->db->join('products_subcategory','products_subcategory.id = t1.product_id','INNER');
		$this->db->join('vendors','vendors.id = t1.vendor_id','INNER');
		if (array_key_exists("conditions", $data)) {
			foreach ($data['conditions'] as $key => $value) {
				$this->db->where('t2.'.$key,$value);
				
			}
            $this->db->where('t1.is_deleted','NOT_DELETED');	//added
				// $this->db->where('shops_inventory.status','1');	//added
		}
        
        $this->db->where('products_subcategory.is_deleted','NOT_DELETED');	//added
        
		if (array_key_exists("conditions_like", $data)) {
			foreach ($data['conditions_like'] as $key => $value) {
				$this->db->like('t1.'.$key,$value);
			}
		}
		if(isset($data['limit']) && isset($data['offset'])){
			$this->db->limit($data['limit'],$data['offset']);
		}
        
		$query = $this->db->get();
        //echo $this->db->last_query();
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}
}
?>