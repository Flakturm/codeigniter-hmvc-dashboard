<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('plugin_url'))
{
	function plugin_url()
	{
		$CI =& get_instance();
		return base_url() . $CI->config->item('plugin_path');
	}
}
if ( ! function_exists('js_burl'))
{
	function js_burl()
	{
		$CI =& get_instance();
		return base_url() . $CI->config->item('js_bpath');
	}
}
if ( ! function_exists('js_furl'))
{
	function js_furl()
	{
		$CI =& get_instance();
		return base_url() . $CI->config->item('js_fpath');
	}
}

/**
 * Load CSS
 * Creates the <link> tag that links all requested css file
 * @access  public
 * @param   string
 * @return  string
 */
if ( ! function_exists('queue_css'))
{
    function queue_css($file, $media='all')
    {
    	// echo "<pre>";print_r($file);echo "</pre>";exit();
		if(!empty($file))
		{
			foreach($file as $e)
			{
				echo '<link rel="stylesheet" href="' . plugin_url() . $e . '">'."\n";
			}
		}
    }
}

/**
 * Load JS
 * Creates the <script> tag that links all requested js file
 * @access  public
 * @param   string
 * @param 	array 	$atts Optional, additional key/value attributes to include in the SCRIPT tag
 * @return  string
 */
if ( ! function_exists('queue_js'))
{
    function queue_js($file, $plugin = false, $front = false)
    {
		if(!empty($file))
		{
			if ($front)
			{
				foreach($file as $e)
				{
					echo '<script src="' . js_furl() . $e . '"></script>'."\n";
				}
			}
			else if ($plugin)
			{
				foreach($file as $e)
				{
					echo '<script src="' . js_burl() . $e . '"></script>'."\n";
				}
			}
			else
			{
				foreach($file as $e)
				{
					echo '<script src="' . plugin_url() . $e . '"></script>'."\n";
				}
			}
		}
    }
}
/* End of file queuescript_helper.php */