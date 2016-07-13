<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
Author: Andy
Date: 12/4/2016
Version: 1.0
*/

class Events extends MY_Controller{

	private $page_name = '';
	private $page_url = '';

	function __construct(){
		parent::__construct();
		$this->load->module("users");

		if( ! $this->users->_is_logged_in() AND $this->uri->segment(3) != 'preview'  )
		{
			redirect('admin/signin');
		}

		$this->load->library('encrypt');
		$this->load->model("event_model");
		$this->load->helper( array('date', 'form') );
		$items = $this->common_model->read($this->users->_is_admin());
		// set page name
		$this->page_name = $items[1]->name;
		// set root page
		$this->root_page = $items[1]->url;
	}

	function index(){
		$data['page_name'] = $this->page_name;
		$data['root_page'] = $this->root_page;
		$data['top_level'] = true;
		$data['has_add'] = true;
		$data['main_content'] = 'index';
		$events = $this->event_model->read();

		foreach ($events as $key => $value) {	// injuect remaining columns to the arrary objects
			$events[$key]->token = $this->encrypt->encode($value->event_id);
			$events[$key]->remaing_slots = $this->event_model->getRemainingSlots($value->event_id);
			$events[$key]->remaing_waiting_slots = $this->event_model->getRemainingWaitingSlots($value->event_id);
		}

		$data['events'] = $events;

		// flash message
		$data['flash_message'] = $this->session->flashdata('message');

		$this->load->view('page', $data);
	}

	function add(){
		$data['css'] = array('steps/css/jquery-steps.css',
							 'selectize/css/selectize.css',
							 'jquery-ui/css/jquery-ui.css',
							 'select2/css/select2.css',
							 'touchspin/css/touchspin.css');
		$data['plugin_js'] = array('steps/js/jquery-steps.js',
								   'parsley/js/parsley.js',
								   'inputmask/js/inputmask.js',
								   'selectize/js/selectize.js',
								   'jquery-ui/js/jquery-ui.js',
								   'jquery-ui/js/addon/timepicker/jquery-ui-timepicker.js',
								   'jquery-ui/js/jquery-ui-touch.js',
								   'inputmask/js/inputmask.js',
								   'select2/js/select2.js',
								   'touchspin/js/jquery.bootstrap-touchspin.js',
								   'magnific/js/jquery.magnific-popup.js');
		$data['backend_js'] = array('forms/wizard.js',
							'forms/element.js');

		$data['statuses'] = $this->getStatuses();
		$data['categories'] = $this->getEventCategories();
		$data['errors'] = array();

		if ( $this->input->post() )
		{
			$data['event'] = $this->input->post();

			// upload only if there is a picture to upload
			if (isset($_FILES['event_pic']) && is_uploaded_file($_FILES['event_pic']['tmp_name']))
			{
			    $img_result = $this->uploadImage('event_pic', true);
			    if ($img_result['uploaded'])
			    {
					$data['event']['event_pic'] = $img_result['message'];
			    }
			    else
			    {
			    	$data['errors'][] = $img_result['message'];
			    }
			}
			if (isset($_FILES['menu_pic']) && is_uploaded_file($_FILES['menu_pic']['tmp_name']))
			{
			    $img_result = $this->uploadImage('menu_pic', true);
			    if ($img_result['uploaded'])
			    {
					$data['event']['menu_pic'] = $img_result['message'];
			    }
			    else
			    {
			    	$data['errors'][] = $img_result['message'];
			    }
			}
			if (isset($_FILES['restaurant_pic']) && is_uploaded_file($_FILES['restaurant_pic']['tmp_name']))
			{
			    $img_result = $this->uploadImage('restaurant_pic', true);
			    if ($img_result['uploaded'])
			    {
					$data['event']['restaurant_pic'] = $img_result['message'];
			    }
			    else
			    {
			    	$data['errors'][] = $img_result['message'];
			    }			    
			}

			if ( ! $data['error'] ):
				$data['event']['slug'] = $this->slug($this->input->post('event_title'));
				$update = $this->event_model->update($this->uri->segment(4), $data['event']);
				if ($update)
				{
					// Set flash data 
					if ($update['message']) {
						$data['errors'][] = $update['message'];
					}
					else
					{
						$this->session->set_flashdata('message', '活動 <b>'.$data['event']['event_title'].'</b> 更新成功');
						redirect('admin/events');
					}
				}
				else
				{
					$this->session->set_flashdata('message', '活動 <b>'.$data['event']['event_title'].'</b> 沒有更動');
					redirect('admin/events');
				}
			endif;
		}

		$data['child_page_name'] = '新增活動';
		$data['page_name'] = $this->page_name;
		$data['root_page'] = $this->root_page;
		$data['main_content'] = 'content';
		$this->load->view('page', $data);
	}

