<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
Author: Andy
Date: 12/4/2016
Version: 1.0
*/

class Enquiries extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->module("users");

		if( ! $this->users->_is_logged_in() )
		{
			redirect('admin/signin');
		}

		$this->load->model("enquiries_model");

		$items = $this->common_model->read();
		// set page name
		$this->page_name = $items[4]->name;
		// set root page
		$this->root_page = $items[4]->url;
	}

	function index(){
		$this->load->helper('text');
		$data['page_name'] = $this->page_name;
		$data['root_page'] = $this->root_page;
		$data['top_level'] = true;
		$data['main_content'] = 'index';
		$data['enquiries'] = $this->enquiries_model->getEnquiries();
		// flash message
		$data['flash_message'] = $this->session->flashdata('message');
		$this->load->view('page', $data);
	}

	function edit(){

		if ( ! $this->uri->segment(4) // no participant id
			OR ! is_numeric($this->uri->segment(4)) // id is not numeric
			OR ! $this->enquiries_model->getEnquiries($this->uri->segment(4)) ) // no result
		{
			redirect('admin/enquiries');
		}
		$data['enquiry'] = $this->enquiries_model->getEnquiries($this->uri->segment(4));
		
		$data['css'] = array('xeditable/css/xeditable.css',
							 'xeditable/inputs-ext/typeaheadjs/lib/typeahead.js-bootstrap.css');
		$data['plugin_js'] = array('xeditable/js/bootstrap-editable.js',
								   'xeditable/inputs-ext/typeaheadjs/lib/typeahead.js');
		$data['backend_js'] = array('forms/xeditable.js');

		$data['statuses'] = $this->getStatuses();

		$data['child_page_name'] = '留言者 - ' . $data['enquiry']['name'];
		$data['page_name'] = $this->page_name;
		$data['root_page'] = $this->root_page;
		$data['main_content'] = 'content';
		$this->load->view('page', $data);
	}

	public function ajaxUpdate()
	{
		$response = array('errors' => false);
		$id = $this->input->post('pk');
		$column = $this->input->post('name');
		$value = $this->input->post('value');

		$this->enquiries_model->update($id, $column, $value);

		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($response));
	}

	private function getStatuses()
	{
		return $this->enquiries_model->getStatuses();
	}
		
}