<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Admin extends CI_Controller {



    public function __construct()

    {

        parent::__construct();

        

    }

    public function isLoggedIn(){

        $is_logged_in = $this->session->userdata('admin_logged_in');

        if(!isset($is_logged_in) || $is_logged_in!==TRUE)

        {

            redirect(base_url());

            exit;

        }

    }

    public function check_role(){

        $data['user']  = $user         = checkLogin();

        $admin_role_id = $user->role_id;

        if($admin_role_id !== '1')

        {

            redirect(base_url());

            exit;

        }    

    } 

    public function index()

    {

        $data['user']  = $user         = checkLogin();

        if(!empty($user))

        {

            base_url().'admin-dashboard';

        }else{

        $this->load->view('auth/login',$data);

        }

    }

    public function header_and_footer($page, $data)

    {

        $data['user']  = $user         = checkLogin();

        $admin_role_id = $user->role_id;

        $user_id = $user->id;

        $data['role_id'] = $admin_role_id;

        $data['dashboard'] = $this->admin_model->get_row_data('admin','id',$user_id);

        $data['admin_menus'] = $this->admin_model->get_role_menu_data($admin_role_id);

       

        $this->load->view('admin/includes/header',$data);

        $this->load->view($page);

        $this->load->view('admin/includes/footer');

    }

    public function admin_login()

	{

        $username = $this->input->post('userName');

        $password = md5($this->input->post('password'));

        //call the model for auth

        if($this->admin_model->admin_login($username, $password)){

            // echo "success";exit;

            // $this->load->view('admin/dashboard');

            redirect('admin-dashboard');

        }



        else

        {

            $this->session->set_flashdata('errormsg', 'Wrong Username or Password!!');

            redirect($this->agent->referrer());

            // $this->load->view('auth/login');

        }

	}



    // admin login by cookie

    public function adminlogin($type='admin')

	{

        

		if ($this->input->server('REQUEST_METHOD')=='POST') {

			if (!$_POST['userName'] or !$_POST['password']) {

				$return['res'] = 'error';

				$return['msg'] = 'Please Enter Username & Password !';

				echo json_encode($return); die();

			}

			

			$check['username'] = $_POST['userName'];

			$type = $_POST['type'];

			if (@$_POST['type']=='admin') {

				$user = $this->admin_model->getRow('admin',$check);

				 $user_password = $this->encryption->decrypt(@$user->password);

			}

			else{

				$user = false;

			}



			if ($user) {

				if ($user->status==1) {

					if ($_POST['password']==$user_password) {

						$user = array_encryption($user);

						$type = value_encryption($type,'encrypt');

						set_cookie('63a490ed05b42',$user['id'],8000*24*30);

						set_cookie('63a490ed05b43',$user['userName'],8000*24*30);

						set_cookie('63a490ed05b44',$type,8000*24*30);

                        set_cookie('63a490ed05b45','admin_logged_in',TRUE);

						$return['res'] = 'success';

						$return['msg'] = 'Login Successful Please Wait Redirecting...';

						$return['redirect_url'] = base_url().'admin-dashboard';

					}

					else {

						$return['res'] = 'error';

						$return['msg'] = 'Incorrect Password';

					}

				}

				else {

					$return['res'] = 'error';

					$return['msg'] = 'Account Temporarily Disabled!';

				}

			}

			else {

				$return['res'] = 'error';

				$return['msg'] = 'User Not Found!';

			}

			echo json_encode($return);



		}

	}

	

     //admin logout

     public function admin_logout()

     {

            delete_cookie('63a490ed05b42');	

		    delete_cookie('63a490ed05b43');	

		    delete_cookie('63a490ed05b44');	

		    redirect(base_url());

        //  $this->admin_model->admin_logout();

        //  redirect(base_url());

     }

    public function admin_dashboard()

	{

        // $this->isLoggedIn();

        // $this->check_role();

        $data['user']  = $user         = checkLogin();

        $data['title'] = 'Admin Dashboard';

        $page = 'admin/dashboard';

        $this->header_and_footer($page, $data);

	}

    public function admin_profile()

	{

        $data['user']  = $user         = checkLogin();

        $this->check_role();

        $user_id = $user->id;

        $data['title'] = 'Admin Profile';

        $data['admin_data'] = $this->admin_model->get_row_data('admin','id',$user_id);

        $page = 'admin/admin_profile';

        $this->header_and_footer($page, $data);

	}



    public function edit_admin_profile()

	{

        $data['user']  = $user         = checkLogin();

        $this->check_role();

        $id = $this->uri->segment(2);



        $data = array(

            'userName'     => $this->input->post('userName'),

            'fullname'     => $this->input->post('fullname'),

            'contact'     => $this->input->post('contact'),

            'email'     => $this->input->post('email'),

        );



        if ($this->admin_model->edit_admin_profile($data,$id)) {

            redirect($this->agent->referrer());

        } else {

            redirect($this->agent->referrer());

        }

    

    }

    public function admin_change_password()

	{

        $data['user']  = $user         = checkLogin();

        $this->check_role();

        $data['title'] = 'Change Password';

        $page = 'admin/admin_change_password';

        $this->header_and_footer($page, $data);

	}

    public function update_admin_password()

	{

        $data['user']  = $user         = checkLogin();

        $this->check_role();

        $password = $this->input->post('new_password');

        $data = array(

            'password'     => md5($this->input->post('new_password')),

        );

        $old_pass = md5($this->input->post('old_password'));

        $result = $this->admin_model->check_old_password($old_pass);



        if($result)

        {

            if ($this->admin_model->edit_data('admin','1',$data)) {

                $this->session->set_flashdata('success','Password Changed Successfully..');

                redirect($this->agent->referrer());

            } else {

                $this->session->set_flashdata('error','Password Not Changed!!');

                redirect($this->agent->referrer());

            }

        }

        else

        {

            $this->session->set_flashdata('error','Old Password Does not match!!');

			redirect($this->agent->referrer());

        }

	}


}

?>