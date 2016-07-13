<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
Author: Andy
Date: 12/4/2016
Version: 1.0
*/

class Users extends MY_Controller{
	
	function __construct()
	{
		parent::__construct();

		if ( ! $this->_is_logged_in() 
			AND $this->uri->segment(2) != 'signin' 
			AND $this->uri->segment(3) != 'preview'
			AND $this->uri->segment(3) != 'pay'
			AND $this->uri->segment(3) != 'paid'
			AND $this->uri->segment(3) != 'feedback' )
		{
			redirect('admin/signin');
		}

		$this->load->model('user_model');

		$this->load->library('form_validation');
	
		$items = $this->common_model->read($this->_is_admin());

		if ( isset($items[3]) )
		{
			// set page name
			$this->page_name = $items[3]->name;
			// set root page
			$this->root_page = $items[3]->url;
		}
		
	}
	
	function index()
	{
		if ( ! $this->_is_admin() )
		{
			redirect('admin/events');
		}

		$data['page_name'] = $this->page_name;
		$data['root_page'] = $this->root_page;
		$data['top_level'] = true;
		$data['has_add'] = true;
		$data['users'] = $this->user_model->read();
		$data['main_content'] = 'users';
		// flash message
		$data['flash_message'] = $this->session->flashdata('message');
		$data['flash_status'] = ($this->session->flashdata('status')) ? $this->session->flashdata('status') : 'danger';
		$this->load->view('page', $data);
	}
	
	function edit()
	{
		$data['is_admin'] = $this->_is_admin();
		if ( ! $this->_is_admin() AND $this->uri->segment(4) )
		{
			redirect('admin/events');
		}

		if ( $this->uri->segment(4) )
		{
			$data['user'] = $this->user_model->user_by_id($this->uri->segment(4));
		}
		else
		{
			$data['user'] = $this->userdata();
		}

		if ( ! $data['user'] )
		{
			redirect('admin/users');
		}

		$data['css'] = array('xeditable/css/xeditable.css',
							 'xeditable/inputs-ext/typeaheadjs/lib/typeahead.js-bootstrap.css');
		$data['plugin_js'] = array('xeditable/js/bootstrap-editable.js',
								   'xeditable/inputs-ext/typeaheadjs/lib/typeahead.js');
		$data['backend_js'] = array('forms/xeditable.js');
		$data['page_name'] = (isset($this->page_name)) ? $this->page_name : '';
		$data['root_page'] = (isset($this->root_page)) ? $this->root_page : '';
		$data['child_page_name'] = $data['user']->user_nicename;
		$data['roles'] = $this->getRoles();
		$data['main_content'] = 'user';
		$this->load->view('page', $data);		
	}

	function add()
	{
		if ( ! $this->_is_admin() )
		{
			redirect('admin/events');
		}
		$data['is_admin'] = $this->_is_admin();

		$data['css'] = array('ladda/css/ladda.css');
		$data['plugin_js'] = array('ladda/js/vendor/spin.js',
								   'ladda/js/ladda.js',
								   'parsley/js/parsley.js');
		$data['backend_js'] = array('forms/ajax.js');

		$data['child_page_name'] = '新增站務人員';

		$data['roles'] = $this->getRoles();
		$data['page_name'] = $this->page_name;
		$data['root_page'] = $this->root_page;
		$data['main_content'] = 'user';
		$this->load->view('page', $data);		
	}

	function delete()
	{
		if ( ! $this->_is_admin() )
		{
			redirect('admin/events');
		}

		if ( $this->uri->segment(4) == 1)  // prevent the admin gets deleted
		{
			$this->session->set_flashdata('message', '<i class="ico-grin2 mr5"></i>Alfa 是不能被消滅的！');
		}
		else if ( $this->user_model->user_by_id($this->uri->segment(4)) )  // if user exists, do delete
		{
			if ( $this->user_model->delete($this->uri->segment(4)) )
			{
				$this->session->set_flashdata('status', 'success');
				$this->session->set_flashdata('message', '<i class="ico-wink2 mr5"></i>解僱成功！');
			}
			else
			{
				$this->session->set_flashdata('message', '<i class="ico-skull mr5"></i>解僱失敗！');
			}
		}

		redirect('admin/users');
	}
	
	function signin()
	{
		//Redirect
		if ( $this->_is_logged_in() )
		{
			redirect('admin/events');
		}

		$data['css'] = array('ladda/css/ladda.css');
		$data['plugin_js'] = array('ladda/js/vendor/spin.js',
								   'ladda/js/ladda.js',
								   'parsley/js/parsley.js');
		$data['backend_js'] = array('forms/ajax.js');

		$this->load->model('settings/settings_model');
		$data['site_logo'] = ($this->settings_model->getColumn('site_logo')) ? $this->settings_model->getColumn('site_logo') : 'default-logo.png';
		
		if ( $_POST )
		{
			//Data
			$user_email = $this->input->post('user_email', true);
			$password 	= $this->input->post('password');

			if ( ! empty($user_email) OR ! empty($password) )
			{
				$hash = password_hash($password, PASSWORD_DEFAULT);
				$userdata 	= $this->user_model->getUserByEmail($user_email);
				
				//Validation
				if( $userdata AND password_verify($password, $userdata->user_pass) AND $userdata->user_status ){
					$data['userid'] = $userdata->id;
					$data['logged_in'] = true;
					$this->session->set_userdata($data);
					redirect('admin/events');
				}else{
					$data['error'] = "You shall not pass!";
				}
			}
			else
			{
				$data['error'] = "You shall not pass!";
			}
			
		}
		$data['main_content'] = 'signin';
		$this->load->view('page', $data);
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('admin/signin');
	}
	
