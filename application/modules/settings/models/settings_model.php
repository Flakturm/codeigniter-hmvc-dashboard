<?php
/*
Author: Andy
Date: 12/4/2016
Version: 1.0
*/

class Settings_model extends CI_Model{

	private $tbl_settings = "settings";
	
	function create()
	{
		
	}
	
	function read()
	{
		$this->db->select('*');
		$query = $this->db->get($this->tbl_settings, 1);	// limit 1
		return ($query->num_rows) ? $query->row_array() : false;
	}
	
	function save($data)
	{
		return $this->db->update($this->tbl_settings, $data);
	}

	function getColumn($column)
	{
		$this->db->select($column);
		$query = $this->db->get($this->tbl_settings, 1);	// limit 1

		if ($query->num_rows)
		{
			$result = $query->row();
			return $result->$column;
		}
		else
		{
			return false;
		}
	}
		
}