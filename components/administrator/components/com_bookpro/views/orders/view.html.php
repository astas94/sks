<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 56 2012-07-21 07:53:28Z quannv $
 **/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
AImporter::helper('bookpro', 'paystatus','orderstatus');
class BookProViewOrders extends JViewLegacy
{
    
    var $items;
    var $state;
    var $pagination;

    
    function display($tpl = null)
    {
    	$mainframe = JFactory::getApplication();
       $document = JFactory::getDocument();
        $document->setTitle('Orders Management');
        $this->state=$this->get('State');
        $this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
       //	$this->assign('orderstatus',$this->getOrderStatusSelect(''));//$this->lists['order_status']
       	$this->agents=BookProHelper::getCustomerGroupSelect($this->state->get('filter.group_id'));
       	$this->ranges=BookProHelper::getRangeSelect($this->state->get('filter.range'));
       	
        $this->orderstatus=$this->getOrderStatusSelect($this->state->get('filter.order_status'));
       	$this->paystatus=$this->getPayStatusSelect($this->state->get('filter.pay_status'));
       	
		$this->addToolbar();
       	parent::display($tpl);
    }
    
    protected function addToolbar(){
    	JToolbarHelper::title(JText::_('COM_BOOPRO_MANAGER_ORDERS'));
    	JToolbarHelper::editList('order.edit');
    	JToolbarHelper::deleteList('','orders.delete', 'JTOOLBAR_DELETE');
    }
    
	function getOrderStatusSelect($select){
		OrderStatus::init();
		return AHtml::getFilterSelect('filter_order_status', JText::_('COM_BOOKPRO_SELECT_ORDER_STATUS'), OrderStatus::$map, $select, false, 'class="input input-medium"', 'value', 'text');
	}
	function getPayStatusSelect($select) {
		PayStatus::init();
		return AHtml::getFilterSelect('filter_pay_status', JText::_('COM_BOOKPRO_SELECT_PAY_STATUS'), PayStatus::$map, $select, false, 'class="input input-medium"', 'value', 'text');
	}
	
	function getAgents($select){
		AImporter::model('customers');
		$config=JComponentHelper::getParams('com_bookpro');
		$model=new BookProModelCustomers();
		$state=$model->getState();
		//$state->set('filter.group_id',)
		$model->getItems();
	}
	
	function td_getPayStatusSelect($select,$id) {
		PayStatus::init();
		return JHtmlSelect::genericlist(PayStatus::$map,$id, 'class="td_paystatus input-small"' ,'value', 'text', $select);
	}
	
	function td_getOrderStatusSelect($select,$id){
		OrderStatus::init();
		return JHtmlSelect::genericlist(OrderStatus::$map,$id, 'class="td_orderstatus input-small"','value', 'text',$select);
	}
	
	
}