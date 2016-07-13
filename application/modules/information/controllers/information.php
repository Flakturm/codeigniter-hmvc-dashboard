<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
Author: Andy
Date: 20/5/2016
Version: 1.0
*/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Information extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model( array('settings/settings_model') );
		$this->site_setting = $this->settings_model->read();
	}

	function index()
	{
		$data['site_title'] = '注意事項 - ' . $this->site_setting['site_title'];
		$data['main_content'] = 'note';
		$this->load->view('front_page', $data);
	}

	function privacy()
	{
		$data['site_title'] = '個人資料保護說明 - ' . $this->site_setting['site_title'];
		$data['main_content'] = 'privacy';
		$this->load->view('front_page', $data);
	}

	function ajaxNotice()
	{
		$data['fluid'] = TRUE;
		$this->load->view('information/note', $data);
	}

	function ajaxPrivacy()
	{
		$data['fluid'] = TRUE;
		$this->load->view('information/privacy', $data);
	}

}