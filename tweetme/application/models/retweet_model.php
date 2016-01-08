<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Retweet_model extends CI_Model
{
	function retweet($fid, $uid, $tweet_id)
	{
		$data = array(
			'retweet_from' => $fid,
			'retweet_to' => $uid,
			'tweet_id' => $tweet_id,
			'retweet_date' => date('Y-m-d H:i:s')
		);
		
		$result = $this->db->insert('t_retweet', $data);
		return $result;
	}
}

?>