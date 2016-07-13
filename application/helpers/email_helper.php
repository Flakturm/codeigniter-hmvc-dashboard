<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('send') )
{
	function send( $data = array(), $test = array() )
	{		
		$ci = get_instance();
		$ci->load->model('settings/settings_model');

		if ( count( $test ) )
		{
			$data = $test;
		}
		else
		{
			if ( count( $data ) )
			{	// push settings to data array
				$arr = $ci->settings_model->read();
				foreach ( $arr as $key => $value )
				{
					if ( isset( $data[$key] ) )
					{
						unset( $arr[$key] );
					}
				}
				$data = array_merge($data, $arr);
			}
			else
			{
				$data = $ci->settings_model->read();
			}
		}
        $ci->load->library('email');

		$config['protocol'] = 'smtp';
        $config['smtp_host'] = $data['smtp_host'];
        $config['smtp_user'] = $data['smtp_user'];
        $config['smtp_pass'] = $data['smtp_pass'];
        $config['smtp_port'] = $data['smtp_port'];
        $config['smtp_crypto'] = 'ssl';
        $config['smtp_timeout'] = 10;
        $config['mailtype'] = 'html';
        $config['newline'] = "\r\n";
        $config['charset'] = 'utf-8'; // iso-8859-1
        $config['crlf'] = "\r\n";
        $ci->email->initialize($config);

        $ci->email->to( $data['email_recipient'] );        
        $ci->email->from( $data['smtp_user'], $data['site_title'] );

        $ci->email->subject( $data['subject'] );
        $ci->email->message( $data['message'] );

        if ( ! $ci->email->send() )
		{
		    return false;
		}
		else
		{
			return true;
		}
	}
}