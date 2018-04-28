<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.parameter.element');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
class JFormFieldSeattemplate extends JFormFieldList
{
	
	protected $type = 'Seattemplate';
	var $day = 0;
	var $hour = 0;
	var $minute = 0;
	protected function getInput(){
		
		
		$html = array();
		$value = $this->value;
		$duration = explode(":", $value);
		$day =(int) $duration[0]/24;
		$hour = $duration[0]%24;
		$minute = $duration[1];
		
		
		$html[] = '<div class="input-prepend bootstrap-timepicker">';
		$html[] = '<span class="add-on">'.JText::_('Day').'</span>';
		$html[] = JHtmlSelect::integerlist(0, 30, 1, 'duration[day]','class="input-mini" id="duration_day"',$day);
		$html[] = '</div>';
		$html[] = '<div class="input-prepend bootstrap-timepicker">';
		$html[] = '<span class="add-on">'.JText::_('Hour').'</span>';
		$html[] = JHtmlSelect::integerlist(0, 23, 1, 'duration[hour]','class="input-mini" id="duration_hour"',$hour);
		$html[] = '</div>';
		$html[] = '<div class="input-prepend bootstrap-timepicker">';
		$html[] = '<span class="add-on">'.JText::_('Minute').'</span>';
		$html[] = JHtmlSelect::integerlist(0, 60, 5, 'duration[minute]','class="input-mini" id="duration_minute"',$minute);
		$html[] = '</div>';
		return implode("\n", $html);
	}
}
?>