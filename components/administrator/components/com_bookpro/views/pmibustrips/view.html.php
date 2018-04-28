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

/*
$dat_today = date("Y-m-d H:i:s");

$expired_data=date( "Y-m-d H:i:s", strtotime($dat_today." -45 minutes" ));

$db = JFactory::getDbo();
$query = $db->getQuery ( true );
$query->select('id,order_status,total,seat,return_seat');
$query->from('#__bookpro_orders');
$query->where('trigger_time <"'.$expired_data.'"');
$db->setQuery($query);
$data=$db->loadAssocList();

foreach ($data as $data1)
{
	$seatset=$data1['seat'];
	if($seatset)
	{
		$seat=explode(",", $seatset);
	}
	$return_seatset=$data1['return_seat'];
	if($return_seatset)	
	{
		$return_seat=explode(",", $return_seatset);
	}
	$ii=0;	

	if( ($data1['order_status'] == "CONFIRMED") || ($data1['order_status'] == "PENDING") )
	{
		$price= $data1['total'];
	}
	else
	{
		$price=0;
	}

	$db = JFactory::getDbo();
	$query1 = $db->getQuery(true);
	$query1->update('#__bookpro_orders');
	$query1->set('total = '.$price.', trigger_time = "'.$dat_today.'"');
	$query1->where('id = '.$data1['id']);
	$db->setQuery($query1);
	$querry_result1 =  $db->loadObjectList();

	$db = JFactory::getDbo();
	$query2 = $db->getQuery ( true );
	$query2->select('id,route_id,return_route_id,passenger_status,passenger_status_return,trigger_time');
	$query2->from('#__bookpro_passenger');
	$query2->where('order_id='.$data1['id']);
	$db->setQuery($query2);
	$data2=$db->loadAssocList();

	foreach($data2 as $data3)

	{

		if($seatset)
		{
			$seat_put= $seat[$ii];
		}
		else
		{
			$seat_put="";
		}

		if($return_seatset)	
		{
			$return_seat_put= $return_seat[$ii];
		}
		else
		{
			$return_seat_put="";
		}

		if($data3['return_route_id'] == 0)
		{
			$return_status= "ABSENT";
		}
		else
		{
			$return_status= $data1['order_status'];
		}

		$db = JFactory::getDbo();
		$query3 = $db->getQuery(true);
		$query3->update('#__bookpro_passenger');
		$query3->set('seat = "'.$seat_put.'", return_seat = "'.$return_seat_put.'", passenger_status = "'.$data1['order_status'].'", passenger_status_return = "'.$return_status.'", trigger_time = "'.$data3['trigger_time'].'"');
		$query3->where('id = '.$data3['id']);
		$db->setQuery($query3);
		$querry_result =  $db->loadObjectList();

		$ii++;
	}


}
*/



/*
$dat_today = date("Y-m-d H:i:s");

$expired_data=date( "Y-m-d H:i:s", strtotime($dat_today." -45 minutes" ));

$db = JFactory::getDbo();
$query = $db->getQuery ( true );
$query->select('id,order_status,total,seat,return_seat');
$query->from('#__bookpro_orders');
$query->where('trigger_time <"'.$expired_data.'"');
$db->setQuery($query);
$data=$db->loadAssocList();

foreach ($data as $data1)
{
	$seatset=$data1['seat'];
	if($seatset)
	{
		$seat=explode(",", $seatset);
	}
	$return_seatset=$data1['return_seat'];
	if($return_seatset)	
	{
		$return_seat=explode(",", $return_seatset);
	}
	$ii=0;	

	$db = JFactory::getDbo();
	$query1 = $db->getQuery(true);
	$query1->update('#__bookpro_orders');
	$query1->set('trigger_time = "'.$dat_today.'"');
	$query1->where('id = '.$data1['id']);
	$db->setQuery($query1);
	$querry_result1 =  $db->loadObjectList();

	$db = JFactory::getDbo();
	$query2 = $db->getQuery ( true );
	$query2->select('id,route_id,return_route_id,passenger_status,passenger_status_return,trigger_time');
	$query2->from('#__bookpro_passenger');
	$query2->where('order_id='.$data1['id']);
	$db->setQuery($query2);
	$data2=$db->loadAssocList();

	foreach($data2 as $data3)

	{

		if($seatset)
		{
			$seat_put= $seat[$ii];
		}
		else
		{
			$seat_put="";
		}

		if($return_seatset)	
		{
			$return_seat_put= $return_seat[$ii];
		}
		else
		{
			$return_seat_put="";
		}

		$db = JFactory::getDbo();
		$query3 = $db->getQuery(true);
		$query3->update('#__bookpro_passenger');
		$query3->set('seat = "'.$seat_put.'", return_seat = "'.$return_seat_put.'", trigger_time = "'.$data3['trigger_time'].'"');
		$query3->where('id = '.$data3['id']);
		$db->setQuery($query3);
		$querry_result =  $db->loadObjectList();

		$ii++;
	}
}
*/



AImporter::helper('bookpro','bus','date','paystatus');
AImporter::model('agents');

class BookProViewPmiBusTrips extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;
	
	function display($tpl = null)
	{
		
		$this->state		= $this->get('State');
		if($this->state->get('filter.depart_date')){
		$this->items		= $this->get('Items');
		}else {
			$this->items=array();
		}
		
		$this->pagination	= $this->get('Pagination');
		$select=$this->state->get('filter.pay_status');
		//$this->pay_status= AHtml::getFilterSelect('filter_pay_status',JText::_('COM_BOOKPRO_ORDER_PAY_STATUS'), PayStatus::$map, $select, false, 'class="input"', 'value', 'text');
		$this->agentbox=$this->getAgentSelectBox($this->state->get('filter.agent_id'));
		
		parent::display($tpl);
		 
	}
	function getAgentSelectBox($select){
		$model = new BookProModelAgents();
		$fullList = $model->getItems();
		return AHtml::getFilterSelect('filter_agent_id', JText::_('COM_BOOKPRO_SELECT_AGENT'), $fullList, $select, false, 'class="input-medium"', 'id', 'company');
	
	}
	
	
}

jimport( 'joomla.html.toolbar.button.link' );

class JToolbarButtonLinkext extends JToolbarButtonLink
{
	protected  $_name = 'Linkext';

	public function fetchButton( $type='Linkext', $name = 'back', $text = '', $url = null )
	{
		
		$text   = JText::_($text);
		$class  = $this->fetchIconClass($name);
		$doTask = $this->_getCommand($url);
		
		?>
		
		<button onclick="window.open('<?php echo $doTask; ?>','_blank');" class="btn btn-small">
			<span class="<?php echo $class; ?>"></span>
				<?php echo $text; ?>
		</button>
		
		<?php 

		
	}
	public function fetchId($type = 'Link', $name = '')
	{
		return $this->_parent->getName() . '-' . $name;
	}
}

?>