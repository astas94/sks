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
class GenerateHelper{
	static function getDestinationSelectBox($select, $field = 'dest_id[]')
    {
        AImporter::model('airports');
    	$model = new BookProModelAirports();
    	$state=$model->getState();
    	$state->set('list.start',0);
    	$state->set('list.limit', 0);
    	$state->set('list.state', 1);
    	$state->set('list.province', 1);
    	$state->set('list.parent_id', 1);
    	$fullList = $model->getItems();
       
		return AHtml::getFilterSelect($field, JText::_('COM_BOOKPRO_SELECT_DESTINATION'), $fullList, $select, false, 'class="destination"', 'id', 'title');
    }
    static function getFilterRoute($jform){
    	$routes = array();
    	foreach ($jform as $obj){
    		if ((int) $obj->dest_id){
    			array_push($routes, $obj);
    		}
    	}
    	return $routes;
    }
    static function getBusSelectBox($selected, $field = 'bus_id') {
    	$model = new BookProModelBuses ();
    	$fullList = $model->getItems ();
    	$attribs = array(
    		'class'=>'select-required validate-select'			
    	);
    	$box = JHtmlSelect::genericlist ( $fullList, $field, $attribs, 'id', 'title', $selected );
    	return $box;
    	// return AHtml::getFilterSelect($field, JText::_('COM_BOOKPRO_SELECT_BUS'), $fullList, $selected, true, '', 'id', 'title');
    }
	static function getSeatLayout(){
		$model = new BookProModelSeattemplates();
		$fullList = $model->getItems();
		return AHtml::getFilterSelect('seat_layout_id', 'COM_BOOKPRO_SELECT_SEATTEMPLATE', $fullList, $select, false, '', 'id', 'title');
	}
	static function getAgentSelectBox($select){
		$model = new BookProModelAgents();
		$fullList = $model->getItems();
		 
		 
		return AHtml::getFilterSelect('agent_id', 'COM_BOOKPRO_SELECT_AGENT', $fullList, $select, false, 'class="select-required validate-select"', 'id', 'company');
	
	}
	
	
	
	static function getRoutes($from,$arrs){
		$routes =array($from->dest_id);
		
		foreach ($arrs as $arr){
			
			if ((int) $arr->dest_id){
				
				array_push($routes, $arr->dest_id);
			}
			
		}
		
		return $routes;
	}
	static function getGenerateRoute($from,$arrs,$routes,$generate){
		$bustrips = array();
		AImporter::model('airport','agent','bus');
		for ($i = count($arrs)-1;$i >=0;$i--){
			$agentModel = new BookProModelAgent();
			$agentModel->getItem($generate->agent_id);
			$busModel = new BookproModelBus();
			$busModel->getItem();
	
			$arr = $arrs[$i];
			$route = new JObject();
			$route->code = $generate->code;
			$route->agent_id = $generate->agent_id;
	
	
			$route->bus_id = $generate->bus_id;
	
	
			$route->from = $from->dest_id;
			$fromModel = new BookProModelAirport();
			$item_from = $fromModel->getItem($from->dest_id);
			$route->from_title = $item_from->title;
			
	
			$route->to = $arr->dest_id;
			$toModel = new BookProModelAirport();
			$item_to = $toModel->getItem($arr->dest_id);
			$route->to_title = $item_to->title;
			$route->route = implode(";", $routes);
			$bustrips[] = $route;
		}
		 
		return $bustrips;
	}
	static function getBusTrips($from,$arrTo,$routes,$duration = false){
		$bustrips = array();
		for ($i = count($arrTo)-1;$i >=0;$i--){
			$arr = $arrTo[$i];
			$obj = new stdClass();
	
			$obj->from = $from->dest_id;
			$obj->to = $arr->dest_id;
			$obj->start_time = $from->start_time;
			$obj->end_time = $arr->start_time;
			$obj->start_loc = $from->location;
			$obj->end_loc = $arr->location;
			$obj->route = implode(";", $routes);
	
			if ($from->duration){
				 
				$start = new JDate();
				$interval = 'P'.$from->duration->day.'DT'.$from->duration->hour.'H'.$from->duration->minute.'M';
				 
				$start->add(new DateInterval($interval));
				 
				$end = new JDate();
				$interval = 'P'.$arr->duration->day.'DT'.$arr->duration->hour.'H'.$arr->duration->minute.'M';
				$end->add(new DateInterval($interval));
				 
				$diff = $end->diff($start);
				 
				$hour = $diff->d*24 + $diff->h;
				$hour = $hour < 10 ? "0".$hour : $hour;
				$minute = $diff->i < 10 ? "0".$diff->i:$diff->i;
				 
				$duration = $hour.":".$minute;
				 
				$obj->duration = $duration;
				//$obj->duration = JFactory::getDate($time)->format('H:i');
			}else{
				$hour = $arr->duration->day*24 + $arr->duration->hour;
				$hour = $hour < 10 ? "0".$hour:$hour;
				$minute = $arr->duration->minute < 10 ? "0".$arr->duration->minute:$arr->duration->minute;
				$duration = $hour.":".$minute;
				$obj->duration = $duration;
				 
			}
			$bustrips[] = $obj;
		}
		 
		return $bustrips;
	}
	static function getStartTime($dfrom,$from){
		$date = JFactory::getDate('now')->format('Y-m-d');
		$date_time = $date.' '.$dfrom->start_time;
		 
		$start = new JDate($date_time);
	
		$interval = 'P'.$from->duration->day.'DT'.$from->duration->hour.'H'.$from->duration->minute.'M';
	
		$start->add(new DateInterval($interval));
	
		$start_time = $start->format('H:i');
		 
		$from->start_time = $start_time;
		return $from;
	}
	static function setStartTime($dfrom,$jform){
	
		$routes = array();
		 
		$arrFrom = $jform;
		foreach ($arrFrom as $from){
			$routes[] = $this->getStartTime($dfrom,$from);
		}
		return $routes;
	}
}
?>