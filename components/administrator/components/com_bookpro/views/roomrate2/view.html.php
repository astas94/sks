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

AImporter::model('roomrate2','bustrip', 'roomratelogs','bustrips');
AImporter::helper('bookpro','currency');


class BookProViewRoomRate2 extends JViewLegacy
{
	
	var $items;

	/**
	 * Standard Joomla! browse tables pagination object.
	 *
	 * @var JPagination
	 */
	var $pagination;
	
	function delete1()
    {
        die;
    }
	
	function getFullBustrip($code_trip, $route_arr)
    {
        $mod = new BookProModelBusTrip();
        return $mod->getComplexRoute($code_trip, $route_arr);
    }
    
    function getFullBustrip2($code_trip, $route_arr)
    {
        $mod = new BookProModelBusTrip();
        return $mod->getComplexRoute2($code_trip, $route_arr);
    }
    
    function getFullBustripReturn($code_trip, $route_arr)
    {
        $mod = new BookProModelBusTrip();
        return $mod->getComplexReturnRoute($code_trip, $route_arr);
    }
    
    function getFullBustripReturn2($code_trip, $route_arr)
    {
        $mod = new BookProModelBusTrip();
        return $mod->getComplexReturnRoute2($code_trip, $route_arr);
    }

    function getDestinationSelectBox($select, $field = 'dest_idsel')
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
      // die;
		return AHtml::getFilterSelect($field, JText::_('COM_BOOKPRO_SELECT_DESTINATION'), $fullList, $select, false, 'class="destination"', 'id', 'title');
    }

	function display($tpl = null)
	{
		$this->_displayForm($tpl);
	}


	function _displayForm($tpl)
	{
		$input=JFactory::getApplication()->input;
		
		$bustrip_id = $input->get('bustrip_id', '', 'int');
		//hotel
		if($bustrip_id){
			$modelHotel = new BookProModelBusTrip();
			
			$this->obj = $modelHotel->getItem($bustrip_id);
		}
		
		$this->rooms=$this->getRoomSelect($bustrip_id);

		$model = new BookProModelRoomRateLogs();
		$state=$model->getState();
		$state->set('filter.room_id',$bustrip_id);
		$state->set('list.ordering','ID');
		$state->set('list.direction','DESC');
		$this->pagination = $model->getPagination();
		$this->items = $model->getItems();
				 
		parent::display($tpl);
	}
	function getRoomSelect($bustrip_id){
		$param = array('order'=>'lft','order_Dir'=>'ASC');
		$model = new BookProModelBusTrips();
		$state=$model->getState();
		$state->set('list.limit',0);
		$lists=$model->getItems();
		$items = array();
		$items[] = JHtmlSelect::option(0,JText::_('COM_BOOKPRO_SELECT_ROOM'),'id','title');
		foreach ($lists as $list){
			$title = str_repeat('-', $list->level - 1). $list->title;
			 
			$items[] = JHtmlSelect::option($list->id,$title,'id','title');
		}
		return JHTML::_('select.genericlist', $items, 'room_id', '', 'id', 'title', $bustrip_id);
		//return AHtml::getFilterSelect('room_id', 'COM_BOOKPRO_SELECT_ROOM', $list, $select, '', '', 'id', 'title');
	}
	/**
	 *
	 * @param unknown $name
	 * @param unknown $selected
	 * @return Ambigous <s, string>
	 */
	static function getDayWeek($name){
		 AImporter::helper('date');
		$days=DateHelper::dayofweek();
		$daysweek=array();
		foreach ($days as $key => $value)
		{
			$object=new stdClass();
			$object->key=$key;
			$object->value=$value;
			$daysweek[]=$object;
		}
		$selected=array_keys($days);
		return AHtml::checkBoxList($daysweek,$name,'',$selected,'key','value');

	}


}

?>