<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 47 2012-07-13 09:43:14Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');


//import needed JoomLIB helpers
AImporter::helper( 'bookpro', 'bus');
AImporter::model('buses','airports','agents');

class BookProViewBusTrips extends JViewLegacy
{
	protected $items;
	function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->state->set('filter.price',1);
		//$this->state->set('test',1);
		$this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
	    
        
		$airportFrombox=$this->getDestinationSelectBox($this->state->get('filter.from'),'filter_from',JText::_('COM_BOOKPRO_SELECT_FROM'));
		$airportTobox=$this->getDestinationSelectBox($this->state->get('filter.to'),'filter_to',JText::_('COM_BOOKPRO_SELECT_TO'));
		$this->dfrom=$airportFrombox;
		$this->dto=$airportTobox;
		$this->bus=BusHelper::getBusSelectBox($this->state->get('filter.bus_id'),'filter_bus_id');
		$this->agents=$this->getAgentSelectBox($this->state->get('filter.agent_id','filter_agent_id'));
		$this->addToolbar();
		parent::display($tpl);
		 //die;
	}
	
	function getDestinationSelectBox($select, $field = 'filter_from',$text)
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
       
		return AHtml::getFilterSelect($field, $text, $fullList, $select, true, '', 'id', 'title');
	}
	function getAgentSelectBox($select,$field="filter_agent_id"){
		$model=new BookProModelAgents();
		$items=$model->getItems();
		return AHtml::getFilterSelect($field, JText::_('COM_BOOKPRO_SELECT_AGENT'), $items, $select, true, '', 'id', 'brandname');
	}
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::_('Управление маршрутами'), 'stack');
		$bar = JToolBar::getInstance('toolbar');
		//JToolBarHelper::addNew();
		$bar->appendButton( 'Link', 'new', 'Новый маршрут', 'index.php?option=com_bookpro&view=generate');
		JToolBarHelper::editList();
		
		JToolBarHelper::divider();
		
		JToolBarHelper::publish('bustrips.publish', 'Опубликовать', true);
		JToolBarHelper::unpublishList('bustrips.unpublish', 'Снять с публикации', true);
		
		//JToolbarHelper::deleteList('', 'roomrate.delete1');
	}
}

?>