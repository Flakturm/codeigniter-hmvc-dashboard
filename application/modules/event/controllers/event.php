<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
Author: Andy
Date: 2/6/2016
Version: 1.0
*/

class Event extends MY_Controller {

	private $site_setting;

	function __construct()
	{
		parent::__construct();
		$this->load->model( array('settings/settings_model', 'participants/participant_model') );
		$this->load->helper( 'form' );
		$this->site_setting = $this->settings_model->read();
	}

	function index()
	{
		if ( $this->uri->segment(2) == FALSE )
		{
			redirect(OFFICIAL_SITE);
		}		
		$this->load->model("events/event_model");
		$data['plugin_js'] = array('gmaps/js/jquery.tinyMap-3.3.19.min.js');
		$data['js'] = array('maps/google.js');
		$data['event'] = $this->event_model->getEventBySlug( urldecode( $this->uri->segment(2) ) );
		$data['remaining_slots'] = $this->event_model->getRemainingSlots( $data['event']['event_id'] );
		$data['remaining_waiting_slots'] = $this->event_model->getRemainingWaitingSlots( $data['event']['event_id'] );
		$data['site_title'] = $data['event']['event_title'] . ' - ' . $this->site_setting['site_title'];
		$data['main_content'] = 'content';
		$this->load->view('front_page', $data);
	}

	function step1()
	{
		if ( ! $this->input->post() )
		{
			redirect(OFFICIAL_SITE);
		}
		$data['event'] = $this->input->post();
		$data['css'] = array('ladda/css/ladda.css');
		$data['plugin_js'] = array('parsley/js/parsley.js',
								   'ladda/js/vendor/spin.js',
								   'ladda/js/ladda.js');
		$data['js'] = array('forms/ajax.js');
		$data['site_title'] = 'Step 1 - ' . $data['event']['event_title'] . ' - ' . $this->site_setting['site_title'];
		$data['main_content'] = 'step1';
		$this->load->view('front_page', $data);
	}

	function step2()
	{
		if ( ! $this->input->post() )
		{
			redirect(OFFICIAL_SITE);
		}
		$this->session->set_userdata('cockroach', time());
		$data['event'] = $this->input->post();
		$data['invoice_types'] = $this->participant_model->getInvoiceTypes();
		$data['plugin_js'] = array('parsley/js/parsley.js');
		$data['js'] = array('forms/ajax.js');
		$data['site_title'] = 'Step 2 - ' . $data['event']['event_title'] . ' - ' . $this->site_setting['site_title'];
		$data['main_content'] = 'step2';
		$this->load->view('front_page', $data);
	}

	function step3()
	{
		if ( ! $this->input->post() )
		{
			redirect(OFFICIAL_SITE);
		}

		$this->load->helper("chinatrust");
		$chinatrust_data = array();
		$event = $this->input->post();

		$order_id = (isset($event['order_id']))? $event['order_id'] : $this->unique_id();
		$amount = $event['extra_people'] * $event['fees'];
		$fail = TRUE;

		$this->load->model("events/event_model");

		// check remaining slots
		if ( $this->input->post()
			 AND $this->event_model->getRemainingSlots( $this->input->post('event_id') ) > 0 )
		{	// has slot(s)
			$chinatrust_data['auto_cap'] = 1;
			$fail = FALSE; // transaction is valid
		}
		else
		{	// all slots taken
			$chinatrust_data['auto_cap'] = 0;
		}

		if ( $this->session->userdata('cockroach') )
		{	// prevent duplicating orders
			$data['cockroach'] = $this->session->userdata('cockroach');
			$this->prepareSave( $this->input->post(), $order_id, $fail );
			$data['has_cockroach'] = TRUE;
			$this->session->unset_userdata('cockroach');
		}
		else
		{   // hides buttons and shows error message
			$data['has_cockroach'] = FALSE;
		}

		// prepare chinatrust variables
		$chinatrust_data = array_merge($chinatrust_data, [
			'order_id' => $order_id,
			'amount' => $amount,
			'event_title' => $event['event_title'],
			'return_url' => site_url('event/feedback')
		]);

		$data['third_party'] = chinatrustSend( $chinatrust_data );
		$data['order_id'] = $order_id;
		$data['auth_url'] = getAuthURL( TEST );
		$data['event'] = $event;
		$data['site_title'] = 'Step 3 - ' . $data['event']['event_title'] . ' - ' . $this->site_setting['site_title'];
		$data['main_content'] = 'step3';
		$this->load->view('front_page', $data);
	}

	function feedback()
	{
		$this->load->helper("chinatrust");
		// echo "<pre>";print_r($this->input->post());echo "</pre>";
		$result_array = chinatrustReceive( $this->input->post() );
		// echo "<pre>";print_r($result_array);echo "</pre>";
		// echo gettype($result_array['encArray']['status']) .'<br>';
		// echo gettype($result_array['encArray']['errcode']) .'<br>';
		// echo gettype($result_array['encArray']['errdesc']) .'<br>';
		if ( $result_array['result'] == TRUE 
			 AND $result_array['encArray']['status'] == '0'
			 AND $result_array['encArray']['errcode'] == '00'
			 AND $result_array['encArray']['errdesc'] == 'null' )
		{
			if ( $this->participant_model->bookingFailed( $result_array['encArray']['lidm'] ) )
			{
				// booking unsucceful
				$this->session->set_flashdata('fail', 1);
			}
			else
			{
				// booking successful
				// booking has been paid
				$this->participant_model->paid( $result_array['encArray']['lidm'], TRUE );
				$participant_id = $this->participant_model->getParticipantId( array('order_id' => $result_array['encArray']['lidm']) );
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
					'message'	=> $this->load->view('emails/success', $email_data, true)
				);

		    	$this->load->helper('email');
		    	send( $data );

		    	$this->session->unset_userdata('cockroach');
		    	$this->session->set_userdata('slug', $event['slug']);
			}
		}
		else
		{
			$this->participant_model->setBookigStatus($result_array['encArray']['lidm']);
			// booking unsucceful
			$this->session->set_flashdata('fail', 1);
		}

