<?php
/*
Author: Andy
Date: 12/4/2016
Version: 1.0
*/

class User_model extends CI_Model{
	
	var $table = "users";
	
	function __construct(){
		parent::__construct();
	}
	
	function create($raw_data) {
		$data = array(
			'user_email'	=> $raw_data['user_email'],
			'user_nicename' => $raw_data['user_nicename'],
			'user_pass'		=> $raw_data['user_pass'],
			'user_status'	=> $raw_data['user_status']
		);

		if ( $this->db->insert($this->table, $data) AND $this->db->insert('users_roles', array('user_id' => $this->db->insert_id(), 'role_id' => $raw_data['role_id'])) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function read(){
		$query = $this->db->query("SELECT $this->table.*, roles.name as role_name 
								   FROM $this->table 
								   INNER JOIN users_roles ON $this->table.id = users_roles.user_id
								   INNER JOIN roles ON users_roles.role_id = roles.id");
		return $query->result();
	}
	
	function user_by_id($id){
		$query = $this->db->query("
			SELECT * 
			FROM $this->table
			WHERE id = $id
		");
		
		$query->row()->role = $this->get_role($id);
		$query->row()->role_name = $this->get_role_name($query->row()->role);
		
		if($query->num_rows > 0){
			return $query->row();
		}else{
			return false;
		}
	}
	
	function user_by_nicename($user_nicename){
		//Get ID
		$query = $this->db->query("SELECT id FROM $this->table WHERE user_nicename = ?", $user_nicename);
				
		if($query->num_rows > 0){
			return $this->user_by_id($query->row()->id);
		}else{
			return false;
		}
	}
	
	function update($userid, $userdata){
		$data = (array)$userdata;
		$where = "id = $userid"; 
		$str = $this->db->update_string($this->table, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	
	function updateUser($id, $colunm, $value)
	{
		$this->db->set($colunm, $value);
		$this->db->where('id', $id);
		$this->db->update($this->table);
	}

	function updateUserRole($id, $colunm, $value)
	{
		$this->db->set($colunm, $value);
		$this->db->where('user_id', $id);
		$this->db->update('users_roles');
	}
	
	function delete($id){
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}

	function checkUserEmail($email)
	{
		$this->db->where('user_email', $email);
		$query = $this->db->get($this->table);
		if ( $query->num_rows > 0 )
		{
			return true;	// email has been taken
		}
		else
		{
			return false;
		}
	}

	function getRoles()
	{
		$query = $this->db->get('roles');
		$result = $query->result_array();
		$array = array();

		foreach ($result as $key => $value) {
			$array[$value['id']] = $value['name'];
		}
		return $array;
	}
	
	function get_role($user_id){
		$query = $this->db->query("SELECT role_id FROM users_roles WHERE user_id = $user_id");
		if($query->num_rows > 0){
			return (int)$query->row()->role_id;
		}else{
			return 0;
		}
	}
	function get_role_name($role_id){
		$query = $this->db->query("SELECT name FROM roles WHERE id = $role_id");
		if($query->num_rows > 0){
			return $query->row()->name;
		}else{
			return false;
		}
	}
	
	function getUserByEmail($user_email){
		$query = $this->db->query("SELECT * FROM $this->table WHERE user_email = '$user_email'");
		if($query->num_rows === 1){
			return $query->row();
		}else{
			return false;
		}
	}
	
		
}