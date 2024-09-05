<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class products_subcategory_model extends CI_Model
{
	function index(){
		echo 'This is model index function';
	}
	function __construct(){
		$this->tbl1 = 'products_subcategory';
		$this->tbl3 = 'cat_pro_maps';
		$this->tbl2 = 'vendors';
        $this->tbl4 = 'shops_inventory';
		$this->load->database();
	}
	function getRows($data = array()){
		$this->db->select("*");
		$this->db->from($this->tbl3.' as t1');
        $this->db->join($this->tbl1.' as t2','t1.pro_id=t2.id');
		if (array_key_exists("conditions", $data)) {
			foreach ($data['conditions'] as $key => $value) {
				$this->db->where('t1.'.$key,$value);
			}
		}
        $this->db->where('t2.is_deleted','NOT_DELETED');
        $this->db->where('t2.active','1');
		$this->db->order_by('t2.name');
		$query = $this->db->get();
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}
    
    function getRowsWithInventory($data = array()){
		$this->db->select("t2.*,t3.qty");
		$this->db->from($this->tbl3.' as t1');
        $this->db->join($this->tbl1.' as t2','t1.pro_id=t2.id');
        $this->db->join($this->tbl4.' as t3',"t2.id=t3.product_id and t3.is_deleted='NOT_DELETED'","left");
		if (array_key_exists("conditions", $data)) {
			foreach ($data['conditions'] as $key => $value) {
				$this->db->where("t1.".$key,$value);
			}
		}
        $this->db->where('t2.is_deleted','NOT_DELETED');
        $this->db->where('t2.active','1');
		$this->db->order_by('t2.name');
		$query = $this->db->get();
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}
    
	function get_vendors($data = array()){
		$this->db->select("*");
		$this->db->from($this->tbl2);
		if (array_key_exists("conditions", $data)) {
			foreach ($data['conditions'] as $key => $value) {
				$this->db->where($key,$value);
			}
		}
        $this->db->where('is_deleted','NOT_DELETED');
        $this->db->where('active','1');
		$this->db->order_by('name');
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
}
?>