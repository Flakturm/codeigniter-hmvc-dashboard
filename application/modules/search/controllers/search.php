<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
Author: Andy
Date: 25/5/2016
Version: 1.0
*/

class Search extends MY_Controller{

	private $site_setting;

	function __construct()
	{
		parent::__construct();
		$this->load->model( array('settings/settings_model',
								  'participants/participant_model',
								  'events/event_model'
		) );
		$this->load->library('encrypt');
		$this->site_setting = $this->settings_model->read();
				
	}

	function index()
	{
		$data['css'] = array('ladda/css/ladda.css');
		$data['plugin_js'] = array('parsley/js/parsley.js',
								   'ladda/js/vendor/spin.js',
								   'ladda/js/ladda.js');
		$data['js'] = array('forms/ajax.js');
		$this->load->helper( array( 'form' ) );
		$data['main_content'] = 'content';
		$data['site_title'] = '查詢報名 - ' . $this->site_setting['site_title'];
		$this->load->view('front_page', $data);
	}

	function result()
	{
		$participant_id = $this->encrypt->decode( $this->uri->segment(3) );
		$result = $this->participant_model->getParticipants( $participant_id );
		$result['event'] = $this->event_model->getEvent( $result['event_id'] );
		$extra = $this->participant_model->getExtraParticipants( $participant_id );

		$result['more'] = ($extra)? $extra : array();
		
		// echo "<pre>";print_r($result);echo "</pre>";
		$data['value'] = $result;
		$data['main_content'] = 'result';
		$data['site_title'] = '查詢結果 - ' . $this->site_setting['site_title'];
		$this->load->view('front_page', $data);
		
	}

	function ajaxSearch()
	{
		$response = array('alert' => 'success');
		$data = $this->input->post();

		$participant_id = $this->participant_model->getParticipantId( $data );

		if ( $participant_id )
		{
			$token = $this->encrypt->encode( $participant_id );
			$response['redirect'] = TRUE;
			$response['message'] = site_url('search/result/' . $token);
		}
		else
		{
			$response['alert'] = 'danger';
		    $response['message'] = '<i class="ico-filter2 mr5"></i>查無資料';
		}

		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($response));
	}

	public function _remap($method)
	{
		$available = array(
			'result', 'ajaxSearch'
		);
        if ( in_array($method, $available) )
        {
            $this->$method();
        }
        else
        {
            $this->index();
        }
	}

}