	function edit(){

		if ( ! $this->uri->segment(4) // no event id
			OR ! is_numeric($this->uri->segment(4)) // id is not numeric
			OR ! $this->event_model->getEvent($this->uri->segment(4)) ) // no result
		{
			redirect('admin/events');
		}

		$data['event'] = $this->event_model->getEvent($this->uri->segment(4));

		$data['css'] = array('steps/css/jquery-steps.css',
							 'selectize/css/selectize.css',
							 'jquery-ui/css/jquery-ui.css',
							 'select2/css/select2.css',
							 'touchspin/css/touchspin.css',
							 'magnific/css/magnific.css');
		$data['plugin_js'] = array('steps/js/jquery-steps.js',
								   'parsley/js/parsley.js',
								   'inputmask/js/inputmask.js',
								   'selectize/js/selectize.js',
								   'jquery-ui/js/jquery-ui.js',
								   'jquery-ui/js/addon/timepicker/jquery-ui-timepicker.js',
								   'jquery-ui/js/jquery-ui-touch.js',
								   'inputmask/js/inputmask.js',
								   'select2/js/select2.js',
								   'touchspin/js/jquery.bootstrap-touchspin.js',
								   'magnific/js/jquery.magnific-popup.js');
		$data['backend_js'] = array('forms/wizard.js',
							'forms/element.js');

		$data['statuses'] = $this->getStatuses();
		$data['categories'] = $this->getEventCategories();
		$data['errors'] = array();

		if ( $this->input->post() )
		{
			$data['event'] = $this->input->post();

			// upload only if there is a picture to upload
			if (isset($_FILES['event_pic']) && is_uploaded_file($_FILES['event_pic']['tmp_name']))
			{
			    $img_result = $this->uploadImage('event_pic');
			    if ($img_result['uploaded'])
			    {
					$data['event']['event_pic'] = $img_result['message'];
			    }
			    else
			    {
			    	$data['errors'][] = $img_result['message'];
			    }
			}
			if (isset($_FILES['menu_pic']) && is_uploaded_file($_FILES['menu_pic']['tmp_name']))
			{
			    $img_result = $this->uploadImage('menu_pic');
			    if ($img_result['uploaded'])
			    {
					$data['event']['menu_pic'] = $img_result['message'];
			    }
			    else
			    {
			    	$data['errors'][] = $img_result['message'];
			    }
			}
			if (isset($_FILES['restaurant_pic']) && is_uploaded_file($_FILES['restaurant_pic']['tmp_name']))
			{
			    $img_result = $this->uploadImage('restaurant_pic');
			    if ($img_result['uploaded'])
			    {
					$data['event']['restaurant_pic'] = $img_result['message'];
			    }
			    else
			    {
			    	$data['errors'][] = $img_result['message'];
			    }			    
			}

			if ($this->event_model->getTakenSlots($this->uri->segment(4)) > $data['event']['slots'])
			{
				$data['errors'][] = '目前報名人數大於所設定的課程人數！';
			}

			if ( ! $data['errors'] ):
				$data['event']['slug'] = $this->slug($this->input->post('event_title'));
				$update = $this->event_model->update($this->uri->segment(4), $data['event']);
				if ($update)
				{
					// Set flash data 
					if ($update['message']) {
						$data['errors'][] = $update['message'];
					}
					else
					{
						$this->session->set_flashdata('message', '活動 <b>'.$data['event']['event_title'].'</b> 更新成功');
						redirect('admin/events');
					}
				}
				else
				{
					$this->session->set_flashdata('message', '活動 <b>'.$data['event']['event_title'].'</b> 沒有更動');
					redirect('admin/events');
				}
			endif;
		}

		$data['child_page_name'] = '編輯活動 - ' . $data['event']['event_title'];
		$data['page_name'] = $this->page_name;
		$data['root_page'] = $this->root_page;
		$data['main_content'] = 'content';
		$this->load->view('page', $data);
	}

	function preview()
	{
		$event_id = $this->encrypt->decode($this->uri->segment(4));
		if ( ! $this->uri->segment(4) // no token
			OR ! is_numeric($event_id) ) // no an id
		{
			redirect(OFFICIAL_SITE);
		}

		$data['event'] = $this->event_model->getEvent($event_id);
		$data['remaining_slots'] = $this->event_model->getRemainingSlots( $data['event']['event_id'] );
		$data['remaining_waiting_slots'] = $this->event_model->getRemainingWaitingSlots( $data['event']['event_id'] );
		$data['site_title'] = '[預覽] ' . $data['event']['event_title'];
		$data['main_content'] = 'preview';
		$this->load->view('front_page', $data);
	}

	private function uploadImage($field_name, $overwrite = false)
	{
		$config['upload_path'] = 'uploads/';
		$config['max_size'] = '500';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = $overwrite;
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload($field_name) )
		{		 
			// uploading failed. $error will holds the errors.
			return array('uploaded' => false, 'message' => $this->upload->display_errors());
		}
		else
		{
			$data_upload_files = $this->upload->data();		 
			// uploading successfull, now do your further actions
	        return array('uploaded' => true, 'message' => $data_upload_files['orig_name']);
		}
	}

	private function getStatuses()
	{
		return $this->event_model->getStatuses();
	}

	private function getEventCategories()
	{
		return $this->event_model->getCategories();
	}

	private function slug($str, $options = array())
	{
		// Make sure string is in UTF-8 and strip invalid UTF-8 characters
		$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
		
		$defaults = array(
			'delimiter' => '-',
			'limit' => null,
			'lowercase' => true,
			'replacements' => array(),
			'transliterate' => false,
		);
		
		// Merge options
		$options = array_merge($defaults, $options);
		
		// Make custom replacements
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
			
		// Replace non-alphanumeric characters with our delimiter
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		
		// Remove duplicate delimiters
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
		
		// Truncate slug to max. characters
		$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
		
		// Remove delimiter from ends
		$str = trim($str, $options['delimiter']);
	
		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	}
		
}