<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Tweet extends REST_Controller
{
	function __construct()
    {
    	parent::__construct();
		$this->load->model('tweet_model');
		$this->load->model('retweet_model');
    }
	
	function user_get()
    {
		$result = array();
		if($this->get('id'))
        {
        	$uid = $this->get('id');
			$model = $this->tweet_model->get_tweet_user($uid);			
			
			if(empty($model)){
				$result = array('errorCode' => 204, 'message' => 'User\'s tweet could not be found');
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
		$msg = $this->post('message');
		if(empty($uid) || empty($msg)){
			$this->response(array('errorCode' => 400, 'message' => 'Parameter not completed'), 400);
		} else {
			$model = $this->tweet_model->post_tweet($uid, $msg);
			if(empty($model)){
				$this->response(array('errorCode' => 406, 'message' => 'Post tweet failed'), 406);
			} else {
				$this->response(array('errorCode' => 0, 'message' => 'Post tweet successful'), 200);
			}
		}
	}
	
	function retweet_post(){
		$uid = $this->post('user_id');
		$fid = $this->post('friend_id');
		$tweet_id = $this->post('tweet_id');
		if(empty($uid) || empty($fid) || empty($tweet_id)){
			$this->response(array('errorCode' => 400, 'message' => 'Parameter not completed'), 400);
		} else {
			$model = $this->retweet_model->retweet($fid, $uid, $tweet_id);
			if(empty($model)){
				$this->response(array('errorCode' => 406, 'message' => 'Retweet failed'), 406);
			} else {
				$this->response(array('errorCode' => 200, 'message' => 'Reweet successful'), 200);
			}
		}
	}
	
	function mention_get()
    {
		$result = array();
		if($this->get('id'))
        {
        	$uid = $this->get('id');
			$model = $this->tweet_model->get_mention_user($uid);			
			
			if(empty($model)){
				$result = array('errorCode' => 204, 'message' => 'User\'s mention could not be found');
				$this->response($result, 200);
			} else {
				$result = array('errorCode' => 0, 'message' => 'Success', 'data' => $model);
				$this->response($result, 200);
			}
        } else {
			$this->response(null, 204);
		}
		   
    }
	
	function timeline_get()
    {
		$result = array();
		if($this->get('id'))
        {
        	$uid = $this->get('id');
			$model = $this->tweet_model->timeline_user($uid);			
			
			if(empty($model)){
				$result = array('errorCode' => 204, 'message' => 'User\'s timeline could not be found');
				$this->response($result, 200);
			} else {
				$result = array('errorCode' => 0, 'message' => 'Success', 'uid' => $uid,'data' => $model);
				$this->response($result, 200);
			}
        } else {
			$this->response(null, 204);
		}
		   
    }
}

?>