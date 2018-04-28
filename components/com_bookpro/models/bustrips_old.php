<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') or die('Restricted access');

class BookProModelBustrips extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
					'l.id',
					'l.title',
			);
		}

		parent::__construct($config);
	}

	
	protected function populateState($ordering = null, $direction = null)
	{
		parent::populateState();
		$app = JFactory::getApplication();
			
		// Load the filter state.
		$depart_date = $this->getUserStateFromRequest($this->context . '.filter.depart_date', 'filter_depart_date');
		$this->setState('filter.depart_date', $depart_date);
			
		$from = $this->getUserStateFromRequest($this->context . '.filter.from', 'filter_from');
		$this->setState('filter.from', $from);
			
		$to = $this->getUserStateFromRequest($this->context . '.filter.to', 'filter_to', 0, 'int');
		$this->setState('filter.to', $to);
		
		$bus_id = $this->getUserStateFromRequest($this->context . '.filter.bus_id', 'filter_bus_id', 0, 'int');
		$this->setState('filter.bus_id', $bus_id);

		$agent_id = $this->getUserStateFromRequest($this->context . '.filter.agent_id', 'filter_agent_id', 0, 'int');
		$this->setState('filter.agent_id', $agent_id);
		
		$cutofftime = $this->getUserStateFromRequest($this->context . '.filter.cutofftime', 'filter_cutofftime');
		$this->setState('filter.cutofftime', $cutofftime);
		
				
		$value = $app->getUserStateFromRequest($this->context.'.ordercol', 'filter_order', $ordering);
		$this->setState('list.ordering', $value);
		$value = $app->getUserStateFromRequest($this->context.'.orderdirn', 'filter_order_Dir', $direction);
		$this->setState('list.direction', $value);
		parent::populateState('a.lft', 'asc');
			
	}
	

	function getListQuery()
	{

	    //die;
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$depart_date = $this->getState('filter.depart_date');
		if ($depart_date) {
			//$depart_date=JFactory::getDate($depart_date)->format('Y-m-d');
			$depart_date = JFactory::getDate($depart_date)->format(DateHelper::getConvertDateFormat('P'));
		}
		
		$subQuery = $db->getQuery(true);
		//
		$subQuery->select('rate.*');
		$subQuery->from('#__bookpro_roomrate AS rate');
		//$subQuery->where('DATE_FORMAT(rate.date,"'.DateHelper::getConvertDateFormat('M').'")='.$db->quote($depart_date));

//$subQuery->where(( (' STR_TO_DATE('.$db->quote($depart_date).', '.$db->quote('%d.%m.%Y %H:%i:%s').') BETWEEN rate.date AND rate.date_end  AND weekdays LIKE '.$db->quote('%'.JFactory::getDate($depart_date)->format ( 'N' ).'%'))));
$subQuery->where(( (' STR_TO_DATE('.$db->quote($depart_date).', '.$db->quote('%d.%m.%Y %H:%i:%s').') BETWEEN rate.date AND rate.date_end')));

		
		$query->select('bustrip.*,`agent`.`brandname` AS `brandname`,agent.company,`agent`.`image` AS `agent_logo`, `bus`.`id` AS `bus_id_`,`seattemplate`.`id` AS `seattemplate_id`,`seattemplate`.`block_layout` AS `block_layout`,  `dest1`.`title` as `fromName`, `dest2`.`title` as `toName`');
		$query->select('`upperseattemplate`.`block_layout` AS `upper_block_layout`');
		$query->select('`bus`.`seat` AS `bus_seat`, `bus`.`title` as `bus_name`, `bus`.`desc` as `bus_sum`,CONCAT(`dest1`.`title`,'.$db->quote('-').',`dest2`.`title`) AS title,`bustrip`.`id` AS b_id');
		//$query->select('DATE_FORMAT(`r`.`date`,"'.DateHelper::getConvertDateFormat('M').'") AS depart_date');

$query->select('DATE_FORMAT(`r`.`date`,"'.DateHelper::getConvertDateFormat('M').'") AS depart_date');


		$query->select('r.adult,`r`.`child`,r.discount,r.infant,r.adult_roundtrip,r.child_roundtrip,r.infant_roundtrip,r.weekdays');
		
		

		$query->from('#__bookpro_bustrip AS bustrip');
		$query->innerJoin('#__bookpro_dest AS `dest1` ON `bustrip`.`from` = `dest1`.`id`');
		$query->innerJoin('#__bookpro_dest AS `dest2` ON `bustrip`.`to` = `dest2`.`id`');
		$query->innerJoin('#__bookpro_bus AS `bus` ON `bus`.`id` = `bustrip`.`bus_id`');
		$query->innerJoin('#__bookpro_agent AS agent ON `agent`.`id` = `bustrip`.`agent_id`');
		$query->join('LEFT', '('.$subQuery->__toString().') AS r ON r.room_id = bustrip.id');
		$query->leftJoin('#__bookpro_bus_seattemplate AS `seattemplate` ON `seattemplate`.`id` = `bus`.`seattemplate_id`');
		$query->leftJoin('#__bookpro_bus_seattemplate AS `upperseattemplate` ON `upperseattemplate`.`id` = `bus`.`upperseattemplate_id`');
		

		$from = $this->getState('filter.from');

		if ($from){

if($from >= 100000)
{
	$from_if="";

	$or_value="";

	$from_check_spb = str_split($from);

	if($from_check_spb[1] == 1)
	{
		$from_if = $from_if.$or_value."bustrip.from=399";
		$or_value = " OR ";		
	}
	if($from_check_spb[2] == 1)
	{
		$from_if = $from_if.$or_value."bustrip.from=415";
		$or_value = " OR ";
	}
	if($from_check_spb[3] == 1)
	{
		$from_if = $from_if.$or_value."bustrip.from=416";
		$or_value = " OR ";
	}
	if($from_check_spb[4] == 1)
	{
		$from_if = $from_if.$or_value."bustrip.from=417";
		$or_value = " OR ";
	}
	if($from_check_spb[5] == 1)
	{
		$from_if = $from_if.$or_value."bustrip.from=418";
		$or_value = " OR ";
	}

	$query->where('('.$from_if.')');
}
else
{
	$query->where('bustrip.from='.$from);
}
			
			//$query->where('bustrip.from='.$from);
		}
		$to = $this->getState('filter.to');
		if ($to){

if($to >= 100000)
{
	$from_if="";

	$or_value="";

	$from_check_spb = str_split($to);

	if($from_check_spb[1] == 1)
	{
		$from_if = $from_if.$or_value."bustrip.to=399";
		$or_value = " OR ";	
	}
	if($from_check_spb[2] == 1)
	{
		$from_if = $from_if.$or_value."bustrip.to=415";
		$or_value = " OR ";	
	}
	if($from_check_spb[3] == 1)
	{
		$from_if = $from_if.$or_value."bustrip.to=416";
		$or_value = " OR ";	
	}
	if($from_check_spb[4] == 1)
	{
		$from_if = $from_if.$or_value."bustrip.to=417";
		$or_value = " OR ";	
	}
	if($from_check_spb[5] == 1)
	{
		$from_if = $from_if.$or_value."bustrip.to=418";
		$or_value = " OR ";	
	}

	$query->where('('.$from_if.')');

}
else
{
	$query->where('bustrip.to='.$to);
}
			
			//$query->where('bustrip.to='.$to);
		}
		$bus_id = $this->getState('filter.bus_id');
		if ($bus_id){
			
			$query->where('bustrip.bus_id='.$bus_id);
		}
		$agent_id = $this->getState('agent_id');
		if ($agent_id){
			
			$query->where('bus.agent_id='.$agent_id);
		}
		//
		$cutofftime = $this->getState('cutofftime');
		if($cutofftime){
			$query->where('DATE_FORMAT(DATE_ADD(now(), INTERVAL '.$cutofftime.' MINUTE),"%H:%i") < `bustrip`.`start`');
		}
		//
		$query->where('bustrip.state = 1');
		$query->having('`r`.`adult` > 0');
		$query->order('bustrip.start_time ASC');
		//echo $query->dump();
 
$sfile = '/home/c/chartfbt/skstest4/public_html/people.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent.(string)$query."\n";
file_put_contents($sfile, $scurrent);
     
		return $query;
	}
	function getItems(){
		$items = parent::getItems();

		$config=JBFactory::getConfig();
		
		AImporter::helper('bus');
		AImporter::model('busstops');

		foreach ($items as $item){

		    //var_dump ($item->route);
			$model = new BookproModelBusstops();
			$state = $model->getState();
			$state->set('filter.bustrip_id',$item->id);
			$state->set('list.limit',null);
			$item->stations =  $model->getItems();

//echo "123123123123";

			
			if($config->get('non_seat')){
				
				//$item->booked_seat_location = BusHelper::getBookedSeatNonGraphical ( $item->depart_date, $item->code);
$item->booked_seat_location = BusHelper::getBookedSeatNonGraphical ( $this->getState('filter.depart_date'), $item->code);
				//var_dump ($items);
			}else{
				//$this->getState('filter.depart_date')
//echo "123123123123-------".$this->getState('filter.depart_date').$item->depart_date;
				//$item->booked_seat_location = BusHelper::getBookedSeat ( $item->depart_date, $item->code);
//$item->booked_seat_location = BusHelper::getBookedSeat ( $this->getState('filter.depart_date'), $item->code);
$item->booked_seat_location =BusHelper::getBookedSeat2 ( $this->getState('filter.depart_date'), $item->code, $item->from, $item->to, $item->route);
//var_dump ($items);
			}
		}

//echo "<pre>";print_r($items);echo "<pre>";

		return $items;
	}
	
	
}