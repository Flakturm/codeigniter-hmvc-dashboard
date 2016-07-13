<?php
/*
Author: Andy
Date: 12/4/2016
Version: 1.0
*/

class Participant_model extends CI_Model{

	private $tbl_participants = "participants";
	private $tbl_extra_participants = "extra_participants";
	private $tbl_event = "events";
	
	function create($data, $more_data = array()){
		$this->db->insert($this->tbl_participants, $data);

		if ( isset($more_data['extra_people']) AND $more_data['extra_people'] > 1 )
		{
			for ( $i = 0; $i < $more_data['extra_people'] - 1; $i++ )
			{
				$extra_data = array(
					'participant_id' => $this->db->insert_id(),
					'other_participant_name' => $more_data['other_participant_name'][$i]['name'],
					'other_participant_phone' => $more_data['other_participant_phone'][$i]['phone']
				);
				$this->db->insert($this->tbl_extra_participants, $extra_data);
			}			
		}
	}
	
	function getParticipantId($data){
		$this->db->select('participant_id')
				 ->where('order_id', $data['order_id']);

		if ( isset($data['email']) AND ! is_null($data['email']) ) 
		{
			$this->db->where('email', $data['email']);
		}
		
		$query = $this->db->get($this->tbl_participants);
		if ($query->num_rows)
		{
			$result = $query->row();
			return $result->participant_id;
		}
		else
		{
			return FALSE;
		}
	}

	function getParticipants($id = '') {
		$this->db->select("COUNT(extra_participants_id) AS extra_ppl, $this->tbl_participants.*, event_title", false)
				 ->from($this->tbl_participants)
				 ->join($this->tbl_event, "$this->tbl_event.event_id = $this->tbl_participants.event_id")
				 ->join($this->tbl_extra_participants, "$this->tbl_extra_participants.participant_id = $this->tbl_participants.participant_id", 'left')
				 ->group_by("$this->tbl_participants.participant_id");

		if ( $id )
		{
			$this->db->where("$this->tbl_participants.participant_id", $id);
		}

		$query = $this->db->get();
		if ( $id )
		{	// fetch single record
			return ($query->num_rows) ? $query->row_array() : false;
		}
		else
		{
			return $query->result();
		}
	}

	function getExtraParticipants($id) {
		$this->db->select('*')
				 ->where('participant_id', $id);
		$query = $this->db->get($this->tbl_extra_participants);
		return ($query->num_rows) ? $query->result_array() : false;
	}

	function setBookigStatus($order_id, $bool = TRUE)
	{
		$this->db->set('fail', $bool);
		$this->db->where('order_id', $order_id);
		$this->db->update($this->tbl_participants);
	}

	function bookingFailed($order_id)
	{
		$this->db->select('fail')
				 ->where('order_id', $order_id);
		$query = $this->db->get($this->tbl_participants);

		$result = $query->row();
		return $result->fail;
	}

	function getStatuses() {
		$row = $this->db->query("SHOW COLUMNS FROM $this->tbl_participants LIKE 'status'")->row()->Type;
		$regex = "/'(.*?)'/";
		preg_match_all( $regex , $row, $enum_array );

		$array = array();

		foreach ($enum_array[1] as $value)
		{
			$array[$value] = $value;
		}

		return $array;
	}

	function getInvoiceTypes()
	{
		$row = $this->db->query("SHOW COLUMNS FROM $this->tbl_participants LIKE 'invoice_types'")->row()->Type;
		$regex = "/'(.*?)'/";
		preg_match_all( $regex , $row, $enum_array );

		$array = array();

		foreach ($enum_array[1] as $value)
		{
			$array[$value] = $value;
		}

		return $array;
	}

	function getEventId($id) {
		$this->db->select('event_id')
				 ->where('participant_id', $id);
		$query = $this->db->get($this->tbl_participants);
		if ($query->num_rows)
		{
			$result = $query->row();
			return $result->event_id;
		}
		else
		{
			return false;
		}
	}

	function getSlotsByPerson($id)
	{
		$query = $this->db->query("SELECT other_part.total + part.total as slots
								   FROM
									(
										SELECT COUNT(*) as total
										FROM extra_participants
										WHERE participant_id  = $id
									) as other_part, (
										SELECT COUNT(*) as total
										FROM participants
										WHERE  participant_id = $id
									) as part");
		$result = $query->row();
		return $result->slots;
	}

	function updatePart($id, $colunm, $value){
		$this->db->set($colunm, $value);
		$this->db->where('participant_id', $id);
		$this->db->update($this->tbl_participants);
	}

	function updateOtherPart($id, $colunm, $value){
		$this->db->set($colunm, $value);
		$this->db->where('extra_participants_id', $id);
		$this->db->update($this->tbl_extra_participants);
	}

	function paid($order_id, $bool = FALSE)
	{
		$this->db->set('paid', $bool)
				 ->where('order_id', $order_id)
				 ->update($this->tbl_participants);
	}
	
	function delete(){
		
	}
	
	
		
}