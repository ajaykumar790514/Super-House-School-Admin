<?php
function array_encryption($data,$type='encrypt')
{
    $CI =& get_instance();
    $CI->load->library('encryption');

	$return=array();
	foreach ($data as $key => $value) {
		$return[$key] = $CI->encryption->$type($value);
	}
	return $return;
}

function value_encryption($data,$type='decrypt')
{
    $CI =& get_instance();
    $CI->load->library('encryption');
	return $CI->encryption->$type($data);
	
}


function decrypt_array_value($array)
{
    $CI =& get_instance();
    $CI->load->library('encryption');
    $return=array();
	foreach ($array as $key => $value) {
		$return[$key] = $CI->encryption->decrypt($value);
	}
	return $return;
}

?>