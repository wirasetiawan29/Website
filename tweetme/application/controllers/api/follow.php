<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Follow extends REST_Controller
{
	function __construct()
    {
    	parent::__construct();
		$this->load->model('follow_model');
    }
	
	function following_get()
    {
		$result = array();
		if($this->get('id'))
        {
        	$uid = $this->get('id');
			$model = $this->follow_model->get_following_user($uid);			
			
			if(empty($model)){
				$result = array('errorCode' => 204, 'message' => 'User\'s following could not be found');
				$this->response($result, 200);
			} else {
				$result = array('errorCode' => 0, 'message' => 'Success', 'data' => $model);
				$this->response($result, 200);
			}
        } else {
			$this->response(null, 204);
		}
		   
    }
	
	function follower_get()
    {
		$result = array();
		if($this->get('id'))
        {
        	$uid = $this->get('id');
			$model = $this->follow_model->get_follower_user($uid);			
			
			if(empty($model)){
				$result = array('errorCode' => 204, 'message' => 'User\'s follower could not be found');
				$this->response($result, 200);
			} else {
				$result = array('errorCode' => 0, 'message' => 'Success', 'data' => $model);
				$this->response($result, 200);
			}
        } else {
			$this->response(null, 204);
		}
		   
    }

	function create_post(){
		$uid = $this->post('user_id');
		$fid = $this->post('friend_id');
		if(empty($uid) || empty($fid)){
			$this->response(array('errorCode' => 400, 'message' => 'Parameter not completed'), 400);
		} else {
			$model = $this->follow_model->create($uid, $fid);
			if(empty($model)){
				$this->response(array('errorCode' => 406, 'message' => 'Following failed'), 406);
			} else {
				$this->response(array('errorCode' => 200, 'message' => 'Following successful'), 200);
			}
		}
	}
}

?>