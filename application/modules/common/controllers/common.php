<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
Author: Andy
Date: 12/4/2016
Version: 1.0
*/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('settings/settings_model');
	}

	function header()
	{
		$data['site_favicon'] = ($this->settings_model->getColumn('site_favicon')) ? $this->settings_model->getColumn('site_favicon') : '';
		$this->load->view("front/header", $data);
	}

	function menu()
	{
		$data['ga_code'] = ($this->settings_model->getColumn('ga_code')) ? $this->settings_model->getColumn('ga_code') : FALSE;
		$data['menu_items'] = $this->common_model->getFrontMenu();
		$this->load->view("front_menu", $data);
	}

	function footer()
	{
		$this->load->view("front/footer");
	}

	function adminHeader()
	{
		$data['site_favicon'] = ($this->settings_model->getColumn('site_favicon')) ? $this->settings_model->getColumn('site_favicon') : '';
		$this->load->view("admin/header", $data);
	}
	
	function adminMenu(){
		$this->load->module("users");
		$data['current'] = $this->uri->segment(2);
		$data['items'] = $this->common_model->read($this->users->_is_admin());
		$data['site_logo'] = ($this->settings_model->getColumn('site_logo')) ? $this->settings_model->getColumn('site_logo') : 'default-logo.png';
		
		$data['currentuser'] = @$this->users->userdata();

		$this->load->view("menu", $data);
	}

	function adminFooter()
	{
		$this->load->view("admin/footer");
	}
	
	//Limit access
	function _remap(){
		show_404();
	}
		
}