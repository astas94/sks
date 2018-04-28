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
AImporter::model('agents','pmibustrips');
class BookproViewSeatallocations extends JViewLegacy{
	protected $state;
	protected $items;
	function display($tpl=null){
		 $this->state=$this->get('State');
		
		
 	//$model= new BookProModelPmiBustrips();
	
	//$this->state = $model->getState();
	
	$depart_date=JFactory::getApplication()->input->get('depart_date', 0);
	$router_id=JFactory::getApplication()->input->get('router_id', 0);
	$agent_id=JFactory::getApplication()->input->get('agent_id', 0);
	$children=JFactory::getApplication()->input->get('children', 0);
	$paystatus=JFactory::getApplication()->input->get('paystatus', 0);

// 	$model->setState('filter.route_id', $router_id);
// 	$model->setState('filter.depart_date', $depart_date);
// 	$model->setState('filter.agent_id', $agent_id);
// 	$model->setState('filter.children', $children);
// 	$model->setState('filter.pay_status', $paystatus);
	

	//$this->items= $model->getItems();
 	parent::display();
 
	}
 
	
}