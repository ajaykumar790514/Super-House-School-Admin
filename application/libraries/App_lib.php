<?php 
/**
 * 
 */
#[\AllowDynamicProperties]
class App_lib 
{
	// public $this->CI ;
	function __construct() {
		// parent::__construct();
	    $this->CI =& get_instance();
	}

	public function get_options($tb,$id='id',$name='name')
	{
		$result = $this->CI->db->get($tb)->result();

		if (@$result):
			$array[''] = '-- Select --';
			foreach ($result as $key => $value) {
				$array[$value->$id] = $value->$name;
			}
		else:
			$array[''] = 'Nothing To Select!';
		endif;

		return $array;
	}

	public function countries()
	{
		$result = $this->CI->db->get('countries')->result();

		if (@$result):
			$array[''] = '-- Select --';
			foreach ($result as $key => $value) {
				$array[$value->id] = $value->name;
			}
		else:
			$array[''] = 'Nothing To Select!';
		endif;

		return $array;
	}

	public function states($country_id=null)
	{
		$this->CI->db->where('country_id',$country_id);
		$result = $this->CI->db->get('states')->result();
		if (@$country_id) :
			if (@$result):
				$array[''] = '-- Select --';
				foreach ($result as $key => $value) {
					$array[$value->id] = $value->name;
				}
			else:
				$array[''] = 'Nothing To Select!';
			endif;
		else:
			$array[''] = 'First Select Country';
		endif;
		return $array;
	}

	public function cities($state_id=null)
	{
		$this->CI->db->where('state_id',$state_id);
		$result = $this->CI->db->get('cities')->result();
		if (@$state_id) :
			if (@$result):
				$array[''] = '-- Select --';
				foreach ($result as $key => $value) {
					$array[$value->id] = $value->name;
				}
			else:
				$array[''] = 'Nothing To Select!';
			endif;
		else:
			$array[''] = 'First Select State';
		endif;
		return $array;
	}

	public function categories($parent)
	{
		$cond['is_parent']		= $parent;
		$cond['is_deleted']		= 'NOT_DELETED';
		$cond['active']			= 1;
		$result = $this->CI->db->get_where('products_category',$cond)->result();
		return $result;
		// if (@$result):
		// 	$array[''] = '-- Select --';
		// 	foreach ($result as $key => $value) {
		// 		$array[$value->id] = $value->name;
		// 	}
		// else:
		// 	$array[''] = 'Nothing To Select!';
		// endif;
		// return $array;
	}

	public function products($parent_cat_id=NULL,$sub_cat_id=NULL)
	{
		$cond['is_deleted']		= 'NOT_DELETED';
		
		$this->CI->db->select("mtb.*,
							pc.name as category,
							psc.name as sub_category,
							CONCAT(mtb.name,' ( ',mtb.unit_value,' ', u.name,' ) ') as name
							");
		$this->CI->db->from('products_subcategory mtb');
		$this->CI->db->join('products_category pc','pc.id = mtb.parent_cat_id','left');
		$this->CI->db->join('products_category psc','psc.id = mtb.sub_cat_id','left');
		$this->CI->db->join('unit_master u','u.id = mtb.unit_type_id','left');
		$this->CI->db->where('mtb.is_deleted','NOT_DELETED');
		if (@$parent_cat_id) {
			$this->CI->db->where('mtb.parent_cat_id',$parent_cat_id);
		}
		if (@$sub_cat_id) {
			$this->CI->db->where('mtb.sub_cat_id',$sub_cat_id);
		}
		$result = $this->CI->db->get()->result();
		return $result;
	}

	public function main_clinic()
	{
		$this->CI->db->select("mtb.*,
							s.name as state_name,
							c.name as city_name");
		$this->CI->db->from('clinics mtb');
		$this->CI->db->join('states s','s.id = mtb.state','left');
		$this->CI->db->join('cities c','c.id = mtb.city','left');
		$this->CI->db->where('mtb.is_deleted','NOT_DELETED');
		$this->CI->db->where('mtb.user_role',7);
		return $this->CI->db->get()->row();
	}


	public function unit_master()
	{
		$cond['is_deleted']		= 'NOT_DELETED';
		$cond['active']			= 1;
		$result = $this->CI->db->get_where('unit_master',$cond)->result();
		return $result;
	}

	public function clinics()
	{
		$cond['is_deleted']		= 'NOT_DELETED';
		$result = $this->CI->db->get_where('clinics',$cond)->result();
		return $result;
	}

	public function patient_code($patient_id,$clinic_id)
	{
		$clinic = $this->CI->db->get_where('clinics',['id'=>$clinic_id])->row();
		$code 	= $clinic->code.$patient_id;
		return $code;
	}

	public function inventory($id)
	{
		$this->CI->db->select("mtb.*,
							pc.name as category,
							psc.name as sub_category,
							CONCAT(p.name,' ( ',p.unit_value,' ', u.name,' ) ') as name
							");
		$this->CI->db->from('shops_inventory mtb');
		$this->CI->db->join('products_subcategory p','p.id = mtb.product_id','INNER');
		$this->CI->db->join('products_category pc','pc.id = p.parent_cat_id','left');
		$this->CI->db->join('products_category psc','psc.id = p.sub_cat_id','left');
		$this->CI->db->join('unit_master u','u.id = p.unit_type_id','left');
		$this->CI->db->where('mtb.is_deleted','NOT_DELETED');
		$this->CI->db->where('p.is_deleted','NOT_DELETED');
		$this->CI->db->where('mtb.id',$id);
		return $this->CI->db->get()->row();
	}

	public function appointment_status()
	{
		$this->CI->db->select('*');	
		$this->CI->db->from('appointment_status');	
		$result = $this->CI->db->get()->result();	
		
		if (@$result):
			$array[''] = '-- Select --';
			foreach ($result as $key => $value) {
				$array[$value->id] = $value->status;
			}
		else:
			$array[''] = 'Nothing To Select!';
		endif;
		
		return $array;
	}

	public function app_users($limit=null,$start=null)
	{
		// $this->db->order_by('id','desc');	
		$limit_query = '';		
		if ($limit!=null) {
			$limit_query = " LIMIT $start , $limit ";
		}
		$where = '';

		$this->CI->db->select('mtb.mobile, mtb.role_id, mtb.user_language, mtb.status,
							ue.*,up.start_date,up.end_date');
		$this->CI->db->from('users mtb');
		$this->CI->db->join('user_extended ue','ue.user_id = mtb.id','INNER');
		$this->CI->db->join('user_plan_details up','up.user_id = mtb.id','LEFT');
		
		
       
		

		
		$result = $this->CI->db->get()->result();

		// echo _prx($result);
		// die();
		
		if (@$result):
			$array[''] = '-- Select --';
			foreach ($result as $key => $value) {
				$array[$value->user_id] = $value->name. ' ('.$value->mobile.')';
			}
		else:
			$array[''] = 'Nothing To Select!';
		endif;
		
		return $array;
	}
}

 ?>