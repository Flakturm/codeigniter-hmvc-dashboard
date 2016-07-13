<?php

class Common_model extends CI_Model{
	
	function create(){
		
	}
	
	function read($is_admin = false){
		//Just a prototype
		$menu = array();
		if ($is_admin)
		{
			$menu[0] = new stdClass();
			$menu[0]->url = "settings";
			$menu[0]->icon = "dashboard2";
			$menu[0]->name = "基本設定";			
		}

		$menu[1] = new stdClass();
		$menu[1]->url = "events";
		$menu[1]->icon = "table22";
		$menu[1]->name = "活動列表";

		$menu[2] = new stdClass();
		$menu[2]->url = "participants";
		$menu[2]->icon = "users";
		$menu[2]->name = "報名名單";

		if ($is_admin)
		{
			$menu[3] = new stdClass();
			$menu[3]->url = "users";
			$menu[3]->icon = "vcard";
			$menu[3]->name = "網站人員";
		}

		$menu[4] = new stdClass();
		$menu[4]->url = "enquiries";
		$menu[4]->icon = "comments-alt";
		$menu[4]->name = "留言表單";
		
		return $menu;
	}

	function getFrontMenu()
	{
		// it gives the latest event in it's category
		$query = $this->db->query("SELECT slug, category_name
								   FROM events
								   JOIN categories on categories.category_id = events.category_id 
								   WHERE room_open_time IN (
								   SELECT MAX(room_open_time)
								   FROM events
								   WHERE status = '進行中' OR status = '已結束'
								   GROUP BY category_id)
		");
		// echo $this->db->last_query().'<br>';
		return ($query->num_rows) ? $query->result_array() : false;
	}

	function update(){
		
	}
	
	function delete(){
		
	}
	
	
		
}