<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bustrip.php 66 2012-07-31 23:46:01Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');


class BookProControllerBusTrip extends JControllerForm
{
    
    function calendar(){
    	$calendar_attributes = array(
    			'min_select_year' => 2014,
    			'max_select_year' => 2016
    	);
    	if (isset($_REQUEST['action']) AND $_REQUEST['action'] == 'pn_get_month_cal') {
    		require_once JPATH_COMPONENT_ADMINISTRATOR.'/classes/calendar.php';
    		AImporter::css('calendar');
    		$calendar = new PN_Calendar($calendar_attributes);
    		echo $calendar->draw(array(), $_REQUEST['year'], $_REQUEST['month']);
    		exit;
    	}
    	
    	
    }
    function end_time(){
    	$input = JFactory::getApplication()->input;
    	$start_time = $input->get('start_time','','string');
    	$duration = json_decode(json_encode($input->get('duration',array(),'array')),false);
    	$interval = 'P'.$duration->day.'DT'.$duration->hour.'H'.$duration->minute.'M';
    	
    	$date = JFactory::getDate('now')->format('Y-m-d');
    	$date_time = $date.' '.$start_time;
    	$start = new JDate($date_time);
    	$start->add(new DateInterval($interval));
    	$end_time = $start->format('H:i');
    	echo $end_time;
    	die;
    }
    function deleteRate(){
    	$id = JRequest::getInt('id',0);
    	$db = JFactory::getDbo();
    	$query = $db->getQuery(true);
    	if ($id) {
    		$query->delete('#__bookpro_roomrate');
    		$query->where('id='.$id);
    		$db->setQuery($query);
    		$db->query();
    	}
    	$calendar_attributes = array(
    			'min_select_year' => 2015,
    			'max_select_year' => 2018
    	);
    	if (isset($_REQUEST['action']) AND $_REQUEST['action'] == 'pn_get_month_cal') {
    		require_once JPATH_COMPONENT_ADMINISTRATOR.'/classes/calendar.php';
    		AImporter::css('calendar');
    		$calendar = new PN_Calendar($calendar_attributes);
    		echo $calendar->draw(array(), $_REQUEST['year'], $_REQUEST['month']);
    		exit;
    	}
    }


  }

?>