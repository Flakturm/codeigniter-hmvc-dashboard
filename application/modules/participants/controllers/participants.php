<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
Author: Andy
Date: 12/4/2016
Version: 1.0
*/

class Participants extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->module("users");

		if( ! $this->users->_is_logged_in() 
			AND $this->uri->segment(3) != 'pay'
			AND $this->uri->segment(3) != 'paid' 
			AND $this->uri->segment(3) != 'feedback' )
		{
			redirect('admin/signin');
		}

		$this->load->library('encrypt');
		$this->load->model("participant_model");

		$items = $this->common_model->read($this->users->_is_admin());
		// set page name
		$this->page_name = $items[2]->name;
		// set root page
		$this->root_page = $items[2]->url;
	}

	function index(){

		$data['css'] = array('ladda/css/ladda.css',
							 'gritter/css/gritter.css');
		$data['plugin_js'] = array('bootbox/js/bootbox.js',
								   'ladda/js/vendor/spin.js',
								   'ladda/js/ladda.js',
								   'gritter/js/jquery.gritter.js');
		$data['backend_js'] = array('components/notification.js');

		$data['page_name'] = $this->page_name;
		$data['root_page'] = $this->root_page;
		$data['top_level'] = true;
		$data['main_content'] = 'index';
		$participants = $this->participant_model->getParticipants();
		foreach ($participants as $key => $value) {	// injuect token to the object arrary
			$participants[$key]->token = $this->encrypt->encode($value->participant_id);
		}		
		$data['participants'] = $participants;
		// flash message
		$data['flash_message'] = $this->session->flashdata('message');
		$this->load->view('page', $data);
	}

	function edit(){

		if ( ! $this->uri->segment(4) // no participant id
			OR ! is_numeric($this->uri->segment(4)) // id is not numeric
			OR ! $this->participant_model->getParticipants($this->uri->segment(4)) ) // no result
		{
			redirect('admin/participants');
		}
		$data['participant'] = $this->participant_model->getParticipants($this->uri->segment(4));
		$data['extraParticipants'] = $this->participant_model->getExtraParticipants($this->uri->segment(4));

		$data['css'] = array('xeditable/css/xeditable.css',
							 'xeditable/inputs-ext/typeaheadjs/lib/typeahead.js-bootstrap.css');
		$data['plugin_js'] = array('xeditable/js/bootstrap-editable.js',
								   'xeditable/inputs-ext/typeaheadjs/lib/typeahead.js');
		$data['backend_js'] = array('forms/xeditable.js');

		$data['statuses'] = $this->getStatuses();
		$data['invoice_types'] = $this->getInvoiceTypes();

		$data['child_page_name'] = '編輯報名者 - ' . $data['participant']['participant_name'];
		$data['page_name'] = $this->page_name;
		$data['root_page'] = $this->root_page;
		$data['main_content'] = 'content';
		$this->load->view('page', $data);
	}

	public function pay()
	{
		$participant_id = $this->encrypt->decode($this->uri->segment(4));
		if ( ! $this->uri->segment(4) // no token
			OR ! is_numeric($participant_id) ) // no an id
		{
			redirect(OFFICIAL_SITE);
		}

		$this->load->helper("chinatrust");
		$this->load->model("events/event_model");

		$value = $this->participant_model->getParticipants($participant_id);
		$event = $this->event_model->getEvent($value['event_id']);

		if ( $value['paid'] )
		{
			redirect( 'admin/' . $this->root_page . '/paid/' . $this->uri->segment(4) );
		}

		// prepare chinatrust variables
		$chinatrust_data = [
			'order_id' => $value['order_id'],
			'amount' => ($value['extra_ppl'] + 1) * $event['fees'],
			'event_title' => $event['event_title'],
			'auto_cap' => 1,
			'return_url' => site_url( 'admin/' . $this->root_page . '/feedback/' )
		];

		$data['third_party'] = chinatrustSend($chinatrust_data);

		$data['value'] = $value;
		$data['event'] = $event;
		$data['auth_url'] = getAuthURL( TEST );
		$data['root_page'] = $this->root_page;
		$data['flash_fail'] = ($this->session->flashdata('fail'))? $this->session->flashdata('fail') : NULL;
		$data['site_title'] = '確認訂單資料';
		$this->load->view('cart', $data);
	}

	public function feedback()
	{
		$this->load->helper("chinatrust");
		$result_array = chinatrustReceive( $this->input->post() );
		$participant_id = $this->participant_model->getParticipantId( array('order_id' => $result_array['encArray']['lidm']) );
		
		if ( $result_array['result'] == TRUE 
			 AND $result_array['encArray']['status'] == '0'
			 AND $result_array['encArray']['errcode'] == '00'
			 AND $result_array['encArray']['errdesc'] == 'null' )
		{
			// booking successful
			// booking has been paid
			$this->participant_model->paid( $result_array['encArray']['lidm'], TRUE );
			$participant = $this->participant_model->getParticipants( $participant_id );
			$this->load->model("events/event_model");
			$event = $this->event_model->getEvent( $participant['event_id'] );

			$this->load->library('encrypt');
			// sending confirmation email
			$email_data = array (
				'participant_name' => $participant['participant_name'],
				'event_title' => $participant['event_title'],
				'time' => date('Y-m-d H:i', strtotime($event['room_open_time'])) . ' - ' . date('H:i', strtotime($event['room_close_time'])),
				'order_id' => $participant['order_id'],
				'fees' => number_format( ($participant['extra_ppl'] + 1) * $event['fees'], 0, '.', ',' ),
				'people' => ($participant['extra_ppl'] + 1),
				'invoice_types' => $participant['invoice_types'],
				'seach_url' => site_url('search/result/' . $this->encrypt->encode( $participant_id ))
			);
			$data = array (
				'email_recipient' => $participant['email'],
				'subject'	=> '[' . $participant['event_title'] . '] 活動報名成功通知信',
				'message'	=> $this->load->view('emails/success', $email_data, TRUE)
			);

	    	$this->load->helper('email');
	    	send( $data );
	    	$this->session->set_flashdata('paid', TRUE);
	    	redirect( 'admin/' . $this->root_page . '/paid/' . $this->encrypt->encode($participant_id) );
		}
		else
		{
			$this->participant_model->setBookigStatus($result_array['encArray']['lidm'], FALSE);
			// booking unsucceful
			$this->session->set_flashdata('fail', TRUE);
			redirect( 'admin/' . $this->root_page . '/pay/' . $this->encrypt->encode($participant_id) );
		}
	}

	public function paid()
	{
		$participant_id = $this->encrypt->decode($this->uri->segment(4));
		if ( ! $this->uri->segment(4) // no token
			OR ! is_numeric($participant_id) ) // no an id
		{
			redirect(OFFICIAL_SITE);
		}

		$this->load->model("events/event_model");

		$data['value'] = $this->participant_model->getParticipants($participant_id);
		$data['event'] = $this->event_model->getEvent($data['value']['event_id']);
		$data['flash_paid'] = ($this->session->flashdata('paid'))? TRUE : FALSE;
		$data['flash_fail'] = ($this->session->flashdata('fail'))? TRUE : FALSE;
		$data['root_page'] = $this->root_page;
		$data['site_title'] = '訂單已付款完成';
		$this->load->view('cart', $data);
	}

	public function ajaxPartUpdate()
	{
		$response = array('errors' => false);
		$id = $this->input->post('pk');
		$column = $this->input->post('name');
		$value = $this->input->post('value');
		
		if ($column == 'password')
		{
			$value = password_hash($value, PASSWORD_DEFAULT);
		}

		if ($column == 'status' AND $value == '訂位')
		{
			$event_id = $this->participant_model->getEventId($id);
			$this->load->model('events/event_model');
			
			$remaining_slots = $this->event_model->getRemainingSlots($event_id);
			$needed_slots = $this->participant_model->getSlotsByPerson($id);

			if ($needed_slots > $remaining_slots)	// needed slots are more than remaining slots
			{
				$response = array(
					'errors' => true,
					'message' => '剩下名額不足，此活動名額剩下 ' . $remaining_slots . '名'
				);
			}
		}

		if ( ! $response['errors'] )
		{
			$this->participant_model->updatePart($id, $column, $value);
		}

		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($response));
	}

	public function ajaxOtherPartUpdate()
	{
		$id = $this->input->post('pk');
		$column = $this->input->post('name');
		$value = $this->input->post('value');
		$this->participant_model->updateOtherPart($id, $column, $value);
	}

	public function ajaxSendRequest()
	{
		$response = array('success' => false);
		$id = $this->input->post('participant_id');

		$participant = $this->participant_model->getParticipants( $id );
		$this->load->model("events/event_model");
		$event = $this->event_model->getEvent( $participant['event_id'] );

		$this->load->library('encrypt');
		// sending confirmation email
		$email_data = array (
			'participant_name' => $participant['participant_name'],
			'payment_url' => site_url( 'admin/' . $this->root_page . '/pay/' . $this->encrypt->encode($id) ),
			'event_title' => $participant['event_title'],
			'time' => date('Y-m-d H:i', strtotime($event['room_open_time'])) . ' - ' . date('H:i', strtotime($event['room_close_time'])),
			'order_id' => $participant['order_id'],
			'fees' => number_format( ($participant['extra_ppl'] + 1) * $event['fees'], 0, '.', ',' ),
			'people' => ($participant['extra_ppl'] + 1),
			'invoice_types' => $participant['invoice_types'],
			'seach_url' => site_url('search/result/' . $this->encrypt->encode( $id ))
		);
		$data = array (
			'email_recipient' => $participant['email'],
			'subject'	=> '[' . $participant['event_title'] . '] 活動線上刷卡頁面',
			'message'	=> $this->load->view('emails/payment', $email_data, true)
		);

    	$this->load->helper('email');
    	if ( send( $data ) )
    	{
    		$response['success'] = TRUE;
    	}

    	$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($response));
	}

	private function getStatuses()
	{
		return $this->participant_model->getStatuses();
	}

	private function getInvoiceTypes()
	{
		return $this->participant_model->getInvoiceTypes();
	}
		
}