<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class User extends REST_Controller
{
	function __construct()
    {
    	parent::__construct();
		$this->load->model('user_model');
    }
	
	function users_get()
    {
		$result = array();
		if($this->get('id'))
        {
        	$uid = $this->get('id');
			$model = $this->user_model->get_user($uid);			
			
			if(empty($model)){
				$result = array('errorCode' => 204, 'message' => 'User could not be found');
				$this->response($result, 200);
			} else {
				$result = array('errorCode' => 0, 'message' => 'Success', 'data' => $model);
				$this->response($result, 200);
			}
        } else if($this->get('name')){
			$name = $this->get('name');
			$model = $this->user_model->search_user($name);
			
			if(empty($model)){
				$result = array('errorCode' => 204, 'message' => 'Name could not be found');
				$this->response($result, 200);
			} else {
				$result = array('errorCode' => 0, 'message' => 'Success', 'data' => $model);
				$this->response($result, 200);
			}
		} else {
			$model = $this->user_model->get_all_user();
			$result = array('errorCode' => 0, 'message' => 'Success', 'data' => $model);
			
			if(empty($model)){
				$this->response(null, 204);
			} else {
				$this->response($result, 200);
			}
		}
		   
    }

	function register_post(){
		if($this->validate_register()){
			$username = $this->post('username');
			$password = $this->post('password');
			$email = $this->post('email');
			$birthdate = $this->post('birthdate');
			$gender = $this->post('gender');
			
			$model = $this->user_model->check_email($email);
			if(empty($model)){
				$model = $this->user_model->check_username($username);
				if(empty($model)){
					$model = $this->user_model->register($username, $password, $email, $birthdate, $gender);
					if(empty($model)){
						$this->response(array('errorCode' => 406, 'message' => 'Register failed'), 406);
					} else {
						$this->response(array('errorCode' => 200, 'message' => 'Registration successful'), 200);
					}
				} else {
					$this->response(array('errorCode' => 409, 'message' => 'Username already exist'), 409);
				}				
			} else {
				$this->response(array('errorCode' => 409, 'message' => 'Email already exist'), 409);
			}
		} else {
			$this->response(array('errorCode' => 400, 'message' => 'Parameter not completed'), 400);
		}
	}
	
	function login_post()
	{
		$username = $this->post('username');
		$password = $this->post('password');
		if(!empty($username) || !empty($password)){
			$model = $this->user_model->login($username, $password);
			if(empty($model)){
				$this->response(array('errorCode' => 404, 'message' => 'Login Failed'), 404);
			} else {
				$this->response(array('errorCode' => 0, 'message' => 'Success', 'data' => $model), 200);
			}						
		} else {
			$this->response(array('errorCode' => 400, 'message' => 'Parameter not completed'), 400);
		}
	
	}
	
	function update_post()
	{
		$uid = $this->post('user_id');
		$birthdate = $this->post('birthdate');
		$gender = $this->post('gender');
		$f_name = $this->post('first_name');
		$l_name = $this->post('last_name');
		$bio = $this->post('bio');
		
		if($this->validate_update()){
			$model = $this->user_model->update($uid, $birthdate, $gender, $f_name, $l_name, $bio);
			if(empty($model)){
				$this->response(array('errorCode' => 406, 'message' => 'Update failed'), 406);
			} else {
				$this->response(array('errorCode' => 200, 'message' => 'Update profile successful'), 200);
			}
		} else {
			$this->response(array('errorCode' => 400, 'message' => 'Parameter not completed'), 400);
		}		
	}
	
	function validate_register(){
		if(!$this->post('username') || !$this->post('password') || !$this->post('email') || !$this->post('birthdate') || !$this->post('gender')){
			return false;
		} else {
			return true;
		}
	}
	
	function validate_update(){
		if(!$this->post('user_id') || !$this->post('birthdate') || !$this->post('gender') || !$this->post('first_name') || !$this->post('last_name') || !$this->post('bio')){
			return false;
		} else {
			return true;
		}
	}
}

?>