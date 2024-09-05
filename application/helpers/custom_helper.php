<?php
/*
 * Custom Helpers
 *
 */

//check admin
if (!function_exists('is_admin')) {
    function is_admin()
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->admin_model->is_admin();
    }
}
if (!function_exists('date_format_func')) {
    function date_format_func($date)
    {
            if($date == NULL)
        	{
        		return "";
        	}
            else if($date == '0000-00-00')
            {
                return "";
            }
        	else
        	{
        		return date('d-m-Y',strtotime($date));
		    }
    }
}
if (!function_exists('rupee_number_to_word')) {
    function rupee_number_to_word($number){
        $no = (int)floor($number);
        $point = (int)round(($number - $no) * 100);
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
         '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
         '7' => 'seven', '8' => 'eight', '9' => 'nine',
         '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
         '13' => 'thirteen', '14' => 'fourteen',
         '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
         '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
         '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
         '60' => 'sixty', '70' => 'seventy',
         '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
          $divider = ($i == 2) ? 10 : 100;
          $number = floor($no % $divider);
          $no = floor($no / $divider);
          $i += ($divider == 10) ? 1 : 2;
     
     
          if ($number) {
             $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
             $hundred = ($counter == 1 && $str[0]) ? null : null;
             $str [] = ($number < 21) ? $words[$number] .
                 " " . $digits[$counter] . $plural . " " . $hundred
                 :
                 $words[floor($number / 10) * 10]
                 . " " . $words[$number % 10] . " "
                 . $digits[$counter] . $plural . " " . $hundred;
          } else $str[] = null;
       }
       $str = array_reverse($str);
       $result = implode('', $str);
     
     
       if ($point > 20) {
         $points = ($point) ?
           "" . $words[floor($point / 10) * 10] . " " . 
               $words[$point = $point % 10] : ''; 
       } else {
           $points = $words[$point];
       }
       if($points != ''){        
           echo ucwords($result . "Rupees and " . $points . " Paise Only");
       } else {
     
           echo ucwords($result . "Rupees Only");
       }
     
     }
}

if (! function_exists('_prx')) {
    function _prx($array)
    {
        return "<pre>".print_r($array,true)."</pre>";
    }
}

function uk_date($date){
    // Assuming you have a datetime string in IST
    $indianDatetimeString = $date;  // Replace this with your datetime string
    
    // Create a DateTime object for the Indian datetime
    $indianDatetime = new DateTime($indianDatetimeString, new DateTimeZone('America/Denver'));
    
    // Convert to Europe/London timezone
    $londonTimezone = new DateTimeZone('Europe/London');
    $indianDatetime->setTimezone($londonTimezone);
    
    // Get the result as a string
    $londonDatetimeString = $indianDatetime->format('d-m-Y');
    
   // echo "Indian datetime: " . $indianDatetimeString . PHP_EOL;
   return $londonDatetimeString . PHP_EOL;

}
function uk_time($date){
    // Assuming you have a datetime string in IST
    $indianDatetimeString = $date;  // Replace this with your datetime string
    
    // Create a DateTime object for the Indian datetime
    $indianDatetime = new DateTime($indianDatetimeString, new DateTimeZone('America/Denver'));
    
    // Convert to Europe/London timezone
    $londonTimezone = new DateTimeZone('Europe/London');
    $indianDatetime->setTimezone($londonTimezone);
    
    // Get the result as a string
    $londonDatetimeString = $indianDatetime->format('H:i:s');
    
   // echo "Indian datetime: " . $indianDatetimeString . PHP_EOL;
   //return $londonDatetimeString . PHP_EOL;
    return (@$londonDatetimeString) ? date('h:i A',strtotime($londonDatetimeString)) : ''; 

}


     function checkLogin(){
		$loggedin = false;
		if (get_cookie('63a490ed05b42') && get_cookie('63a490ed05b43') && get_cookie('63a490ed05b44')) {
			$user_id = value_encryption(get_cookie('63a490ed05b42'),'decrypt');
			$user_nm = value_encryption(get_cookie('63a490ed05b43'),'decrypt');
			$type    = value_encryption(get_cookie('63a490ed05b44'),'decrypt');
			if (is_numeric($user_id) && !is_numeric($user_nm)) {
				$check['id'] 	   = $user_id;
				$check['username'] = $user_nm;
				if ($type=='admin') {
					// $user = $this->admin_model->getRow('admin',$check);
                    $CI =& get_instance();
                   $user = $CI->db->get_where('admin',$check)->row();
				}
				else{
					$user = false;
				}

				if ($user) {
					if ($user->status==1) {
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
	
        function checkShopLogin(){
            $loggedin = false;
            if (get_cookie('63a490ed05b42') && get_cookie('63a490ed05b43') && get_cookie('63a490ed05b44') && get_cookie('63a490ed05b45')) {
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

    // if (!function_exists('getGroup')) {
    //     function getGroup($group_id) {
    //         $CI = &get_instance();
    //         $group_name = $CI->master_model->getRow('group_master',['id'=>$group_id]);
    
    //         return @$group_name->name;
    //     }
    // }
    function getOrdinal($number) {
        $suffix = '';
        if (in_array(($number % 100), range(11, 13))) {
            $suffix = 'th';
        } else {
            switch ($number % 10) {
                case 1: $suffix = 'st'; break;
                case 2: $suffix = 'nd'; break;
                case 3: $suffix = 'rd'; break;
                default: $suffix = 'th'; break;
            }
        }
    
        return $number . $suffix;
    }
    
    function getClass($class_id, $group_id) {
        $CI = &get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('class_master', array('id' => $class_id, 'group_id' => $group_id));
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $class_name = $row->name;
    
            $ordinal_class_id = getOrdinal($class_id);
    
            return "$ordinal_class_id";
        } else {
            return 'Unknown Class'; 
        }
    }

    if (!function_exists('displayPhoto')) {
    function displayPhoto($photo_path) {
        if (!empty($photo_path)) {
            return IMGS_URL.$photo_path;
        } else {
            return base_url('photo/noimg/new.png');
        }
    }
}
    



