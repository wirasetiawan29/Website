<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Follow_model extends CI_Model
{
 	function get_following_user($uid)
 	{
 		$this->db->select('a.USER_ID_CHILD as USER_ID, b.USERNAME, b.FIRST_NAME, b.LAST_NAME');
   		$this->db->from('t_follow a, t_user b');
		$this->db->where('a.user_id_child = b.user_id');
		$this->db->where('user_id_parrent', $uid);
		
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
	
	function get_follower_user($uid)
 	{
 		$this->db->select('a.USER_ID_PARRENT as USER_ID, b.USERNAME, b.FIRST_NAME, b.LAST_NAME');
   		$this->db->from('t_follow a, t_user b');
		$this->db->where('a.user_id_parrent = b.user_id');
		$this->db->where('user_id_child', $uid);
		
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
 	
	function create($uid, $fid)
	{
		$data = array(
			'user_id_parrent' => $uid,
			'user_id_child' => $fid,
			'is_follow' => 1
		);
		
		$result = $this->db->insert('t_follow', $data);
		return $result;
	}
}

?>