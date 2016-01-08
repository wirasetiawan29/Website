<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tweet_model extends CI_Model
{
 	function get_tweet_user($uid)
 	{
 		$this->db->select('a.*, b.USERNAME, b.FIRST_NAME, b.LAST_NAME');
   		$this->db->from('t_tweet a, t_user b');
		$this->db->where('b.user_id', $uid);		
		$this->db->where('a.user_id', $uid);
		$this->db->order_by("a.tweet_date", "desc"); 
		
   		$query = $this->db->get();

   		if($query -> num_rows() > 0)
   		{
     		return $query->result();
   		}
   		else
   		{
     		return null;
   		}
 	}
	
	function get_mention_user($uid)
 	{ 		
		$this->db->select('username');
		$this->db->from('t_user');
		$this->db->where('user_id', $uid);
		$query = $this->db->get()->row_array();

		$this->db->select('a.*, b.USERNAME, b.FIRST_NAME, b.LAST_NAME');
   		$this->db->from('t_tweet a, t_user b');
		$this->db->where('a.user_id = b.user_id');
		$this->db->like('a.tweet_msg', $query['username'], 'both');
		$this->db->where_not_in('a.user_id', $uid);
		$this->db->order_by('a.tweet_date', 'desc'); 	
		
		$query = $this->db->get();

   		if($query -> num_rows() > 0)
   		{
     		return $query->result();
   		}
   		else
   		{
     		return null;
   		}
 	}
	
	function timeline_user($uid)
 	{
 		$query = $this->db->query('select a.*, b.USERNAME, b.FIRST_NAME, b.LAST_NAME
						 from t_tweet a, t_user b
						 where a.user_id = b.user_id
						 and a.user_id not in (select user_id_child from t_follow where user_id_parrent = '. $uid .')
						 and a.user_id = '. $uid .'
						 union
						 select a.*, b.USERNAME, b.FIRST_NAME, b.LAST_NAME
						 from t_tweet a, t_user b
						 where a.user_id = b.user_id
						 and a.user_id in (select user_id_child from t_follow where user_id_parrent = '. $uid .')
						 union 
						 (select a.TWEET_ID, a.RETWEET_FROM as USER_ID, getTweetMsg(a.TWEET_ID) as TWEET_MSG, a.RETWEET_DATE, b.USERNAME, b.FIRST_NAME, b.LAST_NAME
						 from t_retweet a, t_user b
						 where a.retweet_from = b.user_id
						 and a.retweet_to = '. $uid . ') order by tweet_date desc');
						 
   		if($query -> num_rows() > 0)
   		{
     		return $query->result();
   		}
   		else
   		{
     		return null;
   		}
 	}
	
	function post_tweet($uid, $msg)
	{
		$date = new DateTime(date('Y-m-d H:i:s'));	
		$data = array(
			'tweet_id' => $date->format('U'),
			'user_id' => $uid,
			'tweet_msg' => $msg,
			'tweet_date' => date('Y-m-d H:i:s')
		);
		
		$result = $this->db->insert('t_tweet', $data);
		return $result;
	}
}

?>