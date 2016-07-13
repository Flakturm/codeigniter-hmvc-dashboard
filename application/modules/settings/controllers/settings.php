<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
Author: Andy
Date: 12/4/2016
Version: 1.0
*/

class Settings extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->module("users");

		if( ! $this->users->_is_logged_in() )
		{
			redirect('admin/signin');
		}

		$this->load->model("settings_model");

		$items = $this->common_model->read($this->users->_is_admin());
		// set page name
		$this->page_name = $items[0]->name;
		// set root page
		$this->root_page = $items[0]->url;
	}

	function index(){
		$data['css'] = array('ladda/css/ladda.css',
							 'gritter/css/gritter.css');
		$data['plugin_js'] = array('ladda/js/vendor/spin.js',
								   'ladda/js/ladda.js',
								   'parsley/js/parsley.js',
								   'gritter/js/jquery.gritter.js');
		$data['backend_js'] = array('forms/ajax.js');
		$data['page_name'] = $this->page_name;
		$data['root_page'] = $this->root_page;
		$data['top_level'] = true;
		$data['main_content'] = 'index';
		$data['settings'] = $this->settings_model->read();
		$this->load->view('page', $data);
	}

	public function ajaxSave()
	{
		$response = array('alert' => 'success');
		$data = $this->input->post();

		$data['site_logo'] = @$data['empty_img'] ? '' : $this->settings_model->getColumn('site_logo');
		$data['site_favicon'] = @$data['empty_icon'] ? '' : $this->settings_model->getColumn('site_favicon');
		unset($data['empty_img']);
		unset($data['empty_icon']);

		// upload only if there is a picture to upload
		if (isset($_FILES['site_favicon']) && is_uploaded_file($_FILES['site_favicon']['tmp_name']))
		{
		    $img_result = $this->uploadImage('site_favicon');
		    if ($img_result['uploaded'])
		    {
				$data['site_favicon'] = $img_result['message'];
		    }
		    else
		    {
		    	$data['errors'][] = $img_result['message'];
		    }
		}
		if (isset($_FILES['site_logo']) && is_uploaded_file($_FILES['site_logo']['tmp_name']))
		{
		    $img_result = $this->uploadImage('site_logo');
		    if ($img_result['uploaded'])
		    {
				$data['site_logo'] = $img_result['message'];
		    }
		    else
		    {
		    	$data['errors'][] = $img_result['message'];
		    }
		}

		if ( ! isset($data['errors']) AND $this->settings_model->save($data) )
		{
			$response['message'][] = '<i class="ico-wink2 mr5"></i>資料存入成功！';
		}
		else
		{
			$response['alert'] = 'danger';
		    $response['errors'][] = '<i class="ico-skull mr5"></i>資料存入失敗...';
		}
		
		sleep(1); // hold on a sec...
		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($response));
	}

	function ajaxSendMail()
	{
		$response = array('alert' => 'success');
		$data = array(
			'email_recipient' => $this->input->post('email_recipient'),
			'subject'	=> '測試 abc 123',
			'message'	=> $this->load->view('emails/test', '', true),
			'site_title'=> $this->input->post('site_title'),
			'smtp_host' => $this->input->post('smtp_host'),
			'smtp_user' => $this->input->post('smtp_user'),
			'smtp_pass' => $this->input->post('smtp_pass'),
			'smtp_port' => $this->input->post('smtp_port'),
		);

    	$this->load->helper('email');

		if ( send('', $data) )
		{
			$response['message'][] = '<i class="ico-wink2 mr5"></i>測試信成功寄到 ' . $this->input->post('email_recipient') . ' 了！ 記得<b><u>儲存</u></b>喔！';
		}
		else
		{
			$response['alert'] = 'danger';
		    $response['errors'][] = '<i class="ico-skull mr5"></i>測試信寄出失敗...';
		}

		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($response));
	}

	private function uploadImage($field_name)
	{
		$config['upload_path'] = 'theme/img/logo/';
		$config['max_size'] = '500';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
        $config['overwrite'] = true;
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload($field_name) )
		{
			@unlink($_FILES[$field_name]);
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
		
}