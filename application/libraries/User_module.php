<?php
/**
 * 
 */
class User_module 
{	
	  
	function __construct() {
	    $CI =& get_instance();
	}

	function get_menu($user)
	{
		$CI =& get_instance();
			$user_id = $user->id;
			$user_role = $user->user_role;

			// if ($user->type=='host') {
			// 	$user_role = 5;
			// }
			// // user
			// if ($user=$CI->db->get_where('tb_admin',array('id'=>$user_id))->row()) {
			// 	$user_role=$user->user_role;
			// }
			// else{
			// 	return false;
			// }
			// // user

			// role
			if ($role=$CI->db->get_where('tb_user_role',array('id'=>$user_role))->row()) {
				$role_id=$role->id;
				$role_title=$role->name;
			}
			else{
				return false;
			}
			// role

		// get menu
		if($menu=$this->getMenu($role_id,$role_title))
		{
			$CI->db->order_by('indexing','asc');
			$all_menus = $CI->db->get_where('tb_admin_menu',array('status' => 1 ))->result();
			return $this->printMenu_v($menu,$all_menus);
			// return $menu;
		}
		else
		{
			return false;
		}
		//  get menu

		// echo "<pre>";
		// echo $role_id.'<br>';
		// echo $role_title.'<br>';
		// print_r($menu);
		// print_r($user);
		// echo "</pre>";
	}


	private function printMenu_v($menu,$all_menus)
	{
		// class="active"

		$current_url=trim(str_replace(base_url(),' ',current_url()));
		$printmenu='';
		// Nav Item - Dashboard
		$dasActive = '';
		if ($current_url=='' or $current_url=='dashboard' or $current_url=='dashboard/index') {
			$dasActive = 'active';
		}
		// echo $current_url;
		$printmenu.='<li class="nav-item '.$dasActive.'">';
            $printmenu.='<a href="'.base_url().'">';
                $printmenu.='<i class="ft-home"></i>';
                $printmenu.='<span class="menu-title" data-i18n="">Dashboard</span>';
            $printmenu.='</a>';
        $printmenu.='</li>';



		
		// Nav Item - Dashboard 
		foreach ($menu as $row) { //memu
			($current_url==$row->url) ? $active = 'active' : $active = '';
			if ($row->parent==0 or $row->parent=='0' or $row->parent=='') {
				
				if ($submenu1=$this->getSubMenu($all_menus,$row->id)) {
					$printmenu.='<li class="nav-item ">';
		                $printmenu.='<a href="#">';
		                    $printmenu.='<i class="'.$row->icon_class.'"></i>';
		                    $printmenu.='<span class="menu-title" data-i18n="">';
		                    $printmenu.= $row->title;
		                $printmenu.='</a>';

		                $printmenu.='<ul class="menu-content">';
		                	foreach ($submenu1 as $row1) {
		                	($current_url==$row1->url) ? $sactive = 'active' : $sactive = '';
		                        $printmenu.='<li class="'.$sactive.'">';
			                        $printmenu.='<a class="menu-item" href="'.base_url().$row1->url.'">';
			                            $printmenu.= $row1->title;
			                        $printmenu.='</a>';
			                    $printmenu.='</li>';
		                	}
		                $printmenu.='</ul>';
		            $printmenu.='</li>';

				}
				else
				{
					
					$printmenu.='<li class=" nav-item '.$active.'">';
			            $printmenu.='<a href="'.base_url().$row->url.'">';
			                $printmenu.='<i class="'.$row->icon_class.'"></i>';
			                $printmenu.='<span class="menu-title" data-i18n="">'.$row->title.'</span>';
			            $printmenu.='</a>';
			        $printmenu.='</li>';
					
				}
			}
			
		}

		return $printmenu;
	}

	function getSubMenu($menu,$id)
	{
		$submenu=array();
		foreach ($menu as $row) {
			if ($row->parent==$id) {
				$submenu[]=$row;
			}
		}
		if (count($submenu)>0) {
			return $submenu;
		}
		return false;
	}


	// get menu
	private function getMenu($role_id,$role_title){
		$CI =& get_instance();
		if ($role_title=='developer') {
				$CI->db->order_by('indexing','asc');
				if($menu=$CI->db->get_where('tb_admin_menu', array('status' => 1 ))){
					return $menu->result();
				}
			else{
				return false;
			}
		}
		else{
			$menu_ids='';
			if($menus=$CI->db->get_where('tb_role_menus',array('role_id'=>$role_id))){
				foreach ($menus->result() as $key => $row) {
					$m_ids[] = trim($row->menu_id);
				}

				$CI->db->where_in('id',$m_ids);
				$CI->db->where('status',1);
				$CI->db->order_by('indexing','asc');
				$functions = $CI->db->get('tb_admin_menu')->result();
				// echo _prx($functionss);
				// die();
				return $functions;
			}
			else{
				return false;
			}
		}
	}
	// get menu
}

?>