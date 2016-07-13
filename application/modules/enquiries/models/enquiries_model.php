<?php
/*
Author: Andy
Date: 12/4/2016
Version: 1.0
*/

class Enquiries_model extends CI_Model{

	private $tbl_enquiries = "enquiries";
	
	function create($data){
		return (bool)$this->db->insert($this->tbl_enquiries, $data);
	}
	
	function read(){

	}

	function getEnquiries($id = '') {
		$this->db->select("*");

		if ( $id )
		{
			$this->db->where("enquiry_id", $id);
		}

		$query = $this->db->get($this->tbl_enquiries);

		if ( $id )
		{	// fetch single record
			return ($query->num_rows) ? $query->row_array() : false;
		}
		else
		{
			return $query->result();
		}
	}

	function getStatuses() {
		$row = $this->db->query("SHOW COLUMNS FROM $this->tbl_enquiries LIKE 'enquiry_status'")->row()->Type;
		$regex = "/'(.*?)'/";
		preg_match_all( $regex , $row, $enum_array );

		$array = array();

		foreach ($enum_array[1] as $value)
		{
			$array[$value] = $value;
		}

		return $array;
	}

	function update($id, $colunm, $value){
		$this->db->set($colunm, $value);
		$this->db->where('enquiry_id', $id);
		$this->db->update($this->tbl_enquiries);
	}
	
	function delete(){
		
	}
		
}