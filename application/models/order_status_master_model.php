<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class order_status_master_model extends CI_Model
{
	function index(){
		echo 'This is model index function';
	}
	function __construct(){
		$this->tbl1 = 'order_status_master';
		$this->tbl3 = 'order_status_log';
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
		$this->db->order_by('order','ASC');
		$query = $this->db->get();
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}
	function getRowsNew($order){
		$this->db->select("*");
		$this->db->from($this->tbl1);
		$this->db->where('active','1');
		$this->db->where('order >=',$order);
		$this->db->order_by('order','ASC');
		$query = $this->db->get();
		$result = ($query->num_rows() > 0)?$query->result():FALSE;
		return $result;
	}
	function getCurrentStatus($id){
		$this->db->select("t2.order");
		$this->db->from('orders t1');
		$this->db->join('order_status_master t2 ', 't2.id=t1.status');
		$this->db->where('t1.id',$id);
		$query = $this->db->get()->row();
		return $query;
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
	function SaveLog($data = array()){
		$result = $this->db->insert($this->tbl3,$data);
		return $result;
	}
	function deleteRow($id){
		$this->db->where($this->tbl1.'.'.'id',$id);
		$result = $this->db->delete($this->tbl1);
		return $result;
	}
}
?>