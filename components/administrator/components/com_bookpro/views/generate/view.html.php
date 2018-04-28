<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 81 2012-08-11 01:16:36Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');

AImporter::model('airports','seattemplates','agents','buses','bustrip');
AImporter::helper('bus','generate');


class BookProViewGenerate extends JViewLegacy
{
    function display($tpl = null)
    {
     	$input=JFactory::getApplication()->input;
        $airportFrombox=$this->getDestinationSelectBox(null,'dest_id[]');
        $this->agent_id=$input->get('agent_id');
        $this->bus_id=$input->get('bus_id');
        $this->code=$input->get('code');
        $this->dests=$input->get('dest_id',array(),'array');
        $this->depart=$input->get('depart',array(),'array');
        $this->bus=$this->getBusSelectBox(null);
        
        
        
        parent::display($tpl);
    }
	
 	function getDestinationSelectBox($select, $field = 'dest_id[]')
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
    function getBusSelectBox($selected, $field = 'generate[bus_id]') {
    	$model = new BookProModelBuses ();
    	$fullList = $model->getItems ();
    	$attribs = array(
    		'class'=>'select-required validate-select'			
    	);
    	$box = JHtmlSelect::genericlist ( $fullList, $field, $attribs, 'id', 'title', $selected );
    	return $box;
    }
    function getSeatLayout(){
    	$model = new BookProModelSeattemplates();
    	$fullList = $model->getItems();
    	return AHtml::getFilterSelect('seat_layout_id', 'COM_BOOKPRO_SELECT_SEATTEMPLATE', $fullList, $select, false, '', 'id', 'title');
    }
    function getAgentSelectBox($select){
    	$model = new BookProModelAgents();
    	$fullList = $model->getItems();
    	
    	return AHtml::getFilterSelect('generate[agent_id]', 'COM_BOOKPRO_SELECT_AGENT', $fullList, $select, false, 'class="select-required validate-select"', 'id', 'company');
    
    }
 
}

?>