		$this->session->set_flashdata('status', '訂位');
		redirect('event/complete');
	}

	function store()
	{
		$this->load->model("events/event_model");
		if ( $this->input->post()
			 AND ( $this->event_model->getRemainingSlots( $this->input->post('event_id') ) >= $this->input->post('extra_people') 
			 OR $this->event_model->getRemainingWaitingSlots( $this->input->post('event_id') ) >= $this->input->post('extra_people') ) )
		{
			$order_id = $this->unique_id();
			
			$this->prepareSave( $this->input->post(), $order_id, FALSE );

			$email_data = array (
				'participant_name' => $this->input->post('participant_name'),
				'event_title' => $this->input->post('event_title'),
				'time' => date('Y-m-d H:i', strtotime($this->input->post('room_open_time'))) . ' - ' . date('H:i', strtotime($this->input->post('room_close_time'))),
				'order_id' => $order_id,
				'fees' => number_format( $this->input->post('extra_people') * $this->input->post('fees'), 0, '.', ',' ),
				'people' => $this->input->post('extra_people'),
				'invoice_types' => $this->input->post('invoice_types'),
				'seach_url' => site_url('search')
			);
			$data = array (
				'email_recipient' => $this->input->post('email'),
				'subject'	=> '[' . $this->input->post('event_title') . '] 活動候補成功通知信',
				'message'	=> $this->load->view('emails/reserve', $email_data, TRUE)
			);

	    	$this->load->helper('email');
	    	send( $data );
		}
		else
		{
			$this->session->set_flashdata('fail', 1);
		}

		$this->session->set_flashdata('status', $this->input->post('order_status'));
		$this->session->set_userdata('slug', $this->input->post('slug'));
		redirect('event/complete');
	}

	function complete()
	{
		if ( ! $this->session->flashdata('status') )
		{
			if ( $this->session->userdata('slug') )
			{
				$slug = $this->session->userdata('slug');
				$this->session->unset_userdata('slug');
				redirect('event/' . $slug);
			}
			else
			{
				redirect(OFFICIAL_SITE);
			}
		}
		// flash message
		$data['flash_status'] = $this->session->flashdata('status')? $this->session->flashdata('status') : '';
		$data['flash_fail'] = $this->session->flashdata('fail')? $this->session->flashdata('fail') : 0;

		$data['slug'] = ($this->session->userdata('slug'))? $this->session->userdata('slug') : NULL;
		$data['site_title'] = $this->site_setting['site_title'];
		$data['main_content'] = 'complete';
		$this->load->view('front_page', $data);
	}

	function ajaxStep1()
	{
		$response = array('alert' => 'danger');

		if ( $this->checkCardNumbers( $this->input->post('card_digits') ) )
		{
			$response['alert'] = 'success';
		}
		else
		{
			$response['message'] = '<i class="ico-info mr5"></i>此卡號非中國信託信用卡...';
		}

		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($response));
	}

	private function checkCardNumbers($number)
	{
		$valid_numbers = array(
			'037768',
			'356051',
			'356075',
			'356351',
			'356375',
			'356551',
			'356651',
			'356712',
			'356714',
			'377663',
			'377683',
			'400001',
			'400025',
			'400361',
			'402980',
			'404329',
			'406586',
			'418230',
			'421598',
			'421599',
			'426614',
			'430451',
			'431195',
			'447757',
			'447768',
			'451873',
			'456301',
			'456319',
			'461746',
			'481537',
			'483515',
			'494124',
			'494125',
			'515352',
			'517357',
			'523953',
			'540829',
			'542863',
			'543372',
			'546697',
			'547785',
			'552049',
			'558888',
			'416217',
			'537675',
			'537805',
			'517357'
		);

		return (int) in_array($number, $valid_numbers) ? TRUE : FALSE;
	}

	private function unique_id($l = 8)
	{
	    return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $l);
	}

	private function prepareSave($raw_data, $order_id, $fail = TRUE)
	{

		$data = array(
			'event_id' => $raw_data['event_id'],
			'order_id' => $order_id,
			'participant_name' => $raw_data['participant_name'],
			'participant_phone' => $raw_data['participant_phone'],
			'email' => $raw_data['email'],
			'invoice_types' => $raw_data['invoice_types'],
			'invoice_title' => $raw_data['invoice_title'],
			'invoice_number' => $raw_data['invoice_number'],
			'fail' => $fail
		);

		if ( isset($raw_data['order_status']) )
		{
			$data['status'] = $raw_data['order_status'];
		}

		if ( $raw_data['extra_people'] > 1 )
		{
			$more_data = array(
				'extra_people' => $raw_data['extra_people'],
				'other_participant_name' => $raw_data['other_participant_name'],
				'other_participant_phone' => $raw_data['other_participant_phone']
			);
			$this->participant_model->create($data, $more_data);
		}
		else
		{
			$this->participant_model->create($data);
		}
	}

	public function _remap($method)
	{
		$available = array(
			'step1', 'step2', 'step3', 'feedback', 'store', 'complete', 'ajaxStep1'
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