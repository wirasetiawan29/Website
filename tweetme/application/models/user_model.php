<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
 	function get_all_user()
 	{
 		$this->db->select('*');
   		$this->db->from('t_user');
		
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
	
	function get_user($id)
 	{
 		$this->db->select('*');
   		$this->db->from('t_user');
		$this->db->where('user_id', $id);
		
   		$query = $this->db->get();

   		if($query -> num_rows() > 0)
   		{
     		return $query->row();
   		}
   		else
   		{
     		return null;
   		}
 	}
	
	function search_user($name)
 	{
 		$this->db->select('*');
   		$this->db->from('t_user a, t_role b');
		$this->db->where('a.role_id', 2);
		$this->db->where('a.role_id = b.role_id');		
		$this->db->like('first_name', $name, 'after');
		
   		$query = $this->db->get();

   		if($query -> num_rows() > 0)
   		{
     		return $query->row();
   		}
   		else
   		{
     		return null;
   		}
 	}
	
	function login($username, $password)
	{		
		$this->db->select('user_id');
		$this->db->from('t_user');
		$this->db->where('username', $username);
		$this->db->where('password', md5($password));
		
		$query = $this->db->get();
		
		if($query -> num_rows() == 1)
   		{
     		return $query->row();
   		}
   		else
   		{
     		return null;
   		}
	}
	
	function check_email($email)
	{		
		$this->db->select('email');
		$this->db->from('t_user');
		$this->db->where('email', $email);
		
		$query = $this->db->get();
		
		if($query -> num_rows() == 1)
   		{
     		return $query->row();
   		}
   		else
   		{
     		return null;
   		}
	}
	
	function check_username($username)
	{		
		$this->db->select('username');
		$this->db->from('t_user');
		$this->db->where('username', $username);
		
		$query = $this->db->get();
		
		if($query -> num_rows() == 1)
   		{
     		return $query->row();
   		}
   		else
   		{
     		return null;
   		}
	}
 	
	function register($username, $password, $email, $birthdate, $gender)
	{
		$epoch = new DateTime(date('Y/m/d H:i:s'));	
		$data = array(
			'user_id' => $epoch->format('U'),
			'role_id' => 2,
			'status_id' => 1,
			'username' => $username,
			'password' => md5($password),
			'email' => $email,
			'birthdate' => $birthdate,
			'gender' => $gender
		);
		
		$result = $this->db->insert('t_user', $data);
		return $result;
	}
	
	function update($uid, $birthdate, $gender, $f_name, $l_name, $bio)
	{
		$data = array(
			'birthdate' => $birthdate,
			'gender' => $gender,
			'first_name' => $f_name,
			'last_name' => $l_name,
			'bio' => $bio
		);
		
		$this->db->where('user_id', $uid);
		$result = $this->db->update('t_user', $data);
		return $result;		
	}
}

?>