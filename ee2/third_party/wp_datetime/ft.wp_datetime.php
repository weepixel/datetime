<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */

// --------------------------------------------------------------------

/**
 * Wee Pixel DateTime Fieldtype
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Fieldtype
 * @author		John Clark - Wee Pixel
 * @link		http://weepixel.com
 */
class Wp_datetime_ft extends EE_Fieldtype {

	var $info = array(
		'name'		=> 'WP DateTime',
		'version'	=> '0.9.1'
	);

	var $has_array_data = TRUE;
	
	private function _include_theme_css($file)
	{
		$this->EE->cp->add_to_head('<link rel="stylesheet" type="text/css" href="'.$this->EE->config->item('theme_folder_url')."third_party/wp_datetime/".$file.'?'.$this->info['version'].'" />');
	}

	private function _include_theme_js($file)
	{
		$this->EE->cp->add_to_foot('<script type="text/javascript" src="'.$this->EE->config->item('theme_folder_url')."third_party/wp_datetime/".$file.'?'.$this->info['version'].'"></script>');
	}

	function display_field($data)
	{
		$this->_include_theme_css('styles/jquery-ui-wp_datetime.css');
		$this->_include_theme_css('styles/wp_datetime.css');
		$this->_include_theme_js('scripts/jquery-ui-datepicker-slider.js');
		$this->_include_theme_js('scripts/jquery-ui-timepicker-addon.js');
		$this->_include_theme_js('scripts/wp_datetime.js');
		
		$this->EE->load->helper('custom_field');
		
		$r = form_input(array('label'=>'Date','name'=>$this->field_name, 'class'=>'hasDatetimepicker min-'.$this->settings['field_mins'].' display-'.$this->settings['field_display'], 'value' => !empty($data) ? (is_numeric($data) ? date("Y-m-d g:i A", strftime($data)) : $data) : ""));
		
		return $r;
	}
	
	function display_cell($data)
	{	
		$this->_include_theme_css('styles/jquery-ui-wp_datetime.css');
		$this->_include_theme_css('styles/wp_datetime.css');
		$this->_include_theme_js('scripts/jquery-ui-datepicker-slider.js');
		$this->_include_theme_js('scripts/jquery-ui-timepicker-addon.js');
		$this->_include_theme_js('scripts/wp_datetime.js');
		
		$this->EE->load->helper('custom_field');
		
		$r = form_input(array('label'=>'Date','name'=>$this->cell_name, 'class'=>'hasDatetimepicker matrix-textarea min-'.$this->settings['field_mins'].' display-'.$this->settings['field_display'], 'style'=>'border:none', 'value' => !empty($data) ? (is_numeric($data) ? date("Y-m-d g:i A", strftime($data)) : $data) : ""));
		
		$this->EE->load->library('javascript');

		$this->EE->javascript->output('
			Matrix.bind("wp_datetime", "display", function(cell){
						
					var input = $("input", cell.dom.$td);
					
					if (input.hasClass("display-datetime")) {
						
						var defaults = {
							dateFormat: "yy-mm-dd",
							ampm: true,
							timeFormat: "h:mm TT"
						}
						
						if (input.hasClass("min-1")) {
							input.datetimepicker(jQuery.extend({}, defaults));
						}
						else if (input.hasClass("min-5")) {
							input.datetimepicker(jQuery.extend({ stepMinute: 5 }, defaults));
						}
						else if (input.hasClass("min-10")) {
							input.datetimepicker(jQuery.extend({ stepMinute: 10 }, defaults));
						}
						else if (input.hasClass("min-15")) {
							input.datetimepicker(jQuery.extend({ stepMinute: 15 }, defaults));
						}
					}
					else if (input.hasClass("display-time")) {
						
						var defaults = {
							ampm: true,
							timeFormat: "h:mm TT"
						}
						
						if (input.hasClass("min-1")) {
							input.timepicker(jQuery.extend({}, defaults));
						}
						else if (input.hasClass("min-5")) {
							input.timepicker(jQuery.extend({ stepMinute: 5 }, defaults));
						}
						else if (input.hasClass("min-10")) {
							input.timepicker(jQuery.extend({ stepMinute: 10 }, defaults));
						}
						else if (input.hasClass("min-15")) {
							input.timepicker(jQuery.extend({ stepMinute: 15 }, defaults));
						}
					}
					else {
						input.datepicker({ dateFormat: "yy-mm-dd" });
					}
	
					$(".ui-datepicker").css("z-index","110 !important");
			});
		');
		
		return $r;
	}
	
	// --------------------------------------------------------------------
	
	function display_cell_settings($settings)
	{
		return array(
			array('Minute Intervals', form_dropdown('field_mins', array("1"=>"All","5"=>"5 mins","10"=>"10 mins", "15"=>"15 Mins"), isset($settings['field_mins']) ? $settings['field_mins'] : "5")),
			array('Display', form_dropdown('field_display', array("datetime"=>"Date & Time","date"=>"Date","time"=>"Time"), isset($settings['field_display']) ? $settings['field_display'] : "datetime"))
		);
	}
	
	// --------------------------------------------------------------------
	
	function display_settings($data)
	{
		$this->EE->table->add_row(
			'<p class="field_format_option select_format"><strong>Minute Intervals</strong></p>',
			'<p class="field_format_option select_format_n">'.
				form_dropdown('field_mins', array("1"=>"All","5"=>"5 mins","10"=>"10 mins", "15"=>"15 Mins"), isset($data['field_mins']) ? $data['field_mins'] : "5").
			'</p>'
		);
		$this->EE->table->add_row(
			'<p class="field_format_option select_format"><strong>Display</strong></p>',
			'<p class="field_format_option select_format_n">'.
				form_dropdown('field_display', array("datetime"=>"Date & Time","date"=>"Date","time"=>"Time"), isset($data['field_display']) ? $data['field_display'] : "datetime").
			'</p>'
		);
	}
	
	// --------------------------------------------------------------------
	
	function save_settings($data)
	{
		return array(
			'field_mins'	=> $this->EE->input->post('field_mins'),
			'field_display'	=> $this->EE->input->post('field_display')
		);
	}
	
	// --------------------------------------------------------------------
	
	function replace_tag($data, $params = array(), $tagdata = FALSE)
	{
		$this->EE->load->helper('custom_field');
		
		if(isset($params['format'])){
			$data = date(str_replace("%", "", $params['format']), strftime($data));
		}
		
		return $data;
	}
	
	// --------------------------------------------------------------------
	
	function save_cell($data)
	{
		return strtotime($data);
	}
	
	function save($data)
	{
		return strtotime($data);
	}

}

// END Date_ft class

/* End of file ft.date.php */
/* Location: ./system/expressionengine/fieldtypes/ft.date.php */