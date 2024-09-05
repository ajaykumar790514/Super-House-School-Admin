<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class order_items_model extends CI_Model
{
	function index(){
		echo 'This is model index function';
	}
	function __construct(){
		$this->tbl1 = 'order_items';
		$this->tbl2 = 'flavour_master';
		$this->tbl3 = 'products_subcategory';
		$this->load->database();
	}
	function getRows($data = array()){
		$this->db->select("
							t1.id,t2.name as flavour,t3.flag as ProductFlag,t1.id as item_id,
							(SELECT name from products_subcategory where id=t1.product_id) as \"product_name\",
							(SELECT product_code from products_subcategory where id=t1.product_id) as \"product_code\",
							(SELECT unit_type from products_subcategory where id=t1.product_id) as \"unit_type\",
							(SELECT unit_value from products_subcategory where id=t1.product_id) as \"unit_value\",
							
							CONCAT('".IMGS_URL."',(SELECT img FROM products_photo where item_id = t1.product_id and is_cover=1)) as \"img\",
							t1.order_id,t1.qty,t1.price_per_unit,t1.total_price,t1.tax,t1.tax_value,t1.offer_applied,t1.product_id,t1.discount_type");
		$this->db->from($this->tbl1.' as t1');
		$this->db->join($this->tbl3.' as t3','t1.product_id=t3.id');
		$this->db->join($this->tbl2.' as t2','t3.flavour_id=t2.id','left');
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

   public function get_value($id)
    {
          $this->db->select('*, t2.value, t2.id as select_id')
        ->from('product_props t1')
        ->join('product_props_master t3', 't3.id = t1.props_id')
        ->join('product_props_value t2', 't2.id = t1.value_id')
        ->where('t1.is_deleted','NOT_DELETED')
        ->where('t1.product_id',$id)
        ->where('t3.is_selectable','3');
        //$this->db->order_by('t1.value_id','asc');
        //->group_by('t1.value_id');
        $result=$this->db->get()->row();
        //echo $this->db->last_query();
       // $result=($query->num_rows() > 0) ? $query->row() : false;
        return $result;
    }

}
?>