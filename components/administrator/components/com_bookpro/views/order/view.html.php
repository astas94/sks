 
 <?php
 /**
  * @package 	Bookpro
  * @author 		Ngo Van Quan
  * @link 		http://joombooking.com
  * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
  * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  * @version 	$Id: view.html.php 62 2012-07-29 01:18:34Z quannv $
  **/

 defined('_JEXEC') or die('Restricted access');

 AImporter::model('customer','order','passengers','orders');
 AImporter::helper('bookpro','paystatus','ordertype','orderstatus','currency');


 class BookProViewOrder extends JViewLegacy
 {

 	/**
 	 * Prepare to display page.
 	 *
 	 * @param string $tpl name of used template
 	 */
 	protected $item;
 	protected $form;

 	public function display($tpl=null){
 		$this->item = $this->get('ComplexItem');
 		$this->form = $this->get('Form');
 		$this->order = $this->item;
 		if (count($errors = $this->get('Errors'))){
 			JError::raiseError(500, implode("\n", $errors));
 			return false;
 		}
 		
 		
 		
 		if ($this->getLayout() != 'default') {
 			$this->addToolbar();
 		}

 		
 		parent::display($tpl);
 	}

 	protected function addToolbar(){
 		JFactory::getApplication()->input->set('hidemainmenu', true);
 		JToolbarHelper::title ( $this->item->id?JText::_ ( 'COM_BOOKPRO_EDIT_ORDER' ):JText::_ ( 'COM_BOOKPRO_NEW_ORDER' ));
 		JToolbarHelper::apply('order.apply');
 		JToolbarHelper::save('order.save');

 		if(empty($this->item->id)){
 			JToolbarHelper::cancel('order.cancel');
 		}
 		else{
 			JToolbarHelper::cancel('order.cancel', 'JTOOLBAR_CLOSE');
 		}
 	}


 

 	function getPayStatusSelect($select){
 		PayStatus::init();
 		return AHtml::getFilterSelect('pay_status', 'Pay status', PayStatus::$map, $select, false, '', 'value', 'text');
 	}
 	function getOrderTypeSelect($select){
 		OrderType::init();
 		return AHtml::getFilterSelect('type', 'Order Type', OrderType::$map, $select, false, '', 'value', 'value');
 	}
 	function getOrderStatusSelect($select){
 		OrderStatus::init();
 		return AHtml::getFilterSelect('order_status', 'Order Status', OrderStatus::$map, $select, false, '', 'value', 'text');
 	}

 	function getCustomerSelectBox($select)
 	{
 		AImporter::model('customers');
 		$model = new BookProModelCustomers();
 		$state=$model->getState();
 		$state->set('list.start',0);
 		$state->set('list.limit', 0);
 		$fullList = $model->getItems(); //getData();
 		return AHtml::getFilterSelect('user_id', 'Select Customer', $fullList, $select, false, '', 'id', 'firstname');
 	}
 	function createTimeSelectBox($name,$selected){
 		$start = "00:00";
 		$end = "23:30";
 		$option=array();
 		$tStart = strtotime($start);
 		$tEnd = strtotime($end);
 		$tNow = $tStart;
 		while($tNow <= $tEnd){
 			$option[]=JHTML::_('select.option',date("H:i",$tNow),date("H:i",$tNow));
 			$tNow = strtotime('+15 minutes',$tNow);
 		}
 		return JHtml::_('select.genericlist',$option,$name,'style="float:none !important;"','value','text',$selected);
 	}

 }

 ?>