	function account()
	{
		//Redirect
		$this->_member_area();
		
		if($_POST){
			$userdata = new stdClass();
			$userdata->user_nicename 	= $this->input->post('nickname');
			$userdata->user_email 		= $this->input->post('email');
			$userdata->user_pass		= md5($this->input->post('password'));
			
			$insert = $this->user_model->update($this->session->userdata('userid'), $userdata);
			
			if($insert){
				$data['message'] = "Updated succesfully";
				$data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
				$data['main_content'] = 'account';
				$this->load->view('page', $data);
			}
			return;
		}
		
		$data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
		$data['main_content'] = 'account';
		$this->load->view('page', $data);
		
	}
	
//Hidden Methods not allowed by url request

	function _member_area()
	{
		if ( ! $this->_is_logged_in() )
		{
			redirect('admin/signin');
		}
	}
	
	function _is_logged_in()
	{
		if ( $this->session->userdata('logged_in') )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function userdata()
	{
		if ( $this->_is_logged_in() )
		{
			return $this->user_model->user_by_id($this->session->userdata('userid'));
		}
		else
		{
			return false;
		}
	}
	
	function _is_admin()
	{
		if ( @$this->userdata()->role === 1 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function getRoles()
	{
		return $this->user_model->getRoles();
	}

	public function ajaxSave()
	{
		$response = array('alert' => 'success');
		$data = $this->input->post();

		if ( $data['user_email'] AND $this->user_model->checkUserEmail($data['user_email']) )  // check if email exists
		{
		    $response['alert'] = 'danger';
	    	$response['errors'][] = '<i class="ico-skull mr5"></i>此信箱已經被註冊了!';
		}

		if ( $data['user_pass'] )
		{
			$data['user_pass'] = password_hash($data['user_pass'], PASSWORD_DEFAULT);
		}

		if ( $response['alert'] == 'success' AND $this->user_model->create($data) )
		{
			$response['redirect'] = site_url('admin/users');
			$this->session->set_flashdata('status', 'success');
			$this->session->set_flashdata('message', '<i class="ico-wink2 mr5"></i> <b>'.$data['user_nicename'].'</b> 新增成功！');
		}
		else
		{
		    $response['errors'][] = '<i class="ico-skull mr5"></i>新增失敗...';
		}
		
		sleep(1); // hold on a sec...
		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($response));
	}

	function ajaxUpdate()
	{
		$response = array('errors' => false);
		$id = $this->input->post('pk');
		$column = $this->input->post('name');
		$value = $this->input->post('value');

		if ( $column == 'user_email' AND $this->user_model->checkUserEmail($value) )
		{
			$response = array(
					'errors' => true,
					'message' => '此信箱已經被註冊了'
				);
		}

		if ($column == 'user_pass')
		{
			$value = password_hash($value, PASSWORD_DEFAULT);
		}

		if ( ! $response['errors'] )
		{
			if ( $column == 'role_id' )
			{
				$this->user_model->updateUserRole($id, $column, $value);
			}
			else
			{
				$this->user_model->updateUser($id, $column, $value);
			}
			
		}

		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($response));
	}

	function ajaxSendPassword()
	{
		$response = array('alert' => 'success');
		$user = $this->user_model->getUserByEmail($this->input->post('user_email'));
		$new_pass = $this->random_password();
		$email_data = array(
			'user_nicename' => $user->user_nicename,
			'new_pass'	=> $new_pass
		);
		$data = array(
			'email_recipient' => $this->input->post('user_email'),
			'subject'	=> '重設密碼',
			'message'	=> $this->load->view('emails/forget', $email_data, true)
		);

		$value = password_hash($new_pass, PASSWORD_DEFAULT);  // encrypt new password
		$this->user_model->updateUser($user->id, 'user_pass', $value);  // update password

		$this->load->helper('email');

		if ( send($data) )
		{
			$response['message'][] = '<i class="ico-wink2 mr5"></i>新的密碼已經寄到 ' . $data['email_recipient'] . ' 了！';
		}
		else
		{
			$response['alert'] = 'danger';
		    $response['errors'][] = '<i class="ico-skull mr5"></i>寄出失敗...';
		}

		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($response));
	}

	function random_password( $length = 8 ) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$&*";
	    $password = substr( str_shuffle( $chars ), 0, $length );
	    return $password;
	}
}