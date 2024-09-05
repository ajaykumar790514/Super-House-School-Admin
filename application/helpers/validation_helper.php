<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
// ******* validate_mobile *******
if (!function_exists('validate_mobile')) {
    function validate_mobile($mobile) {
        return preg_match('/^[0-9]{10}+$/', $mobile);
    }
}
// ******* validate_mobile *******


// ******* validate_email *******
if (!function_exists('validate_email')) {
    function validate_email($email) {
         return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
// ******* validate_email *******

?>