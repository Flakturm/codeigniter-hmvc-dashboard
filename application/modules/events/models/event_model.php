<?php
/*
Author: Andy
Date: 12/4/2016
Version: 1.0
*/

class Event_model extends CI_Model{

	private $tbl_event = "events";
	private $tbl_categories = "categories";
	
	function create(){
		
	}
	
	function read(){
		$query = $this->db->query("SELECT *, CONCAT(prefix, LPAD(event_id, 2, '0')) AS uid, DATE_FORMAT(room_open_time, '%Y-%m-%d') AS event_date, category_name 
								   FROM $this->tbl_event e
								   INNER JOIN $this->tbl_categories c
								   ON e.category_id = c.category_id
								   ORDER BY event_id DESC");
		return $query->result();
	}

	function getEvent($event_id){
		$query = $this->db->query("SELECT e.*, c.* 
								   FROM $this->tbl_event e
								   INNER JOIN $this->tbl_categories c
								   ON e.category_id = c.category_id
								   WHERE event_id = $event_id LIMIT 1");

		return ($query->num_rows) ? $query->row_array() : false;
	}

	function getEventBySlug($event_title)
	{
		$this->db->select('event_id')
				 ->where('slug', $event_title);
		$query = $this->db->get($this->tbl_event);
		$result = $query->row();
		return ($query->num_rows) ? $this->getEvent($result->event_id) : false;
	}

	function update($event_id = null, $data){

		if ($event_id) // if the record exists then update it
		{	
			if ( $this->checkCategoryStatus( $event_id, $data['category_id'], $data['room_open_time'] ) )
			{ // IMPORTANT - remove this block if no restriction
				if ($data['status'] == '進行中') {
					return array( 'message' => '此類別本月已有活動進行中' );
				}
			}
			if ( $this->checkEventTitle( $event_id, $data['event_title'] ))
			{ // if event title exists
				return array( 'message' => '活動名稱已被使用' );
			}
			$this->db->where('event_id', $event_id);
			$this->db->update($this->tbl_event, $data);
		}
		else // if not, add new record
		{
			$this->db->insert($this->tbl_event, $data);
		}

		return (bool)($this->db->affected_rows() > 0);
	}
	
	function delete(){
		
	}

	function getStatuses() {
		$row = $this->db->query("SHOW COLUMNS FROM $this->tbl_event LIKE 'status'")->row()->Type;
		$regex = "/'(.*?)'/";
		preg_match_all( $regex , $row, $enum_array );

		$array = array();

		foreach ($enum_array[1] as $value)
		{
			$array[$value] = $value;
		}

		return $array;
	}

	function getCategories($id = null) {

		$this->db->select('*');

		if ($id)
		{
			$this->db->where($id);
		}

		$query = $this->db->get($this->tbl_categories);

		$array = array();

		foreach ($query->result_array() as $row)
		{
			$array[$row['category_id']] = $row['category_name'];
		}

		return $array;
	}

	function getAllSlots($event_id)
	{
		$this->db->select('slots')
				 ->where('event_id', $event_id);
		$query = $this->db->get($this->tbl_event);
		
		if ($query->num_rows)
		{
			$result = $query->row();
			return (int)$result->slots;
		}
		else
		{
			return false;
		}
	}

	function getWaitingSlots($event_id)
	{
		$this->db->select('waiting_slots')
				 ->where('event_id', $event_id);
		$query = $this->db->get($this->tbl_event);
		
		if ($query->num_rows)
		{
			$result = $query->row();
			return (int)$result->waiting_slots;
		}
		else
		{
			return false;
		}
	}

	function getTakenSlots($event_id, $status = '訂位')
	{

		$fail = ( $status == '訂位' )? ' AND fail = 0' : '';

		$query = $this->db->query("SELECT other_part.total + part.total as used
								   FROM
									(
									  	SELECT COUNT(*) as total
										FROM extra_participants ep
										JOIN participants p
										WHERE p.participant_id = ep.participant_id AND status = '$status' $fail AND event_id = $event_id
									) as other_part, (
										SELECT COUNT(*) as total
										FROM participants p 
										WHERE  event_id = $event_id $fail AND status = '$status'
									) as part");
		$result = $query->row();

		return $result->used;
	}

	function getRemainingSlots($event_id)
	{
		return $this->getAllSlots($event_id) - $this->getTakenSlots($event_id);
	}

	function getRemainingWaitingSlots($event_id)
	{
		return $this->getWaitingSlots($event_id) - $this->getTakenSlots($event_id, '候補');
	}
	
	function checkCategoryStatus($event_id, $category_id, $room_open_time)
	{
		// each category can only have one running event in that month.
		$timestamp = strtotime($room_open_time);
		$year = date("Y", $timestamp);
		$month = date("m", $timestamp);

		$this->db->select('*')
				 ->where('category_id', $category_id)
				 ->where('status', '進行中')
				 ->where("date_format(room_open_time, '%Y') =", $year)
				 ->where("date_format(room_open_time, '%m') =", $month)
				 ->where('event_id <>', $event_id);

		$query = $this->db->get($this->tbl_event);
		return ($query->num_rows) ? true : false;
	}

	function checkEventTitle($event_id, $event_title)
	{
		$this->db->select('*')
				 ->where('event_title', $event_title)
				 ->where('event_id <>', $event_id);
		$query = $this->db->get($this->tbl_event);
		return ($query->num_rows) ? true : false;
	}
		
}