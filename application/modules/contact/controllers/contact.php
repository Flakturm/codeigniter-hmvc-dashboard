<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
Author: Andy
Date: 19/5/2016
Version: 1.0
*/

class Contact extends MY_Controller{

	private $site_setting;
	
	function __construct(){
		parent::__construct();
		$this->load->model( array('settings/settings_model', 'enquiries/enquiries_model') );
		$this->load->helper( array('form', 'email') );
		$this->site_setting = $this->settings_model->read();
	}
	
	function index()
	{
		$data['css'] = array('ladda/css/ladda.css');
		$data['plugin_js'] = array('parsley/js/parsley.js',
								   'ladda/js/vendor/spin.js',
								   'ladda/js/ladda.js');
		$data['js'] = array('forms/ajax.js');
		$data['main_content'] = 'content';
		$data['site_title'] = '聯絡我們 - ' . $this->site_setting['site_title'];
		$this->load->view('front_page', $data);
	}

	function ajaxSend()
	{
		$response = array('alert' => 'success');
		$email_data = array(
			'name' => $this->input->post('name'),
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'message' => $this->input->post('message'),
			'client_ip' => $this->getUserIpAddr()
		);
		$data = array(
			'subject'	=> 'You got a message from ' . $this->site_setting['site_title'],
			'message'	=> $this->load->view('emails/contact', $email_data, true)
		);

		if ( $this->enquiries_model->create( $email_data ) AND send( $data ) )
		{
			$response['message'] = '<i class="ico-wink2 mr5"></i>訊息成功寄出了！';
		}
		else
		{
			$response['alert'] = 'danger';
		    $response['errors'][] = '<i class="ico-skull mr5"></i>訊息寄出失敗...';
		}

		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($response));
	}

	private function getUserIpAddr()
	{
	    if (!empty($_SERVER['HTTP_CLIENT_IP'])) //if from shared
	    {
	        return $_SERVER['HTTP_CLIENT_IP'];
	    }
	    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //if from a proxy
	    {
	        return $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	        return $_SERVER['REMOTE_ADDR'];
	    }
	}
}